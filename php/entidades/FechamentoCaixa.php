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
class FechamentoCaixa{

    public $id;
    public $valor;
    public $banco;
    public $data;

    function __construct() {

        $this->id = 0;
        $this->valor = 0;
        $this->banco = null;
        $this->data = round(microtime(true)*1000);
        
    }

    public function merge($con) {
        
        if($this->id === 0){
        
            $ps = $con->getConexao()->prepare("INSERT INTO fechamento_caixa(valor,id_banco,data) VALUES($this->valor,".$this->banco->id.",FROM_UNIXTIME($this->data/1000))");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE fechamento_caixa SET valor=$this->valor,id_banco=".$this->banco->id.",data=FROM_UNIXTIME($this->data/1000) WHERE id=$this->id");
            $ps->execute();
            $ps->close();
            
        }
    }

    public function delete($con) {
        
        $ps = $con->getConexao()->prepare("DELETE fechamento_caixa WHERE id=$this->id");
        $ps->execute();
        $ps->close();
        
    }

}
