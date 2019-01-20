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
class CPF {

    public $valor;

    function __construct($str) {

        $this->valor = str_replace(array(".", "-"), array("", ""), $str);


        if (strlen($this->valor) != 11) {

            $this->valor = "000.000.000-00";
        } else {

            $this->valor = substr($this->valor, 0, 3) . "." . substr($this->valor, 3, 3) . "." . substr($this->valor, 6, 3) . "-" . substr($this->valor, 9, 2);
        }
    }

}
