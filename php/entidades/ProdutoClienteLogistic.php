<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CotacaoEntrada
 *
 * @author Renan
 */
class ProdutoClienteLogistic {

    public $id;
    public $nome;
    public $empresas;
    public $estoques;
    public $disponiveis;
    public $transitos;
    public $categoria;

    function __construct() {
        
        $this->id = 0;
        $this->empresas = array();
        $this->estoques = array();
        $this->disponiveis = array();
        $this->transitos = array();
        
    }
    
}
