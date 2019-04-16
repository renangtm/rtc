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
class OBS_NFE {

    public static $RETORNO_REMESSA = 1;
    private $obs;

    public function __construct($empresa, $pedido, $op = 0) {

        $tipo = $empresa->tipo_empresa;

        if ($tipo === 0) { //Empresa Agricola
            $this->obs = "Os produtos estao adequadamente acondicionados para suportar os riscos normais das etapas necessarias a uma operacao de transporte e que atende a regulamentacao em vigor. Conf. Lei n. 9974 de 06\/06\/00 reg. pelo decreto 4072\/02 de 04\/01\/2002, as embalagens adquiridas nesta NF deverao ser devolvidas no prazo de 1 (um) ano, perfuradas e com a triplice lavagem realizada, na unidade de recebimento: Agro-Fauna Com. Ins. Ltda. R.Coutinho Cavalcanti, 1171 - Jd Alto Alegre - S J Rio Preto-SP. CENTRAL DE RECEBIMENTOS DE EMBALAGENS VAZIAS DE AGROTOXICOS Av Jose Geraldo de Matos, 765A Distrito Industrial do Paracangua - Taubate SP . Pedido:$pedido->id";

            if ($pedido->cliente->suframado) {
                $this->obs .= ".Reducao da base de calculo conforme artigo 9 Anexo ll do Decreto 45.490/00 do RICMS-SP. Isento conforme artigo 41 Item I do Anexo I do Decreto 45.490\/00 do RICMS-SP. Suframa: " . $pedido->cliente->inscricao_suframa;
            }
        } else if ($tipo === 1) {//Logistica
            if ($op === self::$RETORNO_REMESSA) {
                $this->obs = "Nota emitida referente a processamento de pedido do " . $empresa->nome . " para a " . $empresa->nome . ". conforme artigo 41 item I do anexo I do decreto 45490 00 do RICMS - SP. Pedido: $pedido->id";
            }
        } else {

            $this->obs = "";
        }
    }

    public function getObs() {

        return $this->obs;
    }

}
