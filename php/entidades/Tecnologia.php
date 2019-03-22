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
class Tecnologia extends Empresa {

    public static function CF_DESENVOLVEDOR_TRAINEE($emp) {
        return new CargoFixo(12, "Desenvolvedor Trainee", $emp);
    }

    public static function CF_DESENVOLVEDOR_JUNIOR($emp) {
        return new CargoFixo(13, "Desenvolvedor Junior", $emp);
    }

    public static function CF_DESENVOLVEDOR_PLENO($emp) {
        return new CargoFixo(14, "Desenvolvedor Pleno", $emp);
    }

    public static function CF_DESENVOLVEDOR_SENIOR($emp) {
        return new CargoFixo(15, "Desenvolvedor Senior", $emp);
    }

    public static function CF_ANALISTA_INFRA_JUNIOR($emp) {
        return new CargoFixo(16, "Analista de Infra Junior", $emp);
    }

    public static function CF_ANALISTA_INFRA_PLENO($emp) {
        return new CargoFixo(17, "Analista de Infra Pleno", $emp);
    }

    public static function CF_ANALISTA_INFRA_SENIOR($emp) {
        return new CargoFixo(18, "Analista de Infra Senior", $emp);
    }

    public static function CF_ESTAGIARIO_TI($emp) {
        return new CargoFixo(19, "Estagiario de TI", $emp);
    }

    public static function CF_HELP_DESK($emp) {
        return new CargoFixo(20, "Help Desk", $emp);
    }

    public static function CF_ANALISTA_TESTES($emp) {
        return new CargoFixo(21, "Analista de testes", $emp);
    }

    function __construct($id=0,$con=null) {

        parent::__construct($id,$con);


        $this->cargos_fixos[] = Tecnologia::CF_DESENVOLVEDOR_TRAINEE($this);
        $this->cargos_fixos[] = Tecnologia::CF_DESENVOLVEDOR_JUNIOR($this);
        $this->cargos_fixos[] = Tecnologia::CF_DESENVOLVEDOR_PLENO($this);
        $this->cargos_fixos[] = Tecnologia::CF_DESENVOLVEDOR_SENIOR($this);
        $this->cargos_fixos[] = Tecnologia::CF_ANALISTA_INFRA_JUNIOR($this);
        $this->cargos_fixos[] = Tecnologia::CF_ANALISTA_INFRA_PLENO($this);
        $this->cargos_fixos[] = Tecnologia::CF_ANALISTA_INFRA_SENIOR($this);
        $this->cargos_fixos[] = Tecnologia::CF_ESTAGIARIO_TI($this);
        $this->cargos_fixos[] = Tecnologia::CF_HELP_DESK($this);
        $this->cargos_fixos[] = Tecnologia::CF_ANALISTA_TESTES($this);

        $this->tarefas_fixas[] = "TT_PROBLEMA_INTERNET";
        $this->tarefas_fixas[] = "TT_PROBLEMA_ENVIO_EMAIL";
        $this->tarefas_fixas[] = "TT_PROBLEMA_MAQUINA";
        $this->tarefas_fixas[] = "TT_MODIFICACAO_SIMPLES_SISTEMA";
        $this->tarefas_fixas[] = "TT_MODIFICACAO_SISTEMA";
        $this->tarefas_fixas[] = "TT_MODIFICACAO_COMPLEXA_SISTEMA";
        
        
    }

}
