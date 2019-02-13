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
    public $envia_email;
    
    function __construct($id=0,$nome="",$estoque=false,$reserva=false,$envia_email=false) {
        
        $this->id = $id;
        $this->nome = $nome;
        $this->estoque = $estoque;
        $this->transito = $reserva;
        $this->envia_email = $envia_email;
        
    }
  
    
}
