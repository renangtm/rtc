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

    public static $RTCS = array();
    public $numero;
    public $nome;
    public $permissoes;

    function __construct($numero = 0, $permissoes = 0) {

        self::$RTCS[] = $this;

        if ($numero === 0 && $permissoes === 0) {

            $this->permissoes = array();
            return;
            
        }

        $this->numero = $numero;
        $this->nome = "RTC m$numero";
        $this->permissoes = $permissoes;

        if ($permissoes === "ALL") {

            $this->permissoes = Utilidades::copy(Sistema::getPermissoes());
            
        } else{

            foreach (self::$RTCS as $key => $rtc) {
                if ($rtc === $this)
                    continue;  
                if ($rtc->numero > $this->numero) {
                    foreach ($this->permissoes as $key2 => $permissao) {
                        if($permissao->clonada===true)continue;
                        $p = Utilidades::copy($permissao);
                        $p->clonada = true;
                        $rtc->permissoes[] = $p;
                    }
                } else {
                    foreach ($rtc->permissoes as $key2 => $permissao) {
                        if($permissao->clonada===true)continue;
                        $p = Utilidades::copy($permissao);
                        $p->clonada = true;
                        $this->permissoes[] = $p;
                    }
                }
            }
        }
        
        
    }

}
