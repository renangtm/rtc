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
class ProdutoPedidoReserva {

    public $id;
    public $produto;
    public $quantidade;
    public $valor_base;
    public $juros;
    public $icms;
    public $base_calculo;
    public $frete;
    public $pedido;
    public $ipi;

    function __construct() {

        $this->id = 0;
        $this->produto = null;
        $this->quantidade = 0;
        $this->icms = 0;
        $this->ipi = 0;
        $this->frete = 0;
        $this->base_calculo = 0;
        $this->juros = 0;
        $this->pedido = null;

        
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO produto_pedido_reserva(id_produto,quantidade,valor_base,juros,icms,base_calculo,frete,id_pedido,ipi) VALUES(" . $this->produto->id . "," . $this->quantidade . ",$this->valor_base,$this->juros,$this->icms,$this->base_calculo,$this->frete," . $this->pedido->id . ",$this->ipi)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE produto_pedido_reserva SET id_produto = " . $this->produto->id . ", quantidade=$this->quantidade,valor_base=$this->valor_base,juros=$this->juros,icms=$this->icms,base_calculo=$this->base_calculo,frete=$this->frete, id_pedido=" . $this->pedido->id . ", ipi=$this->ipi WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();
        }

    }

    public function atualizarCustos() {


        if ($this->pedido->cliente !== null) {
            $con = new ConnectionFactory();
            $pe = $this->pedido->cliente->getPrecoEspecial($con);
            if ($pe > 0) {
                $this->valor_base = round($this->produto->custo / $pe, 2);
            }
        }

        $cat = $this->produto->categoria;

        $emp = $this->pedido->empresa;

        if ($this->pedido->logistica !== null) {

            $emp = $this->pedido->logistica;
        }

        $juros_mes = 1 + $this->pedido->empresa->juros_mensal / 100;

        $juros_dia = pow($juros_mes, 1 / 30);

        $periodo = $this->pedido->prazo/$this->pedido->parcelas;

        $this->juros = round($this->valor_base * (((pow($juros_dia, $periodo)-1)/2)*($this->pedido->parcelas+1)), 2);

        if ($this->pedido->cliente != null) {

            $this->base_calculo = ($cat->base_calculo / 100) * ($this->valor_base + $this->juros);

            $icms = Sistema::getIcmsEstado($this->pedido->cliente->endereco->cidade->estado);

            if ($emp->endereco->cidade->estado->id == $this->pedido->cliente->endereco->cidade->estado->id || $this->pedido->cliente->suframado) {

                $this->icms = 0;
            } else {

                $base = ($cat->base_calculo / 100) * ($icms / 100);

                if (!$this->produto->categoria->icms_normal) {

                    $base = ($cat->base_calculo / 100) * ($this->produto->categoria->icms / 100);
                }

                $base = (1 - $base);
                $icms = round(($this->valor_base + $this->juros) / $base, 2);
                $icms = $icms - $this->valor_base - $this->juros;

                $this->icms = $icms;
            }
        }

        $this->ipi = ($this->valor_base + $this->juros + $this->icms) * ($this->produto->categoria->ipi / 100);

        if ($this->pedido->frete_incluso) {

            $total = 0;

            foreach ($this->pedido->produtos as $produto) {

                $total += $produto->valor_base * $produto->quantidade;
            }

            if ($total > 0) {

                $perc = ($this->valor_base * $this->quantidade) / $total;

                $this->frete = round((($this->pedido->frete * $perc) / $this->quantidade), 2);
            }
        } else {

            $this->frete = 0;
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("DELETE FROM produto_pedido_reserva WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();

    }

}
