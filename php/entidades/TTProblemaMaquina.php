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
class TTProblemaMaquina extends TipoTarefa {

    function __construct($id_empresa) {

        parent::__construct(5, $id_empresa);

        $this->nome = "Problema de Maquina";
        $this->tempo_medio = 1;
        $this->prioridade = 1;
        $this->cargos = array(
            Tecnologia::CF_HELP_DESK(new Empresa($id_empresa)),
            Tecnologia::CF_ESTAGIARIO_TI(new Empresa($id_empresa)),
            Tecnologia::CF_ANALISTA_INFRA_JUNIOR(new Empresa($id_empresa)),
            Tecnologia::CF_ANALISTA_INFRA_PLENO(new Empresa($id_empresa))
        );
        $this->carregarDados();
    }

    public function aoFinalizar() {
        
    }

}
