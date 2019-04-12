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
class TTRastreio extends TipoTarefa {

    function __construct($id_empresa) {
        
        parent::__construct(26, $id_empresa);
        
        $this->nome = "Rastreio";
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

                $pedido->status = Sistema::STATUS_FINALIZADO();
                $pedido->merge($con);
            }
        }
    }

}
