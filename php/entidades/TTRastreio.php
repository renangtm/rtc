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
    

    public function getObservacaoPadrao($tarefa){

        $pedido = $tarefa->id_entidade_relacionada;

        $con = new ConnectionFactory();

        $transportadora = 0;

        $consulta = $con->getConexao()->prepare("SELECT id_transportadora FROM pedido WHERE id=$pedido");
        $consulta->execute();
        
        $consulta->bind_result($id_transportadora);

        if($consulta->fetch()){

            $transportadora = $id_transportadora;

        }

        $consulta->close();


        $nome_transportadora = " ";

        $consulta = $con->getConexao()->prepare("SELECT razao_social FROM transportadora WHERE id=$transportadora");
        $consulta->execute();
        $consulta->bind_result($razao_social);

        if($consulta->fetch()){

            $nome_transportadora = $razao_social;

        }

        $consulta->close();


        return "Ola, rastreamos seu pedido $pedido com o (a) Sr. (a) ________ da Transportadora $nome_transportadora e recebemos a informacao de que seu pedido ________________________.";


    }
    
    public function init($tarefa) {
        
        $con = new ConnectionFactory();

        $pt = explode("_", $tarefa->tipo_entidade_relacionada);
        if (count($pt) === 2) {
            if ($pt[0] === "PED") {

                $id_empresa = intval($pt[1]);
                $empresa = new Empresa($id_empresa, $con);
                $pedido = $empresa->getPedidos($con, 0, 1, "pedido.id=$tarefa->id_entidade_relacionada");
                $pedido = $pedido[0];

                $observ = $tarefa->observacoes[count($tarefa->observacoes)-1];
                
                Logger::gerarLog($pedido, "Rastreamento do pedido $pedido->id do cliente ".$pedido->cliente->razao_social.": ".$observ->observacao);
                
            }
        }
        
        
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
