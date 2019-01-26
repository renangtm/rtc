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

class testePedidoEntrada extends PHPUnit_Framework_TestCase {

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
        
        $empresa = new stdClass();
        $empresa->id = 1;
        $empresa->juros_mensal = 1.5;
        $empresa->endereco = $e1;
        
        // criando categorias de produto
        
        $categoria = new stdClass();
        $categoria->id = 1;
        $categoria->ipi = 0;
        $categoria->base_calculo = 40;
        $categoria->icms = 0;
        $categoria->icms_normal = true;
        
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
        $produto->transito = 0;
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
        $produto2->transito = 0;
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
        $produto3->transito = 0;
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
        
        //criando cliente
        
         $fornecedor = new Fornecedor();
        
        $fornecedor->nome = "Teste";
        $fornecedor->telefone = "111111";
        $fornecedor->cnpj = new CNPJ("11122233344455");
        $fornecedor->empresa = new stdClass();
        $fornecedor->empresa->id = 1;
        $fornecedor->email = new Email("renan.miranda@agrofauna.com.br");
        $fornecedor->endereco = $e4;
        $fornecedor->merge(new ConnectionFactory());
        
        //-----------------------
        
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
        
        //------ criando cotacao;
        
        $pedido = new PedidoEntrada();
        $pedido->fornecedor = $fornecedor;
        $pedido->incluir_frete = true;
        $pedido->frete = 10;
        $pedido->prazo = 20;
        $pedido->usuario = new stdClass();
        $pedido->usuario->id=1;
        $pedido->empresa = $empresa;
        $pedido->status = Sistema::getStatusPedidoEntrada();
        $pedido->transportadora = $tra;
        $cancelado = $pedido->status[3];
        
        $finalizado = $pedido->status[2];
        
        $pedido->status = $pedido->status[1];
        
        $pedido->produtos = array();
        
        $pp1 = new ProdutoPedidoEntrada();
        $pp1->produto = $produto;
        $pp1->quantidade = 65;
        $pp1->valor = 10;
        $pp1->pedido=$pedido;
        
        $pedido->produtos[] = $pp1;
        
        
        $pp2 = new ProdutoPedidoEntrada();
        $pp2->produto = $produto2;
        $pp2->quantidade = 20;
        $pp2->valor = 100;
        $pp2->pedido=$pedido;
        
        $pedido->produtos[] = $pp2;
        
        $pp3 = new ProdutoPedidoEntrada();
        $pp3->produto = $produto;
        $pp3->quantidade = 21;
        $pp3->valor = 150;
        $pp3->pedido=$pedido;
        
        $pedido->produtos[] = $pp3;
        
        $pp4 = new ProdutoPedidoEntrada();
        $pp4->produto = $produto3;
        $pp4->quantidade = 56;
        $pp4->valor = 11;
        $pp4->pedido=$pedido;
        
        $pedido->produtos[] = $pp4;

        //produto1 85 --> 45 e 40 | 65 + 21(3), produto2 80 --> 50 e 30 | 20, produto3 80 --> 80 | 56
        
        $pedido->merge(new ConnectionFactory());
        
        $this->assertEquals($produto->transito,86); 
        $this->assertEquals($produto->estoque,85); 

        $this->assertEquals($produto2->transito,20);
        $this->assertEquals($produto2->estoque,80);
    
        $this->assertEquals($produto3->transito,56);
        $this->assertEquals($produto3->estoque,80);
        
        $pedido->status = $cancelado;
        
        $pedido->merge(new ConnectionFactory());
        //produto1 85 --> 45 e 40 | 65 + 21(3), produto2 80 --> 50 e 30 | 20, produto3 80 --> 80 | 56
        $this->assertEquals($produto->transito,0);
        $this->assertEquals($produto2->transito,0);
        $this->assertEquals($produto3->transito,0);
        
        $this->assertEquals($produto->estoque,85);
        $this->assertEquals($produto2->estoque,80);
        $this->assertEquals($produto3->estoque,80);
        
       $pedido->status = $finalizado;
        
        $pedido->produtos[0]->merge(new ConnectionFactory());
        $pedido->produtos[1]->merge(new ConnectionFactory());
        $pedido->produtos[2]->merge(new ConnectionFactory());
        $pedido->produtos[3]->merge(new ConnectionFactory());
        //produto1 85 --> 45 e 40 | 65 + 21(3), produto2 80 --> 50 e 30 | 20, produto3 80 --> 80 | 56
        $this->assertEquals($produto->transito,0);
        $this->assertEquals($produto2->transito,0);
        $this->assertEquals($produto3->transito,0);
        
        $this->assertEquals($produto->disponivel,171);
        $this->assertEquals($produto2->disponivel,100);
        $this->assertEquals($produto3->disponivel,136);
        
        $this->assertEquals($produto->estoque,171);
        $this->assertEquals($produto2->estoque,100);
        $this->assertEquals($produto3->estoque,136);
        
        $pedido->status = $cancelado;
        
        $pedido->merge(new ConnectionFactory());
        
        $pedido->merge(new ConnectionFactory());
        
        //produto1 85 --> 45 e 40 | 65 + 21(3), produto2 80 --> 50 e 30 | 20, produto3 80 --> 80 | 56
        $this->assertEquals($produto->transito,0);
        $this->assertEquals($produto2->transito,0);
        $this->assertEquals($produto3->transito,0);
        
        $this->assertEquals($produto->estoque,85);
        $this->assertEquals($produto2->estoque,80);
        $this->assertEquals($produto3->estoque,80);
        
        unset($pedido->produtos[3]);
        
        $this->assertEquals(count($pedido->produtos),3);
        
        $pedido->merge(new ConnectionFactory());
        
        $this->assertEquals(count($pedido->getProdutos(new ConnectionFactory())),3);
        
    }

}
