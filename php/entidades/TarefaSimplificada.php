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
    
    public function __construct() {
        
        $this->id = 0;
        $this->descricao = "";
        $this->empresa = null;
        $this->momento = round(microtime(true)*1000);
        $this->andamentos = array();
        $this->usuarios = array();
        $this->arquivos = array();
        
    }
    
    public function merge($con){
        
        if($this->id === 0){
            
            $ps = $con->getConexao()->prepare("INSERT INTO tarefa_simplificada(descricao,id_empresa,momento) VALUES('".addslahes($this->descricao)."',".$this->empresa->id.",FROM_UNIXTIME($this->momento/1000))");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE tarefa_simplificada SET descricao='".addslashes($descruicao)."', id_empresa=".$this->empresa->id.", momento=FROM_UNIXTIME($this->momento/1000) WHERE id=$this->id");
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
        
        $ps = $con->getConexao()->prepare("DELETE FROM andamento_tarefa_simplificada WHERE id_tarefa=$this->id");
        $ps->execute();
        $ps->close();
        
    }
    
}
