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
class ProdutoCotacaoGrupal {

    public $id;
    public $produto;
    public $quantidade;
    public $respostas;
    public $cotacao;

    function __construct() {

        $this->id = 0;
        $this->produto = null;
        $this->quantidade = 0;
        $this->respostas = array();
        $this->cotacao = array();
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO produto_cotacao_grupal(id_cotacao,id_produto,quantidade) VALUES(" . $this->cotacao->id . "," . $this->produto->id . ",$this->quantidade)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE produto_cotacao_grupal SET id_cotacao=" . $this->cotacao->id . ",quantidade=$this->quantidade,id_produto=" . $this->produto->id . " WHERE id = $this->id");
            $ps->execute();
            $ps->close();
        }

        $ids = "(0";
        foreach ($this->respostas as $key2 => $value2) {

            $value2->merge($con);

            $ids .= ",$value2->id";
        }
        $ids .= ")";

        $ps = $con->getConexao()->prepare("DELETE FROM resposta_cotacao_grupal WHERE id_produto_cotacao=$this->id AND id NOT IN $ids");
        $ps->execute();
        $ps->close();
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("DELETE FROM produto_cotacao_grupal WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
