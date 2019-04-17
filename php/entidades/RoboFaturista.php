<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegraTabela
 *
 * @author Renan
 */
class RoboFaturista {

    public $dia;
    public $mes;
    public $ano;
    public $hora;
    public $minuto;
    public $segundo;
    public $momento;

    public function __construct() {

        date_default_timezone_set("America/Sao_Paulo");

        $this->momento = round(microtime(true) * 1000);

        $str = explode(':', date('d:m:Y:H:i:s', $this->momento / 1000));
        $this->dia = intval($str[0]);
        $this->mes = intval($str[1]);
        $this->ano = intval($str[2]);
        $this->hora = intval($str[3]);
        $this->minuto = intval($str[4]);
        $this->segundo = intval($str[5]);
    }

    public function executar($con) {
        
        $empresas = Sistema::getEmpresas($con, 'empresa.rtc>=5');
        
        foreach($empresas as $key=>$empresa){
            $notas = $empresa->getNotas($con, 0, 10,'nota.emissao_automatica=false AND nota.emitida=false'); 
            $in = "(0";
            foreach($notas as $key2=>$nota){
                try{
                    if($nota->saida){
                        $nota->emitir($con);
                    }else if(!$nota->saida){
                        $nota->manifestar($con);
                    }
                }catch(Exception $ex){
                    
                }
                $in .= ",$nota->id";
            }
            $in .= ")";
            $ps = $con->getConexao()->prepare("UPDATE nota SET data_emissao=data_emissao, emissao_automatica=true WHERE id IN $in");
            $ps->execute();
            $ps->close();
        }
        
    }

}
