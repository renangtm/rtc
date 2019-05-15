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
class TTRevisaoPedido extends TipoTarefa {

    function __construct($id_empresa) {

        parent::__construct(80, $id_empresa);

        $this->nome = "Revisao de Pedido";
        $this->tempo_medio = 0.1;
        $this->prioridade = 100;
        $this->cargos = array(
            Empresa::CF_DIRETOR($id_empresa)
        );
        $this->carregarDados();
    }

    public function getObservacaoPadrao($tarefa) {
        $this->observacao_padrao = "#APROVADO_SIM_OU_NAO: SIM <br>";
        $this->observacao_padrao .= "#OBSERVACOES: _____ ";
        return $this->observacao_padrao;
    }

    public function aoFinalizar($tarefa, $usuario) {

        $con = new ConnectionFactory();

        $dados = $this->getDados($tarefa);

        $str = strtolower($dados['aprovado_sim_ou_nao']);

        if (strpos($str, "s") !== false) {
            
            $ps = $con->getConexao()->prepare("SELECT dado FROM dados WHERE id=" . $tarefa->id_entidade_relacionada);
            $ps->execute();
            
            $ps->bind_result($dado);
            if ($ps->fetch()) {
                $ps->close();
                
                $json = Utilidades::base64decodeSPEC($dado);
                $pedido = Utilidades::fromJson($json);
                $pedido->revisar = false;
                $pedido->observacoes .= ". Revisao de pedido aprovada por $usuario->nome sobre o motivo de $tarefa->descricao";
                $pedido->merge($con);
                 
            }else{
                $ps->close();
            }
        }
    }

}
