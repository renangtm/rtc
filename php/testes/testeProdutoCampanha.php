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

class testeReceituario extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $cat = new ProdutoCampanha();
        
        $cat->produto = new stdClass();
        $cat->produto->id = 1;
        
        $cat->campanha = new stdClass();
        $cat->campanha->id = 2;
        
        $cat->valor = 40.5;
        
        $cat->merge(new ConnectionFactory());
        
        $cat->merge(new ConnectionFactory());
        
        $cat->delete(new ConnectionFactory());
        
    }

}
