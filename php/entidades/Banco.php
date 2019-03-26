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
class Banco {

    public $id;
    public $codigo;
    public $nome;
    public $conta;
    public $agencia;
    public $saldo;
    public $excluido;
    public $empresa;
    public $codigo_contimatic;
    public $fechamento;
    
    function __construct() {

        $this->id = 0;
        $this->saldo = 0;
        $this->codigo = 0;
        $this->excluido = false;
        $this->codigo_contimatic = 0;
        $this->fechamento = false;
        
    }
    
    public function getValorFechamento($con){
        
        $anterior = 0;
        $data_anterior = '1970-01-01';
        
        $ps = $con->getConexao()->prepare("SELECT valor,data FROM fechamento_caixa WHERE id_banco=$this->id ORDER BY data DESC");
        $ps->execute();
        $ps->bind_result($valor,$data);
        if($ps->fetch()){
            $anterior = $valor;
            $data_anterior = $data;
        }
        $ps->close();
        
        
        $ps = $con->getConexao()->prepare("SELECT SUM((CASE WHEN operacao.debito THEN -1 ELSE 1 END)*(movimento.valor-movimento.descontos+movimento.juros)) FROM movimento "
                . "INNER JOIN operacao ON movimento.id_operacao=operacao.id "
                . "WHERE movimento.id_banco=$this->id AND movimento.data>$data_anterior");
        $ps->execute();
        $ps->bind_result($valor);
        
        if($ps->fetch()){
            $anterior += $valor;
        }
        
        $ps->close();
        
        $fechamento = new FechamentoCaixa();
        $fechamento->valor = $anterior;
        $fechamento->data = round(microtime(true)*1000);
        $fechamento->banco = $this;
        
        return $fechamento;
        
    }
    
    public function getCountMovimentosFechamento($con,$filtro2=""){
        
        $filtro = "";
        
        $ps = $con->getConexao()->prepare("SELECT MAX(data) FROM fechamento_caixa WHERE id_banco=$this->id");
        $ps->execute();
        $ps->bind_result($dt);
        if($ps->fetch()){
            if($dt !== null){
                $filtro .= "movimento.data>$dt";
            }
        }
        $ps->close();
        
        if($filtro2 !== ""){
            
            $filtro .= " AND $filtro2";
            
        }
        
        $qtd = $this->empresa->getCountMovimentos($con, $filtro);
        
        return $qtd;
        
    }

    public function getMovimentosFechamento($con,$x1,$x2,$filtro2="",$ordem=""){
        
        $filtro = "";
        
        $ps = $con->getConexao()->prepare("SELECT MAX(data) FROM fechamento_caixa WHERE id_banco=$this->id");
        $ps->execute();
        $ps->bind_result($dt);
        if($ps->fetch()){
            if($dt !== null){
                $filtro .= "movimento.data>$dt";
            }
        }
        $ps->close();
        
        if($filtro2 !== ""){
            
            $filtro .= " AND $filtro2";
            
        }
        
        $movimentos = $this->empresa->getMovimentos($con,$x1, $x2,$filtro,$ordem);
        
        return $movimentos;
        
    }
    
    public function atualizaSaldo($con) {

        $ps = $con->getConexao()->prepare("SELECT saldo FROM banco WHERE id = $this->id");
        $ps->execute();
        $ps->bind_result($saldo);
        if ($ps->fetch()) {
            $this->saldo = $saldo;
        }
        $ps->close();
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO banco(nome,conta,saldo,excluido,id_empresa,codigo,agencia,fechamento) VALUES('$this->nome','$this->conta',$this->saldo,false," . $this->empresa->id . ",$this->codigo,'" . addslashes($this->agencia) . "',".($this->fechamento?"true":"false").")");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE banco SET nome='$this->nome',conta='$this->conta',saldo=$this->saldo,excluido = false,codigo=$this->codigo, id_empresa=" . $this->empresa->id . ",agencia='" . addslashes($this->agencia) . "',fechamento=".($this->fechamento?"true":"false")." WHERE id=$this->id");
            $ps->execute();
            $ps->close();
        }

        if ($this->codigo_contimatic > 0) {

            $ps = $con->getConexao()->prepare("UPDATE banco SET codigo_contimatic=$this->codigo_contimatic WHERE id=$this->id");
            $ps->execute();
            $ps->close();
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE banco SET excluido=true WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
