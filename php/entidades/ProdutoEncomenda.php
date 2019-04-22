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
class ProdutoEncomenda {

    public $id;
    public $produto;
    public $quantidade;
    public $valor_base_inicial;
    public $base_calculo_inicial;
    public $juros_inicial;
    public $icms_inicial;
    public $ipi_inicial;
    public $valor_base_final;
    public $base_calculo_final;
    public $juros_final;
    public $icms_final;
    public $ipi_final;
    public $encomenda;

    function __construct() {

        $this->id = 0;
        $this->produto = null;
        $this->quantidade = 0;

        $this->valor_base_inicial = 0;
        $this->base_calculo_inicial = 0;
        $this->juros_inicial = 0;
        $this->icms_inicial = 0;
        $this->ipi_inicial = 0;

        $this->valor_base_final = 0;
        $this->base_calculo_final = 0;
        $this->juros_final = 0;
        $this->icms_final = 0;
        $this->ipi_final = 0;

        $this->encomenda = null;
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO produto_encomenda(id_produto,quantidade,valor_base_inicial,valor_base_final,juros_inicial,juros_final,icms_inicial,icms_final,base_calculo_inicial,base_calculo_final,ipi_inicial,ipi_final,id_encomenda) VALUES(" . $this->produto->id . "," . $this->quantidade . ",$this->valor_base_inicial,$this->valor_base_final,$this->juros_inicial,$this->juros_final,$this->icms_inicial,$this->icms_final,$this->base_calculo_inicial,$this->base_calculo_final,$this->ipi_inicial,$this->ipi_final," . $this->encomenda->id . ")");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE produto_encomenda SET id_produto = " . $this->produto->id . ", quantidade=$this->quantidade, valor_base_inicial=$this->valor_base_inicial,valor_base_final=$this->valor_base_final,juros_inicial=$this->juros_inicial,juros_fina=$this->juros_final,icms_inicial=$this->icms_inicial,icms_final=$this->icms_final,base_calculo_inicial=$this->base_calculo_inicial,base_calculo_final=$this->base_calculo_final,ipi_inicial=$this->ipi_inicial,ipi_final=$this->ipi_final,id_encomenda=" . $this->encomenda->id . " WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();
        }
    }

    public function atualizarCustos() {

        $cat = $this->produto->categoria;

        $emp = $this->encomenda->empresa;

        $juros_mes = 1 + $emp->juros_mensal / 100;

        $juros_dia = pow($juros_mes, 1 / 30);

        $this->juros_inicial = round(($this->valor_base_inicial * pow($juros_dia, $this->encomenda->prazo)) - $this->valor_base_inicial, 2);

        if ($this->encomenda->cliente != null) {

            $this->base_calculo_inicial = ($cat->base_calculo / 100) * ($this->valor_base_inicial + $this->juros_inicial);

            $icms = Sistema::getIcmsEstado($this->encomenda->cliente->endereco->cidade->estado);

            if ($emp->endereco->cidade->estado->id == $this->encomenda->cliente->endereco->cidade->estado->id || $this->encomenda->cliente->suframado) {

                $this->icms_inicial = 0;
            } else {

                $base = ($cat->base_calculo / 100) * ($icms / 100);

                if (!$this->produto->categoria->icms_normal) {

                    $base = ($cat->base_calculo / 100) * ($this->produto->categoria->icms / 100);
                }

                $base = (1 - $base);
                $icms = round(($this->valor_base_inicial + $this->juros_inicial) / $base, 2);
                $icms = $icms - $this->valor_base_inicial - $this->juros_inicial;

                $this->icms_inicial = $icms;
            }
        }

        $this->ipi_inicial = ($this->valor_base_inicial + $this->juros_inicial + $this->icms_inicial) * ($this->produto->categoria->ipi / 100);

        //-------- valores finais

        $this->juros_final = round(($this->valor_base_final * pow($juros_dia, $this->encomenda->prazo)) - $this->valor_base_final, 2);

        if ($this->encomenda->cliente != null) {

            $this->base_calculo_final = ($cat->base_calculo / 100) * ($this->valor_base_final + $this->juros_final);

            $icms = Sistema::getIcmsEstado($this->encomenda->cliente->endereco->cidade->estado);

            if ($emp->endereco->cidade->estado->id == $this->encomenda->cliente->endereco->cidade->estado->id || $this->encomenda->cliente->suframado) {

                $this->icms_final = 0;
            } else {

                $base = ($cat->base_calculo / 100) * ($icms / 100);

                if (!$this->produto->categoria->icms_normal) {

                    $base = ($cat->base_calculo / 100) * ($this->produto->categoria->icms / 100);
                }

                $base = (1 - $base);
                $icms = round(($this->valor_base_final + $this->juros_final) / $base, 2);
                $icms = $icms - $this->valor_base_final - $this->juros_final;

                $this->icms_final = $icms;
            }
        }

        $this->ipi_final = ($this->valor_base_final + $this->juros_final + $this->icms_final) * ($this->produto->categoria->ipi / 100);
    }

    function delete($con) {

        $ps = $con->getConexao()->prepare("DELETE FROM produto_encomenda WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
