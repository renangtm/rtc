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
class Telefone {
    
    public $id;
    public $numero;
    public $excluido;
    
    function __construct($str="") {
        
        $this->id = 0;
        $this->numero = $str;
        $this->excluido = false;
        
        
        
        if(strpos($this->numero, "-") === false){
            $ddd = "";
            $num = "";
            if(strlen($str) <= 9){
                $num  = substr($str,0,ceil(strlen($str)/2));
                $num  .=  "-".substr($str,ceil(strlen($str)/2),strlen($str));
            }else{
                $ddd= "(".substr($str,0,2).")";
                $str = substr($str,2);
                $num  = substr($str,0,ceil(strlen($str)/2));
                $num .= "-".substr($str,ceil(strlen($str)/2),strlen($str));
            }
            $this->numero = $ddd.$num;
        }
        
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO telefone(numero,excluido) VALUES('" . addslashes($this->numero) . "',false)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE telefone SET numero = '" . addslashes($this->numero) . "', excluido = false WHERE id = ".$this->id);
            $ps->execute();
            $ps->close();
            
        }
        
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("UPDATE telefone SET excluido = true WHERE id = ".$this->id);
        $ps->execute();
        $ps->close();
        
    }
    
}
