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

class testeVencimento extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $ven = new Vencimento();
        $ven->valor = 123;
        $ven->nota = new stdClass();
        $ven->nota->id = 1;
        
        $ven->merge(new ConnectionFactory());
   
        $ven->merge(new ConnectionFactory());
        
        $ven->delete(new ConnectionFactory());
        
    }

}
