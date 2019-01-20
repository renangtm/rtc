<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GrupoCidadesExp
 *
 * @author Renan
 */
class GrupoCidadesExp extends FuncaoBooleana {

    public function getTermo() {

        return "GRUPO";
    }

    public function interpretar($args) {

       return GrupoCidades::cidadeEstaNoGrupo($args[0], $args[1]);
        
    }

}
