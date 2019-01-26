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
        
        $usuario = new Usuario();
        
        $usuario->nome = "Teste";
        $usuario->telefones[]= new Telefone("1234");
        $usuario->cpf = new CPF("11122233344455");
        $usuario->empresa = new stdClass();
        $usuario->empresa->id = 1;
        $usuario->login = "12344321";
        $usuario->senha = "1233";
        
        $e = new Endereco();
        
        $e->rua = "Rua Teste";
        $e->bairro = "Bairro Teste";
        $e->numero = 0;
        $e->cep = new CEP("07195201");
        $e->cidade = new stdClass();
        $e->cidade->id = 3;
        
        $usuario->endereco = $e;
        
        $usuario->email = new Email("teserewfdwefd");
        
        $usuario->permissoes = Sistema::getPermissoesIniciais();
        
        $usuario->merge(new ConnectionFactory());
        
        $usuario->merge(new ConnectionFactory());
        
        $usuario->delete(new ConnectionFactory());
        
    }

}
