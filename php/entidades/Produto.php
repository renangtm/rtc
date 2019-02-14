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
class Produto {

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
    public $lucro_consignado;
    public $custo;
    public $ncm;
    public $peso_liquido;
    public $peso_bruto;
    public $estoque;
    public $ativo;
    public $concentracao;
    public $disponivel;
    public $transito;
    public $ofertas;
    public $grade;
    public $imagem;
    public $fabricante;
    public $classe_risco;
    public $logistica;
    public $sistema_lotes;
    public $nota_usuario;
    
    function __construct() {

        $this->id = 0;
        $this->id_universal = 0;
        $this->categoria = null;
        $this->liquido = false;
        $this->quantidade_unidade = 0;
        $this->excluido = false;
        $this->habilitado = true;
        $this->empresa = null;
        $this->valor_base = 0;
        $this->custo = 0;
        $this->peso_bruto = 0;
        $this->lucro_consignado = 0;
        $this->peso_liquido = 0;
        $this->estoque = 0;
        $this->disponivel = 0;
        $this->transito = 0;
        $this->grade = null;
        $this->ofertas = array();
        $this->classe_risco = 0;
        $this->ativo = "";
        $this->concentracao = "";
        $this->logistica = null;
        $this->sistema_lotes = true;
        $this->nota_usuario = 5;
        
    }

    public function merge($con) {

        if ($this->id == 0) {
            $ps = $con->getConexao()->prepare("INSERT INTO produto(id_universal,nome,id_categoria,liquido,quantidade_unidade,excluido,habilitado,id_empresa,valor_base,custo,peso_bruto,peso_liquido,estoque,disponivel,transito,grade,unidade,ncm,lucro_consignado,ativo,concentracao,classe_risco,fabricante,imagem,id_logistica,sistema_lotes,nota_usuario) VALUES($this->id_universal,'" . addslashes($this->nome) . "'," . $this->categoria->id . "," . ($this->liquido ? "true" : "false") . ",$this->quantidade_unidade,false," . ($this->habilitado ? "true" : "false") . "," . $this->empresa->id . ",$this->valor_base,$this->custo,$this->peso_bruto,$this->peso_liquido,$this->estoque,$this->disponivel,$this->transito,'" . $this->grade->str . "','" . addslashes($this->unidade) . "','" . addslashes($this->ncm) . "',$this->lucro_consignado,'$this->ativo','$this->concentracao',$this->classe_risco,'$this->fabricante','$this->imagem'," . ($this->logistica !== null ? $this->logistica->id : 0) . ",".($this->sistema_lotes?"true":"false").",$this->nota_usuario)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE produto SET nome = '" . addslashes($this->nome) . "', id_universal=$this->id_universal, id_categoria=" . $this->categoria->id . ",liquido=" . ($this->liquido ? "true" : "false") . ", id_empresa=" . $this->empresa->id . ", valor_base=" . $this->valor_base . ",custo=$this->custo,peso_bruto=$this->peso_bruto,peso_liquido=$this->peso_liquido,estoque=$this->estoque,disponivel=$this->disponivel,transito=$this->transito,excluido=false,habilitado=" . ($this->habilitado ? "true" : "false") . ",grade='" . $this->grade->str . "',unidade='" . addslashes($this->unidade) . "',ncm='" . addslashes($this->ncm) . "',quantidade_unidade=$this->quantidade_unidade,lucro_consignado=$this->lucro_consignado, ativo='$this->ativo', concentracao='$this->concentracao',classe_risco=$this->classe_risco,fabricante='$this->fabricante',imagem='$this->imagem', id_logistica=" . ($this->logistica !== null ? $this->logistica->id : 0) . ",sistema_lotes=".($this->sistema_lotes?"true":"false").",nota_usuario=$this->nota_usuario WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();
        }
    }

    public function atualizarEstoque($con) {

        $ps = $con->getConexao()->prepare("SELECT estoque,disponivel,transito FROM produto WHERE id = $this->id");
        $ps->execute();
        $ps->bind_result($estoque, $disponivel, $transito);

        if ($ps->fetch()) {

            $this->estoque = $estoque;
            $this->disponivel = $disponivel;
            $this->transito = $transito;
        }

        $ps->close();
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE produto SET excluido = true WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

    public function getLotes($con, $filtro = null, $ordem = null) {

        $sql = "SELECT lote.id,lote.numero,lote.rua,lote.altura, UNIX_TIMESTAMP(lote.validade)*1000, UNIX_TIMESTAMP(lote.data_entrada)*1000, lote.quantidade_inicial, lote.grade, lote.quantidade_real, lote.codigo_fabricante, retirada.retirada FROM lote LEFT JOIN retirada ON lote.id=retirada.id_lote WHERE lote.excluido=false AND lote.id_produto=$this->id";
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

        $ps = $con->getConexao()->prepare("SELECT receituario.id, receituario.instrucoes, cultura.id, cultura.nome, praga.id, praga.nome FROM receituario INNER JOIN praga ON praga.id=receituario.id_praga INNER JOIN cultura ON cultura.id=receituario.id_cultura AND receituario.excluido=false AND id_produto=$this->id");
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
