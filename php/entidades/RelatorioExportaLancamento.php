<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CotacaoEntrada
 *
 * @author Renan
 */
class RelatorioExportaLancamento extends Relatorio {

    public function __construct($empresa = null) {

        if ($empresa === null) {

            return;
        }


        parent::__construct("SELECT movimento.id as 'id',movimento.data as 'data_movimento',CASE WHEN operacao.debito THEN fornecedor.codigo_contimatic ELSE banco.codigo_contimatic END as 'debito', CASE WHEN operacao.debito=false THEN cliente.codigo_contimatic ELSE banco.codigo_contimatic END as 'credito' ,(movimento.valor-movimento.descontos+movimento.juros) as 'valor',17 as 'historico',CASE WHEN operacao.debito THEN CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(fornecedor.codigo,' - '),fornecedor.nome),' NF: '),nota.numero),' ficha n.'),nota.ficha) ELSE CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(cliente.codigo,' - '),cliente.razao_social),' NF: '),nota.numero),' ficha n.'),nota.ficha) END as 'complemento' FROM movimento INNER JOIN vencimento ON vencimento.id=movimento.id_vencimento INNER JOIN nota ON vencimento.id_nota=nota.id INNER JOIN operacao ON movimento.id_operacao=operacao.id INNER JOIN historico ON movimento.id_historico=historico.id LEFT JOIN fornecedor ON fornecedor.id=nota.id_fornecedor LEFT JOIN cliente ON cliente.id =nota.id_cliente INNER JOIN banco ON banco.id = movimento.id_banco WHERE nota.id_empresa=$empresa->id AND nota.excluida=false", 2);

        $this->nome = "Exportar Lancamentos";

        $id = new CampoRelatorio('id', 'Lancamento', 'N');
        $data = new CampoRelatorio('data_movimento', 'Data', 'D');
        $debito = new CampoRelatorio('debito', 'Debito', 'N');
        $credito = new CampoRelatorio('credito', 'Credito', 'N');
        $historico = new CampoRelatorio('historico', 'Historico Padrao', 'N');
        $complemento = new CampoRelatorio('complemento', 'Complemento', 'T');

        $this->campos = array(
            $id,
            $data,
            $debito,
            $credito,
            $historico,
            $complemento);
    }

}

