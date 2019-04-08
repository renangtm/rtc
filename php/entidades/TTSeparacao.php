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
class TTSeparacao extends TipoTarefa {

    function __construct($id_empresa) {
        
        parent::__construct(23, $id_empresa);
        
        $this->nome = "Separacao";
        $this->tempo_medio = 0.2;
        $this->prioridade = 2;
        $this->carregarDados();
    }

    public function aoFinalizar() {
        
    }

}
