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

class testeConnectionFactory extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $cnpj = new CPF("1234");
       
        $this->assertEquals($cnpj->valor,"000.000.000-00");
        
        $cnpj = new CPF("121.231.231-11");
        
        $this->assertEquals($cnpj->valor,"121.231.231-11");
        
        $cnpj = new CPF("121.23123111");
        
        $this->assertEquals($cnpj->valor,"121.231.231-11");
        
    }

}
