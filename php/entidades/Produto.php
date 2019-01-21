<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Fornecedor
 *
 * @author Renan
 */
class Produto {

    public $id;
    public $id_universal;
    public $nome;
    public $categoria;
    public $liquido;
    public $unidade;
    public $quantidade_unidade;
    public $excluido;
    public $habilitado;
    public $empresa;
    public $valor_base;
    public $custo;
    public $ncm;
    public $peso_liquido;
    public $peso_bruto;
    public $estoque;
    public $disponivel;
    public $transito;
    public $ofertas;
    public $grade;

    function __construct() {

        $this->id = 0;
        $this->id_universal = 0;
        $this->categoria = null;
        $this->liquido = false;
        $this->quantidade_unidade = 0;
        $this->excluido = false;
        $this->habilitado = true;
        $this->empresa = null;
        $this->valor_base = 0;
        $this->custo = 0;
        $this->peso_bruto = 0;
        $this->peso_liquido = 0;
        $this->estoque = 0;
        $this->disponivel = 0;
        $this->transito = 0;
        $this->grade = null;
        $this->ofertas = array();
    }

    public function merge($con) {

        if ($this->id == 0) {

            echo "INSERT INTO produto(id_universal,id_categoria,liquido,quantidade_unidade,excluido,habilitado,id_empresa,valor_base,custo,peso_bruto,peso_liquido,estoque,disponivel,transito,grade,unidade,ncm) VALUES($this->id_universal," . $this->categoria->id . "," . ($this->liquido ? "true" : "false") . ",$this->quantidade_unidade,false," . ($this->habilitado ? "true" : "false") . "," . $this->empresa->id . ",$this->valor_base,$this->custo,$this->peso_bruto,$this->peso_liquido,$this->estoque,$this->disponivel,$this->transito,'" . $this->grade->str . "','".addslashes($this->unidade)."','".addslashes($this->ncm)."')";
            
            $ps = $con->getConexao()->prepare("INSERT INTO produto(id_universal,id_categoria,liquido,quantidade_unidade,excluido,habilitado,id_empresa,valor_base,custo,peso_bruto,peso_liquido,estoque,disponivel,transito,grade,unidade,ncm) VALUES($this->id_universal," . $this->categoria->id . "," . ($this->liquido ? "true" : "false") . ",$this->quantidade_unidade,false," . ($this->habilitado ? "true" : "false") . "," . $this->empresa->id . ",$this->valor_base,$this->custo,$this->peso_bruto,$this->peso_liquido,$this->estoque,$this->disponivel,$this->transito,'" . $this->grade->str . "','".addslashes($this->unidade)."','".addslashes($this->ncm)."')");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE produto SET nome = '" . addslashes($this->nome) . "', id_universal=$this->id_universal, id_categoria=".$this->categoria->id.",liquido=".($this->liquido?"true":"false").", id_empresa=" . $this->empresa->id . ", valor_base=".$this->valor_base.",custo=$this->custo,peso_bruto=$this->peso_bruto,peso_liquido=$this->peso_liquido,estoque=$this->estoque,disponivel=$this->disponivel,transito=$this->transito,excluido=false,habilitado=".($this->habilitado?"true":"false").",grade='".$this->grade->str."',unidade='".addslashes($this->unidade)."',ncm='".addslashes($this->ncm)."',quantidade_unidade=$this->quantidade_unidade WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();
        }

    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE produto SET excluido = true WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
        
    }
    
    public function getLotes($con, $filtro=null, $ordem=null){
        
        $sql = "SELECT lote.id, UNIX_TIMESTAMP(lote.validade)*1000, UNIX_TIMESTAMP(lote.data_entrada)*1000, lote.quantidade_inicial, lote.grade, lote.quantidade_real, lote.codigo_fabricante, retirada.retirada FROM lote LEFT JOIN retirada ON lote.id=retirada.id_lote WHERE lote.excluido=false AND lote.id_produto=$this->id";
        if($filtro != null && $filtro!= ""){
            
            $sql .= " AND (".addslashes($filtro).")";
            
        }
        
        if($ordem!= null && $ordem != ""){
            
            $sql .= " ORDER BY ".addslashes($ordem);
            
        }
        
        $lotes = array();
        
        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id,$validade,$entrada,$quantidade_inicial,$grade,$quantidade_real,$codigo_fabricante,$retirada);
        
        while($ps->fetch()){
            
            if(!isset($lotes[$id])){

                $lote = new Lote();
                $lote->id = $id;
                $lote->validade = $validade;
                $lote->entrada = $entrada;
                $lote->quantidade_inicial = $quantidade_inicial;
                $lote->grade = new Grade($grade);
                $lote->quantidade_real = $quantidade_real;
                $lote->produto = $this;
                $lote->codigo_fabricante = $codigo_fabricante;
                
                $lotes[$id] = $lote;
                
            }
            
            if($retirada != null){
                
                $ret = explode(',', $retirada);
                foreach($ret as $key=>$value){
                    
                    $ret[$key] = intval($ret[$key]);
                    
                }
                
                $lotes[$id]->retiradas[] = $ret;
                
            }
            
        }
        
        $ps->close();
        
        $retorno = array();
        
        foreach($lotes as $key=>$value){
            
            $retorno[] = $value;
            
        }
        
        return $retorno;
        
    }

}
