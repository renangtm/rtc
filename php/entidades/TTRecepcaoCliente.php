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

    function __construct($id_empresa) {

        parent::__construct(12, $id_empresa);

        $this->nome = "Recepcao de Cliente";
        $this->tempo_medio = 0.2;
        $this->prioridade = 10;
        $this->cargos = array(
            Virtual::CF_ASSISTENTE_VIRTUAL_RECEPCAO(new Empresa($id_empresa))
        );
    }

    public function aoAtribuir($id_usuario,$tarefa) {

        $con = new ConnectionFactory();
        $relacionamento = new RelacaoUsuarioCliente();
        $relacionamento->situacao = RelacaoUsuarioCliente::$RECEPCAO;
        $relacionamento->cliente = new stdClass();
        $relacionamento->cliente->id = $tarefa->id_entidade_relacionada;
        $relacionamento->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE usuario_cliente SET id_usuario=$id_usuario WHERE id=$relacionamento->id");
        $ps->execute();
        $ps->close();
    }

    public function aoFinalizar($tarefa) {
        
    }

}
