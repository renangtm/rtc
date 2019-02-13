<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CotacaoEntrada
 *
 * @author Renan
 */
class RTC {
    
    private static $RTCS = array();
    
    public $numero;
    public $nome;
    public $permissoes;
    
    function __construct($numero = 0,$permissoes = 0) {
        
        self::$RTCS[] = $this;
        
        if($numero === 0 && $permissoes === 0){
            
            return;
            
        }
        
        $this->numero = $numero;
        $this->nome = "RTC v$numero";
        $this->permissoes = $permissoes;
        
        if($permissoes === "ALL"){
            
            $this->permissoes = Sistema::getPermissoes();
            
        }
        
        foreach(self::$RTCS as $key=>$rtc){
            if($rtc === $this)continue;
            if($rtc->numero>$this->numero){
                foreach($this->permissoes as $key2=>$permissao){
                    $rtc->permissoes[] = $permissao;
                }
            }else{
                foreach($this->rtc as $key2=>$permissao){
                    $this->permissoes[] = $permissao;
                }
            }
        }
        
    }
}
