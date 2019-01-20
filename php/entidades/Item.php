<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Item
 *
 * @author Renan
 */
class Item {
    
    public $quantidade;
    public $filhos;
    public $quantidade_filhos;
    public $numero;
    public $removivel;
    public $pai;
    
    function __construct() {
        
        $this->filhos = array();
        $this->pai = null;
        
    }
    
}
