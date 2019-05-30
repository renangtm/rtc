<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CotacaoEntrada
 *
 * @author Renan
 */
class GrauProduto {

    public $nivel;
    public $nome;
    
    function __construct($nivel = 0,$nome  = "") {

        $this->nivel = $nivel;
        $this->nome = $nome;
        
    }

}
