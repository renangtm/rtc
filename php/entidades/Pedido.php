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
    public $nota;
    public $prazo;
    public $parcelas;
    public $status;
    public $produtos;
    public $forma_pagamento;

    function __construct() {

        $this->id = 0;
        $this->cliente = null;
        $this->transportadora = null;
        $this->frete = 0;
        $this->observacoes = "";
        $this->frete_incluso = "";
        $this->empresa = null;
        $this->data = round(microtime(true));
        $this->excluido = false;
        $this->usuario = null;
        $this->nota = null;
        $this->prazo = 0;
        $this->parcelas = 1;
        $this->status = null;
        $this->produtos = null;
        $this->forma_pagamento = null;
    }

    public function getProdutos($con) {

        $campanhas = array();
        $ofertas = array();

        $ps = $con->getConexao()->prepare("SELECT campanha.id,campanha.inicio,campanha.fim,campanha.prazo,campanha.parcelas,campanha.cliente_expression,produto_campanha.id,produto_campanha.id_produto,UNIX_TIMESTAMP(produto_campanha.validade)*1000,produto_campanha.limite,produto_campanha.valor FROM campanha INNER JOIN produto_campanha ON campanha.id = produto_campanha.id_campanha WHERE campanha.inicio>=CURRENT_TIMESTAMP AND campanha.fim<=CURRENT_TIMESTAMP AND campanha.excluida=false");
        $ps->execute();
        $ps->bind_result($id, $inicio, $fim, $prazo, $parcelas, $cliente, $id_produto_campanha, $id_produto, $validade, $limite, $valor);

        while ($ps->fetch()) {

            if (!isset($campanhas[$id])) {

                $campanhas[$id] = new Campanha();
                $campanhas[$id]->id = $id;
                $campanhas[$id]->inicio = $inicio;
                $campanhas[$id]->fim = $fim;
                $campanhas[$id]->prazo = $prazo;
                $campanhas[$id]->parcelas = $parcelas;
                $campanhas[$id]->cliente = $cliente;
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
                . "categoria_produto.id,"
                . "categoria_produto.nome,"
                . "categoria_produto.base_calculo,"
                . "categoria_produto.ipi,"
                . "categoria_produto.icms_normal,"
                . "categoria_produto.icms"
                . " FROM produto_pedido_saida "
                . "INNER JOIN produto ON produto_pedido_saida.id_produto=produto.id "
                . "INNER JOIN categoria_produto ON categoria_produto.id=produto.id_categoria"
                . " WHERE produto_pedido_saida.id_pedido=$this->id");

        $ps->execute();
        $ps->bind_result($id, $quantidade, $validade, $valor_base, $juros, $icms, $base_calculo, $frete, $ie, $ir, $ipi, $id_pro, $id_uni, $liq, $qtd_un, $hab, $vb, $cus, $pb, $pl, $est, $disp, $tr, $gr, $uni, $ncm,$nome, $lucro, $cat_id, $cat_nom, $cat_bs, $cat_ipi, $cat_icms_normal, $cat_icms);

        $retorno = array();

        
        $ids = "-1";
        while ($ps->fetch()) {

            $p = new Produto();
            $p->id = $id_pro;
            $p->nome = $nome;
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
            $p->transito = $tr;
            $p->grade = new Grade($gr);
            $p->unidade = $uni;
            $p->ncm = $ncm;
            $p->lucro_consignado = $lucro;
            $p->empresa = $this->empresa;
            $p->ofertas = (!isset($ofertas[$p->id]) ? array() : $ofertas[$p->id]);

            $p->categoria = new CategoriaProduto();

            $p->categoria->id = $cat_id;
            $p->categoria->nome = $cat_nom;
            $p->categoria->base_calculo = $cat_bs;
            $p->categoria->icms = $cat_icms;
            $p->categoria->icms_normal = $cat_icms_normal;
            $p->categoria->ipi = $cat_ipi;

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

            $ids .= ",".$pp->id;
            
        }

        $ps->close();
        $ps = $con->getConexao()->prepare("SELECT id_lote,quantidade,retirada,id_produto_pedido FROM retirada WHERE id_produto_pedido IN ($ids)");
        $ps->execute();
        $ps->bind_result($id_lote,$qtd,$ret,$idp);
        while($ps->fetch()){
            
            $r = explode(",", $ret);
            $rr = array($id_lote,$qtd);
            
            foreach ($r as $key => $value) {
                
                $rr[] = intval($value);
                
            }
            
            $retorno[$idp]->retiradas[] = $rr;
            
        }
        
        $real_ret = array();
        
        foreach($retorno as $key=>$value){
            
            $real_ret[] = $value;
            
        }
        
        return $real_ret;
    }

    public function atualizarCustos() {

        foreach ($this->produtos as $key => $value) {

            $value->atualizarCustos();
        }
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO pedido(id_cliente,id_transportadora,frete,observacoes,frete_inclusao,id_empresa,data,excluido,id_usuario,id_nota,prazo,parcelas,id_status,id_forma_pagamento) VALUES(" . $this->cliente->id . "," . $this->transportadora->id . ",$this->frete,'$this->observacoes'," . ($this->frete_incluso ? "true" : "false") . "," . $this->empresa->id . ",FROM_UNIXTIME($this->data/1000),false," . $this->usuario->id . "," . ($this->nota === null ? 0 : $this->nota->id) . ",$this->prazo,$this->parcelas," . $this->status->id . "," . $this->forma_pagamento->id . ")");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE pedido SET id_cliente=" . $this->cliente->id . ",id_transportadora=" . $this->transportadora->id . ",frete=$this->frete,observacoes='$this->observacoes',frete_inclusao=" . ($this->frete_incluso ? "true" : "false") . ",id_empresa=" . $this->empresa->id . ",data=FROM_UNIXTIME($this->data/1000),excluido=false,id_usuario=" . $this->usuario->id . ",id_nota=" . ($this->nota === null ? 0 : $this->nota->id) . ",prazo=$this->prazo,parcelas=$this->parcelas,id_status=" . $this->status->id . ",id_forma_pagamento=" . $this->forma_pagamento->id . " WHERE id=$this->id");
            $ps->execute();
            $ps->close();
        }

        $prods = $this->getProdutos($con);

        if ($this->produtos == null) {

            $this->produtos = $prods;
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
            } catch (Exception $ex) {

                $erro = $ex->getMessage();
            }
        }

        foreach ($this->produtos as $key2 => $value2) {

            try {

                $value2->merge($con);
            } catch (Exception $ex) {

                $erro = $ex->getMessage() . ", produto cod: " . $value2->produto->id . ", estoque: " . $value2->produto->estoque . ", disponivel: " . $value2->produto->disponivel . ", quantidade: " . $value2->quantidade;
            }
        }

        if ($erro !== null) {

            throw new Exception($erro);
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE pedido SET excluido=true WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();

        $this->status = Sistema::getStatusExcluidoPedidoSaida();

        $this->produtos = $this->getProdutos($con);

        $erro = null;

        foreach ($this->produtos as $key => $value) {

            try {

                $value->merge($con);
                
            } catch (Exception $ex) {

                $erro = $ex->getMessage() . ", produto cod: " . $value->produto->id . ", estoque: " . $value->produto->estoque . ", disponivel: " . $value->produto->disponivel . ", quantidade: " . $value->quantidade;
            }
        }

        if ($erro !== null) {
            throw new Exception($erro);
        }
    }

}
