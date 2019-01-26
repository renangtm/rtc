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
class Fornecedor {
    
    public $id;
    public $nome;
    public $email;
    public $telefones;
    public $endereco;
    public $cnpj;
    public $excluido;
    public $empresa;
    
    function __construct() {
        
        $this->id = 0;
        $this->email = null;
        $this->telefones = array();
        $this->endereco = null;
        $this->excluido = false;
        $this->cnpj = new CNPJ("");
        $this->empresa = null;
        
    }
    
    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO fornecedor(nome,cnpj,excluido,id_empresa) VALUES('" . addslashes($this->nome) . "','".$this->cnpj->valor."',false,".$this->empresa->id.")");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE fornecedor SET nome = '" . addslashes($this->nome) . "', cnpj='".$this->cnpj->valor."',excluido=false, id_empresa=".$this->empresa->id." WHERE id = ".$this->id);
            $ps->execute();
            $ps->close();
            
        }
        
        $this->email->merge($con);
        
        $ps = $con->getConexao()->prepare("UPDATE email SET id_entidade=".$this->id.", tipo_entidade='FOR' WHERE id = ".$this->email->id);
        $ps->execute();
        $ps->close();
        
        $this->endereco->merge($con);
        
        $ps = $con->getConexao()->prepare("UPDATE endereco SET id_entidade=".$this->id.", tipo_entidade='FOR' WHERE id = ".$this->endereco->id);
        $ps->execute();
        $ps->close();
        
        $tels = array();
        $ps = $con->getConexao()->prepare("SELECT id,numero FROM telefone WHERE tipo_entidade='FOR' AND id_entidade=$this->id AND excluido=false");
        $ps->execute();
        $ps->bind_result($idt, $numerot);
        while ($ps->fetch()) {
            $t = new Telefone($numerot);
            $t->id = $idt;
            $tels[] = $t;
        }

        foreach ($tels as $key => $value) {

            foreach ($this->telefones as $key2 => $value2) {

                if ($value->id == $value2->id) {

                    continue 2;
                }
            }

            $value->delete($con);
        }

        foreach ($this->telefones as $key => $value) {

            $value->merge($con);
            
            $ps = $con->getConexao()->prepare("UPDATE telefone SET tipo_entidade='FOR', id_entidade=$this->id WHERE id=" . $value->id);
            $ps->execute();
            $ps->close();

        }
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("UPDATE fornecedor SET excluido = true WHERE id = ".$this->id);
        $ps->execute();
        $ps->close();
        
    }
    
    
    
}
