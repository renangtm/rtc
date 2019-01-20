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
        
        $cnpj = new RG("1234");
       
        $this->assertEquals($cnpj->valor,"00.000.000-0");
        
        $cnpj = new RG("12.231.231-1");
        
        $this->assertEquals($cnpj->valor,"12.231.231-1");
        
        $cnpj = new RG("111.22-2345");
        
        $this->assertEquals($cnpj->valor,"11.122.234-5");
        
    }

}
