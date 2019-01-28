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

class testeMovimento extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        $con = new ConnectionFactory();
        
        
        $historico = new Historico();
        $historico->nome = "Teste";
        $historico->merge($con);
        
        $operacao =  new Operacao();
        $operacao->nome = "Teste2";
        $operacao->merge($con);
        
        $banco = new Banco();
        $banco->saldo = 10000;
        $banco->empresa = Utilidades::getEmpresaTeste();
        $banco->nome = "Itau";
        $banco->conta = "dedede";
        
        $banco->merge(new ConnectionFactory());
   
        $ven = new Vencimento();
        $ven->valor = 100;
        $ven->nota = new stdClass();
        $ven->nota->id = 1;
        $ven->nota->saida = true;
        
        $ven->merge(new ConnectionFactory());
   
        
        $m1 = new Movimento();
        $m1->banco = $banco;
        $m1->vencimento = $ven;
        $m1->valor = 100;
        $m1->juros = 1.5;
        $m1->descontos =  2;
        $m1->operacao = $operacao;
        $m1->historico = $historico;
        
        $m2 = new Movimento();
        $m2->banco = $banco;
        $m2->vencimento = $ven;
        $m2->valor = 100;
        $m2->juros = 0;
        $m2->descontos =  0;
        $m2->data += 20000;
        $m2->operacao = $operacao;
        $m2->historico = $historico;
        
        $m3 = new Movimento();
        $m3->banco = $banco;
        $m3->vencimento = $ven;
        $m3->valor = 100;
        $m3->juros = 0;
        $m3->descontos =  0;
        $m3->data -= 30000;
        $m3->operacao = $operacao;
        $m3->historico = $historico;
        
        $m4 = new Movimento();
        $m4->banco = $banco;
        $m4->vencimento = $ven;
        $m4->valor = 100;
        $m4->juros = 0;
        $m4->descontos =  0;
        $m4->data += 10000;
        $m4->operacao = $operacao;
        $m4->historico = $historico;
        
        $m5 = new Movimento();
        $m5->banco = $banco;
        $m5->vencimento = $ven;
        $m5->valor = 100;
        $m5->juros = 0;
        $m5->descontos =  0;
        $m5->data += 70000;
        $m5->operacao = $operacao;
        $m5->historico = $historico;
        
        $erro = false;
        try{
            
            $m1->insert($con);
                        
        }catch(Exception $ex){
            
            $erro = true;
            
        }
        
        $this->assertTrue($erro);

        $operacao->debito = false;
        $operacao->merge($con);
        
        $m1->insert($con);
        
        $banco->atualizaSaldo($con);
        
        $this->assertEquals($banco->saldo,10099.5);
        
        $banco->saldo = 10000;
        
        
        
        $m2->insert($con);
        
        $this->assertEquals($m2->saldo_anterior,10099.5);
        $banco->atualizaSaldo($con);
        $this->assertEquals($banco->saldo,10199.5);
        
        
        
        $m3->insert($con);
        
        $this->assertEquals($m3->saldo_anterior,10000);
        $banco->atualizaSaldo($con);
        $this->assertEquals($banco->saldo,10299.5);
        
        
        
        $m4->insert($con);
        
        $this->assertEquals($m4->saldo_anterior,10199.5);
        $banco->atualizaSaldo($con);
        $this->assertEquals($banco->saldo,10399.5);
        
        
        

        $m5->insert($con);
        
        $this->assertEquals($m5->saldo_anterior,10399.5);
        $banco->atualizaSaldo($con);
        $this->assertEquals($banco->saldo,10499.5);
        
    }

}
