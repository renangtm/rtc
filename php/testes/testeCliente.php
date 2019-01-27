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

class testeCliente extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $doc = new Documento();
        
        $doc->categoria = Sistema::getCategoriaDocumentos();
        $doc->categoria = $doc->categoria[0];
        
        $doc->numero = "erfqwerewq";
        
        $doc->link = "dfdwerferwfffffff";
        
        
        $doc2 = new Documento();
        
        $doc2->categoria = Sistema::getCategoriaDocumentos();
        $doc2->categoria = $doc2->categoria[1];
        
        $doc2->numero = "12344321";
        
        $doc2->link = "12344321";
        
        $cat = new CategoriaCliente();
        
        $cat->nome = "Teste";
       
        $cliente = new Cliente();
        $cliente->razao_social = "T1";
        $cliente->nome_fantasia = "T2";
        $cliente->limite_credito = 100;
        $cliente->pessoa_fisica = true;
        $cliente->cpf = new CPF("11111111111");
        $cliente->rg = new RG("111111111");
        $cliente->categoria = $cat;
        $cliente->empresa = Utilidades::getEmpresaTeste();
        $cliente->email = new Email("renan_goncalves@outlook.com.br");
        
        $cliente->telefones[] = new Telefone("1234412");
        $cliente->telefones[] = new Telefone("2232233");
        $cliente->inscricao_estadual = "333333333";
        $cliente->suframado = false;
        $cliente->inscricao_suframa = "444444444";   
        
        $e = new Endereco();
        
        $e->rua = "Rua Teste";
        $e->bairro = "Bairro Teste";
        $e->numero = 0;
        $e->cep = new CEP("07195201");
        $e->cidade = Sistema::getCidades(new ConnectionFactory());
        $e->cidade = $e->cidade[0];
        
        $cliente->endereco = $e;
        
        $cliente->merge(new ConnectionFactory());
        
        unset($cliente->telefones[0]);
        
        $cliente->merge(new ConnectionFactory());
        
        $cliente->setDocumentos(array($doc,$doc2),new ConnectionFactory());
        
        $nd = $cliente->getDocumentos(new ConnectionFactory());
        
        $this->assertTrue(count($nd)==2);
        
        $this->assertTrue($nd[0]->link==$doc->link && $nd[1]->link==$doc2->link);
        
        $cliente->delete(new ConnectionFactory());
        
    }

}
