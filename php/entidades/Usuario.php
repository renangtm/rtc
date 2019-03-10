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
    public $telefones;
    public $endereco;
    public $cpf;
    public $excluido;
    public $empresa;
    public $login;
    public $senha;
    public $rg;
    public $permissoes;

    function __construct() {

        $this->id = 0;
        $this->email = null;
        $this->telefones = array();
        $this->endereco = new Endereco();
        $this->excluido = false;
        $this->cpf = new CPF("");
        $this->rg = new RG("");
        $this->email = new Email("");
        $this->empresa = null;
        $this->permissoes = array();
    }

    public function merge($con) {


        $ps = $con->getConexao()->prepare("SELECT id FROM usuario WHERE (cpf='" . $this->cpf->valor . "' OR login='$this->login') AND id <> $this->id AND id_empresa=".$this->empresa->id);
        $ps->execute();
        $ps->bind_result($id);
        if ($ps->fetch()) {
            $ps->close();
            throw new Exception("Ja existe um usuario com os mesmos dados $id");
        }
        $ps->close();

        if ($this->id == 0) {
            $ps = $con->getConexao()->prepare("INSERT INTO usuario(login,senha,nome,cpf,excluido,id_empresa,rg) VALUES('" . addslashes($this->login) . "','" . addslashes($this->senha) . "','" . addslashes($this->nome) . "','" . $this->cpf->valor . "',false," . $this->empresa->id . ",'" . addslashes($this->rg->valor) . "')");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {
            $ps = $con->getConexao()->prepare("UPDATE usuario SET login='" . addslashes($this->login) . "',senha='" . addslashes($this->senha) . "', nome = '" . addslashes($this->nome) . "', cpf='" . $this->cpf->valor . "',excluido=false, id_empresa=" . $this->empresa->id . ",rg='" . addslashes($this->rg->valor) . "' WHERE id = " . $this->id);
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

        $ps = $con->getConexao()->prepare("DELETE FROM usuario_permissao WHERE id_usuario=$this->id AND incluir=false AND deletar=false AND alterar=false AND consultar=false");
        $ps->execute();
        $ps->close();

        $tels = array();
        $ps = $con->getConexao()->prepare("SELECT id,numero FROM telefone WHERE tipo_entidade='USU' AND id_entidade=$this->id AND excluido=false");
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

            $ps = $con->getConexao()->prepare("UPDATE telefone SET tipo_entidade='USU', id_entidade=$this->id WHERE id=" . $value->id);
            $ps->execute();
            $ps->close();
        }
    }

    public function temPermissao($p) {
        
        foreach ($this->permissoes as $key => $value) {

            if ($value->nome == $p->nome) {

                if ($p->in && !$value->in) {
                    return false;
                } else if ($p->del && !$value->del) {
                    return false;
                } else if ($p->alt && !$value->alt) {
                    return false;
                } else if ($p->cons && !$value->cons) {
                    return false;
                }else{
                    
                    foreach($this->empresa->rtc->permissoes as $key2=>$value2){
                        if($value2->id === $value->id){
                            return true;
                        }
                    }
                    
                    return false;
                }
                
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
