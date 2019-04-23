<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProdutoCotacaoEntrada
 *
 * @author Renan
 */
class AnaliseCotacaoEntrada {

    public $id;
    public $nome_produto;
    public $quantidade_produto;
    public $valor;
    public $valor_maximo;
    public $valor_minimo;
    public $data;
    public $ids_produtos;

    function __construct() {

        $this->id = 0;
        $this->nome_produto = "";
        $this->quantidade_produto = 0;
        $this->valor = 0;
        $this->valor_maximo = 0;
        $this->valor_minimo = 0;
        $this->data = round(microtime(true)*1000);
        $this->ids_produtos = array();
    }

}
