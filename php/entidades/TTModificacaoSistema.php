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
class TTModificacaoSistema extends TipoTarefa {

    function __construct($id_empresa) {

        parent::__construct(6, $id_empresa);

        $this->nome = "Modificacao Sistema";
        $this->tempo_medio = 5;
        $this->prioridade = 3;
        $this->cargos = array(
            Tecnologia::CF_DESENVOLVEDOR_PLENO(new Empresa($id_empresa)),
            Tecnologia::CF_DESENVOLVEDOR_SENIOR(new Empresa($id_empresa)),
        );
    }

    public function aoFinalizar() {
        
    }

}
