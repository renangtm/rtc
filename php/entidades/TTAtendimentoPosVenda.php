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
class TTAtendimentoPosVenda extends TipoTarefa {

    function __construct($id_empresa) {

        parent::__construct(15, $id_empresa);

        $this->nome = "Atendimento pos venda";
        $this->tempo_medio = 0.2;
        $this->prioridade = 5;
        $this->cargos = array(
            Virtual::CF_ASSISTENTE_VIRTUAL_POSVENDA(new Empresa($id_empresa))
        );
        $this->carregarDados();
    }

    public function aoFinalizar() {
        
    }

}
