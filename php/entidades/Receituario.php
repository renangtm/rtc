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
class Receituario {
   
    public $id;
    public $excluido;
    public $instrucoes;
    public $produto;
    public $cultura;
    public $praga;
    
    function __construct() {
        
        $this->id = 0;
        $this->excluido = false;
        $this->produto = null;
        $this->cultura = null;
        $this->praga = null;
        
    }
    
    public function merge($con) {

        $this->cultura->merge($con);
        $this->praga->merge($con);
        
        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO receituario(instrucoes,excluido,id_produto,id_praga,id_cultura) VALUES('" . addslashes($this->instrucoes) . "',false,".$this->produto->id.",".$this->praga->id.",".$this->cultura->id.")");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE receituario SET instrucoes = '" . addslashes($this->instrucoes) . "', excluido=false, id_cultura=".$this->cultura->id.", id_praga=".$this->praga->id.", id_produto=".$this->produto->id." WHERE id = ".$this->id);
            $ps->execute();
            $ps->close();
            
        }
        
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("UPDATE receituario SET excluido = true WHERE id = ".$this->id);
        $ps->execute();
        $ps->close();
        
    }
    
}
