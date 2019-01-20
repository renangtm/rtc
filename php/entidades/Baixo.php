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
class Baixo extends FuncaoNumerica{
    
    public function getTermo() {
        
        return "BAIXO";
        
    }
    
    public function interpretar($args) {
        
        return floor($args[0]);
        
    }
    
}
