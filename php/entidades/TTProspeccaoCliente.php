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
class TTProspeccaoDeCliente extends TipoTarefa {

    public $id_empresa;
    
    function __construct($id_empresa) {

        parent::__construct(9, $id_empresa);

        $this->id_empresa = $id_empresa;
        $this->nome = "Prospeccao de Cliente";
        $this->tempo_medio = 0.3;
        $this->prioridade = 5;
        $this->cargos = array(
            Virtual::CF_ASSISTENTE_VIRTUAL_PROSPECCAO(new Empresa($id_empresa))
        );
    }

    public function aoAtribuir($id_usuario, $tarefa) {

        $con = new ConnectionFactory();
        $relacionamento = new RelacaoUsuarioCliente();
        $relacionamento->situacao = RelacaoUsuarioCliente::$PROSPECCAO;
        $relacionamento->cliente = new stdClass();
        $relacionamento->cliente->id = $tarefa->id_entidade_relacionada;
        $relacionamento->merge($con);
        
        $ps = $con->getConexao()->prepare("UPDATE usuario_cliente SET id_usuario=$id_usuario WHERE id=$relacionamento->id");
        $ps->execute();
        $ps->close();
        
    }

    public function aoFinalizar($tarefa) {
        
        $con = new ConnectionFactory();
        
        $tarefa_ = new Tarefa();
        $tarefa_->tipo_tarefa = Sistema::TT_RECEPCAO_CLIENTE($this->id_empresa);
        $tarefa_->titulo = "Recepcao de Cliente";
        $tarefa_->descricao = "Recepcione o cliente ".$tarefa->id_entidade_relacionada." para o RTC ";
        $tarefa_->id_entidade_relacionada = $tarefa->id_entidade_relacionada;
        $tarefa_->tipo_entidade_relacionada = $tarefa->tipo_entidade_relacionada;
        
        Sistema::novaTarefaEmpresa(new ConnectionFactory(), $tarefa_, new Virtual($this->id_empresa,$con));
        
        $ps = $con->getConexao()->prepare("UPDATE usuario_cliente SET data_inicio=data_inicio, data_fim=CURRENT_TIMESTAMP WHERE id_cliente=$tarefa->id_entidade_relacionada AND situacao=".RelacaoUsuarioCliente::$RECEPCAO);
        $ps->execute();
        $ps->close();
        
    }

}
