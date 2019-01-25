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
class StatusPedidoEntrada {
   
    public $id;
    public $nome;
    public $estoque;
    public $transito;

    function __construct($id,$nome,$estoque,$reserva) {
        
        $this->id = $id;
        $this->nome = $nome;
        $this->estoque = $estoque;
        $this->transito = $reserva;
        
    }
  
    
}
