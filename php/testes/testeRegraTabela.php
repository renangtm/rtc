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
       
        $regra = new RegraTabela();
        
        $regra->condicional = "!valor>50&'!cliente.cidade'='TESTE'";
        $regra->resultante = "!valor+!peso*5";
        
        $regra->merge(new ConnectionFactory());
        
        $regra->merge(new ConnectionFactory());
        
        $regra->delete(new ConnectionFactory());
        
        $cidade = new stdClass();
        $cidade->nome = "TESTE";
        
        $this->assertTrue($regra->atende($cidade,5,100));
        
        $cidade->nome = "TEST";
        
        $this->assertFalse($regra->atende($cidade,5,100));
        
        $this->assertEquals($regra->valor($cidade,100,5),505);
        
        
    }

}
