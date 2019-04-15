<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CotacaoEntrada
 *
 * @author Renan
 */
class CFOP {

    public static $VENDA_DENTRO_ESTADO = "5102";
    public static $VENDA_FORA_ESTADO = "6102";
    public static $REMESSA_DEPOSITO = "5905";
    public static $RETORNO_DEPOSITO = "5906";
    
    
    public static function descricao($cfop){
        
        if($cfop === self::$VENDA_DENTRO_ESTADO){
            return "Venda de mercadoria dentro do estado.";
        }else if($cfop === self::$VENDA_FORA_ESTADO){
            return "Venda de mercadoria fora do estado";
        }else if($cfop === self::$REMESSA_DEPOSITO){
            return "Remessa de mercadoria para deposito";
        }else if($cfop === self::$RETORNO_DEPOSITO){
            return "Retorno de mercadoria para deposito";
        }
        
        return "Indefinido";
        
    }
    
}
