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
class Usuario {

    public $id;
    public $nome;
    public $email;
    public $telefone;
    public $endereco;
    public $cpf;
    public $excluido;
    public $empresa;
    public $login;
    public $senha;
    public $permissoes;

    function __construct() {

        $this->id = 0;
        $this->email = null;
        $this->telefone = "";
        $this->endereco = null;
        $this->excluido = false;
        $this->cpf = new CPF("");
        $this->empresa = null;
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO usuario(login,senha,nome,cpf,telefone,excluido,id_empresa) VALUES('" . addslashes($this->login) . "','" . addslashes($this->senha) . "','" . addslashes($this->nome) . "','" . $this->cpf->valor . "','" . $this->telefone . "',false," . $this->empresa->id . ")");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE usuario SET login='" . addslashes($this->login) . "',senha='" . addslashes($this->senha) . "', nome = '" . addslashes($this->nome) . "', cpf='" . $this->cpf->valor . "', telefone='" . $this->telefone . "',excluido=false, id_empresa=" . $this->empresa->id . " WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();
        }

        $this->email->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE email SET id_entidade=" . $this->id . ", tipo_entidade='USU' WHERE id = " . $this->email->id);
        $ps->execute();
        $ps->close();

        $this->endereco->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE endereco SET id_entidade=" . $this->id . ", tipo_entidade='USU' WHERE id = " . $this->endereco->id);
        $ps->execute();
        $ps->close();

        $ps = $con->getConexao()->prepare("DELETE FROM usuario_permissao WHERE id_usuario=$this->id");
        $ps->execute();
        $ps->close();

        foreach ($this->permissoes as $key => $value) {

            $in = ($value->in ? "true" : "false");
            $del = ($value->del ? "true" : "false");
            $alt = ($value->alt ? "true" : "false");
            $cons = ($value->cons ? "true" : "false");

            $ps = $con->getConexao()->prepare("INSERT INTO usuario_permissao(id_usuario,id_permissao,incluir,deletar,alterar,consultar) VALUES($this->id,$value->id,$in,$del,$alt,$cons)");
            $ps->execute();
            $ps->close();
        }
    }

    public function temPermissao($nome,$tipo){
        
        foreach($this->permissoes as $key=>$value){
            
            if($value->nome == $nome){
                
                return $value->$tipo === true;
                
            }
            
        }
        
        return false;
        
    }
    
    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE usuario SET excluido = true WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
