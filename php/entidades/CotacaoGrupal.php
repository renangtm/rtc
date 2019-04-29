<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegraTabela
 *
 * @author Renan
 */
class CotacaoGrupal {

    public $id;
    public $fornecedores;
    public $produtos;
    public $data;
    public $observacoes;
    public $enviada;
    public $empresa;

    function __construct() {

        $this->id = 0;
        $this->fornecedores = array();
        $this->produtos = array();
        $this->data = round(microtime(true) * 1000);
        $this->observacoes = "";
        $this->empresa = null;
    }

    public function enviarEmails($con) {

        foreach ($this->fornecedores as $key => $fornecedor) {

            $completo = $this->empresa->getFornecedores($con, 0, 1, "fornecedor.cnpj='" . addslashes($fornecedor->cnpj->valor) . "'");
            
            if (count($completo) === 0) {
                Sistema::avisoDEVS($fonecedor->id . " da cotacao grupal " . $this->id . ", cnpj " . $fornecedor->cnpj->valor . ", nao foi encontrado, e nao enviou email...");
                continue;
            }
            
            $completo = $completo[0];
            $obj = Utilidades::copy($this);
            $obj->fornecedor = $completo;
            $obj->link_resposta = Sistema::$ENDERECO . "resposta_cotacao_grupal.php?cod=" . Utilidades::base64encodeSPEC($this->empresa->id . "||" . $this->id . "||" . $fornecedor->id);

            $html = Sistema::getHtml('cotacao_grupal', $obj);

            $empresa->email->enviarEmail($empresa->email->filtro(Email::$COMPRAS),"Cotacao da ".$empresa->nome,$html);
            
            //$empresa->email->enviarEmail($fornecedor->email,"Cotacao da ".$empresa->nome,$html);
            
        }

        $this->enviada = true;
        $ps = $con->getConexao()->prepare("UPDATE cotacao_grupal SET data=data, enviada=true WHERE id=$this->id");
        $ps->execute();
        $ps->close();
    }

    public function getRespostasFaltantes($fornecedor) {

        $fornecedor_real = null;

        foreach ($this->fornecedores as $key => $value) {
            if ($value->id === $fornecedor->id) {
                $fornecedor_real = $value;
            }
        }

        if ($fornecedor_real === null) {
            return array();
        }

        $faltantes = array();

        foreach ($this->produtos as $key => $produto) {
            foreach ($produto->respostas as $key2 => $resposta) {
                if ($resposta->fornecedor->id === $fornecedor_real->id) {
                    continue 2;
                }
            }

            $r = new RespostaCotacaoGrupal();
            $r->fornecedor = $fornecedor_real;
            $r->produto = $produto;
            $r->quantidade = $produto->quantidade;
            $r->valor = 0;

            $faltantes[] = $r;
        }

        return $faltantes;
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO cotacao_grupal(id_empresa,observacoes,data,enviada) VALUES(" . $this->empresa->id . ",'" . addslashes($this->observacoes) . "',FROM_UNIXTIME($this->data/1000)," . ($this->enviada ? "true" : "false") . ")");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE cotacao_grupal SET id_empresa=" . $this->empresa->id . ",data=FROM_UNIXTIME($this->data/1000),observacoes='" . addslashes($this->observacoes) . "',enviada=" . ($this->enviada ? "true" : "false") . " WHERE id = $this->id");
            $ps->execute();
            $ps->close();
        }

        $ids = "(0";
        foreach ($this->produtos as $key2 => $value2) {

            $value2->merge($con);

            $ids .= ",$value2->id";
        }
        $ids .= ")";

        $ps = $con->getConexao()->prepare("DELETE FROM produto_cotacao_grupal WHERE id_cotacao=$this->id AND id NOT IN $ids");
        $ps->execute();
        $ps->close();

        $ps = $con->getConexao()->prepare("DELETE FROM fornecedor_cotacao_grupal WHERE id_cotacao=$this->id");
        $ps->execute();
        $ps->close();

        foreach ($this->fornecedores as $key => $value) {
            $ps = $con->getConexao()->prepare("INSERT INTO fornecedor_cotacao_grupal(id_fornecedor,id_cotacao) VALUES($value->id,$this->id)");
            $ps->execute();
            $ps->close();
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE cotacao_grupal SET excluida=true,data=data WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
