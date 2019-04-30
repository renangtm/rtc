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

    public static $VENDA_DENTRO_ESTADO = "5106";
    public static $VENDA_FORA_ESTADO = "6106";
    public static $REMESSA_DEPOSITO = "5906";
    public static $REMESSA_DEPOSITO_2 = "5905";
    public static $RETORNO_DEPOSITO = "5907";
    public static $ISENTO = "6110";
    public static $VENDA_DENTRO_ESTADO_2 = "5102";
    public static $VENDA_FORA_ESTADO_2 = "5106";
    public static $TRANSFERENCIA = "6152";
    public static $TRANSFERENCIA_DENTRO_ESTADO = "5152";
    public static $ANULACAO_DENTRO_ESTADO = "5206";
    public static $ANULACAO_FORA_ESTADO = "6206";
    
    public static function descricao($cfop) {

        $cfop = str_replace(array("."), array(""), $cfop . "");

        if ($cfop === self::$VENDA_DENTRO_ESTADO) {
            return "Venda de mercadoria dentro do estado.";
        } else if ($cfop === self::$VENDA_FORA_ESTADO) {
            return "Venda de mercadoria fora do estado";
        } else if ($cfop === self::$REMESSA_DEPOSITO) {
            return "Remessa de mercadoria para deposito";
        }else if ($cfop === self::$REMESSA_DEPOSITO_2) {
            return "Remessa de mercadoria para deposito";
        } else if ($cfop === self::$RETORNO_DEPOSITO) {
            return "Retorno de mercadoria para deposito";
        } else if ($cfop === self::$ISENTO) {
            return "Venda de merc destinada a zona franca de manaus";
        } else if ($cfop === self::$VENDA_DENTRO_ESTADO_2) {
            return "Venda de mercadoria dentro do estado.";
        } else if ($cfop === self::$VENDA_FORA_ESTADO_2) {
            return "Venda de mercadoria fora do estado";
        } else if ($cfop === self::$TRANSFERENCIA) {
            return "Transferencia de mercadoria fora do estado";
        }else if ($cfop === self::$TRANSFERENCIA_DENTRO_ESTADO) {
            return "Transferencia de mercadoria dentro do estado";
        }else if ($cfop === self::$ANULACAO_FORA_ESTADO) {
            return "Anulacao de valor referente a prestacao de servico. fora do estado";
        }else if ($cfop === self::$ANULACAO_DENTRO_ESTADO) {
            return "Anulacao de valor referente a prestacao de servico. dentro do estado";
        }

        return "Indefinido";
    }

}
