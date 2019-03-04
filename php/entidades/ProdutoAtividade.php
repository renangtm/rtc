<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Atividade
 *
 * @author Renan
 */
class ProdutoAtividade {

    public $id;
    public $nome;
    public $relevancia;
    
    public function __construct() {
        
        $this->id = 0;
        $this->nome = "";
        $this->relevancia = 0;
        
    }
    
}
