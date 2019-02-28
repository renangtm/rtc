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

class testeBanner extends PHPUnit_Framework_TestCase {

    public function testSimple() {
       
        $con = new ConnectionFactory();
        
        $empresa = new Empresa(1733);
        
        $banners = $empresa->getBanners($con, 0, 2);
        
        $banner = $banners[0];
        
        echo $banner->getHTML();
        
    }

}
