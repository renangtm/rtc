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

        if (true) {

            //retire para realmente executar o script
            //return;
        }

        //inserindo cidades e estados

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
        $ps->bind_result($nome, $sg_estado);

        while ($ps->fetch()) {

            $cidades[] = $nome;
            $estados[] = $sg_estado;
        }

        $ps->close();

        $est = array();
        $cids = array();
        foreach ($cidades as $key => $c) {

            $e = $estados[$key];

            $k = null;

            foreach ($est as $key2 => $value2) {

                if ($value2->sigla == $e) {

                    $k = $value2;
                    break;
                }
            }

            if ($k == null) {

                $k = new Estado();

                $k->sigla = $e;

                $k->merge($con);

                $est[] = $k;
            }

            $cidade = new Cidade();
            $cidade->nome = $c;
            $cidade->estado = $k;
            $cidade->merge($con);
            $cids[] = $cidade;
        }
        $cidades = $cids;
        // criando empresa
        
        $ps = $con->getConexao()->prepare("DELETE FROM empresa");
        $ps->execute();
        $ps->close();
        
        $ps = $con->getConexao()->prepare("DELETE FROM logo");
        $ps->execute();
        $ps->close();
        
        $ps = $con->getConexao()->prepare("DELETE FROM parametros_emissao");
        $ps->execute();
        $ps->close();

        $af = new Empresa();
        $af->cnpj = new CNPJ("47626510001708");
        $af->inscricao_estadual = "796.512.644.111";
        $af->nome = "Agro Fauna Filial";
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
        $end->rua = "RUA PROFESSOR JOAO CAVALEIRO SALEM";

        $af->endereco = $end;

        $af->merge($con);

        $melhor_rtc = Sistema::getRTCS();
        $melhor_rtc = $melhor_rtc[count($melhor_rtc) - 1];

        $af->setRTC($con, $melhor_rtc);
        $af->setLogo($con, 'http://www.tratordecompras.com.br/renew/Status_3/php/uploads/arquivo_15501989058192.png');


        // categorias de cliente;

        $ps = $con->getConexao()->prepare("DELETE FROM novo_rtc.categoria_cliente");
        $ps->execute();
        $ps->close();


        $c = new CategoriaCliente();
        $c->nome = "Micro empresa";
        $c->merge($con);

        $c = new CategoriaCliente();
        $c->nome = "Pequeno Porte";
        $c->merge($con);

        $c = new CategoriaCliente();
        $c->nome = "Medio Porte";
       $c->merge($con);

        $c = new CategoriaCliente();
        $c->nome = "Grande Porte";
        $c->merge($con);

        $c = new CategoriaCliente();
        $c->nome = "Sem categoria";
        $c->merge($con);

        // ------------------------------

        $ps = $con->getConexao()->prepare("DELETE FROM novo_rtc.cliente");
        $ps->execute();
        $ps->close();

        $ps = $this->getConexao()->prepare("SELECT c.CODCLI,"
                . "c.NOMFAN,"
                . "c.NOMCLI,"
                . "GROUP_CONCAT(IFNULL(t.TELEFONE,'00000000') separator ';'),"
                . "c.ENDPRI,c.NUMRES,cid.NOMCID,cid.ESTCID,"
                . "c.CEPPRI,c.CGCCPF,INSEST,c.EMAIL,ia.INSCRICAO_SUFRAMA,(ia.REGULAR_SUFRAMA='S' AND ia.ISENCAO_SUFRAMA='S') FROM db_agrofauna.FATFCLIE c LEFT JOIN db_agrofauna.TELEFONE t ON t.CODCLI=c.CODCLI "
                . "INNER JOIN db_agrofauna.FATFCIDI cid ON cid.CODCID=c.CODCID INNER JOIN db_agrofauna.INFO_ADIC_CLIENTE ia ON ia.CODIGO_CLIENTE=c.CODCLI WHERE c.ativo=1 GROUP BY c.CODCLI");
        $ps->execute();
        $ps->bind_result($codigo, $nomfan, $nomcli, $telefones, $endereco, $numero, $cidade, $estado, $cep, $cnpj, $ie, $email, $suf, $ise);
        $clientes = array();
        while ($ps->fetch()) {

            $cliente = new Cliente();
            $cliente->nome_fantasia = $nomfan;
            $cliente->razao_social = $nomcli;
            $cliente->codigo = $codigo;

            $tels = array();
            $ts = explode(';', $telefones);
            foreach ($ts as $key => $value) {
                $tels[] = new Telefone($value);
            }

            $cliente->telefones = $tels;
            $cliente->email = new Email($email);
            $cliente->inscricao_estadual = $ie;
            $cliente->cnpj = new CNPJ($cnpj);
            $cliente->pessoa_fisica = false;
            $cliente->empresa = $af;

            $end = new Endereco();
            $end->rua = $endereco;
            $end->cep = new CEP($cep);
            $end->numero = $numero;

            $cliente->categoria = $c;

            if ($ise) {

                $cliente->suframado = true;
                $cliente->inscricao_suframa = $suf;
            } else {

                $cliente->suframado = false;
            }

            foreach ($cidades as $key => $value) {

                if (strtoupper($value->nome) === strtoupper($cidade) || strtoupper($value->nome) === strtoupper($cidade . " " . $estado)) {

                    $end->cidade = $value;
                    break;
                }
            }

            $cliente->endereco = $end;

            $clientes[] = $cliente;
        }
        $ps->close();

        foreach ($clientes as $key => $value) {

            $value->merge($con);
            $ps = $con->getConexao()->prepare("UPDATE cliente SET id=$value->codigo WHERE id=$value->id");
            $value->id = $value->codigo;
            $value->merge($con);
            $ps->execute();
            $ps->close();
        }
        
        
        
        
    }

}
