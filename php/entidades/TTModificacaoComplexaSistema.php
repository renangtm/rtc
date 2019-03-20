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
class TTModificacaoComplexaSistema extends TipoTarefa {

    function __construct($id_empresa) {

        parent::__construct(7, $id_empresa);

        $this->nome = "Modificacao Complexa Sistema";
        $this->tempo_medio = 24;
        $this->prioridade = 3;
        $this->cargos = array(
            Tecnologia::CF_DESENVOLVEDOR_SENIOR(new Empresa($id_empresa)),
        );
    }

    public function aoFinalizar() {
        
    }

}
