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

class testeCategoriaCliente extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $con = new ConnectionFactory();
        
        $grupo = new GrupoCidades();
        $grupo->nome = "Teste";
        
        $grupo->empresa = Utilidades::getEmpresaTeste();
        
        $cidades = Sistema::getCidades($con);
        
        $grupo->cidades = array($cidades[0],$cidades[1],$cidades[2],$cidades[3]);
        
        $grupo->merge($con);
        
        $this->assertTrue(GrupoCidades::cidadeEstaNoGrupo($cidades[0]->nome, "Teste"));
        
        $grupo->delete($con);
        
        $this->assertFalse(GrupoCidades::cidadeEstaNoGrupo($cidades[0]->nome, "Teste"));
        
    }

}
