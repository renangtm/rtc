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

class testeEmpresa extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $empresa = new Empresa();
        
        $empresa->nome = "Teste";
        $empresa->cnpj = new CNPJ("11122233344455");
        $empresa->inscricao_estadual = "1234412";
        
        $e = new Endereco();
        
        $e->rua = "Rua Teste";
        $e->bairro = "Bairro Teste";
        $e->numero = 0;
        $e->cep = new CEP("07195201");
        $e->cidade = new stdClass();
        $e->cidade->id = 3;
        
        $empresa->endereco = $e;
        
        $empresa->email = new Email("teserewfdwefd");
        
        $empresa->telefone = new Telefone("t1241243");
        
        
        $empresa->merge(new ConnectionFactory());
        
        $empresa->merge(new ConnectionFactory());
        
        $empresa->delete(new ConnectionFactory());
        
    }

}
