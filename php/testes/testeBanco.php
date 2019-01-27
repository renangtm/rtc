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

class testeBanco extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $banco = new Banco();
        $banco->saldo = 123;
        $banco->empresa = Utilidades::getEmpresaTeste();
        $banco->nome = "Itau";
        $banco->conta = "dedede";
        
        $banco->merge(new ConnectionFactory());
   
        $banco->merge(new ConnectionFactory());
        
        $banco->atualizaSaldo(new ConnectionFactory());
        
        $banco->delete(new ConnectionFactory());
        
    }

}
