<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Endereco
 *
 * @author Renan
 */
class Endereco {
    
    public $id;
    public $rua;
    public $bairro;
    public $numero;
    public $cep;
    public $cidade;
    
    function __construct() {
        
        $this->id = 0;
        $this->cidade = null;
        $this->cep = new CEP("");
        
    }
    
   public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO endereco(rua,numero,bairro,cep,id_cidade) VALUES('" . addslashes($this->rua) . "',".$this->numero.",'".$this->bairro."','".$this->cep->valor."',".$this->cidade->id.")");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE endereco SET rua = '" . addslashes($this->rua) . "', numero=".$this->numero.", bairro='".$this->bairro."',cep='".$this->cep->valor."', id_cidade=".$this->cidade->id." WHERE id = ".$this->id);
            $ps->execute();
            $ps->close();
            
        }
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("DELETE FROM endereco WHERE id = ".$this->id);
        $ps->execute();
        $ps->close();
        
    }
    
    
}
