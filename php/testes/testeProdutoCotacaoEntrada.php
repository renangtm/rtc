<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InterpretadorNumerico
 *
 * @author Renan
 */

include("includes.php");

class testeProdutoCotacaoEntrada extends PHPUnit_Framework_TestCase {

    public function testSimple() {
       
        $p = new ProdutoCotacaoEntrada();
        
        $p->quantidade = 30;
        $p->cotacao = new stdClass();
        $p->produto = new stdClass();
        
        $p->cotacao->id = 12;
        $p->produto->id = 13;
        
        $p->merge(new ConnectionFactory());
        
        $p->merge(new ConnectionFactory());
        
        $p->delete(new ConnectionFactory());
        
    }

}
