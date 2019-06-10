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
class RoboProtocolo {

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
      
        $status = array(
            Sistema::STATUS_SEPARACAO(),
            Sistema::STATUS_FATURAMENTO(),
        );
        
       
        $str_status = "(-1";
        
        foreach($status as $key=>$value){
            $str_status .= ",".$value->id;
        }
        
        $str_status .= ")";
        
        
        $ps = $con->getConexao()->prepare("UPDATE protocolo SET fim=CURRENT_TIMESTAMP WHERE tipo_entidade='Pedido' AND id_entidade IN (SELECT id FROM pedido WHERE id_status NOT IN $str_status)");
        $ps->execute();
        $ps->close();
        
        $empresas = Sistema::getEmpresas($con, 'empresa.rtc>=5');
        
        foreach($empresas as $key=>$empresa){
            
            $emergencias = $empresa->getPedidos($con,0,5,"DATE_ADD(pedido.data,INTERVAL 96 HOUR)<CURRENT_TIMESTAMP AND pedido.id_status IN $str_status AND pedido.id NOT IN (SELECT id_entidade FROM protocolo WHERE tipo_entidade='Pedido' GROUP BY id_entidade)");
            
            $servicos = $empresa->getPedidos($con,0,5,"DATE_ADD(pedido.data,INTERVAL 48 HOUR)<CURRENT_TIMESTAMP AND pedido.id_status IN $str_status AND pedido.id NOT IN (SELECT id_entidade FROM protocolo WHERE tipo_entidade='Pedido' GROUP BY id_entidade)");
           
            foreach($servicos as $key=>$value){
                foreach($emergencias as $key2=>$value2){
                    if($value->id === $value2->id){
                        unset($servicos[$key]);
                        break;
                    }
                }
            }
            
            foreach($emergencias as $key=>$value){
                
                echo $value->id.",";
                
            }
            
        }
        
    }

}
