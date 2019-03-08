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
        
        set_time_limit(0);

        ob_implicit_flush();

        $address = 'www.tratordecompras.com.br';
        $service_port = 10000;

        if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
            echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
        }

        if (socket_connect($sock, $address, $service_port) === false) {
            echo "socket_bind() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
        }
        
        $bairro = $pedido->cliente->endereco->bairro;
        $cep = str_replace(array("-"), array(""), $pedido->cliente->endereco->cep->valor);
        $estado = $pedido->cliente->endereco->cidade->estado->sigla;
        $inscricao = $pedido->cliente->inscricao_estadual;
        $nome = $pedido->cliente->razao_social;
        $documento = $pedido->id;
        $cidade = $pedido->cliente->endereco->cidade->nome;
        $logadouro = $pedido->cliente->endereco->rua;
        $valor = 0;
        foreach($pedido->produtos as $key=>$value){
            $valor += $value->quantidade*($value->valor_base+$value->ipi+$value->frete+$value->juros+$value->icms);
        }
        $agora = round(microtime(true)*1000);
        $momento = $agora + $pedido->prazo*24*60*60*1000;
       
        if($bairro === ""){
            $bairro = "sem bairro";
        }
        
        if($inscricao === ""){
            $inscricao = "000000";
        }
        
        if($nome === ""){
            $nome = "sem nome";
        }
        
        if($logadouro === ""){
            $logadouro = "sem rua";
        }
        
        $in = "itau;tipo:em;bairro:$bairro;cep:$cep;cidade:$cidade;estado:$estado;inscricao:$inscricao;logadouro:$logadouro;nome:$nome;documento:$documento;valor:$valor;vencimento:$momento\n";
        
        socket_write($sock, $in, strlen($in));

        $out = socket_read($sock, 2048);
        socket_close($sock);

        $objeto = json_decode($out);

        $lk = $objeto->link;

        return "<a style='margin-left:10px' href='$lk'><i class='fas fa-download'></i>&nbsp Abrir boleto</a>";
        
    }

    public function habilitada($pedido) {

        return strpos($pedido->empresa->nome, 'Agro') !== false && strpos($pedido->empresa->nome, 'Fauna') !== false;
    }

}
