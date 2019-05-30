<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CotacaoEntrada
 *
 * @author Renan
 */
class UsuarioTipoTarefa {

    public $id;
    public $tipo_tarefa;
    public $importancia;
    public $usuario;
    
    public function __construct() {
        
        $this->id = 0;
        $this->tipo_tarefa = null;
        $this->importancia = 0;
        $this->usuario = null;
        
    }
    
    public function merge($con){
        
        if($this->id === 0){
        
            $ps = $con->getConexao()->prepare("INSERT INTO tipo_tarefa_usuario(id_tipo_tarefa,id_usuario,importancia) VALUES(".$this->tipo_tarefa->id.",".$this->usuario->id.",$this->importancia)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE tipo_tarefa_usuario SET id_tipo_tarefa=".$this->tipo->id.", id_usuario=".$this->usuario->id.",importancia=$this->importancia WHERE id=$this->id");
            $ps->execute();
            $ps->close();
            
        }
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("DELETE FROM tipo_tarefa_usuario WHERE id=$this->id");
        $ps->execute();
        $ps->close();
        
    }

}
