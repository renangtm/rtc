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

class testeUsuario extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $fornecedor = new Usuario();
        
        $fornecedor->nome = "Teste";
        $fornecedor->telefone = "111111";
        $fornecedor->cpf = new CPF("11122233344455");
        $fornecedor->empresa = new stdClass();
        $fornecedor->empresa->id = 1;
        $fornecedor->login = "12344321";
        $fornecedor->senha = "1233";
        
        $e = new Endereco();
        
        $e->rua = "Rua Teste";
        $e->bairro = "Bairro Teste";
        $e->numero = 0;
        $e->cep = new CEP("07195201");
        $e->cidade = new stdClass();
        $e->cidade->id = 3;
        
        $fornecedor->endereco = $e;
        
        $fornecedor->email = new Email("teserewfdwefd");
        
        $fornecedor->permissoes = Sistema::getPermissoesIniciais();
        
        $fornecedor->merge(new ConnectionFactory());
        
        $fornecedor->merge(new ConnectionFactory());
        
        $fornecedor->delete(new ConnectionFactory());
        
    }

}
