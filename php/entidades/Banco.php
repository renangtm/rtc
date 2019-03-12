<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CategoriaDocumento
 *
 * @author Renan
 */
class Banco {

    public $id;
    public $codigo;
    public $nome;
    public $conta;
    public $agencia;
    public $saldo;
    public $excluido;
    public $empresa;
    public $codigo_contimatic;

    function __construct() {

        $this->id = 0;
        $this->saldo = 0;
        $this->codigo = 0;
        $this->excluido = false;
        $this->codigo_contimatic = 0;
    }

    public function atualizaSaldo($con) {

        $ps = $con->getConexao()->prepare("SELECT saldo FROM banco WHERE id = $this->id");
        $ps->execute();
        $ps->bind_result($saldo);
        if ($ps->fetch()) {
            $this->saldo = $saldo;
        }
        $ps->close();
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO banco(nome,conta,saldo,excluido,id_empresa,codigo,agencia) VALUES('$this->nome','$this->conta',$this->saldo,false," . $this->empresa->id . ",$this->codigo,'" . addslashes($this->agencia) . "')");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE banco SET nome='$this->nome',conta='$this->conta',saldo=$this->saldo,excluido = false,codigo=$this->codigo, id_empresa=" . $this->empresa->id . ",agencia='" . addslashes($this->agencia) . "' WHERE id=$this->id");
            $ps->execute();
            $ps->close();
        }

        if ($this->codigo_contimatic > 0) {

            $ps = $con->getConexao()->prepare("UPDATE banco SET codigo_contimatic=$this->codigo_contimatic WHERE id=$this->id");
            $ps->execute();
            $ps->close();
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE banco SET excluido=true WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
