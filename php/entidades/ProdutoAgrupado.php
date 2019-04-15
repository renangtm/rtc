<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cidade
 *
 * @author Renan
 */
class ProdutoAgrupado {
   
    public $id;
    public $nome;
    public $categoria;
    public $ativo;
    public $unidade;
    public $fabricante;
    public $imagem;
    public $valor_base;
    public $empresa;
    public $produtos;
    public $disponivel;
    public $transito;
    public $estoque;
    public $grade;
    public $ofertas;
    
    function __construct() {
        
        $this->id = 0;
        $this->nome = "";
        $this->categoria = null;
        $this->ativo = "";
        $this->fabricante = "";
        $this->unidade = "";
        $this->valor_base = 0;
        $this->empresa = "";
        $this->produtos = array();
        $this->disponivel = 0;
        $this->transito = 0;
        $this->estoque = 0;
        $this->imagem = "";
        $this->grade = "";
        $this->ofertas = 0;
        
    }
    
}
