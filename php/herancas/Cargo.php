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
class Cargo {

    public $id;
    public $nome;
    public $empresa;
    public $excluido;

    function __construct() {

        $this->id = 0;
        $this->nome = "";
        $this->empresa = null;
        $this->excluido = false;
    }

    public function setPermissoes($con, $permissoes) {

        $resultado = array();

        foreach ($permissoes as $key => $value) {

            if ($value->in) {
                $resultado[] = array($value->id, 0);
            }
            if ($value->del) {
                $resultado[] = array($value->id, 1);
            }
            if ($value->alt) {
                $resultado[] = array($value->id, 2);
            }
            if ($value->cons) {
                $resultado[] = array($value->id, 3);
            }
        }


        $ps = $con->getConexao()->prepare("DELETE FROM cargo_permissao WHERE id_cargo=$this->id");
        $ps->execute();
        $ps->close();

        foreach ($resultado as $key => $value) {

            $ps = $con->getConexao()->prepare("INSERT INTO cargo_permissao(id_cargo,id_permissao,tipo) VALUES($this->id,$value[0],$value[1])");
            $ps->execute();
            $ps->close();
        }
    }

    public function getPermissoes($con) {

        $permissoes = array();

        $ps = $con->getConexao()->prepare("SELECT id_permissao,tipo FROM cargo_permissao WHERE id_cargo=$this->id");
        $ps->execute();
        $ps->bind_result($id_permissao, $tipo);
        while ($ps->fetch()) {

            if (!isset($permissoes[$id_permissao])) {

                $permissoes[$id_permissao] = array();
            }

            $permissoes[$id_permissao][$tipo] = true;
        }
        $ps->close();

        $todas_permissoes = Sistema::getPermissoes($this->empresa);

        $retorno = array();

        foreach ($todas_permissoes as $key => $value) {

            $cp = Utilidades::copy($value);
            
            if (isset($permissoes[$cp->id][0])) {
                $cp->in = true;
            }
            if (isset($permissoes[$cp->id][1])) {
                $cp->del = true;
            }
            if (isset($permissoes[$cp->id][2])) {
                $cp->alt = true;
            }
            if (isset($permissoes[$cp->id][3])) {
                $cp->cons = true;
            }
            
            $retorno[] = $cp;
            
            unset($cp);            

            
        }


        return $retorno;
        
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO cargo(nome,id_empresa,excluido) VALUES('" . addslashes($this->nome) . "'," . $this->empresa->id . ",false)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE cargo SET nome='" . addslashes($this->nome) . "',id_empresa=" . $this->empresa->id . ",excluido=false WHERE id=$this->id");
            $ps->execute();
            $ps->close();
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE cargo SET excluido=true WHERE id=$this->id");
        $ps->execute();
        $ps->close();
    }

}
