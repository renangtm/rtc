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
class Contato {

    public $id;
    public $data;
    public $descricao;
    public $relacao;

    function __construct() {

        $this->id = 0;
        $this->data = round(microtime(true)*1000);
        $this->descricao = "";
        $this->relacao = null;
        
    }

    public function merge($con) {
        
        if ($this->id == 0) {
            
            

            $ps = $con->getConexao()->prepare("INSERT INTO contato(id_relacao,data,descricao) VALUES(".$this->relacao->id.",FROM_UNIXTIME($this->data/1000),'$this->descricao')");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE contato SET id_relacao=".$this->relacao->id.",data=FROM_UNIXTIME($this->data/1000),descricao='$this->descricao' WHERE id = ".$this->id);
            $ps->execute();
            $ps->close();
            
        }
        
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("DELETE FROM contato WHERE id = ".$this->id);
        $ps->execute();
        $ps->close();
        
    }

}
