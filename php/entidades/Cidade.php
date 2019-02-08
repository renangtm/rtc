<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cidade
 *
 * @author Renan
 */
class Cidade {
   
    public $id;
    public $nome;
    public $excluida;
    public $estado;
    
    function __construct() {
        
        $this->id = 0;
        $this->excluida = false;
        $this->estado = new Estado();
        
        
    }
    
    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO cidade(nome,id_estado,excluida) VALUES('" . addslashes($this->nome) . "',".$this->estado->id.",false)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE cidade SET nome = '" . addslashes($this->nome) . "', id_estado=".$this->estado->id.", excluida=false WHERE id = ".$this->id);
            $ps->execute();
            $ps->close();
            
        }
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("UPDATE cidade SET excluida = true WHERE id = ".$this->id);
        $ps->execute();
        $ps->close();
        
    }
    
}
