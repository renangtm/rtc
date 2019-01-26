<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CategoriaDocumento
 *
 * @author Renan
 */
class Movimento {

    public $id;
    public $valor;
    public $juros;
    public $descontos;
    public $vencimento;
    public $data;
    public $banco;
    public $debito;
    public $saldo_anterior;

    function __construct() {

        $this->id = 0;
        $this->valor = 0;
        $this->data = round(microtime(true) * 1000);
        $this->juros = 0;
        $this->descontos = 0;
        $this->saldo_anterior = 0;
        $this->banco = null;
        $this->vencimento = null;
    }

    public function insert($con) {

        if ($this->id == 0) {

            if($this->vencimento->nota->saida && $this->debito){
                
                throw new Exception('A nota é de saida porem esse movimento é um desconto');
                
            }else if(!$this->vencimento->nota->saida && !$this->debito){
                
                throw new Exception('A nota é de entrada porem esse movimento é um crédito');
                
            }
            
            if ($this->valor != $this->vencimento->valor) {

                throw new Exception('Valor do movimento é diferente do valor da nota');
            }

            $ps = $con->getConexao()->prepare("SELECT id FROM movimento WHERE data=FROM_UNIXTIME($this->data/1000) AND id_banco=".$this->banco->id);
            $ps->execute();
            $ps->bind_result($i);
            if($ps->fetch()){
                
                $ps->close();
                
                throw new Exception('Ja existe um movimento exatamente com essa data (ate os segundos), assim o sistema nao consegue saber qual foi feito primeiro e qual foi depois');
                
            }
            $ps->close();
            
            $this->banco->atualizaSaldo($con);

            $this->saldo_anterior = $this->banco->saldo;
            $ps = $con->getConexao()->prepare("SELECT saldo_anterior,valor,juros,descontos,debito FROM movimento WHERE data = (SELECT MAX(data) FROM movimento WHERE data<FROM_UNIXTIME($this->data/1000) AND id_banco=" . $this->banco->id . ") AND id_banco = ".$this->banco->id);
            $ps->execute();
            $ps->bind_result($sa, $val, $jur, $des, $deb);
            if ($ps->fetch()) {
                $this->saldo_anterior = $deb ? ($sa - ($val + $jur - $des)) : ($sa + ($val + $jur - $des));
                $ps->close();
            }else{
                $ps->close();
                
                $ps = $con->getConexao()->prepare("SELECT SUM((valor+juros-descontos)*(CASE WHEN debito THEN -1 ELSE 1 END)) FROM movimento WHERE id_banco=".$this->banco->id);
                $ps->execute();
                $ps->bind_result($valt);
                if($ps->fetch()){
                    
                    $this->saldo_anterior -= $valt;
                    
                }
                $ps->close();
                
            }
            

            $vl = ($this->debito ? (- ($this->valor + $this->juros - $this->descontos)) : (+ ($this->valor + $this->juros - $this->descontos)));

            $this->banco->saldo += $vl;

            $this->banco->merge($con);

            $ps = $con->getConexao()->prepare("INSERT INTO movimento(data,saldo_anterior,valor,id_vencimento,id_banco,juros,descontos,debito) VALUES(FROM_UNIXTIME($this->data/1000),$this->saldo_anterior,$this->valor," . $this->vencimento->id . "," . $this->banco->id . ",$this->juros,$this->descontos," . ($this->debito ? "true" : "false") . ")");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();

            $ps = $con->getConexao()->prepare("UPDATE movimento SET saldo_anterior = saldo_anterior + ($vl), data=data WHERE data>FROM_UNIXTIME($this->data/1000) AND id_banco=" . $this->banco->id);
            $ps->execute();
            $ps->close();
        }
    }

    public function delete($con) {

        if ($this->id > 0) {

            $ps = $con->getConexao()->prepare("DELETE FROM movimento WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();

            $vl = ($this->debito ? (- ($this->valor + $this->juros - $this->descontos)) : (+ ($this->valor + $this->juros - $this->descontos)));

            $ps = $con->getConexao()->prepare("UPDATE movimento SET saldo_anterior = saldo_anterior - ($vl), data=data WHERE data>FROM_UNIXTIME($this->data/1000) AND id_banco=" . $this->banco->id);
            $ps->execute();
            $ps->close();
            
        }
        
    }

}
