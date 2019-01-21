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

class testeProduto extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $produto = new Produto();
   
        $produto->nome = "teste";
        $produto->id_universal = 12;
        $produto->categoria = new stdClass();
        $produto->categoria->id=2;
        $produto->liquido = false;
        $produto->unidade = "Galao";
        $produto->quantidade_unidade = 0.25;
        $produto->empresa = new stdClass();
        $produto->empresa->id = 1;
        $produto->valor_base = 0.3;
        $produto->custo = 123;
        $produto->ncm = "12341234";
        $produto->peso_liquido = 12;
        $produto->peso_bruto = 23;
        $produto->estoque = 12;
        $produto->disponivel = 13;
        $produto->transito = 14;
        $produto->grade = new Grade("15,2,1");
        
        $produto->merge(new ConnectionFactory());
        $produto->merge(new ConnectionFactory());
        
        
        
        $lote = new Lote();
        
        $lote->quantidade_inicial = 30;
        $lote->quantidade_real = 30;
        $lote->grade = $produto->grade;
        $lote->produto = $produto;
        $lote->codigo_fabricante = "1234";
        
        $lote->merge(new ConnectionFactory());
        
        $lote2 = new Lote();
        
        $lote2->quantidade_inicial = 40;
        $lote2->quantidade_real = 50;
        $lote2->grade = $produto->grade;
        $lote2->produto = $produto;
        $lote2->codigo_fabricante = "1234";
        
        $lote2->merge(new ConnectionFactory());
        
        
        $lotes = $produto->getLotes(new ConnectionFactory());
        
        $this->assertEquals(count($lotes),2);

        $this->assertEquals($lotes[0]->quantidade_inicial,$lote->quantidade_inicial);
        $this->assertEquals($lotes[1]->quantidade_inicial,$lote2->quantidade_inicial);
        
        $this->assertEquals($lotes[0]->quantidade_real,$lote->quantidade_real);
        $this->assertEquals($lotes[1]->quantidade_real,$lote2->quantidade_real);

        $this->assertEquals($lotes[0]->grade->str,$lote->grade->str);
        $this->assertEquals($lotes[1]->grade->str,$lote2->grade->str);
        
        $this->assertEquals($lotes[0]->id,$lote->id);
        $this->assertEquals($lotes[1]->id,$lote2->id);
        
        $this->assertEquals($lotes[0]->produto->id,$lote->produto->id);
        $this->assertEquals($lotes[1]->produto->id,$lote2->produto->id);
        
        $this->assertEquals($lotes[0]->codigo_fabricante,$lote->codigo_fabricante);
        $this->assertEquals($lotes[1]->codigo_fabricante,$lote2->codigo_fabricante);

        $produto->delete(new ConnectionFactory());
        
    }

}
