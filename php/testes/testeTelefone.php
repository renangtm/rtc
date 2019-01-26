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

class testeTelefone extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $telefone = new Telefone("1234");
      
        $telefone->merge(new ConnectionFactory());
        
        $telefone->merge(new ConnectionFactory());
        
        $telefone->delete(new ConnectionFactory());
        
    }

}
