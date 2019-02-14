<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cidade
 *
 * @author Renan
 */
class CategoriaProduto {

    public $id;
    public $nome;
    public $excluida;
    public $base_calculo;
    public $ipi;
    public $icms_normal;
    public $icms;
    function __construct() {

        $this->id = 0;
        $this->excluida = false;
        $this->base_calculo = 40;
        $this->ipi = 0;
        $this->icms_normal = true;
        $this->icms = 7;
        
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO categoria_produto(nome,excluida,base_calculo,ipi,icms_normal,icms) VALUES('" . addslashes($this->nome) . "',false,$this->base_calculo,$this->ipi," . ($this->icms_normal ? "true" : "false") . ",$this->icms)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE categoria_produto SET nome = '" . addslashes($this->nome) . "', excluida=false, ipi=$this->ipi, base_calculo=$this->base_calculo, icms = $this->icms, icms_normal=" . ($this->icms_normal ? "true" : "false") . " WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE categoria_produto SET excluida = true WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
