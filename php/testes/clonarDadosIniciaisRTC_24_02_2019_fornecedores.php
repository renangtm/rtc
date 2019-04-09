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

class clonarDadosIniciaisRTC extends PHPUnit_Framework_TestCase {

    private static $conexao;

    public function getConexao() {

        if (self::$conexao == null) {
            self::$conexao = new mysqli("192.168.0.104", "SYSTEMUSER", "senha5dosistema1", "db_agrofauna", 10049);
        }

        return self::$conexao;
    }

    public function testSimple() {

        $con = new ConnectionFactory();

        if (true) {

            //retire para realmente executar o script
            //return;
        }
        
        $cidade = array();
        $ps = $this->getConexao()->prepare("SELECT nome,codigoIBGE FROM status_3.cidades");
        $ps->execute();
        $ps->bind_result($nome,$codigo);
        while($ps->fetch()){
            $cidade[$nome] = $codigo;
        }
        $ps->close();
        foreach($cidade as $key=>$value){
            $ps = $con->getConexao()->prepare("UPDATE cidade SET codigoIBGE='$value' WHERE nome='".addslashes($key)."'");
            $ps->execute();
            $ps->close();
        }
        
        return;
        
        $filial = new Empresa(1733);
        $logistic = new Empresa(1735);
        
        $fornecedores = $filial->getFornecedores($con,0,10000,'','');
        
        foreach($fornecedores as $key=>$value){
            
            $copia = Utilidades::copyId0($value);
            
            $copia->endereco->id = 0;
            $copia->email->id = 0;
            $copia->telefones = array();
            $copia->empresa = $logistic;
            
            $copia->merge($con);
           
            
        }

       
    }

}
