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

class testeUtilidades extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
       $str = "Renan 12341";
        
       $e = Utilidades::base64encode($str);
        
       echo $e;

       $this->assertEquals($e,"UmVuYW4gMTIzNDE=");
       
       $v = Utilidades::base64decode($e);
       
       echo "    ".$v;
       
       $this->assertEquals($v,"Renan 12341");
        
       $h = Utilidades::toHex($v);
       
       echo "    ".$h;
       
       $this->assertEquals($h,strtolower("52656E616E203132333431"));
       
    }

}
