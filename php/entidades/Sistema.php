<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sistema
 *
 * @author Renan
 */
class Sistema {
  
    public static function getRelatorios($empresa){
        
        $rtc = $empresa->getRTC(new ConnectionFactory());
        
        $relatorios = array();
        
        if($rtc->numero >= 3){
            
            $relatorios[] = new RelatorioFinanceiro($empresa);
            $relatorios[] = new RelatorioMovimento($empresa);
        }
        
        return $relatorios;
        
    }
    
    public static function getProdutosDoDia($con,$dia,$num,$empresa){
        
        $dia = $dia - 1;
        
        while($dia<0){
            $dia += $num;
        }
        
        $dia = $dia%$num;
        
        $classes = array();
        $ps = $con->getConexao()->prepare("SELECT id,classificacao_saida FROM produto WHERE id_empresa=$empresa->id AND produto.disponivel > 0");
        $ps->execute();
        $ps->bind_result($id,$classe);
        while($ps->fetch()){
            if(!isset($classes[$classe])){
                $classes[$classe] = array();
            }
            $classes[$classe][] = $id;
        }
        $ps->close();
        
        $produtos = "(-1";
        
        
        foreach($classes as $key=>$classe){
            
            $fat = floor(count($classe)/$num);
            $rst = count($classe)%$num;
            
            for($i=$fat*$dia;$i<$fat*($dia+1);$i++){
                $produtos .= ",".$classe[$i];
            }
            
            if($dia<$rst){
                
                $produtos .= ",".$classe[$fat*$num+$dia];
                
            }
            
        }
        
        $produtos .= ")";
        
        
        return $empresa->getProdutos($con,0,10000000,"produto.id IN $produtos","");
        
    }

    public static function finalizarCompraParceiros($con, $pedido, $empresa) {

        $logistica = $pedido->empresa;

        if ($pedido->logistica !== null) {

            $logistica = $pedido->logistica;
        }

        $g = new Getter($logistica);
        $ge = new Getter($empresa);

        $transportadora = $g->getTransportadoraViaTransportadora($con, $pedido->transportadora);
        $pedido->transportadora = $transportadora;

        $pedido->merge($con);

        $produtos = array();

        foreach ($pedido->produtos as $key => $value) {

            $produtos[] = $value->produto;
        }

        $produtos = $ge->getProdutoViaProduto($con, $produtos);
        foreach ($produtos as $key => $value) {
            $produtos[$value->id_universal] = $value;
        }


        $entrada = new PedidoEntrada();
        $entrada->empresa = $empresa;
        $entrada->fornecedor = $ge->getFornecedorViaEmpresa($con, $pedido->empresa);
        $entrada->frete = $pedido->frete;
        $entrada->incluir_frete = $pedido->incluir_frete;
        $entrada->parcelas = $pedido->parcelas;
        $entrada->prazo = $pedido->prazo;
        $entrada->transportadora = $ge->getTransportadoraViaTransportadora($con, $pedido->transportadora);
        $entrada->usuario = $pedido->usuario;
        $entrada->status = Sistema::getStatusPedidoEntrada();
        $entrada->status = $entrada->status[0];
        $entrada->observacoes = "Pedido gerado referente a compra feita pelo RTC";
        $entrada->produtos = array();

        foreach ($pedido->produtos as $key => $value) {

            $pp = new ProdutoPedidoEntrada();
            $pp->pedido = $entrada;
            $pp->produto = $produtos[$value->produto->id_universal];
            $pp->valor = ($value->valor_base + $value->icms + $value->frete + $value->ipi);
            $pp->quantidade = $value->quantidade;

            $entrada->produtos[] = $pp;
        }


        $entrada->merge($con);

        $ret = $pedido->forma_pagamento->aoFinalizarPedido($pedido);

        return $ret;
    }

    public static function getPedidosResultantes($con, $carrinho, $empresa, $usuario) {

        $grupos = array();
        $campanhas = array();


        foreach ($carrinho as $key => $item) {

            $hash = "e" . $item->empresa->id;

            if ($item->logistica !== null) {

                $hash .= "l" . $item->logistica->id;
            }

            $campanha = null;

            foreach ($item->ofertas as $key => $value) {
                if ($value->validade == $item->validade->validade) {
                    $campanha = $value->campanha;
                    break;
                }
            }

            if ($campanha !== null) {
                $h = "c" . $campanha->prazo . "p" . $campanha->parcelas;

                if ($campanha->prazo < 0 || $campanha->parcelas < 0 || true) { //retirar esse true, para mudar a abordagem, apra dividir tambem pedidos entre campanhas de prazos diferentes
                    $hash .= "cp";
                } else {
                    $hash .= $h;
                    $campanhas[$hash] = $campanha;
                }
            } else {
                $hash .= "cp";
            }

            if (!isset($grupos[$hash])) {
                $grupos[$hash] = array();
            }

            $grupos[$hash][] = $item;
        }

        $pedidos = array();

        $formas = Sistema::getFormasPagamento();
        $status_inicial = Sistema::getStatusPedidoSaida();
        $status_inicial = $status_inicial[0];



        foreach ($grupos as $key => $value) {

            $base = $value[0];

            $emp = $base->empresa;


            $g = new Getter($emp);

            $cliente = $g->getClienteViaEmpresa($con, $empresa);

            $pedido = new Pedido();
            $pedido->empresa = $emp;
            $pedido->cliente = $cliente;

            if (isset($campanhas[$key])) {

                $campanha = $campanhas[$key];
            }

            foreach ($formas as $k2 => $v2) {
                if ($v2->habilitada($pedido)) {
                    $pedido->forma_pagamento = $v2;
                    break;
                }
            }

            if ($base->logistica !== null) {

                $pedido->logistica = $base->logistica;
            }

            $pedido->usuario = $usuario;
            $pedido->status = $status_inicial;
            $pedido->produtos = array();

            foreach ($value as $key2 => $produto) {

                if (!$produto->sistema_lotes) {

                    $p = new ProdutoPedidoSaida();
                    $p->produto = $produto;
                    $p->validade_minima = $produto->validade->validade;
                    $p->quantidade = $produto->quantidade_comprada;
                    $p->valor_base = $produto->validade->valor;

                    if ($p->quantidade > $produto->validade->limite && $produto->validade->limite > 0) {
                        $p->quantidade = $produto->validade->limite;
                    }

                    $pedido->produtos[] = $p;
                    $p->pedido = $pedido;
                } else {

                    $p = new ProdutoPedidoSaida();
                    $p->produto = $produto;
                    $p->validade_minima = $produto->validade->validade;
                    $p->quantidade = $produto->quantidade_comprada;
                    $p->valor_base = $produto->validade->valor;
                    $p->pedido = $pedido;
                    if ($p->quantidade > $produto->validade->limite && $produto->validade->limite > 0) {
                        $p->quantidade = $produto->validade->limite;
                    }

                    $pds = array($p);

                    if ($produto->validade->alem) {
                        $lotes = $produto->getLotes($con, 'lote.quantidade_real>0 AND (UNIX_TIMESTAMP(lote.validade)*1000) >= ' . $produto->validade->validade, 'lote.validade ASC');
                        for ($i = 0; $i < count($pds); $i++) {
                            $pp = $pds[$i];
                            $pp->aux = $pp->quantidade;
                            $primeira_maior = 0;
                            foreach ($lotes as $keyl => $lote) {
                                if ($lote->validade === $pp->validade_minima) {
                                    $pp->aux -= $lote->quantidade_real;
                                } else if ($lote->validade > $pp->validade_minima && $primeira_maior === 0) {
                                    $primeira_maior = $lote->validade;
                                }
                            }
                            if ($pp->aux > 0 && $primeira_maior > 0) {
                                $np = Utilidades::copyId0($pp);
                                $np->quantidade = $pp->aux;
                                $np->validade_minima = $primeira_maior;
                                $np->pedido = $pedido;
                                $pds[] = $np;
                            }
                            $pp->quantidade -= $pp->aux;
                        }
                    }

                    foreach ($pds as $kp => $produto_pedido) {
                        $pedido->produtos[] = $produto_pedido;
                    }
                }
            }

            $pedido->atualizarCustos();
            $pedido->formas_pagamento = array();

            foreach ($formas as $keyf => $f) {
                if ($f->habilitada($pedido)) {
                    $pedido->formas_pagamento[] = $f;
                }
            }

            $pedido->forma_pagamento = $pedido->formas_pagamento[0];


            $pedidos[] = $pedido;
        }

        return $pedidos;
    }

    public static function getCompraParceiros($con) {

        $cm = new CacheManager();

        $g = $cm->getCache('compra_parceiros');

        if ($g !== null) {

            return $g;
        }

        $empresas = array();

        $ps = $con->getConexao()->prepare("SELECT "
                . "empresa.id,"
                . "empresa.is_logistica,"
                . "empresa.nome,"
                . "empresa.inscricao_estadual,"
                . "empresa.consigna,"
                . "empresa.aceitou_contrato,"
                . "empresa.juros_mensal,"
                . "empresa.cnpj,"
                . "endereco.numero,"
                . "endereco.id,"
                . "endereco.rua,"
                . "endereco.bairro,"
                . "endereco.cep,"
                . "cidade.id,"
                . "cidade.nome,"
                . "estado.id,"
                . "estado.sigla,"
                . "email.id,"
                . "email.endereco,"
                . "email.senha,"
                . "telefone.id,"
                . "telefone.numero "
                . "FROM empresa "
                . "INNER JOIN endereco ON endereco.id_entidade=empresa.id AND endereco.tipo_entidade='EMP' "
                . "INNER JOIN email ON email.id_entidade=empresa.id AND email.tipo_entidade='EMP' "
                . "INNER JOIN telefone ON telefone.id_entidade=empresa.id AND telefone.tipo_entidade='EMP' "
                . "INNER JOIN cidade ON endereco.id_cidade=cidade.id "
                . "INNER JOIN estado ON cidade.id_estado = estado.id "
                . "WHERE empresa.vende_para_fora = true");
        $ps->execute();
        $ps->bind_result($id_empresa, $is_logistica, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        while ($ps->fetch()) {

            $empresa = new Empresa();

            if ($is_logistica == 1) {

                $empresa = new Logistica();
            }

            $empresa->id = $id_empresa;
            $empresa->cnpj = new CNPJ($cnpj);
            $empresa->inscricao_estadual = $inscricao_empresa;
            $empresa->nome = $nome_empresa;
            $empresa->aceitou_contrato = $aceitou_contrato;
            $empresa->juros_mensal = $juros_mensal;
            $empresa->consigna = $consigna;

            $endereco = new Endereco();
            $endereco->id = $id_endereco;
            $endereco->rua = $rua;
            $endereco->bairro = $bairro;
            $endereco->cep = new CEP($cep);
            $endereco->numero = $numero_endereco;

            $cidade = new Cidade();
            $cidade->id = $id_cidade;
            $cidade->nome = $nome_cidade;

            $estado = new Estado();
            $estado->id = $id_estado;
            $estado->sigla = $nome_estado;

            $cidade->estado = $estado;

            $endereco->cidade = $cidade;

            $empresa->endereco = $endereco;

            $email = new Email($endereco_email);
            $email->id = $id_email;
            $email->senha = $senha_email;

            $empresa->email = $email;

            $telefone = new Telefone($numero_telefone);
            $telefone->id = $id_telefone;

            $empresa->telefone = $telefone;

            $empresas[] = $empresa;
        }

        $ps->close();

        $produtos = array();

        foreach ($empresas as $key => $value) {

            $prods = $value->getProdutos($con, 0, 500000, 'categoria_produto.loja=true', '');

            foreach ($prods as $key2 => $value2) {

                $produtos[] = $value2;
            }
        }


        $cm->setCache('compra_parceiros', $produtos);

        return $produtos;
    }

    public static function getHtml($nom, $p = null) {

        global $obj;
        $obj = $p;

        $servico = realpath('../../html_email');
        $servico .= "/$nom.php";

        ob_start();
        include($servico);
        $html = ob_get_clean();

        return utf8_decode($html);
    }

    public static function finalizarNotas($con, $notas) {



        for ($i = 0; $i < count($notas); $i++) {

            $value = $notas[$i];

            if ($value->emitida || $value->cancelada)
                continue;


            $value->merge($con);

            if ($value->saida) {

                $value->emitir($con);
            } else {

                $value->manifestar($con);
            }

            if (isset($value->inverter)) {

                $emp = new Empresa($value->inverter);
                $nota = $value->inverteOperacao($con, $emp);
                $nota->calcularImpostosAutomaticamente();
                $nota->emitida = false;
                $nota->cancelada = false;
                $notas[] = $nota;
            }
        }
    }

    public static function getPedidoEntradaSemelhante($con, $empresa, $xml) {

        if (!isset($xml->nfeProc->NFe)) {

            throw new Exception('XML em formato incorreto');
        }

        $nfe = $xml->nfeProc->NFe;

        $inf = $nfe->infNFe;

        if ($inf->ide->tpNF != "1") {

            throw new Exception('A Nota nao e de saida');
        }

        $cnpj_empresa = new CNPJ($inf->dest->CNPJ);
        $id_empresa = $empresa->id;

        if ($empresa->cnpj->valor !== $cnpj_empresa->valor) {

            if ($empresa->is_logistica) {

                $ps = $con->getConexao()->prepare("SELECT empresa.id FROM empresa INNER JOIN produto ON produto.id_empresa=empresa.id WHERE produto.id_logistica=$empresa->id AND empresa.cnpj='" . $cnpj_empresa->valor . "'");
                $ps->execute();
                $ps->bind_result($ide);
                if ($ps->fetch()) {
                    $id_empresa = $ide;
                } else {
                    $ps->close();
                    throw new Exception('A Nota nao e dessa empresa, e nem de uma afiliada');
                }
                $ps->close();
            } else {

                throw new Exception('A Nota nao e dessa empresa');
            }
        }

        $escolhido = -1;

        $possiveis = array();

        $cnpj_transportadora = new CNPJ($inf->transp->transporta->CNPJ);

        $ps = $con->getConexao()->prepare("SELECT pedido_entrada.id FROM pedido_entrada INNER JOIN transportadora ON pedido_entrada.id_transportadora=transportadora.id WHERE transportadora.cnpj='" . $cnpj_transportadora->valor . "' AND pedido_entrada.id_empresa=$id_empresa AND id_status<=2");
        $ps->execute();
        $ps->bind_result($idt);
        while ($ps->fetch()) {
            $possiveis[] = $idt;
        }
        $ps->close();

        if (count($possiveis) == 0) {

            throw new Exception('Nao foi encontrado nenhum pedido de compra equivalente, com o CNPJ dessa transportadora');
        } else if (count($possiveis) == 1) {

            $escolhido = $possiveis[0];
        } else {

            $in = "(-1";
            foreach ($possiveis as $key => $value) {
                $in .= ",$value";
            }
            $in .= ")";

            $cnpj_fornecedor = new CNPJ($inf->emit->CNPJ);

            $possiveis = array();
            $ps = $con->getConexao()->prepare("SELECT pedido_entrada.id FROM pedido_entrada INNER JOIN fornecedor ON fornecedor.id=pedido_entrada.id_fornecedor WHERE pedido_entrada.id IN $in AND fornecedor.cnpj='" . $cnpj_fornecedor->valor . "'");
            $ps->execute();
            $ps->bind_result($idp);
            while ($ps->fetch()) {
                $possiveis[] = $idp;
            }
            $ps->close();

            if (count($possiveis) == 0) {

                throw new Exception('Nao foi encontrado nenhum pedido de compra equivalente, com o CNPJ desse fornecedor');
            } else if (count($possiveis) == 1) {

                $escolhido = $possiveis[0];
            } else {

                $in = "(-1";
                foreach ($possiveis as $key => $value) {
                    $in .= ",$value";
                }
                $in .= ")";

                $produtos = array();

                if (!is_array($inf->det)) {
                    $inf->det = array($inf->det);
                }

                $total = 0;
                foreach ($inf->det as $key => $value) {

                    $value = $value->prod;

                    if (!isset($produtos[$value->cProd])) {

                        $p = new stdClass();
                        $p->id = $value->cProd;
                        $p->nome = $value->xProd;
                        $p->valor = doubleval($value->vUnCom . "");
                        $p->quantidade = 0;
                        $p->total = 0;

                        $produtos[$p->id] = $p;
                    }

                    $produtos[$value->cProd]->quantidade += doubleval($value->qCom . "");
                    $produtos[$value->cProd]->total += doubleval($value->qCom . "") * $produtos[$value->cProd]->valor;
                    $total += doubleval($value->qCom . "") * $produtos[$value->cProd]->valor;
                }

                $ps = $con->getConexao()->prepare("SELECT k.id FROM (SELECT produto_pedido_entrada.id_pedido as 'id',SUM(produto_pedido_entrada.valor*produto_pedido_entrada.quantidade) as 'soma' FROM produto_pedido_entrada WHERE produto_pedido_entrada.id_pedido IN $in GROUP BY produto_pedido_entrada.id_pedido) k WHERE (k.soma-0.5)<$total AND (k.soma+0.5)>$total");
                $ps->execute();

                $ps->bind_result($idp);
                if ($ps->fetch()) {
                    $escolhido = $idp;
                    $ps->close();
                } else {
                    $ps->close();
                    throw new Exception('Nao foi possivel selecionar o pedido de compra devido ao valor nao estar batendo ');
                }
            }
        }

        $e = new Empresa($id_empresa, new ConnectionFactory());

        $pedido = $e->getPedidosEntrada($con, 0, 1, "pedido_entrada.id=$escolhido");
        $pedido = $pedido[0];

        $nota = new Nota();
        $nota->numero = $inf->ide->nNF;
        $nota->transportadora = $pedido->transportadora;
        $nota->protocolo = $nfe->protNFe->infProt->nProt;
        $nota->saida = false;
        $nota->chave = explode('e', $inf->Id);
        $nota->chave = $nota->chave[1];

        $ps = $con->getConexao()->prepare("SELECT id FROM nota WHERE chave='$nota->chave' AND nota.excluida = false");
        $ps->execute();
        $ps->bind_result($t);
        if ($ps->fetch()) {
            $ps->close();
            throw new Exception('Ja existem operacoes realizadas referentes a essa NFe');
        }
        $ps->close();

        $nota->fornecedor = $pedido->fornecedor;
        $nota->emitida = false;
        $nota->forma_pagamento = Sistema::getFormasPagamento();
        $nota->forma_pagamento = $nota->forma_pagamento[0];
        $nota->interferir_estoque = false;
        $nota->empresa = $e;
        $nota->frete_destinatario_remetente = $pedido->incluir_frete;

        $vencimentos = array();
        $cobr = $inf->cobr->dup;
        if (!is_array($cobr)) {
            $cobr = array($cobr);
        }

        foreach ($cobr as $key => $value) {
            $v = new Vencimento();
            $v->nota = $nota;
            $v->valor = doubleval($value->vDup . "");
            $v->data = strtotime($value->dVenc) * 1000;
            $vencimentos[] = $v;
        }

        $nota->vencimentos = $vencimentos;

        $pp = $pedido->getProdutos($con);
        $pedido->produtos = $pp;
        $produtos = array();

        $logisticas = array();
        $logs = array();

        $dets = array();
        $dets_n = array();

        if (!is_array($inf->det)) {
            $inf->det = array($inf->det);
        }

        foreach ($inf->det as $key => $value) {

            $value = $value->prod;

            if (!isset($produtos[$value->cProd])) {

                $p = new stdClass();
                $p->id = $value->cProd;
                $p->nome = $value->xProd;
                $p->cfop = $value->CFOP;
                $p->valor = doubleval($value->vUnCom . "");
                $p->quantidade = 0;
                $p->total = 0;

                $dets[$p->id] = $p;
                $dets_n[] = $p;
            }

            $dets[$value->cProd]->quantidade += doubleval($value->qCom . "");
            $dets[$value->cProd]->total += doubleval($value->qCom . "") * $produtos[$value->cProd]->valor;
        }

        foreach ($pp as $key => $value) {

            $pn = new ProdutoNota();
            $pn->cfop = (isset($dets_n[$key]) ? $dets_n[$key]->cfop : "5152"); //verificar esse ponto aqui
            $pn->valor_unitario = doubleval($value->valor . "");
            $pn->quantidade = doubleval($value->quantidade . "");
            $pn->nota = $nota;
            $pn->valor_total = $pn->valor_unitario * $pn->quantidade;
            $pn->produto = $value->produto;

            $produtos[] = $pn;

            if ($value->produto->logistica !== null) {
                if (!isset($logisticas[$value->produto->logistica->id])) {
                    $nl = Utilidades::copyId0($nota);
                    $nl->emitida = false;
                    $nl->chave = "";
                    $nl->protocolo = "";
                    $nl->saida = true;
                    $nl->empresa = $e;
                    $nl->fornecedor = null;
                    $gt = new Getter($nl->empresa);
                    $nl->cliente = $gt->getClienteViaEmpresa($con, $value->produto->logistica);
                    $nl->observacao = "Nota referente a remessa da empresa " . $id_empresa;
                    $nl->produtos = array();
                    $logisticas[$value->produto->logistica->id] = $nl;
                    $logs[$value->produto->logistica->id] = $value->produto->logistica;
                }
                $n = $logisticas[$value->produto->logistica->id];
                $p = Utilidades::copyId0($pn);
                $p->nota = $logisticas[$value->produto->logistica->id];
                $n->produtos[] = $p;
            }
        }

        $rl = array();

        foreach ($logisticas as $key => $value) {
            $value->igualaVencimento();
            $value->calcularImpostosAutomaticamente();
            $value->inverter = $logs[$key]->id;
            $rl[] = $value;
            $inv = $value->inverteOperacao($con, $logs[$key]);
            $inv->calcularImpostosAutomaticamente();
            $inv->cancelada = true;
            $rl[] = $inv;
        }

        $nota->produtos = $produtos;
        $nota->calcularImpostosAutomaticamente();
        $pedido->nota = $nota;
        $pedido->notas_logisticas = $rl;


        return array($pedido);
    }

    public static function getMesesValidadeCurta() {

        return 4;
    }

    public static function mergeArquivo($nome, $conteudo) {

        $handle = fopen('../uploads/' . $nome, 'a');
        fwrite($handle, Utilidades::base64decode($conteudo));
        fflush($handle);
        fclose($handle);
    }

    private static function getMicroServicoJava($nome, $parametros = null) {

        $servico = realpath('../micro_servicos_java');
        $servico .= "/$nome.jar";
        $comando = "java -jar \"$servico\"";
              
        if ($parametros !== null) {
            $comando .= " \"".$parametros."\"";
        } else {
            $comando .= " 200";
        }

        exec($comando, $output);
        return $output[0];
    }

    public static function getEtiquetas($etiquetas) {

        $caminho = realpath("../uploads");
        $arquivo = "etiqueta_" . round(microtime(true) * 1000) . ".pdf";
        $caminho_completo = $caminho . "/$arquivo";
        
        
        
        $request = new stdClass();
        $request->arquivo = $caminho_completo;
        $request->etiquetas = $etiquetas;

        $final_request = Utilidades::toJson($request);
        $final_request = addslashes($final_request);
        
        $resp = Utilidades::fromJson(self::getMicroServicoJava('GeradorEtiqueta', $final_request));
      
        if (!$resp->sucesso) {

            throw new Exception('falha');
            
        } else {

            return $arquivo;
        }
    }

    public static function getHistorico($con) {

        $historicos = array();

        $ps = $con->getConexao()->prepare("SELECT id,nome FROM historico WHERE excluido = false");
        $ps->execute();
        $ps->bind_result($id, $nome);

        while ($ps->fetch()) {

            $historico = new Historico();
            $historico->id = $id;
            $historico->nome = $nome;

            $historicos[] = $historico;
        }

        $ps->close();

        return $historicos;
    }

    public static function getOperacoes($con) {

        $operacoes = array();

        $ps = $con->getConexao()->prepare("SELECT id,nome,debito FROM operacao WHERE excluida=false");
        $ps->execute();
        $ps->bind_result($id, $nome, $debito);

        while ($ps->fetch()) {

            $operacao = new Operacao();
            $operacao->id = $id;
            $operacao->nome = $nome;
            $operacao->debito = $debito;

            $operacoes[] = $operacao;
        }

        $ps->close();

        return $operacoes;
    }

    public static function getStatusCanceladoPedidoEntrada() {

        $st = Sistema::getStatusPedidoEntrada();
        return $st[3];
    }

    public static function relacionarFilial($empresa1, $empresa2) {

        $con = new ConnectionFactory();

        $ps = $con->getConexao()->prepare("INSERT INTO filial(id_empresa1,id_empresa2) VALUES($empresa1->id,$empresa2->id)");
        $ps->execute();
        $ps->close();
    }

    public static function getPragas($con) {

        $pragas = array();

        $ps = $con->getConexao()->prepare("SELECT id,nome FROM praga WHERE excluida = false ORDER BY nome");
        $ps->execute();
        $ps->bind_result($id, $nome);

        while ($ps->fetch()) {

            $praga = new Praga();
            $praga->id = $id;
            $praga->nome = $nome;

            $pragas[] = $praga;
        }

        $ps->close();

        return $pragas;
    }

    public static function getCategoriaCliente($con) {

        $cats = array();

        $ps = $con->getConexao()->prepare("SELECT id,nome FROM categoria_cliente WHERE excluida = false ORDER BY nome");
        $ps->execute();
        $ps->bind_result($id, $nome);

        while ($ps->fetch()) {

            $cat = new CategoriaCliente();
            $cat->id = $id;
            $cat->nome = $nome;

            $cats[] = $cat;
        }

        $ps->close();

        return $cats;
    }

    public static function getCulturas($con) {

        $culturas = array();

        $ps = $con->getConexao()->prepare("SELECT id,nome FROM cultura WHERE excluida = false ORDER BY nome");
        $ps->execute();
        $ps->bind_result($id, $nome);

        while ($ps->fetch()) {

            $cultura = new Cultura();
            $cultura->id = $id;
            $cultura->nome = $nome;

            $culturas[] = $cultura;
        }

        $ps->close();

        return $culturas;
    }

    public static function getStatusPedidoEntrada() {

        $status = array();

        $status[] = new StatusPedidoEntrada(1, "Confirmacao de pedido", false, false, true);
        $status[] = new StatusPedidoEntrada(2, "Em transito", false, true, false);
        $status[] = new StatusPedidoEntrada(3, "Finalizado", true, false, false);
        $status[] = new StatusPedidoEntrada(4, "Cancelado", false, false, true);

        return $status;
    }

    public static function getFormasPagamento() {

        $formas = array();

        $formas[] = new BoletoEspecialAgroFauna();
        $formas[] = new DepositoEmConta();

        return $formas;
    }

    public static function getIcmsEstado($estado) {

        $doze = array("MG", "RS", "SC", "RJ", "PB");

        if (in_array($estado->sigla, $doze)) {

            return 12;
        }

        return 7;
    }

    public static function getCategoriaDocumentos() {

        $cats = array();

        $cats[] = new CategoriaDocumento(1, "NFE");
        $cats[] = new CategoriaDocumento(2, "Certificado Comerciante de Agrotoxico");
        $cats[] = new CategoriaDocumento(3, "Documentos Empresariais");
        $cats[] = new CategoriaDocumento(4, "Balanco");

        return $cats;
    }

    public static function getEmailSistema() {

        $email = new Email("renan.miranda@agrofauna.com.br");
        $email->senha = "5hynespt";

        return $email;
    }

    public static function getRTCS() {
        RTC::$RTCS = array();
        return array(new RTC(1, array(
                new Permissao(5, "cliente"),
                new Permissao(17, "fonecedor"),
                new Permissao(4, "transportadora"),
                new Permissao(3, "cotacao"),
                new Permissao(13, "pedido_saida"),
                new Permissao(25, "pedido_entrada"),
                new Permissao(27, "logo"),
                new Permissao(2, "produto"))
            ), new RTC(2, array(
                new Permissao(23, "lista_preco"),
                new Permissao(9, "campanha"))
            ), new RTC(3, array(
                new Permissao(8, "tabela"),
                new Permissao(10, "grupo_cidades"))
            ), new RTC(4, "ALL")
        );
    }

    public static function getPermissoes() {

        $perms = array();

        $perms[] = new Permissao(1, "pedido_entrada");
        $perms[] = new Permissao(2, "produto");
        $perms[] = new Permissao(3, "cotacao");
        $perms[] = new Permissao(4, "transportadora");
        $perms[] = new Permissao(5, "cliente");
        $perms[] = new Permissao(6, "nota");
        $perms[] = new Permissao(7, "lote");
        $perms[] = new Permissao(8, "tabela");
        $perms[] = new Permissao(9, "campanha");
        $perms[] = new Permissao(10, "grupo_cidades");
        $perms[] = new Permissao(11, "banco");
        $perms[] = new Permissao(12, "movimento");
        $perms[] = new Permissao(13, "pedido_saida");
        $perms[] = new Permissao(14, "categoria_produto");
        $perms[] = new Permissao(15, "categoria_cliente");
        $perms[] = new Permissao(16, "categoria_documento");
        $perms[] = new Permissao(17, "fonecedor");
        $perms[] = new Permissao(18, "cfg");
        $perms[] = new Permissao(19, "configuracao_empresa");
        $perms[] = new Permissao(20, "cultura");
        $perms[] = new Permissao(21, "praga");
        $perms[] = new Permissao(23, "lista_preco");
        $perms[] = new Permissao(24, "configuracao_empresa");
        $perms[] = new Permissao(25, "separacao");
        $perms[] = new Permissao(26, "pedido_entrada");
        $perms[] = new Permissao(27, "logo");

        return $perms;
    }

    public static function getStatusExcluidoPedidoSaida() {

        return new StatusPedidoSaida(30, "Excluido", false, false, false, true);
    }

    public static function getStatusPedidoSaida() {

        $status = array();

        $status[] = new StatusPedidoSaida(1, "Confirmacao de pedido", false, true, Email::$COMPRAS, Email::$VENDAS, true, true, false, false);
        $status[] = new StatusPedidoSaida(2, "Limite de credito", false, true, Email::$COMPRAS, Email::$FINANCEIRO, true, true, false, false);
        $status[] = new StatusPedidoSaida(3, "Autorizacao de pedido", false, Email::$COMPRAS, Email::$DIRETORIA, false, true, true, false, false);
        $status[] = new StatusPedidoSaida(4, "Confirmacao de pagamento", false, Email::$FINANCEIRO, Email::$FINANCEIRO, false, true, true, false, false);
        $status[] = new StatusPedidoSaida(5, "Separacao", false, Email::$COMPRAS, Email::$LOGISTICA, false, false, false, false, false);
        $status[] = new StatusPedidoSaida(6, "Faturamento", true, Email::$COMPRAS, Email::$LOGISTICA, false, false, false, false, true);
        $status[] = new StatusPedidoSaida(7, "Coleta", true, Email::$COMPRAS, Email::$LOGISTICA, true, false, false, false, true);
        $status[] = new StatusPedidoSaida(8, "Rastreio", true, Email::$COMPRAS, Email::$LOGISTICA, false, false, false, false, true);
        $status[] = new StatusPedidoSaida(9, "Finalizado", true, Email::$COMPRAS, Email::$LOGISTICA, false, false, false, true, true);
        $status[] = new StatusPedidoSaida(10, "Cancelado", false, Email::$COMPRAS, Email::$VENDAS, true, false, false, true, false);
        $status[] = new StatusPedidoSaida(11, "Orcamento", false, Email::$COMPRAS, Email::$VENDAS, true, true, true, false, false);
        $status[] = new StatusPedidoSaida(30, "Excluido", false, Email::$COMPRAS, Email::$VENDAS, true, false, false, true, false);


        return $status;
    }

    public static function getStatusCotacaoEntrada() {

        $sts = array();

        $sts[] = new StatusCotacaoEntrada(1, "Aguardando resposta", true);
        $sts[] = new StatusCotacaoEntrada(2, "Respondida", false);
        $sts[] = new StatusCotacaoEntrada(3, "Pedido fechado", false);
        $sts[] = new StatusCotacaoEntrada(4, "Cancelada", true);

        return $sts;
    }

    public static function getPermissoesIniciais() {

        $perms = array();

        $perms[] = new Permissao(1, "pedido_entrada", true, true, true, true);
        $perms[] = new Permissao(2, "produto", true, true, true, true);
        $perms[] = new Permissao(3, "cotacao", true, true, true, true);
        $perms[] = new Permissao(4, "transportadora", true, true, true, true);
        $perms[] = new Permissao(5, "cliente", true, true, true, true);
        $perms[] = new Permissao(7, "lote", true, true, true, true);
        $perms[] = new Permissao(13, "pedido_saida", true, true, true, true);
        $perms[] = new Permissao(17, "fonecedor", true, true, true, true);
        $perms[] = new Permissao(18, "cfg", true, true, true, true);
        $perms[] = new Permissao(19, "configuracao_empresa", true, true, true, true);

        return $perms;
    }

    public static function getCategoriaProduto($con) {

        $cats = array();

        $ps = $con->getConexao()->prepare("SELECT id, nome,base_calculo,ipi,icms_normal,icms FROM categoria_produto WHERE excluida=false");
        $ps->execute();
        $ps->bind_result($id, $nome, $base_calculo, $ipi, $icms_normal, $icms);

        while ($ps->fetch()) {

            $cat = new CategoriaProduto();
            $cat->id = $id;
            $cat->nome = $nome;
            $cat->base_calculo = $base_calculo;
            $cat->ipi = $ipi;
            $cat->icms_norma = $icms_normal;
            $cat->icms = $icms;

            $cats[] = $cat;
        }

        $ps->close();

        return $cats;
    }

    public static function getEstados($con) {

        $estados = array();

        $ps = $con->getConexao()->prepare("SELECT id, sigla FROM estado WHERE excluido=false");
        $ps->execute();
        $ps->bind_result($id, $sigla);

        while ($ps->fetch()) {

            $e = new Estado();
            $e->id = $id;
            $e->sigla = $sigla;

            $estados[] = $e;
        }

        $ps->close();

        return $estados;
    }

    public static function getUsuario($filtro) {

        $con = new ConnectionFactory();

        $ses = new SessionManager();

        $sql = "SELECT "
                . "usuario.id,"
                . "usuario.nome,"
                . "usuario.login,"
                . "usuario.senha,"
                . "usuario.cpf,"
                . "endereco_usuario.id,"
                . "endereco_usuario.rua,"
                . "endereco_usuario.numero,"
                . "endereco_usuario.bairro,"
                . "endereco_usuario.cep,"
                . "cidade_usuario.id,"
                . "cidade_usuario.nome,"
                . "estado_usuario.id,"
                . "estado_usuario.sigla,"
                . "email_usu.id,"
                . "email_usu.endereco,"
                . "email_usu.senha,"
                . "empresa.id,"
                . "empresa.nome,"
                . "empresa.inscricao_estadual,"
                . "empresa.consigna,"
                . "empresa.aceitou_contrato,"
                . "empresa.juros_mensal,"
                . "empresa.cnpj,"
                . "endereco.numero,"
                . "endereco.id,"
                . "endereco.rua,"
                . "endereco.bairro,"
                . "endereco.cep,"
                . "cidade.id,"
                . "cidade.nome,"
                . "estado.id,"
                . "estado.sigla,"
                . "email.id,"
                . "email.endereco,"
                . "email.senha,"
                . "telefone.id,"
                . "telefone.numero "
                . "FROM usuario "
                . "INNER JOIN endereco endereco_usuario ON endereco_usuario.id_entidade=usuario.id AND endereco_usuario.tipo_entidade='USU' "
                . "INNER JOIN cidade cidade_usuario ON endereco_usuario.id_cidade=cidade_usuario.id "
                . "INNER JOIN estado estado_usuario ON estado_usuario.id=cidade_usuario.id_estado "
                . "INNER JOIN email email_usu ON email_usu.id_entidade=usuario.id AND email_usu.tipo_entidade='USU' "
                . "INNER JOIN empresa ON usuario.id_empresa=empresa.id "
                . "INNER JOIN endereco ON endereco.id_entidade=empresa.id AND endereco.tipo_entidade='EMP' "
                . "INNER JOIN email ON email.id_entidade=empresa.id AND email.tipo_entidade='EMP' "
                . "INNER JOIN telefone ON telefone.id_entidade=empresa.id AND telefone.tipo_entidade='EMP' "
                . "INNER JOIN cidade ON endereco.id_cidade=cidade.id "
                . "INNER JOIN estado ON cidade.id_estado = estado.id "
                . "WHERE " . $filtro;


        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id_usu, $nome_usu, $login_usu, $senha_usu, $cpf_usu, $end_usu_id, $end_usu_rua, $end_usu_numero, $end_usu_bairro, $end_usu_cep, $cid_usu_id, $cid_usu_nome, $est_usu_id, $est_usu_nome, $email_usu_id, $email_usu_end, $email_usu_senha, $id_empresa, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        $usuarios = array();

        while ($ps->fetch()) {

            $usuario = new Usuario();

            $usuario->cpf = new CPF($cpf_usu);
            $usuario->email = new Email($email_usu_end);
            $usuario->email->id = $email_usu_id;
            $usuario->email->senha = $email_usu_senha;
            $usuario->id = $id_usu;
            $usuario->login = $login_usu;
            $usuario->senha = $senha_usu;
            $usuario->nome = $nome_usu;

            $end = new Endereco();
            $end->id = $end_usu_id;
            $end->bairro = $end_usu_bairro;
            $end->cep = new CEP($end_usu_cep);
            $end->numero = $end_usu_numero;
            $end->rua = $end_usu_numero;

            $end->cidade = new Cidade();
            $end->cidade->id = $cid_usu_id;
            $end->cidade->nome = $cid_usu_nome;

            $end->cidade->estado = new Estado();
            $end->cidade->estado->id = $est_usu_id;
            $end->cidade->estado->sigla = $est_usu_nome;

            $usuario->endereco = $end;


            $empresa = new Empresa();
            $empresa->id = $id_empresa;
            $empresa->cnpj = new CNPJ($cnpj);
            $empresa->inscricao_estadual = $inscricao_empresa;
            $empresa->nome = $nome_empresa;
            $empresa->aceitou_contrato = $aceitou_contrato;
            $empresa->juros_mensal = $juros_mensal;
            $empresa->consigna = $consigna;

            $endereco = new Endereco();
            $endereco->id = $id_endereco;
            $endereco->rua = $rua;
            $endereco->bairro = $bairro;
            $endereco->cep = new CEP($cep);
            $endereco->numero = $numero_endereco;

            $cidade = new Cidade();
            $cidade->id = $id_cidade;
            $cidade->nome = $nome_cidade;

            $estado = new Estado();
            $estado->id = $id_estado;
            $estado->sigla = $nome_estado;

            $cidade->estado = $estado;

            $endereco->cidade = $cidade;

            $empresa->endereco = $endereco;

            $email = new Email($endereco_email);
            $email->id = $id_email;
            $email->senha = $senha_email;

            $empresa->email = $email;

            $telefone = new Telefone($numero_telefone);
            $telefone->id = $id_telefone;

            $empresa->telefone = $telefone;

            $usuario->empresa = $empresa;

            $usuarios[$usuario->id] = $usuario;
        }

        $ps->close();

        $in_usu = "-1";
        foreach ($usuarios as $id => $usuario) {
            $in_usu .= ",";
            $in_usu .= $id;
        }

        $ps = $con->getConexao()->prepare("SELECT telefone.id_entidade, telefone.tipo_entidade, telefone.id, telefone.numero FROM telefone WHERE (telefone.id_entidade IN ($in_usu) AND telefone.tipo_entidade='USU') AND telefone.excluido = false");
        $ps->execute();
        $ps->bind_result($id_entidade, $tipo_entidade, $id, $numero);
        while ($ps->fetch()) {

            $v = $usuarios;
            $telefone = new Telefone();
            $telefone->id = $id;
            $telefone->numero = $numero;

            $v[$id_entidade]->telefones[] = $telefone;
        }
        $ps->close();

        $permissoes = Sistema::getPermissoes();

        $ps = $con->getConexao()->prepare("SELECT id_usuario, id_permissao,incluir,deletar,alterar,consultar FROM usuario_permissao WHERE id_usuario IN ($in_usu)");
        $ps->execute();
        $ps->bind_result($id_usuario, $id_permissao, $incluir, $deletar, $alterar, $consultar);

        while ($ps->fetch()) {

            $p = null;

            foreach ($permissoes as $key => $perm) {
                if ($perm->id == $id_permissao) {
                    $p = $perm;
                    break;
                }
            }

            if ($p == null) {

                continue;
            }

            $p->alt = $alterar;
            $p->in = $incluir;
            $p->del = $deletar;
            $p->cons = $consultar;

            $usuarios[$id_usuario]->permissoes[] = $p;
        }

        $ps->close();

        $real = array();

        foreach ($usuarios as $key => $value) {

            $real[] = $value;
        }

        if (count($real) > 0) {

            $u = $real[0];

            $ses->set("usuario", $u);
            $ses->set("empresa", $u->empresa);

            return $u;
        }

        return null;
    }

    public static function getLogisticaById($con, $id) {

        $logs = Sistema::getLogisticas($con, true);

        if (isset($logs[$id])) {
            return $logs[$id];
        }

        return null;
    }

    public static function getLogisticas($con, $id_array = false) {

        $ses = new SessionManager();

        if ($ses->get("logisticas") != null) {

            if ($id_array) {

                return $ses->get("logisticas_id");
            } else {

                return $ses->get("logisticas");
            }
        }

        $ps = $con->getConexao()->prepare("SELECT "
                . "empresa.id,"
                . "empresa.is_logistica,"
                . "empresa.nome,"
                . "empresa.inscricao_estadual,"
                . "empresa.consigna,"
                . "empresa.aceitou_contrato,"
                . "empresa.juros_mensal,"
                . "empresa.cnpj,"
                . "endereco.numero,"
                . "endereco.id,"
                . "endereco.rua,"
                . "endereco.bairro,"
                . "endereco.cep,"
                . "cidade.id,"
                . "cidade.nome,"
                . "estado.id,"
                . "estado.sigla,"
                . "email.id,"
                . "email.endereco,"
                . "email.senha,"
                . "telefone.id,"
                . "telefone.numero "
                . "FROM empresa "
                . "INNER JOIN endereco ON endereco.id_entidade=empresa.id AND endereco.tipo_entidade='EMP' "
                . "INNER JOIN email ON email.id_entidade=empresa.id AND email.tipo_entidade='EMP' "
                . "INNER JOIN telefone ON telefone.id_entidade=empresa.id AND telefone.tipo_entidade='EMP' "
                . "INNER JOIN cidade ON endereco.id_cidade=cidade.id "
                . "INNER JOIN estado ON cidade.id_estado = estado.id "
                . "WHERE empresa.is_logistica=true");
        $ps->execute();

        $empresas = array();
        $empresas_id = array();
        $ps->bind_result($id_empresa, $is_logistica, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        while ($ps->fetch()) {

            $empresa = new Empresa();

            if ($is_logistica == 1) {

                $empresa = new Logistica();
            }

            $empresa->id = $id_empresa;
            $empresa->cnpj = new CNPJ($cnpj);
            $empresa->inscricao_estadual = $inscricao_empresa;
            $empresa->nome = $nome_empresa;
            $empresa->aceitou_contrato = $aceitou_contrato;
            $empresa->juros_mensal = $juros_mensal;
            $empresa->consigna = $consigna;

            $endereco = new Endereco();
            $endereco->id = $id_endereco;
            $endereco->rua = $rua;
            $endereco->bairro = $bairro;
            $endereco->cep = new CEP($cep);
            $endereco->numero = $numero_endereco;

            $cidade = new Cidade();
            $cidade->id = $id_cidade;
            $cidade->nome = $nome_cidade;

            $estado = new Estado();
            $estado->id = $id_estado;
            $estado->sigla = $nome_estado;

            $cidade->estado = $estado;

            $endereco->cidade = $cidade;

            $empresa->endereco = $endereco;

            $email = new Email($endereco_email);
            $email->id = $id_email;
            $email->senha = $senha_email;

            $empresa->email = $email;

            $telefone = new Telefone($numero_telefone);
            $telefone->id = $id_telefone;

            $empresa->telefone = $telefone;


            $empresas[] = $empresa;

            $empresas_id[$id_empresa] = $empresa;
        }

        $ps->close();

        $ses->set("logisticas_id", $empresas_id);
        $ses->set("logisticas", $empresas);

        if ($id_array) {

            return $empresas_id;
        } else {

            return $empresas;
        }
    }

    public static function logar($login, $senha) {

        $con = new ConnectionFactory();

        $ses = new SessionManager();

        $sql = "SELECT "
                . "usuario.id,"
                . "usuario.nome,"
                . "usuario.login,"
                . "usuario.senha,"
                . "usuario.cpf,"
                . "endereco_usuario.id,"
                . "endereco_usuario.rua,"
                . "endereco_usuario.numero,"
                . "endereco_usuario.bairro,"
                . "endereco_usuario.cep,"
                . "cidade_usuario.id,"
                . "cidade_usuario.nome,"
                . "estado_usuario.id,"
                . "estado_usuario.sigla,"
                . "email_usu.id,"
                . "email_usu.endereco,"
                . "email_usu.senha,"
                . "empresa.id,"
                . "empresa.is_logistica,"
                . "empresa.nome,"
                . "empresa.inscricao_estadual,"
                . "empresa.consigna,"
                . "empresa.aceitou_contrato,"
                . "empresa.juros_mensal,"
                . "empresa.cnpj,"
                . "endereco.numero,"
                . "endereco.id,"
                . "endereco.rua,"
                . "endereco.bairro,"
                . "endereco.cep,"
                . "cidade.id,"
                . "cidade.nome,"
                . "estado.id,"
                . "estado.sigla,"
                . "email.id,"
                . "email.endereco,"
                . "email.senha,"
                . "telefone.id,"
                . "telefone.numero "
                . "FROM usuario "
                . "INNER JOIN endereco endereco_usuario ON endereco_usuario.id_entidade=usuario.id AND endereco_usuario.tipo_entidade='USU' "
                . "INNER JOIN cidade cidade_usuario ON endereco_usuario.id_cidade=cidade_usuario.id "
                . "INNER JOIN estado estado_usuario ON estado_usuario.id=cidade_usuario.id_estado "
                . "INNER JOIN email email_usu ON email_usu.id_entidade=usuario.id AND email_usu.tipo_entidade='USU' "
                . "INNER JOIN empresa ON usuario.id_empresa=empresa.id "
                . "INNER JOIN endereco ON endereco.id_entidade=empresa.id AND endereco.tipo_entidade='EMP' "
                . "INNER JOIN email ON email.id_entidade=empresa.id AND email.tipo_entidade='EMP' "
                . "INNER JOIN telefone ON telefone.id_entidade=empresa.id AND telefone.tipo_entidade='EMP' "
                . "INNER JOIN cidade ON endereco.id_cidade=cidade.id "
                . "INNER JOIN estado ON cidade.id_estado = estado.id "
                . "WHERE usuario.login = '" . addslashes($login) . "' AND usuario.senha='" . addslashes($senha) . "' ";


        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id_usu, $nome_usu, $login_usu, $senha_usu, $cpf_usu, $end_usu_id, $end_usu_rua, $end_usu_numero, $end_usu_bairro, $end_usu_cep, $cid_usu_id, $cid_usu_nome, $est_usu_id, $est_usu_nome, $email_usu_id, $email_usu_end, $email_usu_senha, $id_empresa, $is_logistica, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        $usuarios = array();

        while ($ps->fetch()) {

            $usuario = new Usuario();

            $usuario->cpf = new CPF($cpf_usu);
            $usuario->email = new Email($email_usu_end);
            $usuario->email->id = $email_usu_id;
            $usuario->email->senha = $email_usu_senha;
            $usuario->id = $id_usu;
            $usuario->login = $login_usu;
            $usuario->senha = $senha_usu;
            $usuario->nome = $nome_usu;

            $end = new Endereco();
            $end->id = $end_usu_id;
            $end->bairro = $end_usu_bairro;
            $end->cep = new CEP($end_usu_cep);
            $end->numero = $end_usu_numero;
            $end->rua = $end_usu_numero;

            $end->cidade = new Cidade();
            $end->cidade->id = $cid_usu_id;
            $end->cidade->nome = $cid_usu_nome;

            $end->cidade->estado = new Estado();
            $end->cidade->estado->id = $est_usu_id;
            $end->cidade->estado->sigla = $est_usu_nome;

            $usuario->endereco = $end;


            $empresa = new Empresa();

            if ($is_logistica == 1) {

                $empresa = new Logistica();
            }

            $empresa->id = $id_empresa;
            $empresa->cnpj = new CNPJ($cnpj);
            $empresa->inscricao_estadual = $inscricao_empresa;
            $empresa->nome = $nome_empresa;
            $empresa->aceitou_contrato = $aceitou_contrato;
            $empresa->juros_mensal = $juros_mensal;
            $empresa->consigna = $consigna;

            $endereco = new Endereco();
            $endereco->id = $id_endereco;
            $endereco->rua = $rua;
            $endereco->bairro = $bairro;
            $endereco->cep = new CEP($cep);
            $endereco->numero = $numero_endereco;

            $cidade = new Cidade();
            $cidade->id = $id_cidade;
            $cidade->nome = $nome_cidade;

            $estado = new Estado();
            $estado->id = $id_estado;
            $estado->sigla = $nome_estado;

            $cidade->estado = $estado;

            $endereco->cidade = $cidade;

            $empresa->endereco = $endereco;

            $email = new Email($endereco_email);
            $email->id = $id_email;
            $email->senha = $senha_email;

            $empresa->email = $email;

            $telefone = new Telefone($numero_telefone);
            $telefone->id = $id_telefone;

            $empresa->telefone = $telefone;

            $usuario->empresa = $empresa;

            $usuarios[$usuario->id] = $usuario;
        }

        $ps->close();

        $in_usu = "-1";
        foreach ($usuarios as $id => $usuario) {
            $in_usu .= ",";
            $in_usu .= $id;
        }

        $ps = $con->getConexao()->prepare("SELECT telefone.id_entidade, telefone.tipo_entidade, telefone.id, telefone.numero FROM telefone WHERE (telefone.id_entidade IN ($in_usu) AND telefone.tipo_entidade='USU') AND telefone.excluido = false");
        $ps->execute();
        $ps->bind_result($id_entidade, $tipo_entidade, $id, $numero);
        while ($ps->fetch()) {

            $v = $usuarios;
            $telefone = new Telefone();
            $telefone->id = $id;
            $telefone->numero = $numero;

            $v[$id_entidade]->telefones[] = $telefone;
        }
        $ps->close();

        $permissoes = Sistema::getPermissoes();

        $ps = $con->getConexao()->prepare("SELECT id_usuario, id_permissao,incluir,deletar,alterar,consultar FROM usuario_permissao WHERE id_usuario IN ($in_usu)");
        $ps->execute();
        $ps->bind_result($id_usuario, $id_permissao, $incluir, $deletar, $alterar, $consultar);

        while ($ps->fetch()) {

            $p = null;

            foreach ($permissoes as $key => $perm) {
                if ($perm->id == $id_permissao) {
                    $p = $perm;
                    break;
                }
            }

            if ($p == null) {

                continue;
            }

            $p->alt = $alterar;
            $p->in = $incluir;
            $p->del = $deletar;
            $p->cons = $consultar;

            $usuarios[$id_usuario]->permissoes[] = $p;
        }

        $ps->close();

        $real = array();

        foreach ($usuarios as $key => $value) {

            $real[] = $value;
        }

        if (count($real) > 0) {

            $u = $real[0];

            $ses->set("usuario", $u);
            $ses->set("empresa", $u->empresa);

            return $u;
        }

        return null;
    }

    public static function getCidades($con) {

        $cidades = array();

        $ps = $con->getConexao()->prepare("SELECT estado.id, estado.sigla, cidade.id, cidade.nome FROM cidade INNER JOIN estado ON cidade.id_estado=estado.id WHERE cidade.excluida=false");
        $ps->execute();
        $ps->bind_result($id_estado, $sigla_estado, $id_cidade, $nome_cidade);

        while ($ps->fetch()) {

            $e = new Estado();
            $e->id = $id_estado;
            $e->sigla = $sigla_estado;

            $c = new Cidade();
            $c->id = $id_cidade;
            $c->nome = $nome_cidade;
            $c->estado = $e;

            $cidades[] = $c;
        }

        $ps->close();

        return $cidades;
    }

}
