<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegraTabela
 *
 * @author Renan
 */
class Nota {

    public $id;
    public $transportadora;
    public $fornecedor;
    public $cliente;
    public $saida;
    public $empresa;
    public $data_emissao;
    public $excluida;
    public $interferir_estoque;
    public $produtos;
    public $observacao;
    public $vencimentos;
    public $frete_destinatario_remetente;
    public $forma_pagamento;
    public $emitida;
    public $xml;
    public $danfe;
    public $chave;
    public $numero;
    public $ficha;
    public $cancelada;
    public $protocolo;
    public $validar;

    function __construct() {

        $this->id = 0;
        $this->fornecedor = null;
        $this->cliente = null;
        $this->validar = true;
        $this->transportadora = null;
        $this->saida = true;
        $this->excluida = false;
        $this->empresa = null;
        $this->data_emissao = round(microtime(true) * 1000);
        $this->produtos = null;
        $this->vencimentos = null;
        $this->interferir_estoque = true;
        $this->forma_pagamento = null;
        $this->frete_destinatario_remetente = false;
        $this->emitida = false;
        $this->numero = 0;
        $this->ficha = 0;
        $this->cancelada = false;
    }

    public function igualaVencimento() {

        $totp = 0;

        foreach ($this->produtos as $key => $value) {
            $totp += $value->valor_total;
        }

        $vencimento = new Vencimento();
        $vencimento->nota = $this;
        $vencimento->valor = $totp;

        $this->vencimentos = array($vencimento);
    }

    public function inverteOperacao($con, $empresa) {

        $gt = new Getter($empresa);
        $nota = Utilidades::copyId0($this);
        unset($nota->inverter);

        if ($nota->saida) {

            $fornecedor = $gt->getFornecedorViaEmpresa($con, $nota->empresa);
            $nota->empresa = $empresa;
            $nota->cliente = null;
            $nota->fornecedor = $fornecedor;
        } else {

            $cliente = $gt->getClienteViaEmpresa($con, $nota->empresa);
            $nota->empresa = $empresa;
            $nota->fornecedor = null;
            $nota->cliente = $cliente;
        }

        $nota->saida = !$nota->saida;

        foreach ($nota->produtos as $key => $value) {
            $prod = Utilidades::copyId0($value);
            $prod->nota = $nota;
            $nota->produtos[$key] = $prod;
        }

        foreach ($nota->vencimentos as $key => $value) {
            $venc = Utilidades::copyId0($value);
            $venc->nota = $nota;
            $nota->vencimentos[$key] = $venc;
        }

        return $nota;
    }

    public function calcularImpostosAutomaticamente() {

        
        $est = ($this->saida) ? $this->cliente->endereco->cidade->estado : $this->fornecedor->endereco->cidade->estado;

        $suf = false;
        
        if($this->saida){
            if($this->cliente->suframado){
                $suf = true;
            }
        }
        
        foreach ($this->produtos as $key => $value) {
            
            $cat = $value->produto->categoria;
            $value->base_calculo = ($cat->base_calculo / 100) * $value->valor_unitario;
            if($est->sigla !== $this->empresa->endereco->cidade->estado->sigla && !$suf){
                if ($cat->icms_normal) {
                    $icm = Sistema::getIcmsEstado($est);
                    $value->icms = $value->base_calculo * ($icm / 100);
                } else {
                    $value->icms = $value->base_calculo * ($cat->icms / 100);
                }
            }else{
                $value->icms = 0;
            }
            
        }
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

            $campanhas[$id]->produtos[] = $p;

            $ofertas[$id_produto][] = $p;
        }

        $ps->close();

        $ps = $con->getConexao()->prepare("SELECT produto_nota.id,"
                . "produto_nota.informacao_adicional,"
                . "produto_nota.quantidade,"
                . "produto_nota.valor_unitario,"
                . "produto_nota.valor_total,"
                . "produto_nota.base_calculo,"
                . "produto_nota.cfop,"
                . "produto_nota.icms,"
                . "produto_nota.ipi,"
                . "produto_nota.influencia_estoque,"
                . "produto.id,"
                . "produto.codigo,"
                . "produto.id_logistica,"
                . "produto.classe_risco,"
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
                . "categoria_produto.id,"
                . "categoria_produto.nome,"
                . "categoria_produto.base_calculo,"
                . "categoria_produto.ipi,"
                . "categoria_produto.icms_normal,"
                . "categoria_produto.icms,"
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
                . " FROM produto_nota "
                . "INNER JOIN produto ON produto_nota.id_produto=produto.id "
                . "INNER JOIN categoria_produto ON categoria_produto.id=produto.id_categoria "
                . "INNER JOIN empresa ON produto.id_empresa=empresa.id "
                . "INNER JOIN endereco ON endereco.id_entidade=empresa.id AND endereco.tipo_entidade='EMP' "
                . "INNER JOIN email ON email.id_entidade=empresa.id AND email.tipo_entidade='EMP' "
                . "INNER JOIN telefone ON telefone.id_entidade=empresa.id AND telefone.tipo_entidade='EMP' "
                . "INNER JOIN cidade ON endereco.id_cidade=cidade.id "
                . "INNER JOIN estado ON cidade.id_estado = estado.id "
                . " WHERE produto_nota.id_nota=$this->id");

        $ps->execute();
        $ps->bind_result($id, $info_adic, $quantidade, $valor_unitario, $valor_total, $base_calculo, $cfop, $icms, $ipi, $influencia_estoque, $id_pro,$cod_pro, $id_log, $classe_risco, $fabricante, $imagem, $id_uni, $liq, $qtd_un, $hab, $vb, $cus, $pb, $pl, $est, $disp, $tr, $gr, $uni, $ncm, $nome, $lucro, $ativo, $conc,$sistema_lotes,$nota_usuario, $cat_id, $cat_nom, $cat_bs, $cat_ipi, $cat_icms_normal, $cat_icms, $id_empresa, $tipo_empresa, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        $retorno = array();


        while ($ps->fetch()) {

            $p = new Produto();
            $p->logistica = $id_log;
            $p->id = $id_pro;
            $p->codigo = $cod_pro;
            $p->sistema_lotes = $sistema_lotes==1;
            $p->nota_usuario = $nota_usuario;
            $p->nome = $nome;
            $p->classe_risco = $classe_risco;
            $p->fabricante = $fabricante;
            $p->imagem = $imagem;
            $p->id_universal = $id_uni;
            $p->liquido = $liq;
            $p->quantidade_unidade = $qtd_un;
            $p->habilitado = $hab;
            $p->valor_base = $vb;
            $p->ativo = $ativo;
            $p->concentracao = $conc;
            $p->custo = $cus;
            $p->peso_bruto = $pb;
            $p->peso_liquido = $pl;
            $p->estoque = $est;
            $p->disponivel = $disp;
            $p->transito = $tr;
            $p->grade = new Grade($gr);
            $p->unidade = $uni;
            $p->ncm = $ncm;
            $p->lucro_consignado = $lucro;
            $p->empresa = $this->empresa;
            $p->ofertas = (!isset($ofertas[$p->id]) ? array() : $ofertas[$p->id]);

            foreach ($p->ofertas as $key => $oferta) {

                $oferta->produto = $p;
            }


            $p->categoria = new CategoriaProduto();

            $p->categoria->id = $cat_id;
            $p->categoria->nome = $cat_nom;
            $p->categoria->base_calculo = $cat_bs;
            $p->categoria->icms = $cat_icms;
            $p->categoria->icms_normal = $cat_icms_normal;
            $p->categoria->ipi = $cat_ipi;

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

            $pp = new ProdutoNota();
            $pp->id = $id;
            $pp->informacao_adicional = $info_adic;
            $pp->quantidade = $quantidade;
            $pp->valor_total = $valor_total;
            $pp->valor_unitario = $valor_unitario;
            $pp->icms = $icms;
            $pp->ipi = $ipi;
            $pp->base_calculo = $base_calculo;
            $pp->influencia_estoque = $influencia_estoque;
            $pp->produto = $p;
            $pp->cfop = $cfop;
            $pp->nota = $this;


            $retorno[$pp->id] = $pp;
        }

        $ps->close();

        foreach ($retorno as $key => $value) {
            $value->produto->logistica = Sistema::getLogisticaById($con, $value->produto->logistica);
        }

        $real_ret = array();

        foreach ($retorno as $key => $value) {

            $real_ret[] = $value;
        }

        return $real_ret;
    }

    public function manifestar($con) {

        $this->emitida = true;

        $ps = $con->getConexao()->prepare("UPDATE nota SET emitida=true WHERE id=$this->id");
        $ps->execute();
        $ps->close();
    }

    public function emitir($con) {

        $this->emitida = true;

        $ps = $con->getConexao()->prepare("UPDATE nota SET emitida=true WHERE id=$this->id");
        $ps->execute();
        $ps->close();
    }

    public function cancelar($con, $motivo) {

        $ps = $con->getConexao()->prepare("SELECT movimento.id FROM movimento "
                . "INNER JOIN vencimento ON vencimento.id_movimento=movimento.id AND vencimento.id_nota=$this->id "
                . "LEFT JOIN movimento est ON est.estorno=movimento.id WHERE est.id IS NULL");
        $ps->execute();
        $ps->bind_result($idm);
        if ($ps->fetch()) {
            $ps->close();
            throw new Exception('O movimento bancario ' . $idm . ', esta relacionado com a nota, e necessario que seja estornado ou excluido');
        }
        $ps->close();
    }

    public function corrigir($con, $correcao) {
        
    }

    public function merge($con) {

        $vencimentos = $this->getVencimentos($con);

        if ($this->vencimentos === null) {

            $this->vencimentos = $vencimentos;
        }

        $prods = $this->getProdutos($con);

        if ($this->produtos === null) {

            $this->produtos = $prods;
        }


        $totv = 0;

        foreach ($this->vencimentos as $key => $value) {

            $totv += $value->valor;
        }

        $totp = 0;

        foreach ($this->produtos as $key => $value) {

            $totp += $value->valor_total;
        }

        if ((($totv > ($totp+0.1)) || ($totv < ($totp-0.1))) && $this->validar) {

            throw new Exception('Somatorio das parcelas difere do valor da nota Total:' . $totp . ', Somatorio: ' . $totv);
        }



        if ($this->emitida && $this->ficha == 0) {

            $ps = $con->getConexao()->prepare("SELECT MAX(ficha) FROM nota WHERE id_empresa = " . $this->empresa->id);
            $ps->execute();
            $ps->bind_result($ficha);
            if ($ps->fetch()) {
                $ps->close();
                $this->ficha = $ficha + 1;
            } else {
                $ps->close();
                $this->ficha = 1;
            }
        }



        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO nota(saida,chave,id_cliente,id_fornecedor,observacao,id_empresa,data_emissao,excluida,influenciar_estoque,id_transportadora,id_forma_pagamento,frete_destinatario_remetente,emitida,numero,ficha,cancelada,danfe,xml,protocolo) VALUES(" . ($this->saida ? "true" : "false") . ",'$this->chave'," . ($this->cliente != null ? $this->cliente->id : 0) . "," . ($this->fornecedor != null ? $this->fornecedor->id : 0) . ",'$this->observacao'," . $this->empresa->id . ",FROM_UNIXTIME($this->data_emissao/1000),false," . ($this->interferir_estoque ? "true" : "false") . "," . $this->transportadora->id . "," . $this->forma_pagamento->id . "," . ($this->frete_destinatario_remetente ? "true" : "false") . "," . ($this->emitida ? "true" : "false") . ",$this->numero,$this->ficha," . ($this->cancelada ? "true" : "false") . ",'$this->danfe','$this->xml','$this->protocolo')");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE nota SET saida=" . ($this->saida ? "true" : "false") . ",chave='$this->chave',id_cliente=" . ($this->cliente != null ? $this->cliente->id : 0) . ",id_fornecedor=" . ($this->fornecedor != null ? $this->fornecedor->id : 0) . ",observacao='$this->observacao',id_empresa=" . $this->empresa->id . ",data_emissao=FROM_UNIXTIME($this->data_emissao/1000),excluida=false,influenciar_estoque=" . ($this->interferir_estoque ? "true" : "false") . ", id_transportadora=" . $this->transportadora->id . ", id_forma_pagamento=" . $this->forma_pagamento->id . ",frete_destinatario_remetente=" . ($this->interferir_estoque ? "true" : "false") . ", emitida=" . ($this->emitida ? "true" : "false") . ",numero=$this->numero,ficha=$this->ficha,cancelada=" . ($this->cancelada ? "true" : "false") . ",danfe='$this->danfe',xml='$this->xml',protocolo='$this->protocolo' WHERE id=$this->id");
            $ps->execute();
            $ps->close();
        }





        foreach ($prods as $key => $value) {

            foreach ($this->produtos as $key2 => $value2) {

                if ($value->id == $value2->id) {

                    continue 2;
                }
            }

            $value->delete($con);
        }
        $erro = "";
        foreach ($this->produtos as $key2 => $value2) {

            try {

                $value2->merge($con);
            } catch (Exception $ex) {

                $erro = $ex->getMessage() . ", produto cod: " . $value2->produto->id . ", estoque: " . $value2->produto->estoque . ", disponivel: " . $value2->produto->disponivel . ", quantidade: " . $value2->quantidade;
            }
        }



        foreach ($vencimentos as $key => $v) {

            foreach ($this->vencimentos as $key2 => $v2) {

                if ($v->id == $v2->id) {

                    continue 2;
                }
            }

            $v->delete($con);
        }

        foreach ($this->vencimentos as $key2 => $v2) {

            $v2->merge($con);
        }

        if ($erro != "") {
            throw new Exception($erro);
        }
    }

    public function delete($con) {

        $this->interferir_estoque = false;

        $erro = "";

        $this->produtos = $this->getProdutos($con);
        foreach ($this->produtos as $key2 => $value2) {

            try {

                $value2->merge($con);
            } catch (Exception $ex) {

                $erro = $ex->getMessage() . ", produto cod: " . $value2->produto->id . ", estoque: " . $value2->produto->estoque . ", disponivel: " . $value2->produto->disponivel . ", quantidade: " . $value2->quantidade;
            }
        }


        $ps = $con->getConexao()->prepare("UPDATE nota SET excluida=true WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();

        if ($erro != "") {
            throw new Exception($erro);
        }
    }

    public function getVencimentos($con) {

        $vencimentos = array();

        $ps = $con->getConexao()->prepare("SELECT vencimento.id,vencimento.valor,UNIX_TIMESTAMP(vencimento.data)*1000,movimento.id,UNIX_TIMESTAMP(movimento.data)*1000,movimento.saldo_anterior,movimento.valor,movimento.juros,movimento.descontos,movimento.estorno,historico.id,historico.nome,operacao.id,operacao.nome,operacao.debito,banco.id,banco.nome,banco.conta,banco.saldo,banco.codigo FROM vencimento LEFT JOIN movimento ON movimento.id=vencimento.id_movimento LEFT JOIN banco ON movimento.id_banco=banco.id LEFT JOIN operacao ON operacao.id=movimento.id_operacao LEFT JOIN historico ON historico.id=movimento.id_historico WHERE id_nota=$this->id");
        $ps->execute();
        $ps->bind_result($id, $valor, $data, $id_mov, $data_mov, $sal_mov, $val_mov, $mov_jur, $mov_desc, $mov_estorno, $hist_id, $hist_nom, $op_id, $op_nom, $op_deb, $ban_id, $ban_nom, $ban_cont, $ban_sal, $ban_cod);

        while ($ps->fetch()) {

            $v = new Vencimento();
            $v->id = $id;
            $v->valor = $valor;
            $v->data = $data;
            $v->nota = $this;

            if ($id_mov != null) {

                $m = new Movimento();

                $m->id = $id_mov;
                $m->data = $data_mov;
                $m->saldo_anterior = $sal_mov;
                $m->valor = $val_mov;
                $m->juros = $mov_jur;
                $m->estorno = $mov_estorno;
                $m->descontos = $mov_desc;
                $m->vencimento = $v;

                $h = new Historico();
                $h->id = $hist_id;
                $h->nome = $hist_nom;

                $o = new Operacao();
                $o->id = $op_id;
                $o->nome = $op_nom;
                $o->debito = $op_deb;

                $b = new Banco();
                $b->id = $ban_id;
                $b->codigo = $ban_cod;
                $b->conta = $ban_cont;
                $b->nome = $ban_nom;
                $b->saldo = $ban_sal;
                $b->empresa = $this->empresa;

                $m->historico = $h;
                $m->operacao = $o;
                $m->banco = $b;

                $v->movimento = $m;
            }

            $vencimentos[] = $v;
        }
        return $vencimentos;
    }

}
