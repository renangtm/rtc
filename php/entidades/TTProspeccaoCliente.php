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
class TTProspeccaoDeCliente extends TipoTarefa {

    function __construct($id_empresa) {

        parent::__construct(9, $id_empresa);

        $this->nome = "Prospeccao de Cliente";
        $this->tempo_medio = 0.3;
        $this->prioridade = 5;
        $this->cargos = array(
            Virtual::CF_ASSISTENTE_VIRTUAL_PROSPECCAO(new Empresa($id_empresa))
        );
    }

    public function aoFinalizar() {
        
    }

}
