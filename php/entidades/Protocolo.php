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
class Protocolo {

    public $id;
    public $titulo;
    public $descricao;
    public $tipo;
    public $empresa;
    public $chat;
    public $tipo_entidade;
    public $id_entidade;
    public $inicio;
    public $fim;
    public $iniciado_por;
    public $precedente;

    public function __construct() {

        $this->id = 0;
        $this->titulo = "";
        $this->descricao = "";
        $this->tipo = null;
        $this->empresa = null;
        $this->chat = array();
        $this->inicio = round(microtime(true) * 1000);
        $this->fim = null;

        $this->id_entidade = 0;
        $this->tipo_entidade = 0;
        $this->iniciado_por = "";
    }
    
    public function init($con){
        
        if($this->tipo_entidade === "Cliente"){
            
            $ps = $con->getConexao()->prepare("SELECT razao_social FROM cliente WHERE id=$this->id_entidade");
            $ps->execute();
            $ps->bind_result($razao_social);
            if($ps->fetch()){
                $this->precedente = $razao_social;
            }
            $ps->close();
            
        }else if($this->tipo_entidade === "Pedido"){
            
            $ps = $con->getConexao()->prepare("SELECT p.id,c.razao_social FROM pedido p INNER JOIN cliente c ON c.id=p.id_cliente WHERE p.id=$this->id_entidade");
            $ps->execute();
            $ps->bind_result($pedido,$razao_social);
            if($ps->fetch()){
                $this->precedente = "Pedido: $pedido, do cliente: $razao_social";
            }
            $ps->close();
            
        }
        
    }

    public function getMensagensPosteriores($con, $ultimo_id = 0) {

        $retorno = array();
        
        foreach ($this->chat as $key => $value) {
            if ($value->id > $ultimo_id) {
                $ultimo_id = $value->id;
            }
        }

        $ps = $con->getConexao()->prepare("SELECT id,mensagem,UNIX_TIMESTAMP(momento)*1000,dados_usuario FROM mensagem_protocolo WHERE id_protocolo = $this->id AND id > $ultimo_id");
        $ps->execute();
        $ps->bind_result($id, $mensagem, $momento, $dados_usuario);
        while ($ps->fetch()) {

            $m = new MensagemProtocolo();
            $m->id = $id;
            $m->mensagem = $mensagem;
            $m->momento = $momento;
            $m->dados_usuario = $dados_usuario;
            $m->protocolo = $this;

            $this->chat[] = $m;

            $retorno[] = $m;
        }

        $ps->close();

        return $retorno;
    }

    public function terminar($con){
        
        $ps = $con->getConexao()->prepare("UPDATE protocolo SET inicio=inicio,fim=CURRENT_TIMESTAMP WHERE id=$this->id");
        $ps->execute();
        $ps->close();
        
    }
    
    public function delete($con) {

        $ps = $con->getConexao()->prepare("DELETE FROM protocolo WHERE id=$this->id");
        $ps->execute();
        $ps->close();
    }

    public function merge($con) {

        $inicio = $this->inicio;
        $fim = $this->fim;

        if ($inicio !== null) {
            $inicio /= 1000;
            $inicio = "FROM_UNIXTIME($inicio)";
        } else {
            $inicio = "null";
        }

        if ($fim !== null) {
            $fim /= 1000;
            $fim = "FROM_UNIXTIME($fim)";
        } else {
            $fim = "null";
        }

        if ($this->id === 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO protocolo(titulo,descricao,id_tipo,inicio,fim,tipo_entidade,id_entidade,id_empresa,iniciado_por) VALUES('" . addslashes($this->titulo) . "','" . addslashes($this->descricao) . "'," . $this->tipo->id . ",$inicio,$fim,'$this->tipo_entidade',$this->id_entidade," . $this->empresa->id . ",'$this->iniciado_por')");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE protocolo SET titulo='" . addslashes($this->titulo) . "',descricao='" . addslashes($this->descricao) . "',id_tipo=" . $this->tipo->id . ",inicio=$inicio,fim=$fim,tipo_entidade='$this->tipo_entidade',id_entidade=$this->id_entidade,id_empresa=" . $this->empresa->id . ",iniciado_por='$this->iniciado_por' WHERE id=$this->id");
            $ps->execute();
            $ps->close();
        }
    }

}
