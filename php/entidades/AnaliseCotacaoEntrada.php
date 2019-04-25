<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProdutoCotacaoEntrada
 *
 * @author Renan
 */
class AnaliseCotacaoEntrada {

    public $id;
    public $nome_produto;
    public $quantidade_produto;
    public $valor;
    public $valor_maximo;
    public $valor_minimo;
    public $data;
    public $ids_produtos;
    public $custo_atual;

    function __construct() {

        $this->id = 0;
        $this->nome_produto = "";
        $this->quantidade_produto = 0;
        $this->valor = 0;
        $this->valor_maximo = 0;
        $this->valor_minimo = 0;
        $this->data = round(microtime(true) * 1000);
        $this->ids_produtos = array();
        $this->custo_atual = 0;
    }

    public function recusar($con, $empresa) {

        foreach ($this->ids_produtos as $key => $value) {

            $ps = $con->getConexao()->prepare("UPDATE produto_cotacao_entrada SET checado=true WHERE id=$value");
            $ps->execute();
            $ps->close();
        }

        $adm = $empresa->getAdm($con);
        if ($adm !== null) {
            $empresa = $adm;
        }

        $t = new Tarefa();
        $t->tipo_tarefa = Sistema::TT_COTACAO($empresa->id);
        $t->titulo = "Preco de cotacao do produto $this->nome_produto rejeitado";
        $t->descricao = "Preco de cotacao do produto $this->nome_produto rejeitado, efetue novas cotacoes";
        $t->tipo_entidade_relacionada = "COT_" . $empresa->id;
        $t->id_entidade_relacionada = $empresa->id;

        try {
            Sistema::novaTarefaEmpresa($con, $t, $empresa);
        } catch (Exception $e) {
            
        }
    }

    public function passar($con) {

        foreach ($this->ids_produtos as $key => $value) {

            $ps = $con->getConexao()->prepare("UPDATE produto_cotacao_entrada SET checado=true WHERE id=$value");
            $ps->execute();
            $ps->close();
        }
    }

    public function aprovar($con, $empresa) {

        $ids = "($empresa->id";

        $filiais = $empresa->getFiliais($con);

        foreach ($filiais as $key => $value) {
            $ids .= ",$value->id";
        }

        $ids .= ")";

        $ps = $con->getConexao()->prepare("UPDATE produto SET custo=$this->valor,valor_base=$this->valor/0.821 WHERE codigo=$this->id AND id_empresa IN $ids");
        $ps->execute();
        $ps->close();
    }

    public function campanha($con, $empresa, $dias) {

        $ps = $con->getConexao()->prepare("INSERT INTO campanha_encomenda(valor_base,termino,id_empresa,codigo_produto) VALUES($this->valor,DATE_ADD(CURRENT_DATE,INTERVAL $dias DAY),$empresa->id,$this->id)");
        $ps->execute();
        $ps->close();
    }

}
