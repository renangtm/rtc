<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Documento
 *
 * @author Renan
 */
class Documento {
   
    public $id;
    public $data_insercao;
    public $categoria;
    public $link;
    public $excluido;
    
    function __construct() {
        $this->id=0;
        $this->categoria = null;
        $this->excluido = false;
        $this->data_insercao = round(microtime(true)*1000);
    }
    
    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO documento(data_insercao,id_categoria,numero,link,excluido) VALUES(FROM_UNIXTIME($this->data_insercao/1000)," . $this->categoria->id . ",'".$this->numero."','".addslashes($this->link)."',false)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE documento SET data_insercao = FROM_UNIXTIME($this->data_insercao/1000), id_categoria = " . $this->categoria->id . ", numero = '$this->numero', link='".addslashes($this->link)."', excluido=false WHERE id = ".$this->id);
            $ps->execute();
            $ps->close();
            
        }
        
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("UPDATE documento SET excluido=true WHERE id = ".$this->id);
        $ps->execute();
        $ps->close();
        
    }
    
}
