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
class TTCompra extends TipoTarefa {

    function __construct($id_empresa) {
        
        parent::__construct(1, $id_empresa);
        
        $this->nome = "Compra";
        $this->tempo_medio = 0.2;
        $this->prioridade = 1;
        $this->carregarDados();
    }

    public function aoFinalizar() {
        
    }

}
