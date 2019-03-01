<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Estado
 *
 * @author Renan
 */
class Estado {

    public $id;
    public $sigla;
    public $excluido;
    
    function __construct() {

        $this->id = 0;
        $this->excluido = false;
        $this->sigla = "SP";
        
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO estado(sigla,excluido) VALUES('" . addslashes($this->sigla) . "',false)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE estado SET sigla = '" . addslashes($this->sigla) . "', excluido = false WHERE id = ".$this->id);
            $ps->execute();
            $ps->close();
            
        }
        
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("UPDATE estado SET excluido = true WHERE id = ".$this->id);
        $ps->execute();
        $ps->close();
        
    }

}
