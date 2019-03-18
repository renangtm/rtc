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
class Ausencia {

    public $id;
    public $inicio;
    public $fim;

    public function __construct() {

        $this->id = 0;
        $this->inicio = round(microtime(true) * 1000);
        $this->fim = round(microtime(true) * 1000 + (24 * 60 * 60 * 1000));
    }

    public function merge($con) {

        if ($this->id === 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO ausencia(inicio,fim) VALUES(FROM_UNIXTIME($this->inicio/1000),FROM_UNIXTIME($this->fim/1000))");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE ausencia SET inicio=FROM_UNIXTIME($this->inicio/1000), fim=FROM_UNIXTIME($this->fim/1000) WHERE id=$this->id");
            $ps->execute();
            $ps->close();
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("DELETE FROM ausencia WHERE id=$this->id");
        $ps->execute();
        $ps->close();
    }

}
