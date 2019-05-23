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
class ObservacaoTarefa {

    public $id;
    public $porcentagem;
    public $observacao;
    public $momento;
    public $excluida;
    
    public function __construct() {

        $this->id = 0;
        $this->porcentagem = 0;
        $this->observacao = '';
        $this->momento = round(microtime(true)*1000);
        $this->excluida = false;
        
    }
    
    public function merge($con){
        
        if($this->id === 0){
            
            $ps = $con->getConexao()->prepare("INSERT INTO observacao(porcentagem,observacao,momento,excluida) VALUES($this->porcentagem,'".addslashes($this->observacao)."',FROM_UNIXTIME($this->momento/1000),false)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE observacao SET porcentagem=$this->porcentagem,observacao='".addslashes($this->observacao)."',momento=FROM_UNIXTIME($this->momento/1000), excluida=false WHERE id=$this->id");
            $ps->execute();
            $ps->close();
            
        }
        
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("UPDATE observacao SET excluida=true WHERE id=$this->id");
        $ps->execute();
        $ps->close();
        
    }

}
