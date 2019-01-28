<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GrupoCidades
 *
 * @author Renan
 */
class GrupoCidades {

    public $id;
    public $nome;
    public $cidades;
    public $excluido;
    public $empresa;

    function __construct() {

        $this->id = 0;
        $this->empresa = null;
        $this->cidades = array();
        $this->excluido = false;
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO grupo_cidades(nome,id_empresa,excluido) VALUES('" . addslashes($this->nome) . "',".$this->empresa->id.",false)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE grupo_cidades SET nome = '" . addslashes($this->nome) . "', id_empresa=".$this->empresa->id.", excluido = false WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();
        }

        $ps = $con->getConexao()->prepare("DELETE FROM grupo_cidade WHERE id_grupo = " . $this->id);

        foreach ($this->cidades as $key => $value) {

            $ps = $con->getConexao()->prepare("INSERT INTO grupo_cidade(id_grupo,id_cidade) VALUES(" . $this->id . "," . $value->id . ")");
            $ps->execute();
            $ps->close();
        }
    }

    public static function cidadeEstaNoGrupo($nome_cidade, $nome_grupo) {

        $con = new ConnectionFactory();

        $ps = $con->getConexao()->prepare("SELECT c.id FROM grupo_cidades g INNER JOIN grupo_cidade gc ON gc.id_grupo=g.id INNER JOIN cidade c ON c.id=gc.id_cidade WHERE g.excluido=false AND c.nome like '$nome_cidade' AND g.nome like '$nome_grupo'");
        $ps->execute();
        $ps->bind_result($id);
        if ($ps->fetch()) {
            $ps->close();

            return true;
        }
        $ps->close();
        return false;
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE grupo_cidades SET excluido=true WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
