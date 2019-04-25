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
class CriadorCotacaoGrupalComBaseEncomenda {

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

        $empresas = array();
        $ps = $con->getConexao()->prepare("SELECT id FROM empresa WHERE rtc>=6");
        $ps->execute();
        $ps->bind_result($id);
        while ($ps->fetch()) {
            $empresas[] = $id;
        }
        $ps->close();

        foreach ($empresas as $key => $empresa) {

            $empresa = new Empresa();
            
            $ecomendas = $empresa->getEncomendas($con, 0, 10,"encomenda.agrupada = false");
            
        }
        
        
    }

}
