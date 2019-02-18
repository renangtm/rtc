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
class OpcaoEquals {
    
    public $id;
    public $nome;
    public $quantidade;
    public $selecionada;
    
    function __construct($id,$nome,$selecionada=0){
        
        $this->id = $id;
        $this->nome = $nome;
        $this->selecionada = $selecionada;
        $this->quantidade = 1;
        
    }
    
    public function ok($valor){

        if($this->selecionada == 1){
            if($valor !== $this->nome){
                return false;
            }
        }else if($this->selecionada == 2){
            if($valor === $this->nome){
                return false;
            }
        }
        
        return true;
        
    }
    
}
