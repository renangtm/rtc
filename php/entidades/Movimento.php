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
    public $saldo_anterior;
    public $historico;
    public $operacao;
    public $estorno;
    public $visto;
    public $baixa_total;
    
    function __construct() {

        $this->id = 0;
        $this->valor = 0;
        $this->data = round(microtime(true) * 1000);
        $this->juros = 0;
        $this->descontos = 0;
        $this->saldo_anterior = 0;
        $this->banco = null;
        $this->vencimento = null;
        $this->estorno = 0;
        $this->visto = false;
        $this->baixa_total = 0;
        
    }
    
    public function corrigirSaldo($con){
        
        $saldo = $this->saldo_anterior;
        $movimentos = array();
        $ps = $con->getConexao()->prepare("SELECT movimento.id,movimento.valor*(CASE WHEN operacao.debito THEN -1 ELSE 1 END) FROM movimento"
                . " INNER JOIN operacao ON operacao.id=movimento.id_operacao"
                . " WHERE id_banco=".$this->banco->id." AND data>=FROM_UNIXTIME($this->data/1000)"
                . " ORDER BY movimento.data ASC");
        $ps->execute();
        $ps->bind_result($id,$valor);
        while($ps->fetch()){
            $movimentos[] = array($id,$valor);
        }
        $ps->close();
        
        foreach($movimentos as $key=>$value){
            $saldo += $value[1];
            if($key+1<count($movimentos)){
                $ps = $con->getConexao()->prepare("UPDATE movimento SET data=data,saldo_anterior=$saldo WHERE id=".$movimentos[$key+1][0]);
                $ps->execute();
                $ps->close();
            }else{
                $ps = $con->getConexao()->prepare("UPDATE banco SET saldo=$saldo WHERE id=".$this->banco->id);
                $ps->execute();
                $ps->close();
            }
        }
        
    }
    
    public function setVisto($con,$visto=true){
        
        $ps = $con->getConexao()->prepare("UPDATE movimento SET visto=".($visto?"true":"false").",data=data WHERE id=$this->id");
        $ps->execute();
        $ps->close();
        
    }   

    public function insert($con, $rp_insert = false) {

        if ($rp_insert) {

            $ps = $con->getConexao()->prepare("INSERT INTO movimento(data,saldo_anterior,valor,id_vencimento,id_banco,juros,descontos,id_historico,id_operacao,estorno,visto) VALUES(FROM_UNIXTIME($this->data/1000),$this->saldo_anterior,$this->valor," . $this->vencimento->id . "," . $this->banco->id . ",$this->juros,$this->descontos," . $this->historico->id . "," . $this->operacao->id . ",$this->estorno,".($this->visto?"true":"false").")");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();


            if ($this->estorno == 0) {
                $ps = $con->getConexao()->prepare("UPDATE vencimento SET id_movimento=$this->id, data=data WHERE id=" . $this->vencimento->id);
                $ps->execute();
                $ps->close();
            }

            return;
        }

        if ($this->id == 0) {

            if ($this->estorno > 0 && !$this->operacao->debito) {

                throw new Exception('O movimento e um estorno porem a operacao é de credito');
            }

            if ($this->estorno > 0) {

                $ps = $con->getConexao()->prepare("SELECT id FROM movimento WHERE estorno=$this->estorno");
                $ps->execute();
                $ps->bind_result($ex);
                if ($ps->fetch()) {

                    $ps->close();
                    throw new Exception('O movimento ' . $this->estorno . ', ja foi estornado');
                }
                $ps->close();


                $ps = $con->getConexao()->prepare("SELECT valor+juros-descontos FROM movimento WHERE id=$this->estorno");
                $ps->execute();
                $ps->bind_result($v);
                if ($ps->fetch()) {
                    $ps->close();
                    if ($this->valor != $v) {
                        throw new Exception('O valor do movimento difere do valor do movimento que esta sendo estornado');
                    }
                } else {
                    $ps->close();
                    throw new Exception('Movimento estornado nao encontrado');
                }

                $ps = $con->getConexao()->prepare("SELECT id FROM movimento WHERE id=$this->estorno AND data<FROM_UNIXTIME($this->data/1000)");
                $ps->execute();
                $ps->bind_result($v);
                if ($ps->fetch()) {
                    $ps->close();
                } else {
                    $ps->close();
                    throw new Exception('O Movimento de estorno deve ter a data maior que a do movimento estornado');
                }
            } else {

                if ($this->vencimento->nota->saida && $this->operacao->debito) {

                    throw new Exception('A nota é de saida porem esse movimento é um desconto');
                } else if (!$this->vencimento->nota->saida && !$this->operacao->debito) {

                    throw new Exception('A nota é de entrada porem esse movimento é um crédito');
                }

                if ($this->valor != $this->vencimento->valor) {

                    throw new Exception('Valor do movimento é diferente do valor da nota');
                }
            }

            $ps = $con->getConexao()->prepare("SELECT id FROM movimento WHERE data=FROM_UNIXTIME($this->data/1000) AND id_banco=" . $this->banco->id);
            $ps->execute();
            $ps->bind_result($i);
            if ($ps->fetch()) {

                $ps->close();

                throw new Exception('Ja existe um movimento exatamente com essa data (ate os segundos), assim o sistema nao consegue saber qual foi feito primeiro e qual foi depois');
            }
            $ps->close();

            $this->banco->atualizaSaldo($con);

            $this->saldo_anterior = $this->banco->saldo;
            $ps = $con->getConexao()->prepare("SELECT saldo_anterior,valor,juros,descontos,operacao.debito FROM movimento INNER JOIN operacao ON movimento.id_operacao=operacao.id WHERE data = (SELECT MAX(data) FROM movimento WHERE data<FROM_UNIXTIME($this->data/1000) AND id_banco=" . $this->banco->id . ") AND id_banco = " . $this->banco->id);
            $ps->execute();
            $ps->bind_result($sa, $val, $jur, $des, $deb);
            if ($ps->fetch()) {
                $this->saldo_anterior = $deb ? ($sa - ($val + $jur - $des)) : ($sa + ($val + $jur - $des));
                $ps->close();
            } else {
                $ps->close();

                $ps = $con->getConexao()->prepare("SELECT SUM((valor+juros-descontos)*(CASE WHEN operacao.debito THEN -1 ELSE 1 END)) FROM movimento INNER JOIN operacao ON movimento.id_operacao=operacao.id WHERE id_banco=" . $this->banco->id);
                $ps->execute();
                $ps->bind_result($valt);
                if ($ps->fetch()) {

                    $this->saldo_anterior -= $valt;
                }
                $ps->close();
            }


            $vl = ($this->operacao->debito ? (- ($this->valor + $this->juros - $this->descontos)) : (+ ($this->valor + $this->juros - $this->descontos)));

            $this->banco->saldo += $vl;

            $this->banco->merge($con);



            $ps = $con->getConexao()->prepare("INSERT INTO movimento(data,saldo_anterior,valor,id_vencimento,id_banco,juros,descontos,id_historico,id_operacao,estorno) VALUES(FROM_UNIXTIME($this->data/1000),$this->saldo_anterior,$this->valor," . $this->vencimento->id . "," . $this->banco->id . ",$this->juros,$this->descontos," . $this->historico->id . "," . $this->operacao->id . ",$this->estorno)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();

            $ps = $con->getConexao()->prepare("UPDATE movimento SET saldo_anterior = saldo_anterior + ($vl), data=data WHERE data>FROM_UNIXTIME($this->data/1000) AND id_banco=" . $this->banco->id);
            $ps->execute();
            $ps->close();

            if ($this->estorno == 0) {
                $ps = $con->getConexao()->prepare("UPDATE vencimento SET id_movimento=$this->id,data=data WHERE id=" . $this->vencimento->id);
                $ps->execute();
                $ps->close();
            }
        }
    }

    public function delete($con) {

        if ($this->id > 0) {

            $ps = $con->getConexao()->prepare("DELETE FROM movimento WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();

            $vl = ($this->operacao->debito ? (- ($this->valor + $this->juros - $this->descontos)) : (+ ($this->valor + $this->juros - $this->descontos)));

            $ps = $con->getConexao()->prepare("UPDATE movimento SET saldo_anterior = saldo_anterior - ($vl), data=data WHERE data>FROM_UNIXTIME($this->data/1000) AND id_banco=" . $this->banco->id);
            $ps->execute();
            $ps->close();

            $ps = $con->getConexao()->prepare("UPDATE banco SET saldo = saldo - ($vl) WHERE id =" . $this->banco->id);
            $ps->execute();
            $ps->close();
        }
    }

}
