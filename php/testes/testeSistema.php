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

class testeSistema extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $con = new ConnectionFactory();
        /*
        $estados = Sistema::getEstados($con);
        
        $this->assertTrue(count($estados)>1);
        $this->assertTrue(strlen($estados[0]->sigla)==2);
        $this->assertTrue($estados[0]->id>0);
        
        $cidades = Sistema::getCidades($con);
        
        $this->assertTrue(count($cidades)>1);
        $this->assertTrue(strlen($cidades[0]->nome)>2);
        $this->assertTrue($cidades[0]->id>0);
        
        $this->assertTrue(strlen($cidades[0]->estado->sigla)==2);
        $this->assertTrue($cidades[0]->estado->id>0);
        
        $categorias_cliente = Sistema::getCategoriaCliente($con);
        
        $historicos = Sistema::getHistorico($con);
        
        $operacoes = Sistema::getOperacoes($con);
        
        
        echo Utilidades::toJson($historicos);
        
        echo Utilidades::toJson($operacoes);
        
        
        
        $empresa = Utilidades::getEmpresaTeste();
        
        $usuario = Utilidades::getUsuarioTeste($empresa);
        
        $this->assertEquals(Sistema::getUsuario("usuario.login='teste' AND usuario.senha='123456'")->empresa->id,$empresa->id);
        
        $this->assertEquals(Sistema::getUsuario("usuario.login='teste' AND usuario.senha='123456'")->id,$usuario->id);
        
        $this->assertEquals(Sistema::getUsuario("usuario.login='teste' AND usuario.senha='12346'"),null);
        */
        
        $cats = Sistema::getCategoriaProduto($con);
        
        echo Utilidades::toJson($cats);
        
    }

}
