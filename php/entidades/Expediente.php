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
class Expediente {

    public $id;
    public $inicio;
    public $fim;
    public $dia_semana;

    public function __construct() {
        $this->id = 0;
        $this->inicio = 8;
        $this->fim = 12;
        $this->dia_semana = 1;
    }

    public function merge($con) {

        if ($this->id === 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO expediente(inicio,fim,dia_semana) VALUES($this->inicio,$this->fim,$this->dia_semana)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE expediente SET inicio=$this->inicio, fim=$this->fim, dia_semana=$this->dia_semana WHERE id=$this->id");
            $ps->execute();
            $ps->close();
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("DELETE FROM expediente WHERE id=$this->id");
        $ps->execute();
        $ps->close();
    }

}
