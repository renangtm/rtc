<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Email
 *
 * @author Renan
 */
class AtividadeUsuarioCliente {

    public $id;
    public $data_referente;
    public $pontos_atendimento;

    function __construct() {

        $this->id = 0;
        $this->data_referente = round(microtime(true)*1000);
        $this->pontos_atendimento = 0;
        
    }

    public function merge($con) {

        if ($this->id == 0) {
            
            $ps = $con->getConexao()->prepare("INSERT INTO usuario_atividade(data_referente,pontos_atendimento) VALUES(FROM_UNIXTIME($this->data_referente/1000),$this->pontos_atendimento)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        } else {

            $ps = $con->getConexao()->prepare("UPDATE usuario_atividade SET data_referente=FROM_UNIXTIME($this->data_referente/1000), pontos_atendimento=$this->pontos_atendimento WHERE id=$this->id");
            $ps->execute();
            $ps->close();
            
        }
        
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("DELETE FROM usuario_atividade WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
        
    }

}
