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

    public function merge($con) {

        if ($this->id == 0) {
            
            $ps = $con->getConexao()->prepare("INSERT INTO parametros_emissao(id_empresa,nota,serie,lote,certificado,senha_certificado) VALUES(".$this->empresa->id.",$this->nota,$this->serie,$this->lote,'".$this->certificado."','$this->senha_certificado')");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        } else {

            $ps = $con->getConexao()->prepare("UPDATE parametros_emissao SET id_empresa=".$this->empresa->id.",nota=$this->nota,serie=$this->serie,lote=$this->lote,certificado='".$this->certificado."',senha_certificado='$this->senha_certificado' WHERE id=$this->id");
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
