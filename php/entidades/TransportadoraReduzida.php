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
class TransportadoraReduzida {

    public $id;
    public $razao_social;
    public $cnpj;

    function __construct() {

        $this->id = 0;
        $this->razao_social = "";
        $this->cnpj = new CNPJ("");
    }

    public function getTransportadora($con) {

        $sql = "SELECT "
                . "transportadora.id_empresa,"
                . "transportadora.id,"
                . "transportadora.codigo, "
                . "transportadora.razao_social, "
                . "transportadora.nome_fantasia, "
                . "transportadora.despacho, "
                . "transportadora.cnpj, "
                . "transportadora.habilitada, "
                . "transportadora.inscricao_estadual,"
                . "endereco_transportadora.id, "
                . "endereco_transportadora.rua, "
                . "endereco_transportadora.numero, "
                . "endereco_transportadora.bairro, "
                . "endereco_transportadora.cep, "
                . "cidade_transportadora.id, "
                . "cidade_transportadora.nome, "
                . "estado_transportadora.id, "
                . "estado_transportadora.sigla, "
                . "email_transportadora.id,"
                . "email_transportadora.endereco,"
                . "email_transportadora.senha "
                . "FROM transportadora "
                . "INNER JOIN endereco endereco_transportadora ON endereco_transportadora.id_entidade=transportadora.id AND endereco_transportadora.tipo_entidade='TRA' "
                . "INNER JOIN cidade cidade_transportadora ON endereco_transportadora.id_cidade=cidade_transportadora.id "
                . "INNER JOIN estado estado_transportadora ON estado_transportadora.id=cidade_transportadora.id_estado "
                . "INNER JOIN email email_transportadora ON email_transportadora.id_entidade = transportadora.id AND email_transportadora.tipo_entidade='TRA' "
                . "LEFT JOIN tabela ON tabela.id_transportadora = transportadora.id "
                . "WHERE transportadora.id=$this->id";

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id_empresa, $tra_id, $cod_tra, $tra_nome, $tra_nome_fantasia, $tra_despacho, $tra_cnpj, $tra_habilitada, $tra_ie, $end_tra_id, $end_tra_rua, $end_tra_numero, $end_tra_bairro, $end_tra_cep, $cid_tra_id, $cid_tra_nome, $est_tra_id, $est_tra_nome, $id_email_tra, $end_email_tra, $sen_email_tra);

        if ($ps->fetch()) {
            
            $ps->close();

            $transportadora = new Transportadora();
            $transportadora->id = $tra_id;
            $transportadora->codigo = $cod_tra;
            $transportadora->cnpj = new CNPJ($tra_cnpj);
            $transportadora->despacho = $tra_despacho;
            $transportadora->email = new Email($end_email_tra);
            $transportadora->email->id = $id_email_tra;
            $transportadora->email->senha = $sen_email_tra;
            $transportadora->habilitada = $tra_habilitada == 1;
            $transportadora->inscricao_estadual = $tra_ie;
            $transportadora->nome_fantasia = $tra_nome_fantasia;
            $transportadora->razao_social = $tra_nome;
            $transportadora->empresa = Sistema::getEmpresas($con, "empresa.id=$id_empresa");
            $transportadora->empresa = $transportadora->empresa[0];

            $end = new Endereco();
            $end->id = $end_tra_id;
            $end->bairro = $end_tra_bairro;
            $end->cep = new CEP($end_tra_cep);
            $end->numero = $end_tra_numero;
            $end->rua = $end_tra_rua;

            $end->cidade = new Cidade();
            $end->cidade->id = $cid_tra_id;
            $end->cidade->nome = $cid_tra_nome;

            $end->cidade->estado = new Estado();
            $end->cidade->estado->id = $est_tra_id;
            $end->cidade->estado->sigla = $est_tra_nome;

            $transportadora->endereco = $end;

           
            return $transportadora;
        }

        $ps->close();

        return null;
    }

}
