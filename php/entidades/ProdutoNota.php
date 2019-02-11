<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProdutoCotacaoEntrada
 *
 * @author Renan
 */
class ProdutoNota {

    public $id;
    public $produto;
    public $quantidade;
    public $nota;
    public $valor_total;
    public $cfop;
    public $valor_unitario;
    public $base_calculo;
    public $icms;
    public $ipi;
    public $influencia_estoque;
    public $informacao_adicional;

    function __construct() {

        $this->id = 0;
        $this->produto = null;
        $this->nota = null;
        $this->icms = 0;
        $this->ipi = 0;
        $this->valor_total = 0;
        $this->quantidade = 0;
        $this->base_calculo = 0;
        $this->valor_unitario = 0;
        $this->influencia_estoque = 0;
    }

    public function merge($con) {

        $ps = $con->getConexao()->prepare("SELECT estoque, disponivel FROM produto WHERE id=" . $this->produto->id);
        $ps->execute();
        $ps->bind_result($estoque, $disponivel);
        if ($ps->fetch()) {
            $this->produto->estoque = $estoque;
            $this->produto->disponivel = $disponivel;
        }
        $ps->close();

        $x_res = ($this->nota->interferir_estoque && !$this->nota->cancelada && $this->nota->emitida) ? ($this->nota->saida ? $this->quantidade * -1 : $this->quantidade) : 0;
        $dif_res = $x_res - $this->influencia_estoque;

        if ($this->produto->disponivel + $dif_res < 0) {

            throw new Exception('Sem estoque disponivel para executar essa operacao '.$this->produto->disponivel."--".$dif_res);
        }

        if ($this->produto->estoque + $dif_res < 0) {

            throw new Exception('Sem estoque para executar essa operacao');
        }

        $this->produto->estoque += $dif_res;
        $this->produto->disponivel += $dif_res;
        $this->produto->merge($con);

        $this->influencia_estoque = $x_res;



        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO produto_nota(id_produto,id_nota,quantidade,valor_unitario,valor_total,influencia_estoque,ipi,icms,base_calculo,cfop,informacao_adicional) VALUES(" . $this->produto->id . "," . $this->nota->id . ",$this->quantidade,$this->valor_unitario,$this->valor_total,$this->influencia_estoque,$this->ipi,$this->icms,$this->base_calculo,'$this->cfop','$this->informacao_adicional')");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE produto_nota SET id_produto=" . $this->produto->id . ",id_nota=" . $this->nota->id . ",quantidade=$this->quantidade,valor_unitario=$this->valor_unitario,valor_total=$this->valor_total,influencia_estoque=$this->influencia_estoque,ipi=$this->ipi,icms=$this->icms,base_calculo=$this->base_calculo,cfop='$this->cfop', informacao_adicional='$this->informacao_adicional' WHERE id=$this->id");
            $ps->execute();
            $ps->close();
        }
    }

    public function delete($con) {

        $dif_res = - $this->influencia_estoque;

        if ($this->produto->disponivel + $dif_res < 0) {

            throw new Exception('Sem estoque disponivel para executar essa operacao');
        }

        if ($this->produto->estoque + $dif_res < 0) {

            throw new Exception('Sem estoque para executar essa operacao');
        }

        $this->produto->estoque += $dif_res;
        $this->produto->disponivel += $dif_res;
        $this->produto->merge($con);

        $this->influencia_estoque = 0;


        $ps = $con->getConexao()->prepare("DELETE FROM produto_nota WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
