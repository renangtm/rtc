<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Permissao
 *
 * @author Renan
 */
class Permissao {

    public $id;
    public $nome;
    public $in;
    public $del;
    public $alt;
    public $cons;
    public $clonada;

    function __construct($id = 0, $nome = "", $in = false, $del = false, $alt = false, $cons = false) {

        $this->id = $id;
        $this->nome = $nome;
        $this->in = $in;
        $this->del = $del;
        $this->alt = $alt;
        $this->cons = $cons;
        $this->clonada = false;
    }

    public function m($str) {

        $this->in = false;
        $this->del = false;
        $this->alt = false;
        $this->cons = false;

        $v = explode(',', $str);

        foreach ($v as $key => $value) {
            if ($value === "I") {
                $this->in = true;
            } else if ($value === "D") {
                $this->del = true;
            } else if ($value === "A") {
                $this->alt = true;
            } else if ($value === "C") {
                $this->cons = true;
            }
        }
        
        return $this;
        
    }

}
