<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProdutoCotacaoEntrada
 *
 * @author Renan
 */
class AndamentoTarefaSimplificada {

    public static $INICIO = 0;
    public static $PAUSE = 1;
    public static $FIM = 2;
    
    public $id;
    public $tarefa;
    public $usuario;
    public $momento;
    public $observacao;
    public $tipo;
    
    function __construct() {

        $this->id = 0;
        $this->tarefa = null;
        $this->usuario = null;
        $this->momento = round(microtime(true)*1000);
        $this->observacao = "";
        $this->tipo = 0;
        
    }

    public function merge($con){
        
        if($this->id === 0){
            $ps = $con->getConexao()->prepare("INSERT INTO andamento_tarefa_simplificada(tipo,momento,id_tarefa,id_usuario,observacao) VALUES($this->tipo,FROM_UNIXTIME($this->momento/1000),".$this->tarefa->id.",".$this->usuario->id.",'$this->observacao')");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        }else{
            $ps = $con->getConexao()->prepare("UPDATE andamento_tarefa_simplificada SET tipo=$this->tipo,momento=FROM_UNIXTIME($this->momento/1000),id_tarefa=".$this->tarefa->id.",id_usuario=".$this->usuario->id.",observacao='$this->observacao' WHERE id=$this->id");
            $ps->execute();
            $ps->close();
        }
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("DELETE FROM andamento_tarefa_simplificada WHERE id=$this->id");
        $ps->execute();
        $ps->close();
        
    }
    
}
