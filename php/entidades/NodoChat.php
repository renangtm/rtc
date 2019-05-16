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
class NodoChat {
    
    public static $FALA_CHAT = 1;
    public static $CAPTURA_USUARIO = 0;
    
    public $id;
    public $tipo;
    public $expressao;
    public $id_empresa;
    public $filhos;
    public $pai;
    
    public function __construct() {
        $this->id = 0;
        $this->tipo = 0;
        $this->expressao = "";
        $this->filhos = array();
        $this->id_empresa = 0;
        $this->pai = null;
    }
    
}
