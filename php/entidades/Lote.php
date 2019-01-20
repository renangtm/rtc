<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Fornecedor
 *
 * @author Renan
 */
class Lote {
    
    public $id;
    public $validade;
    public $data_entrada;
    public $grade;
    public $quantidade_inicial;
    public $excluido;
    public $produto;
    public $quantidade_real;
    public $retiradas;
    public $codigo_fabricante;
    
    function __construct() {
        
        $this->id = 0;
        $this->validade = round(microtime(true)*1000);
        $this->data_entrada = round(microtime(true)*1000);
        $this->excluido = false;
        $this->grade = new Grade("1");
        $this->retiradas = array();
        
    }
    
    public function getItem(){
        
        return $this->grade->fractalizar($this->quantidade_inicial,$this->retiradas);
        
    }
    
    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO lote(validade,data_entrada,id_produto,grade,excluido,quantidade_inicial,quantidade_real,codigo_fabricante) VALUES(FROM_UNIXTIME(" . $this->validade . "/1000), FROM_UNIXTIME(".$this->data_entrada."/1000),".$this->produto->id.",'".$this->grade->str."',false,$this->quantidade_inicial,$this->quantidade_real,'".addslashes($this->codigo_fabricante)."')");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE lote SET validade = FROM_UNIXTIME(" .$this->validade. "/1000), data_entrada=FROM_UNIXTIME(".$this->cnpj->valor."/1000), id_produto=".$this->produto->id.",grade='".$this->grade->str."', excluido=false, quantidade_inicial=$this->quantidade_inicial, quantidade_real=$this->quantidade_real, codigo_fabricante='".addslashes($this->codigo_fabricante)."' WHERE id = ".$this->id);
            $ps->execute();
            $ps->close();
            
        }
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("UPDATE lote SET excluido = true WHERE id = ".$this->id);
        $ps->execute();
        $ps->close();
        
    }
    
    
    
}
