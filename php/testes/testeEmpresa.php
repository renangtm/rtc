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
        
        $con = new ConnectionFactory();
        /*
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
        
        $banco = new Banco();
        $banco->codigo = "123";
        $banco->conta = "123423";
        $banco->empresa = $empresa;
        $banco->nome = "Teste";
        $banco->saldo = 1234;
        
        $banco->merge($con);
        
        $banco2 = new Banco();
        $banco2->codigo = "321";
        $banco2->conta = "321321";
        $banco2->empresa = $empresa;
        $banco2->nome = "Teste321";
        $banco2->saldo = 4321;
        
        $banco2->merge($con);
        
        $bancos = $empresa->getBancos($con);
        
        $this->assertEquals(count($bancos),2);
        
        $this->assertEquals($bancos[0]->id,$banco->id);
        $this->assertEquals($bancos[1]->id,$banco2->id);
        
        
        $empresa = Utilidades::getEmpresaTeste();
        
        $pedido1 = Utilidades::getPedidoTeste($empresa);
        $pedido2 = Utilidades::getPedidoTeste($empresa);
        $pedido3 = Utilidades::getPedidoTeste($empresa);
      
        
        $pedidos = $empresa->getPedidos($con, 0, 2);
        
        $this->assertEquals($pedido1->id,$pedidos[0]->id);
        $this->assertEquals($pedido2->id,$pedidos[1]->id);
        
        $pedidos = $empresa->getPedidos($con, 2, 3);
        
        $this->assertEquals($pedido3->id,$pedidos[0]->id);
        
        echo "    ".Utilidades::toJson($pedidos);
        
        $this->assertEquals($empresa->getCountPedidos($con),3);
        
         
        
        $empresa = Utilidades::getEmpresaTeste();
        
        $campanha1 = Utilidades::getCampanhaTeste($empresa);
        $campanha2 = Utilidades::getCampanhaTeste($empresa);
        
        $campanhas = $empresa->getCampanhas($con, 0, 2);
        
        echo Utilidades::toJson($campanhas);
        
        $this->assertEquals($campanhas[0]->id,$campanha1->id);
        $this->assertEquals($campanhas[1]->id,$campanha2->id);
        
        $this->assertEquals($empresa->getCountCampanha($con),2);
        
        
        $empresa = Utilidades::getEmpresaTeste();
        
        $grupo1 = Utilidades::getGrupoCidadesTeste($empresa);
        $grupo2 = Utilidades::getGrupoCidadesTeste($empresa);
        $grupo3 = Utilidades::getGrupoCidadesTeste($empresa);
        
        $grupos = $empresa->getGruposCidades($con, 0, 2);
        
        $this->assertEquals($grupo1->id,$grupos[0]->id);
        $this->assertEquals($grupo2->id,$grupos[1]->id);
        
        $grupos = $empresa->getGruposCidades($con, 2, 3);
        
        $this->assertEquals($grupo3->id,$grupos[0]->id);
        
        $this->assertEquals($empresa->getCountGruposCidades($con),3);
     
        
        
        $empresa = Utilidades::getEmpresaTeste();
        
        $nota = Utilidades::getNotaTeste($empresa);
        
        $vencimento = Utilidades::getVencimentoTeste($nota);
        
        echo Utilidades::toJson($vencimento);
        
        
        
        $movimento = Utilidades::getMovimentoTeste($vencimento);
        
        $vencimento = Utilidades::getVencimentoTeste($nota);
        
        $movimento = Utilidades::getMovimentoTeste($vencimento);
        
        $nota = Utilidades::getNotaTeste($empresa);
        
        $vencimento = Utilidades::getVencimentoTeste($nota);
        
        $movimento = Utilidades::getMovimentoTeste($vencimento);
        
        $movimentos = $empresa->getMovimentos($con, 0, 3);
        
        $this->assertEquals($movimentos[2]->id,$movimento->id);
        
        $this->assertEquals($empresa->getCountMovimentos($con),3);

        $notas = $empresa->getNotas($con, 0, 2);
        
        $this->assertEquals($notas[1]->id,$nota->id);
        
        $this->assertEquals($empresa->getCountNotas($con),2);
        
        
        
        $empresa = Utilidades::getEmpresaTeste();
        
        $fornecedor = Utilidades::getFornecedorTeste($empresa);
        $fornecedor = Utilidades::getFornecedorTeste($empresa);
        $fornecedor = Utilidades::getFornecedorTeste($empresa);
        $fornecedor = Utilidades::getFornecedorTeste($empresa);
        $fornecedor = Utilidades::getFornecedorTeste($empresa);
        $fornecedor = Utilidades::getFornecedorTeste($empresa);
        
        $fornecedores = $empresa->getFornecedores($con, 0, 2);
        
        $this->assertEquals(count($fornecedores),2);
        
        $fornecedores = $empresa->getFornecedores($con, 2, 4);
        
        $this->assertEquals(count($fornecedores),2);
        
        $fornecedores = $empresa->getFornecedores($con, 4, 6);
        
        $this->assertEquals(count($fornecedores),2);
        
        $this->assertEquals($fornecedor->id,$fornecedores[1]->id);
        
        $this->assertEquals($empresa->getCountFornecedores($con),6);
        
        
        
        $empresa = Utilidades::getEmpresaTeste();
        
        $cotacao = Utilidades::getCotacaoEntradaTeste($empresa);
        $cotacao = Utilidades::getCotacaoEntradaTeste($empresa);
        $cotacao = Utilidades::getCotacaoEntradaTeste($empresa);
        $cotacao = Utilidades::getCotacaoEntradaTeste($empresa);
        $cotacao = Utilidades::getCotacaoEntradaTeste($empresa);
        
        $cotacoes = $empresa->getCotacoesEntrada($con, 0, 2);
        
        $this->assertEquals(count($cotacoes),2);
        
        $cotacoes = $empresa->getCotacoesEntrada($con, 2, 4);
        
        $this->assertEquals(count($cotacoes),2);
        
        $cotacoes = $empresa->getCotacoesEntrada($con, 4, 6);
        
        $this->assertEquals(count($cotacoes),1);
        
        $this->assertEquals($cotacoes[0]->id,$cotacao->id);
        
        $this->assertEquals($empresa->getCountCotacoesEntrada($con),5);
        
        
        
        
        
        $empresa = Utilidades::getEmpresaTeste();
        
        $produto = Utilidades::getProdutoTeste($empresa);
        
        Utilidades::getCampanhaTeste($empresa, $produto);
        
        $produto = Utilidades::getProdutoTeste($empresa);
        $produto = Utilidades::getProdutoTeste($empresa);
        $produto = Utilidades::getProdutoTeste($empresa);
        $produto = Utilidades::getProdutoTeste($empresa);
        
        $produtos = $empresa->getProdutos($con, 0, 2);
        
        $this->assertEquals(count($produtos),2);
        
        $produtos = $empresa->getProdutos($con, 2, 4);
        
        $this->assertEquals(count($produtos),2);
        
        $produtos = $empresa->getProdutos($con, 4, 6);
        
        $this->assertEquals(count($produtos),2);
        
        $this->assertEquals($produtos[1]->id,$produto->id);
        
        $this->assertEquals($empresa->getCountProdutos($con),6);
        
        
        
        
        
        $empresa = Utilidades::getEmpresaTeste();
        
        $r = Utilidades::getReceituarioTeste($empresa);
        $r = Utilidades::getReceituarioTeste($empresa);
        $r = Utilidades::getReceituarioTeste($empresa);
        $r = Utilidades::getReceituarioTeste($empresa);
        
        $recsg = $empresa->getReceituario($con, 0, 2,"","","produto.nome");
        
        $recs = $empresa->getReceituario($con, 2, 4);
        
        $this->assertEquals(count($recsg),1);
        
        $this->assertEquals(count($recs),2);
        
        $this->assertEquals($recs[1]->id, $r->id);
        
        $this->assertEquals($empresa->getCountReceituario($con),4);
        $this->assertEquals($empresa->getCountReceituario($con,"","produto.nome"),1);
        
        
        
        $empresa = Utilidades::getEmpresaTeste();
        
        $transportadora = Utilidades::getTransportadoraTeste($empresa);
        $transportadora = Utilidades::getTransportadoraTeste($empresa);
        $transportadora = Utilidades::getTransportadoraTeste($empresa);
        $transportadora = Utilidades::getTransportadoraTeste($empresa);
        $transportadora = Utilidades::getTransportadoraTeste($empresa);
        
        $transportadoras = $empresa->getTransportadoras($con, 0, 2);
        
        $this->assertEquals(count($transportadoras),2);
        
        $transportadoras = $empresa->getTransportadoras($con, 2, 4);
        
        $this->assertEquals(count($transportadoras),2);
        
        $transportadoras = $empresa->getTransportadoras($con,4, 6);
        
        $this->assertEquals(count($transportadoras),1);
        
        $this->assertEquals($transportadora->id,$transportadoras[0]->id);
        
        $this->assertEquals($empresa->getCountTransportadoras($con),5);
        
        
        
        
        $empresa = Utilidades::getEmpresaTeste();
        
        $cliente = Utilidades::getClienteTeste($empresa);
        $cliente = Utilidades::getClienteTeste($empresa);
        $cliente = Utilidades::getClienteTeste($empresa);
        $cliente = Utilidades::getClienteTeste($empresa);
        $cliente = Utilidades::getClienteTeste($empresa);
        
        $clientes = $empresa->getClientes($con, 0, 2);
        
        $this->assertEquals(count($clientes),2);
        
        $clientes = $empresa->getClientes($con, 2, 4);
        
        $this->assertEquals(count($clientes),2);
        
        $clientes = $empresa->getClientes($con, 4, 6);
        
        $this->assertEquals(count($clientes),1);
        
        $this->assertEquals($clientes[0]->id,$cliente->id);
        
        $this->assertEquals($empresa->getCountClientes($con),5);
     
        
        $empresa = Utilidades::getEmpresaTeste();
        
        $usuario = Utilidades::getUsuarioTeste($empresa);
        $usuario = Utilidades::getUsuarioTeste($empresa);
        $usuario = Utilidades::getUsuarioTeste($empresa);
        $usuario = Utilidades::getUsuarioTeste($empresa);
        $usuario = Utilidades::getUsuarioTeste($empresa);
        
        $usuarios = $empresa->getUsuarios($con, 0, 2);
        
        $this->assertEquals(count($usuarios),2);
        
        $usuarios = $empresa->getUsuarios($con, 2, 4);
        
        $this->assertEquals(count($usuarios),2);
        
        $usuarios = $empresa->getUsuarios($con, 4, 6);
        
        $this->assertEquals(count($usuarios),1);
        
        $this->assertEquals($usuarios[0]->id,$usuario->id);
        
        $this->assertEquals($empresa->getCountUsuarios($con),5);

        $empresa = Utilidades::getEmpresaTeste();
        
        $parametros = Utilidades::getParametrosEmissaoTeste($empresa);
        
     
        
        $empresa = Utilidades::getEmpresaTeste();
        
        $logo = Utilidades::getLogoTeste($empresa);
        */
  
        
    }

}

