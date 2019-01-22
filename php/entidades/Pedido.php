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
class Pedido {

    public $id;
    public $cliente;
    public $transportadora;
    public $frete;
    public $observacoes;
    public $frete_incluso;
    public $empresa;
    public $data;
    public $excluido;
    public $usuario;
    public $nota;
    public $prazo;
    public $parcelas;
    public $status;
    public $produtos; 
    public $forma_pagamento;
    
    function __construct() {

        $this->id = 0;
        $this->cliente = null;
        $this->transportadora = null;
        $this->frete = 0;
        $this->observacoes = "";
        $this->frete_incluso = "";
        $this->empresa = null;
        $this->data = round(microtime(true));
        $this->excluido = false;
        $this->usuario = null;
        $this->nota = null;
        $this->prazo = 0;
        $this->parcelas = 1;
        $this->status = null;
        $this->produtos = null;
        $this->forma_pagamento = null;
        
    }

    public function getProdutos($con){
        
        $ps = $con->getConexao()->prepare("SELECT campanha.id,campanha.inicio,campanha.fim,campanha.prazo,campanha.parcelas,campanha.cliente_expression");
        
    }
    
    public function atualizarCustos(){
        
        foreach($this->produtos as $key=>$value){
            
            $value->atualizarCustos();
            
        }
        
    }
    
    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO pedido(id_cliente,id_transportadora,frete,observacoes,frete_inclusao,id_empresa,data,excluido,id_usuario,id_nota,prazo,parcelas,id_status,id_forma_pagamento) VALUES(".$this->cliente->id.",".$this->transportadora->id.",$this->frete,'$this->observacoes',".($this->frete_incluso?"true":"false").",".$this->empresa->id.",FROM_UNIXTIME($this->data/1000),false,".$this->usuario->id.",".($this->nota===null?0:$this->nota->id).",$this->prazo,$this->parcelas,".$this->status->id.",".$this->forma_pagamento->id.")");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("INSERT INTO pedido(id_cliente,id_transportadora,frete,observacoes,frete_inclusao,id_empresa,data,excluido,id_usuario,id_nota,prazo,parcelas,id_status,id_forma_pagamento) VALUES(".$this->cliente->id.",".$this->transportadora->id.",$this->frete,'$this->observacoes',".($this->frete_incluso?"true":"false").",".$this->empresa->id.",FROM_UNIXTIME($this->data/1000),false,".$this->usuario->id.",".($this->nota===null?0:$this->nota->id).",$this->prazo,$this->parcelas,".$this->status->id.",".$this->forma_pagamento->id.")");
            $ps->execute();
            $ps->close();
            
        }
        
        $prods = $this->getProdutos($con);
        
        if($this->produtos == null){
            
            $this->produtos = $prods;
            
        }
        
        $erro = null;
        
        foreach($prods as $key=>$value){
            
            foreach($this->produtos as $key2=>$value2){
                
                if($value->id==$value2->id){
                    
                    continue 2;
                    
                }
                
            }
            
            $value->delete($con);
            
        }
        
        foreach($this->produtos as $key2=>$value2){
        
            $value2->merge($con);
                
        }
        
        if($erro !== null){
            
            throw new Exception($erro);
            
        }
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("UPDATE pedido SET excluido=true WHERE id = ".$this->id);
        $ps->execute();
        $ps->close();
        
        $this->status = Sistema::getStatusExcluidoPedidoSaida();
        
        $this->produtos = $this->getProdutos($con);
        
        $erro = null;
        
        foreach($this->produtos as $key=>$value){
            
            try{
            
                $value->merge($con);
            
            }catch(Exception $ex){
                
                $erro = $ex->getMessage().", produto cod: ".$value->id;
                
            }
            
        }

        throw new Exception($erro);
        
    }

}
