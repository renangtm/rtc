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

class testeCategoriaCliente extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $grade = new Grade("15,3,2");
        
        $lote = new Lote();
        
        $lote->produto = new stdClass();
        $lote->produto->id = 1;
        $lote->grade = $grade;
        
        $lote->quantidade_inicial=30;
        $lote->quantidade_real=28;
        
        $lote->codigo_fabricante = "12345-@@#$!1";
        
        $lote->retiradas[] = array(0,1,0,0);
        
        $lote->merge(new ConnectionFactory());
        
        $lote->delete(new ConnectionFactory());
        
        $it = $lote->getItem();
        
        $this->assertEquals($it->quantidade,28);
        
        $this->assertEquals($it->quantidade_filhos,2);
        
        $this->assertEquals($it->filhos[0]->quantidade,15);
        
        $this->assertEquals($it->filhos[0]->filhos[0]->quantidade,3);
     
        $this->assertEquals($it->filhos[0]->filhos[0]->filhos[0]->quantidade,2);
        
        $this->assertEquals($it->filhos[0]->filhos[0]->filhos[1]->quantidade,1);
        
        $this->assertEquals($it->filhos[1]->filhos[0]->quantidade,1);
        
        $this->assertEquals($it->filhos[1]->filhos[0]->quantidade_filhos,0);
    
        
        $it = $grade->fractalizar(30,array());
        
        $this->assertEquals($it->quantidade,30);
        
        $this->assertEquals($it->quantidade_filhos,2);
        
        $this->assertEquals($it->filhos[0]->quantidade,15);
        
        $this->assertEquals($it->filhos[0]->filhos[0]->quantidade,3);
     
        $this->assertEquals($it->filhos[0]->filhos[0]->filhos[0]->quantidade,2);
        
        $this->assertEquals($it->filhos[0]->filhos[0]->filhos[1]->quantidade,1);
        
        $this->assertEquals($it->filhos[1]->filhos[0]->quantidade,3);
        
        $this->assertEquals($it->filhos[1]->filhos[0]->quantidade_filhos,2);
        
        
    }

}
