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
class StatusPedidoSaida {
   
    public $id;
    public $nome;
    public $estoque;
    public $reserva;
    public $emailCliente;
    public $emailInterno;
    
    function __construct($id,$nome,$estoque,$reserva,$emailCliente = false,$emailInterno = false) {
        
        $this->id = $id;
        $this->nome = $nome;
        $this->estoque = $estoque;
        $this->reserva = $reserva;
        $this->emailCliente = $emailCliente;
        $this->emailInterno = $emailInterno;
        
    }
  
    
}
