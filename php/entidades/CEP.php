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
class CEP {

    public $valor;

    function __construct($str = "") {

        $this->valor = str_replace(array("-"), array(""), $str);


        if (strlen($this->valor) != 8) {

            $this->valor = "00000-000";
        } else {

            $this->valor = substr($this->valor, 0, 5) . "-" . substr($this->valor, 5, 3);
        }
    }
    
    public function getEnderecoViaService(){
        
        return null;
        
    }

}
