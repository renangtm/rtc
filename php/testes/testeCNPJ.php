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

class testeCNPJ extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $cnpj = new CNPJ("1234");
       
        $this->assertEquals($cnpj->valor,"00.000.000/0000-00");
        
        $cnpj = new CNPJ("12.123.123/1111-11");
        
        $this->assertEquals($cnpj->valor,"12.123.123/1111-11");
        
        $cnpj = new CNPJ("12.123.1231111-11");
        
        $this->assertEquals($cnpj->valor,"12.123.123/1111-11");
        
    }

}
