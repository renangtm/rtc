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
class Tarefa {

    public $id;
    public $inicio_minimo;
    public $ordem;
    public $porcentagem_conclusao;
    public $tipo_entidade_relacionada;
    public $id_entidade_relacionada;
    public $titulo;
    public $descricao;
    public $intervalos_execucao;
    public $observacoes;
    public $realocavel;
    public $excluida;
    public $prioridade; // geralmente vai ser o mesmo do tipo da tarefa porem usuarios com permissoes elevadas poderao alterar.
    public $tipo_tarefa;
    public $calculado_previsao_util_conclusao; //calculado
    public $calculado_momento_conclusao; //calculado
    public $calculado_horas_uteis_dispendidas; //calculado
    public $calculado_horas_reais_dispendidas; //calculado
    public $calculado_tempo_util_faltante; //calculado
    public $calculado_previsao_inicio; //calculado
    
    public function __construct() {

        $this->id = 0;
        $this->prioridade = 1;
        $this->tipo_tarefa = null;
        $this->inicio_minimo = round(microtime(true) * 1000);
        $this->ordem = 0;
        $this->porcentagem_conclusao = 0;
        $this->tipo_entidade_relacionada = '';
        $this->id_entidade_relacionada = 0;
        $this->titulo = '';
        $this->descricao = '';
        $this->intervalos_execucao = array();
        $this->observacoes = array();
        $this->realocavel = false;
        $this->excluida = false;

        $this->calculado_momento_conclusao = 0;
        $this->calculado_previsao_util_conclusao = 0;
        $this->calculado_horas_uteis_dispendidas = 0;
        $this->calculado_horas_reais_dispendidas = 0;
        $this->calculado_tempo_util_faltante = 0;
        $this->calculado_previsao_inicio = 0;
        
    }

    public function addObservacao($con, $usuario, $observacao) {

        $observacao->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE observacao SET id_tarefa=$this->id,momento=momento WHERE id=$observacao->id");
        $ps->execute();
        $ps->close();

        $porcentagem = $observacao->porcentagem + $this->porcentagem_conclusao;
        $inicio = $this->inicio_minimo;
        $this->porcentagem_conclusao = $porcentagem;

        $ps = $con->getConexao()->prepare("SELECT UNIX_TIMESTAMP(ultima_execucao)*1000 FROM usuario WHERE id=$usuario->id");
        $ps->execute();
        $ps->bind_result($ue);
        if ($ps->fetch()) {
            if ($ue > 0) {
                $inicio = $ue;
            }
        }
        $ps->close();

        $intervalo = array($inicio, $observacao->momento);
        $this->intervalos_execucao[] = $intervalo;

        $ps = $con->getConexao()->prepare("UPDATE usuario SET ultima_execucao=FROM_UNIXTIME($observacao->momento/1000) WHERE id=$usuario->id");
        $ps->execute();
        $ps->close();

        $intervalos = "";

        foreach ($this->intervalos_execucao as $key => $value) {
            $intervalos .= $value[0] . "@" . $value[1] . ";";
        }

        $ps = $con->getConexao()->prepare("UPDATE tarefa SET intervalos_execucao='$intervalos',inicio_minimo=inicio_minimo,porcentagem_conclusao=$porcentagem WHERE id=$this->id");
        $ps->execute();
        $ps->close();
        
        if($this->porcentagem_conclusao >= 100){

            $this->tipo_tarefa->aoFinalizar($this,$usuario);
            
        }
        
    }

    public function merge($con) {

        $intervalos = "";

        foreach ($this->intervalos_execucao as $key => $value) {
            $intervalos .= $value[0] . "@" . $value[1] . ";";
        }

        if ($this->id === 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO tarefa(inicio_minimo,ordem,porcentagem_conclusao,tipo_entidade_relacionada,id_entidade_relacionada,titulo,descricao,intervalos_execucao,realocavel,excluida,prioridade,id_tipo_tarefa) VALUES(FROM_UNIXTIME($this->inicio_minimo/1000),$this->ordem,$this->porcentagem_conclusao,'$this->tipo_entidade_relacionada',$this->id_entidade_relacionada,'" . addslashes($this->titulo) . "','" . addslashes($this->descricao) . "','$intervalos'," . ($this->realocavel ? "true" : "false") . ",false,$this->prioridade," . $this->tipo_tarefa->id . ")");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE tarefa SET inicio_minimo=FROM_UNIXTIME($this->inicio_minimo/1000),ordem=$this->ordem,porcentagem_conclusao=$this->porcentagem_conclusao,tipo_entidade_relacionada='$this->tipo_entidade_relacionada',id_entidade_relacionada=$this->id_entidade_relacionada,titulo='" . addslashes($this->titulo) . "',descricao='" . addslashes($this->descricao) . "',intervalos_execucao='$intervalos',realocavel=" . ($this->realocavel ? "true" : "false") . ",excluida=false,prioridade=$this->prioridade,id_tipo_tarefa=" . $this->tipo_tarefa->id . " WHERE id=$this->id");
            $ps->execute();
            $ps->close();
        }

        $ps = $con->getConexao()->prepare("UPDATE observacao SET id_tarefa=0 WHERE id_tarefa=$this->id");
        $ps->execute();
        $ps->close();

        foreach ($this->observacoes as $key => $value) {

            $value->merge($con);

            $ps = $con->getConexao()->prepare("UPDATE observacao SET id_tarefa=$this->id WHERE id=$value->id");
            $ps->execute();
            $ps->close();
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE tarefa SET excluida=true,inicio_minimo=inicio_minimo WHERE id=$this->id");
        $ps->execute();
        $ps->close();
    }

}
