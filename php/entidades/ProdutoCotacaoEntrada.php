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
class ProdutoCotacaoEntrada {

    public $id;
    public $produto;
    public $quantidade;
    public $cotacao;

    function __construct() {

        $this->id = 0;
        $this->produto = null;
        $this->cotacao = null;
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO produto_cotacao_entrada(id_produto,quantidade,id_cotacao) VALUES(" . $this->produto->id . "," . $this->quantidade . "," . $this->cotacao->id . ")");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE regra_tabela SET id_produto = " . $this->id_produto . ", quantidade = " . $this->quantidade . ", id_cotacao=" . $this->cotacao->id . " WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("DELETE FROM produto_cotacao_entrada WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
