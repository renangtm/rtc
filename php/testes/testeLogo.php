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

class testeLogoAndEval extends PHPUnit_Framework_TestCase {

    public function testSimple() {
       
       $str = "";
       $str .= '$logo = new Logo();';
       $str .= '$logo->logo = Utilidades::base64encode("LOGO INVALIDO");';
       $str .= '$logo->cor_predominante = "255,255,255";';
       $str .= '$logo->empresa = Utilidades::getEmpresaTeste();';
       $str .= '$logo->merge(new ConnectionFactory());';
       $str .= '$logo->merge(new ConnectionFactory());';
       $str .= '$logo->delete(new ConnectionFactory());';
       
       eval($str);
       
       echo $str;
        
    }

}
