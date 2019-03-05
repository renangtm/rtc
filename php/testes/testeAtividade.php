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

class testeAtividade extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $con = new ConnectionFactory();
        
        $g = new GerenciadorAtividade(new Empresa(1733));
        
        echo Utilidades::toJson($g->getMaximoUsuariosOnline($con));
        
    }

}
