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

class testeEmail extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $doc = new Documento();
        
        $doc->categoria = Sistema::getCategoriaDocumentos()[0];
        
        $doc->numero = "erfqwerewq";
        
        $doc->link = "dfdwerferwfffffff";
        
        $doc->merge(new ConnectionFactory());
        
        $doc->merge(new ConnectionFactory());
        
        $doc->delete(new ConnectionFactory());
        
    }

}
