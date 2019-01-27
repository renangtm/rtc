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
        
       $rec = new stdClass();
       $rec->id = 1;
       $rec->rec = array($rec,$rec,$rec,$rec);
       
       $js = Utilidades::toJson($rec)."     ";
       
       echo $js;
       
       $o = Utilidades::fromJson($js);
       
       echo $o->rec[0]->rec[1]->rec[0]->rec[1]->rec[0]->rec[2]->rec[3]->rec[0]->id."      ";
        
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
