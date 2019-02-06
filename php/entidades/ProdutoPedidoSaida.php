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
    public $ipi;
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

        if ($this->produto->disponivel + $dif_res < 0) {

            throw new Exception('Sem estoque disponivel para executar essa operacao');
        }

        if ($this->produto->estoque + $dif_est < 0) {

            throw new Exception('Sem estoque para executar essa operacao');
        }

        $this->produto->estoque += $dif_est;
        $this->produto->disponivel += $dif_res;
        $this->produto->merge($con);

        $this->influencia_estoque = $x_est;
        $this->influencia_reserva = $x_res;

        if ($this->id == 0) {
            
            $ps = $con->getConexao()->prepare("INSERT INTO produto_pedido_saida(id_produto,quantidade,validade_minima,valor_base,juros,icms,base_calculo,frete,id_pedido,influencia_estoque,influencia_reserva,ipi) VALUES(" . $this->produto->id . "," . $this->quantidade . ",FROM_UNIXTIME($this->validade_minima/1000),$this->valor_base,$this->juros,$this->icms,$this->base_calculo,$this->frete," . $this->pedido->id . ",$this->influencia_estoque,$this->influencia_reserva,$this->ipi)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        } else {

            $ps = $con->getConexao()->prepare("UPDATE produto_pedido_saida SET id_produto = " . $this->produto->id . ", quantidade=$this->quantidade, validade_minima=FROM_UNIXTIME($this->validade_minima/1000),valor_base=$this->valor_base,juros=$this->juros,icms=$this->icms,base_calculo=$this->base_calculo,frete=$this->frete, id_pedido=" . $this->pedido->id . ", influencia_estoque=$this->influencia_estoque, influencia_reserva = $this->influencia_reserva, ipi=$this->ipi WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();
        }

        if ($dif_res != 0 || $dif_est != 0) {

            foreach ($this->retiradas as $key => $value) {

                $ps = $con->getConexao()->prepare("UPDATE lote SET quantidade_real = quantidade_real + " . $value[1] . " WHERE id = " . $value[0]);
                $ps->execute();
                $ps->close();
            }

            $ps = $con->getConexao()->prepare("DELETE FROM retirada WHERE id_produto_pedido = $this->id");
            $ps->execute();
            $ps->close();

            $this->retiradas = array();

            $lotes = $this->produto->getLotes($con, "lote.validade = FROM_UNIXTIME($this->validade_minima/1000) AND lote.quantidade_real > 0", "lote.quantidade_real DESC");

            $qtd = max(abs($this->influencia_estoque),abs($this->influencia_reserva));

            $ls = array();

            $li = null;
            $is = array();

            foreach ($lotes as $key => $value) {

                if ($qtd == 0) {

                    break;
                }

                if ($value->quantidade_real <= $qtd) {

                    $ls[] = $value;
                    $qtd -= $value->quantidade_real;
                }
            }

            if ($qtd > 0 && count($ls) == count($lotes)) {

                $this->produto->estoque -= $this->influencia_estoque;
                $this->produto->disponivel -= $this->influencia_reserva;
                $this->produto->merge($con);

                $this->influencia_estoque = 0;
                $this->influencia_reserva = 0;
                
                foreach ($this->retiradas as $key => $value) {

                    $ps = $con->getConexao()->prepare("UPDATE lote SET quantidade_real = quantidade_real + " . $value[1] . " WHERE id = " . $value[0]);
                    $ps->execute();
                    $ps->close();
                }

                $ps = $con->getConexao()->prepare("DELETE FROM retirada WHERE id_produto_pedido = $this->id");
                $ps->execute();
                $ps->close();
                
                $this->retiradas = array();

                throw new Exception('Nao existem lotes suficientes para essa quantidade');
                
            } else if ($qtd > 0) {

                $li = $lotes[count($lotes) - 1];
                $i = $lotes[count($lotes) - 1]->getItem()->filhos;

                while ($qtd > 0) {

    
                    for ($j = 1; $j < count($i); $j++) {
                        if ($i[$j] == null)
                            continue;
                        for ($k = $j; $k > 0; $k--) {
                            if ($i[$k - 1] != null) {
                                if (!($i[$k]->quantidade > $i[$k - 1]->quantidade))
                                    break;
                            }
                            $t = $i[$k];
                            $i[$k] = $i[$k - 1];
                            $i[$k - 1] = $t;
                        }
                    }
                    
                    $min = 0;
                    
                    for ($j = 0; $j < count($i); $j++) {
                        if($i[$min] == null){
                            $min = $j;
                        }else if($i[$j] != null){
                            if($i[$min]->quantidade>=$i[$j]->quantidade){
                                $min = $j;
                            }
                        }
                    }
                    
                    for ($j = 0; $j < count($i) && $qtd > 0; $j++) {

                        if ($i[$j] == null)
                            continue;

                        if ($i[$j]->quantidade <= $qtd) {

                            $qtd -= $i[$j]->quantidade;
                            $is[] = $i[$j];
                            
                        }
                    }

                    if ($qtd > 0) {

                        if ($i[$min]->quantidade_filhos == 0) {

                            $this->produto->estoque -= $this->influencia_estoque;
                            $this->produto->disponivel -= $this->influencia_reserva;
                            $this->produto->merge($con);

                            $this->influencia_estoque = 0;
                            $this->influencia_reserva = 0;
                            
                            foreach ($this->retiradas as $key => $value) {

                                $ps = $con->getConexao()->prepare("UPDATE lote SET quantidade_real = quantidade_real + " . $value[1] . " WHERE id = " . $value[0]);
                                $ps->execute();
                                $ps->close();
                            }

                            $ps = $con->getConexao()->prepare("DELETE FROM retirada WHERE id_produto_pedido = $this->id");
                            $ps->execute();
                            $ps->close();

                            $this->retiradas = array();

                            throw new Exception('Nao e possivel separar essa quantidade');
                        }

                        $i = $i[$min]->filhos;
                    }
                }
            }

            foreach ($ls as $key => $value) {

                $this->retiradas[] = array($value->id, $value->quantidade_real, 0);
            }

            if ($li != null) {

                foreach ($is as $key => $value) {

                    $r = array($li->id, $value->quantidade);

                    foreach ($value->numero as $key2 => $value2) {

                        $r[] = $value2;
                    }

                    $this->retiradas[] = $r;
                }
            }

            foreach ($this->retiradas as $key => $value) {

                $str = "";


                foreach ($value as $key2 => $value2) {
                    if ($key2 < 2)
                        continue;
                    if ($str != "")
                        $str .= ",";
                    $str .= $value2;
                }

                $ps = $con->getConexao()->prepare("INSERT INTO retirada(id_lote,retirada,id_produto_pedido,quantidade) VALUES(" . $value[0] . ",'$str',$this->id," . $value[1] . ")");
                $ps->execute();
                $ps->close();
                
                $ps = $con->getConexao()->prepare("UPDATE lote SET quantidade_real = quantidade_real - ".$value[1]." WHERE id = ".$value[0]);
                $ps->execute();
                $ps->close();
                
            }
        }
    }

    public function atualizarCustos() {

        $cat = $this->produto->categoria;

        $emp = $this->pedido->empresa;

        $juros_mes = 1 + $emp->juros_mensal / 100;

        $juros_dia = pow($juros_mes, 1 / 30);

        $this->juros = round(($this->valor_base * pow($juros_dia, $this->pedido->prazo)) - $this->valor_base, 2);

        if ($this->pedido->cliente != null) {

            $icms = Sistema::getIcmsEstado($this->pedido->cliente->endereco->cidade->estado);

            if ($this->pedido->empresa->endereco->cidade->estado->id == $this->pedido->cliente->endereco->cidade->estado->id || $this->pedido->cliente->suframado) {

                $icms = 0;
            }

            $base = ($cat->base_calculo / 100) * ($icms / 100);

            $this->base_calculo = ($cat->base_calculo / 100) * ($this->valor_base+$this->juros);
            
            if (!$this->produto->categoria->icms_normal) {

                $base = ($cat->base_calculo / 100) * ($this->produto->categoria->icms / 100);
            }
            

            $this->icms = round(($this->valor_base + $this->juros) * $base, 2);
        }

        $this->ipi = ($this->valor_base + $this->juros + $this->icms) * ($this->produto->categoria->ipi / 100);

        if ($this->pedido->incluir_frete) {

            $total = 0;

            foreach ($this->pedido->produtos as $produto) {

                $total += $produto->valor_base * $produto->quantidade;
                
            }

            if ($total > 0) {

                $perc = ($this->valor_base * $this->quantidade) / $total;
                
                $this->frete = round((($this->pedido->frete * $perc) / $this->quantidade), 2);
            }
            
        }else{
            
            $this->frete = 0;
            
        }
        
    }

    public function delete($con) {

        $this->produto->estoque -= $this->influencia_estoque;
        $this->produto->disponivel -= $this->influencia_reserva;
        $this->produto->merge($con);
        $this->influencia_estoque = 0;
        $this->influencia_reserva = 0;

        foreach ($this->retiradas as $key => $value) {

            $ps = $con->getConexao()->prepare("UPDATE lote SET quantidade_real = quantidade_real + " . $value[1] . " WHERE id = " . $value[0]);
            $ps->execute();
            $ps->close();
        }

        $ps = $con->getConexao()->prepare("DELETE FROM retirada WHERE id_produto_pedido = $this->id");
        $ps->execute();
        $ps->close();

        $ps = $con->getConexao()->prepare("DELETE FROM produto_pedido_saida WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
