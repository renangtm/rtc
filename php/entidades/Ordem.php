<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ordem
 *
 * @author T-Gamer
 */
class Ordem {

    public $id;
    public $nome;
    public $asc;
    public $atributo;

    public function compare($obj1, $obj2) {

        $att1 = Utilidades::getAttr($obj1, $this->atributo);
        $att2 = Utilidades::getAttr($obj2, $this->atributo);

        if (is_array($att1)) {

            if (count($att1) > count($att2)) {

                return 1 * ($this->asc ? -1 : 1);
            } else {

                return -1 * ($this->asc ? -1 : 1);
            }
        } else if (is_numeric($att1)) {

            if ($att1 > $att2) {

                return 1 * ($this->asc ? -1 : 1);
            } else {

                return -1 * ($this->asc ? -1 : 1);
            }

            return 0;
        } else {

            return strcmp(strtoupper($att1 . ""), strtoupper($att2 . "")) * ($this->asc ? -1 : 1);
        }
    }

    function __construct($id, $nome, $atributo) {

        $this->id = $id;
        $this->nome = $nome;
        $this->asc = false;
        $this->atributo = $atributo;
    }

    public function ordenar($lista) {

        usort($lista, array($this, "compare"));

        return $lista;
    }

}
