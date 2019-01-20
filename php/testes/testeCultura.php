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

class testeCategoriaCultura extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $cat = new Cultura();
        
        $cat->nome = "Teste";
        
        $cat->merge(new ConnectionFactory());
        
        $cat->merge(new ConnectionFactory());
        
        $cat->delete(new ConnectionFactory());
        
    }

}
