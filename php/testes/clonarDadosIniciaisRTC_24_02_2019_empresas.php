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

        $af = new Agronomia();
        $af->tipo_empresa = 6;
        $af->cnpj = new CNPJ("47626510001708");
        $af->inscricao_estadual = "796.512.644.111";
        $af->nome = "Agronomia Virtual";
        $af->consigna = true;
        $af->aceitou_contrato = true;
        $af->juros_mensal = 1.5;
        $af->telefone = new Telefone("1122552255");

        $end = new Endereco();

        foreach ($cidades as $key => $value) {
            if (strtolower($value->nome) === strtolower('guarulhos')) {
                $end->cidade = $value;
                break;
            }
        }

        $end->bairro = "PARQUE DAS NACOES";
        $end->cep = new CEP("07243580");
        $end->numero = "1138";
        $end->rua = "RUA ANTONIO MESTRINER";

        $af->endereco = $end;

        $af->merge($con);

        $melhor_rtc = Sistema::getRTCS();
        $melhor_rtc = $melhor_rtc[count($melhor_rtc) - 1];

        $af->setRTC($con, $melhor_rtc);
        $af->setLogo($con, 'http://www.tratordecompras.com.br/renew/Status_3/php/uploads/arquivo_15501989058192.png');

        $filial->setFilial($con, $af);

        $usuario = $filial->getUsuarios($con,0, 1);
        $usuario = $usuario[0];

        $usuario->id = 0;
        $usuario->endereco->id = 0;
        foreach ($usuario->telefones as $key => $value) {
            $value->id = 0;
        }
        $usuario->email->id = 0;
        $usuario->empresa = $af;
        $usuario->login = $usuario->login."_help";
        $usuario->merge($con);
    }

}
