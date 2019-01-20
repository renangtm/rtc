<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Min
 *
 * @author Renan
 */
class Min extends FuncaoNumerica {

    public function getTermo() {

        return "MIN";
    }

    public function interpretar($args) {

        return min($args[0], $args[1]);
    }

}
