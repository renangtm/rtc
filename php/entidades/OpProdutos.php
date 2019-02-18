<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OpProdutos
 *
 * @author T-Gamer
 */
class OpProdutos {

    private $lista;

    function __construct($lista) {

        $this->lista = $lista;
    }

    public function getOrdensPossiveis() {

        return array(
            new Ordem(1, "Nome", "nome"),
            new Ordem(2, "Valor", "valor_base")
        );
    }

    public function getFiltrosPossiveis() {

        $filtro_nome_principio = new FiltroTextual(1, "Nome ou Ativo", array("nome","ativo"));

        $filtro_categoria = new FiltroOpcional(2, "Categoria", "categoria.nome");

        foreach ($this->lista as $key => $produto) {

            $c = $produto->categoria;

            if (($op = $filtro_categoria->getOpcao($c->id)) !== null) {
                $op->quantidade++;
                continue;
            }

            $filtro_categoria->opcoes[] = new OpcaoEquals($c->id, $c->nome);
        }

        $filtro_valor = new FiltroOpcional(3, "Valor", "valor_base");

        $intervalo = 50; //reais;

        foreach ($this->lista as $key => $produto) {

            $i = 0;
            $f = $intervalo;
            $j = 2;
            for (; $produto->valor_base > $f; $i = $f, $f *= 2, $j++)
                ;

            if (($op = $filtro_valor->getOpcao($j)) !== null) {
                $op->quantidade++;
                continue;
            }

            $filtro_valor->opcoes[] = new OpcaoEntre($j, $i, $f);
        }

        $filtro_ativo = new FiltroOpcional(4, "Principio Ativo", "ativo");


        foreach ($this->lista as $key => $produto) {

            $a = $produto->ativo;

            foreach ($filtro_ativo->opcoes as $key => $op) {
                if ($op->nome === $a) {
                    $op->quantidade++;
                    continue 2;
                }
            }

            $filtro_ativo->opcoes[] = new OpcaoEquals(crc32($a), $a);
        }

        $filtro_embalagem = new FiltroOpcional(5, "Embalagem", "unidade");

        foreach ($this->lista as $key => $produto) {

            $a = $produto->unidade;

            foreach ($filtro_embalagem->opcoes as $key => $op) {
                if ($op->nome === $a) {
                    $op->quantidade++;
                    continue 2;
                }
            }

            $filtro_embalagem->opcoes[] = new OpcaoEquals(crc32($a), $a);
        }

        $filtro_fabricante = new FiltroOpcional(6, "Fabricante", "fabricante");

        foreach ($this->lista as $key => $produto) {

            $a = $produto->fabricante;

            foreach ($filtro_fabricante->opcoes as $key => $op) {
                if ($op->nome === $a) {
                    $op->quantidade++;
                    continue 2;
                }
            }

            $filtro_fabricante->opcoes[] = new OpcaoEquals(crc32($a), $a);
        }

        return array(
            $filtro_nome_principio,
            $filtro_categoria,
            $filtro_embalagem,
            $filtro_valor,
            $filtro_fabricante,
            $filtro_ativo);
    }
    
    private $last_qtd = 0;
    
    public function getLastQtd(){
        
        return $this->last_qtd;
        
    }

    public function filtrar($x1, $x2, $filtros = null, $ordem = null) {

        $k = array();
        
        foreach($this->lista as $key=>$value){
            if($value->disponivel > 0){
                $k[] = $value;
            }
        }
        
        $this->lista = $k;
        
        if ($filtros !== null) {
            $k = array();
            foreach ($this->lista as $keyl => $produto) {
                $a = true;
                foreach ($filtros as $key => $value) {
                    if (!$value->ok($produto)) {
                        $a = false;
                        break;
                    }
                }
                if ($a) {
                    $k[] = $produto;
                }
            }
            $this->lista = $k;
        }
        
        $odr = new Ordem(1,"","ofertas");
        $odr->asc = true;
        $this->lista = $odr->ordenar($this->lista);

        if ($ordem !== null) {
            $this->lista = $ordem->ordenar($this->lista);
        }

        $ret = array();
        
        $this->last_qtd = count($this->lista);

        $x1 = min($x1, count($this->lista));
        $x2 = min($x2, count($this->lista));

        for ($i = $x1; $i < $x2; $i++) {

            $ret[] = $this->lista[$i];
        }

        return $ret;
    }

}
