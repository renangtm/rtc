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
class TTFaturamento extends TipoTarefa {

    function __construct($id_empresa) {
        
        parent::__construct(25, $id_empresa);
        
        $this->nome = "Faturamento";
        $this->tempo_medio = 0.2;
        $this->prioridade = 2;
        $this->cargos = array(
            Empresa::CF_FATURISTA($id_empresa)
        );
        $this->carregarDados();
    }

    public function aoFinalizar() {
        
    }

}
