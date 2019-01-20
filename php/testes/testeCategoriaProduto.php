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

class testeCategoriaProduto extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $cat = new CategoriaProduto();
        
        $cat->nome = "Teste";
        
        $cat->base_calculo = 40;
        
        $cat->ipi = 10;
        
        $cat->icms_normal = false;
        
        $cat->icms = 4;
        
        $cat->merge(new ConnectionFactory());
        
        $cat->merge(new ConnectionFactory());
        
        $cat->delete(new ConnectionFactory());
        
    }

}
