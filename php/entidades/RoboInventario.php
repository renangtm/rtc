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
class RoboInventario {

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
            
            $ja_tem = false;
            
            $ps = $con->getConexao()->prepare("SELECT id FROM inventario WHERE id_empresa=$empresa->id AND DATE(CURRENT_TIMESTAMP)=DATE(FROM_UNIXTIME($this->momento/1000)) AND MONTH(CURRENT_TIMESTAMP)=MONTH(FROM_UNIXTIME($this->momento/1000)) AND YEAR(CURRENT_TIMESTAMP)=YEAR(FROM_UNIXTIME($this->momento/1000))");
            $ps->execute();
            $ps->bind_result($id);
            $ja_tem = $ps->fetch();
            $ps->close();
            
            if(!$ja_tem){
            
                $produtos = $empresa->getProdutosInventario($con);
            
                $inventario = $empresa->getItensInventario($con, $produtos, $this->momento);
                
                foreach($inventario as $key=>$value){
                    
                    $value->merge($con);
                    
                }
                
                unset($produtos);
                
            }
            
        }
        
    }

}
