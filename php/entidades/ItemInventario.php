<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Item
 *
 * @author Renan
 */
class ItemInventario {

    public $id;
    public $data;
    public $produto;
    public $valor_medio;
    public $quantidade;
    public $icms_recuperavel;
    public $empresa;

    function __construct() {

        $this->id = 0;
        $this->data = round(microtime(true) * 1000);
        $this->produto = null;
        $this->valor_medio = 0;
        $this->quantidade = 0;
        $this->icms_recuperavel = 0;
        $this->empresa = null;
    }

    public function getTotal() {

        return $this->quantidade * $this->valor_medio;
    }

    public function getTotalLiquido() {

        return $this->getTotal() - $this->icms_recuperavel;
    }

    public function merge($con) {

        if ($this->id === 0) {
            
            $ps = $con->getConexao()->prepare("INSERT INTO inventario(id_empresa,data,id_produto,valor_medio,quantidade,icms_recuperado,total,total_liquido) VALUES(" . $this->empresa->id . ",FROM_UNIXTIME($this->data/1000)," . $this->produto->id . ",ROUND($this->valor_medio,2),$this->quantidade,ROUND($this->icms_recuperavel,2),ROUND(" . $this->getTotal() . ",2),ROUND(" . $this->getTotalLiquido() . ",2))");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        } else {
            
            $ps = $con->getConexao()->prepare("UPDATE inventario SET id_empresa=" . $this->empresa->id . ",data=FROM_UNIXTIME($this->data/1000),id_produto=" . $this->produto->id . ",valor_medio=ROUND($this->valor_medio,2),quantidade=$this->quantidade,icms_recuperavel=ROUND($this->icms_recuperavel,2),total=ROUND(" . $this->getTotal() . ",2),total_liquido=ROUND(" . $this->getTotalLiquido() . ",2) WHERE id=$this->id");
            $ps->execute();
            $ps->close();
            
        }
    }

}
