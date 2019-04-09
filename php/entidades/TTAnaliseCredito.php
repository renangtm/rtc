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
class TTAnaliseCredito extends TipoTarefa {

    function __construct($id_empresa) {

        parent::__construct(22, $id_empresa);

        $this->nome = "Analise de Credito";
        $this->tempo_medio = 0.2;
        $this->prioridade = 2;
        $this->carregarDados();
    }

    public function aoFinalizar($tarefa, $usuario) {

        $con = new ConnectionFactory();

        $pt = explode("_", $tarefa->tipo_entidade_relacionada);
        if (count($pt) === 2) {
            if ($pt[0] === "PED") {
                $passou = false;
                $id_empresa = intval($pt[1]);
                $empresa = new Empresa($id_empresa, $con);
                $pedido = $empresa->getPedidos($con, 0, 1, "pedido.id=$tarefa->id_entidade_relacionada");
                $pedido = $pedido[0];
                if ($pedido->prazo < 3) {
                    $passou = true;
                } else {
                    $limite = $pedido->cliente->getLimiteCredito();
                    $divida = $pedido->cliente->getDividas($con);
                    $pedido->produtos = $pedido->getProdutos($con);
                    if (($divida + $pedido->getTotal()) < $limite) {
                        $passou = true;
                    } else {
                        $pedido->status = Sistema::STATUS_CANCELADO();
                        $pedido->merge($con);
                        $lo = Logger::gerarLog($pedido, "Pedido cancelado devido a limite de credito, limite: R$ " . round($limite, 2) . ", divida: R$ " . round($divida, 2) . ", valor do pedido: R$ " . round($pedido->getTotal(), 2));
                        $html = $lo->toHtml();
                        $empresa->email->enviarEmail($pedido->cliente->email->filtro(Email::$COMPRAS), "Cancelamento de pedido", $html);
                        $empresa->email->enviarEmail($empresa->email->filtro(Email::$FINANCEIRO), "Cancelamento de pedido", $html);
                        return;
                    }
                }
                if ($passou) {

                    $emp = $pedido->empresa;
                    if ($pedido->logistica !== null) {
                        $emp = $pedido->logistica;
                    }

                    $t = new Tarefa();
                    $t->tipo_tarefa = Sistema::TT_SEPARACAO($emp->id);
                    $t->titulo = "Separacao do pedido $pedido->id";
                    $t->descricao .= "<a style='font-size:20px;text-decoration:underline;color:SteelBlue' href='separacao.php?pedido=$pedido->id&empresa=" . $pedido->empresa->id . "'>SEPARAR PEDIDO</a>";

                    $t->tipo_entidade_relacionada = "PED_" . $pedido->empresa->id;
                    $t->id_entidade_relacionada = $pedido->id;
                    Sistema::novaTarefaEmpresa($con, $t, $emp);

                    $pedido->status = Sistema::STATUS_SEPARACAO();
                    $pedido->merge($con);

                }
            }
        }
    }

}
