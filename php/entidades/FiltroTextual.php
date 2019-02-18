<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FiltroTextual
 *
 * @author T-Gamer
 */
class FiltroTextual {
    
    public $id;
    public $nome;
    public $valor;
    public $atributos;
    
    function __construct($id,$nome,$atributos){
        
        $this->id = $id;
        $this->nome = $nome;
        $this->valor = "";
        $this->atributos = $atributos;
        
    }
    
    public function ok($obj){
        if($this->valor !== ""){
            foreach($this->atributos as $key=>$atributo){
                if(strpos(strtoupper(Utilidades::getAttr($obj, $atributo)), strtoupper($this->valor)) !== false){
                    return true;
                }
            }
            return false;
        }else{
            return true;
        }
    }
    
    
}
