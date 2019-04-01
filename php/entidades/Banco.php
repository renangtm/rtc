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
    
    private static function normalizarDia($ms) {

        date_default_timezone_set("America/Sao_Paulo");
        
        $d = explode(':', date('H:i:s', $ms / 1000));

        $nm = $ms;

        $nm -= intval($d[0]) * 60 * 60 * 1000;
        $nm -= intval($d[1]) * 60 * 1000;
        $nm -= intval($d[2]) * 1000;

        return $nm;
    }

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
    
    public function getRelatorioMovimentosFechamento($con){
        
        $obs = "Fechamento de ";
        
        $fechamento = $this->getFechamento($con);
        
        $obs .= date("d/m/Y",doubleval($fechamento->data_anterior."")/1000)." ate ".date("d/m/Y",doubleval($fechamento->data."")/1000).", valor de ".round($fechamento->valor,2).", saldo atual ".round($this->saldo,2).", Fechamento anterior: ".round($fechamento->valor_anterior,2);
        
        $qtd = $this->getCountMovimentosFechamento($con);
        $movimentos = $this->getMovimentosFechamento($con, 0, $qtd);
        
        
        $campos = array(
            array("tipo","Tipo",10),
            array("cf","Cliente/Fornecedor",30),
            array("operacao","Op.",15),
            array("valor","Valor",13),
            array("juros","Juros",5),
            array("desconto","Desc",5),
            array("saldo","Saldo",10),
            array("nota","Nota",6),
            array("ficha","Ficha",6));
        
        $valores = array();
        
        foreach($movimentos as $key=>$value){
            
            $l = array();
            
            if($value->operacao->debito){
                $l[] = "Deb";
                $l[] = utf8_decode($value->vencimento->nota->fornecedor->nome);
            }else{
                $l[] = "Cred";
                $l[] = utf8_decode($value->vencimento->nota->cliente->razao_social);
            }
            
            $l[] = utf8_decode($value->operacao->nome);
            $l[] = $value->valor."";
            $l[] = $value->juros."";
            $l[] = $value->descontos."";
            $l[] = $value->saldo_anterior."";
            $l[] = $value->vencimento->nota->numero;
            $l[] = $value->vencimento->nota->ficha;
            
            $valores[] = $l;
            
        }
        
        return Sistema::gerarRelatorio($con, $this->empresa, "Fechamento do banco $this->nome", $obs, $campos, $valores);
        
    }
    
    public function getFechamento($con){
        
        $anterior = 0;
        $data_anterior = 0;
        
        $ps = $con->getConexao()->prepare("SELECT valor,UNIX_TIMESTAMP(data)*1000 FROM fechamento_caixa WHERE id_banco=$this->id ORDER BY data DESC");
        $ps->execute();
        $ps->bind_result($valor,$data);
        if($ps->fetch()){
            $anterior = $valor;
            $data_anterior = $data;
        }
        $ps->close();
        $real_anterior = $anterior;
        
        $ps = $con->getConexao()->prepare("SELECT SUM((CASE WHEN operacao.debito THEN -1 ELSE 1 END)*(movimento.valor-movimento.descontos+movimento.juros)) FROM movimento "
                . "INNER JOIN operacao ON movimento.id_operacao=operacao.id "
                . "WHERE movimento.id_banco=$this->id AND movimento.data>FROM_UNIXTIME($data_anterior/1000)");
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
        $fechamento->data_anterior = $data_anterior;
        $fechamento->valor_anterior = $real_anterior;
        
        return $fechamento;
        
    }
    
    public function getCountMovimentosFechamento($con,$filtro2=""){
        
        $filtro = "";
        
        $ps = $con->getConexao()->prepare("SELECT MAX(data) FROM fechamento_caixa WHERE id_banco=$this->id");
        $ps->execute();
        $ps->bind_result($dt);
        if($ps->fetch()){
            if($dt !== null){
                $filtro .= "movimento.data>'$dt'";
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
        
        $filtro = "banco.id=$this->id";
        
        $ps = $con->getConexao()->prepare("SELECT MAX(data) FROM fechamento_caixa WHERE id_banco=$this->id");
        $ps->execute();
        $ps->bind_result($dt);
        if($ps->fetch()){
            if($dt !== null){
                $filtro .= " AND movimento.data>'$dt'";
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
