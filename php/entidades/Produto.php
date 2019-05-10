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
    public $codigo;
    public $mais_fotos;

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
        $this->estoque = 0;
        $this->disponivel = 0;
        $this->transito = 0;
        $this->grade = new Grade("1");
        $this->ofertas = array();
        $this->classe_risco = 0;
        $this->ativo = "";
        $this->concentracao = "";
        $this->logistica = null;
        $this->sistema_lotes = true;
        $this->nota_usuario = 5;
        $this->ncm = "000000";
        $this->unidade = "Ob";
        $this->codigo = 0;
        $this->mais_fotos = array();
    }

    public function setMaisFotos($con, $fotos) {

        $ps = $con->getConexao()->prepare("DELETE FROM mais_fotos_produto WHERE id_produto=$this->id");
        $ps->execute();
        $ps->close();

        foreach ($fotos as $key => $value) {

            $ps = $con->getConexao()->prepare("INSERT INTO mais_fotos_produto(id_produto,imagem) VALUES($this->id,'$value')");
            $ps->execute();
            $ps->close();
        }
    }

    public function getReduzido() {

        $p = new ProdutoReduzido();
        $p->id = $this->id;
        $p->codigo = $this->codigo;
        $p->nome = $this->nome;
        $p->imagem = $this->imagem;

        return $p;
    }

    public function merge($con, $verifica = true) {

        if ($this->id_universal === 0) {

            $ps = $con->getConexao()->prepare("SELECT MAX(id_universal) FROM produto");
            $ps->execute();
            $ps->bind_result($idn);

            if ($ps->fetch()) {

                $this->id_universal = $idn;
            }

            $ps->close();
        }

        if ($this->codigo === 0) {

            $ps = $con->getConexao()->prepare("SELECT IFNULL(MAX(codigo)+1,0) FROM produto WHERE id_empresa=" . $this->empresa->id);
            $ps->execute();
            $ps->bind_result($idn);

            if ($ps->fetch()) {

                $this->codigo = $idn;
            }

            $ps->close();
        }

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO produto(id_universal,nome,id_categoria,liquido,quantidade_unidade,excluido,habilitado,id_empresa,valor_base,custo,peso_bruto,peso_liquido,estoque,disponivel,transito,grade,unidade,ncm,lucro_consignado,ativo,concentracao,classe_risco,fabricante,imagem,id_logistica,sistema_lotes,nota_usuario,codigo) VALUES($this->id_universal,'" . addslashes($this->nome) . "'," . $this->categoria->id . "," . ($this->liquido ? "true" : "false") . ",$this->quantidade_unidade,false," . ($this->habilitado ? "true" : "false") . "," . $this->empresa->id . ",$this->valor_base,$this->custo,$this->peso_bruto,$this->peso_liquido,$this->estoque,$this->disponivel,$this->transito,'" . $this->grade->str . "','" . addslashes($this->unidade) . "','" . addslashes($this->ncm) . "',$this->lucro_consignado,'$this->ativo','$this->concentracao','$this->classe_risco','$this->fabricante','$this->imagem'," . ($this->logistica !== null ? $this->logistica->id : 0) . "," . ($this->sistema_lotes ? "true" : "false") . ",$this->nota_usuario,$this->codigo)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            if ($this->sistema_lotes) {
                $ps = $con->getConexao()->prepare("SELECT SUM(quantidade_real) FROM lote WHERE id_produto=$this->id");
                $ps->execute();
                $ps->bind_result($quantidade);
                if ($ps->fetch()) {
                    $ps->close();
                    if ($this->disponivel < $quantidade) {
                        throw new Exception("Estoque invalido, nao pode ser menor que a quantidade de lotes cadastrada $quantidade");
                    }
                } else {
                    $ps->close();
                }
            }
            if ($verifica) {
                $ps = $con->getConexao()->prepare("SELECT SUM(influencia_reserva)-SUM(influencia_estoque) FROM produto_pedido_saida WHERE id_produto=$this->id");
                $ps->execute();
                $ps->bind_result($d);
                if ($ps->fetch()) {
                    $ps->close();
                    if ($this->disponivel !== $this->estoque + $d) {
                        throw new Exception("Existem " . (-1 * $d) . " produtos reservados, portanto o estoque($this->estoque) e disponivel($this->disponivel) nao batem");
                    }
                } else {
                    $ps->close();
                }
            }

            if ($this->estoque < $this->disponivel) {
                throw new Exception("O estoque nao pode ser menor que o disponivel");
            }

            $ps = $con->getConexao()->prepare("UPDATE produto SET nome = '" . addslashes($this->nome) . "', id_universal=$this->id_universal, id_categoria=" . $this->categoria->id . ",liquido=" . ($this->liquido ? "true" : "false") . ", valor_base=" . $this->valor_base . ",custo=$this->custo,peso_bruto=$this->peso_bruto,peso_liquido=$this->peso_liquido,grade='" . $this->grade->str . "',unidade='" . addslashes($this->unidade) . "',ncm='" . addslashes($this->ncm) . "',quantidade_unidade=$this->quantidade_unidade,lucro_consignado=$this->lucro_consignado, ativo='$this->ativo', concentracao='$this->concentracao',classe_risco='$this->classe_risco',fabricante='$this->fabricante',imagem='$this->imagem',sistema_lotes=" . ($this->sistema_lotes ? "true" : "false") . ",nota_usuario=$this->nota_usuario, codigo=$this->codigo WHERE codigo = " . $this->codigo . " AND id_empresa=" . $this->empresa->id);
            $ps->execute();
            $ps->close();

            $ps = $con->getConexao()->prepare("UPDATE produto SET id_empresa=" . $this->empresa->id . ",estoque=" . $this->estoque . ",disponivel=" . $this->disponivel . ",transito=" . $this->transito . ",habilitado=" . ($this->habilitado ? "true" : "false") . ",id_logistica=" . ($this->logistica === null ? "0" : $this->logistica->id) . " WHERE id=$this->id");
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
