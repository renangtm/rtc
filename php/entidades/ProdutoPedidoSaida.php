<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Fornecedor
 *
 * @author Renan
 */
class ProdutoPedidoSaida {

    public $id;
    public $produto;
    public $quantidade;
    public $validade_minima;
    public $valor_base;
    public $juros;
    public $icms;
    public $base_calculo;
    public $frete;
    public $pedido;
    public $retiradas;
    public $influencia_estoque;
    public $influencia_reserva;

    function __construct() {

        $this->id = 0;
        $this->produto = null;
        $this->quantidade = "";
        $this->validade_minima = round(microtime(true) * 1000);
        $this->pedido = null;
        $this->influencia_estoque = 0;
        $this->influencia_reserva = 0;
        $this->retiradas = array();
    }

    public function merge($con) {

        // -------- atualizando produto ------------

        $ps = $con->getConexao()->prepare("SELECT estoque, disponivel FROM produto WHERE id=" . $this->produto->id);
        $ps->execute();
        $ps->bind_result($estoque, $disponivel);
        if ($ps->fetch()) {
            $this->produto->estoque = $estoque;
            $this->produto->disponivel = $disponivel;
        }
        $ps->close();

        //------------------------------------------

        $status_pedido = $this->pedido->status;

        $x_est = ($status_pedido->estoque ? -1 : 0) * $this->quantidade;
        $dif_est = $x_est - $this->influencia_estoque;

        $x_res = ($status_pedido->reserva ? -1 : 0) * $this->quantidade;
        $dif_res = $x_res - $this->influencia_reserva;

        if ($produto->disponivel < $dif_res) {

            throw new Exception('Sem estoque disponivel para executar essa operacao');
        }

        if ($produto->estoque < $dif_est) {

            throw new Exception('Sem estoque para executar essa operacao');
        }

        $produto->estoque -= $dif_est;
        $produto->disponivel -= $dif_res;
        $produto->merge($con);

        $this->influencia_estoque = $x_est;
        $this->influencia_reserva = $x_res;

        if (($status_pedido->reserva || $status_pedido->estoque) && ($dif_res != 0 || $dif_est != 0)) {
            
        }

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO produto_pedido_saida(id_produto,quantidade,validade_minima,valor_base,juros,icms,base_calculo,frete,id_pedido,influencia_estoque,influencia_reserva) VALUES(" . $this->produto->id . "," . $this->quantidade . ",FROM_UNIXTIME($this->validade_minima/1000),$this->valor_base,$this->juros,$this->icms,$this->base_calculo,$this->frete," . $this->pedido->id . ",$this->influencia_estoque,$this->influencia_reserva)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE produto_pedido_saida SET id_produto = " . $this->produto->id . ", quantidade=$this->quantidade, validade_minima=FROM_UNIXTIME($this->validade_minima/1000),valor_base=$this->valor_base,juros=$this->juros,icms=$this->icms,base_calculo=$this->base_calculo,frete=$this->frete, id_pedido=" . $this->pedido->id . ", influencia_estoque=$this->influencia_estoque, influencia_reserva = $this->influencia_reserva WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();
        }
    }

    public function atualizarCustos() {

        $cat = $this->produto->categoria;

        $emp = $this->pedido->empresa;

        $juros_mes = 1 + $emp->juros_mes / 100;

        $juros_dia = pow($juros_mes, 1 / 30);

        $this->juros = round($this->valor_base * pow($juros_dia, $this->pedido->prazo), 2);

        if ($this->pedido->cliente != null) {

            $icms = Sistema::getIcmsEstado($this->pedido->cliente->endereco->cidade->estado);

            $base = ($cat->base_calculo / 100) * ($icms / 100);

            $fat = 1 + $base;

            $this->icms = round(($this->valor_base + $this->juros) * $fat, 2);
        }

        if ($this->pedido->incluir_frete) {

            $total = 0;

            foreach ($this->pedido->produtos as $produto) {

                $total += $produto->valor_base * $produto->quantidade;
            }

            $perc = ($this->valor_base * $this->quantidade) / $total;

            $this->frete = round((($this->pedido->frete * $perc) / $this->quantidade), 2);
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("DELETE FROM produto_pedido_saida WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
