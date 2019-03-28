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
    
    function __construct($id = 0, $id_empresa = 0) {

        //pode ter ate 100 tarefas fixas
        if ($id_empresa > 0) {

            $id = -1 * (($id_empresa * 1000) + $id);
        }

        $this->id = $id;
        $this->nome = "";
        $this->tempo_medio = 1;
        $this->prioridade = 1;
        $this->cargos = array();
        $this->empresa = null;
        $this->observacao_padrao = "";
        $this->excluido = false;
        
    }
    
    public function getObservacaoPadrao($tarefa){
        
        return "";
        
    }
    
    public function aoAtribuir($id_usuario,$tarefa) {
        
    }

    public function aoFinalizar($tarefa,$usuario) {
        
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
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE tipo_tarefa SET excluido=true WHERE id=$this->id");
        $ps->execute();
        $ps->close();
    }

}
