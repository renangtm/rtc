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
class CotacaoGrupal {

    public $id;
    public $fornecedores;
    public $produtos;
    public $data;
    public $observacoes;
    public $empresa;

    function __construct() {

        $this->id = 0;
        $this->fornecedores = array();
        $this->produtos = array();
        $this->data = round(microtime(true) * 1000);
        $this->observacoes = "";
        $this->empresa = null;
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO cotacao_grupal(id_empresa,observacoes,data) VALUES(" . $this->empresa->id . ",'" . addslashes($this->observacoes) . "',FROM_UNIXTIME($this->data/1000))");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE cotacao_grupal SET id_empresa=" . $this->empresa->id . ",data=FROM_UNIXTIME($this->data/1000),observacoes='" . addslashes($this->observacoes) . "' WHERE id = $this->id");
            $ps->execute();
            $ps->close();
        }

        $ids = "(0";
        foreach ($this->produtos as $key2 => $value2) {

            $value2->merge($con);

            $ids .= ",$value2->id";
        }
        $ids .= ")";

        $ps = $con->getConexao()->prepare("DELETE FROM produto_cotacao_grupal WHERE id_cotacao=$this->id AND id NOT IN $ids");
        $ps->execute();
        $ps->close();

        $ps = $con->getConexao()->prepare("DELETE FROM fornecedor_cotacao_grupal WHERE id_cotacao=$this->id");
        $ps->execute();
        $ps->close();

        foreach ($this->fornecedores as $key => $value) {
            $ps = $con->getConexao()->prepare("INSERT INTO fornecedor_cotacao_grupal(id_fornecedor,id_cotacao) VALUES($value->id,$this->id)");
            $ps->execute();
            $ps->close();
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE cotacao_grupal SET excluida=true WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
