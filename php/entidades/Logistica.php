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
class Logistica extends Empresa {

    function __construct() {

        parent::__construct();

        $this->is_logistica = true;
    }

    public function getCountProdutoClienteLogistic($con, $filtro = "") {

        $sql = "SELECT COUNT(*) "
                . "FROM produto "
                . "INNER JOIN categoria_produto ON categoria_produto.id=produto.id_categoria "
                . "INNER JOIN empresa ON empresa.id=produto.id_empresa "
                . "WHERE produto.id_logistica=$this->id ";

        if ($filtro != "") {

            $sql .= "AND $filtro ";
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

    public function getProdutoClienteLogistic($con, $x1, $x2, $filtro = "", $ordem = "") {

        $sql = "SELECT "
                . "produto.id_universal, "
                . "produto.nome, "
                . "produto.estoque, "
                . "produto.disponivel, "
                . "produto.transito, "
                . "categoria_produto.nome, "
                . "CONCAT(CONCAT(empresa.id,'-'),empresa.nome) "
                . "FROM produto "
                . "INNER JOIN categoria_produto ON categoria_produto.id=produto.id_categoria "
                . "INNER JOIN empresa ON empresa.id=produto.id_empresa "
                . "WHERE produto.id_logistica=$this->id ";

        if ($filtro != "") {

            $sql .= "AND $filtro ";
        }

        if ($ordem != "") {

            $sql .= "ORDER BY $ordem ";
        }

        $sql .= "LIMIT $x1, " . ($x2 - $x1) . " ";

        $ps = $con->getConexao()->prepare($sql);

        $ps->execute();
        $ps->bind_result($id, $nome, $estoque, $disponivel, $transito, $categoria, $empresa);

        $empresas = array();

        $produtos = array();

        while ($ps->fetch()) {

            if (!isset($produtos[$id])) {

                $p = new ProdutoClienteLogistic();
                $p->id = $id;
                $p->nome = $nome;
                $p->categoria = $categoria;

                $produtos[$id] = $p;
            }

            $pro = $produtos[$id];

            $pro->estoques[$empresa] = $estoque;
            $pro->disponiveis[$empresa] = $disponivel;
            $pro->transitos[$empresa] = $transito;

            foreach ($empresas as $key => $value) {

                if ($value === $empresa) {

                    continue 2;
                }
            }

            $empresas[] = $empresa;
        }

        $ps->close();

        $retorno = array();

        foreach ($produtos as $key => $value) {

            $pem = array();
            $pe = array();
            $pd = array();
            $pt = array();

            foreach ($empresas as $key2 => $value2) {

                if (isset($value->estoques[$value2])) {

                    $pem[] = $value2;
                    $pe[] = $value->estoques[$value2];
                    $pd[] = $value->disponiveis[$value2];
                    $pt[] = $value->transitos[$value2];
                } else {

                    $pem[] = $value2;
                    $pe[] = 0;
                    $pd[] = 0;
                    $pt[] = 0;
                }
            }

            $value->empresas = $pem;
            $value->estoques = $pe;
            $value->transitos = $pt;
            $value->disponiveis = $pd;

            $retorno[] = $value;
        }

        return $retorno;
    }

    //@Override
    public function getCadastroLotesPendentes($con) {

        $sql = "SELECT "
                . "produto.id,"
                . "produto.nome,"
                . "(produto.disponivel-IFNULL(l.quantidade,0)),"
                . "produto.grade "
                . "FROM produto "
                . "LEFT JOIN (SELECT lote.id_produto,SUM(lote.quantidade_real) as 'quantidade' FROM lote WHERE lote.excluido=false GROUP BY lote.id_produto) l ON l.id_produto=produto.id "
                . "WHERE (produto.id_empresa = $this->id OR produto.id_logistica = $this->id) AND produto.excluido = false AND (produto.disponivel-IFNULL(l.quantidade,0))>0";


        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id, $nome, $quantidade, $grade);

        $p = array();

        while ($ps->fetch()) {

            $c = new CadastroLotePendente();
            $c->id_produto = $id;
            $c->nome_produto = $nome;
            $c->quantidade = $quantidade;
            $c->grade = new Grade($grade);

            $p[] = $c;
        }

        $ps->close();

        return $p;
    }

    //@Override
    public function getCountLotes($con, $filtro = "") {

        $sql = "SELECT COUNT(*) FROM lote INNER JOIN produto ON produto.id=lote.id_produto WHERE (produto.id_empresa=$this->id OR produto.id_logistica=$this->id) AND lote.excluido=false ";

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

    //@Override
    public function getLotes($con, $x1, $x2, $filtro = "", $ordem = "") {

        $campanhas = array();
        $ofertas = array();

        $ps = $con->getConexao()->prepare("SELECT "
                . "campanha.id,"
                . "campanha.inicio,"
                . "campanha.fim,"
                . "campanha.prazo,"
                . "campanha.parcelas,"
                . "campanha.cliente_expression,"
                . "produto_campanha.id,"
                . "produto_campanha.id_produto,"
                . "UNIX_TIMESTAMP(produto_campanha.validade)*1000,"
                . "produto_campanha.limite,"
                . "produto_campanha.valor, "
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
        $ps->bind_result($id, $inicio, $fim, $prazo, $parcelas, $cliente, $id_produto_campanha, $id_produto, $validade, $limite, $valor, $id_empresa, $is_logistica, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        while ($ps->fetch()) {

            if (!isset($campanhas[$id])) {

                $campanhas[$id] = new Campanha();
                $campanhas[$id]->id = $id;
                $campanhas[$id]->inicio = $inicio;
                $campanhas[$id]->fim = $fim;
                $campanhas[$id]->prazo = $prazo;
                $campanhas[$id]->parcelas = $parcelas;
                $campanhas[$id]->cliente_expression = $cliente;

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

                $campanhas[$id]->empresa = $empresa;
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

            $campanhas[$id]->produtos[] = $p;
        }
        $ps->close();

        $sql = "SELECT "
                . "lote.id,"
                . "lote.numero,"
                . "lote.rua,"
                . "lote.altura,"
                . "UNIX_TIMESTAMP(lote.validade)*1000,"
                . "UNIX_TIMESTAMP(lote.data_entrada)*1000,"
                . "lote.grade,"
                . "lote.quantidade_inicial,"
                . "lote.quantidade_real,"
                . "lote.codigo_fabricante,"
                . "GROUP_CONCAT(retirada.retirada separator ';'),"
                . "produto.id,"
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
                . "categoria_produto.id,"
                . "categoria_produto.nome,"
                . "categoria_produto.base_calculo,"
                . "categoria_produto.ipi,"
                . "categoria_produto.icms_normal,"
                . "categoria_produto.icms, "
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
                . "FROM lote "
                . "LEFT JOIN retirada ON lote.id=retirada.id_lote "
                . "INNER JOIN produto ON lote.id_produto=produto.id "
                . "INNER JOIN categoria_produto ON categoria_produto.id=produto.id_categoria "
                . "INNER JOIN empresa ON empresa.id = produto.id_empresa "
                . "INNER JOIN telefone ON telefone.id_entidade=empresa.id AND telefone.tipo_entidade='EMP' "
                . "INNER JOIN email ON email.id_entidade = empresa.id AND email.tipo_entidade='EMP' "
                . "INNER JOIN endereco ON endereco.id_entidade = empresa.id AND endereco.tipo_entidade='EMP' "
                . "INNER JOIN cidade ON endereco.id_cidade = cidade.id "
                . "INNER JOIN estado ON cidade.id_estado = estado.id "
                . "WHERE (produto.id_empresa = $this->id OR produto.id_logistica = $this->id) AND lote.excluido = false ";

        if ($filtro != "") {

            $sql .= "AND $filtro ";
        }

        $sql .= "GROUP BY lote.id ";

        if ($ordem != "") {

            $sql .= "ORDER BY $ordem ";
        }

        $sql .= "LIMIT $x1," . ($x2 - $x1);


        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id, $numero_lote, $rua_lote, $altura, $validade, $entrada, $grade, $quantidade_inicial, $quantidade_real, $codigo_fabricante, $retirada, $id_pro, $id_log, $classe_risco, $fabricante, $imagem, $id_uni, $liq, $qtd_un, $hab, $vb, $cus, $pb, $pl, $est, $disp, $tr, $gr, $uni, $ncm, $nome, $lucro, $ativo, $conc, $cat_id, $cat_nom, $cat_bs, $cat_ipi, $cat_icms_normal, $cat_icms, $id_empresa, $is_logistica, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        $lotes = array();

        $produtos = array();

        while ($ps->fetch()) {

            if (!isset($produtos[$id_pro])) {

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

                $p = new Produto();
                $p->logistica = $id_log;
                $p->id = $id_pro;
                $p->classe_risco = $classe_risco;
                $p->fabricante = $fabricante;
                $p->imagem = $imagem;
                $p->nome = $nome;
                $p->id_universal = $id_uni;
                $p->liquido = $liq == 1;
                $p->quantidade_unidade = $qtd_un;
                $p->habilitado = $hab;
                $p->empresa = $empresa;
                $p->valor_base = $vb;
                $p->custo = $cus;
                $p->peso_bruto = $pb;
                $p->peso_liquido = $pl;
                $p->estoque = $est;
                $p->disponivel = $disp;
                $p->ativo = $ativo;
                $p->concentracao = $conc;
                $p->transito = $tr;
                $p->grade = new Grade($gr);
                $p->unidade = $uni;
                $p->ncm = $ncm;
                $p->lucro_consignado = $lucro;
                $p->ofertas = (!isset($ofertas[$p->id]) ? array() : $ofertas[$p->id]);

                foreach ($p->ofertas as $key => $oferta) {

                    $oferta->produto = $p;
                }

                $p->categoria = new CategoriaProduto();

                $p->categoria->id = $cat_id;
                $p->categoria->nome = $cat_nom;
                $p->categoria->base_calculo = $cat_bs;
                $p->categoria->icms = $cat_icms;
                $p->categoria->icms_normal = $cat_icms_normal;
                $p->categoria->ipi = $cat_ipi;

                $produtos[$id_pro] = $p;
            }


            $lote = new Lote();
            $lote->id = $id;
            $lote->numero = $numero_lote;
            $lote->rua = $rua_lote;
            $lote->altura = $altura;
            $lote->validade = $validade;
            $lote->entrada = $entrada;
            $lote->quantidade_inicial = $quantidade_inicial;
            $lote->grade = new Grade($grade);
            $lote->quantidade_real = $quantidade_real;
            $lote->produto = $produtos[$id_pro];
            $lote->codigo_fabricante = $codigo_fabricante;

            if ($retirada != null) {

                $rets = explode(';', $retirada);

                foreach ($rets as $key => $value) {

                    $ret = explode(',', $value);
                    foreach ($ret as $key => $value) {

                        $ret[$key] = intval($ret[$key]);
                    }

                    $lote->retiradas[] = $ret;
                }
            }

            $lotes[] = $lote;
        }

        $ps->close();

        foreach ($produtos as $key => $value) {
            $value->logistica = Sistema::getLogisticaById($con, $value->logistica);
        }

        return $lotes;
    }

}
