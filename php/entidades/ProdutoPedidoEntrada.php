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
class ProdutoPedidoEntrada {

    public $id;
    public $produto;
    public $quantidade;
    public $valor;
    public $pedido;
    public $influencia_estoque;
    public $influencia_transito;

    function __construct() {

        $this->id = 0;
        $this->produto = null;
        $this->quantidade = 0;
        $this->valor = 0;
        $this->pedido = null;
        $this->influencia_estoque = 0;
        $this->influencia_transito = 0;
    }

    public function merge($con) {

        if ($this->produto->categoria->desconta_estoque) {
            // -------- atualizando produto ------------

            $ps = $con->getConexao()->prepare("SELECT estoque, disponivel, transito FROM produto WHERE id=" . $this->produto->id);
            $ps->execute();
            $ps->bind_result($estoque, $disponivel, $transito);
            if ($ps->fetch()) {
                $this->produto->estoque = $estoque;
                $this->produto->transito = $transito;
                $this->produto->disponivel = $disponivel;
            }
            $ps->close();

            //------------------------------------------

            $status_pedido = $this->pedido->status;

            $x_est = ($status_pedido->estoque ? 1 : 0) * $this->quantidade;
            $dif_est = $x_est - $this->influencia_estoque;

            $x_res = ($status_pedido->transito ? 1 : 0) * $this->quantidade;
            $dif_res = $x_res - $this->influencia_transito;

            if ($this->produto->transito + $dif_res < 0) {

                throw new Exception('Sem estoque disponivel para executar essa operacao');
            }

            if ($this->produto->estoque + $dif_est < 0) {

                throw new Exception('Sem estoque para executar essa operacao');
            }

            $this->produto->estoque += $dif_est;
            $this->produto->disponivel += $dif_est;
            $this->produto->transito += $dif_res;
            $this->produto->merge($con);

            $this->influencia_estoque = $x_est;
            $this->influencia_transito = $x_res;
        }

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO produto_pedido_entrada(id_produto,quantidade,id_pedido,influencia_estoque,influencia_transito,valor) VALUES(" . $this->produto->id . "," . $this->quantidade . "," . $this->pedido->id . ",$this->influencia_estoque,$this->influencia_transito,$this->valor)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE produto_pedido_entrada SET id_produto=" . $this->produto->id . ",quantidade=" . $this->quantidade . ",id_pedido=" . $this->pedido->id . ",influencia_estoque=$this->influencia_estoque,influencia_transito=$this->influencia_transito, valor=$this->valor WHERE id=$this->id");
            $ps->execute();
            $ps->close();
        }
    }

    public function delete($con) {

        if ($this->produto->categoria->desconta_estoque) {
            $this->produto->atualizarEstoque($con);
            $this->produto->estoque -= $this->influencia_estoque;
            $this->produto->disponivel -= $this->influencia_estoque;
            $this->produto->transito -= $this->influencia_transito;
            $this->produto->merge($con);
            $this->influencia_estoque = 0;
            $this->influencia_reserva = 0;
        }
        $ps = $con->getConexao()->prepare("DELETE FROM produto_pedido_entrada WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
