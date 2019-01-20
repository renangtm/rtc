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

class testeTransportadora extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $doc = new Documento();
        
        $doc->categoria = Sistema::getCategoriaDocumentos()[0];
        
        $doc->numero = "erfqwerewq";
        
        $doc->link = "dfdwerferwfffffff";
        
        
        $doc2 = new Documento();
        
        $doc2->categoria = Sistema::getCategoriaDocumentos()[1];
        
        $doc2->numero = "12344321";
        
        $doc2->link = "12344321";
        
       
        $cliente = new Transportadora();
        $cliente->razao_social = "T1";
        $cliente->nome_fantasia = "T2";
        $cliente->cnpj = new CNPJ("11111111111111");
        $cliente->empresa = new stdClass();
        $cliente->empresa->id = 1;
        $cliente->email = new Email("renan_goncalves@outlook.com.br");
        $cliente->despacho = 999;
        $cliente->habilitada = true;
        $cliente->telefone="1234";
        $cliente->inscricao_estadual = "333333333";

        
        $e = new Endereco();
        
        $e->rua = "Rua Teste";
        $e->bairro = "Bairro Teste";
        $e->numero = 0;
        $e->cep = new CEP("07195201");
        $e->cidade = Sistema::getCidades(new ConnectionFactory())[0];
        
        $cliente->endereco = $e;
        
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
        
        $cliente->tabela = $tabela;
        
        $cliente->merge(new ConnectionFactory());
        
        $cliente->merge(new ConnectionFactory());
        
        $cliente->setDocumentos(array($doc,$doc2),new ConnectionFactory());
        
        $nd = $cliente->getDocumentos(new ConnectionFactory());
        
        $this->assertTrue(count($nd)==2);
        
        $this->assertTrue($nd[0]->link==$doc->link && $nd[1]->link==$doc2->link);
        
        $cliente->delete(new ConnectionFactory());
        
    }

}
