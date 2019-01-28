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
class Operacao {

    public $id;
    public $nome;
    public $excluida;
    public $debito;
    
    function __construct() {

        $this->id = 0;
        $this->debito = true;
        $this->excluida = false;
        
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO operacao(nome,excluida,debito) VALUES('" . addslashes($this->nome) . "',false,".($this->debito?"true":"false").")");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE operacao SET nome = '" . addslashes($this->nome) . "', excluida = false,debito=".($this->debito?"true":"false")." WHERE id = ".$this->id);
            $ps->execute();
            $ps->close();
            
        }
        
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("UPDATE operacao SET excluida = true WHERE id = ".$this->id);
        $ps->execute();
        $ps->close();
        
    }

}
