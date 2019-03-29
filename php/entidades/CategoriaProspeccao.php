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
class CategoriaProspeccao {

    public $id;
    public $nome;

    function __construct() {

        $this->id = 0;
        $this->nome = "";
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO categoria_prospeccao(nome) VALUES('" . addslashes($this->nome). "')");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE categoria_prospeccao SET nome = '" . addslashes($this->nome) . "' WHERE id = ".$this->id);
            $ps->execute();
            $ps->close();
            
        }
        
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("DELETE FROM categoria_prospeccao WHERE id = ".$this->id);
        $ps->execute();
        $ps->close();
        
    }

}
