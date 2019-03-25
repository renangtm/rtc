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
class TTSuporteCliente extends TipoTarefa {

    function __construct($id_empresa) {

        parent::__construct(11, $id_empresa);

        $this->nome = "Suporte para Cliente";
        $this->tempo_medio = 0.2;
        $this->prioridade = 15;
        $this->cargos = array(
            Virtual::CF_ASSISTENTE_VIRTUAL_SUPORTE(new Empresa($id_empresa))
        );
    }

    public function aoAtribuir($id_usuario,$tarefa) {

        $con = new ConnectionFactory();
        $relacionamento = new RelacaoUsuarioCliente();
        $relacionamento->situacao = RelacaoUsuarioCliente::$QUARENTENA;
        $relacionamento->cliente = new stdClass();
        $relacionamento->cliente->id = $tarefa->id_entidade_relacionada;
        $relacionamento->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE usuario_cliente SET id_usuario=$id_usuario,data_inicio=data_inicio,data_fim=data_fim WHERE id=$relacionamento->id");
        $ps->execute();
        $ps->close();
    }
    
    public function aoFinalizar($usuario,$tarefa) {
        
        $ps = $con->getConexao()->prepare("UPDATE usuario_cliente SET data_inicio=data_inicio,data_fim=data_fim,situacao=".RelacaoUsuarioCliente::$QUARENTENA_PASSADA." WHERE id_usuario=$usuario->id AND id_cliente=$tarefa->id_entidade_relacionada");
        $ps->execute();
        $ps->close();
    
        
    }

}
