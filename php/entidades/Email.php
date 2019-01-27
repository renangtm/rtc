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
class Email {
    
    public $id;
    public $endereco;
    public $excluido;
    public $senha;
    
    function __construct($str="") {
        
        $this->id = 0;
        $this->endereco = $str;
        $this->excluido = false;
        
        if(!filter_var($str, FILTER_VALIDATE_EMAIL)){
            
            $this->endereco = "emailinvalido@invalido.com.br";
            
        }
        
    }
    
    public function enviarEmail($destino, $titulo, $conteudo){
        
        
        
    }
    
    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO email(endereco,excluido,senha) VALUES('" . addslashes($this->endereco) . "',false,'".addslashes($this->senha)."')");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE email SET endereco = '" . addslashes($this->endereco) . "', excluido = false, senha = '".addslashes($this->senha)."' WHERE id = ".$this->id);
            $ps->execute();
            $ps->close();
            
        }
        
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("UPDATE email SET excluido = true WHERE id = ".$this->id);
        $ps->execute();
        $ps->close();
        
    }
    
}
