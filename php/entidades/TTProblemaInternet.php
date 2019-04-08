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
class TTProblemaInternet extends TipoTarefa {

    function __construct($id_empresa) {

        parent::__construct(3, $id_empresa);

        $this->nome = "Problema de Internet";
        $this->tempo_medio = 0.3;
        $this->prioridade = 20;
        $this->cargos = array(
            Tecnologia::CF_ANALISTA_INFRA_JUNIOR(new Empresa($id_empresa)),
            Tecnologia::CF_ANALISTA_INFRA_PLENO(new Empresa($id_empresa)),
            Tecnologia::CF_ANALISTA_INFRA_SENIOR(new Empresa($id_empresa))
        );
        $this->carregarDados();
    }

    public function aoFinalizar($tarefa) {
        
    }

}
