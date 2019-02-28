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

class testeInterpretadorBooleano extends PHPUnit_Framework_TestCase {

    public function testSimple() {
       
        $con = new ConnectionFactory();
        
        $banner = new Banner();
        $banner->json = Utilidades::toJson($banner);
        
        $banner->campanha = new stdClass();
        $banner->campanha->id = 2;
        
        $banner->empresa = new stdClass();
        $banner->empresa->id = 85;
        
        $banner->merge($con);
      
        
        $banner = new Banner();
        $banner->json = Utilidades::toJson($banner);
        
        $banner->campanha = new stdClass();
        $banner->campanha->id = 2;
        
        $banner->empresa = new stdClass();
        $banner->empresa->id = 85;
        
        $banner->merge($con);
        
        $banner = new Banner();
        $banner->json = Utilidades::toJson($banner);
        
        $banner->campanha = new stdClass();
        $banner->campanha->id = 0;
        
        $banner->empresa = new stdClass();
        $banner->empresa->id = 85;
        
        $banner->merge($con);
        
        
        $empresa = new Empresa();
        $empresa->id = 85;
        
        $banners = $empresa->getBanners($con, 0, 10);
        
        echo Utilidades::toJson($banners);
        
    }

}
