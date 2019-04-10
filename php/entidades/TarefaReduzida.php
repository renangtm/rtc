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
class TarefaReduzida {

    public $id;
    public $inicio_minimo;
    public $porcentagem_conclusao;
    public $titulo;
    public $descricao;
    public $intervalos_execucao;
    public $observacoes;
    public $prioridade;
    public $tipo_tarefa;
    public $criada_por;
    public $assinatura_solicitante;
    public $calculado_previsao_util_conclusao; //calculado
    public $calculado_momento_conclusao; //calculado
    public $calculado_horas_uteis_dispendidas; //calculado
    public $calculado_horas_reais_dispendidas; //calculado
    public $calculado_tempo_util_faltante; //calculado
    public $calculado_previsao_inicio; //calculado
    public $id_empresa;
    public $nome_empresa;
    public $id_usuario;
    public $nome_usuario;

    public function __construct($tarefa) {


        $this->id = $tarefa->id;
        $this->inicio_minimo = $tarefa->inicio_minimo;
        $this->porcentagem_conclusao = $tarefa->porcentagem_conclusao;
        $this->titulo = $tarefa->titulo . "...";
        
        $this->descricao_resumida = substr($tarefa->descricao, 0, 50) . "...";


        $this->descricao = $tarefa->descricao;

        $this->intervalos_execucao = $tarefa->intervalos_execucao;
        $this->observacoes = array();//$tarefa->observacoes;
        $this->prioridade = $tarefa->prioridade;
        $this->tipo_tarefa = $tarefa->tipo_tarefa->nome;
        $this->criada_por = $tarefa->criada_por;
        $this->assinatura_solicitante = $tarefa->assinatura_solicitante;
        $this->calculado_previsao_util_conclusao = $tarefa->calculado_previsao_util_conclusao;
        $this->calculado_momento_conclusao = $tarefa->calculado_momento_conclusao;
        $this->calculado_horas_uteis_dispendidas = $tarefa->calculado_horas_uteis_dispendidas;
        $this->calculado_tempo_util_faltante = $tarefa->calculado_tempo_util_faltante;
        $this->calculado_previsao_inicio = $tarefa->calculado_previsao_inicio;

        if (isset($tarefa->id_empresa)) {
            $this->id_empresa = $tarefa->id_empresa;
        }

        if (isset($tarefa->nome_empresa)) {
            $this->nome_empresa = $tarefa->nome_empresa;
        }

        if (isset($tarefa->id_usuario)) {
            $this->id_usuario = $tarefa->id_usuario;
        }

        if (isset($tarefa->nome_usuario)) {
            $this->nome_usuario = $tarefa->nome_usuario;
        }
    }

}
