<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cliente
 *
 * @author Renan
 */
class Transportadora {

    public $id;
    public $razao_social;
    public $nome_fantasia;
    public $telefones;
    public $despacho;
    public $empresa;
    public $endereco;
    public $email;
    public $cnpj;
    public $excluida;
    public $inscricao_estadual;
    public $habilitada;

    function __construct() {

        $this->id = 0;
        $this->email = new Email("");
        $this->cnpj = new CNPJ("");
        $this->endereco = null;
        $this->tabela = null;
        $this->telefones = array();
        $this->empresa = null;
        $this->excluida = false;
        $this->habilitado = false;
    }

    public function merge($con) {
        
        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO transportadora(razao_social,nome_fantasia,inscricao_estadual,despacho,id_empresa,cnpj,excluida,habilitada) VALUES('" . addslashes($this->razao_social) . "','" . addslashes($this->nome_fantasia) . "','" . addslashes($this->inscricao_estadual) . "',$this->despacho," . $this->empresa->id . ",'" . addslashes($this->cnpj->valor) . "',false," . ($this->habilitada ? "true" : "false") . ")");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE transportadora SET razao_social='" . addslashes($this->razao_social) . "', nome_fantasia='" . addslashes($this->nome_fantasia) . "', inscricao_estadual='" . addslashes($this->inscricao_estadual) . "', despacho=$this->despacho, id_empresa=" . $this->empresa->id . ", cnpj='" . addslashes($this->cnpj->valor) . "', excluida=false, habilitada=" . ($this->habilitada ? "true" : "false") . " WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();
        }

        $this->endereco->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE endereco SET tipo_entidade='TRA', id_entidade=$this->id WHERE id=" . $this->endereco->id);
        $ps->execute();
        $ps->close();

        $this->email->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE email SET tipo_entidade='TRA', id_entidade=$this->id WHERE id=" . $this->email->id);
        $ps->execute();
        $ps->close();

        $ps = $con->getConexao()->prepare("UPDATE tabela SET id_transportadora=0 WHERE id_transportadora=" . $this->id);
        $ps->execute();
        $ps->close();

        if ($this->tabela != null) {

            $this->tabela->merge($con);

            $ps = $con->getConexao()->prepare("UPDATE tabela SET id_transportadora=$this->id WHERE id=" . $this->tabela->id);
            $ps->execute();
            $ps->close();
        }
        
        $tels = array();
        $ps = $con->getConexao()->prepare("SELECT id,numero FROM telefone WHERE tipo_entidade='TRA' AND id_entidade=$this->id AND excluido=false");
        $ps->execute();
        $ps->bind_result($idt, $numerot);
        while ($ps->fetch()) {
            $t = new Telefone($numerot);
            $t->id = $idt;
            $tels[] = $t;
        }

        foreach ($tels as $key => $value) {

            foreach ($this->telefones as $key2 => $value2) {

                if ($value->id == $value2->id) {

                    continue 2;
                }
            }

            $value->delete($con);
        }

        foreach ($this->telefones as $key => $value) {

            $value->merge($con);
            
            $ps = $con->getConexao()->prepare("UPDATE telefone SET tipo_entidade='TRA', id_entidade=$this->id WHERE id=" . $value->id);
            $ps->execute();
            $ps->close();

        }
        
    }

    public function setDocumentos($docs, $con) {

        $ps = $con->getConexao()->prepare("UPDATE documento SET id_entidade=0 WHERE tipo_entidade='TRA' AND id_entidade=$this->id");
        $ps->execute();
        $ps->close();

        foreach ($docs as $key => $doc) {

            $doc->merge($con);

            $ps = $con->getConexao()->prepare("UPDATE documento SET tipo_entidade='TRA', id_entidade=$this->id WHERE id=$doc->id");
            $ps->execute();
            $ps->close();
        }
    }

    public function getDocumentos($con) {

        $categorias_documento = Sistema::getCategoriaDocumentos();

        $docs = array();

        $ps = $con->getConexao()->prepare("SELECT id,UNIX_TIMESTAMP(data_insercao)*1000,id_categoria,numero,link FROM documento WHERE tipo_entidade='TRA' AND id_entidade=$this->id AND excluido=false");
        $ps->execute();
        $ps->bind_result($id, $data, $id_categoria, $numero, $link);

        while ($ps->fetch()) {

            $d = new Documento();

            $d->id = $id;
            $d->data_insercao = $data;
            $d->numero = $numero;
            $d->link = $link;

            foreach ($categorias_documento as $key => $value) {
                if ($value->id == $id_categoria) {

                    $d->categoria = $value;

                    $docs[] = $d;

                    continue 2;
                }
            }
        }

        $ps->close();

        return $docs;
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE transportadora SET excluida=true WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
