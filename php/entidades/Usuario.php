<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Fornecedor
 *
 * @author Renan
 */
class Usuario {

    public $id;
    public $nome;
    public $email;
    public $telefones;
    public $endereco;
    public $cpf;
    public $excluido;
    public $empresa;
    public $login;
    public $senha;
    public $rg;
    public $permissoes;
    public $cargo;

    function __construct() {

        $this->id = 0;
        $this->email = null;
        $this->telefones = array();
        $this->endereco = new Endereco();
        $this->excluido = false;
        $this->cpf = new CPF("");
        $this->rg = new RG("");
        $this->email = new Email("");
        $this->empresa = null;
        $this->permissoes = array();
        $this->cargo = null;
    }

    public function getCountClientes($con, $filtro = "") {

        $sql = "SELECT COUNT(*) "
                . "FROM cliente "
                . "INNER JOIN empresa ON cliente.id_empresa=empresa.id "
                . "INNER JOIN usuario_cliente ON usuario_cliente.id_usuario=$this->id AND usuario_cliente.id_cliente=cliente.id "
                . "WHERE cliente.excluido = false";

        if ($filtro !== "") {

            $sql .= " AND $filtro";
        }

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($qtd);

        if ($ps->fetch()) {
            $ps->close();

            return $qtd;
        }

        $ps->close();

        return 0;
    }

    public function addCliente($con, $cliente, $situacao) {

        $uc = new RelacaoUsuarioCliente();
        $uc->cliente = $cliente;
        $uc->situacao = $situacao;
        $uc->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE usuario_cliente SET data_inicio=data_inicio,data_fim=data_fim,id_usuario=$this->id WHERE id=$uc->id");
        $ps->execute();
        $ps->close();
    }

    public function getClientes($con, $x1, $x2, $filtro = "", $ordem = "") {

        $sql = "SELECT "
                . "cliente.id,"
                . "cliente.codigo_contimatic,"
                . "cliente.codigo,"
                . "cliente.razao_social, "
                . "cliente.nome_fantasia, "
                . "cliente.limite_credito, "
                . "UNIX_TIMESTAMP(cliente.inicio_limite)*1000, "
                . "UNIX_TIMESTAMP(cliente.termino_limite)*1000, "
                . "cliente.pessoa_fisica, "
                . "cliente.cpf, "
                . "cliente.cnpj, "
                . "cliente.rg, "
                . "cliente.inscricao_estadual, "
                . "cliente.suframado, "
                . "cliente.inscricao_suframa, "
                . "categoria_cliente.id, "
                . "categoria_cliente.nome, "
                . "endereco_cliente.id, "
                . "endereco_cliente.rua, "
                . "endereco_cliente.numero, "
                . "endereco_cliente.bairro, "
                . "endereco_cliente.cep, "
                . "cidade_cliente.id, "
                . "cidade_cliente.nome, "
                . "estado_cliente.id, "
                . "estado_cliente.sigla, "
                . "email_cliente.id,"
                . "email_cliente.endereco,"
                . "email_cliente.senha,"
                . "empresa.id,"
                . "empresa.tipo_empresa,"
                . "empresa.nome,"
                . "empresa.inscricao_estadual,"
                . "empresa.consigna,"
                . "empresa.aceitou_contrato,"
                . "empresa.juros_mensal,"
                . "empresa.cnpj,"
                . "endereco_empresa.numero,"
                . "endereco_empresa.id,"
                . "endereco_empresa.rua,"
                . "endereco_empresa.bairro,"
                . "endereco_empresa.cep,"
                . "cidade_empresa.id,"
                . "cidade_empresa.nome,"
                . "estado_empresa.id,"
                . "estado_empresa.sigla,"
                . "email_empresa.id,"
                . "email_empresa.endereco,"
                . "email_empresa.senha,"
                . "telefone_empresa.id,"
                . "telefone_empresa.numero,"
                . "usuario_cliente.id,"
                . "FROM_UNIXTIME(usuario_cliente.data_inicio)*1000,"
                . "CASE WHEN usuario_cliente.data_fim IS NULL THEN null ELSE FROM_UNIXTIME(usuario_cliente.data_fim)*1000 END,"
                . "usuario_cliente.situacao "
                . "FROM cliente "
                . "INNER JOIN endereco endereco_cliente ON endereco_cliente.id_entidade=cliente.id AND endereco_cliente.tipo_entidade='CLI' "
                . "INNER JOIN cidade cidade_cliente ON endereco_cliente.id_cidade=cidade_cliente.id "
                . "INNER JOIN estado estado_cliente ON estado_cliente.id=cidade_cliente.id_estado "
                . "INNER JOIN categoria_cliente ON cliente.id_categoria=categoria_cliente.id "
                . "INNER JOIN email email_cliente ON email_cliente.id_entidade=cliente.id AND email_cliente.tipo_entidade = 'CLI' "
                . "INNER JOIN empresa ON cliente.id_empresa=empresa.id "
                . "INNER JOIN endereco endereco_empresa ON endereco_empresa.id_entidade=empresa.id AND endereco_empresa.tipo_entidade='EMP' "
                . "INNER JOIN email email_empresa ON email_empresa.id_entidade=empresa.id AND email_empresa.tipo_entidade='EMP' "
                . "INNER JOIN telefone telefone_empresa ON telefone_empresa.id_entidade=empresa.id AND telefone_empresa.tipo_entidade='EMP' "
                . "INNER JOIN cidade cidade_empresa ON endereco_empresa.id_cidade=cidade_empresa.id "
                . "INNER JOIN estado estado_empresa ON cidade_empresa.id_estado = estado_empresa.id "
                . "INNER JOIN usuario_cliente ON cliente.id=usuario_cliente.id_cliente AND usuario_cliente.id_usuario=$this->id "
                . "WHERE cliente.excluido=false AND usuario_cliente.data_fim IS NULL ";

        if ($filtro != "") {

            $sql .= "AND $filtro ";
        }

        if ($ordem != "") {

            $sql .= "ORDER BY $ordem ";
        }

        $sql .= "LIMIT $x1, " . ($x2 - $x1);

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id_cliente, $cod_ctm, $cod_cli, $nome_cliente, $nome_fantasia_cliente, $limite, $inicio, $fim, $pessoa_fisica, $cpf, $cnpj, $rg, $ie, $suf, $i_suf, $cat_id, $cat_nome, $end_cli_id, $end_cli_rua, $end_cli_numero, $end_cli_bairro, $end_cli_cep, $cid_cli_id, $cid_cli_nome, $est_cli_id, $est_cli_nome, $email_cli_id, $email_cli_end, $email_cli_senha, $id_empresa, $tipo_empresa, $nome_empresa, $inscricao_empresa, $consigna_empresa, $aceitou_contrato_empresa, $juros_mensal_empresa, $cnpj_empresa, $numero_endereco_empresa, $id_endereco_empresa, $rua_empresa, $bairro_empresa, $cep_empresa, $id_cidade_empresa, $nome_cidade_empresa, $id_estado_empresa, $nome_estado_empresa, $id_email_empresa, $endereco_email_empresa, $senha_email_empresa, $id_telefone_empresa, $numero_telefone_empresa, $id_uc, $ini_uc, $fim_uc, $sit_uc);

        $clientes = array();
        $ucs = array();

        while ($ps->fetch()) {

            $cliente = new Cliente();
            $cliente->id = $id_cliente;
            $cliente->codigo_contimatic = $cod_ctm;
            $cliente->codigo = $cod_cli;
            $cliente->cnpj = new CNPJ($cnpj);
            $cliente->cpf = new CPF($cpf);
            $cliente->rg = new RG($rg);
            $cliente->pessoa_fisica = $pessoa_fisica == 1;
            $cliente->nome_fantasia = $nome_fantasia_cliente;
            $cliente->razao_social = $nome_cliente;
            $cliente->email = new Email($email_cli_end);
            $cliente->email->id = $email_cli_id;
            $cliente->email->senha = $email_cli_senha;
            $cliente->categoria = new CategoriaCliente();
            $cliente->categoria->id = $cat_id;
            $cliente->categoria->nome = $cat_nome;
            $cliente->inicio_limite = $inicio;
            $cliente->termino_limite = $fim;
            $cliente->limite_credito = $limite;
            $cliente->inscricao_suframa = $i_suf;
            $cliente->suframado = $suf == 1;
            $cliente->inscricao_estadual = $ie;

            $end = new Endereco();
            $end->id = $end_cli_id;
            $end->bairro = $end_cli_bairro;
            $end->cep = new CEP($end_cli_cep);
            $end->numero = $end_cli_numero;
            $end->rua = $end_cli_numero;

            $end->cidade = new Cidade();
            $end->cidade->id = $cid_cli_id;
            $end->cidade->nome = $cid_cli_nome;

            $end->cidade->estado = new Estado();
            $end->cidade->estado->id = $est_cli_id;
            $end->cidade->estado->sigla = $est_cli_nome;

            $cliente->endereco = $end;

            //empresa

            $empresa = Sistema::getEmpresa($tipo_empresa);

            $empresa->id = $id_empresa;
            $empresa->cnpj = new CNPJ($cnpj_empresa);
            $empresa->inscricao_estadual = $inscricao_empresa;
            $empresa->nome = $nome_empresa;
            $empresa->aceitou_contrato = $aceitou_contrato_empresa;
            $empresa->juros_mensal = $juros_mensal_empresa;
            $empresa->consigna = $consigna_empresa;

            $endereco = new Endereco();
            $endereco->id = $id_endereco_empresa;
            $endereco->rua = $rua_empresa;
            $endereco->bairro = $bairro_empresa;
            $endereco->cep = new CEP($cep_empresa);
            $endereco->numero = $numero_endereco_empresa;

            $cidade = new Cidade();
            $cidade->id = $id_cidade_empresa;
            $cidade->nome = $nome_cidade_empresa;

            $estado = new Estado();
            $estado->id = $id_estado_empresa;
            $estado->sigla = $nome_estado_empresa;

            $cidade->estado = $estado_empresa;

            $endereco->cidade = $cidade_empresa;

            $empresa->endereco = $endereco_empresa;

            $email = new Email($endereco_email_empresa);
            $email->id = $id_email_empresa;
            $email->senha = $senha_email_empresa;

            $empresa->email = $email_empresa;

            $telefone = new Telefone($numero_telefone_empresa);
            $telefone->id = $id_telefone_empresa;

            $empresa->telefone = $telefone_empresa;

            $cliente->empresa = $empresa;

            //--------------

            $clientes[$id_cliente] = $cliente;

            $uc = new RelacaoUsuarioCliente();
            $uc->id = $id_uc;
            $uc->cliente = $cliente;
            $uc->data_fim = $fim_uc;
            $uc->data_inicio = $ini_uc;
            $uc->situacao = $sit_uc;

            $ucs[] = $uc;
        }

        $ps->close();

        $in_cli = "-1";

        foreach ($clientes as $id => $cliente) {
            $in_cli .= ",";
            $in_cli .= $id;
        }

        $ps = $con->getConexao()->prepare("SELECT telefone.id_entidade, telefone.tipo_entidade, telefone.id, telefone.numero FROM telefone WHERE (telefone.id_entidade IN ($in_cli) AND telefone.tipo_entidade='CLI') AND telefone.excluido=false");
        $ps->execute();
        $ps->bind_result($id_entidade, $tipo_entidade, $id, $numero);
        while ($ps->fetch()) {

            $v = $clientes;

            $telefone = new Telefone($numero);
            $telefone->id = $id;


            $v[$id_entidade]->telefones[] = $telefone;
        }
        $ps->close();

        $real = array();

        foreach ($clientes as $key => $value) {

            $real[] = $value;
        }

        return $ucs;
    }

    public function getAtividadeUsuarioClienteAtual($con) {

        $auc = null;

        $ps = $con->getConexao()->prepare("SELECT "
                . "id,"
                . "data_referente,"
                . "pontos_atendimento "
                . "FROM usuario_atividade "
                . "WHERE "
                . "id_usuario=$this->id AND "
                . "DATE(data_referente)=DATE(CURRENT_DATE) AND "
                . "MONTH(data_referente)=MONTH(CURRENT_DATE) AND "
                . "YEAR(data_referente)=YEAR(CURRENT_DATE)");
        $ps->execute();
        $ps->bind_result($id, $data_referente, $pontos_atendimento);

        if ($ps->fetch()) {

            $auc = new AtividadeUsuarioCliente();
            $auc->id = $id;
            $auc->data_referente = $data_referente;
            $auc->pontos_atendimento = $pontos_atendimento;
            $ps->close();
        } else {

            $ps->close();

            $auc = new AtividadeUsuarioCliente();
            $auc->merge($con);

            $ps = $con->getConexao()->prepare("UPDATE usuario_atividade SET id_usuario=$this->id WHERE id=$auc->id");
            $ps->execute();
            $ps->close();
        }

        $ps = $con->getConexao()->prepare("SELECT SUM(pontos_atendimento) FROM usuario_atividade "
                . "WHERE id_usuario=$this->id AND "
                . "MONTH(data_referente)=MONTH(FROM_UNIXTIME($auc->data_referente/1000)) AND "
                . "YEAR(data_referente)=YEAR(FROM_UNIXTIME($auc->data_referente/1000))");
        $ps->execute();
        $ps->bind_result($pontos_mes);
        if ($ps->fetch()) {
            if($pontos_mes !== null){
                $auc->pontos_mes = $pontos_mes;
            }
        }
        $ps->close();

        $auc->calcularMetaDiaria();

        return $auc;
    }
    
    public function getCountTarefas($con,$filtro=""){
        
        
        
        
    }
    
    public function getTarefasSolicitadas($con,$x1,$x2, $filtro = "", $ordem = "") {

        $tipos_tarefa = array();

        $sql = "SELECT "
                . "tarefa.id,"
                . "UNIX_TIMESTAMP(tarefa.inicio_minimo)*1000,"
                . "tarefa.ordem,"
                . "tarefa.porcentagem_conclusao,"
                . "tarefa.tipo_entidade_relacionada,"
                . "tarefa.id_entidade_relacionada,"
                . "tarefa.titulo,"
                . "tarefa.descricao,"
                . "tarefa.intervalos_execucao,"
                . "tarefa.realocavel,"
                . "tarefa.id_tipo_tarefa,"
                . "tarefa.prioridade,"
                . "observacao.id,"
                . "observacao.porcentagem,"
                . "UNIX_TIMESTAMP(observacao.momento)*1000, "
                . "observacao.observacao,"
                . "u.id,"
                . "u.nome "
                . "FROM tarefa "
                . "LEFT JOIN (SELECT * FROM observacao WHERE observacao.excluida = false) observacao ON tarefa.id=observacao.id_tarefa "
                . "INNER JOIN usuario u ON u.id=tarefa.id_usuario "
                . "WHERE tarefa.excluida=false AND tarefa.criada_por=$this->id";

        if ($filtro !== "") {

            $sql .= " AND $filtro";
        }

        if ($ordem !== "") {

            $sql .= " ORDER BY $ordem";
        }
        
        $sql .= " LIMIT $x1, ".($x2-$x1);

        
        
        $tarefas = array();
        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id, $inicio_minimo, $ordem, $porcentagem_conclusao, $tipo_entidade_relacionada, $id_entidade_relacionada, $titulo, $descricao, $intervalos_execucao, $realocavel, $id_tipo_tarefa, $prioridade, $id_observacao, $porcentagem_observacao, $momento_observacao, $observacao,$id_usu,$nome_usu);
        while ($ps->fetch()) {

            if (!isset($tarefas[$id])) {

                $t = new Tarefa();
                $t->id = $id;
                $t->assinatura_solicitante = $this->id."-".$this->nome;
                $t->inicio_minimo = $inicio_minimo;
                $t->ordem = $ordem;
                $t->porcentagem_conclusao = $porcentagem_conclusao;
                $t->tipo_entidade_relacionada = $tipo_entidade_relacionada;
                $t->id_entidade_relacionada = $id_entidade_relacionada;
                $t->titulo = $titulo;
                $t->descricao = $descricao;
                $t->intervalos_execucao = $intervalos_execucao;
                $t->realocavel = $realocavel == 1;
                $t->usuario = $id_usu."-".$nome_usu;
                
                foreach ($tipos_tarefa as $key => $tipo) {
                    if ($tipo->id === $id_tipo_tarefa) {
                        $t->tipo_tarefa = $tipo;
                        break;
                    }
                }
                
                if($t->tipo_tarefa===null){
                    continue;
                }

                $t->prioridade = $prioridade;

                $t->intervalos_execucao = explode(";", $t->intervalos_execucao);
                $intervalos = array();
                foreach ($t->intervalos_execucao as $key => $intervalo) {
                    if ($intervalo === "")
                        continue;
                    $k = explode('@', $intervalo);
                    $intervalos[] = array($k[0] + 0, $k[1] + 0);
                }
                $t->intervalos_execucao = $intervalos;
                
                $tarefas[$id] = $t;
            }

            $t = $tarefas[$id];

            if ($id_observacao !== null) {

                $obs = new ObservacaoTarefa();
                $obs->id = $id_observacao;
                $obs->momento = $momento_observacao;
                $obs->porcentagem = $porcentagem_observacao;
                $obs->observacao = $observacao;

                $t->observacoes[] = $obs;
            }
        }

        $retorno = array();

        foreach ($tarefas as $key => $value) {

            $retorno[] = $value;
        }

        return $retorno;
    }

    public function getTarefas($con, $filtro = "", $ordem = "") {

        $tipos_tarefa = $this->empresa->getTiposTarefa($con);

        $sql = "SELECT "
                . "tarefa.id,"
                . "UNIX_TIMESTAMP(tarefa.inicio_minimo)*1000,"
                . "tarefa.ordem,"
                . "tarefa.porcentagem_conclusao,"
                . "tarefa.tipo_entidade_relacionada,"
                . "tarefa.id_entidade_relacionada,"
                . "tarefa.titulo,"
                . "tarefa.descricao,"
                . "tarefa.intervalos_execucao,"
                . "tarefa.realocavel,"
                . "tarefa.id_tipo_tarefa,"
                . "tarefa.prioridade,"
                . "observacao.id,"
                . "observacao.porcentagem,"
                . "UNIX_TIMESTAMP(observacao.momento)*1000, "
                . "observacao.observacao,"
                . "CASE WHEN u.id IS NULL THEN 'SISTEMA' ELSE CONCAT(u.id,CONCAT('-',u.nome)) END "
                . "FROM tarefa "
                . "LEFT JOIN (SELECT * FROM observacao WHERE observacao.excluida = false) observacao ON tarefa.id=observacao.id_tarefa "
                . "LEFT JOIN usuario u ON u.id=tarefa.criada_por "
                . "WHERE tarefa.excluida=false AND tarefa.id_usuario=$this->id";

        if ($filtro !== "") {

            $sql .= " AND $filtro";
        }

        if ($ordem !== "") {

            $sql .= " ORDER BY $ordem";
        }

        $tarefas = array();
        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id, $inicio_minimo, $ordem, $porcentagem_conclusao, $tipo_entidade_relacionada, $id_entidade_relacionada, $titulo, $descricao, $intervalos_execucao, $realocavel, $id_tipo_tarefa, $prioridade, $id_observacao, $porcentagem_observacao, $momento_observacao, $observacao,$ass);
        while ($ps->fetch()) {

            if (!isset($tarefas[$id])) {

                $t = new Tarefa();
                $t->id = $id;
                $t->assinatura_solicitante = $ass;
                $t->inicio_minimo = $inicio_minimo;
                $t->ordem = $ordem;
                $t->porcentagem_conclusao = $porcentagem_conclusao;
                $t->tipo_entidade_relacionada = $tipo_entidade_relacionada;
                $t->id_entidade_relacionada = $id_entidade_relacionada;
                $t->titulo = $titulo;
                $t->descricao = $descricao;
                $t->intervalos_execucao = $intervalos_execucao;
                $t->realocavel = $realocavel == 1;

                foreach ($tipos_tarefa as $key => $tipo) {
                    if ($tipo->id === $id_tipo_tarefa) {
                        $t->tipo_tarefa = $tipo;
                        break;
                    }
                }
                
                if($t->tipo_tarefa===null){
                    continue;
                }

                $t->prioridade = $prioridade;

                $t->intervalos_execucao = explode(";", $t->intervalos_execucao);
                $intervalos = array();
                foreach ($t->intervalos_execucao as $key => $intervalo) {
                    if ($intervalo === "")
                        continue;
                    $k = explode('@', $intervalo);
                    $intervalos[] = array($k[0] + 0, $k[1] + 0);
                }
                $t->intervalos_execucao = $intervalos;
                
                $tarefas[$id] = $t;
            }

            $t = $tarefas[$id];

            if ($id_observacao !== null) {

                $obs = new ObservacaoTarefa();
                $obs->id = $id_observacao;
                $obs->momento = $momento_observacao;
                $obs->porcentagem = $porcentagem_observacao;
                $obs->observacao = $observacao;

                $t->observacoes[] = $obs;
            }
        }

        $retorno = array();

        foreach ($tarefas as $key => $value) {

            $retorno[] = $value;
        }

        return $retorno;
    }

    public function addTarefa($con, $tarefa) {

        $tarefa->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE tarefa SET id_usuario = $this->id,inicio_minimo=inicio_minimo WHERE id=$tarefa->id");
        $ps->execute();
        $ps->close();

        $tarefa->tipo_tarefa->aoAtribuir($this->id, $tarefa);
    }

    public function getAusencias($con, $filtro = "") {

        $sql = "SELECT id,UNIX_TIMESTAMP(inicio)*1000,UNIX_TIMESTAMP(fim)*1000 FROM ausencia WHERE id_usuario=$this->id";

        if ($filtro !== "") {

            $sql .= " AND $filtro";
        }

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id, $inicio, $fim);
        $ausencias = array();
        while ($ps->fetch()) {

            $a = new Ausencia();
            $a->id = $id;
            $a->inicio = $inicio;
            $a->fim = $fim;
            $ausencias[] = $a;
        }
        $ps->close();

        return $ausencias;
    }

    public function getExpedientes($con) {

        $ps = $con->getConexao()->prepare("SELECT id,inicio,fim,dia_semana FROM expediente WHERE id_usuario=$this->id");
        $ps->execute();
        $ps->bind_result($id, $inicio, $fim, $dia_semana);
        $expedientes = array();
        while ($ps->fetch()) {

            $e = new Expediente();
            $e->id = $id;
            $e->inicio = $inicio;
            $e->fim = $fim;
            $e->dia_semana = $dia_semana;
            $expedientes[] = $e;
        }
        $ps->close();

        return $expedientes;
    }

    public function setExpedientes($con, $expedientes) {

        $in = "(-1";

        foreach ($expedientes as $key => $value) {

            $in .= ",$value->id";
        }

        $in .= ")";

        $ps = $con->getConexao()->prepare("DELETE FROM expediente WHERE id_usuario=$this->id AND id NOT IN $in");
        $ps->execute();
        $ps->close();

        foreach ($expedientes as $key => $value) {

            $value->merge($con);

            $ps = $con->getConexao()->prepare("UPDATE expediente SET id_usuario=$this->id WHERE id=$value->id");
            $ps->execute();
            $ps->close();
        }
    }

    public function setAusencias($con, $ausencias) {

        $in = "(-1";

        foreach ($ausencias as $key => $value) {

            $in .= ",$value->id";
        }

        $in .= ")";

        $ps = $con->getConexao()->prepare("DELETE FROM ausencia WHERE id_usuario=$this->id AND id NOT IN $in");
        $ps->execute();
        $ps->close();

        foreach ($ausencias as $key => $value) {

            $value->merge($con);

            $ps = $con->getConexao()->prepare("UPDATE ausencia SET id_usuario=$this->id WHERE id=$value->id");
            $ps->execute();
            $ps->close();
        }
    }

    public function merge($con) {


        $ps = $con->getConexao()->prepare("SELECT id FROM usuario WHERE (cpf<>'" . $this->cpf->valor . "' AND login='$this->login') AND id <> $this->id AND id_empresa=" . $this->empresa->id);
        $ps->execute();
        $ps->bind_result($id);
        if ($ps->fetch()) {
            $ps->close();
            throw new Exception("Ja existe um usuario com os mesmos dados $id");
        }
        $ps->close();
        
        

        if ($this->id == 0) {
            $ps = $con->getConexao()->prepare("INSERT INTO usuario(login,senha,nome,cpf,excluido,id_empresa,rg) VALUES('" . addslashes($this->login) . "','" . addslashes($this->senha) . "','" . addslashes($this->nome) . "','" . $this->cpf->valor . "',false," . $this->empresa->id . ",'" . addslashes($this->rg->valor) . "')");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {
            $ps = $con->getConexao()->prepare("UPDATE usuario SET login='" . addslashes($this->login) . "',senha='" . addslashes($this->senha) . "', nome = '" . addslashes($this->nome) . "', cpf='" . $this->cpf->valor . "',excluido=false, id_empresa=" . $this->empresa->id . ",rg='" . addslashes($this->rg->valor) . "' WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();
        }

        if ($this->cargo !== null) {

            $ps = $con->getConexao()->prepare("UPDATE usuario SET id_cargo=" . $this->cargo->id . " WHERE id=" . $this->id);
            $ps->execute();
            $ps->close();
        }

        $this->email->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE email SET id_entidade=" . $this->id . ", tipo_entidade='USU' WHERE id = " . $this->email->id);
        $ps->execute();
        $ps->close();

        $this->endereco->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE endereco SET id_entidade=" . $this->id . ", tipo_entidade='USU' WHERE id = " . $this->endereco->id);
        $ps->execute();
        $ps->close();

        $ps = $con->getConexao()->prepare("DELETE FROM usuario_permissao WHERE id_usuario=$this->id");
        $ps->execute();
        $ps->close();

        foreach ($this->permissoes as $key => $value) {

            $in = ($value->in ? "true" : "false");
            $del = ($value->del ? "true" : "false");
            $alt = ($value->alt ? "true" : "false");
            $cons = ($value->cons ? "true" : "false");

            $ps = $con->getConexao()->prepare("INSERT INTO usuario_permissao(id_usuario,id_permissao,incluir,deletar,alterar,consultar) VALUES($this->id,$value->id,$in,$del,$alt,$cons)");
            $ps->execute();
            $ps->close();
        }

        $ps = $con->getConexao()->prepare("DELETE FROM usuario_permissao WHERE id_usuario=$this->id AND incluir=false AND deletar=false AND alterar=false AND consultar=false");
        $ps->execute();
        $ps->close();

        $tels = array();
        $ps = $con->getConexao()->prepare("SELECT id,numero FROM telefone WHERE tipo_entidade='USU' AND id_entidade=$this->id AND excluido=false");
        $ps->execute();
        $ps->bind_result($idt, $numerot);
        while ($ps->fetch()) {
            $t = new Telefone($numerot);
            $t->id = $idt;
            $tels[] = $t;
        }

        foreach ($tels as $key => $value) {

            foreach ($this->telefones as $key2 => $value2) {

                if ($value->id == $value2->id) {

                    continue 2;
                }
            }

            $value->delete($con);
        }

        foreach ($this->telefones as $key => $value) {

            $value->merge($con);

            $ps = $con->getConexao()->prepare("UPDATE telefone SET tipo_entidade='USU', id_entidade=$this->id WHERE id=" . $value->id);
            $ps->execute();
            $ps->close();
        }
        
        $filiais = $this->empresa->getFiliais($con);
        
        foreach($filiais as $key=>$value){
            
            $q = $value->getCountUsuarios($con,"usuario.cpf='".$this->cpf->valor."'");
            if($q === 0){
                $c = Utilidades::copyId0($this);
                $c->endereco = Utilidades::copyId0($this->endereco);
                $c->email = Utilidades::copyId0($c->email);
                $c->telefones = Utilidades::copyId0($c->telefones);
                $c->empresa=$value;
                $c->cargo = Empresa::CF_SEM_CARGO($c->empresa);
                $c->merge($con);
            }
        }
        
    }

    public function temPermissao($p) {

        foreach ($this->permissoes as $key => $value) {

            if ($value->nome == $p->nome) {

                if ($p->in && !$value->in) {
                    return false;
                } else if ($p->del && !$value->del) {
                    return false;
                } else if ($p->alt && !$value->alt) {
                    return false;
                } else if ($p->cons && !$value->cons) {
                    return false;
                } else {

                    foreach ($this->empresa->rtc->permissoes as $key2 => $value2) {
                        if ($value2->id === $value->id) {
                            return true;
                        }
                    }

                    foreach ($this->empresa->permissoes_especiais as $key3 => $value3) {
                        if ($key3 >= $this->empresa->rtc->numero) {
                            continue;
                        }
                        foreach ($value3 as $key2 => $value2) {
                            if ($value2->id === $value->id) {
                                return true;
                            }
                        }
                    }

                    return false;
                }
            }
        }

        return false;
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE usuario SET excluido = true WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
