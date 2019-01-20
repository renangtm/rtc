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
       
        $it = new InterpretadorBooleano();
        
        $variaveis = new stdClass();
        
        $variaveis->valor = 5;
        $variaveis->peso = 20;
        $variaveis->teste='TESTE';
        $variaveis->cliente = new stdClass();
        $variaveis->cliente->cidade = "Teste";
        
        $it->setVariaveis($variaveis);
        
        $this->assertTrue($it->interpretar("!valor=5"));
        $this->assertTrue($it->interpretar("!peso=20"));
        $this->assertTrue($it->interpretar("!peso<21&!valor>4"));
        $this->assertFalse($it->interpretar("!peso>!valor&!valor=1"));
        $this->assertFalse($it->interpretar("'!teste'='TESE'"));
        $this->assertTrue($it->interpretar("'!teste'='TESTE'"));
        
        $this->assertFalse($it->interpretar("GRUPO['!cliente.cidade','Teste']"));
        
        $con = new ConnectionFactory();
        
        $grupo = new GrupoCidades();
        $grupo->nome = "Teste";
        
        $grupo->empresa = new stdClass();
        $grupo->empresa->id = 1;
        
        $cidades = Sistema::getCidades($con);
        
        $grupo->cidades = array($cidades[0],$cidades[1],$cidades[2],$cidades[3]);
        
        $grupo->merge($con);
        
        $this->assertFalse($it->interpretar("GRUPO['!cliente.cidade','Teste']"));
        
        $variaveis->cliente->cidade = $cidades[0]->nome;
        
        $this->assertTrue($it->interpretar("GRUPO['!cliente.cidade','Teste']"));
        
        $this->assertFalse($it->interpretar("GRUPO['!cliente.cidade','Teste']&!valor>!peso"));
        
        $grupo->delete($con);
        
        $this->assertFalse($it->interpretar("GRUPO['!cliente.cidade','Teste']"));
        
    }

}
