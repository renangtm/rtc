<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Permissao
 *
 * @author Renan
 */
class Permissao {
    
    public $id;
    public $nome;
    public $in;
    public $del;
    public $alt;
    public $cons;
    
    function __construct($id=0,$nome="",$in=false,$del=false,$alt=false,$cons=false){
        
        $this->id = $id;
        $this->nome = $nome;
        $this->in = $in;
        $this->del = $del;
        $this->alt = $alt;
        $this->cons = $cons;
        
    }
    
}
