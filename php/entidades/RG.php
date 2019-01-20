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
class RG {
    
    public $valor;

    function __construct($str) {

        $this->valor = str_replace(array(".", "-"), array("", ""), $str);


        if (strlen($this->valor) != 9) {

            $this->valor = "00.000.000-0";
        } else {

            $this->valor = substr($this->valor, 0, 2) . "." . substr($this->valor, 2, 3) . "." . substr($this->valor, 5, 3) . "-" . substr($this->valor, 8, 1);
        }
    }
    
}
