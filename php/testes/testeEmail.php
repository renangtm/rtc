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

class testeEmail extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $email = new Email("1234");
        $email->senha = "teste";
       
        $this->assertEquals($email->endereco,"emailinvalido@invalido.com.br");
        
        $email = new Email("renan.miranda@agrofauna.com.br");
        $email->senha = "teste";
        
        $this->assertEquals($email->endereco,"renan.miranda@agrofauna.com.br");
        
        $email->merge(new ConnectionFactory());
        
        $email->merge(new ConnectionFactory());
        
        $email->delete(new ConnectionFactory());
        
    }

}
