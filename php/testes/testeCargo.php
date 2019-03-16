<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InterpretadorNumerico
 *
 * @author Renan
 */

include("includes.php");

class testeInterpretadorBooleano extends PHPUnit_Framework_TestCase {

    public function testSimple() {
       
        $con = new ConnectionFactory();
        
        $cargo = new Cargo();
        
        $cargo->empresa = new stdClass();
        $cargo->empresa->id = 1;
        
        $cargo->nome = "teste";
        
        $cargo->merge($con);
        $cargo->delete($con);
        
    }

}
