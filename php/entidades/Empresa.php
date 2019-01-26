<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Fornecedor
 *
 * @author Renan
 */
class Empresa {

    public $id;
    public $nome;
    public $email;
    public $telefones;
    public $endereco;
    public $cnpj;
    public $excluida;
    public $consigna;
    public $aceitou_contrato;
    public $juros_mensal;
    public $inscricao_estadual;
    
    function __construct() {

        $this->id = 0;
        $this->email = null;
        $this->telefones = array();
        $this->endereco = null;
        $this->email = null;
        $this->excluida = false;
        $this->cnpj = new CNPJ("");
  
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO empresa(nome,excluida,inscricao_estadual,consigna,aceitou_contrato,juros_mensal,cnpj) VALUES('" . addslashes($this->nome) . "',false,'" . $this->inscricao_estadual . "'," . ($this->consigna?"true":"false") . ",".($this->aceitou_contrato?"true":"false").",false,$this->juros_mensal,'".$this->cnpj->valor."')");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE empresa SET nome='" . addslashes($this->nome) . "',excluida=false,inscricao_estadual = '" . addslashes($this->inscricao_estadual) . "', consigna=".($this->consigna?"true":"false").",aceitou_contrato=".($this->aceitou_contrato?"true":"false").", juros_mensal=" . $this->juros_mensal . ", cnpj='".$this->cnpj->valor."' WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();
        }

        
    }

    
    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE empresa SET excluida = true WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
