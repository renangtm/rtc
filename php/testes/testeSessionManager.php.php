<?php

session_start();

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

include('/../entidades/SessionManager.php');

class testeConnectionFactory extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $ses  = new SessionManager();
        
        $std = new stdClass();
        $std->nome = "Teste";
        
        $ses->set("teste",$std);
        
        $std = $ses->get("teste");
        
        if($std->nome!="Teste"){
            
            $this->assertFalse(true);
            
        }
        
    }

}
