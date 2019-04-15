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
        
        $this->observacao_padrao_nota = "Os produtos estao adequadamente acondicionados para suportar os riscos normais das etapas RESERVADO AO FISCO necessarias a uma operacao de transporte e que atende a regulamentacao em vigor. Conf. Lei n. 9974 de 06-06-00 reg. pelo decreto 4072/02 de 04/01/2002, as embalagens adquiridas nesta NF deverao ser devolvidas no prazo de 1 (um) ano, perfuradas e com a triplice lavagem realizada, na unidade de recebimento: Agro-Fauna Com. Ins. Ltda. R.Coutinho Cavalcanti, 1171 - Jd Alto Alegre - S J Rio Preto-SP. CENTRAL DE RECEBIMENTOS DE EMBALAGENS VAZIAS DE AGROTOXICOS Av Jose Geraldo de Matos, 765A Distrito Industrial do Paracangua  - Taubate  SP";
        
    }

}
