<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegraTabela
 *
 * @author Renan
 */
class NodoOrganograma {
    
    public $id;
    public $pai;
    public $id_usuario;
    public $nome_usuario;
    public $filhos;

    public function __construct() {
        $this->id = 0;
        $this->id_usuario = 0;
        $this->nome_usuario = "";
        $this->filhos = array();
        $this->pai = null;
    }
    
}
