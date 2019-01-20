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
class Cultura {
   
    public $id;
    public $nome;
    public $excluida;
    
    function __construct() {
        
        $this->id = 0;
        $this->excluida = false;
        
    }
    
    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO cultura(nome,excluida) VALUES('" . addslashes($this->nome) . "',false)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE cultura SET nome = '" . addslashes($this->nome) . "', excluida=false WHERE id = ".$this->id);
            $ps->execute();
            $ps->close();
            
        }
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("UPDATE cultura SET excluida = true WHERE id = ".$this->id);
        $ps->execute();
        $ps->close();
        
    }
    
}
