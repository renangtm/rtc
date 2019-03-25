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
class TTProspeccaoExternaCliente extends TipoTarefa {

    function __construct($id_empresa) {

        parent::__construct(33, $id_empresa);

        $this->nome = "Prospeccao Externa de Cliente";
        $this->tempo_medio = 0.5;
        $this->prioridade = 10;
        $this->cargos = array(
            Virtual::CF_ASSISTENTE_VIRTUAL_PROSPECCAO(new Empresa($id_empresa))
        );
    }

    public function aoAtribuir($id_usuario,$tarefa) {
        
    }

    public function aoFinalizar($tarefa,$usuario) {
        
    }

}
