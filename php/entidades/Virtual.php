<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Logistica
 *
 * @author Renan
 */
class Virtual extends Empresa {

    public static function CF_ASSISTENTE_VIRTUAL_PROSPECCAO($emp) {
        return new CargoFixo(12, "Assistente Virtual de Prospeccao", $emp);
    }

    public static function CF_ASSISTENTE_VIRTUAL_RECEPCAO($emp) {
        return new CargoFixo(13, "Assistente Virtual de Recepcao", $emp);
    }

    public static function CF_ASSISTENTE_VIRTUAL_SUPORTE($emp) {
        return new CargoFixo(14, "Assistente Virtual de Suporte", $emp);
    }

    public static function CF_ASSISTENTE_VIRTUAL_POSVENDA($emp) {
        return new CargoFixo(15, "Assistente Virtual de Pos Venda", $emp);
    }

    function __construct() {

        parent::__construct();
        $this->cargos_fixos[] = Virtual::CF_ASSISTENTE_VIRTUAL_PROSPECCAO($this);
        $this->cargos_fixos[] = Virtual::CF_ASSISTENTE_VIRTUAL_RECEPCAO($this);
        $this->cargos_fixos[] = Virtual::CF_ASSISTENTE_VIRTUAL_SUPORTE($this);
        $this->cargos_fixos[] = Virtual::CF_ASSISTENTE_VIRTUAL_POSVENDA($this);
    
        $this->tarefas_fixas[] = "TT_PROSPECCAO_CLIENTE";
        $this->tarefas_fixas[] = "TT_RECEPCAO_CLIENTE";
        $this->tarefas_fixas[] = "TT_SUPORTE_CLIENTE";
        $this->tarefas_fixas[] = "TT_FAQ_CLIENTE";
        $this->tarefas_fixas[] = "TT_ATENDIMENTO_POSVENDA";
        
    }

}
