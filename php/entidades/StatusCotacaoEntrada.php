<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StatusCotacaoEntrada
 *
 * @author Renan
 */
class StatusCotacaoEntrada {
    
    public $id;
    public $nome;
    public $envia_email;
    
    function __construct($id,$nome,$envia_email = true) {
        
        $this->id = $id;
        $this->nome = $nome;
        $this->envia_email = $envia_email;
        
    }
    
}

