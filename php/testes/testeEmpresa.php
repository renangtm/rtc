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
        
        
        $empresa2 = new Empresa();
        
        $empresa2->nome = "Teste";
        $empresa2->cnpj = new CNPJ("11122233344455");
        $empresa2->inscricao_estadual = "1234412";
        
        $e = new Endereco();
        
        $e->rua = "Rua Teste";
        $e->bairro = "Bairro Teste";
        $e->numero = 0;
        $e->cep = new CEP("07195201");
        $e->cidade = new stdClass();
        $e->cidade->id = 3;
        
        $empresa2->endereco = $e;
        
        $empresa2->email = new Email("teserewfdwefd");
        
        $empresa2->telefone = new Telefone("t1241243");
        
        $empresa2->merge(new ConnectionFactory());
        
        $empresa2->merge(new ConnectionFactory());
       
        $empresa3 = new Empresa();
        
        $empresa3->nome = "Teste";
        $empresa3->cnpj = new CNPJ("11122233344455");
        $empresa3->inscricao_estadual = "1234412";
        
        $e = new Endereco();
        
        $e->rua = "Rua Teste";
        $e->bairro = "Bairro Teste";
        $e->numero = 0;
        $e->cep = new CEP("07195201");
        $e->cidade = new stdClass();
        $e->cidade->id = 3;
        
        $empresa3->endereco = $e;
        
        $empresa3->email = new Email("teserewfdwefd");
        
        $empresa3->telefone = new Telefone("t1241243");
        
        $empresa3->merge(new ConnectionFactory());
        
        $empresa3->merge(new ConnectionFactory());
        
        Sistema::relacionarFilial($empresa, $empresa2);
        Sistema::relacionarFilial($empresa2, $empresa3);
        
        $filiais = $empresa->getFiliais(new ConnectionFactory());

        $this->assertEquals(count($filiais),2);
        
        $this->assertEquals($filiais[0]->id, $empresa2->id);
        $this->assertEquals($filiais[1]->id, $empresa3->id);
        
        $filiais = $empresa2->getFiliais(new ConnectionFactory());
        
        $this->assertEquals(count($filiais),2);
        
        $this->assertEquals($filiais[0]->id, $empresa->id);
        $this->assertEquals($filiais[1]->id, $empresa3->id);
        
        $filiais = $empresa3->getFiliais(new ConnectionFactory());
        
        $this->assertEquals(count($filiais),2);
        
        $this->assertEquals($filiais[0]->id, $empresa->id);
        $this->assertEquals($filiais[1]->id, $empresa2->id);
        
        
    }

}
