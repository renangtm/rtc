<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of testeConnectionFactory
 *
 * @author Renan
 */
include('includes.php');

class clonarDadosIniciaisRTC extends PHPUnit_Framework_TestCase {

    private static $conexao;

    public function getConexao() {

        if (self::$conexao == null) {
            self::$conexao = new mysqli("192.168.0.104", "SYSTEMUSER", "senha5dosistema1", "db_agrofauna", 10049);
        }

        return self::$conexao;
    }

    public function testSimple() {

        $con = new ConnectionFactory();

        
        $pedidos = "(9120)";
        
        $empresa = new Empresa(1733,$con);
        $nova_empresa = new Empresa(1734,$con);
        $produtos = $nova_empresa->getProdutos($con, 0, 50000,"produto.id_categoria=1164 AND produto.id_logistica=1735");
        
        
        $ap = array();
        foreach($produtos as $key=>$value){
            $ap[$value->id_universal] = $value;
        }
        
        $pedidos = $empresa->getPedidos($con,0, 10,"pedido.id IN $pedidos");
        
        foreach($pedidos as $key=>$pedido){
            $pedido->empresa = $nova_empresa;
            $pedido->produtos = $pedido->getProdutos($con);
            foreach($pedido->produtos as $key=>$value){
                $value->influencia_estoque=0;
                $value->influencia_reserva=0;
                foreach($ap as $key2=>$value2){
                    if($value2->id_universal===$value->produto->id_universal){
                        $value->id = 0;
                        $value->produto=$value2;
                        continue 2;
                    }
                }
                throw new Exception("Pedido $pedido->id, produto ".$value->produto->id_universal);
                break 2;
            }
            $pedido->id = 0;
            
            $pedido->merge($con);
            
        }
        
    }

}
