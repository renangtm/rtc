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
class TTSuporteCliente extends TipoTarefa {

    function __construct($id_empresa) {

        parent::__construct(11, $id_empresa);

        $this->nome = "Suporte para Cliente";
        $this->tempo_medio = 0.2;
        $this->prioridade = 15;
        $this->cargos = array(
            Virtual::CF_ASSISTENTE_VIRTUAL_SUPORTE(new Empresa($id_empresa))
        );
    }

    public function aoFinalizar() {
        
    }

}
