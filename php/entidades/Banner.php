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
class Banner {

    public $id;
    public $campanha;
    public $data_inicial;
    public $data_final;
    public $json;
    public $empresa;
    public $tipo;

    function __construct() {

        $this->id = 0;
        $this->campanha = null;
        $this->data_inicial = round(microtime(true) * 1000);
        $this->data_final = round(microtime(true) * 1000);
        $this->json = null;
        $this->tipo = 0;
        $this->empresa = null;
        
    }

    public function getJson($con) {

        if ($this->id === 0) {

            return "";
        }

        $ps = $con->getConexao()->prepare("SELECT json FROM banner WHERE id=$this->id");
        $ps->execute();
        $ps->bind_result($json);

        if ($ps->fetch()) {
            $ps->close();

            return "";
        }

        $ps->close();

        return "";
    }

    public function merge($con) {

        if ($this->json === null) {

            $this->json = $this->getJson($con);
        }

        if ($this->id == 0) {
            
            $ps = $con->getConexao()->prepare("INSERT INTO banner(id_campanha,data_inicial,data_final,json,id_empresa,tipo) VALUES(" . (($this->campanha !== null) ? $this->campanha->id : 0) . ",FROM_UNIXTIME($this->data_inicial/1000),FROM_UNIXTIME($this->data_final/1000),'" . addslashes($this->json) . "',".$this->empresa->id.",$this->tipo)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE banner SET id_campanha=" . (($this->campanha !== null) ? $this->campanha->id : 0) . ",data_inicial=FROM_UNIXTIME($this->data_inicial/1000),data_final=FROM_UNIXTIME($this->data_final/1000),json='" . addslashes($this->json) . "',id_empresa=".$this->empresa->id.", tipo=$this->tipo  WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("DELETE FROM banner WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
