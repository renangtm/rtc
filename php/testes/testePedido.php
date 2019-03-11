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
        $produto->empresa = $empresa;
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
        $produto2->empresa = $empresa;
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
        $produto3->empresa = $empresa;
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
        $cliente->empresa = new stdClass();
        $cliente->empresa->id = 1;
        $cliente->email = new Email("renan_goncalves@outlook.com.br");
        
        $cliente->telefones[]= new Telefone("1234");
        $cliente->inscricao_estadual = "333333333";
        $cliente->suframado = false;
        $cliente->inscricao_suframa = "444444444";
        
        $cliente->endereco = $e2;
        
        $cliente->merge(new ConnectionFactory());
        
        //------ criando pedido;
        
        $pedido = new Pedido();
        $pedido->cliente = $cliente;
        $pedido->transportadora = $tra;
        $pedido->frete_incluso = true;
        $pedido->frete = 10;
        $pedido->prazo = 20;
        $pedido->empresa = $empresa;
        $pedido->forma_pagamento = Sistema::getFormasPagamento();
        $pedido->forma_pagamento = $pedido->forma_pagamento[0];
        $pedido->usuario = new stdClass();
        $pedido->usuario->id = 2;
        
        $pedido->status = Sistema::getStatusPedidoSaida();
        
        $cancelado = $pedido->status[9];
        
        $pedido->status = $pedido->status[0];
        
        $pedido->produtos = array();
        
        $pp1 = new ProdutoPedidoSaida();
        $pp1->produto = $produto;
        $pp1->validade_minima = $produto->getLotes(new ConnectionFactory());
        $pp1->validade_minima = $pp1->validade_minima[0]->validade;
        $pp1->quantidade = 65;
        $pp1->valor_base = 10;
        $pp1->pedido=$pedido;
        
        $pedido->produtos[] = $pp1;
        
        
        $pp2 = new ProdutoPedidoSaida();
        $pp2->produto = $produto2;
        $pp2->validade_minima = $produto2->getLotes(new ConnectionFactory());
        $pp2->validade_minima = $pp2->validade_minima[0]->validade;
        $pp2->quantidade = 20;
        $pp2->valor_base = 100;
        $pp2->pedido=$pedido;
        
        $pedido->produtos[] = $pp2;
        
        $pp3 = new ProdutoPedidoSaida();
        $pp3->produto = $produto;
        $pp3->validade_minima = $produto->getLotes(new ConnectionFactory());
        $pp3->validade_minima = $pp3->validade_minima[0]->validade;
        $pp3->quantidade = 21;
        $pp3->valor_base = 150;
        $pp3->pedido=$pedido;
        
        $pedido->produtos[] = $pp3;
        
        $pp4 = new ProdutoPedidoSaida();
        $pp4->produto = $produto3;
        $pp4->validade_minima = $produto3->getLotes(new ConnectionFactory());
        $pp4->validade_minima = $pp4->validade_minima[0]->validade;
        $pp4->quantidade = 56;
        $pp4->valor_base = 11;
        $pp4->pedido=$pedido;
        
        $pedido->produtos[] = $pp4;
        
     
        
        // testando calculos
        $pedido->atualizarCustos();
        
        $this->assertEquals($pedido->produtos[0]->juros,round($pedido->produtos[0]->valor_base*0.009975165,2));
        $this->assertEquals($pedido->produtos[1]->juros,round($pedido->produtos[1]->valor_base*0.009975165,2));
        $this->assertEquals($pedido->produtos[2]->juros,round($pedido->produtos[2]->valor_base*0.009975165,2));
        $this->assertEquals($pedido->produtos[3]->juros,round($pedido->produtos[3]->valor_base*0.009975165,2));
        
        $this->assertEquals($pedido->produtos[0]->icms,round(($pedido->produtos[0]->valor_base+$pedido->produtos[0]->juros)*0.028,2),'',0.000001);
        $this->assertEquals($pedido->produtos[1]->icms,round(($pedido->produtos[1]->valor_base+$pedido->produtos[1]->juros)*0.028,2),'',0.000001);
        $this->assertEquals($pedido->produtos[2]->icms,round(($pedido->produtos[2]->valor_base+$pedido->produtos[2]->juros)*0.028,2),'',0.000001);
        $this->assertEquals($pedido->produtos[3]->icms,round(($pedido->produtos[3]->valor_base+$pedido->produtos[3]->juros)*0.028,2),'',0.000001);
        
        $total = 6416;
        $frete_produto1 = ((($pp1->quantidade*$pp1->valor_base)/$total)*10)/$pp1->quantidade;
        $frete_produto2 = ((($pp2->quantidade*$pp2->valor_base)/$total)*10)/$pp2->quantidade;
        $frete_produto3 = ((($pp3->quantidade*$pp3->valor_base)/$total)*10)/$pp3->quantidade;
        $frete_produto4 = ((($pp4->quantidade*$pp4->valor_base)/$total)*10)/$pp4->quantidade;
        
        $this->assertEquals($pedido->produtos[0]->frete,round($frete_produto1,2));
        $this->assertEquals($pedido->produtos[1]->frete,round($frete_produto2,2));
        $this->assertEquals($pedido->produtos[2]->frete,round($frete_produto3,2));
        $this->assertEquals($pedido->produtos[3]->frete,round($frete_produto4,2));
 
        $categoria->icms_normal = false;
        $categoria->icms = 0;
        
        $pedido->atualizarCustos();
        
        $this->assertEquals($pedido->produtos[0]->icms,0);
        $this->assertEquals($pedido->produtos[1]->icms,0);
        $this->assertEquals($pedido->produtos[2]->icms,0);
        $this->assertEquals($pedido->produtos[3]->icms,0);
        
        $categoria->icms_normal = true;
        
        $pedido->atualizarCustos();
        
        $this->assertEquals($pedido->produtos[0]->juros,round($pedido->produtos[0]->valor_base*0.009975165,2));
        $this->assertEquals($pedido->produtos[1]->juros,round($pedido->produtos[1]->valor_base*0.009975165,2));
        $this->assertEquals($pedido->produtos[2]->juros,round($pedido->produtos[2]->valor_base*0.009975165,2));
        $this->assertEquals($pedido->produtos[3]->juros,round($pedido->produtos[3]->valor_base*0.009975165,2));
      
        $cliente->suframado = true;
        
        $pedido->atualizarCustos();
        
        $this->assertEquals($pedido->produtos[0]->icms,0);
        $this->assertEquals($pedido->produtos[1]->icms,0);
        $this->assertEquals($pedido->produtos[2]->icms,0);
        $this->assertEquals($pedido->produtos[3]->icms,0);
        
        
        //produto1 85 --> 45 e 40 | 65 + 21(3), produto2 80 --> 50 e 30 | 20, produto3 80 --> 80 | 56
    
        $deu_erro = false;
        
        try{
        
            $pedido->merge(new ConnectionFactory());
        
        }catch(Exception $e){

            echo $e;
            
            $deu_erro = true;
            
        }
        
        $this->assertEquals($produto->disponivel,20);
        $this->assertEquals(count($pedido->produtos[0]->retiradas),5);
        $this->assertEquals($pedido->produtos[0]->retiradas[0][1],45);
        $this->assertEquals($pedido->produtos[0]->retiradas[1][1],15);
        $this->assertEquals($pedido->produtos[0]->retiradas[2][1],2);
        $this->assertEquals($pedido->produtos[0]->retiradas[3][1],2);
        $this->assertEquals($pedido->produtos[0]->retiradas[4][1],1);   
        
        $this->assertEquals($produto2->disponivel,60);
        $this->assertEquals(count($pedido->produtos[1]->retiradas),4);
        $this->assertEquals($pedido->produtos[1]->retiradas[0][1],15);
        $this->assertEquals($pedido->produtos[1]->retiradas[1][1],2);
        $this->assertEquals($pedido->produtos[1]->retiradas[2][1],2);
        $this->assertEquals($pedido->produtos[1]->retiradas[3][1],1);
        
        //produto1 85 --> 45 e 40 | 65 + 21(3), produto2 80 --> 50 e 30 | 20, produto3 80 --> 80 | 56
        
        //$this->assertTrue($deu_erro);
        $this->assertEquals($produto->disponivel,20);
        
        
        $lotes = $produto->getLotes(new ConnectionFactory());
        
        $this->assertEquals($lotes[0]->quantidade_real,20);
        
        $this->assertEquals($produto3->disponivel,24);
        $this->assertEquals(count($pedido->produtos[3]->retiradas),5);
        $this->assertEquals($pedido->produtos[3]->retiradas[0][1],40);
        $this->assertEquals($pedido->produtos[3]->retiradas[1][1],10);
        $this->assertEquals($pedido->produtos[3]->retiradas[2][1],2);
        $this->assertEquals($pedido->produtos[3]->retiradas[3][1],2);
        $this->assertEquals($pedido->produtos[3]->retiradas[4][1],2);  
        
        
        
        $this->assertTrue($deu_erro);

        $pedido->delete(new ConnectionFactory());
        
        $produto->atualizarEstoque(new ConnectionFactory());
        $produto2->atualizarEstoque(new ConnectionFactory());
        $produto3->atualizarEstoque(new ConnectionFactory());
        
        $this->assertEquals($produto->disponivel,85);
        $this->assertEquals($produto2->disponivel,80);
        $this->assertEquals($produto3->disponivel,80);
        
        $lotes1 = $produto->getLotes(new ConnectionFactory());
        $lotes2 = $produto2->getLotes(new ConnectionFactory());
        $lotes3 = $produto3->getLotes(new ConnectionFactory());
        
        $this->assertEquals($lotes1[0]->quantidade_real,40);
        $this->assertEquals($lotes1[1]->quantidade_real,45);
        
        $this->assertEquals($lotes2[0]->quantidade_real,30);
        $this->assertEquals($lotes2[1]->quantidade_real,50);
        
        $this->assertEquals($lotes3[0]->quantidade_real,80);

    }

}
