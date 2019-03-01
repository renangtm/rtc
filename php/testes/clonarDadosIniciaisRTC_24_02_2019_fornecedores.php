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

        $cidades = array();

        $ps = $con->getConexao()->prepare("SELECT id,nome FROM cidade");
        $ps->execute();
        $ps->bind_result($id, $nome);
        while ($ps->fetch()) {
            $c = new Cidade();
            $c->id = $id;
            $c->nome = $nome;
            $cidades[] = $c;
        }
        $ps->close();

        $filial = new Empresa(1733);
        $logistic = new Empresa(1735);
        
        

       
    }

}
