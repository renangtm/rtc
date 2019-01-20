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

include('/../entidades/ConnectionFactory.php');

class testeConnectionFactory extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $con = new ConnectionFactory();
        
        $ps = $con->getConexao()->prepare("SELECT * FROM reltrab_db.USERS");
        $ps->execute();
        $ps->close();
        
    }

}
