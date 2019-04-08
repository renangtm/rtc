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
class TTModificacaoSimplesSistema extends TipoTarefa {

    function __construct($id_empresa) {

        parent::__construct(5, $id_empresa);

        $this->nome = "Modificacao Simples Sistema";
        $this->tempo_medio = 2;
        $this->prioridade = 2;
        $this->cargos = array(
            Tecnologia::CF_DESENVOLVEDOR_JUNIOR(new Empresa($id_empresa)),
            Tecnologia::CF_DESENVOLVEDOR_PLENO(new Empresa($id_empresa))
        );
        $this->carregarDados();
    }

    public function aoFinalizar() {
        
    }

}
