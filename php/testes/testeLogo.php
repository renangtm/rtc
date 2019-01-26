<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of testeConnectionFactory
 *
 * @author Renan
 */

include('includes.php');

class testeLogo extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $logo = new Logo();
        $logo->logo = Utilidades::base64encode("LOGO INVALIDO");
        $logo->cor_predominante = "255,255,255";
        $logo->empresa = new stdClass();
        $logo->empresa->id = 1;
        
        $logo->merge(new ConnectionFactory());
   
        $logo->merge(new ConnectionFactory());
        
        $logo->delete(new ConnectionFactory());
        
    }

}
