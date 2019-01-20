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

class testeInterpretadorNumerico extends PHPUnit_Framework_TestCase {

    public function testSimple() {
       
        $it = new InterpretadorNumerico();
        
        $variaveis = new stdClass();
        
        $variaveis->valor = 5;
        $variaveis->peso = 20;
        
        $it->setVariaveis($variaveis);
        
        $this->assertEquals($it->interpretar("MAX[!peso*!valor,!valor+!peso]"),100);
        $this->assertEquals($it->interpretar("MIN[!peso*!valor,!valor+!peso]"),25);
        $this->assertEquals($it->interpretar("BAIXO[(!peso+1)/!valor]"),4);
        $this->assertEquals($it->interpretar("CIMA[(!peso+1)/!valor]"),5);
        
    }

}
