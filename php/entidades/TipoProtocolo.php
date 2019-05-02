<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tabela
 *
 * @author Renan
 */
class TipoProtocolo {

    public $id;
    public $nome;
    public $prioridade;

    function __construct() {

        $this->id = 0;
        $this->nome = "";
        $this->prioridade = 0;
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO tipo_protocolo(nome,prioridade) VALUES('".addslashes($this->nome)."',$this->prioridade)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE tipo_protocolo SET nome = '" . addslashes($this->nome) . "', prioridade=$this->prioridade WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();
        }

    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE tipo_protocolo SET excluido=true WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();

    }

}
