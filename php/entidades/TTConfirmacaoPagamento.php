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
class TTConfirmacaoPagamento extends TipoTarefa {

    function __construct($id_empresa) {

        parent::__construct(2, $id_empresa);

        $this->nome = "Confirmacao Pagamento";
        $this->tempo_medio = 0.2;
        $this->prioridade = 2;
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

                $emp = $pedido->empresa;
                if ($pedido->logistica !== null) {
                    $emp = $pedido->logistica;
                }

                $t = new Tarefa();
                $t->tipo_tarefa = Sistema::TT_SEPARACAO($empresa->id);
                $t->titulo = "Separacao do pedido $pedido->id";
                $t->descricao .= "<a style='font-size:20px;text-decoration:underline;color:SteelBlue' href='separacao.php?pedido=$this->id&empresa=" . $this->empresa->id . "'>SEPARAR PEDIDO</a>";
               
                $t->tipo_entidade_relacionada = "PED_" . $pedido->empresa->id;
                $t->id_entidade_relacionada = $pedido->id;
                Sistema::novaTarefaEmpresa($con, $t, $empresa);
                
            }
        }
    }

}
