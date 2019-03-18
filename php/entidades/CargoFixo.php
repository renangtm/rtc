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
class CargoFixo extends Cargo {

    public $id;
    public $nome;
    public $empresa;

    function __construct($id = 0, $nome = "", $empresa = null) {

        $this->id = $id*-1;
        $this->nome = $nome;
        $this->empresa = $empresa;
    }

    public function merge($con) {
        
    }

    public function delete($con) {
        
    }

}
