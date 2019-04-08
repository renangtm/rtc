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
class TTRecepcaoCliente extends TipoTarefa {

    public $id_empresa;
    
    function __construct($id_empresa) {

        parent::__construct(12, $id_empresa);
        
        $this->id_empresa = $id_empresa;

        $this->nome = "Recepcao de Cliente";
        $this->tempo_medio = 0.2;
        $this->prioridade = 10;
        $this->cargos = array(
            Virtual::CF_ASSISTENTE_VIRTUAL_RECEPCAO(new Empresa($id_empresa))
        );
        $this->carregarDados();
    }

    public function aoAtribuir($id_usuario,$tarefa) {

        $con = new ConnectionFactory();
        $relacionamento = new RelacaoUsuarioCliente();
        $relacionamento->situacao = RelacaoUsuarioCliente::$RECEPCAO;
        $relacionamento->cliente = new stdClass();
        $relacionamento->cliente->id = $tarefa->id_entidade_relacionada;
        $relacionamento->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE usuario_cliente SET id_usuario=$id_usuario,data_inicio=data_inicio,data_fim=data_fim WHERE id=$relacionamento->id");
        $ps->execute();
        $ps->close();
    }

    public function aoFinalizar($tarefa,$usuario) {
        
        $con = new ConnectionFactory();
        
        $tarefa_ = new Tarefa();
        $tarefa_->tipo_tarefa = Sistema::TT_SUPORTE_CLIENTE($this->id_empresa);
        $tarefa_->titulo = "Suporte ao Cliente";
        $tarefa_->descricao = "Preste suporte ao cliente ".$tarefa->id_entidade_relacionada." para o RTC ";
        $tarefa_->id_entidade_relacionada = $tarefa->id_entidade_relacionada;
        $tarefa_->tipo_entidade_relacionada = $tarefa->tipo_entidade_relacionada;
        
        $tamanho = 0;
        
        foreach($tarefa->observacoes as $key=>$value){
            $tamanho += strlen($value->observacao);
        }
        
        $pontos = ($tamanho>500)?3:($tamanho>200?2:1);
        $atividade = $usuario->getAtividadeUsuarioClienteAtual($con);
        $atividade->pontos_atendimento += $pontos;
        $atividade->merge($con);
        
        Sistema::novaTarefaEmpresa($con, $tarefa_, new Virtual($this->id_empresa,$con));
        
        $ps = $con->getConexao()->prepare("UPDATE usuario_cliente SET data_inicio=data_inicio, data_fim=data_fim,situacao=".RelacaoUsuarioCliente::$RECEPCAO_INATIVA." WHERE id_usuario=$usuario->id AND id_cliente=$tarefa->id_entidade_relacionada");
        $ps->execute();
        $ps->close();
        
    }

}
