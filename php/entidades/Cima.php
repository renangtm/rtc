<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cima
 *
 * @author Renan
 */
class Cima extends FuncaoNumerica{
   
    public function interpretar($args) {
     
        return ceil($args[0]);
        
    }
    
    public function getTermo() {
        
        return "CIMA";
        
    }
    
}
