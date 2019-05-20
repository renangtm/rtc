<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RG
 *
 * @author Renan
 */
class AprovacaoConsignado {
    
    public $id;
    public $empresa;
    public $produto;
    public $aprovado_sob;
    public $momento;
    public $valor;
    public $ate;

    function __construct() {

    	$this->id = 0;
    	$this->empresa = null;
    	$this->produto = null;
    	$this->aprovado_sob = 0;
    	$this->momento = round(microtime(true)*1000);
    	$this->valor = 0;
    	$this->ate = round(microtime(true)*1000)+7*24*60*60*1000;

    }

    public function merge($con){

    	if($this->id === 0){


    		$ps = $con->getConexao()->prepare("INSERT INTO aprovacao_consignado(id_produto,id_empresa,momento,valor,aprovado_sob,ate) VALUES(".$this->produto->id.",".$this->empresa->id.",FROM_UNIXTIME($this->momento/1000),$this->valor,$this->aprovado_sob,FROM_UNIXTIME($this->ate/1000))");
    		$ps->execute();
    		$this->id = $ps->insert_id;
    		$ps->close();

    	}else{

    		$ps = $con->getConexao()->prepare("UPDATE aprovacao_consignado SET id_produto=".$this->produto->id.",id_empresa=".$this->empresa->id.",momento=FROM_UNIXTIME($this->momento/1000),valor=$this->valor,aprovado_sob=$this->aprovado_sob,ate=FROM_UNIXTIME($this->ate/1000) WHERE id=$this->id");
    		$ps->execute();
    		$ps->close();

    	}


    }

    public function delete($con){

   		$ps = $con->getConexao()->prepare("DELETE FROM aprovacao_consignado WHERE id=$this->id");
   		$ps->execute();
   		$ps->close();

    }
    
}
