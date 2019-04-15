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
class ProdutoAlocal {

    public $id;
    public $id_universal;
    public $nome;
    public $categoria;
    public $liquido;
    public $unidade;
    public $quantidade_unidade;
    public $excluido;
    public $habilitado;
    public $empresa;
    public $valor_base;
    public $custo;
    public $ncm;
    public $peso_liquido;
    public $peso_bruto;
    public $ativo;
    public $concentracao;
    public $ofertas;
    public $grade;
    public $imagem;
    public $fabricante;
    public $classe_risco;
    public $locais;
    public $codigo;
    public $estoque;
    public $disponivel;
    public $transito;
    public $sistema_lotes;

    function __construct() {

        $this->id = 0;
        $this->id_universal = 0;
        $this->categoria = null;
        $this->liquido = false;
        $this->quantidade_unidade = 1;
        $this->excluido = false;
        $this->habilitado = true;
        $this->empresa = null;
        $this->valor_base = 0;
        $this->custo = 0;
        $this->peso_bruto = 0;
        $this->lucro_consignado = 0;
        $this->peso_liquido = 0;
        $this->grade = new Grade("1");
        $this->ofertas = array();
        $this->classe_risco = 0;
        $this->ativo = "";
        $this->concentracao = "";
        $this->locais = array();
        $this->ncm = "000000";
        $this->unidade = "Ob";
        $this->codigo = 0;
        $this->estoque = 0;
        $this->disponivel = 0;
        $this->transito = 0;
        $this->sistema_lotes = false;
        
    }

    public function getReduzido() {

        $p = new ProdutoReduzido();
        $p->id = $this->id;
        $p->codigo = $this->codigo;
        $p->nome = $this->nome;
        $p->imagem = $this->imagem;

        return $p;
    }

    public function getLotes($con, $filtro = null, $ordem = null) {

        $sql = "SELECT lote.id,lote.numero,lote.rua,lote.altura, UNIX_TIMESTAMP(lote.validade)*1000, UNIX_TIMESTAMP(lote.data_entrada)*1000, lote.quantidade_inicial, lote.grade, lote.quantidade_real, lote.codigo_fabricante, retirada.retirada FROM lote LEFT JOIN retirada ON lote.id=retirada.id_lote INNER JOIN produto ON produto.id=lote.id_produto WHERE lote.excluido=false AND produto.codigo=$this->codigo AND produto.id_empresa=".$this->empresa->id;
        if ($filtro != null && $filtro != "") {

            $sql .= " AND (" . addslashes($filtro) . ")";
        }

        if ($ordem != null && $ordem != "") {

            $sql .= " ORDER BY " . addslashes($ordem);
        }

        $lotes = array();

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id, $numero, $rua, $altura, $validade, $entrada, $quantidade_inicial, $grade, $quantidade_real, $codigo_fabricante, $retirada);

        while ($ps->fetch()) {

            if (!isset($lotes[$id])) {

                $lote = new Lote();
                $lote->id = $id;
                $lote->numero = $numero;
                $lote->rua = $rua;
                $lote->altura = $altura;
                $lote->validade = $validade;
                $lote->entrada = $entrada;
                $lote->quantidade_inicial = $quantidade_inicial;
                $lote->grade = new Grade($grade);
                $lote->quantidade_real = $quantidade_real;
                $lote->produto = $this;
                $lote->codigo_fabricante = $codigo_fabricante;

                $lotes[$id] = $lote;
            }

            if ($retirada != null) {

                $ret = explode(',', $retirada);
                foreach ($ret as $key => $value) {

                    $ret[$key] = intval($ret[$key]);
                }

                $lotes[$id]->retiradas[] = $ret;
            }
        }

        $ps->close();

        $retorno = array();

        foreach ($lotes as $key => $value) {

            $retorno[] = $value;
        }

        return $retorno;
    }

    public function getReceituario($con) {

        $receituarios = array();

        $ps = $con->getConexao()->prepare("SELECT receituario.id, receituario.instrucoes, cultura.id, cultura.nome, praga.id, praga.nome FROM receituario INNER JOIN praga ON praga.id=receituario.id_praga INNER JOIN cultura ON cultura.id=receituario.id_cultura AND receituario.excluido=false INNER JOIN produto ON produto.id=receituario.id_produto WHERE produto.codigo=$this->codigo GROUP BY receituario.instrucoes,receituario.id_praga,receituario.id_cultura");
        $ps->execute();
        $ps->bind_result($id, $instrucoes, $id_cultura, $nome_cultura, $id_praga, $nome_praga);

        while ($ps->fetch()) {

            $r = new Receituario();
            $r->id = $id;
            $r->instrucoes = $instrucoes;

            $r->produto = $this;

            $c = new Cultura();
            $c->id = $id_cultura;
            $c->nome = $nome_cultura;

            $r->cultura = $c;

            $p = new Praga();
            $p->id = $id_praga;
            $p->nome = $nome_praga;

            $r->praga = $p;

            $receituarios[] = $r;
        }

        $ps->close();

        return $receituarios;
    }

}
