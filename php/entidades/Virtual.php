<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Logistica
 *
 * @author Renan
 */
class Virtual extends Empresa {

    public static function CF_ASSISTENTE_VIRTUAL_PROSPECCAO($emp) {
        return new CargoFixo(99, "Assistente Virtual de Prospeccao", $emp);
    }

    public static function CF_ASSISTENTE_VIRTUAL_RECEPCAO($emp) {
        return new CargoFixo(13, "Assistente Virtual de Recepcao", $emp);
    }
    
    public static function CF_ASSISTENTE_VIRTUAL_RECEPCAO_M2($emp) {
        return new CargoFixo(34, "Assistente Virtual de Recepcao M2", $emp);
    }

    public static function CF_ASSISTENTE_VIRTUAL_SUPORTE($emp) {
        return new CargoFixo(14, "Assistente Virtual de Suporte", $emp);
    }

    public static function CF_ASSISTENTE_VIRTUAL_POSVENDA($emp) {
        return new CargoFixo(15, "Assistente Virtual de Pos Venda", $emp);
    }

    function __construct($id = 0, $con = null) {

        parent::__construct($id, $con);

        $this->permissoes_especiais[] = array(
            Sistema::P_EMPRESA_CLIENTE(),
            Sistema::P_RELACAO_CLIENTE());

        $this->cargos_fixos[] = Virtual::CF_ASSISTENTE_VIRTUAL_PROSPECCAO($this);
        $this->cargos_fixos[] = Virtual::CF_ASSISTENTE_VIRTUAL_RECEPCAO($this);
        $this->cargos_fixos[] = Virtual::CF_ASSISTENTE_VIRTUAL_SUPORTE($this);
        $this->cargos_fixos[] = Virtual::CF_ASSISTENTE_VIRTUAL_POSVENDA($this);
        $this->cargos_fixos[] = Virtual::CF_ASSISTENTE_VIRTUAL_RECEPCAO_M2($this);

        $this->tarefas_fixas[] = "TT_PROSPECCAO_CLIENTE";
        $this->tarefas_fixas[] = "TT_RECEPCAO_CLIENTE";
        $this->tarefas_fixas[] = "TT_RECEPCAO_CLIENTE_M2";
        $this->tarefas_fixas[] = "TT_SUPORTE_CLIENTE";
        $this->tarefas_fixas[] = "TT_FAQ_CLIENTE";
        $this->tarefas_fixas[] = "TT_ATENDIMENTO_POSVENDA";
        $this->tarefas_fixas[] = "TT_PROSPECCAO_EXTERNA_CLIENTE";
        
    }
    
    public function getEmpresasClientes($con){
        
        $contratadas = array($this);

        $ps = $con->getConexao()->prepare("SELECT "
                . "empresa.id,"
                . "empresa.tipo_empresa,"
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
                . "WHERE empresa.empresa_vendas=$this->id");
        $ps->execute();
        $ps->bind_result($id_empresa, $tipo_empresa, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        while ($ps->fetch()) {

            $empresa = Sistema::getEmpresa($tipo_empresa);

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

            $contratadas[] = $empresa;
        }

        $ps->close();

        return $contratadas;
        
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
                . "email_cliente.senha, "
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
                . "telefone_empresa.numero "
                . "FROM cliente "
                . "INNER JOIN endereco endereco_cliente ON endereco_cliente.id_entidade=cliente.id AND endereco_cliente.tipo_entidade='CLI' "
                . "INNER JOIN cidade cidade_cliente ON endereco_cliente.id_cidade=cidade_cliente.id "
                . "INNER JOIN estado estado_cliente ON estado_cliente.id=cidade_cliente.id_estado "
                . "INNER JOIN categoria_cliente ON cliente.id_categoria=categoria_cliente.id "
                . "INNER JOIN email email_cliente ON email_cliente.id_entidade=cliente.id AND email_cliente.tipo_entidade = 'CLI' "
                . "INNER JOIN empresa ON empresa.id=cliente.id_empresa "
                . "INNER JOIN endereco endereco_empresa ON endereco_empresa.id_entidade=empresa.id AND endereco_empresa.tipo_entidade='EMP' "
                . "INNER JOIN email email_empresa ON email_empresa.id_entidade=empresa.id AND email_empresa.tipo_entidade='EMP' "
                . "INNER JOIN telefone telefone_empresa ON telefone_empresa.id_entidade=empresa.id AND telefone_empresa.tipo_entidade='EMP' "
                . "INNER JOIN cidade cidade_empresa ON endereco_empresa.id_cidade=cidade_empresa.id "
                . "INNER JOIN estado estado_empresa ON cidade_empresa.id_estado = estado_empresa.id "
                . "WHERE (cliente.id_empresa=$this->id OR empresa.empresa_vendas=$this->id) AND cliente.excluido=false ";

        if ($filtro != "") {

            $sql .= "AND $filtro ";
        }

        if ($ordem != "") {

            $sql .= "ORDER BY $ordem ";
        }

        $sql .= "LIMIT $x1, " . ($x2 - $x1);


        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id_cliente, $cod_ctm, $cod_cli, $nome_cliente, $nome_fantasia_cliente, $limite, $inicio, $fim, $pessoa_fisica, $cpf, $cnpj, $rg, $ie, $suf, $i_suf, $cat_id, $cat_nome, $end_cli_id, $end_cli_rua, $end_cli_numero, $end_cli_bairro, $end_cli_cep, $cid_cli_id, $cid_cli_nome, $est_cli_id, $est_cli_nome, $email_cli_id, $email_cli_end, $email_cli_senha, $id_empresa, $tipo_empresa, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj_empresa, $numero_endereco_empresa, $id_endereco_empresa, $rua_empresa, $bairro_empresa, $cep_empresa, $id_cidade_empresa, $nome_cidade_empresa, $id_estado_empresa, $nome_estado_empresa, $id_email_empresa, $endereco_email_empresa, $senha_email_empresa, $id_telefone_empresa, $numero_telefone_empresa);

        $empresas = array();

        $clientes = array();

        while ($ps->fetch()) {

            if (!isset($empresas[$id_empresa])) {

                $empresa = Sistema::getEmpresa($tipo_empresa);

                $empresa->id = $id_empresa;
                $empresa->cnpj = new CNPJ($cnpj_empresa);
                $empresa->inscricao_estadual = $inscricao_empresa;
                $empresa->nome = $nome_empresa;
                $empresa->aceitou_contrato = $aceitou_contrato;
                $empresa->juros_mensal = $juros_mensal;
                $empresa->consigna = $consigna;

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

                $cidade->estado = $estado;

                $endereco->cidade = $cidade;

                $empresa->endereco = $endereco;

                $email = new Email($endereco_email_empresa);
                $email->id = $id_email_empresa;
                $email->senha = $senha_email_empresa;

                $empresa->email = $email;

                $telefone = new Telefone($numero_telefone_empresa);
                $telefone->id = $id_telefone_empresa;

                $empresa->telefone = $telefone;

                $empresas[$id_empresa] = $empresa;
            }

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
            $cliente->empresa = $empresas[$id_empresa];
            $cliente->inscricao_estadual = $ie;

            $end = new Endereco();
            $end->id = $end_cli_id;
            $end->bairro = $end_cli_bairro;
            $end->cep = new CEP($end_cli_cep);
            $end->numero = $end_cli_numero;
            $end->rua = $end_cli_rua;

            $end->cidade = new Cidade();
            $end->cidade->id = $cid_cli_id;
            $end->cidade->nome = $cid_cli_nome;

            $end->cidade->estado = new Estado();
            $end->cidade->estado->id = $est_cli_id;
            $end->cidade->estado->sigla = $est_cli_nome;

            $cliente->endereco = $end;

            $clientes[$id_cliente] = $cliente;
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

        return $real;
    }

    public function getCountClientes($con, $filtro = "") {

        $sql = "SELECT COUNT(*) FROM cliente INNER JOIN empresa ON empresa.id=cliente.id_empresa WHERE (cliente.id_empresa=$this->id OR empresa.empresa_vendas=$this->id) AND cliente.excluido=false ";

        if ($filtro != "") {

            $sql .= "AND $filtro";
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

}
