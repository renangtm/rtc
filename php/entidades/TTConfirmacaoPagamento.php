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
class TTConfirmacaoPagamento extends TipoTarefa {

    function __construct($id_empresa) {
        
        parent::__construct(2, $id_empresa);
        
        $this->nome = "Confirmacao Pagamento";
        $this->tempo_medio = 0.2;
        $this->prioridade = 2;
        
    }

    public function aoFinalizar() {
        
    }

}
