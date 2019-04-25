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
    public $valor;
    public $quantidade;
    public $momento;

    function __construct() {

        $this->id = 0;
        $this->quantidade = 0;
        $this->valor = 0;
        $this->momento = round(microtime(true) * 1000);
        $this->produto = null;
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO resposta_cotacao_grupal(valor,quantidade,id_produto_cotacao,momento) VALUES($this->valor,$this->quantidadde," . $this->produto->id . ",FROM_UNIXTIME($this->momento/1000))");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE resposta_cotacao_grupal SET id_produto=" . $this->produto->id . ",quantidade=$this->quantidade,valor=" . $this->valor . ",momento=FROM_UNIXTIME($this->momento/1000) WHERE id = $this->id");
            $ps->execute();
            $ps->close();
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("DELETE FROM resposta_cotacao_grupal WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
