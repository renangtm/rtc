<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegraTabela
 *
 * @author Renan
 */
class Encomenda {

    public $id;
    public $cliente;
    public $observacoes;
    public $empresa;
    public $data;
    public $excluido;
    public $usuario;
    public $status;
    public $produtos;
    public $prazo;
    public $parcelas;

    function __construct() {

        $this->id = 0;
        $this->cliente = null;
        $this->observacoes = "";
        $this->empresa = null;
        $this->data = round(microtime(true) * 1000);
        $this->excluido = false;
        $this->usuario = null;
        $this->status = Sistema::STATUS_ENCOMENDA_ANALISE();
        $this->produtos = null;
        $this->prazo = 0;
        $this->parcelas = 0;
    }

    public function getProdutos($con) {

        $campanhas = array();
        $ofertas = array();

        $ps = $con->getConexao()->prepare("SELECT "
                . "campanha.id,"
                . "campanha.nome,"
                . "UNIX_TIMESTAMP(campanha.inicio)*1000,"
                . "UNIX_TIMESTAMP(campanha.fim)*1000,"
                . "campanha.prazo,"
                . "campanha.parcelas,"
                . "campanha.cliente_expression,"
                . "produto_campanha.id,"
                . "produto_campanha.id_produto,"
                . "UNIX_TIMESTAMP(produto_campanha.validade)*1000,"
                . "produto_campanha.limite,"
                . "produto_campanha.valor, "
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
                . "FROM campanha "
                . "INNER JOIN produto_campanha ON campanha.id = produto_campanha.id_campanha "
                . "INNER JOIN empresa ON campanha.id_empresa=empresa.id "
                . "INNER JOIN endereco ON endereco.id_entidade=empresa.id AND endereco.tipo_entidade='EMP' "
                . "INNER JOIN email ON email.id_entidade=empresa.id AND email.tipo_entidade='EMP' "
                . "INNER JOIN telefone ON telefone.id_entidade=empresa.id AND telefone.tipo_entidade='EMP' "
                . "INNER JOIN cidade ON endereco.id_cidade=cidade.id "
                . "INNER JOIN estado ON cidade.id_estado = estado.id "
                . " WHERE campanha.inicio<=CURRENT_TIMESTAMP AND campanha.fim>=CURRENT_TIMESTAMP AND campanha.excluida=false");

        $ps->execute();
        $ps->bind_result($id, $camp_nome, $inicio, $fim, $prazo, $parcelas, $cliente, $id_produto_campanha, $id_produto, $validade, $limite, $valor, $id_empresa, $tipo_empresa, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        while ($ps->fetch()) {

            if (!isset($campanhas[$id])) {

                $campanhas[$id] = new Campanha();
                $campanhas[$id]->id = $id;
                $campanhas[$id]->nome = $camp_nome;
                $campanhas[$id]->inicio = $inicio;
                $campanhas[$id]->fim = $fim;
                $campanhas[$id]->prazo = $prazo;
                $campanhas[$id]->parcelas = $parcelas;
                $campanhas[$id]->cliente_expression = $cliente;

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

                $campanhas[$id]->empresa = $empresa;

                $campanhas[$id] = $campanhas[$id]->getReduzida();
            }

            $campanha = $campanhas[$id];

            $p = new ProdutoCampanha();
            $p->id = $id_produto_campanha;
            $p->validade = $validade;
            $p->limite = $limite;
            $p->valor = $valor;
            $p->campanha = $campanha;

            if (!isset($ofertas[$id_produto])) {

                $ofertas[$id_produto] = array();
            }

            $ofertas[$id_produto][] = $p;
        }

        $ps->close();

        $ps = $con->getConexao()->prepare("SELECT produto_encomenda.id,"
                . "produto_encomenda.quantidade,"
                . "produto_encomenda.valor_base_inicial,"
                . "produto_encomenda.valor_base_final,"
                . "produto_encomenda.juros_inicial,"
                . "produto_encomenda.juros_final,"
                . "produto_encomenda.icms_inicial,"
                . "produto_encomenda.icms_final,"
                . "produto_encomenda.base_calculo_inicial,"
                . "produto_encomenda.base_calculo_final,"
                . "produto_encomenda.ipi_inicial,"
                . "produto_encomenda.ipi_final,"
                . "produto.id,"
                . "produto.codigo,"
                . "produto.id_logistica,"
                . "produto.classe_risco,"
                . "produto.fabricante,"
                . "produto.imagem,"
                . "produto.id_universal,"
                . "produto.liquido,"
                . "produto.quantidade_unidade,"
                . "produto.habilitado,"
                . "produto.valor_base,"
                . "produto.custo,"
                . "produto.peso_bruto,"
                . "produto.peso_liquido,"
                . "produto.estoque,"
                . "produto.disponivel,"
                . "produto.transito,"
                . "produto.grade,"
                . "produto.unidade,"
                . "produto.ncm,"
                . "produto.nome,"
                . "produto.lucro_consignado,"
                . "produto.ativo,"
                . "produto.concentracao,"
                . "produto.sistema_lotes,"
                . "produto.nota_usuario,"
                . "produto.id_categoria,"
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
                . "telefone.numero"
                . " FROM produto_encomenda "
                . "INNER JOIN produto ON produto_encomenda.id_produto=produto.id "
                . "INNER JOIN empresa ON produto.id_empresa=empresa.id "
                . "INNER JOIN endereco ON endereco.id_entidade=empresa.id AND endereco.tipo_entidade='EMP' "
                . "INNER JOIN email ON email.id_entidade=empresa.id AND email.tipo_entidade='EMP' "
                . "INNER JOIN telefone ON telefone.id_entidade=empresa.id AND telefone.tipo_entidade='EMP' "
                . "INNER JOIN cidade ON endereco.id_cidade=cidade.id "
                . "INNER JOIN estado ON cidade.id_estado = estado.id "
                . " WHERE produto_encomenda.id_encomenda=$this->id");

        $ps->execute();
        $ps->bind_result($id, $quantidade, $valor_base_inicial, $valor_base_final, $juros_inicial, $juros_final, $icms_inicial, $icms_final, $base_calculo_inicial, $base_calculo_final, $ipi_inicial, $ipi_final, $id_pro, $cod_pro, $id_log, $classe_risco, $fabricante, $imagem, $id_uni, $liq, $qtd_un, $hab, $vb, $cus, $pb, $pl, $est, $disp, $tr, $gr, $uni, $ncm, $nome, $lucro, $ativo, $conc, $sistema_lote, $nota_usuario, $cat_id, $id_empresa, $tipo_empresa, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        $retorno = array();


        $ids = "-1";
        while ($ps->fetch()) {

            $p = new Produto();

            $p->logistica = $id_log;
            $p->id = $id_pro;
            $p->codigo = $cod_pro;
            $p->nome = $nome;
            $p->classe_risco = $classe_risco;
            $p->fabricante = $fabricante;
            $p->imagem = $imagem;
            $p->id_universal = $id_uni;
            $p->liquido = $liq;
            $p->quantidade_unidade = $qtd_un;
            $p->habilitado = $hab;
            $p->valor_base = $vb;
            $p->custo = $cus;
            $p->peso_bruto = $pb;
            $p->peso_liquido = $pl;
            $p->estoque = $est;
            $p->disponivel = $disp;
            $p->ativo = $ativo;
            $p->concentracao = $conc;
            $p->transito = $tr;
            $p->sistema_lotes = $sistema_lote == 1;
            $p->nota_usuario = $nota_usuario;
            $p->grade = new Grade($gr);
            $p->unidade = $uni;
            $p->ncm = $ncm;
            $p->lucro_consignado = $lucro;
            $p->empresa = $this->empresa;
            $p->ofertas = (!isset($ofertas[$p->codigo]) ? array() : $ofertas[$p->codigo]);

            foreach ($p->ofertas as $key => $oferta) {

                $oferta->produto = $p->getReduzido();
            }

            $p->categoria = Sistema::getCategoriaProduto(null, $cat_id);

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


            $p->empresa = $empresa;

            $pp = new ProdutoEncomenda();
            $pp->id = $id;
            $pp->quantidade = $quantidade;
            $pp->valor_base_inicial = $valor_base_inicial;
            $pp->valor_base_final = $valor_base_final;
            $pp->base_calculo_inicial = $base_calculo_inicial;
            $pp->base_calculo_final = $base_calculo_final;
            $pp->ipi_inicial = $ipi_inicial;
            $pp->ipi_final = $ipi_final;
            $pp->juros_inicial = $juros_inicial;
            $pp->juros_final = $juros_final;
            $pp->icms_inicial = $icms_inicial;
            $pp->icms_final = $icms_final;

            $pp->encomenda = $this;
            $pp->produto = $p;

            $retorno[$pp->id] = $pp;

            $ids .= "," . $pp->id;
        }
        $ps->close();

        foreach ($retorno as $key => $value) {

            $value->produto->logistica = Sistema::getLogisticaById($con, $value->produto->logistica);
        }

        $real_ret = array();

        foreach ($retorno as $key => $value) {

            $real_ret[] = $value;
        }

        return $real_ret;
    }

    public function atualizarCustos() {

        foreach ($this->produtos as $key => $value) {

            $value->atualizarCustos();
        }
    }

    public function getTotalInicial() {

        $total = 0;

        foreach ($this->produtos as $key => $value) {

            $total += ($value->valor_base_inicial + $value->icms_inicial + $value->juros_inicial + $value->ipi_inicial) * $value->quantidade;
        }

        return $total;
    }

    public function getTotalFinal() {

        $total = 0;

        foreach ($this->produtos as $key => $value) {

            $total += ($value->valor_base_final + $value->icms_final + $value->juros_final + $value->ipi_final) * $value->quantidade;
        }

        return $total;
    }

    public function merge($con) {

        $prods = $this->getProdutos($con);

        if ($this->produtos === null) {
            $this->produtos = $prods;
        }


        $inicial = $this->id === 0;

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO encomenda(id_cliente,observacoes,id_empresa,data,excluida,id_usuario,prazo,parcelas,id_status) VALUES(" . $this->cliente->id . ",'$this->observacoes'," . $this->empresa->id . ",FROM_UNIXTIME($this->data/1000),false," . $this->usuario->id . ",$this->prazo,$this->parcelas," . $this->status->id . ")");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();

            $atividade = new Atividade($this->usuario);
            $atividade->descricao = "Encomenda fechada " . $this->getTotalInicial() . " ate " . $this->getTotalFinal();
            $atividade->pontos = $this->getTotalInicial();
            $atividade->tipo = Atividade::$PEDIDO;
            $atividade->merge($con);

            $empresa = $this->empresa;

            $adm = $empresa->getAdm($con);
            if ($adm !== null) {
                $empresa = $adm;
            }

            $t = new Tarefa();
            $t->tipo_tarefa = Sistema::TT_COTACAO($empresa->id);
            $t->titulo = "Nova encomenda $this->id, do cliente " . $this->cliente->razao_social;
            $t->descricao = "Houve uma nova encomenda de numero $this->id, veja os maiores detalhes na aba de encomenda";
            $t->tipo_entidade_relacionada = "ENC_" . $this->empresa->id;
            $t->id_entidade_relacionada = $this->id;

            try {
                Sistema::novaTarefaEmpresa($con, $t, $empresa);
            } catch (Exception $e) {
                
            }
            
        } else {

            $ps = $con->getConexao()->prepare("UPDATE encomenda SET id_cliente=" . $this->cliente->id . ",observacoes='$this->observacoes',id_empresa=" . $this->empresa->id . ",data=FROM_UNIXTIME($this->data/1000),excluida=false,id_usuario=" . $this->usuario->id . ",prazo=$this->prazo,parcelas=$this->parcelas,id_status=" . $this->status->id . " WHERE id=$this->id");
            $ps->execute();
            $ps->close();

        }

        $erro = null;

        foreach ($prods as $key => $value) {

            foreach ($this->produtos as $key2 => $value2) {

                if ($value->id == $value2->id) {

                    continue 2;
                }
            }

            try {

                $value->delete($con);
            } catch (Exception $ex) {
                $erro = $ex->getMessage();
            }
        }

        $np = array();
        foreach ($this->produtos as $key2 => $value2) {
            try {
                $value2->merge($con);
                $np[] = $value2;
            } catch (Exception $ex) {
                $erro = $ex->getMessage();
            }
        }

        $this->produtos = $np;


        Logger::gerarLog($this, $this->status->nome);
        if ($inicial) {
            $this->status->enviarEmails($this);
        }

        if ($erro !== null) {
            throw new Exception($erro);
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE encomenda SET excluida=true WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();

        $this->status = Sistema::STATUS_ENCOMENDA_CANCELADA();

        $this->produtos = $this->getProdutos($con);

        $erro = null;
        $ps = $con->getConexao()->prepare("UPDATE tarefa SET inicio_minimo=inicio_minimo,excluida=true "
                . "WHERE tipo_entidade_relacionada='ENC_" . $this->empresa->id . "' AND id_entidade_relacionada=$this->id AND porcentagem_conclusao<100");
        $ps->execute();
        $ps->close();

        foreach ($this->produtos as $key => $value) {
            try {
                $value->merge($con);
            } catch (Exception $ex) {
                $value->delete($con);
                $erro = $ex->getMessage();
            }
        }

        if ($erro !== null) {

            throw new Exception($erro);
        }
    }

}
