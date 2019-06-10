<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegraTabela
 * ge
 * @author Renan
 */
class Pedido {

    public $id;
    public $cliente;
    public $transportadora;
    public $frete;
    public $observacoes;
    public $frete_incluso;
    public $empresa;
    public $data;
    public $excluido;
    public $usuario;
    public $id_nota;
    public $prazo;
    public $parcelas;
    public $status;
    public $produtos;
    public $forma_pagamento;
    public $logistica;
    public $fretes_intermediarios;
    public $etapa_frete;
    public $revisar;

    function __construct() {

        $this->id = 0;
        $this->cliente = null;
        $this->transportadora = null;
        $this->frete = 0;
        $this->observacoes = "";
        $this->frete_incluso = true;
        $this->empresa = null;
        $this->data = round(microtime(true) * 1000);
        $this->excluido = false;
        $this->usuario = null;
        $this->id_nota = 0;
        $this->prazo = 0;
        $this->parcelas = 1;
        $this->status = null;
        $this->produtos = null;
        $this->forma_pagamento = null;
        $this->logistica = null;
        $this->fretes_intermediarios = array();
        $this->etapa_frete = 0;
        $this->revisar = false;
    }

    public function getProdutos($con) {

        $campanhas = array();
        $ofertas = array();

        $ps = $con->getConexao()->prepare("SELECT "
                . "campanha.id,"
                . "campanha.nome,"
                . "UNIX_TIMESTAMP(campanha.inicio)*1000,"
                . "UNIX_TIMESTAMP(campanha.fim)*1000,"
                . "campanha.prazo,"
                . "campanha.parcelas,"
                . "campanha.cliente_expression,"
                . "produto_campanha.id,"
                . "produto_campanha.id_produto,"
                . "UNIX_TIMESTAMP(produto_campanha.validade)*1000,"
                . "produto_campanha.limite,"
                . "produto_campanha.valor, "
                . "empresa.id,"
                . "empresa.tipo_empresa,"
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
                . "FROM campanha "
                . "INNER JOIN produto_campanha ON campanha.id = produto_campanha.id_campanha "
                . "INNER JOIN empresa ON campanha.id_empresa=empresa.id "
                . "INNER JOIN endereco ON endereco.id_entidade=empresa.id AND endereco.tipo_entidade='EMP' "
                . "INNER JOIN email ON email.id_entidade=empresa.id AND email.tipo_entidade='EMP' "
                . "INNER JOIN telefone ON telefone.id_entidade=empresa.id AND telefone.tipo_entidade='EMP' "
                . "INNER JOIN cidade ON endereco.id_cidade=cidade.id "
                . "INNER JOIN estado ON cidade.id_estado = estado.id "
                . " WHERE campanha.inicio<=CURRENT_TIMESTAMP AND campanha.fim>=CURRENT_TIMESTAMP AND campanha.excluida=false");

        $ps->execute();
        $ps->bind_result($id, $camp_nome, $inicio, $fim, $prazo, $parcelas, $cliente, $id_produto_campanha, $id_produto, $validade, $limite, $valor, $id_empresa, $tipo_empresa, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        while ($ps->fetch()) {

            if (!isset($campanhas[$id])) {

                $campanhas[$id] = new Campanha();
                $campanhas[$id]->id = $id;
                $campanhas[$id]->nome = $camp_nome;
                $campanhas[$id]->inicio = $inicio;
                $campanhas[$id]->fim = $fim;
                $campanhas[$id]->prazo = $prazo;
                $campanhas[$id]->parcelas = $parcelas;
                $campanhas[$id]->cliente_expression = $cliente;

                $empresa = Sistema::getEmpresa($tipo_empresa);

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

                $campanhas[$id]->empresa = $empresa;

                $campanhas[$id] = $campanhas[$id]->getReduzida();
            }

            $campanha = $campanhas[$id];

            $p = new ProdutoCampanha();
            $p->id = $id_produto_campanha;
            $p->validade = $validade;
            $p->limite = $limite;
            $p->valor = $valor;
            $p->campanha = $campanha;

            if (!isset($ofertas[$id_produto])) {

                $ofertas[$id_produto] = array();
            }

            $ofertas[$id_produto][] = $p;
        }

        $ps->close();

        $ps = $con->getConexao()->prepare("SELECT produto_pedido_saida.id,"
                . "produto_pedido_saida.quantidade,"
                . "UNIX_TIMESTAMP(produto_pedido_saida.validade_minima)*1000,"
                . "produto_pedido_saida.valor_base,"
                . "produto_pedido_saida.juros,"
                . "produto_pedido_saida.icms,"
                . "produto_pedido_saida.base_calculo,"
                . "produto_pedido_saida.frete,"
                . "produto_pedido_saida.influencia_estoque,"
                . "produto_pedido_saida.influencia_reserva,"
                . "produto_pedido_saida.ipi,"
                . "produto.id,"
                . "produto.codigo,"
                . "produto.id_logistica,"
                . "produto.classe_risco,"
                . "produto.onu,"
                . "produto.descricao_onu,"
                . "produto.fabricante,"
                . "produto.imagem,"
                . "produto.id_universal,"
                . "produto.liquido,"
                . "produto.quantidade_unidade,"
                . "produto.habilitado,"
                . "produto.valor_base,"
                . "produto.custo,"
                . "produto.peso_bruto,"
                . "produto.peso_liquido,"
                . "produto.estoque,"
                . "produto.disponivel,"
                . "produto.transito,"
                . "produto.grade,"
                . "produto.unidade,"
                . "produto.ncm,"
                . "produto.nome,"
                . "produto.lucro_consignado,"
                . "produto.ativo,"
                . "produto.concentracao,"
                . "produto.sistema_lotes,"
                . "produto.nota_usuario,"
                . "produto.id_categoria,"
                . "empresa.id,"
                . "empresa.tipo_empresa,"
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
                . "telefone.numero"
                . " FROM produto_pedido_saida "
                . "INNER JOIN produto ON produto_pedido_saida.id_produto=produto.id "
                . "INNER JOIN empresa ON produto.id_empresa=empresa.id "
                . "INNER JOIN endereco ON endereco.id_entidade=empresa.id AND endereco.tipo_entidade='EMP' "
                . "INNER JOIN email ON email.id_entidade=empresa.id AND email.tipo_entidade='EMP' "
                . "INNER JOIN telefone ON telefone.id_entidade=empresa.id AND telefone.tipo_entidade='EMP' "
                . "INNER JOIN cidade ON endereco.id_cidade=cidade.id "
                . "INNER JOIN estado ON cidade.id_estado = estado.id "
                . " WHERE produto_pedido_saida.id_pedido=$this->id");

        $ps->execute();
        $ps->bind_result($id, $quantidade, $validade, $valor_base, $juros, $icms, $base_calculo, $frete, $ie, $ir, $ipi, $id_pro, $cod_pro, $id_log, $classe_risco, $onu, $descricao_onu, $fabricante, $imagem, $id_uni, $liq, $qtd_un, $hab, $vb, $cus, $pb, $pl, $est, $disp, $tr, $gr, $uni, $ncm, $nome, $lucro, $ativo, $conc, $sistema_lote, $nota_usuario, $cat_id, $id_empresa, $tipo_empresa, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        $retorno = array();


        $ids = "-1";
        while ($ps->fetch()) {

            $p = new Produto();

            $p->onu = $onu;
            $p->descricao_onu = $descricao_onu;
            $p->logistica = $id_log;
            $p->id = $id_pro;
            $p->codigo = $cod_pro;
            $p->nome = $nome;
            $p->classe_risco = $classe_risco;
            $p->fabricante = $fabricante;
            $p->imagem = $imagem;
            $p->id_universal = $id_uni;
            $p->liquido = $liq;
            $p->quantidade_unidade = $qtd_un;
            $p->habilitado = $hab;
            $p->valor_base = $vb;
            $p->custo = $cus;
            $p->peso_bruto = $pb;
            $p->peso_liquido = $pl;
            $p->estoque = $est;
            $p->disponivel = $disp;
            $p->ativo = $ativo;
            $p->concentracao = $conc;
            $p->transito = $tr;
            $p->sistema_lotes = $sistema_lote == 1;
            $p->nota_usuario = $nota_usuario;
            $p->grade = new Grade($gr);
            $p->unidade = $uni;
            $p->ncm = $ncm;
            $p->lucro_consignado = $lucro;
            $p->empresa = $this->empresa;
            $p->ofertas = (!isset($ofertas[$p->codigo]) ? array() : $ofertas[$p->codigo]);

            foreach ($p->ofertas as $key => $oferta) {

                $oferta->produto = $p->getReduzido();
            }

            $p->categoria = Sistema::getCategoriaProduto(null, $cat_id);

            $empresa = Sistema::getEmpresa($tipo_empresa);

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


            $p->empresa = $empresa;

            $pp = new ProdutoPedidoSaida();
            $pp->id = $id;
            $pp->quantidade = $quantidade;
            $pp->validade_minima = $validade;
            $pp->valor_base = $valor_base;
            $pp->produto = $p;
            $pp->juros = $juros;
            $pp->icms = $icms;
            $pp->pedido = $this;
            $pp->base_calculo = $base_calculo;
            $pp->frete = $frete;
            $pp->influencia_estoque = $ie;
            $pp->influencia_reserva = $ir;
            $pp->ipi = $ipi;


            $retorno[$pp->id] = $pp;

            $ids .= "," . $pp->id;
        }
        $ps->close();

        foreach ($retorno as $key => $value) {

            $value->produto->logistica = Sistema::getLogisticaById($con, $value->produto->logistica);
        }

        $ps = $con->getConexao()->prepare("SELECT id_lote,quantidade,retirada,id_produto_pedido FROM retirada WHERE id_produto_pedido IN ($ids)");
        $ps->execute();
        $ps->bind_result($id_lote, $qtd, $ret, $idp);
        while ($ps->fetch()) {

            $r = explode(",", $ret);
            $rr = array($id_lote, $qtd);

            foreach ($r as $key => $value) {

                $rr[] = intval($value);
            }

            $retorno[$idp]->retiradas[] = $rr;
        }

        $real_ret = array();

        foreach ($retorno as $key => $value) {

            $real_ret[] = $value;
        }

        return $real_ret;
    }

    public function atualizarCustos() {

        foreach ($this->produtos as $key => $value) {

            $value->atualizarCustos();
        }
    }

    public function getTotal() {

        $total = 0;

        foreach ($this->produtos as $key => $value) {

            $total += ($value->valor_base + $value->icms + $value->juros + $value->frete + $value->ipi) * $value->quantidade;
        }

        return $total;
    }

    public function gerarNotaPadrao() {

        $this->parcelas = max($this->parcelas, 1);

        $nota = new Nota();
        $nota->saida = true;
        $nota->empresa = $this->empresa;
        $nota->cliente = $this->cliente;
        $nota->emitida = false;
        $nota->cancelada = false;
        $nota->forma_pagamento = $this->forma_pagamento;
        $nota->interferir_estoque = false;

        $nota->observacao = new OBS_NFE($this->empresa, $this);
        $nota->observacao = $nota->observacao->getObs();

        $nota->frete_destinatario_remetente = $this->frete_incluso;
        $nota->transportadora = $this->transportadora;

        $total = $this->getTotal();

        $vencimentos = array();

        $dias = 0;
        for ($i = 0; $i < $this->parcelas; $i++) {

            $valor = (($total - ($total % $this->parcelas)) / $this->parcelas);
            $data = (($this->prazo - ($this->prazo % $this->parcelas)) / $this->parcelas);

            if ($i == 0) {

                $valor += ($total % $this->parcelas);
                $data += ($this->prazo % $this->parcelas);
            }

            $dias += $data;

            $vencimento = new Vencimento();
            $vencimento->data = $this->data + ($dias * 24 * 60 * 60 * 1000);
            $vencimento->valor = $valor;
            $vencimento->nota = $nota;

            $vencimentos[] = $vencimento;
        }
        $nota->vencimentos = $vencimentos;

        $produtos_nota = array();

        foreach ($this->produtos as $key => $value) {

            $pn = new ProdutoNota();
            $pn->base_calculo = $value->base_calculo;
            $pn->cfop = CFOP::$VENDA_DENTRO_ESTADO; // verificar esse ponto depois
            if ($this->cliente->endereco->cidade->estado->sigla !== $this->empresa->endereco->cidade->estado->sigla) {
                $pn->cfop = CFOP::$VENDA_FORA_ESTADO;
            }
            if ($this->cliente->suframado) {
                $pn->cfop = CFOP::$ISENTO;
            }
            $pn->icms = $value->icms;
            $pn->base_calculo = $value->base_calculo;
            $pn->ipi = $value->ipi;
            $pn->produto = $value->produto;
            $pn->quantidade = $value->quantidade;
            $pn->valor_unitario = ($value->valor_base + $value->icms + $value->ipi + $value->juros + $value->frete);
            $pn->informacao_adicional = "Cl Risco: " . $value->produto->classe_risco . ". ONU " . $value->produto->onu . " " . $value->produto->descricao_onu;

            if ($value->produto->sistema_lotes) {

                $con = new ConnectionFactory();

                $pn->informacao_adicional .= "LOTES(S): D. Validade: " . date("d/m/Y", $value->validade_minima / 1000) . " ";
                foreach ($value->retiradas as $key2 => $retirada) {

                    $codigo_lote = $retirada[0];

                    $ps = $con->getConexao()->prepare("SELECT codigo_fabricante FROM lote WHERE id=$codigo_lote");
                    $ps->execute();
                    $ps->bind_result($cod);
                    if ($ps->fetch()) {
                        if ($cod !== "") {
                            $codigo_lote = $cod;
                        }
                    }
                    $ps->close();

                    $pn->informacao_adicional .= "$codigo_lote (Qtd: " . $retirada[1] . ")";
                }
            }

            $pn->nota = $nota;
            $pn->valor_total = $pn->valor_unitario * $pn->quantidade;

            $produtos_nota[] = $pn;
        }

        $nota->produtos = $produtos_nota;

        return $nota;
    }

    public function gerarCobranca() {

        $retorno = $this->forma_pagamento->aoFinalizarPedido($this);
        $log = Logger::gerarLog($this, "Cobranca via " . $this->forma_pagamento->nome . ", gerada $retorno");
        try {
            $this->empresa->email->enviarEmail($this->empresa->email->filtro(Email::$FINANCEIRO), "Cobranca de pagamento", $log->toHtml());
            $this->empresa->email->enviarEmail($this->cliente->email->filtro(Email::$FINANCEIRO), "Cobranca de pagamento", $log->toHtml());
        } catch (Exception $ex) {
            
        }
        return $retorno;
    }

    public function merge($con, $recursao = false) {

        if ($this->revisar && $this->id > 0) {

            $to = isset($this->observacao_status);

            if ($to) {
                $to = strlen($this->observacao_status) >= 20;
            }

            if (!$to) {
                throw new Exception("Nao e possivel fazer uma alteracao direta, descreva o que foi alterado no pedido e motivo com precisao.");
            }

            $encode = Utilidades::toJson($this);
            $encode = Utilidades::base64encodeSPEC($encode);

            $ps = $con->getConexao()->prepare("INSERT INTO dados(dado) VALUES('$encode')");
            $ps->execute();
            $dado = $ps->insert_id;
            $ps->close();

            $empresa = $this->empresa->getAdm($con);
            if ($empresa === null) {
                $empresa = $this->empresa;
            }

            $t = new Tarefa();
            $t->tipo_tarefa = Sistema::TT_REVISAO_PEDIDO($empresa->id);
            $t->titulo = "Revisao de pedido";
            $t->descricao = "Observacoes: " . $this->observacao_status;
            $t->tipo_entidade_relacionada = 'DAD';
            $t->id_entidade_relacionada = $dado;

            try {

                Sistema::novaTarefaEmpresa($con, $t, $empresa);
                return;
            } catch (Exception $ex) {

                throw new Exception("Nao existe ninguem habilitado para verificar se sua modificacao sera permitida");
            }
        }

        if ($this->status->id === Sistema::STATUS_CANCELADO()->id) {

            $ps = $con->getConexao()->prepare("UPDATE tarefa SET inicio_minimo=inicio_minimo,excluida=true "
                    . "WHERE tipo_entidade_relacionada='PED_" . $this->empresa->id . "' AND id_entidade_relacionada=$this->id AND porcentagem_conclusao<100");
            $ps->execute();
            $ps->close();
        }

        $prods = $this->getProdutos($con);

        if ($this->produtos === null) {
            $this->produtos = $prods;
        }

        foreach ($this->produtos as $key => $value) {
            if ($this->logistica === null) {
                if ($value->produto->logistica !== null) {
                    throw new Exception('Esse produto nao esta armazenado na logistica do pedido');
                }
            } else {
                if ($value->produto->logistica === null) {
                    throw new Exception('Esse produto nao esta armazenado na logistica do pedido');
                } else {
                    if ($value->produto->logistica->id !== $this->logistica->id) {
                        throw new Exception('Esse produto nao esta armazenado na logistica do pedido');
                    }
                }
            }
        }


        $status_anterior = $this->status;

        $ps = $con->getConexao()->prepare("SELECT id_status FROM pedido WHERE id=$this->id");
        $ps->execute();
        $ps->bind_result($id_status);
        if ($ps->fetch()) {
            $status = Sistema::getStatusPedidoSaida();
            foreach ($status as $key => $value) {
                if ($value->id === $id_status) {
                    $status_anterior = $value;
                }
            }
        }
        $ps->close();

        $inicial = $this->id === 0;

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO pedido(id_cliente,id_transportadora,frete,observacoes,frete_inclusao,id_empresa,data,excluido,id_usuario,id_nota,prazo,parcelas,id_status,id_forma_pagamento,id_logistica,etapa_frete) VALUES(" . $this->cliente->id . "," . $this->transportadora->id . ",$this->frete,'$this->observacoes'," . ($this->frete_incluso ? "true" : "false") . "," . $this->empresa->id . ",FROM_UNIXTIME($this->data/1000),false," . $this->usuario->id . ",$this->id_nota,$this->prazo,$this->parcelas," . $this->status->id . "," . $this->forma_pagamento->id . "," . ($this->logistica != null ? $this->logistica->id : 0) . ",$this->etapa_frete)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();

            foreach ($this->fretes_intermediarios as $key => $value) {
                $value->pedido = $this;
                $value->merge($con);
            }

            $atividade = new Atividade($this->usuario);
            $atividade->descricao = "Pedido fechado " . $this->getTotal();
            $atividade->pontos = $this->getTotal();
            $atividade->tipo = Atividade::$PEDIDO;
            $atividade->merge($con);

            //INICIANDO LIMITE CREDITO
            $empresa = $this->empresa->getAdm($con);
            if ($empresa === null) {
                $empresa = $this->empresa;
            }
            $passar_direto = false;
            $analisar_credito = false;
            $divida = 0;
            if ($this->prazo < 3) {
                $passar_direto = true;
            } else {
                $limite = $this->cliente->getLimiteCredito();
                if ($limite < 0) {
                    $analisar_credito = true;
                } else {
                    $divida = $this->cliente->getDividas($con);
                    if (($divida + $this->getTotal()) > $limite) {
                        $ps = $con->getConexao()->prepare("UPDATE pedido SET data=data, excluido=true WHERE id=$this->id");
                        $ps->execute();
                        $ps->close();
                        throw new Exception("O pedido nao pode ser realizado devido limite de credito excedido");
                    } else {
                        $passar_direto = true;
                    }
                }
            }
            if ($analisar_credito) {
                $t = new Tarefa();
                $t->tipo_tarefa = Sistema::TT_ANALISE_CREDITO($empresa->id);
                $t->titulo = "Analise de credito do pedido $this->id, cliente " . $this->cliente->razao_social;
                $t->descricao = "Razao Social: " . $this->cliente->razao_social . " <br>"
                        . "CNPJ: " . $this->cliente->cnpj->valor . " <br>"
                        . "Estado: " . $this->cliente->endereco->cidade->estado->sigla . " <br>"
                        . "Cidade: " . $this->cliente->endereco->cidade->nome . " <br>"
                        . "Email: " . str_replace(array(";"), array("<br>"), $this->cliente->email->endereco) . " <br>"
                        . "Divida: R$ " . round($divida, 2) . " <br>"
                        . "Telefones: ";
                foreach ($this->cliente->telefones as $key => $value) {
                    $t->descricao .= "$value->numero<br>";
                }

                $t->descricao .= "<a style='font-size:20px;text-decoration:underline;color:SteelBlue' href='analise_credito.php?cliente=" . $this->cliente->id . "&pedido=$this->id&empresa=" . $this->empresa->id . "'>ANALISAR CREDITO</a>";

                $t->tipo_entidade_relacionada = "PED_" . $this->empresa->id;
                $t->id_entidade_relacionada = $this->id;
                Sistema::novaTarefaEmpresa($con, $t, $empresa);

                $this->status = Sistema::STATUS_LIMITE_CREDITO();

                $ps = $con->getConexao()->prepare("UPDATE pedido SET data=data, id_status=" . $this->status->id . " WHERE id = $this->id");
                $ps->execute();
                $ps->close();
            } else if ($passar_direto) {
                if ($this->prazo < 3) {
                    $t = new Tarefa();
                    $t->tipo_tarefa = Sistema::TT_CONFIRMACAO_PAGAMENTO($empresa->id);
                    $t->titulo = "Confirmacao de pagamento do pedido $this->id, cliente " . $this->cliente->razao_social;
                    $t->descricao = "Razao Social: " . $this->cliente->razao_social . " <br>"
                            . "CNPJ: " . $this->cliente->cnpj->valor . " <br>"
                            . "Estado: " . $this->cliente->endereco->cidade->estado->sigla . " <br>"
                            . "Cidade: " . $this->cliente->endereco->cidade->nome . " <br>"
                            . "Email: " . str_replace(array(";"), array("<br>"), $this->cliente->email->endereco) . " <br>"
                            . "Valor do Pedido: R$" . round($this->getTotal(), 2) . " <br> "
                            . "Telefones: ";
                    foreach ($this->cliente->telefones as $key => $value) {
                        $t->descricao .= "$value->numero<br>";
                    }
                    $t->tipo_entidade_relacionada = "PED_" . $this->empresa->id;
                    $t->id_entidade_relacionada = $this->id;
                    Sistema::novaTarefaEmpresa($con, $t, $empresa);

                    $this->status = Sistema::STATUS_CONFIRMACAO_PAGAMENTO();

                    $ps = $con->getConexao()->prepare("UPDATE pedido SET data=data, id_status=" . $this->status->id . " WHERE id = $this->id");
                    $ps->execute();
                    $ps->close();
                } else {

                    $emp = $this->empresa;
                    if ($this->logistica !== null) {
                        $emp = $this->logistica;
                    }

                    $t = new Tarefa();
                    $t->tipo_tarefa = Sistema::TT_SEPARACAO($emp->id);
                    $t->titulo = "Separacao do pedido $this->id";
                    $t->descricao .= "<a style='font-size:20px;text-decoration:underline;color:SteelBlue' href='separacao.php?pedido=$this->id&empresa=" . $this->empresa->id . "'>SEPARAR PEDIDO</a>";

                    $t->tipo_entidade_relacionada = "PED_" . $this->empresa->id;
                    $t->id_entidade_relacionada = $this->id;
                    Sistema::novaTarefaEmpresa($con, $t, $emp);

                    $this->status = Sistema::STATUS_SEPARACAO();

                    $ps = $con->getConexao()->prepare("UPDATE pedido SET data=data, id_status=" . $this->status->id . " WHERE id = $this->id");
                    $ps->execute();
                    $ps->close();
                }
            }

            $ps = $con->getConexao()->prepare("SELECT empresa_vendas FROM empresa WHERE id=".$this->empresa->id);
            $ps->execute();
            $ps->bind_result($ev);
            if($ps->fetch()){
                
                if($ev > 0){
                    $ps->close();
                    
                    $vrt = new Virtual($ev, $con);
                    $t = new Tarefa();
                    $t->tipo_tarefa = Sistema::TT_SUPORTE_ACOMPANHAMENTO($vrt->id);
                    $t->titulo = "Acompanhe o pedido $this->id, do cliente " . $this->cliente->codigo . "-" . $this->cliente->razao_social;
                    $t->descricao .= "Acompanhe o andamento do pedido, para acompanhar as etapas, basta entrar em Pedidos de Venda, digitar o id $this->id do pedido na barra de busca, ap�s isso ao visualizar o pedido, clique no icone <i class='fas fa-edit'></i> para ver maiores informa��es do pedido, e posteriormente acompanhe seu andamento pela aba de Logs do Pedido, isso deve ser feito com frequencia, pedidos que estao a mais de 48 horas na empresa, se tornam protocolos.";

                    $t->tipo_entidade_relacionada = "PED_" . $this->empresa->id;
                    $t->id_entidade_relacionada = $this->id;
                    Sistema::novaTarefaEmpresa($con, $t, $vrt);

                }else{
                    $ps->close();
                }
            }else{
                $ps->close();
            }
            
        } else {

            $ps = $con->getConexao()->prepare("UPDATE pedido SET id_cliente=" . $this->cliente->id . ",id_transportadora=" . $this->transportadora->id . ",frete=$this->frete,observacoes='$this->observacoes',frete_inclusao=" . ($this->frete_incluso ? "true" : "false") . ",id_empresa=" . $this->empresa->id . ",data=FROM_UNIXTIME($this->data/1000),excluido=false,id_usuario=" . $this->usuario->id . ",id_nota=$this->id_nota,prazo=$this->prazo,parcelas=$this->parcelas,id_status=" . $this->status->id . ",id_forma_pagamento=" . $this->forma_pagamento->id . ", id_logistica=" . ($this->logistica != null ? $this->logistica->id : 0) . ",etapa_frete=$this->etapa_frete WHERE id=$this->id");
            $ps->execute();
            $ps->close();

            foreach ($this->fretes_intermediarios as $key => $value) {
                $value->pedido = $this;
                $value->merge($con);
            }
        }

        $erro = null;

        foreach ($prods as $key => $value) {

            foreach ($this->produtos as $key2 => $value2) {

                if ($value->id == $value2->id) {

                    continue 2;
                }
            }

            try {

                $value->delete($con);
                Sistema::avisoDEVS($value->produto->nome . ", quantidade:". $value->quantidade.", Valor Base: R$ ".$value->valor_base.", Retirado do pedido $this->id");
            } catch (Exception $ex) {

                $erro = $ex->getMessage();
            }
        }

        $np = array();
        $merged = array();
        foreach ($this->produtos as $key2 => $value2) {
            try {

                $value2->merge($con);
                $np[] = $value2;
                $merged[] = $value2;
            } catch (Exception $ex) {

                $this->status = $status_anterior;
                $erro = $ex->getMessage() . ", produto cod: " . $value2->produto->id . ", estoque: " . $value2->produto->estoque . ", disponivel: " . $value2->produto->disponivel . ", quantidade: " . $value2->quantidade;
            }
        }

        $this->produtos = $np;


        Logger::gerarLog($this, $this->status->nome);
        if ($inicial) {
            $this->status->enviarEmails($this);
        }
        if ($this->status->nota && $this->id_nota == 0) {

            $nota = $this->gerarNotaPadrao();

            if (count($this->fretes_intermediarios) > 0) {

                $nota->transportadora = $this->fretes_intermediarios[count($this->fretes_intermediarios) - 1]->transportadora;

                $redespacho = "";

                for ($i = count($this->fretes_intermediarios) - 2; $i >= 0; $i--) {
                    $f = $this->fretes_intermediarios[$i];
                    $destino = Sistema::getEmpresas($con, "empresa.id=" . $f->id_empresa_destino);

                    $ps = $con->getConexao()->prepare("SELECT inscricao_estadual,cnpj FROM transportadora WHERE id=" . $f->transportadora->id);
                    $ps->execute();
                    $ps->bind_result($ie, $cnpj);
                    if ($ps->fetch()) {
                        $redespacho .= "Redespacho por " . $f->transportadora->razao_social . " CNPJ: $cnpj, IE: $ie - para " . $destino->endereco->cidade->nome . " - " . $destino->endereco->cidade->estado->sigla . ", " . $destino->endereco->bairro . ", " . $destino->endereco->rua . ", " . $destino->endereco->numero . " CEP: " . $destino->endereco->cep->valor . "; ";
                    }
                    $ps->close();
                }

                $destino = $this->cliente;
                $redespacho .= "Redespacho por " . $this->transportadora->razao_social . " CNPJ: " . $this->transportadora->cnpj->valor . ", IE: " . $this->transportadora->inscricao_estadual . " para " . $destino->endereco->cidade->nome . " - " . $destino->endereco->cidade->estado->sigla . ", " . $destino->endereco->bairro . ", " . $destino->endereco->rua . ", " . $destino->endereco->numero . " CEP: " . $destino->endereco->cep->valor . "; ";

                $nota->observacao = $redespacho . ", " . $nota->observacao;
            }

            $nota->merge($con);

            $this->id_nota = $nota->id;

            $ps = $con->getConexao()->prepare("UPDATE pedido SET id_nota=$this->id_nota WHERE id=$this->id");
            $ps->execute();
            $ps->close();

            $ps = $con->getConexao()->prepare("UPDATE nota SET data_emissao=data_emissao,id_pedido=$this->id WHERE id=$nota->id");
            $ps->execute();
            $ps->close();

            if ($this->logistica !== null) {

                $getter = new Getter($this->logistica);

                $nota_logistica_empresa = $this->gerarNotaPadrao();

                $l = $this->logistica;
                $t = new Transportadora();
                $t->razao_social = $l->nome;
                $t->cnpj = $l->cnpj;
                $t->inscricao_estadual = $l->inscricao_estadual;
                $t->email = $l->email;
                $t->endereco = $l->endereco;
                $t->telefones = array($l->telefone);
                $t->empresa = $l;
                $t->habilitada = true;
                $t->nome_fantasia = $l->nome;
                $t = $getter->getTransportadoraViaTransportadora($con, $t);
                $nota_logistica_empresa->transportadora = $t;

                $vencimento = new Vencimento();
                $vencimento->nota = $nota_logistica_empresa;
                $vencimento->valor = 0;

                foreach ($nota_logistica_empresa->produtos as $key => $value) {
                    $value->cfop = CFOP::$RETORNO_DEPOSITO;
                    $value->valor_unitario = $value->produto->custo;
                    $value->valor_total = $value->valor_unitario * $value->quantidade;
                    $vencimento->valor += $value->valor_unitario * $value->quantidade;
                }

                $nota_logistica_empresa->vencimentos = array($vencimento);

                $nota_logistica_empresa->observacao = new OBS_NFE($this->logistica, $this, OBS_NFE::$RETORNO_REMESSA);
                $nota_logistica_empresa->observacao = $nota_logistica_empresa->observacao->getObs();
                $nota_logistica_empresa->empresa = $this->logistica;
                $nota_logistica_empresa->cliente = $getter->getClienteViaEmpresa($con, $this->empresa);

                $nota_logistica_empresa->merge($con);

                $ps = $con->getConexao()->prepare("UPDATE nota SET data_emissao=data_emissao,id_pedido=$this->id WHERE id=$nota_logistica_empresa->id");
                $ps->execute();
                $ps->close();
            }
        }

        if ($erro !== null) {
            if (!$recursao && !$inicial) {
                $this->merge($con, true);
            } else if ($inicial) {

                foreach ($merged as $key => $value) {
                    $value->delete($con);
                    Sistema::avisoDEVS_MASTER($value->produto->nome . ", Retirado do pedido $this->id");
                }

                $ps = $con->getConexao()->prepare("DELETE FROM pedido WHERE id=$this->id");
                $ps->execute();
                $ps->close();
            }
            throw new Exception($erro);
        }

        if (!$this->status->nota) {
            try {
                $this->cancelarNotas($con);
            } catch (Exception $e) {
                throw new Exception("Nao foi possivel cancelar as notas do pedido, favor cancelar manualmente");
            }
        }
    }

    private function cancelarNotas($con) {

        $ps = $con->getConexao()->prepare("SELECT id FROM nota WHERE id_pedido=$this->id AND cancelada=false");
        $ps->execute();
        $ps->bind_result($id);
        if ($ps->fetch()) {
            $ps->close();

            $notas = $this->empresa->getNotas($con, 0, 50, "nota.id_pedido=$this->id AND nota.cancelada=false");

            if ($this->logistica !== null) {
                $notas_logistica = $this->logistica->getNotas($con, 0, 50, "nota.id_pedido=$this->id AND nota.cancelada=false");
                foreach ($notas_logistica as $key => $value) {
                    $notas[] = $value;
                }
            }

            foreach ($notas as $key => $value) {
                if ($value->emitida) {
                    $value->cancelar($con, "Pedido $this->id, referente a nota foi cancelado");
                } else {
                    $value->delete($con);
                }
            }
        } else {
            $ps->close();
        }
    }

    public function delete($con) {

        $this->cancelarNotas($con);
        
        $ps = $con->getConexao()->prepare("UPDATE pedido SET excluido=true WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();

        $this->status = Sistema::getStatusExcluidoPedidoSaida();

        $this->produtos = $this->getProdutos($con);

        $erro = null;


        $ps = $con->getConexao()->prepare("UPDATE tarefa SET inicio_minimo=inicio_minimo,excluida=true "
                . "WHERE tipo_entidade_relacionada='PED_" . $this->empresa->id . "' AND id_entidade_relacionada=$this->id AND porcentagem_conclusao<100");
        $ps->execute();
        $ps->close();

        foreach ($this->produtos as $key => $value) {
            try {
                $value->merge($con);
            } catch (Exception $ex) {
                $value->delete($con);
                $erro = $ex->getMessage() . ", produto cod: " . $value->produto->id . ", estoque: " . $value->produto->estoque . ", disponivel: " . $value->produto->disponivel . ", quantidade: " . $value->quantidade;
            }
        }

        if ($erro !== null) {

            throw new Exception($erro);
        }
    }

}
