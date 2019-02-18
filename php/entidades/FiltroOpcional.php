<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FiltroOpcional
 *
 * @author T-Gamer
 */
class FiltroOpcional {

    public $id;
    public $nome;
    public $opcoes;
    public $atributo;

    function __construct($id, $nome,$atributo) {

        $this->id = $id;
        $this->nome = $nome;
        $this->opcoes = array();
        $this->atributo = $atributo;
    }

    public function getOpcao($id) {

        foreach ($this->opcoes as $key => $value) {
            if ($value->id === $id) {
                return $value;
            }
        }
        return null;
    }

    public function existOpcao($id) {

        foreach ($this->opcoes as $key => $value) {
            if ($value->id === $id) {
                return $value;
            }
        }
        return null;
    }

    public function ok($obj){
        
        $attr = Utilidades::getAttr($obj, $this->atributo);
        
        foreach($this->opcoes as $key=>$value){
            if(!$value->ok($attr)){
                return false;
            }
        }
        
    
        return true;
        
    }
    
}
