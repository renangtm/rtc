<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cidade
 *
 * @author Renan
 */
class StatusEncomenda {

    public $id;
    public $nome;
    public $emailInterno;
    public $emailCliente;

    function __construct($id = 0, $nome = "", $emailCliente = "", $emailInterno = "") {

        $this->id = $id;
        $this->nome = $nome;
        $this->emailCliente = $emailCliente;
        $this->emailInterno = $emailInterno;
    }

    public function enviarEmails($encomenda) {

        if ($this->emailCliente !== "") {
            $html = Sistema::getHtml('visualizar-encomenda', $encomenda);
            $encomenda->empresa->email->enviarEmail($encomenda->cliente->email->filtro($this->emailCliente), "Encomenda numero " . $encomenda->id, $html);
        }

        if ($this->emailInterno !== "") {
            $html = Sistema::getHtml('visualizar-encomenda', $encomenda);
            $encomenda->empresa->email->enviarEmail($encomenda->empresa->email->filtro($this->emailInterno), "Encomenda numero " . $encomenda->id, $html);
        }
    }

}
