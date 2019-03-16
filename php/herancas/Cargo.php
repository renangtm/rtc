<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegraTabela
 *
 * @author Renan
 */
class Cargo {

    public $id;
    public $nome;
    public $empresa;
    public $excluido;

    function __construct() {

        $this->id = 0;
        $this->nome = "";
        $this->empresa = null;
        $this->excluido = false;
        
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO cargo(nome,id_empresa,excluido) VALUES('".addslashes($this->nome)."',".$this->empresa->id.",false)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE cargo SET nome='".addslashes($this->nome)."',id_empresa=".$this->empresa->id.",excluido=false WHERE id=$this->id");
            $ps->execute();
            $ps->close();
            
        }
        
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("UPDATE cargo SET excluido=true WHERE id=$this->id");
        $ps->execute();
        $ps->close();
        
    }

}
