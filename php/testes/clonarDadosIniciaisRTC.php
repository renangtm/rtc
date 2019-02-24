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
        /*
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

          $ma = new Empresa();
          $ma->cnpj = new CNPJ("47626510000132");
          $ma->inscricao_estadual = "647.097.432.115";
          $ma->nome = "Agro Fauna Matriz";
          $ma->consigna = true;
          $ma->aceitou_contrato = true;
          $ma->juros_mensal = 1.5;
          $ma->telefone = new Telefone("1122552255");

          $end = new Endereco();

          foreach ($cidades as $key => $value) {
          if (strtolower($value->nome) === strtolower('sao jose do rio preto')) {
          $end->cidade = $value;
          break;
          }
          }

          $end->bairro = "jd a alegre";
          $end->cep = new CEP("15055000");
          $end->numero = "1171";
          $end->rua = "RUA COUTINHO CAVALCANTI";

          $ma->endereco = $end;

          $ma->merge($con);

          $melhor_rtc = Sistema::getRTCS();
          $melhor_rtc = $melhor_rtc[count($melhor_rtc) - 1];

          $ma->setRTC($con, $melhor_rtc);
          $ma->setLogo($con, 'http://www.tratordecompras.com.br/renew/Status_3/php/uploads/arquivo_15501989058192.png');


          $lo = new Empresa();
          $lo->is_logistica = true;
          $lo->cnpj = new CNPJ("47626510001708");
          $lo->inscricao_estadual = "796.512.644.111";
          $lo->nome = "Agro Fauna Filial";
          $lo->consigna = true;
          $lo->aceitou_contrato = true;
          $lo->juros_mensal = 1.5;
          $lo->telefone = new Telefone("1122552255");

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

          $lo->endereco = $end;

          $lo->merge($con);

          $melhor_rtc = Sistema::getRTCS();
          $melhor_rtc = $melhor_rtc[count($melhor_rtc) - 1];

          $lo->setRTC($con, $melhor_rtc);
          $lo->setLogo($con, 'http://www.tratordecompras.com.br/renew/Status_3/php/uploads/arquivo_15502590195234.jpg');

          $getter = new Getter($lo);
          $getter->getClienteViaEmpresa($con, $af);
          $getter->getFornecedorViaEmpresa($con, $af);

          $getter = new Getter($af);
          $getter->getClienteViaEmpresa($con, $lo);
          $getter->getFornecedorViaEmpresa($con, $lo);

          $af->setFilial($con, $ma);

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
          . "fn_remove_accents(c.NOMFAN),"
          . "fn_remove_accents(c.NOMCLI),"
          . "GROUP_CONCAT(IFNULL(t.TELEFONE,'00000000') separator ';'),"
          . "c.ENDPRI,c.NUMRES,fn_remove_accents(cid.NOMCID),cid.ESTCID,"
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

          // criando usuarios

          $ps = $con->getConexao()->prepare("DELETE FROM usuario");
          $ps->execute();
          $ps->close();

          $usuarios = array();
          $ps = $con->getConexao()->prepare("SELECT fn_remove_accents(nome), login, senha, IFNULL(email,''), senha_email FROM rtc.usuarios WHERE id_empresa=5");
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
          $ps = $this->getConexao()->prepare("SELECT t.id,t.id_transportadora,fn_remove_accents(t.nome), r.condicional, r.expressao FROM status_3.tabelas t INNER JOIN status_3.regras r ON r.id_tabela=t.id");
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

          }

          // passagem de transportadoras

          $transportadoras = array();
          $ps = $this->getConexao()->prepare("SELECT t.CODTRA,fn_remove_accents(t.NOMFAN),fn_remove_accents(t.RAZSOC),t.ENDERE,t.BAIRRO,t.NUMERO,fn_remove_accents(cid.NOMCID),cid.ESTCID,t.NUMCEP,IFNULL(t.TELEF1,'0000000'),IFNULL(t.TELEF2,'000000'),t.CNPJ,t.IE,t.EMAIL FROM db_agrofauna.FATFTRAN t INNER JOIN db_agrofauna.FATFCIDI cid ON cid.CODCID=t.CODCID WHERE t.RAZSOC <> '' AND t.RAZSOC IS NOT NULL");
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
          $ps = $this->getConexao()->prepare("SELECT DISTINCT fp.ID_CLIENTE, fn_remove_accents(c.NOMCLI),fn_remove_accents(c.NOMFAN),c.CGCCPF,"
          . "c.INSEST,GROUP_CONCAT(IFNULL(t.TELEFONE,'00000000') separator ';'),"
          . "fn_remove_accents(cid.NOMCID),cid.ESTCID,c.ENDPRI,c.NUMRES,c.BAIPRI,c.CEPPRI,c.EMAIL "
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

          // ---------------- COPIA LOGISTIC

          $usuarios = array();
          $ps = $con->getConexao()->prepare("SELECT fn_remove_accents(nome), login, senha, IFNULL(email,''), senha_email FROM rtc.usuarios WHERE id_empresa=5");
          $ps->execute();
          $ps->bind_result($nome, $login, $senha, $email, $senha_email);
          while ($ps->fetch()) {

          $u = new Usuario();
          $u->empresa = $lo;
          $u->nome = $nome;
          $u->login = $login."_logistic";
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

          $tabelas = array();
          $ps = $this->getConexao()->prepare("SELECT t.id,t.id_transportadora,fn_remove_accents(t.nome), r.condicional, r.expressao FROM status_3.tabelas t INNER JOIN status_3.regras r ON r.id_tabela=t.id");
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
          }

          $transportadoras = array();
          $ps = $this->getConexao()->prepare("SELECT t.CODTRA,fn_remove_accents(t.NOMFAN),fn_remove_accents(t.RAZSOC),t.ENDERE,t.BAIRRO,t.NUMERO,fn_remove_accents(cid.NOMCID),cid.ESTCID,t.NUMCEP,IFNULL(t.TELEF1,'0000000'),IFNULL(t.TELEF2,'000000'),t.CNPJ,t.IE,t.EMAIL FROM db_agrofauna.FATFTRAN t INNER JOIN db_agrofauna.FATFCIDI cid ON cid.CODCID=t.CODCID WHERE t.RAZSOC <> '' AND t.RAZSOC IS NOT NULL");
          $ps->execute();
          $ps->bind_result($id, $nomfan, $nom, $endereco, $bairro, $numero, $cidade, $estado, $cep, $tel1, $tel2, $cnpj, $ie, $email);

          while ($ps->fetch()) {

          $transportadora = new Transportadora();
          if (isset($tabela_transp[$id])) {
          $transportadora->tabela = $tabela_transp[$id];
          }
          $transportadora->despacho = 0;
          $transportadora->email = new Email($email);
          $transportadora->empresa = $lo;
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
          }


          //----------------- COPIA MATRIZ

          $ps = $this->getConexao()->prepare("SELECT c.CODCLI,"
          . "fn_remove_accents(c.NOMFAN),"
          . "fn_remove_accents(c.NOMCLI),"
          . "GROUP_CONCAT(IFNULL(t.TELEFONE,'00000000') separator ';'),"
          . "c.ENDPRI,c.NUMRES,fn_remove_accents(cid.NOMCID),cid.ESTCID,"
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
          $cliente->empresa = $ma;

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
          }

          // criando usuarios

          $usuarios = array();
          $ps = $con->getConexao()->prepare("SELECT fn_remove_accents(nome), login, senha, IFNULL(email,''), senha_email FROM rtc.usuarios WHERE id_empresa=5");
          $ps->execute();
          $ps->bind_result($nome, $login, $senha, $email, $senha_email);
          while ($ps->fetch()) {

          $u = new Usuario();
          $u->empresa = $ma;
          $u->nome = $nome;
          $u->login = $login."_matriz";
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



          // passagem de transportadoras

          $transportadoras = array();
          $ps = $this->getConexao()->prepare("SELECT t.CODTRA,fn_remove_accents(t.NOMFAN),fn_remove_accents(t.RAZSOC),t.ENDERE,t.BAIRRO,t.NUMERO,fn_remove_accents(cid.NOMCID),cid.ESTCID,t.NUMCEP,IFNULL(t.TELEF1,'0000000'),IFNULL(t.TELEF2,'000000'),t.CNPJ,t.IE,t.EMAIL FROM db_agrofauna.FATFTRAN t INNER JOIN db_agrofauna.FATFCIDI cid ON cid.CODCID=t.CODCID WHERE t.RAZSOC <> '' AND t.RAZSOC IS NOT NULL");
          $ps->execute();
          $ps->bind_result($id, $nomfan, $nom, $endereco, $bairro, $numero, $cidade, $estado, $cep, $tel1, $tel2, $cnpj, $ie, $email);

          while ($ps->fetch()) {

          $transportadora = new Transportadora();
          $transportadora->despacho = 0;
          $transportadora->email = new Email($email);
          $transportadora->empresa = $ma;
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
          }

          // passagem de fornecedores

          $fornecedores = array();
          $ps = $this->getConexao()->prepare("SELECT DISTINCT fp.ID_CLIENTE, fn_remove_accents(c.NOMCLI),fn_remove_accents(c.NOMFAN),c.CGCCPF,"
          . "c.INSEST,GROUP_CONCAT(IFNULL(t.TELEFONE,'00000000') separator ';'),"
          . "fn_remove_accents(cid.NOMCID),cid.ESTCID,c.ENDPRI,c.NUMRES,c.BAIPRI,c.CEPPRI,c.EMAIL "
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
          $fornecedor->empresa = $ma;

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
          }
         */
        /*
          $af = new Empresa(104);
          $ma = new Empresa(105);
          $lo = new Empresa(106);


          //---- categorias de produto;

          $ps = $con->getConexao()->prepare("DELETE FROM categoria_produto");
          $ps->execute();
          $ps->close();

          $cat1 = new CategoriaProduto();
          $cat1->base_calculo = 40;
          $cat1->icms_normal = true;
          $cat1->nome = "Agricola";
          $cat1->merge($con);

          $cat2 = new CategoriaProduto();
          $cat2->base_calculo = 40;
          $cat2->icms_normal = false;
          $cat2->icms = 4;
          $cat2->nome = "Agricola Importado ICMS 4.0";
          $cat2->merge($con);

          $cat3 = new CategoriaProduto();
          $cat3->base_calculo = 100;
          $cat3->icms_normal = true;
          $cat3->nome = "Objeto";
          $cat3->merge($con);

          //----- pragas

          $ps = $con->getConexao()->prepare("DELETE FROM praga");
          $ps->execute();
          $ps->close();

          $ps = $con->getConexao()->prepare("DELETE FROM cultura");
          $ps->execute();
          $ps->close();

          $ps = $con->getConexao()->prepare("DELETE FROM produto");
          $ps->execute();
          $ps->close();

          $ps = $con->getConexao()->prepare("DELETE FROM lote");
          $ps->execute();
          $ps->close();

          $ps = $con->getConexao()->prepare("DELETE FROM receituario");
          $ps->execute();
          $ps->close();

          $pragas = array();
          $ps = $this->getConexao()->prepare("SELECT CODPRA,fn_remove_accents(DESCRI) FROM db_agrofauna.ESTFPRAG");
          $ps->execute();
          $ps->bind_result($id, $nome);
          while ($ps->fetch()) {

          $p = new Praga();
          $p->nome = $nome;
          $pragas[$id] = $p;
          }
          $ps->close();

          foreach ($pragas as $key => $value) {

          $value->merge($con);

          $ps = $con->getConexao()->prepare("UPDATE praga SET id=$key WHERE id=$value->id");
          $ps->execute();
          $ps->close();

          $value->id = $key;

          }

          //----- culturas

          $culturas = array();
          $ps = $this->getConexao()->prepare("SELECT F_CODCULT,fn_remove_accents(F_DESCR) FROM db_agrofauna.CULTURA");
          $ps->execute();
          $ps->bind_result($id, $nome);
          while ($ps->fetch()) {

          $p = new Cultura();
          $p->nome = $nome;
          $culturas[$id] = $p;
          }
          $ps->close();

          foreach ($culturas as $key => $value) {

          $value->merge($con);

          $ps = $con->getConexao()->prepare("UPDATE cultura SET id=$key WHERE id=$value->id");
          $ps->execute();
          $ps->close();

          $value->id = $key;

          }

          //-------------------------------------------

          $receituarios = array();

          $ps = $this->getConexao()->prepare("SELECT m.F_CODCULT,m.F_CODPROD,p.CODPRA,F_EPOCA1 FROM db_agrofauna.MODULO m INNER JOIN db_agrofauna.ESTFPRAG p ON (m.F_PRAGAS1 like CONCAT('%',p.DESCRI) OR m.F_PRAGAS1 like CONCAT(CONCAT(p.DESCRI,'.'),'%') OR m.F_PRAGAS1 like CONCAT(CONCAT(p.DESCRI,','),'%'))");
          $ps->execute();
          $ps->bind_result($id_cultura, $id_produto, $id_praga, $indicacao);
          while ($ps->fetch()) {

          if (!isset($receituarios[$id_produto])) {

          $receituarios[$id_produto] = array();

          }

          if(!isset($culturas[$id_cultura]) || !isset($pragas[$id_praga])){

          continue;
          }

          $r = new Receituario();
          $r->instrucoes = $indicacao;
          $r->cultura = $culturas[$id_cultura];
          $r->praga = $pragas[$id_praga];

          $receituarios[$id_produto][] = $r;
          }

          $ps->close();
          $produtos = array();
          $ps = $this->getConexao()->prepare("SELECT p.F_CODPROD,p.F_DESCRICA,p.F_UNIDADES IN ('Frc','Gl','Bd','Amp'),p.F_UNIDADES,p.F_UNIDADEQ,p.F_PREPRO*2.33,c.PRECUS,IFNULL(a.ATVCF,''),p.F_PESOL,p.F_PESOB,(IFNULL(r.qtd,0)),p.F_QUANTIDA,ll.qtd,p.F_PRATIVO,p.F_CONCENTR,p.F_QECX,IFNULL(pi.nm_link,''),p.F_FABVEND,IFNULL(p.F_CLRISCO,0) FROM db_agrofauna_center.PRODUTO p LEFT JOIN db_agro_matriz.produto_imagem pi ON pi.id_produto=p.F_CODPROD LEFT JOIN (SELECT SUM(rr.QTDRES) as 'qtd',rr.COD_PROD FROM db_agrofauna_filial17.CAD_RES rr GROUP BY rr.COD_PROD) r ON r.COD_PROD=p.F_CODPROD LEFT JOIN db_agrofauna.CADATV a ON a.ATVCOD=p.F_CODPATV INNER JOIN db_agrofauna.FATFCUST c ON c.CODPRO=p.F_CODPROD INNER JOIN (SELECT SUM(l.quantidade_real) as 'qtd',l.id_produto FROM lotes_n.lotes_n l GROUP BY l.id_produto) ll ON ll.id_produto=p.F_CODPROD WHERE F_TIPEST like '%Agric%Lista%' AND p.F_DESCRICA not like '%val%/%'");
          $ps->execute();
          $ps->bind_result($id, $nome, $liquido, $unidade, $quantidade_unidade, $valor_base, $custo, $ncm, $peso_liquido, $peso_bruto, $reserva, $estoque, $lote, $principio_ativo, $concentracao, $grade, $imagem, $fabricante, $classe_risco);
          while ($ps->fetch()) {

          $p = new Produto();
          $p->empresa = $af;
          $p->logistica = $lo;
          $p->id_universal = $id;
          $p->nome = $nome;
          $p->liquido = $liquido == 1;
          $p->unidade = $unidade;
          $p->quantidade_unidade = $quantidade_unidade;
          $p->categoria = $cat1;
          $p->valor_base = round($valor_base, 2);
          $p->custo = round($custo, 2);
          $p->ncm = $ncm;
          $p->peso_bruto = round($peso_bruto, 2);
          $p->peso_liquido = round($peso_liquido,2);
          $p->estoque = max($estoque - $reserva,0);
          $p->disponivel = $p->estoque;
          $p->sistema_lotes = true;
          $p->ativo = $principio_ativo;
          $p->concentracao = $concentracao;
          $p->grade = new Grade(max($grade, 1) . ",1");
          $p->imagem = $imagem;
          $p->fabricante = $fabricante;
          $p->classe_risco = $classe_risco;
          $p->lotes = array();
          $p->aux_lote = 0;
          $produtos[$id] = $p;
          }
          $ps->close();

          $ps = $this->getConexao()->prepare("SELECT id_produto,quantidade_real,lote_fabricante,unidade,rua,numero,altura,UNIX_TIMESTAMP(data_vencimento)*1000 FROM lotes_n.lotes_n WHERE quantidade_real>0 ORDER BY data_vencimento DESC");
          $ps->execute();
          $ps->bind_result($id_produto, $quantidade_real, $lote_fabricante, $grade, $rua, $numero, $altura, $data_vencimento);

          while ($ps->fetch()) {

          if(!isset($produtos[$id_produto]))
          continue;

          $p = $produtos[$id_produto];

          $resto = $p->estoque - $p->aux_lote;

          if ($resto == 0)
          continue;

          $quantidade_real = min($quantidade_real, $resto);
          $p->aux_lote += $quantidade_real;

          $lote = new Lote();
          $lote->codigo_fabricante = $lote_fabricante;
          $lote->quantidade_inicial = $quantidade_real;
          $lote->quantidade_real = $quantidade_real;
          $lote->validade = $data_vencimento;
          $lote->grade = new Grade($grade . ",1");
          $lote->rua = $rua;
          $lote->numero = $numero;
          $lote->altura = $altura;
          $lote->produto = $p;
          $lote->retiradas = array();

          $p->lotes[] = $lote;
          }

          $ps->close();

          foreach ($produtos as $key => $value) {

          $value->merge($con);

          $ps = $con->getConexao()->prepare("UPDATE produto SET id=$key WHERE id=$value->id");
          $ps->execute();
          $ps->close();

          $value->id = $key;

          if (isset($receituarios[$key])) {

          foreach ($receituarios[$key] as $key2 => $value2) {

          $v = Utilidades::copyId0($value2);
          $v->produto = $value;
          $v->merge($con);


          }
          }

          foreach ($value->lotes as $key2 => $value2) {

          $value2->merge($con);
          }
          }

          //------------------------------------------------------------
          //----------------- PASSAGEM MATRIZ

          $produtos = array();
          $ps = $this->getConexao()->prepare("SELECT p.F_CODPROD,p.F_DESCRICA,p.F_UNIDADES IN ('Frc','Gl','Bd','Amp'),p.F_UNIDADES,p.F_UNIDADEQ,p.F_PREPRO*2.33,c.PRECUS,IFNULL(a.ATVCF,''),p.F_PESOL,p.F_PESOB,(IFNULL(r.qtd,0)),p.F_QUANTIDA,ll.qtd,p.F_PRATIVO,p.F_CONCENTR,p.F_QECX,IFNULL(pi.nm_link,''),p.F_FABVEND,IFNULL(p.F_CLRISCO,0) FROM db_agrofauna.PRODUTO p INNER JOIN db_agro_matriz.produto_imagem pi ON pi.id_produto=p.F_CODPROD LEFT JOIN (SELECT 0 as 'qtd',rr.COD_PROD FROM db_agrofauna.CAD_RES rr GROUP BY rr.COD_PROD) r ON r.COD_PROD=p.F_CODPROD LEFT JOIN db_agrofauna.CADATV a ON a.ATVCOD=p.F_CODPATV INNER JOIN db_agrofauna.FATFCUST c ON c.CODPRO=p.F_CODPROD INNER JOIN (SELECT SUM(l.quantidade_real) as 'qtd',l.id_produto FROM lotes_n.lotes_n l GROUP BY l.id_produto) ll ON ll.id_produto=p.F_CODPROD WHERE F_TIPEST like '%Agric%Lista%' AND p.F_DESCRICA not like '%val%/%'");
          $ps->execute();
          $ps->bind_result($id, $nome, $liquido, $unidade, $quantidade_unidade, $valor_base, $custo, $ncm, $peso_liquido, $peso_bruto, $reserva, $estoque, $lote, $principio_ativo, $concentracao, $grade, $imagem, $fabricante, $classe_risco);
          while ($ps->fetch()) {

          $p = new Produto();
          $p->empresa = $ma;
          $p->id_universal = $id;
          $p->nome = $nome;
          $p->liquido = $liquido == 1;
          $p->unidade = $unidade;
          $p->quantidade_unidade = $quantidade_unidade;
          $p->valor_base = round($valor_base, 2);
          $p->custo = round($custo, 2);
          $p->ncm = $ncm;
          $p->peso_bruto = round($peso_bruto, 2);
          $p->peso_liquido = round($peso_liquido,2);
          $p->estoque = max($estoque - $reserva,0);
          $p->disponivel = $p->estoque;
          $p->sistema_lotes = true;
          $p->ativo = $principio_ativo;
          $p->concentracao = $concentracao;
          $p->grade = new Grade(max($grade, 1) . ",1");
          $p->imagem = $imagem;
          $p->fabricante = $fabricante;
          $p->classe_risco = $classe_risco;
          $p->lotes = array();
          $p->categoria = $cat1;
          $p->aux_lote = 0;
          $produtos[$id] = $p;
          }
          $ps->close();

          $ps = $this->getConexao()->prepare("SELECT id_produto,quantidade_real,lote_fabricante,unidade,rua,numero,altura,UNIX_TIMESTAMP(data_vencimento)*1000 FROM lotes_n_matriz.lotes_n WHERE quantidade_real>0 ORDER BY data_vencimento DESC");
          $ps->execute();
          $ps->bind_result($id_produto, $quantidade_real, $lote_fabricante, $grade, $rua, $numero, $altura, $data_vencimento);

          while ($ps->fetch()) {

          if(!isset($produtos[$id_produto]))
          continue;

          $p = $produtos[$id_produto];

          $resto = $p->estoque - $p->aux_lote;

          if ($resto == 0)
          continue;

          $quantidade_real = min($quantidade_real, $resto);
          $p->aux_lote += $quantidade_real;

          $lote = new Lote();
          $lote->codigo_fabricante = $lote_fabricante;
          $lote->quantidade_inicial = $quantidade_real;
          $lote->quantidade_real = $quantidade_real;
          $lote->validade = $data_vencimento;
          $lote->grade = new Grade($grade . ",1");
          $lote->rua = $rua;
          $lote->numero = $numero;
          $lote->altura = $altura;
          $lote->produto = $p;
          $lote->retiradas = array();

          $p->lotes[] = $lote;
          }

          $ps->close();

          foreach ($produtos as $key => $value) {

          $value->merge($con);

          if (isset($receituarios[$key])) {

          foreach ($receituarios[$key] as $key2 => $value2) {

          $v = Utilidades::copyId0($value2);
          $v->produto = $value;
          $v->merge($con);


          }
          }

          foreach ($value->lotes as $key2 => $value2) {

          $value2->merge($con);
          }
          }
         */
        /*
          $ps = $con->getConexao()->prepare("DELETE FROM operacao");
          $ps->execute();
          $ps->close();

          $ps = $con->getConexao()->prepare("DELETE FROM historico");
          $ps->execute();
          $ps->close();

          $ops = array();
          $ps = $this->getConexao()->prepare("SELECT ID,DESCRICAO,TIPO FROM AF_financeiro_filial17.OPERACAO");
          $ps->execute();
          $ps->bind_result($id,$descri,$deb);
          while($ps->fetch()){

          $op = new Operacao();
          $op->nome = $descri;
          $op->debito = $deb==='D';
          $ops[$id] = $op;

          }

          $ps->close();

          foreach($ops as $key=>$value){
          $value->merge($con);
          $ps = $con->getConexao()->prepare("UPDATE operacao SET id=$key WHERE id=$value->id");
          $ps->execute();
          $ps->close();
          }

          $hist = array();
          $ps = $this->getConexao()->prepare("SELECT ID,DESCRICAO FROM AF_financeiro_filial17.HISTORICO");
          $ps->execute();
          $ps->bind_result($id,$descr);
          while($ps->fetch()){
          $h = new Historico();
          $h->nome = $descr;
          $hist[$id] = $h;
          }

          $ps->close();

          foreach($hist as $key=>$value){
          $value->merge($con);
          $ps = $con->getConexao()->prepare("UPDATE historico SET id=$key WHERE id=$value->id");
          $ps->execute();
          $ps->close();
          }
         */
        /*
          $empresas = array();
          $usuarios = array();

          $ps = $con->getConexao()->prepare("SELECT e.nome,e.cnpj,e.email,e.id_cidade,u.nome,u.login,u.senha,u.email FROM rtc.empresas e INNER JOIN rtc.usuarios u ON u.id_empresa=e.id WHERE e.id NOT IN (5,25)");
          $ps->execute();
          $ps->bind_result($ne, $cnpj, $email, $id_cidade, $nome, $login, $senha, $ee);
          while ($ps->fetch()) {


          $ic = $id_cidade-2;
          $ic = 11019 + ($ic*2);
          $id_cidade = $ic;

          $e = new Empresa();
          $e->nome = $ne;
          $e->cnpj = new CNPJ($cnpj);
          $e->email = new Email($email);
          $e->telefone = new Telefone("11111111");
          $end = new Endereco();
          $end->cidade = new Cidade();
          $end->cidade->id = $id_cidade;

          $end->bairro = "nao informado";
          $end->cep = new CEP("11111111");
          $end->numero = "nao informado";
          $end->rua = "nao informado";

          $e->endereco = $end;


          $usu = new Usuario();
          $usu->empresa = $e;
          $usu->senha = $senha;
          $usu->login = $login;
          $usu->nome = $nome;
          $usu->email = new Email($ee);
          $usu->telefones = array(new Telefone("11111111"));
          $end = new Endereco();
          $end->cidade = new Cidade();
          $end->cidade->id = $id_cidade;

          $end->bairro = "nao informado";
          $end->cep = new CEP("11111111");
          $end->numero = "nao informado";
          $end->rua = "nao informado";

          $usu->endereco = $end;

          $usuarios[] = $usu;

          $empresas[] = $e;

          }

          $ps->close();

          foreach($empresas as $key=>$value){

          $value->merge($con);



          }

          foreach($usuarios as $key=>$value){

          $value->merge($con);

          }

          foreach($empresas as $key=>$value){



          $ps = $con->getConexao()->prepare("INSERT INTO novo_rtc.transportadora(razao_social,nome_fantasia,despacho,id_empresa,cnpj,excluida,habilitada,inscricao_estadual) (SELECT razao_social,nome_fantasia,despacho,$value->id,cnpj,excluida,habilitada,inscricao_estadual FROM transportadora WHERE id_empresa=106)");
          $ps->execute();
          $ps->close();

          $ps = $con->getConexao()->prepare("INSERT INTO novo_rtc.logo(logo,cor_predominante,id_empresa) (SELECT logo,cor_predominante,$value->id FROM logo WHERE id_empresa=104)");
          $ps->execute();
          $ps->close();

          }

          $ps = $con->getConexao()->prepare("UPDATE empresa SET rtc=1 WHERE id NOT IN (104,105,106)");
          $ps->execute();
          $ps->close();
         */
        /*
          $validades = array();
          $ps = $this->getConexao()->prepare("SELECT lote_fabricante,UNIX_TIMESTAMP(data_vencimento) FROM lotes_n_matriz.lotes_n");
          $ps->execute();
          $ps->bind_result($fab,$venc);

          while($ps->fetch()){

          $validades[$fab] = $venc;

          }

          $ps->close();

          $lotes = array();
          $ps = $con->getConexao()->prepare("SELECT id,codigo_fabricante FROM lote");
          $ps->execute();
          $ps->bind_result($id,$fab);
          while($ps->fetch()){

          $lotes[$id] = $fab;

          }
          $ps->close();


          foreach($lotes as $key=>$value){

          if(!isset($validades[$value])){
          continue;
          }

          $ps = $con->getConexao()->prepare("UPDATE lote SET validade = FROM_UNIXTIME(".$validades[$value].") WHERE id=$key");
          $ps->execute();
          $ps->close();

          }

         */

        $filial = new Empresa(1733, $con);
        $matriz = new Empresa(1734, $con);

/*
        $empresas = array();

        $ps = $con->getConexao()->prepare("SELECT id FROM empresa WHERE id > 1735");
        $ps->execute();
        $ps->bind_result($ide);
        while ($ps->fetch()) {
            $empresas[] = $ide;
        }
        $ps->close();

        $transportadoras = $matriz->getTransportadoras($con, 0, 100000, "", "");
        foreach ($transportadoras as $key => $value) {

            foreach ($value->telefones as $key2 => $value2) {
                $value2->id = 0;
            }
            foreach ($empresas as $ke => $ide) {
                $value->id = 0;
                $value->tabela = null;
                $value->endereco->id = 0;
                $value->email->id = 0;
                $value->empresa = new stdClass();
                $value->empresa->id = $ide;
                $value->merge($con);
            }
        }
*/
        $classes = array();
        $ps = $this->getConexao()->prepare("SELECT CEIL((k.classe/100)),k.id_produto FROM (SELECT COUNT(*) as 'classe',CODPRO as 'id_produto' FROM db_agrofauna_filial17.COMFPFIC WHERE ATIVID='S' GROUP BY CODPRO) k ORDER BY k.classe DESC");
        $ps->execute();
        $ps->bind_result($classe,$produto);
        while($ps->fetch()){
            $classes[$produto] = $classe;
        }
        $ps->close();
        foreach($classes as $id_produto=>$classe){
            $ps = $con->getConexao()->prepare("UPDATE produto SET classificacao_saida=$classe WHERE id_universal=$id_produto");
            $ps->execute();
            $ps->close();
        }
        /*
        $g = new Getter($filial);

        $clienteFiltradoMatriz = new Cliente();
        $clienteFiltradoMatriz->id = 126280;
        
        $clienteFiltradoFilial = new Cliente();
        $clienteFiltradoFilial->id = 23;
        
        $clientes_cnpj = array();
        $fornecedores_cnpj = array();
        $transportadoras_cnpj = array();
        $notas = array();

        $nota = new Nota();

        $ps = $this->getConexao()->prepare("SELECT n.P_NRCONTRO,IFNULL(n.P_OBSERV1,'') like '%Cancel%',c.CGCCPF,UNIX_TIMESTAMP(n.P_DATAMOV)*1000,n.P_ATIVIDAD,n.P_NUMCHEC,t.CNPJ,UNIX_TIMESTAMP(IFNULL(p.VENCTO,n.P_DATAMOV))*1000,IFNULL(p.VALOR,n.P_VALOR) FROM db_agrofauna_filial17.CADPED n INNER JOIN db_agrofauna_filial17.FATFCLIE c ON c.CODCLI=n.P_CODCLI INNER JOIN db_agrofauna.FATFTRAN t ON t.CODTRA=n.P_TRANSPO LEFT JOIN db_agrofauna_filial17.PARCFIC p ON p.FICHA=n.P_NRCONTRO WHERE n.P_DATAMOV >= '2019-2-22' AND c.CGCCPF IS NOT NULL AND c.CGCCPF <> '' AND n.P_TRANSPO IS NOT NULL AND n.P_TRANSPO <> ''");
        $ps->execute();
        $ps->bind_result($ficha, $cancelada, $cnpj, $data, $es, $nf, $cnpj_transportadora, $vencimento, $valor);
        while ($ps->fetch()) {

            if (!isset($notas[$ficha])) {

                $nota = new Nota();
                $nota->interferir_estoque = false;

                $cliente = null;

                if (isset($clientes_cnpj[$cnpj])) {
                    $cliente = $clientes_cnpj[$cnpj];
                } else {
                    $cliente = $g->getClienteViaCnpj($con, new CNPJ($cnpj));
                    if ($cliente === null) {
                        $cliente = $clienteFiltradoFilial;
                    }
                    $clientes_cnpj[$cnpj] = $cliente;
                }

                if ($es === 'E') {
                    if (isset($fornecedores_cnpj[$cnpj])) {
                        $cliente = $fornecedores_cnpj[$cnpj];
                    } else {
                        $cliente = $g->getFornecedorViaCliente($con, $cliente);
                        if ($cliente === null) {
                            continue;
                             echo "Ficha $ficha, parou por fornecedor ou cliente ";
                        }
                        $fornecedores_cnpj[$cnpj] = $cliente;
                    }
                    $nota->fornecedor = $cliente;
                } else {
                    $nota->cliente = $cliente;
                }

                $transportadora = null;
                if (isset($transportadoras_cnpj[$cnpj_transportadora])) {
                    $transportadora = $transportadoras_cnpj[$cnpj_transportadora];
                } else {
                    $transportadora = $g->getTransportadoraViaCnpj($con, new CNPJ($cnpj_transportadora));
                    $transportadoras_cnpj[$cnpj_transportadora] = $transportadora;
                }

                if ($transportadora === null) {
                    echo "Ficha $ficha, parou por transportadora ";
                    continue;
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

        $ps = $this->getConexao()->prepare("SELECT n.P_NRCONTRO,p.QTDPRO,p.VALUNI,p.NATOPE,pi.F_DESCRICA,pi.F_CODPROD FROM db_agrofauna_filial17.CADPED n INNER JOIN db_agrofauna_filial17.FATFCLIE c ON c.CODCLI=n.P_CODCLI INNER JOIN db_agrofauna_filial17.COMFPFIC p ON p.CONTRO=n.P_NRCONTRO INNER JOIN db_agrofauna_filial17.PRODUTO pi ON pi.F_CODPROD=p.CODPRO INNER JOIN db_agrofauna.FATFTRAN t ON t.CODTRA=n.P_TRANSPO WHERE n.P_DATAMOV > '2014-19-02' AND c.CGCCPF IS NOT NULL AND c.CGCCPF <> '' AND n.P_TRANSPO IS NOT NULL AND n.P_TRANSPO <> '' AND n.P_DATMOV >= '2019-2-22'");
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


        $g = new Getter($matriz);

        $clientes_cnpj = array();
        $fornecedores_cnpj = array();
        $transportadoras_cnpj = array();
        $notas = array();

        $nota = new Nota();

        $ps = $this->getConexao()->prepare("SELECT n.P_NRCONTRO,IFNULL(n.P_OBSERV1,'') like '%Cancel%',c.CGCCPF,UNIX_TIMESTAMP(n.P_DATAMOV)*1000,n.P_ATIVIDAD,n.P_NUMCHEC,t.CNPJ,UNIX_TIMESTAMP(IFNULL(p.VENCTO,n.P_DATAMOV))*1000,IFNULL(p.VALOR,n.P_VALOR) FROM db_agrofauna.CADPED n INNER JOIN db_agrofauna.FATFCLIE c ON c.CODCLI=n.P_CODCLI INNER JOIN db_agrofauna.FATFTRAN t ON t.CODTRA=n.P_TRANSPO LEFT JOIN db_agrofauna.PARCFIC p ON p.FICHA=n.P_NRCONTRO WHERE n.P_DATAMOV >= '2019-2-22' AND c.CGCCPF IS NOT NULL AND c.CGCCPF <> '' AND n.P_TRANSPO IS NOT NULL AND n.P_TRANSPO <> ''");
        $ps->execute();
        $ps->bind_result($ficha, $cancelada, $cnpj, $data, $es, $nf, $cnpj_transportadora, $vencimento, $valor);
        while ($ps->fetch()) {

            if (!isset($notas[$ficha])) {

                $nota = new Nota();
                $nota->interferir_estoque = false;

                $cliente = null;

                if (isset($clientes_cnpj[$cnpj])) {
                    $cliente = $clientes_cnpj[$cnpj];
                } else {
                    $cliente = $g->getClienteViaCnpj($con, new CNPJ($cnpj));
                    if ($cliente === null) {
                        $cliente = $clienteFiltradoMatriz;
                    }
                    $clientes_cnpj[$cnpj] = $cliente;
                }

                if ($es === 'E') {
                    if (isset($fornecedores_cnpj[$cnpj])) {
                        $cliente = $fornecedores_cnpj[$cnpj];
                    } else {
                        $cliente = $g->getFornecedorViaCliente($con, $cliente);
                        if ($cliente === null) {
                            continue;
                        }
                        $fornecedores_cnpj[$cnpj] = $cliente;
                    }
                    $nota->fornecedor = $cliente;
                } else {
                    $nota->cliente = $cliente;
                }

                $transportadora = null;
                if (isset($transportadoras_cnpj[$cnpj_transportadora])) {
                    $transportadora = $transportadoras_cnpj[$cnpj_transportadora];
                } else {
                    $transportadora = $g->getTransportadoraViaCnpj($con, new CNPJ($cnpj_transportadora));
                    $transportadoras_cnpj[$cnpj_transportadora] = $transportadora;
                }

                if ($transportadora === null) {
                    continue;
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

        $ps = $this->getConexao()->prepare("SELECT n.P_NRCONTRO,p.QTDPRO,p.VALUNI,p.NATOPE,pi.F_DESCRICA,pi.F_CODPROD FROM db_agrofauna.CADPED n INNER JOIN db_agrofauna.FATFCLIE c ON c.CODCLI=n.P_CODCLI INNER JOIN db_agrofauna.COMFPFIC p ON p.CONTRO=n.P_NRCONTRO INNER JOIN db_agrofauna.PRODUTO pi ON pi.F_CODPROD=p.CODPRO INNER JOIN db_agrofauna.FATFTRAN t ON t.CODTRA=n.P_TRANSPO WHERE n.P_DATAMOV >= '2019-02-22' AND c.CGCCPF IS NOT NULL AND c.CGCCPF <> '' AND n.P_TRANSPO IS NOT NULL AND n.P_TRANSPO <> ''");
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
        /*
          $filial = new Empresa(104);
          $matriz = new Empresa(105);


          $ps = $con->getConexao()->prepare("DELETE FROM banco");
          $ps->execute();
          $ps->close();



          $bancos = array();
          $ps = $this->getConexao()->prepare("SELECT ID,AGENCIA,NOME,0,CONTA FROM AF_financeiro_filial17.BANCO");
          $ps->execute();
          $ps->bind_result($cod, $age, $nm, $sal,$conta);
          while ($ps->fetch()) {

          $b = new Banco();
          $b->agencia = $age;
          $b->codigo = $cod;
          $b->nome = $nm;
          $b->conta = $conta;
          $b->saldo = $sal;
          $b->empresa = $filial;
          $bancos[$cod."_f"] = $b;
          }
          $ps->close();
          $ps = $this->getConexao()->prepare("SELECT ID,AGENCIA,NOME,0,CONTA FROM AF_financeiro.BANCO");
          $ps->execute();
          $ps->bind_result($cod, $age, $nm, $sal,$conta);
          while ($ps->fetch()) {

          $b = new Banco();
          $b->agencia = $age;
          $b->codigo = $cod;
          $b->nome = $nm;
          $b->conta = $conta;
          $b->saldo = $sal;
          $b->empresa = $matriz;
          $bancos[$cod."_m"] = $b;

          }
          $ps->close();

          foreach ($bancos as $key => $value) {

          $value->merge($con);
          $ps = $con->getConexao()->prepare("UPDATE banco SET id=$value->codigo WHERE id=$value->id");
          $ps->execute();
          $ps->close();
          }
         */
        /*
        $ps = $con->getConexao()->prepare("DELETE FROM movimento");
        $ps->execute();
        $ps->close();

        $filial = new Empresa(1733);
        $matriz = new Empresa(1734);


        $bancos = $filial->getBancos($con, 0, 1000, "", "");

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

            $b = null;
            foreach ($bancos as $key => $value) {
                if ($value->codigo === $banco) {
                    $b = $value;
                    break;
                }
            }
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

        $ps = $con->getConexao()->prepare("SELECT vencimento.id,nota.ficha FROM vencimento INNER JOIN nota ON nota.id=vencimento.id_nota");
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

            $m = $mp[$value->ficha] = 0;


            if (!isset($vencimentos[$value->ficha][$m])) {
                continue;
            }



            $value->vencimento = new stdClass();
            $value->vencimento->id = $vencimentos[$value->ficha][$m];

            $mp[$value->ficha] ++;

            $value->insert($con, true);
        }

        $bancos = $matriz->getBancos($con, 0, 1000, "", "");

        $fichas_filial = "(-1";

        $ps = $con->getConexao()->prepare("SELECT ficha FROM nota WHERE id_empresa=$matriz->id");
        $ps->execute();
        $ps->bind_result($ficha);
        while ($ps->fetch()) {
            $fichas_filial .= ",$ficha";
        }
        $ps->close();

        $fichas_filial .= ")";

        $movimentos = array();
        $datas = array();
        $ps = $this->getConexao()->prepare("SELECT ID_FICHA,ID_BANCO,ID_OPERACAO,ID_HISTORICO,VALOR,JUROS,DESCONTO,SALDO,NUMERO_PARCELA,UNIX_TIMESTAMP(DATA)*1000 FROM AF_financeiro.MOVIMENTO WHERE ID_FICHA IN $fichas_filial ORDER BY DATA, NUMERO_PARCELA");
        $ps->execute();
        $ps->bind_result($ficha, $banco, $op, $hist, $val, $jur, $desc, $saldo, $parc, $data);
        while ($ps->fetch()) {
            if (!isset($datas[$data])) {
                $datas[$data] = 0;
            }

            $b = null;
            foreach ($bancos as $key => $value) {
                if ($value->codigo === $banco) {
                    $b = $value;
                    break;
                }
            }
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



        $mp = array();

        foreach ($movimentos as $key => $value) {

            if (!isset($mp[$value->ficha])) {
                $mp[$value->ficha] = 0;
            }

            $m = $mp[$value->ficha] = 0;


            if (!isset($vencimentos[$value->ficha][$m])) {
                continue;
            }



            $value->vencimento = new stdClass();
            $value->vencimento->id = $vencimentos[$value->ficha][$m];

            $mp[$value->ficha] ++;

            $value->insert($con, true);
        }
        */
        /*
        $ps = $con->getConexao()->prepare("DELETE FROM campanha");
        $ps->execute();
        $ps->close();
        
        $validades = array();
        $ps = $con->getConexao()->prepare("SELECT id_produto,UNIX_TIMESTAMP(validade)*1000 FROM lote WHERE validade > DATE_ADD(CURRENT_DATE, INTERVAL 4 MONTH) ORDER BY validade ASC");
        $ps->execute();
        $ps->bind_result($id_produto,$validade);
        while($ps->fetch()){
            if(!isset($validades[$id_produto])){
                $validades[$id_produto] = $validade;
            }
        }
        $ps->close();
        
        $campanhas = array();
        $ps = $this->getConexao()->prepare("SELECT c.id_campanha,c.nm_campanha,UNIX_TIMESTAMP(c.dt_inicial)*1000,UNIX_TIMESTAMP(c.dt_final)*1000,p.id_produto,p.vl_preco_campanha,p.limite FROM db_agro_matriz.campanha c INNER JOIN db_agro_matriz.campanha_produto p ON p.id_campanha=c.id_campanha WHERE c.dt_final > CURRENT_TIMESTAMP AND c.sn_status=1");
        $ps->execute();
        $ps->bind_result($id,$nome,$inicio,$fim,$produto,$preco,$limite);
        while($ps->fetch()){
            
            if(!isset($validades[$produto]))
                continue;
            
            $v = $validades[$produto];
            
            if(!isset($campanhas[$id])){
                
                $c = new Campanha();
                $c->nome = $nome;
                $c->inicio = $inicio;
                $c->fim = $fim;
                $c->prazo = 0;
                $c->parcelas = 1;
                $c->empresa = $filial;
                
                $campanhas[$id] = $c;
                
            }
            
            $c = $campanhas[$id];
            $p = new ProdutoCampanha();
            $p->campanha = $c;
            $p->produto = new stdClass();
            $p->produto->id = $produto;
            $p->validade = $v;
            $p->valor = $preco;
            
            $c->produtos[] = $p;
            
            
            
        }
        $ps->close();
        
        foreach($campanhas as $key=>$value){
            $value->merge($con);
        }
        */
    }

}
