<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cliente
 *
 * @author Renan
 */
class Cliente {
    
    public $id;
    public $razao_social;
    public $nome_fantasia;
    public $email;
    public $limite_credito;
    public $termino_limite;
    public $inicio_limite;
    public $pessoa_fisica;
    public $cpf;
    public $cnpj;
    public $rg;
    public $inscricao_estadual;
    public $telefone;
    public $endereco;
    public $suframado;
    public $inscricao_suframa;
    public $empresa;
    public $categoria_cliente;
    
    function __construct() {
        
        $this->id = 0;
        $this->email = new Email("");
        $this->cpf = new CPF("");
        $this->cnpj = new CNPJ("");
        $this->rg = new RG("");
        $this->endereco = null;
        $this->empresa = null;
        $this->categoria_cliente = null;
        
        $this->excluido = false;
        $this->suframado = false;
        
        $this->inicio_limite = round(microtime(true)*1000);
        $this->termino_limite = round(microtime(true)*1000);
        
    }
    
    public function merge($con) {
        
        $this->categoria->merge($con);

        if ($this->id == 0) {
            
            $ps = $con->getConexao()->prepare("INSERT INTO cliente(razao_social,nome_fantasia,limite_credito,inicio_limite,termino_limite,pessoa_fisica,cpf,rg,cnpj,excluido,id_categoria,id_empresa,telefone,inscricao_estadual,suframado,inscricao_suframa) VALUES('".addslashes($this->razao_social)."','".addslashes($this->nome_fantasia)."','$this->limite_credito',FROM_UNIXTIME($this->inicio_limite/1000),FROM_UNIXTIME($this->termino_limite/1000),".($this->pessoa_fisica?"true":"false").",'".addslashes($this->cpf->valor)."','".addslashes($this->rg->valor)."','".$this->cnpj->valor."',false,".$this->categoria->id.",".$this->empresa->id.",'".addslashes($this->telefone)."','$this->inscricao_estadual',".($this->suframado?"true":"false").",'".addslashes($this->inscricao_suframa)."')");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{

            $ps = $con->getConexao()->prepare("UPDATE cliente SET razao_social='".addslashes($this->razao_social)."', nome_fantasia='".addslashes($this->nome_fantasia)."', limite_credito=$this->limite_credito, inicio_limite=FROM_UNIXTIME($this->inicio_limite/1000), termino_limite=FROM_UNIXTIME($this->termino_limite/1000), pessoa_fisica=".($this->pessoa_fisica?"true":"false").", cpf='".addslashes($this->cpf->valor)."', rg='".addslashes($this->rg->valor)."', cnpj='".addslashes($this->cnpj->valor)."', excluido= false, id_categoria=".$this->categoria->id.", id_empresa=".$this->empresa->id.", telefone='".addslashes($this->telefone)."', inscricao_estadual='".addslashes($this->inscricao_estadual)."',suframado=".($this->suframado?"true":"false").", inscricao_suframa='$this->inscricao_suframa' WHERE id = ".$this->id);
            $ps->execute();
            $ps->close();
            
        }
        
        $this->endereco->merge($con);
        
        $ps = $con->getConexao()->prepare("UPDATE endereco SET tipo_entidade='CLI', id_entidade=$this->id WHERE id=".$this->endereco->id);
        $ps->execute();
        $ps->close();
        
        $this->email->merge($con);
        
        $ps = $con->getConexao()->prepare("UPDATE email SET tipo_entidade='CLI', id_entidade=$this->id WHERE id=".$this->email->id);
        $ps->execute();
        $ps->close();
        
    }
    
    public function setDocumentos($docs,$con){
        
        $ps = $con->getConexao()->prepare("UPDATE documento SET id_entidade=0 WHERE tipo_entidade='CLI' AND id_entidade=$this->id");
        $ps->execute();
        $ps->close();
        
        foreach($docs as $key=>$doc){
        
            $doc->merge($con);

            $ps = $con->getConexao()->prepare("UPDATE documento SET tipo_entidade='CLI', id_entidade=$this->id WHERE id=$doc->id");
            $ps->execute();
            $ps->close();

        }
        
    }
    
    public function getDocumentos($con){
        
        $categorias_documento = Sistema::getCategoriaDocumentos();
        
        $docs = array();
        
        $ps = $con->getConexao()->prepare("SELECT id,UNIX_TIMESTAMP(data_insercao)*1000,id_categoria,numero,link FROM documento WHERE tipo_entidade='CLI' AND id_entidade=$this->id AND excluido=false");
        $ps->execute();
        $ps->bind_result($id,$data,$id_categoria,$numero,$link);
        
        while($ps->fetch()){
            
            $d = new Documento();
            
            $d->id = $id;
            $d->data_insercao = $data;
            $d->numero = $numero;
            $d->link = $link;
            
            foreach($categorias_documento as $key=>$value){
                if($value->id==$id_categoria){
                    
                    $d->categoria = $value;
                    
                    $docs[] = $d;
                    
                    continue 2;
                    
                }
            }
            
        }
        
        $ps->close();
        
        return $docs;
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("UPDATE cliente SET excluido=true WHERE id = ".$this->id);
        $ps->execute();
        $ps->close();
        
    }
    
}
