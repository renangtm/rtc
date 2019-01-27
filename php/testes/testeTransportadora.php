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
        
        $doc->categoria = Sistema::getCategoriaDocumentos();
        $doc->categoria = $doc->categoria[0];
        
        $doc->numero = "erfqwerewq";
        
        $doc->link = "dfdwerferwfffffff";
        
        
        $doc2 = new Documento();
        
        $doc2->categoria = Sistema::getCategoriaDocumentos();
        $doc2->categoria = $doc2->categoria[1];
        
        $doc2->numero = "12344321";
        
        $doc2->link = "12344321";
        
       
        $transportadora = new Transportadora();
        $transportadora->razao_social = "T1";
        $transportadora->nome_fantasia = "T2";
        $transportadora->cnpj = new CNPJ("11111111111111");
        $transportadora->empresa = Utilidades::getEmpresaTeste();
        $transportadora->email = new Email("renan_goncalves@outlook.com.br");
        $transportadora->despacho = 999;
        $transportadora->habilitada = true;
        $transportadora->telefones[] = new Telefone("1234432");
        $transportadora->inscricao_estadual = "333333333";

        
        $e = new Endereco();
        
        $e->rua = "Rua Teste";
        $e->bairro = "Bairro Teste";
        $e->numero = 0;
        $e->cep = new CEP("07195201");
        $e->cidade = Sistema::getCidades(new ConnectionFactory());
        $e->cidade = $e->cidade[0];
        
        $transportadora->endereco = $e;
        
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
        
        $transportadora->tabela = $tabela;
        
        $transportadora->merge(new ConnectionFactory());
        
        $transportadora->merge(new ConnectionFactory());
        
        $transportadora->setDocumentos(array($doc,$doc2),new ConnectionFactory());
        
        $nd = $transportadora->getDocumentos(new ConnectionFactory());
        
        $this->assertTrue(count($nd)==2);
        
        $this->assertTrue($nd[0]->link==$doc->link && $nd[1]->link==$doc2->link);
        
        $transportadora->delete(new ConnectionFactory());
        
    }

}
