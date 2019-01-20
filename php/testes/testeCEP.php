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

class testeCEP extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $cnpj = new CEP("1234");
       
        $this->assertEquals($cnpj->valor,"00000-000");
        
        $cnpj = new CEP("12345-111");
        
        $this->assertEquals($cnpj->valor,"12345-111");
        
        $cnpj = new CEP("12345111");
        
        $this->assertEquals($cnpj->valor,"12345-111");
        
    }

}
