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
class TTSolicitacaoColeta extends TipoTarefa {

    function __construct($id_empresa) {

        parent::__construct(27, $id_empresa);

        $this->nome = "Solicitacao Coleta";
        $this->tempo_medio = 0.2;
        $this->prioridade = 2;
        $this->cargos = array(
            Empresa::CF_ESTAGIARIO_LOGISTICA($id_empresa)
        );
        $this->carregarDados();
    }

    public function aoFinalizar($tarefa, $usuario) {

        $con = new ConnectionFactory();

        $pt = explode("_", $tarefa->tipo_entidade_relacionada);
        if (count($pt) === 2) {
            if ($pt[0] === "PED") {

                $id_empresa = intval($pt[1]);
                $empresa = new Empresa($id_empresa, $con);
                $pedido = $empresa->getPedidos($con, 0, 1, "pedido.id=$tarefa->id_entidade_relacionada");
                $pedido = $pedido[0];

                $pedido->status = Sistema::STATUS_RASTREIO();
                $pedido->merge($con);

                $emp = $pedido->empresa;
                if ($pedido->logistica !== null) {
                    $emp = $pedido->logistica;
                }

                $t = new Tarefa();
                $t->tipo_tarefa = Sistema::TT_RASTREIO($emp->id);
                $t->titulo = "Rastreio do pedido $pedido->id";
                $t->descricao = "Rastreamento com a transportadora '" . $pedido->transportadora->razao_social . "', referente ao pedido $pedido->id";
                $t->tipo_entidade_relacionada = "PED_" . $pedido->empresa->id;
                $t->id_entidade_relacionada = $pedido->id;
                Sistema::novaTarefaEmpresa($con, $t, $emp);
            }
        }
    }

}
