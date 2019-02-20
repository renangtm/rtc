<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Baixo
 *
 * @author Renan
 */
class Log{
    
    public $id;
    public $obs;
    public $usuario;
    public $momento;
    public $notificados;
    
    function __construct() {
        $this->usuario = "";
    }
    
    public function toHtml(){
        
        return Sistema::getHtml('log', $this);
        
    }
    
}
