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

class testeFornecedor extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $fornecedor = new Fornecedor();
        
        $fornecedor->nome = "Teste";
        $fornecedor->telefones[] = new Telefone("111111");
        $fornecedor->cnpj = new CNPJ("11122233344455");
        $fornecedor->empresa = new stdClass();
        $fornecedor->empresa->id = 1;
        
        $e = new Endereco();
        
        $e->rua = "Rua Teste";
        $e->bairro = "Bairro Teste";
        $e->numero = 0;
        $e->cep = new CEP("07195201");
        $e->cidade = new stdClass();
        $e->cidade->id = 3;
        
        $fornecedor->endereco = $e;
        
        $fornecedor->email = new Email("teserewfdwefd");
        
        
        $fornecedor->merge(new ConnectionFactory());
        
        $fornecedor->merge(new ConnectionFactory());
        
        $fornecedor->delete(new ConnectionFactory());
        
    }

}
