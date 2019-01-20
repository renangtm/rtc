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

class clonarCidadesRTC extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        if(true){
            
            //retire para realmente executar o script
            return;
            
        }
        
       $estados = array();
       $cidades = array();
        
       $con = new ConnectionFactory();
       
       $ps = $con->getConexao()->prepare("DELETE FROM novo_rtc.cidade");
       $ps->execute();
       $ps->close();
       
       $ps = $con->getConexao()->prepare("DELETE FROM novo_rtc.estado");
       $ps->execute();
       $ps->close();
       
       $ps = $con->getConexao()->prepare("SELECT nome, estado FROM rtc.cidades");
       $ps->execute();
       $ps->bind_result($nome,$sg_estado);
      
       while($ps->fetch()){
           
           $cidades[] = $nome;
           $estados[] = $sg_estado;
           
       }
       
       $ps->close();
       
       $est = array();
       
       foreach($cidades as $key=>$c){
           
           $e = $estados[$key];
           
           $k = null;
           
           foreach($est as $key2=>$value2){
               
               if($value2->sigla==$e){
                   
                   $k = $value2;
                   break;
                   
               }
               
           }
           
           if($k == null){
               
               $k = new Estado();
               
               $k->sigla = $e;
               
               $k->merge($con);
               
               $est[] = $k;
               
           }
           
           $cidade = new Cidade();
           $cidade->nome = $c;
           $cidade->estado = $k;
           $cidade->merge($con);
           
       }
       
    }

}
