<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Email
 *
 * @author Renan
 */
class ParametrosEmissao {

    public $id;
    public $empresa;
    public $nota;
    public $serie;
    public $lote;
    public $certificado;
    public $senha_certificado;

    function __construct() {

        $this->id = 0;
        $this->empresa = null;
        $this->nota = 0;
        $this->lote = 0;
        $this->serie = 0;
    }

    public function getComandoBase($con) {

        $obj = new stdClass();

        $obj->id = $this->id;
        $obj->lote = $this->lote;
        $obj->nf = $this->nota;
        $obj->cnpj = str_replace(array("-", ".", "/"), array("", "", ""), $this->empresa->cnpj->valor);
        $obj->serie = $this->serie;
        $obj->pais = "Brasil";
        $obj->municipio = $this->empresa->endereco->cidade->nome;
        $obj->nome = $this->empresa->nome;
        $obj->ie = str_replace(array("-", ".", "/"), array("", "", ""),$this->empresa->inscricao_estadual);
        $obj->crt = 3; //normal
        $obj->cep = str_replace(array("-", ".", "/"), array("", "", ""), $this->empresa->endereco->cep->valor);
        $obj->telefone = $this->empresa->telefone->numero;
        $obj->bairro = $this->empresa->endereco->bairro;
        $obj->logadouro = $this->empresa->endereco->rua;
        $obj->numero = $this->empresa->endereco->numero;

        $arquivo = "logo_" . round(microtime(true) * 1000) . ".txt";

        $logo = $this->empresa->getLogo($con);
        $decodificado = Utilidades::base64decode($logo->logo);

        while (strlen($decodificado) > 0) {
            $buff = substr($decodificado, 0, 2000);
            $decodificado = substr($decodificado, 2000);
            Sistema::mergeArquivo($arquivo, $buff, false);
        }

        $obj->logo = Sistema::$ENDERECO."php/uploads/".$arquivo;
        $obj->estado = $this->empresa->endereco->cidade->estado->sigla;
        $obj->certificado = $this->certificado;
        $obj->senha_certificado = $this->senha_certificado;
     
        return $obj;
        
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO parametros_emissao(id_empresa,nota,serie,lote,certificado,senha_certificado) VALUES(" . $this->empresa->id . ",$this->nota,$this->serie,$this->lote,'" . $this->certificado . "','$this->senha_certificado')");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE parametros_emissao SET id_empresa=" . $this->empresa->id . ",nota=$this->nota,serie=$this->serie,lote=$this->lote,certificado='" . $this->certificado . "',senha_certificado='$this->senha_certificado' WHERE id=$this->id");
            $ps->execute();
            $ps->close();
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("DELETE FROM parametros_emissao WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
