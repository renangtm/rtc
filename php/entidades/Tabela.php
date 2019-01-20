<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tabela
 *
 * @author Renan
 */
class Tabela {

    public $id;
    public $nome;
    public $regras;
    public $excluida;

    function __construct() {

        $this->regras = array();
        $this->excluida = false;
        $this->id = 0;
    }

    public function atende($cidade, $peso, $valor) {

        foreach ($this->regras as $key => $value) {

            if ($value->atende($cidade, $peso, $valor)) {

                return true;
            }
        }

        return false;
    }

    public function valor($cidade, $peso, $valor) {

        foreach ($this->regras as $key => $value) {

            if ($value->atende($cidade, $peso, $valor)) {

                return $value->valor($cidade, $peso, $valor);
            }
        }

        return 0;
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO tabela(nome,excluida) VALUES('" . addslashes($this->nome) . "',false)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE tabela SET nome = '" . addslashes($this->nome) . "', excluida=false WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();
        }

        $ps = $con->getConexao()->prepare("UPDATE regra_tabela SET id_tabela=0 WHERE id_tabela=" . $this->id);
        $ps->execute();
        $ps->close();

        foreach ($this->regras as $key => $value) {

            $value->merge($con);

            $ps = $con->getConexao()->prepare("UPDATE regra_tabela SET id_tabela=" . $this->id . " WHERE id=" . $value->id);
            $ps->execute();
            $ps->close();
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE tabela SET excluida=true WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();

        foreach ($this->regras as $key => $value) {

            $value->delete($con);
        }
    }

}
