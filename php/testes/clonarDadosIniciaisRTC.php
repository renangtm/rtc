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

        // deletando lixo

        $ps = $con->getConexao()->prepare("DELETE FROM endereco");
        $ps->execute();
        $ps->close();

        $ps = $con->getConexao()->prepare("DELETE FROM telefone");
        $ps->execute();
        $ps->close();

        $ps = $con->getConexao()->prepare("DELETE FROM email");
        $ps->execute();
        $ps->close();

        //inserindo cidades e estados

        $estados = array();
        $ids_cidades = array();
        $cidades = array();

        $ps = $con->getConexao()->prepare("DELETE FROM novo_rtc.cidade");
        $ps->execute();
        $ps->close();

        $ps = $con->getConexao()->prepare("DELETE FROM novo_rtc.estado");
        $ps->execute();
        $ps->close();

        $ps = $this->getConexao()->prepare("SELECT id,nome, estado FROM status_3.cidades");
        $ps->execute();
        $ps->bind_result($id, $nome, $sg_estado);

        while ($ps->fetch()) {
            $ids_cidades[] = $id;
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

            $id_cidade = $ids_cidades[$key];

            $cidade = new Cidade();
            $cidade->nome = $c;
            $cidade->estado = $k;
            $cidade->merge($con);

            $ps = $con->getConexao()->prepare("UPDATE cidade SET id=$id_cidade WHERE id=$cidade->id");
            $ps->execute();
            $ps->close();

            $cidade->id = $id_cidade;

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
        /*
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

          if (Utilidades::eq($value->nome) === Utilidades::eq($cidade) || Utilidades::eq($value->nome) === Utilidades::eq($cidade . " " . $estado)) {

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
          $ps->execute();
          $ps->close();
          $value->id = $value->codigo;
          $value->merge($con);

          }
         */
        // criando usuarios

        $ps = $con->getConexao()->prepare("DELETE FROM usuario");
        $ps->execute();
        $ps->close();

        $usuarios = array();
        $ps = $con->getConexao()->prepare("SELECT nome, login, senha, IFNULL(email,''), senha_email FROM rtc.usuarios WHERE id_empresa=5");
        $ps->execute();
        $ps->bind_result($nome, $login, $senha, $email, $senha_email);
        while ($ps->fetch()) {

            $u = new Usuario();
            $u->empresa = $af;
            $u->nome = $nome;
            $u->login = $login;
            $u->senha = $senha;


            $u->email = new Email($email);
            $u->email->senha = $senha_email;

            $end = new Endereco();

            $end->cidade = $cidades[0];

            $u->endereco = $end;

            $usuarios[] = $u;
        }
        $ps->close();

        foreach ($usuarios as $key => $value) {

            $value->merge($con);
        }

        // passando grupos de cidades;
        $ps = $con->getConexao()->prepare("DELETE FROM tabela");
        $ps->execute();
        $ps->close();

        $ps = $con->getConexao()->prepare("DELETE FROM regra_tabela");
        $ps->execute();
        $ps->close();

        $ps = $con->getConexao()->prepare("DELETE FROM grupo_cidade");
        $ps->execute();
        $ps->close();

        $ps = $con->getConexao()->prepare("DELETE FROM grupo_cidades");
        $ps->execute();
        $ps->close();

        $grupos = array();
        $ps = $this->getConexao()->prepare("SELECT g.id,g.nome,gc.id_cidade FROM status_3.grupos_cidade g INNER JOIN status_3.cidade_grupo gc ON gc.id_grupo=g.id");
        $ps->execute();
        $ps->bind_result($id, $nome, $id_cidade);
        while ($ps->fetch()) {

            if (!isset($grupos[$id])) {
                $g = new GrupoCidades();
                $g->empresa = $af;
                $g->nome = $nome;
                $g->cidades = array();
                $grupos[$id] = $g;
            }

            $cid = new Cidade();
            $cid->id = $id_cidade;

            $grupos[$id]->cidades[] = $cid;
        }

        $ps->close();

        foreach ($grupos as $key => $value) {

            $value->merge($con);

            $ps = $con->getConexao()->prepare("UPDATE grupo_cidades SET id=$key WHERE id=$value->id");
            $ps->execute();
            $ps->close();

            $ps = $con->getConexao()->prepare("UPDATE grupo_cidade SET id_grupo=$key WHERE id_grupo=$value->id");
            $ps->execute();
            $ps->close();
        }

        $ps = $con->getConexao()->prepare("DELETE FROM tabela");
        $ps->execute();
        $ps->close();
        
        $ps = $con->getConexao()->prepare("DELETE FROM transportadora");
        $ps->execute();
        $ps->close();

        $tabelas = array();
        $ps = $this->getConexao()->prepare("SELECT t.id,t.id_transportadora,t.nome, r.condicional, r.expressao FROM status_3.tabelas t INNER JOIN status_3.regras r ON r.id_tabela=t.id");
        $ps->execute();
        $ps->bind_result($id, $id_transp, $nome, $conf, $exp);
        $tabela_transp = array();
        while ($ps->fetch()) {

            if (!isset($tabelas[$id_transp])) {

                $t = new Tabela();
                $t->nome = $nome;
                $t->regras = array();
                $t->id_transp = $id_transp;
                $tabelas[$id_transp] = $t;
                $tabela_transp[$id_transp] = $t;
            }

            $r = new RegraTabela();
            $r->condicional = $conf;
            $r->resultante = $exp;

            $tabelas[$id_transp]->regras[] = $r;
        }

        $ps->close();

        foreach ($tabelas as $key => $value) {

            $value->merge($con);

            $ps = $con->getConexao()->prepare("UPDATE tabela SET id_transportadora=$value->id_transp WHERE id=$value->id");
            $ps->execute();
            $ps->close();
        }

        // passagem de transportadoras

        $transportadoras = array();
        $ps = $this->getConexao()->prepare("SELECT t.CODTRA,t.NOMFAN,t.RAZSOC,t.ENDERE,t.BAIRRO,t.NUMERO,cid.NOMCID,cid.ESTCID,t.NUMCEP,IFNULL(t.TELEF1,'0000000'),IFNULL(t.TELEF2,'000000'),t.CNPJ,t.IE,t.EMAIL FROM db_agrofauna.FATFTRAN t INNER JOIN db_agrofauna.FATFCIDI cid ON cid.CODCID=t.CODCID WHERE t.RAZSOC <> '' AND t.RAZSOC IS NOT NULL");
        $ps->execute();
        $ps->bind_result($id, $nomfan, $nom, $endereco, $bairro, $numero, $cidade, $estado, $cep, $tel1, $tel2, $cnpj, $ie, $email);

        while ($ps->fetch()) {

            $transportadora = new Transportadora();
            if (isset($tabela_transp[$id])) {
                $transportadora->tabela = $tabela_transp[$id];
            }
            $transportadora->despacho = 0;
            $transportadora->email = new Email($email);
            $transportadora->empresa = $af;
            $transportadora->nome_fantasia = $nomfan;
            $transportadora->razao_social = $nom;
            $transportadora->telefones = array(new Telefone($tel1), new Telefone($tel2));
            $transportadora->inscricao_estadual = $ie;
            $transportadora->cnpj = new CNPJ($cnpj);

            $end = new Endereco();
            $end->rua = $endereco;
            $end->cep = new CEP($cep);
            $end->numero = $numero;

            foreach ($cidades as $key => $value) {

                if (Utilidades::eq($value->nome) === Utilidades::eq($cidade) || Utilidades::eq($value->nome) === Utilidades::eq($cidade . " " . $estado)) {

                    $end->cidade = $value;
                    break;
                    
                }
            }

            $transportadora->endereco = $end;

            $transportadoras[$id] = $transportadora;
        }

        $ps->close();

        foreach ($transportadoras as $key => $value) {

            $value->merge($con);
            $ps = $con->getConexao()->prepare("UPDATE transportadora SET id=$key WHERE id=$value->id");
            $ps->execute();
            $ps->close();
            $value->id = $key;
            $value->merge($con);
        }

        $ps = $con->getConexao()->prepare("DELETE FROM fornecedor");

        // passagem de fornecedores

        $fornecedores = array();
        $ps = $this->getConexao()->prepare("SELECT DISTINCT fp.ID_CLIENTE, c.NOMCLI,c.NOMFAN,c.CGCCPF,"
                . "c.INSEST,GROUP_CONCAT(IFNULL(t.TELEFONE,'00000000') separator ';'),"
                . "cid.NOMCID,cid.ESTCID,c.ENDPRI,c.NUMRES,c.BAIPRI,c.CEPPRI,c.EMAIL "
                . "FROM db_agrofauna.FATFCLIE c JOIN db_agrofauna.FORNECEDOR_PRODUTO fp ON c.CODCLI = fp.ID_CLIENTE"
                . " LEFT JOIN db_agrofauna.TELEFONE t ON t.CODCLI=c.CODCLI"
                . " INNER JOIN db_agrofauna.FATFCIDI cid ON cid.CODCID=c.CODCID GROUP BY c.CODCLI");
        $ps->execute();
        $ps->bind_result($id, $nom, $nomfan, $cnpj, $ie, $telefones, $cidade, $estado, $endereco, $numero, $bairro, $cep, $email);

        while ($ps->fetch()) {

            $fornecedor = new Fornecedor();
            $fornecedor->nome = $nom;
            $fornecedor->cnpj = new CNPJ($cnpj);
            $fornecedor->inscricao_estadual = $ie;

            $tels = array();
            $ts = explode(';', $telefones);
            foreach ($ts as $key => $value) {
                $tels[] = new Telefone($value);
            }

            $fornecedor->telefones = $tels;
            $fornecedor->email = new Email($email);
            $fornecedor->empresa = $af;

            $end = new Endereco();
            $end->rua = $endereco;
            $end->cep = new CEP($cep);
            $end->numero = $numero;

            foreach ($cidades as $key => $value) {

                if (Utilidades::eq($value->nome) === Utilidades::eq($cidade) || Utilidades::eq($value->nome) === Utilidades::eq($cidade . " " . $estado)) {

                    $end->cidade = $value;
                    break;
                }
            }

            $fornecedor->endereco = $end;

            $fornecedores[$id] = $fornecedor;
        }

        $ps->close();

        foreach ($fornecedores as $key => $value) {

            $value->merge($con);

            $ps = $con->getConexao()->prepare("UPDATE fornecedor SET id=$key WHERE id=$value->id");
            $ps->execute();
            $ps->close();

            $value->id = $key;
            $value->merge($con);
        }
        
        
        
        
    }

}
