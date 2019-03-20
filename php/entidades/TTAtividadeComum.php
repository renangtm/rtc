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
class TTAtividadeComum extends TipoTarefa {

    function __construct($id_empresa) {

        parent::__construct(8, $id_empresa);

        $this->nome = "Atividade Comum";
        $this->tempo_medio = 1;
        $this->prioridade = 1;
        $this->cargos = array(
        );
    }

    public function aoFinalizar() {
        
    }

}
