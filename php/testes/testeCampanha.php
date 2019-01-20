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

class testeCampanha extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $cat = new Campanha();
        
        $cat->prazo = 12;
        $cat->parcelas = 1;
        $cat->cliente_expression = "123";
        $cat->empresa = new stdClass();
        $cat->empresa->id=1;
        
        $p = new ProdutoCampanha();
        
        $p->produto = new stdClass();
        $p->produto->id = 1;
        
        $p->campanha = $cat;
        
        $p2 = new ProdutoCampanha();
        
        $p2->produto = new stdClass();
        $p2->produto->id = 2;
        
        $p2->campanha = $cat;
        
        $cat->produtos[] = $p;
        $cat->produtos[] = $p2;
        
        $cat->merge(new ConnectionFactory());
        
        $cat->produtos = array($p);
        
        $cat->merge(new ConnectionFactory());
        
        $cat->delete(new ConnectionFactory());
        
    }

}
