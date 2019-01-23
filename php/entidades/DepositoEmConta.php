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
class DepositoEmConta extends FormaPagamento{
    
    function __construct() {
        
        $this->id = 1;
        $this->nome = "Deposito em conta";
        
    }
    
}
