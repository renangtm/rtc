<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cidade
 *
 * @author Renan
 */
class Campanha {
   
    public $id;
    public $inicio;
    public $fim;
    public $prazo;
    public $parcelas;
    public $excluida;
    public $cliente_expression;
    public $empresa;
    public $produtos;
    public $nome;
    
    function __construct() {
        
        $this->id = 0;
        $this->inicio = round(microtime(true)*1000);
        $this->fim = round(microtime(true)*1000);
        $this->excluida = false;
        $this->empresa = null;
        $this->cliente_expression = "*";
        $this->produtos = array();
        $this->prazo = 0;
        $this->parcelas = 0;
        
    }
    
    public function getReduzida(){
        
        $c = new CampanhaReduzida();
        $c->id = $this->id;
        $c->parcelas = $this->parcelas;
        $c->cliente_expression= $this->cliente_expression;
        $c->empresa = $this->empresa;
        $c->prazo = $this->prazo;
        $c->parcelas = $this->parcelas;
        $c->nome = $this->nome;
        $c->inicio = $this->inicio;
        $c->fim = $this->fim;
        
        return $c;
        
    }
    
    public function merge($con,$block = false) {
        
        if($this->empresa->tipo_empresa === 3 && !$block){
            
            $campanhas = array();
            $empresas = array();
            
            foreach($this->produtos as $key=>$value){
                
                if(!isset($campanhas[$value->produto->empresa->id])){
                    
                    $campanhas[$value->produto->empresa->id] = array();
                    $empresas[$value->produto->empresa->id] = $value->produto->empresa;
                    
                }
                
                $campanhas[$value->produto->empresa->id][] = Utilidades::copy($value);
                
            }
            
            foreach($campanhas as $key=>$value){
                
                $campanha = Utilidades::copyId0($this);
                $campanha->produtos = $value;
                $campanha->empresa =  $empresas[$key];
                
                foreach($campanha->produtos as $key2=>$produtos2){
                    $produtos2->campanha = $campanha; 
                }
                
                $campanha->merge($con,true);
                
            }
            
            return;
            
        }

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO campanha(inicio,fim,prazo,parcelas,excluida,cliente_expression,id_empresa,nome) VALUES(FROM_UNIXTIME($this->inicio/1000),FROM_UNIXTIME($this->fim/1000),$this->prazo,$this->parcelas,false,'$this->cliente_expression',".$this->empresa->id.",'".addslashes($this->nome)."')");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE campanha SET inicio = FROM_UNIXTIME($this->inicio/1000), fim = FROM_UNIXTIME($this->fim/1000), excluida=false, prazo=$this->prazo,parcelas=$this->parcelas,cliente_expression='$this->cliente_expression',id_empresa=".$this->empresa->id.",nome='".addslashes($this->nome)."' WHERE id = ".$this->id);
            $ps->execute();
            $ps->close();
            
        }
        
        $ps = $con->getConexao()->prepare("UPDATE produto_campanha SET id_campanha=0 WHERE id_campanha=$this->id");
        $ps->execute();
        $ps->close();
        
        foreach($this->produtos as $key=>$value){
   
               $value->merge($con);
            
        }
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("UPDATE campanha SET excluida = true WHERE id = ".$this->id);
        $ps->execute();
        $ps->close();
        
    }
    
}
