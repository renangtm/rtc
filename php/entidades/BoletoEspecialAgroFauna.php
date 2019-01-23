<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Boleto
 *
 * @author T-Gamer
 */
class BoletoEspecialAgroFauna extends FormaPagamento{
    
    function __construct() {
        
        $this->id = 2;
        $this->nome = "Boleto Agro Fauna";
        
    }
    
    public function aoFinalizarPedido($pedido){
        
        
    }
    
    public function habilitada($pedido){
        
        return strpos($pedido->empresa->nome, 'Agro') !== false && strpos($pedido->empresa->nome, 'Fauna') !== false;
        
    }
    
}
