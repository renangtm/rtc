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

class testeCampanha extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $cat = new Campanha();
        
        $cat->prazo = 12;
        $cat->parcelas = 1;
        $cat->cliente_expression = "123";
        $cat->empresa = new stdClass();
        $cat->empresa->id=1;
        
        $cat->merge(new ConnectionFactory());
        
        $cat->merge(new ConnectionFactory());
        
        $cat->delete(new ConnectionFactory());
        
    }

}
