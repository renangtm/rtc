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
class TTCotacao extends TipoTarefa {

    function __construct($id_empresa) {

        parent::__construct(67, $id_empresa);

        $this->nome = "Cotacao de produtos";
        $this->tempo_medio = 5;
        $this->prioridade = 3;
        $this->cargos = array(
            Empresa::CF_ASSISTENTE_COMPRAS(new Empresa($id_empresa)),
            Empresa::CF_DIRETOR(new Empresa($id_empresa))
        );
        $this->carregarDados();
    }

    public function aoFinalizar() {
        
    }

}
