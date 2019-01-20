<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Max
 *
 * @author Renan
 */
class Max extends FuncaoNumerica {

    public function getTermo() {

        return "MAX";
    }

    public function interpretar($args) {

        return max($args[0], $args[1]);
    }

}
