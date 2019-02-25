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
        $matriz = new Empresa(1734);

        $bancos_filial = array();
        $bancos_matriz = array();

        $ps = $con->getConexao()->prepare("SELECT id,codigo FROM banco WHERE id_empresa=$filial->id");
        $ps->execute();
        $ps->bind_result($id, $codigo);
        while ($ps->fetch()) {
            $b = new Banco();
            $b->id = $id;
            $b->codigo = $codigo;
            $bancos_filial[$codigo] = $b;
        }
        $ps->close();

        $ps = $con->getConexao()->prepare("SELECT id,codigo FROM banco WHERE id_empresa=$matriz->id");
        $ps->execute();
        $ps->bind_result($id, $codigo);
        while ($ps->fetch()) {
            $b = new Banco();
            $b->id = $id;
            $b->codigo = $codigo;
            $bancos_matriz[$codigo] = $b;
        }
        $ps->close();

        //--------------------------------------

        $fichas_filial = "(-1";

        $ps = $con->getConexao()->prepare("SELECT ficha FROM nota WHERE id_empresa=$filial->id");
        $ps->execute();
        $ps->bind_result($ficha);
        while ($ps->fetch()) {
            $fichas_filial .= ",$ficha";
        }
        $ps->close();

        $fichas_filial .= ")";
        $datas = array();
        $movimentos = array();
        $ps = $this->getConexao()->prepare("SELECT ID_FICHA,ID_BANCO,ID_OPERACAO,ID_HISTORICO,VALOR,JUROS,DESCONTO,SALDO,NUMERO_PARCELA,UNIX_TIMESTAMP(DATA)*1000 FROM AF_financeiro_filial17.MOVIMENTO WHERE ID_FICHA IN $fichas_filial ORDER BY DATA,NUMERO_PARCELA");
        $ps->execute();
        $ps->bind_result($ficha, $banco, $op, $hist, $val, $jur, $desc, $saldo, $parc, $data);
        while ($ps->fetch()) {

            if (!isset($datas[$data])) {
                $datas[$data] = 0;
            }

            $b = $bancos_filial[$banco];

            if ($b === null) {
                echo "Movimento $ficha SEM banco.    ";
                continue;
            }

            $m = new Movimento();
            $m->banco = $b;
            $m->data = $data + $datas[$data];
            $m->descontos = $desc;
            $m->valor = $val;
            $m->juros = $jur;
            $m->operacao = new stdClass();
            $m->operacao->id = $op;
            $m->historico = new stdClass();
            $m->historico->id = $hist;
            $m->ficha = $ficha;
            $m->numero_parcela = $parc;
            $m->saldo_anterior = $saldo;

            $movimentos[] = $m;
            $datas[$data] += 1000;
        }
        $ps->close();

        $vencimentos = array();

        $ps = $con->getConexao()->prepare("SELECT vencimento.id,nota.ficha FROM vencimento INNER JOIN nota ON nota.id=vencimento.id_nota WHERE nota.id_empresa=$filial->id");
        $ps->execute();
        $ps->bind_result($id, $ficha);
        while ($ps->fetch()) {

            if (!isset($vencimentos[$ficha])) {
                $vencimentos[$ficha] = array();
            }

            $vencimentos[$ficha][] = $id;
        }

        $ps->close();

        $mp = array();

        foreach ($movimentos as $key => $value) {

            if (!isset($mp[$value->ficha])) {
                $mp[$value->ficha] = 0;
            }

            $m = $mp[$value->ficha];


            while (!isset($vencimentos[$value->ficha][$m])) {
                $m--;
                if($m<0)continue 2;
            }


            $value->vencimento = new stdClass();
            $value->vencimento->id = $vencimentos[$value->ficha][$m];

            $mp[$value->ficha] ++;

            $value->insert($con, true);
        }

        $fichas_matriz = "(-1";

        $ps = $con->getConexao()->prepare("SELECT ficha FROM nota WHERE id_empresa=$matriz->id");
        $ps->execute();
        $ps->bind_result($ficha);
        while ($ps->fetch()) {
            $fichas_matriz .= ",$ficha";
        }
        $ps->close();

        $fichas_matriz .= ")";

        $movimentos = array();
        $datas = array();
        $ps = $this->getConexao()->prepare("SELECT ID_FICHA,ID_BANCO,ID_OPERACAO,ID_HISTORICO,VALOR,JUROS,DESCONTO,SALDO,NUMERO_PARCELA,UNIX_TIMESTAMP(DATA)*1000 FROM AF_financeiro.MOVIMENTO WHERE ID_FICHA IN $fichas_matriz ORDER BY DATA, NUMERO_PARCELA");
        $ps->execute();
        $ps->bind_result($ficha, $banco, $op, $hist, $val, $jur, $desc, $saldo, $parc, $data);
        while ($ps->fetch()) {
            if (!isset($datas[$data])) {
                $datas[$data] = 0;
            }

            $b = $bancos_matriz[$banco];

            if ($b === null)
                continue;

            $m = new Movimento();
            $m->banco = $b;
            $m->data = $data + $datas[$data];
            $m->descontos = $desc;
            $m->valor = $val;
            $m->juros = $jur;
            $m->operacao = new stdClass();
            $m->operacao->id = $op;
            $m->historico = new stdClass();
            $m->historico->id = $hist;
            $m->ficha = $ficha;
            $m->numero_parcela = $parc;
            $m->saldo_anterior = $saldo;

            $movimentos[] = $m;
            $datas[$data] += 1000;
        }
        $ps->close();

        $vencimentos = array();

        $ps = $con->getConexao()->prepare("SELECT vencimento.id,nota.ficha FROM vencimento INNER JOIN nota ON nota.id=vencimento.id_nota WHERE nota.id_empresa=$matriz->id");
        $ps->execute();
        $ps->bind_result($id, $ficha);
        while ($ps->fetch()) {

            if (!isset($vencimentos[$ficha])) {
                $vencimentos[$ficha] = array();
            }

            $vencimentos[$ficha][] = $id;
        }

        foreach ($movimentos as $key => $value) {

            if (!isset($mp[$value->ficha])) {
                $mp[$value->ficha] = 0;
            }

            $m = $mp[$value->ficha];


            while (!isset($vencimentos[$value->ficha][$m])) {
                $m--;
                if($m<0)continue 2;
            }



            $value->vencimento = new stdClass();
            $value->vencimento->id = $vencimentos[$value->ficha][$m];

            $mp[$value->ficha] ++;

            $value->insert($con, true);
        }
    }

}
