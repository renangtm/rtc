<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sistema
 *
 * @author Renan
 */
class Sistema {

    public static function getHtml($nom, $p = null) {

        global $obj;
        $obj = $p;

        $servico = realpath('../../html_email');
        $servico .= "/$nom.php";

        ob_start();
        include($servico);
        $html = ob_get_clean();

        return utf8_decode($html);
    }

    public static function getMesesValidadeCurta() {

        return 4;
    }

    public static function mergeArquivo($nome, $conteudo) {

        $handle = fopen('../uploads/' . $nome, 'a');
        fwrite($handle, Utilidades::base64decode($conteudo));
        fflush($handle);
        fclose($handle);
    }

    private static function getMicroServicoJava($nome, $parametros = null) {

        $servico = realpath('../micro_servicos_java');
        $servico .= "/$nome.jar";
        $comando = "java -jar \"$servico\"";
        if ($parametros != null) {
            $comando .= " \"$parametros\" 2>&1";
        } else {
            $comando .= " 200 2>&1";
        }
        exec($comando, $output);
        return $output[0];
    }

    public static function getEtiquetas($etiquetas) {

        $caminho = realpath("../uploads");
        $arquivo = "etiqueta_" . round(microtime(true) * 1000) . ".pdf";
        $caminho_completo = $caminho . "/$arquivo";

        $request = new stdClass();
        $request->arquivo = $caminho_completo;
        $request->etiquetas = $etiquetas;

        $final_request = Utilidades::toJson($request);
        $final_request = addslashes($final_request);

        $resp = Utilidades::fromJson(self::getMicroServicoJava('GeradorEtiqueta', $final_request));

        if (!$resp->sucesso) {

            throw new Exception('falha');
        } else {

            return $arquivo;
        }
    }

    public static function getHistorico($con) {

        $historicos = array();

        $ps = $con->getConexao()->prepare("SELECT id,nome FROM historico WHERE excluido = false");
        $ps->execute();
        $ps->bind_result($id, $nome);

        while ($ps->fetch()) {

            $historico = new Historico();
            $historico->id = $id;
            $historico->nome = $nome;

            $historicos[] = $historico;
        }

        $ps->close();

        return $historicos;
    }

    public static function getOperacoes($con) {

        $operacoes = array();

        $ps = $con->getConexao()->prepare("SELECT id,nome,debito FROM operacao WHERE excluida=false");
        $ps->execute();
        $ps->bind_result($id, $nome, $debito);

        while ($ps->fetch()) {

            $operacao = new Operacao();
            $operacao->id = $id;
            $operacao->nome = $nome;
            $operacao->debito = $debito;

            $operacoes[] = $operacao;
        }

        $ps->close();

        return $operacoes;
    }

    public static function getStatusCanceladoPedidoEntrada() {

        $st = Sistema::getStatusPedidoEntrada();
        return $st[3];
    }

    public static function relacionarFilial($empresa1, $empresa2) {

        $con = new ConnectionFactory();

        $ps = $con->getConexao()->prepare("INSERT INTO filial(id_empresa1,id_empresa2) VALUES($empresa1->id,$empresa2->id)");
        $ps->execute();
        $ps->close();
    }

    public static function getPragas($con) {

        $pragas = array();

        $ps = $con->getConexao()->prepare("SELECT id,nome FROM praga WHERE excluida = false ORDER BY nome");
        $ps->execute();
        $ps->bind_result($id, $nome);

        while ($ps->fetch()) {

            $praga = new Praga();
            $praga->id = $id;
            $praga->nome = $nome;

            $pragas[] = $praga;
        }

        $ps->close();

        return $pragas;
    }

    public static function getCategoriaCliente($con) {

        $cats = array();

        $ps = $con->getConexao()->prepare("SELECT id,nome FROM categoria_cliente WHERE excluida = false ORDER BY nome");
        $ps->execute();
        $ps->bind_result($id, $nome);

        while ($ps->fetch()) {

            $cat = new CategoriaCliente();
            $cat->id = $id;
            $cat->nome = $nome;

            $cats[] = $cat;
        }

        $ps->close();

        return $cats;
    }

    public static function getCulturas($con) {

        $culturas = array();

        $ps = $con->getConexao()->prepare("SELECT id,nome FROM cultura WHERE excluida = false ORDER BY nome");
        $ps->execute();
        $ps->bind_result($id, $nome);

        while ($ps->fetch()) {

            $cultura = new Cultura();
            $cultura->id = $id;
            $cultura->nome = $nome;

            $culturas[] = $cultura;
        }

        $ps->close();

        return $culturas;
    }

    public static function getStatusPedidoEntrada() {

        $status = array();

        $status[] = new StatusPedidoEntrada(1, "Confirmacao de pedido", false, false, true);
        $status[] = new StatusPedidoEntrada(2, "Em transito", false, true, false);
        $status[] = new StatusPedidoEntrada(3, "Finalizado", true, false, false);
        $status[] = new StatusPedidoEntrada(4, "Cancelado", false, false, true);

        return $status;
    }

    public static function getFormasPagamento() {

        $formas = array();

        $formas[] = new DepositoEmConta();
        $formas[] = new BoletoEspecialAgroFauna();

        return $formas;
    }

    public static function getIcmsEstado($estado) {

        $doze = array("MG", "RS", "SC", "RJ", "PB");

        if (in_array($estado->sigla, $doze)) {

            return 12;
        }

        return 7;
    }

    public static function getCategoriaDocumentos() {

        $cats = array();

        $cats[] = new CategoriaDocumento(1, "NFE");
        $cats[] = new CategoriaDocumento(2, "Certificado Comerciante de Agrotoxico");
        $cats[] = new CategoriaDocumento(3, "Documentos Empresariais");
        $cats[] = new CategoriaDocumento(4, "Balanco");

        return $cats;
    }

    public static function getEmailSistema() {

        $email = new Email("renan.miranda@agrofauna.com.br");
        $email->senha = "5hynespt";

        return $email;
    }

    public static function getPermissoes() {

        $perms = array();

        $perms[] = new Permissao(1, "pedido_entrada");
        $perms[] = new Permissao(2, "produto");
        $perms[] = new Permissao(3, "cotacao");
        $perms[] = new Permissao(4, "transportadora");
        $perms[] = new Permissao(5, "cliente");
        $perms[] = new Permissao(6, "nota");
        $perms[] = new Permissao(7, "lote");
        $perms[] = new Permissao(8, "tabela");
        $perms[] = new Permissao(9, "campanha");
        $perms[] = new Permissao(10, "grupo_cidades");
        $perms[] = new Permissao(11, "banco");
        $perms[] = new Permissao(12, "movimento");
        $perms[] = new Permissao(13, "pedido_saida");
        $perms[] = new Permissao(14, "categoria_produto");
        $perms[] = new Permissao(15, "categoria_cliente");
        $perms[] = new Permissao(16, "categoria_documento");
        $perms[] = new Permissao(17, "fonecedor");
        $perms[] = new Permissao(18, "cfg");
        $perms[] = new Permissao(19, "configuracao_empresa");
        $perms[] = new Permissao(20, "cultura");
        $perms[] = new Permissao(21, "praga");
        $perms[] = new Permissao(22, "receita");


        return $perms;
    }

    public static function getStatusExcluidoPedidoSaida() {

        return new StatusPedidoSaida(30, "Excluido", false, false, false, true);
    }

    public static function getStatusPedidoSaida() {

        $status = array();

        $status[] = new StatusPedidoSaida(1, "Confirmacao de pedido", false, true, true, true, true, true, false, false);
        $status[] = new StatusPedidoSaida(2, "Limite de credito", false, true, false, false, true, true, false, false);
        $status[] = new StatusPedidoSaida(3, "Autorizacao de pedido", false, true, false, false, true, true, false, false);
        $status[] = new StatusPedidoSaida(4, "Confirmacao de pagamento", false, true, true, false, true, true, false, false);
        $status[] = new StatusPedidoSaida(5, "Separacao", false, true, true, false, false, false, false, false);
        $status[] = new StatusPedidoSaida(6, "Faturamento", true, true, true, false, false, false, false, true);
        $status[] = new StatusPedidoSaida(7, "Coleta", true, true, true, true, false, false, false, true);
        $status[] = new StatusPedidoSaida(8, "Rastreio", true, true, true, false, false, false, false, true);
        $status[] = new StatusPedidoSaida(9, "Finalizado", true, true, true, false, false, false, true, true);
        $status[] = new StatusPedidoSaida(10, "Cancelado", false, false, true, true, false, false, true, false);
        $status[] = new StatusPedidoSaida(30, "Excluido", false, false, false, true, false, false, true, false);

        return $status;
    }

    public static function getStatusCotacaoEntrada() {

        $sts = array();

        $sts[] = new StatusCotacaoEntrada(1, "Aguardando resposta", true);
        $sts[] = new StatusCotacaoEntrada(2, "Respondida", false);
        $sts[] = new StatusCotacaoEntrada(3, "Pedido fechado", false);
        $sts[] = new StatusCotacaoEntrada(4, "Cancelada", true);

        return $sts;
    }

    public static function getPermissoesIniciais() {

        $perms = array();

        $perms[] = new Permissao(1, "pedido_entrada", true, true, true, true);
        $perms[] = new Permissao(2, "produto", true, true, true, true);
        $perms[] = new Permissao(3, "cotacao", true, true, true, true);
        $perms[] = new Permissao(4, "transportadora", true, true, true, true);
        $perms[] = new Permissao(5, "cliente", true, true, true, true);
        $perms[] = new Permissao(7, "lote", true, true, true, true);
        $perms[] = new Permissao(13, "pedido_saida", true, true, true, true);
        $perms[] = new Permissao(17, "fonecedor", true, true, true, true);
        $perms[] = new Permissao(18, "cfg", true, true, true, true);
        $perms[] = new Permissao(19, "configuracao_empresa", true, true, true, true);

        return $perms;
    }

    public static function getCategoriaProduto($con) {

        $cats = array();

        $ps = $con->getConexao()->prepare("SELECT id, nome,base_calculo,ipi,icms_normal,icms FROM categoria_produto WHERE excluida=false");
        $ps->execute();
        $ps->bind_result($id, $nome, $base_calculo, $ipi, $icms_normal, $icms);

        while ($ps->fetch()) {

            $cat = new CategoriaProduto();
            $cat->id = $id;
            $cat->nome = $nome;
            $cat->base_calculo = $base_calculo;
            $cat->ipi = $ipi;
            $cat->icms_norma = $icms_normal;
            $cat->icms = $icms;

            $cats[] = $cat;
        }

        $ps->close();

        return $cats;
    }

    public static function getEstados($con) {

        $estados = array();

        $ps = $con->getConexao()->prepare("SELECT id, sigla FROM estado WHERE excluido=false");
        $ps->execute();
        $ps->bind_result($id, $sigla);

        while ($ps->fetch()) {

            $e = new Estado();
            $e->id = $id;
            $e->sigla = $sigla;

            $estados[] = $e;
        }

        $ps->close();

        return $estados;
    }

    public static function getUsuario($filtro) {

        $con = new ConnectionFactory();

        $ses = new SessionManager();

        $sql = "SELECT "
                . "usuario.id,"
                . "usuario.nome,"
                . "usuario.login,"
                . "usuario.senha,"
                . "usuario.cpf,"
                . "endereco_usuario.id,"
                . "endereco_usuario.rua,"
                . "endereco_usuario.numero,"
                . "endereco_usuario.bairro,"
                . "endereco_usuario.cep,"
                . "cidade_usuario.id,"
                . "cidade_usuario.nome,"
                . "estado_usuario.id,"
                . "estado_usuario.sigla,"
                . "email_usu.id,"
                . "email_usu.endereco,"
                . "email_usu.senha,"
                . "empresa.id,"
                . "empresa.nome,"
                . "empresa.inscricao_estadual,"
                . "empresa.consigna,"
                . "empresa.aceitou_contrato,"
                . "empresa.juros_mensal,"
                . "empresa.cnpj,"
                . "endereco.numero,"
                . "endereco.id,"
                . "endereco.rua,"
                . "endereco.bairro,"
                . "endereco.cep,"
                . "cidade.id,"
                . "cidade.nome,"
                . "estado.id,"
                . "estado.sigla,"
                . "email.id,"
                . "email.endereco,"
                . "email.senha,"
                . "telefone.id,"
                . "telefone.numero "
                . "FROM usuario "
                . "INNER JOIN endereco endereco_usuario ON endereco_usuario.id_entidade=usuario.id AND endereco_usuario.tipo_entidade='USU' "
                . "INNER JOIN cidade cidade_usuario ON endereco_usuario.id_cidade=cidade_usuario.id "
                . "INNER JOIN estado estado_usuario ON estado_usuario.id=cidade_usuario.id_estado "
                . "INNER JOIN email email_usu ON email_usu.id_entidade=usuario.id AND email_usu.tipo_entidade='USU' "
                . "INNER JOIN empresa ON usuario.id_empresa=empresa.id "
                . "INNER JOIN endereco ON endereco.id_entidade=empresa.id AND endereco.tipo_entidade='EMP' "
                . "INNER JOIN email ON email.id_entidade=empresa.id AND email.tipo_entidade='EMP' "
                . "INNER JOIN telefone ON telefone.id_entidade=empresa.id AND telefone.tipo_entidade='EMP' "
                . "INNER JOIN cidade ON endereco.id_cidade=cidade.id "
                . "INNER JOIN estado ON cidade.id_estado = estado.id "
                . "WHERE " . $filtro;


        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id_usu, $nome_usu, $login_usu, $senha_usu, $cpf_usu, $end_usu_id, $end_usu_rua, $end_usu_numero, $end_usu_bairro, $end_usu_cep, $cid_usu_id, $cid_usu_nome, $est_usu_id, $est_usu_nome, $email_usu_id, $email_usu_end, $email_usu_senha, $id_empresa, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        $usuarios = array();

        while ($ps->fetch()) {

            $usuario = new Usuario();

            $usuario->cpf = new CPF($cpf_usu);
            $usuario->email = new Email($email_usu_end);
            $usuario->email->id = $email_usu_id;
            $usuario->email->senha = $email_usu_senha;
            $usuario->id = $id_usu;
            $usuario->login = $login_usu;
            $usuario->senha = $senha_usu;
            $usuario->nome = $nome_usu;

            $end = new Endereco();
            $end->id = $end_usu_id;
            $end->bairro = $end_usu_bairro;
            $end->cep = new CEP($end_usu_cep);
            $end->numero = $end_usu_numero;
            $end->rua = $end_usu_numero;

            $end->cidade = new Cidade();
            $end->cidade->id = $cid_usu_id;
            $end->cidade->nome = $cid_usu_nome;

            $end->cidade->estado = new Estado();
            $end->cidade->estado->id = $est_usu_id;
            $end->cidade->estado->sigla = $est_usu_nome;

            $usuario->endereco = $end;


            $empresa = new Empresa();
            $empresa->id = $id_empresa;
            $empresa->cnpj = new CNPJ($cnpj);
            $empresa->inscricao_estadual = $inscricao_empresa;
            $empresa->nome = $nome_empresa;
            $empresa->aceitou_contrato = $aceitou_contrato;
            $empresa->juros_mensal = $juros_mensal;
            $empresa->consigna = $consigna;

            $endereco = new Endereco();
            $endereco->id = $id_endereco;
            $endereco->rua = $rua;
            $endereco->bairro = $bairro;
            $endereco->cep = new CEP($cep);
            $endereco->numero = $numero_endereco;

            $cidade = new Cidade();
            $cidade->id = $id_cidade;
            $cidade->nome = $nome_cidade;

            $estado = new Estado();
            $estado->id = $id_estado;
            $estado->sigla = $nome_estado;

            $cidade->estado = $estado;

            $endereco->cidade = $cidade;

            $empresa->endereco = $endereco;

            $email = new Email($endereco_email);
            $email->id = $id_email;
            $email->senha = $senha_email;

            $empresa->email = $email;

            $telefone = new Telefone($numero_telefone);
            $telefone->id = $id_telefone;

            $empresa->telefone = $telefone;

            $usuario->empresa = $empresa;

            $usuarios[$usuario->id] = $usuario;
        }

        $ps->close();

        $in_usu = "-1";
        foreach ($usuarios as $id => $usuario) {
            $in_usu .= ",";
            $in_usu .= $id;
        }

        $ps = $con->getConexao()->prepare("SELECT telefone.id_entidade, telefone.tipo_entidade, telefone.id, telefone.numero FROM telefone WHERE (telefone.id_entidade IN ($in_usu) AND telefone.tipo_entidade='USU') AND telefone.excluido = false");
        $ps->execute();
        $ps->bind_result($id_entidade, $tipo_entidade, $id, $numero);
        while ($ps->fetch()) {

            $v = $usuarios;
            $telefone = new Telefone();
            $telefone->id = $id;
            $telefone->numero = $numero;

            $v[$id_entidade]->telefones[] = $telefone;
        }
        $ps->close();

        $permissoes = Sistema::getPermissoes();

        $ps = $con->getConexao()->prepare("SELECT id_usuario, id_permissao,incluir,deletar,alterar,consultar FROM usuario_permissao WHERE id_usuario IN ($in_usu)");
        $ps->execute();
        $ps->bind_result($id_usuario, $id_permissao, $incluir, $deletar, $alterar, $consultar);

        while ($ps->fetch()) {

            $p = null;

            foreach ($permissoes as $key => $perm) {
                if ($perm->id == $id_permissao) {
                    $p = $perm;
                    break;
                }
            }

            if ($p == null) {

                continue;
            }

            $p->alt = $alterar;
            $p->in = $incluir;
            $p->del = $deletar;
            $p->cons = $consultar;

            $usuarios[$id_usuario]->permissoes[] = $p;
        }

        $ps->close();

        $real = array();

        foreach ($usuarios as $key => $value) {

            $real[] = $value;
        }

        if (count($real) > 0) {

            $u = $real[0];

            $ses->set("usuario", $u);
            $ses->set("empresa", $u->empresa);

            return $u;
        }

        return null;
    }

    public static function getLogisticaById($con, $id) {

        $logs = Sistema::getLogisticas($con, true);

        if (isset($logs[$id])) {
            return $logs[$id];
        }
        
        return null;
    }

    public static function getLogisticas($con, $id_array = false) {
        
        $ses = new SessionManager();

        if ($ses->get("logisticas") != null) {

            if ($id_array) {

                return $ses->get("logisticas_id");
            } else {

                return $ses->get("logisticas");
            }
        }
        
        $ps = $con->getConexao()->prepare("SELECT "
                . "empresa.id,"
                . "empresa.is_logistica,"
                . "empresa.nome,"
                . "empresa.inscricao_estadual,"
                . "empresa.consigna,"
                . "empresa.aceitou_contrato,"
                . "empresa.juros_mensal,"
                . "empresa.cnpj,"
                . "endereco.numero,"
                . "endereco.id,"
                . "endereco.rua,"
                . "endereco.bairro,"
                . "endereco.cep,"
                . "cidade.id,"
                . "cidade.nome,"
                . "estado.id,"
                . "estado.sigla,"
                . "email.id,"
                . "email.endereco,"
                . "email.senha,"
                . "telefone.id,"
                . "telefone.numero "
                . "FROM empresa "
                . "INNER JOIN endereco ON endereco.id_entidade=empresa.id AND endereco.tipo_entidade='EMP' "
                . "INNER JOIN email ON email.id_entidade=empresa.id AND email.tipo_entidade='EMP' "
                . "INNER JOIN telefone ON telefone.id_entidade=empresa.id AND telefone.tipo_entidade='EMP' "
                . "INNER JOIN cidade ON endereco.id_cidade=cidade.id "
                . "INNER JOIN estado ON cidade.id_estado = estado.id "
                . "WHERE empresa.is_logistica=true");
        $ps->execute();
        
        $empresas = array();
        $empresas_id = array();
        $ps->bind_result($id_empresa, $is_logistica, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        while ($ps->fetch()) {

            $empresa = new Empresa();

            if ($is_logistica == 1) {

                $empresa = new Logistica();
            }

            $empresa->id = $id_empresa;
            $empresa->cnpj = new CNPJ($cnpj);
            $empresa->inscricao_estadual = $inscricao_empresa;
            $empresa->nome = $nome_empresa;
            $empresa->aceitou_contrato = $aceitou_contrato;
            $empresa->juros_mensal = $juros_mensal;
            $empresa->consigna = $consigna;

            $endereco = new Endereco();
            $endereco->id = $id_endereco;
            $endereco->rua = $rua;
            $endereco->bairro = $bairro;
            $endereco->cep = new CEP($cep);
            $endereco->numero = $numero_endereco;

            $cidade = new Cidade();
            $cidade->id = $id_cidade;
            $cidade->nome = $nome_cidade;

            $estado = new Estado();
            $estado->id = $id_estado;
            $estado->sigla = $nome_estado;

            $cidade->estado = $estado;

            $endereco->cidade = $cidade;

            $empresa->endereco = $endereco;

            $email = new Email($endereco_email);
            $email->id = $id_email;
            $email->senha = $senha_email;

            $empresa->email = $email;

            $telefone = new Telefone($numero_telefone);
            $telefone->id = $id_telefone;

            $empresa->telefone = $telefone;


            $empresas[] = $empresa;

            $empresas_id[$id_empresa] = $empresa;
        }

        $ps->close();

        $ses->set("logisticas_id", $empresas_id);
        $ses->set("logisticas", $empresas);

        if($id_array){
            
            return $empresas_id;
            
        }else{
        
            return $empresas;
            
        }
        
        
    }

    public static function logar($login, $senha) {

        $con = new ConnectionFactory();

        $ses = new SessionManager();

        $sql = "SELECT "
                . "usuario.id,"
                . "usuario.nome,"
                . "usuario.login,"
                . "usuario.senha,"
                . "usuario.cpf,"
                . "endereco_usuario.id,"
                . "endereco_usuario.rua,"
                . "endereco_usuario.numero,"
                . "endereco_usuario.bairro,"
                . "endereco_usuario.cep,"
                . "cidade_usuario.id,"
                . "cidade_usuario.nome,"
                . "estado_usuario.id,"
                . "estado_usuario.sigla,"
                . "email_usu.id,"
                . "email_usu.endereco,"
                . "email_usu.senha,"
                . "empresa.id,"
                . "empresa.is_logistica,"
                . "empresa.nome,"
                . "empresa.inscricao_estadual,"
                . "empresa.consigna,"
                . "empresa.aceitou_contrato,"
                . "empresa.juros_mensal,"
                . "empresa.cnpj,"
                . "endereco.numero,"
                . "endereco.id,"
                . "endereco.rua,"
                . "endereco.bairro,"
                . "endereco.cep,"
                . "cidade.id,"
                . "cidade.nome,"
                . "estado.id,"
                . "estado.sigla,"
                . "email.id,"
                . "email.endereco,"
                . "email.senha,"
                . "telefone.id,"
                . "telefone.numero "
                . "FROM usuario "
                . "INNER JOIN endereco endereco_usuario ON endereco_usuario.id_entidade=usuario.id AND endereco_usuario.tipo_entidade='USU' "
                . "INNER JOIN cidade cidade_usuario ON endereco_usuario.id_cidade=cidade_usuario.id "
                . "INNER JOIN estado estado_usuario ON estado_usuario.id=cidade_usuario.id_estado "
                . "INNER JOIN email email_usu ON email_usu.id_entidade=usuario.id AND email_usu.tipo_entidade='USU' "
                . "INNER JOIN empresa ON usuario.id_empresa=empresa.id "
                . "INNER JOIN endereco ON endereco.id_entidade=empresa.id AND endereco.tipo_entidade='EMP' "
                . "INNER JOIN email ON email.id_entidade=empresa.id AND email.tipo_entidade='EMP' "
                . "INNER JOIN telefone ON telefone.id_entidade=empresa.id AND telefone.tipo_entidade='EMP' "
                . "INNER JOIN cidade ON endereco.id_cidade=cidade.id "
                . "INNER JOIN estado ON cidade.id_estado = estado.id "
                . "WHERE usuario.login = '" . addslashes($login) . "' AND usuario.senha='" . addslashes($senha) . "' ";


        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id_usu, $nome_usu, $login_usu, $senha_usu, $cpf_usu, $end_usu_id, $end_usu_rua, $end_usu_numero, $end_usu_bairro, $end_usu_cep, $cid_usu_id, $cid_usu_nome, $est_usu_id, $est_usu_nome, $email_usu_id, $email_usu_end, $email_usu_senha, $id_empresa, $is_logistica, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        $usuarios = array();

        while ($ps->fetch()) {

            $usuario = new Usuario();

            $usuario->cpf = new CPF($cpf_usu);
            $usuario->email = new Email($email_usu_end);
            $usuario->email->id = $email_usu_id;
            $usuario->email->senha = $email_usu_senha;
            $usuario->id = $id_usu;
            $usuario->login = $login_usu;
            $usuario->senha = $senha_usu;
            $usuario->nome = $nome_usu;

            $end = new Endereco();
            $end->id = $end_usu_id;
            $end->bairro = $end_usu_bairro;
            $end->cep = new CEP($end_usu_cep);
            $end->numero = $end_usu_numero;
            $end->rua = $end_usu_numero;

            $end->cidade = new Cidade();
            $end->cidade->id = $cid_usu_id;
            $end->cidade->nome = $cid_usu_nome;

            $end->cidade->estado = new Estado();
            $end->cidade->estado->id = $est_usu_id;
            $end->cidade->estado->sigla = $est_usu_nome;

            $usuario->endereco = $end;


            $empresa = new Empresa();

            if ($is_logistica == 1) {

                $empresa = new Logistica();
            }

            $empresa->id = $id_empresa;
            $empresa->cnpj = new CNPJ($cnpj);
            $empresa->inscricao_estadual = $inscricao_empresa;
            $empresa->nome = $nome_empresa;
            $empresa->aceitou_contrato = $aceitou_contrato;
            $empresa->juros_mensal = $juros_mensal;
            $empresa->consigna = $consigna;

            $endereco = new Endereco();
            $endereco->id = $id_endereco;
            $endereco->rua = $rua;
            $endereco->bairro = $bairro;
            $endereco->cep = new CEP($cep);
            $endereco->numero = $numero_endereco;

            $cidade = new Cidade();
            $cidade->id = $id_cidade;
            $cidade->nome = $nome_cidade;

            $estado = new Estado();
            $estado->id = $id_estado;
            $estado->sigla = $nome_estado;

            $cidade->estado = $estado;

            $endereco->cidade = $cidade;

            $empresa->endereco = $endereco;

            $email = new Email($endereco_email);
            $email->id = $id_email;
            $email->senha = $senha_email;

            $empresa->email = $email;

            $telefone = new Telefone($numero_telefone);
            $telefone->id = $id_telefone;

            $empresa->telefone = $telefone;

            $usuario->empresa = $empresa;

            $usuarios[$usuario->id] = $usuario;
        }

        $ps->close();

        $in_usu = "-1";
        foreach ($usuarios as $id => $usuario) {
            $in_usu .= ",";
            $in_usu .= $id;
        }

        $ps = $con->getConexao()->prepare("SELECT telefone.id_entidade, telefone.tipo_entidade, telefone.id, telefone.numero FROM telefone WHERE (telefone.id_entidade IN ($in_usu) AND telefone.tipo_entidade='USU') AND telefone.excluido = false");
        $ps->execute();
        $ps->bind_result($id_entidade, $tipo_entidade, $id, $numero);
        while ($ps->fetch()) {

            $v = $usuarios;
            $telefone = new Telefone();
            $telefone->id = $id;
            $telefone->numero = $numero;

            $v[$id_entidade]->telefones[] = $telefone;
        }
        $ps->close();

        $permissoes = Sistema::getPermissoes();

        $ps = $con->getConexao()->prepare("SELECT id_usuario, id_permissao,incluir,deletar,alterar,consultar FROM usuario_permissao WHERE id_usuario IN ($in_usu)");
        $ps->execute();
        $ps->bind_result($id_usuario, $id_permissao, $incluir, $deletar, $alterar, $consultar);

        while ($ps->fetch()) {

            $p = null;

            foreach ($permissoes as $key => $perm) {
                if ($perm->id == $id_permissao) {
                    $p = $perm;
                    break;
                }
            }

            if ($p == null) {

                continue;
            }

            $p->alt = $alterar;
            $p->in = $incluir;
            $p->del = $deletar;
            $p->cons = $consultar;

            $usuarios[$id_usuario]->permissoes[] = $p;
        }

        $ps->close();

        $real = array();

        foreach ($usuarios as $key => $value) {

            $real[] = $value;
        }

        if (count($real) > 0) {

            $u = $real[0];

            $ses->set("usuario", $u);
            $ses->set("empresa", $u->empresa);

            return $u;
        }

        return null;
    }

    public static function getCidades($con) {

        $cidades = array();

        $ps = $con->getConexao()->prepare("SELECT estado.id, estado.sigla, cidade.id, cidade.nome FROM cidade INNER JOIN estado ON cidade.id_estado=estado.id WHERE cidade.excluida=false");
        $ps->execute();
        $ps->bind_result($id_estado, $sigla_estado, $id_cidade, $nome_cidade);

        while ($ps->fetch()) {

            $e = new Estado();
            $e->id = $id_estado;
            $e->sigla = $sigla_estado;

            $c = new Cidade();
            $c->id = $id_cidade;
            $c->nome = $nome_cidade;
            $c->estado = $e;

            $cidades[] = $c;
        }

        $ps->close();

        return $cidades;
    }

}
