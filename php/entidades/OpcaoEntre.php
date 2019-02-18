<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Opcao
 *
 * @author T-Gamer
 */
class OpcaoEntre {
    
    public $id;
    public $nome;
    public $quantidade;
    public $selecionada;
    public $i;
    public $f;
    
    function __construct($id,$i,$f,$selecionada=0){
        
        $this->id = $id;
        $this->nome = "Entre $i e $f";
        $this->selecionada = 0;
        $this->quantidade = 1;
        $this->i = $i;
        $this->f = $f;
        
    }
    
    public function ok($valor){
        
        if($this->selecionada == 1){
            
            return ($valor>$this->i && $valor<$this->f);
            
        }else if($this->selecionada == 2){
            
            return !($valor>$this->i && $valor<$this->f);
            
        }
        
        return true;
        
    }
    
}
