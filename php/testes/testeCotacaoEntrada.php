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

class testePedido extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
         // criando enderecos
        
        $e1 = new Endereco();
        
        $e1->rua = "Rua Teste";
        $e1->bairro = "Bairro Teste";
        $e1->numero = 0;
        $e1->cep = new CEP("07195201");
        $e1->cidade = Sistema::getCidades(new ConnectionFactory());
        $e1->cidade = $e1->cidade[0];
        
        
        $e2 = new Endereco();
        
        $e2->rua = "Rua Teste";
        $e2->bairro = "Bairro Teste";
        $e2->numero = 0;
        $e2->cep = new CEP("07195201");
        $e2->cidade = Sistema::getCidades(new ConnectionFactory());
        $e2->cidade = $e2->cidade[400];
        
        
        $e3 = new Endereco();
        
        $e3->rua = "Rua Teste";
        $e3->bairro = "Bairro Teste";
        $e3->numero = 0;
        $e3->cep = new CEP("07195201");
        $e3->cidade = Sistema::getCidades(new ConnectionFactory());
        $e3->cidade = $e3->cidade[100];
        
        $e4 = new Endereco();
        
        $e4->rua = "Rua Teste";
        $e4->bairro = "Bairro Teste";
        $e4->numero = 0;
        $e4->cep = new CEP("07195201");
        $e4->cidade = Sistema::getCidades(new ConnectionFactory());
        $e4->cidade = $e4->cidade[51];
        
        // criando empresa
        
        $empresa = Utilidades::getEmpresaTeste();
        
        // criando categorias de produto
        
        $categoria = new CategoriaProduto();
        $categoria->ipi = 0;
        $categoria->base_calculo = 40;
        $categoria->icms = 0;
        $categoria->icms_normal = true;
        $categoria->merge(new ConnectionFactory());
        
        // criando produtos
        
        $produto = new Produto();
   
        $produto->nome = "teste";
        $produto->id_universal = 12;
        $produto->categoria = $categoria;
        $produto->categoria->id=2;
        $produto->liquido = false;
        $produto->unidade = "Galao";
        $produto->quantidade_unidade = 0.25;
        $produto->empresa = new stdClass();
        $produto->empresa->id = 1;
        $produto->valor_base = 100;
        $produto->custo = 123;
        $produto->ncm = "12341234";
        $produto->peso_liquido = 12;
        $produto->peso_bruto = 23;
        $produto->estoque = 85;
        $produto->disponivel = 85;
        $produto->transito = 14;
        $produto->grade = new Grade("15,2,1");
        
        $produto->merge(new ConnectionFactory());
        $produto->merge(new ConnectionFactory());

        $lote = new Lote();
        
        $lote->quantidade_inicial = 40;
        $lote->quantidade_real = 40;
        $lote->grade = $produto->grade;
        $lote->produto = $produto;
        $lote->codigo_fabricante = "1234";
        
        $lote->merge(new ConnectionFactory());
        
        $lote2 = new Lote();
        
        $lote2->quantidade_inicial = 45;
        $lote2->quantidade_real = 45;
        $lote2->grade = $produto->grade;
        $lote2->produto = $produto;
        $lote2->codigo_fabricante = "1234";
        
        $lote2->merge(new ConnectionFactory());
        
        $lote3 = new Lote();
        
        $lote3->quantidade_inicial = 0;
        $lote3->quantidade_real = 0;
        $lote3->grade = $produto->grade;
        $lote3->produto = $produto;
        $lote3->codigo_fabricante = "1234";
        
        $lote3->merge(new ConnectionFactory());
        
        $lote4 = new Lote();
        
        $lote4->quantidade_inicial = 100;
        $lote4->quantidade_real = 100;
        $lote4->validade = round(microtime(true)*1000)+(60*24*60*60*1000);
        $lote4->grade = $produto->grade;
        $lote4->produto = $produto;
        $lote4->codigo_fabricante = "1234";
        
        $lote4->merge(new ConnectionFactory());
        
        $produto2 = new Produto();
   
        $produto2->nome = "teste";
        $produto2->id_universal = 12;
        $produto2->categoria = $categoria;
        $produto2->liquido = false;
        $produto2->unidade = "Galao";
        $produto2->quantidade_unidade = 0.25;
        $produto2->empresa = new stdClass();
        $produto2->empresa->id = 1;
        $produto2->valor_base = 15;
        $produto2->custo = 123;
        $produto2->ncm = "12341234";
        $produto2->peso_liquido = 12;
        $produto2->peso_bruto = 23;
        $produto2->estoque = 80;
        $produto2->disponivel = 80;
        $produto2->transito = 14;
        $produto2->grade = new Grade("15,2,1");
        
        $produto2->merge(new ConnectionFactory());
        $produto2->merge(new ConnectionFactory());
        
        $lote = new Lote();
        
        $lote->quantidade_inicial = 30;
        $lote->quantidade_real = 30;
        $lote->grade = $produto2->grade;
        $lote->produto = $produto2;
        $lote->codigo_fabricante = "1234";
        
        $lote->merge(new ConnectionFactory());
        
        $lote2 = new Lote();
        
        $lote2->quantidade_inicial = 50;
        $lote2->quantidade_real = 50;
        $lote2->grade = $produto2->grade;
        $lote2->produto = $produto2;
        $lote2->codigo_fabricante = "1234";
        
        $lote2->merge(new ConnectionFactory());
        
        $produto3 = new Produto();
   
        $produto3->nome = "teste";
        $produto3->id_universal = 12;
        $produto3->categoria = $categoria;
        $produto3->liquido = false;
        $produto3->unidade = "Galao";
        $produto3->quantidade_unidade = 0.25;
        $produto3->empresa = new stdClass();
        $produto3->empresa->id = 1;
        $produto3->valor_base = 10;
        $produto3->custo = 123;
        $produto3->ncm = "12341234";
        $produto3->peso_liquido = 12;
        $produto3->peso_bruto = 23;
        $produto3->estoque = 80;
        $produto3->disponivel = 80;
        $produto3->transito = 80;
        $produto3->grade = new Grade("40,10,2");
        
        $produto3->merge(new ConnectionFactory());
        $produto3->merge(new ConnectionFactory());
        
        $lote = new Lote();
        
        $lote->quantidade_inicial = 80;
        $lote->quantidade_real = 80;
        $lote->grade = $produto3->grade;
        $lote->produto = $produto3;
        $lote->codigo_fabricante = "1234";
        
        $lote->merge(new ConnectionFactory());
        
        // criando transportadora
        
        $tra = new Transportadora();
        $tra->razao_social = "T1";
        $tra->nome_fantasia = "T2";
        $tra->cnpj = new CNPJ("11111111111111");
        $tra->empresa = new stdClass();
        $tra->empresa->id = 1;
        $tra->email = new Email("renan_goncalves@outlook.com.br");
        $tra->despacho = 999;
        $tra->habilitada = true;
        $tra->telefones[]= new Telefone("1234");
        $tra->inscricao_estadual = "333333333";
        $tra->endereco = $e3;
        
        $tra->merge(new ConnectionFactory());
        
        //criando cliente
       
        $fornecedor = new Fornecedor();
        
        $fornecedor->nome = "Teste";
        $fornecedor->telefones[]= new Telefone("1234");
        $fornecedor->cnpj = new CNPJ("11122233344455");
        $fornecedor->empresa = new stdClass();
        $fornecedor->empresa->id = 1;
        $fornecedor->email = new Email("renan.miranda@agrofauna.com.br");
        $fornecedor->endereco = $e4;
        $fornecedor->merge(new ConnectionFactory());
        
        //------ criando pedido;
        
        $cot = new CotacaoEntrada();
        $cot->fornecedor = $fornecedor;
        $cot->transportadora = $tra;
        $cot->frete = 10;
        $cot->empresa = $empresa;
        $cot->status = Sistema::getStatusCotacaoEntrada();
        $cot->status = $cot->status[0];
        $cot->tratar_em_litros = false;
        $cot->usuario = new stdClass();
        $cot->usuario->id = 2;

        
        $cot->produtos = array();
        
        $pp1 = new ProdutoCotacaoEntrada();
        $pp1->produto = $produto;
        $pp1->quantidade = 65;
        $pp1->valor = 10;
        $pp1->cotacao=$cot;
        
        $cot->produtos[] = $pp1;
        
        
        $pp2 = new ProdutoCotacaoEntrada();
        $pp2->produto = $produto2;
        $pp2->quantidade = 20;
        $pp2->valor = 100;
        $pp2->cotacao=$cot;
        
        $cot->produtos[] = $pp2;
        
        $pp3 = new ProdutoCotacaoEntrada();
        $pp3->produto = $produto;
        $pp3->quantidade = 21;
        $pp3->valor = 150;
        $pp3->cotacao=$cot;
        
        $cot->produtos[] = $pp3;
        
        $pp4 = new ProdutoCotacaoEntrada();
        $pp4->produto = $produto3;
        $pp4->quantidade = 56;
        $pp4->valor = 11;
        $pp4->cotacao=$cot;
        
        $cot->produtos[] = $pp4;
        
        
        $cot->merge(new ConnectionFactory());
        
        $cot->merge(new ConnectionFactory());
        
        
        $produtos = $cot->getProdutos(new ConnectionFactory());
        
        $this->assertEquals($produtos[0]->id,$pp1->id);
        $this->assertEquals($produtos[0]->produto->nome,$pp1->produto->nome);
        
        $this->assertEquals($produtos[1]->id,$pp2->id);
        $this->assertEquals($produtos[1]->produto->nome,$pp2->produto->nome);
        
        $this->assertEquals($produtos[2]->id,$pp3->id);
        $this->assertEquals($produtos[2]->produto->nome,$pp3->produto->nome);
        
        $this->assertEquals($produtos[3]->id,$pp4->id);
        $this->assertEquals($produtos[3]->produto->nome,$pp4->produto->nome);
        
        unset($cot->produtos[3]);
        
        $cot->merge(new ConnectionFactory());
        
        $produtos = $cot->getProdutos(new ConnectionFactory());
        
        $this->assertEquals(count($produtos),3);
        
        $cot->delete(new ConnectionFactory());
        
    }

}
