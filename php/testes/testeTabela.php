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

class testeTabela extends PHPUnit_Framework_TestCase {

    public function testSimple() {

        $regra = new RegraTabela();

        $regra->condicional = "!valor>50&'!cliente.cidade'='TESTE'";
        $regra->resultante = "!valor+!peso*5";

        $regra2 = new RegraTabela();

        $regra2->condicional = "!valor>40&!valor<50&'!cliente.cidade'='TESTE'";
        $regra2->resultante = "!valor+!peso*4";



        $cidade = new stdClass();
        $cidade->nome = "TESTE";

        $cidade2 = new stdClass();
        $cidade2->nome = "TEST";


        $tabela = new Tabela();

        $tabela->nome = "teste unitario";
        $tabela->regras = array($regra, $regra2);

        $tabela->merge(new ConnectionFactory());
        
        $tabela->merge(new ConnectionFactory());

        $tabela->delete(new ConnectionFactory());

        $this->assertTrue($tabela->atende($cidade, 10, 45));
        $this->assertTrue($tabela->atende($cidade, 10, 55));
        $this->assertFalse($tabela->atende($cidade, 10, 30));
        $this->assertFalse($tabela->atende($cidade2, 10, 55));

        $this->assertEquals($tabela->atende($cidade, 10, 45), 85);
        $this->assertEquals($tabela->atende($cidade2, 10, 45), 0);

        $this->assertEquals($tabela->atende($cidade, 10, 55), 105);
    }

}
