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
class CampanhaReduzida {

    public $id;
    public $inicio;
    public $fim;
    public $prazo;
    public $parcelas;
    public $excluida;
    public $cliente_expression;
    public $empresa;
    public $produtos;
    public $nome;

    function __construct() {

        $this->id = 0;
        $this->inicio = round(microtime(true) * 1000);
        $this->fim = round(microtime(true) * 1000);
        $this->excluida = false;
        $this->empresa = null;
        $this->cliente_expression = "*";
        $this->prazo = 0;
        $this->parcelas = 0;
    }

}
