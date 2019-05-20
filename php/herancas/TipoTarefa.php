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
class TipoTarefa {

    public $id;
    public $nome;
    public $tempo_medio;
    public $prioridade;
    public $cargos;
    public $empresa;
    public $excluido;
    public $observacao_padrao;
    
    public $classes;

    function __construct($id = 0, $id_empresa = 0) {

        //pode ter ate 100 tarefas fixas
        if ($id_empresa > 0) {

            $id = -1 * (($id_empresa * 1000) + $id);
        }
        $this->classes = array();
        $this->id = $id;
        $this->nome = "";
        $this->tempo_medio = 1;
        $this->prioridade = 1;
        $this->empresa = null;
        $this->observacao_padrao = "";
        $this->excluido = false;
        $this->cargos = array();
    }

    public function init($tarefa) {
        
    }
    
    public function getOpcoes($con,$tarefa){
        
        return array();
        
    }

    public function getDados($tarefa,$nova = true) {

        $dados = array();

        foreach ($tarefa->observacoes as $key => $value) {
            if (!$value->cadastrada_agora && $nova) {
                continue;
            }
            $o = str_replace(array("<br>"), array(" "), $value->observacao);
            $o = explode("#", $o);
            foreach ($o as $k => $d) {
                $val = explode(":", $d, 2);
                if (count($val) < 2) {
                    continue;
                }
                $val2 = $val[1];
                $val = $val[0];
                if (strlen($val) === 0 || strlen($val2) === 0) {
                    continue;
                }
                while ($val2{0} === " ") {
                    $val2 = substr($val2, 1);
                }
                $dados[strtolower($val)] = $val2;
            }
        }

        return $dados;
    }

    protected function carregarDados() {

        $ses = new SessionManager();

        $obj = null;

        if (($obj = $ses->get("tipo_tarefa_" . $this->id)) !== null) {

            if (isset($obj->prioridade)) {
                $this->prioridade = $obj->prioridade;
            }
            if (isset($obj->tempo_medio)) {
                $this->tempo_medio = $obj->tempo_medio;
            }
            if (isset($obj->cargos)) {
                foreach ($obj->cargos as $key => $value) {
                    $k = false;
                    foreach ($this->cargos as $key2 => $cargo) {
                        if ($value->id === $cargo->id) {
                            $this->cargos[$key2] = $value;
                            $k = true;
                        }
                    }
                    if (!$k) {
                        $this->cargos[] = $value;
                    }
                }
            }
        } else {

            $obj = new stdClass();

            $con = new ConnectionFactory();
            $ps = $con->getConexao()->prepare("SELECT tempo_medio,prioridade FROM tipo_tarefa WHERE id=" . $this->id);
            $ps->execute();
            $ps->bind_result($tempo_medio, $prioridade);
            if ($ps->fetch()) {
                $obj->tempo_medio = $tempo_medio;
                $obj->prioridade = $prioridade;
            }
            $ps->close();

            $obj->cargos = array();
            $ps = $con->getConexao()->prepare("SELECT c.id,c.nome FROM tipo_tarefa_cargo tt INNER JOIN cargo c ON c.id=tt.id_cargo "
                    . "WHERE tt.id_tipo_tarefa=$this->id AND c.id>0");
            $ps->execute();
            $ps->bind_result($id, $nome);
            while ($ps->fetch()) {
                $c = new Cargo();
                $c->empresa = $this->empresa;
                $c->id = $id;
                $c->nome = $nome;
                $obj->cargos[] = $c;
            }
            $ps->close();
            if (isset($obj->prioridade)) {
                $this->prioridade = $obj->prioridade;
            }
            if (isset($obj->tempo_medio)) {
                $this->tempo_medio = $obj->tempo_medio;
            }
            if (isset($obj->cargos)) {
                foreach ($obj->cargos as $key => $cargo) {
                    $k = false;
                    foreach ($this->cargos as $key2 => $value) {
                        if ($value->id === $cargo->id) {
                            $this->cargos[$key2] = $cargo;
                            $k = true;
                        }
                    }
                    if (!$k) {
                        $this->cargos[] = $cargo;
                    }
                }
            }

            $ses->set("tipo_tarefa_" . $this->id, $obj);
        }
    }

    public function getObservacaoPadrao($tarefa) {

        return "";
    }

    public function aoAtribuir($id_usuario, $tarefa) {
        
    }

    public function aoFinalizar($tarefa, $usuario) {
        
    }

    public function merge($con) {


        $a = false;
        $ps = $con->getConexao()->prepare("SELECT id FROM tipo_tarefa WHERE id = $this->id");
        $ps->execute();
        $ps->bind_result($id);
        $a = $ps->fetch();
        $ps->close();

        if (!$a) {
            if ($this->id === 0) {
                $ps = $con->getConexao()->prepare("INSERT INTO tipo_tarefa(nome,tempo_medio,prioridade,id_empresa,excluido) VALUES('" . addslashes($this->nome) . "',$this->tempo_medio,$this->prioridade," . $this->empresa->id . ",false)");
                $ps->execute();
                $this->id = $ps->insert_id;
                $ps->close();
            } else {
                $ps = $con->getConexao()->prepare("INSERT INTO tipo_tarefa(id,nome,tempo_medio,prioridade,id_empresa,excluido) VALUES($this->id,'" . addslashes($this->nome) . "',$this->tempo_medio,$this->prioridade," . $this->empresa->id . ",false)");
                $ps->execute();
                $ps->close();
            }
        } else {

            $ps = $con->getConexao()->prepare("UPDATE tipo_tarefa SET nome='" . addslashes($this->nome) . "', tempo_medio=$this->tempo_medio,prioridade=$this->prioridade,id_empresa=" . $this->empresa->id . ", excluido=false WHERE id=$this->id");
            $ps->execute();
            $ps->close();
        }

        $ps = $con->getConexao()->prepare("DELETE FROM tipo_tarefa_cargo WHERE id_tipo_tarefa=$this->id");
        $ps->execute();
        $ps->close();

        foreach ($this->cargos as $key => $cargo) {

            $ps = $con->getConexao()->prepare("INSERT INTO tipo_tarefa_cargo(id_cargo,id_tipo_tarefa) VALUES($cargo->id,$this->id)");
            $ps->execute();
            $ps->close();
        }

        $ses = new SessionManager();
        $ses->deset("tipo_tarefa_$this->id");
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE tipo_tarefa SET excluido=true WHERE id=$this->id");
        $ps->execute();
        $ps->close();
    }

}
