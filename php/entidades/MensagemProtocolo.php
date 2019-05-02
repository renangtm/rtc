<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Fornecedor
 *
 * @author Renan
 */
class MensagemProtocolo {

    public $id;
    public $mensagem;
    public $momento;
    public $dados_usuario;
    public $protocolo;

    public function __construct() {

        $this->id = 0;
        $this->mensagem = "";
        $this->dados_usuario = "";
        $this->momento = round(microtime(true) * 1000);
        $this->protocolo = null;
    }

    public function merge($con) {

        if ($this->id === 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO mensagem_protocolo(mensagem,dados_usuario,momento,id_protocolo) VALUES('" . addslashes($this->mensagem) . "','" . addslashes($this->dados_usuario) . "',FROM_UNIXTIME($this->momento/1000)," . $this->protocolo->id . ")");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE mensagem_protocolo SET mensagem = '" . addslashes($this->mensagem) . "', dados_usuario='" . addslashes($this->dados_usuario) . "',momento=FROM_UNIXTIME($this->momento/1000),id_protocolo=" . $this->protocolo->id . " WHERE id=$this->id");
            $ps->execute();
            $ps->close();
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("DELETE FROM mensagem_protocolo WHERE id=$this->id");
        $ps->execute();
        $ps->close();
    }

}
