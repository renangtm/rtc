<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Boleto
 *
 * @author T-Gamer
 */
class BoletoEspecialAgroFauna extends FormaPagamento {

    function __construct() {

        $this->id = 2;
        $this->nome = "Boleto Agro Fauna";
    }

    public function aoFinalizarPedido($pedido) {



        $inscricao = $pedido->cliente->cnpj->valor;

        if ($pedido->cliente->pessoa_fisica) {
            $inscricao = $pedido->cliente->cpf->valor;
        }

        $cep = $pedido->cliente->endereco->cep->valor;

        if ($inscricao === "") {
            $inscricao = "00001";
        }

        if ($cep === "") {
            $cep = "1234";
        }

        $bairro = $pedido->cliente->endereco->bairro;
        $cep = str_replace(array("-"), array(""), $cep);
        $estado = $pedido->cliente->endereco->cidade->estado->sigla;
        $inscricao = substr(str_replace(array(".", "-", "/"), array("", "", ""), $inscricao), 0, 14);
        $nome = $pedido->cliente->razao_social;
        $documento = $pedido->id;
        $cidade = $pedido->cliente->endereco->cidade->nome;
        $logadouro = $pedido->cliente->endereco->rua;
        $valor = 0;
        foreach ($pedido->produtos as $key => $value) {
            $valor += $value->quantidade * ($value->valor_base + $value->ipi + $value->frete + $value->juros + $value->icms);
        }

        $ret = "";
        $valor = round($valor / max(1, $pedido->parcelas), 2);


        for ($i = 0; $i < max(1, $pedido->parcelas); $i++) {

            $fat = $pedido->prazo / max(1, $pedido->parcelas);

            $agora = round(microtime(true) * 1000);
            $momento = $agora + ($fat * ($i+1) + 1) * 24 * 60 * 60 * 1000;

            if ($bairro === "") {
                $bairro = "sem bairro";
            }

            if ($nome === "") {
                $nome = "sem nome";
            }

            if ($logadouro === "") {
                $logadouro = "sem rua";
            }


            $in = "itau;tipo:em;bairro:$bairro;cep:$cep;cidade:$cidade;estado:$estado;inscricao:$inscricao;logadouro:$logadouro;nome:$nome;documento:$documento;valor:$valor;vencimento:$momento";

            $out = Sistema::getMicroServicoJava('ServidorBoletosRTC', $in);

            $objeto = json_decode($out);

            $lk = $objeto->link;

            $ret .= "<br><a target='_blank' style='margin-left:10px' href='$lk'><i class='fas fa-download'></i>&nbsp Abrir boleto $i</a>";
        }
        
        $ret.="<hr><img src=''></img>";
        
        return $ret;
    }

    public function habilitada($pedido) {

        return strpos($pedido->empresa->nome, 'Agro') !== false && strpos($pedido->empresa->nome, 'Fauna') !== false;
    }

}
