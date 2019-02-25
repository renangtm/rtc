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



        $clientes_filial = array();
        $clientes_matriz = array();

        for ($i = 0; $i < 25; $i++) {
            $buffer = $filial->getClientes($con, $i * 2000, ($i + 1) * 2000, "", "");
            foreach ($buffer as $key => $value) {
                $clientes_filial[] = $value;
            }
            $buffer = $matriz->getClientes($con, $i * 2000, ($i + 1) * 2000, "", "");
            foreach ($buffer as $key => $value) {
                $clientes_matriz[] = $value;
            }
        }


        $cli_filial = array();
        $cli_matriz = array();

        foreach ($clientes_filial as $key => $value) {
            $id_reltrab = explode("__", $value->nome_fantasia);
            if (count($id_reltrab) == 2) {
                $id_reltrab = $id_reltrab[1];
            } else {
                $id_reltrab = $id_reltrab[0];
            }
            $cli_filial[$id_reltrab] = $value;
        }

        foreach ($clientes_matriz as $key => $value) {
            $id_reltrab = explode("__", $value->nome_fantasia);
            if (count($id_reltrab) == 2) {
                $id_reltrab = $id_reltrab[1];
            } else {
                $id_reltrab = $id_reltrab[0];
            }
            $cli_matriz[$id_reltrab] = $value;
        }

        $clientes_filial = $cli_filial;
        $clientes_matriz = $cli_matriz;

        
        //------------
        /*
        $g = new Getter($filial);

        $fornecedores_cnpj = array();
        $transportadoras_cnpj = array();
        $transportadora_default = $filial->getTransportadoras($con, 0, 1);
        $transportadora_default = $transportadora_default[0];
        $notas = array();

        $nota = new Nota();

        $ps = $this->getConexao()->prepare("SELECT n.P_NRCONTRO,IFNULL(n.P_OBSERV1,'') like '%Cancel%',n.P_CODCLI,UNIX_TIMESTAMP(n.P_DATAMOV)*1000,n.P_ATIVIDAD,IFNULL(n.P_NUMCHEC,0),IFNULL(t.CNPJ,'123456'),UNIX_TIMESTAMP(IFNULL(p.VENCTO,n.P_DATAMOV))*1000,IFNULL(p.VALOR,n.P_VALOR) FROM db_agrofauna_filial17.CADPED n INNER JOIN db_agrofauna_filial17.FATFCLIE c ON c.CODCLI=n.P_CODCLI LEFT JOIN db_agrofauna.FATFTRAN t ON t.CODTRA=n.P_TRANSPO LEFT JOIN db_agrofauna_filial17.PARCFIC p ON p.FICHA=n.P_NRCONTRO WHERE n.P_DATAMOV > '2014-19-02'");
        $ps->execute();
        $ps->bind_result($ficha, $cancelada, $cod, $data, $es, $nf, $cnpj_transportadora, $vencimento, $valor);
        while ($ps->fetch()) {

            if (!isset($notas[$ficha])) {

                $nota = new Nota();
                $nota->interferir_estoque = false;

                if (!isset($clientes_filial[$cod . ""])) {
                    echo "Ops: Cliente $cod, ";
                    continue;
                }

                $cliente = $clientes_filial[$cod . ""];


                if ($es === 'E') {
                    if (isset($fornecedores_cnpj[$cod])) {
                        $cliente = $fornecedores_cnpj[$cod];
                    } else {
                        $cliente = $g->getFornecedorViaCliente($con, $cliente, false);

                        $fornecedores_cnpj[$cod] = $cliente;
                    }
                    $nota->fornecedor = $cliente;
                } else {
                    $nota->cliente = $cliente;
                }

                $transportadora = null;
                if ($cnpj_transportadora !== '123456') {
                    if (isset($transportadoras_cnpj[$cnpj_transportadora])) {
                        $transportadora = $transportadoras_cnpj[$cnpj_transportadora];
                    } else {
                        $transportadora = $g->getTransportadoraViaCnpj($con, new CNPJ($cnpj_transportadora));
                        $transportadoras_cnpj[$cnpj_transportadora] = $transportadora;
                    }

                    if ($transportadora === null) {
                        $transportadora = $transportadora_default;
                    }
                } else {
                    $transportadora = $transportadora_default;
                }

                $nota->cancelada = $cancelada == 1;
                $nota->emitida = true;
                $nota->data_emissao = $data;
                $nota->empresa = $filial;
                $nota->ficha = $ficha;
                $nota->numero = $nf;
                $nota->saida = $es === 'S';
                $nota->transportadora = $transportadora;
                $nota->forma_pagamento = Sistema::getFormasPagamento();
                $nota->forma_pagamento = $nota->forma_pagamento[0];
                $nota->frete_destinatario_remetente = false;
                $nota->vencimentos = array();
                $nota->produtos = array();

                $notas[$ficha] = $nota;
            }

            $nota = $notas[$ficha];

            $v = new Vencimento();
            $v->valor = $valor;
            $v->data = $vencimento;
            $v->nota = $nota;

            $nota->vencimentos[] = $v;
        }
        $ps->close();
 
        $categoria_default = Sistema::getCategoriaProduto($con);
        $categoria_default = $categoria_default[2];

        $produtos = array();

        $ps = $this->getConexao()->prepare("SELECT n.P_NRCONTRO,p.QTDPRO,p.VALUNI,p.NATOPE,pi.F_DESCRICA,pi.F_CODPROD FROM db_agrofauna_filial17.CADPED n INNER JOIN db_agrofauna_filial17.FATFCLIE c ON c.CODCLI=n.P_CODCLI INNER JOIN db_agrofauna_filial17.COMFPFIC p ON p.CONTRO=n.P_NRCONTRO INNER JOIN db_agrofauna_filial17.PRODUTO pi ON pi.F_CODPROD=p.CODPRO WHERE n.P_DATAMOV > '2014-19-02'");
        $ps->execute();
        $ps->bind_result($ficha, $qtd, $val, $cfop, $nom, $id);
        while ($ps->fetch()) {
            if (!isset($notas[$ficha]))
                continue;


            $nota = $notas[$ficha];

            if (!isset($produtos[$id])) {
                $prod = new Produto();
                $prod->id_universal = $id;
                $prod->nome = $nom;
                $prod->categoria = $categoria_default;
                $prod->empresa = $filial;

                $produtos[$id] = $prod;
            }

            $prod = $produtos[$id];

            $pn = new ProdutoNota();
            $pn->nota = $nota;
            $pn->produto = $prod;
            $pn->quantidade = $qtd;
            $pn->valor_unitario = $val;
            $pn->valor_total = $qtd * $val;
            $pn->cfop = $cfop;

            $nota->produtos[] = $pn;
        }
        $ps->close();

        $produtos = $g->getProdutoViaProduto($con, $produtos);

        foreach ($produtos as $key => $value) {
            $produtos[$value->id_universal] = $value;
        }

        foreach ($notas as $key => $value) {
            foreach ($value->produtos as $key2 => $value2) {
                $value2->produto = $produtos[$value2->produto->id_universal];
            }
            $value->calcularImpostosAutomaticamente();
            $value->validar = false;
            $value->merge($con);
            echo "Inserida a NFE de ficha $value->ficha";
        }
        */
        //------------------------------------------------------- MATRIZ

        $g = new Getter($matriz);

        $fornecedores_cnpj = array();
        $transportadoras_cnpj = array();
        $transportadora_default = $matriz->getTransportadoras($con, 0, 1);
        $transportadora_default = $transportadora_default[0];
        $notas = array();

        $nota = new Nota();

        $ps = $this->getConexao()->prepare("SELECT n.P_NRCONTRO,IFNULL(n.P_OBSERV1,'') like '%Cancel%',n.P_CODCLI,UNIX_TIMESTAMP(n.P_DATAMOV)*1000,n.P_ATIVIDAD,IFNULL(n.P_NUMCHEC,0),IFNULL(t.CNPJ,'123456'),UNIX_TIMESTAMP(IFNULL(p.VENCTO,n.P_DATAMOV))*1000,IFNULL(p.VALOR,n.P_VALOR) FROM db_agrofauna.CADPED n INNER JOIN db_agrofauna.FATFCLIE c ON c.CODCLI=n.P_CODCLI LEFT JOIN db_agrofauna.FATFTRAN t ON t.CODTRA=n.P_TRANSPO LEFT JOIN db_agrofauna.PARCFIC p ON p.FICHA=n.P_NRCONTRO WHERE n.P_DATAMOV > '2014-19-02'");
        $ps->execute();
        $ps->bind_result($ficha, $cancelada, $cod, $data, $es, $nf, $cnpj_transportadora, $vencimento, $valor);
        while ($ps->fetch()) {

            if (!isset($notas[$ficha])) {

                $nota = new Nota();
                $nota->interferir_estoque = false;

                if (!isset($clientes_matriz[$cod . ""])) {
                    echo "Ops: Cliente $cod, nao foi encontrado..     ";
                    continue;
                }

                $cliente = $clientes_matriz[$cod . ""];


                if ($es === 'E') {
                    if (isset($fornecedores_cnpj[$cod])) {
                        $cliente = $fornecedores_cnpj[$cod];
                    } else {
                        $cliente = $g->getFornecedorViaCliente($con, $cliente, false);
                        $fornecedores_cnpj[$cod] = $cliente;
                    }
                    $nota->fornecedor = $cliente;
                } else {
                    $nota->cliente = $cliente;
                }

                $transportadora = null;
                if ($cnpj_transportadora !== '123456') {
                    if (isset($transportadoras_cnpj[$cnpj_transportadora])) {
                        $transportadora = $transportadoras_cnpj[$cnpj_transportadora];
                    } else {
                        $transportadora = $g->getTransportadoraViaCnpj($con, new CNPJ($cnpj_transportadora));
                        $transportadoras_cnpj[$cnpj_transportadora] = $transportadora;
                    }

                    if ($transportadora === null) {
                        $transportadora = $transportadora_default;
                    }
                } else {
                    $transportadora = $transportadora_default;
                }

                $nota->cancelada = $cancelada == 1;
                $nota->emitida = true;
                $nota->data_emissao = $data;
                $nota->empresa = $matriz;
                $nota->ficha = $ficha;
                $nota->numero = $nf;
                $nota->saida = $es === 'S';
                $nota->transportadora = $transportadora;
                $nota->forma_pagamento = Sistema::getFormasPagamento();
                $nota->forma_pagamento = $nota->forma_pagamento[0];
                $nota->frete_destinatario_remetente = false;
                $nota->vencimentos = array();
                $nota->produtos = array();

                $notas[$ficha] = $nota;
            }

            $nota = $notas[$ficha];

            $v = new Vencimento();
            $v->valor = $valor;
            $v->data = $vencimento;
            $v->nota = $nota;

            $nota->vencimentos[] = $v;
        }
        $ps->close();

        $categoria_default = Sistema::getCategoriaProduto($con);
        $categoria_default = $categoria_default[2];

        $produtos = array();

        $ps = $this->getConexao()->prepare("SELECT n.P_NRCONTRO,p.QTDPRO,p.VALUNI,p.NATOPE,pi.F_DESCRICA,pi.F_CODPROD FROM db_agrofauna_filial17.CADPED n INNER JOIN db_agrofauna.FATFCLIE c ON c.CODCLI=n.P_CODCLI INNER JOIN db_agrofauna.COMFPFIC p ON p.CONTRO=n.P_NRCONTRO INNER JOIN db_agrofauna.PRODUTO pi ON pi.F_CODPROD=p.CODPRO WHERE n.P_DATAMOV > '2014-19-02'");
        $ps->execute();
        $ps->bind_result($ficha, $qtd, $val, $cfop, $nom, $id);
        while ($ps->fetch()) {
            if (!isset($notas[$ficha]))
                continue;

            $nota = $notas[$ficha];

            if (!isset($produtos[$id])) {
                $prod = new Produto();
                $prod->id_universal = $id;
                $prod->nome = $nom;
                $prod->categoria = $categoria_default;
                $prod->empresa = $filial;

                $produtos[$id] = $prod;
            }

            $prod = $produtos[$id];

            $pn = new ProdutoNota();
            $pn->nota = $nota;
            $pn->produto = $prod;
            $pn->quantidade = $qtd;
            $pn->valor_unitario = $val;
            $pn->valor_total = $qtd * $val;
            $pn->cfop = $cfop;

            $nota->produtos[] = $pn;
        }
        $ps->close();

        $produtos = $g->getProdutoViaProduto($con, $produtos);

        foreach ($produtos as $key => $value) {
            $produtos[$value->id_universal] = $value;
        }

        foreach ($notas as $key => $value) {
            foreach ($value->produtos as $key2 => $value2) {
                $value2->produto = $produtos[$value2->produto->id_universal];
            }
            $value->calcularImpostosAutomaticamente();
            $value->validar = false;
            $value->merge($con);
            echo "Inserida a NFE de ficha $value->ficha";
        }
    }

}
