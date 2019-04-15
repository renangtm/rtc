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
class TTVerificaSuframa extends TipoTarefa {

    function __construct($id_empresa) {

        parent::__construct(23, $id_empresa);

        $this->nome = "Verificar Suframa";
        $this->tempo_medio = 0.2;
        $this->prioridade = 2;
        $this->cargos = array(
            Empresa::CF_FATURISTA($id_empresa)
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
                
                $pedido->status = Sistema::STATUS_FATURAMENTO();
                $pedido->merge($con);

                $emp = $pedido->empresa;
                if ($pedido->logistica !== null) {
                    $emp = $pedido->logistica;
                }

                $t = new Tarefa();
                $t->tipo_tarefa = Sistema::TT_FATURAMENTO($emp->id);
                $t->titulo = "Faturamento do pedido $pedido->id";

                if ($pedido->logistica !== null) {
                    $t->descricao = "Acompanhe o faturamento da nota do pedido </strong>$pedido->id</strong> da empresa <strong>'" .
                            $pedido->empresa->nome . "', verificando se esta faturada e fazendo possiveis ajustes para faturar, </strong> para o cliente <strong>'" .
                            $pedido->cliente->razao_social . "'</strong><br>, e tambem o da nota de retorno da <strong>'" .
                            $pedido->logistica->nome . "'</strong> para a <strong>'" . $pedido->empresa->nome . "'</strong>";
                } else {
                    $t->descricao = "Acompanhe o faturamento da nota do pedido <strong>$pedido->id</strong>, para o cliente <strong>" .
                            $pedido->cliente->razao_social .
                            "</strong>";
                }

                $t->tipo_entidade_relacionada = "PED_" . $pedido->empresa->id;
                $t->id_entidade_relacionada = $pedido->id;
                Sistema::novaTarefaEmpresa($con, $t, $emp);

                
            }
        }
    }

}
