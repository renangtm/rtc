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
class Vencimento {
   
    public $id;
    public $valor;
    public $data;
    public $nota;
    public $movimento;
    
    function __construct() {
        
        $this->id = 0;
        $this->valor= 0;
        $this->data = round(microtime(true)*1000);
        $this->nota = null;
        $this->movimento = null;
        
    }
    
    public function merge($con) {

        if ($this->id == 0) {
            
            $ps = $con->getConexao()->prepare("INSERT INTO vencimento(valor,data,id_nota,id_movimento) VALUES($this->valor,FROM_UNIXTIME($this->data/1000),".$this->nota->id.",".($this->movimento!=null?$this->movimento->id:0).")");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE vencimento SET valor=$this->valor,data=FROM_UNIXTIME($this->data/1000),id_nota=".$this->nota->id.",id_movimento=".($this->movimento!=null?$this->movimento->id:0)." WHERE id = $this->id");
            $ps->execute();
            $ps->close();
            
        }
        
        if($this->movimento != null){
            
            $this->movimento->insert($con);
            
        }
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("DELETE FROM vencimento WHERE id = ".$this->id);
        $ps->execute();
        $ps->close();
        
        if($this->movimento != null){
            
            $this->movimento->delete($con);
            
        }
        
    }
    
}
