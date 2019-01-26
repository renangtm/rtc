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

class testeParametrosEmissao extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $parametros = new ParametrosEmissao();
        $parametros->registro = "123";
        $parametros->saldo = 123;
        $parametros->empresa = new stdClass();
        $parametros->empresa->id = 1;
        $parametros->certificado = Utilidades::base64encode("TESTE CERTIFICADO INVALIDO");
        $parametros->senha_certificado = "123456";
        
        $parametros->merge(new ConnectionFactory());
   
        $parametros->merge(new ConnectionFactory());
        
        $parametros->delete(new ConnectionFactory());
        
    }

}
