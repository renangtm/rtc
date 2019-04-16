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
class EmpresaAgricola extends Empresa {

    function __construct($id=0,$con=null) {

        parent::__construct($id,$con);
        
        $this->permissoes_especiais[] = array(
            Sistema::P_LISTA_PRECO(),
            Sistema::P_CULTURA(),
            Sistema::P_PRAGA(),
            Sistema::P_PARAMETRROS_TECNICOS_PRODUTO());
        
    }

}
