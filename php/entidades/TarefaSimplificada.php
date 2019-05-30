<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, 
 * and open the template in the editor.
 */
/**
 * Description of Baixo
 *
 * @author Renan
 */
class TarefaSimplificada{
    
    public $id;
    public $descricao;
    public $empresa;
    public $momento;
    public $andamentos;
    public $usuarios;
    public $arquivos;
    public $tipo;
    public $prioridade;
    public $prioridade_real;
    
    public function __construct() {
        
        $this->id = 0;
        $this->descricao = "";
        $this->empresa = null;
        $this->momento = round(microtime(true)*1000);
        $this->andamentos = array();
        $this->usuarios = array();
        $this->arquivos = array();
        $this->tipo = null;
        $this->prioridade = 0;
        $this->prioridade_real = 0;
        
    }
    
    public function merge($con){
                
        $this->prioridade = round($this->tipo->prioridade*($this->prioridade_real/100));
        
        if($this->id === 0){
            
            $ps = $con->getConexao()->prepare("INSERT INTO tarefa_simplificada(descricao,id_empresa,momento,id_tipo_tarefa,prioridade) VALUES('".addslashes($this->descricao)."',".$this->empresa->id.",FROM_UNIXTIME($this->momento/1000),".$this->tipo->id.",$this->prioridade)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE tarefa_simplificada SET descricao='".addslashes($this->descricao)."', id_empresa=".$this->empresa->id.", momento=FROM_UNIXTIME($this->momento/1000), id_tipo_tarefa=".$this->tipo->id.",prioridade=$this->prioridade WHERE id=$this->id");
            $ps->execute();
            $ps->close();
            
        }
        
        $ps = $con->getConexao()->prepare("DELETE FROM arquivo_tarefa_simplificada WHERE id_tarefa=$this->id");
        $ps->execute();
        $ps->close();
        
        foreach($this->arquivos as $key=>$value){
            
            $ps = $con->getConexao()->prepare("INSERT INTO arquivo_tarefa_simplificada(link,id_tarefa) VALUES('$value',$this->id)");
            $ps->execute();
            $ps->close();
            
        }
        
        
        $ids_andamentos = "(-1";
        
        foreach($this->andamentos as $key=>$value){
            
            $ids_andamentos .= ",$value->id";
            
        }
        
        $ids_andamentos .= ")";
        
        $ps = $con->getConexao()->prepare("DELETE FROM andamento_tarefa_simplificada WHERE id_tarefa=$this->id AND id NOT IN $ids_andamentos");
        $ps->execute();
        $ps->close();
        
        foreach($this->andamentos as $key=>$value){
            
            $value->merge($con);
            
        }
        
        $ps = $con->getConexao()->prepare("DELETE FROM usuario_tarefa_simplificada WHERE id_tarefa=$this->id");
        $ps->execute();
        $ps->close();
        
        foreach($this->usuarios as $key=>$value){
            
            $ps = $con->getConexao()->prepare("INSERT INTO usuario_tarefa_simplificada(id_tarefa,id_usuario) VALUES($this->id,$value->id)");
            $ps->execute();
            $ps->close();
            
        }
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("DELETE FROM tarefa_simplificada WHERE id=$this->id");
        $ps->execute();
        $ps->close();
        
    }
    
}