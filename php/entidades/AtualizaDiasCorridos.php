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
class AtualizaDiasCorridos {

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

        
        $ps = $con->getConexao()->prepare("SELECT UNIX_TIMESTAMP(IFNULL(MAX(dia),DATE_ADD(CURRENT_DATE,INTERVAL -365 DAY)))*1000,UNIX_TIMESTAMP(CURRENT_DATE)*1000 FROM dias_corridos");
        $ps->execute();
        $ps->bind_result($ultimo_dia,$agora);
        if($ps->fetch()){
            $ps->close();
            
            while($ultimo_dia<=$agora){
                
                $ultimo_dia += 24*60*60*1000;
                
                $ps = $con->getConexao()->prepare("INSERT INTO dias_corridos(dia) VALUES(FROM_UNIXTIME($ultimo_dia/1000))");
                $ps->execute();
                $ps->close();
                
            }
            
            
        }else{
            $ps->close();
        }
        
    }

}
