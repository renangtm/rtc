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
class CategoriaProduto {

    public $id;
    public $nome;
    public $excluida;
    public $base_calculo;
    public $ipi;
    public $icms_normal;
    public $desconta_estoque;
    public $parametros_agricolas;
    public $icms;
    public $loja;
    public $abstrato;
    
    function __construct() {

        $this->id = 0;
        $this->excluida = false;
        $this->base_calculo = 40;
        $this->ipi = 0;
        $this->icms_normal = true;
        $this->icms = 7;
        $this->desconta_estoque = true;
        $this->parametros_agricolas = false;
        $this->loja = false;
        $this->abstrato = false;
        
    }

}
