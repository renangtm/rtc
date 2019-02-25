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
class RelatorioFinanceiro extends Relatorio {

    public function __construct($empresa = null) {

        if ($empresa === null) {

            return;
        }


        parent::__construct("SELECT (CASE WHEN nota.saida THEN 'Saida' ELSE 'Entrada' END) as 'tipo', (CASE WHEN nota.saida THEN CONCAT(CONCAT(nota.id_cliente,' - '),cliente.razao_social) ELSE '---------' END) as 'cliente',(CASE WHEN nota.saida THEN '----------' ELSE CONCAT(CONCAT(nota.id_fornecedor,' - '),fornecedor.nome) END) as 'fornecedor',((CASE WHEN nota.saida THEN 1 ELSE -1 END)*ROUND((vencimento.valor-(SUM(IFNULL(movimento.valor,0)))),2)) as 'valor',UNIX_TIMESTAMP(vencimento.data)*1000 as 'vencimento', nota.ficha as 'ficha', vencimento.data as 'data', MONTH(vencimento.data) as 'mes', YEAR(vencimento.data) as 'ano', DAY(vencimento.data) as 'dia' FROM nota INNER JOIN vencimento ON vencimento.id_nota = nota.id LEFT JOIN cliente ON cliente.id=nota.id_cliente LEFT JOIN fornecedor ON fornecedor.id=nota.id_fornecedor LEFT JOIN movimento ON movimento.id_vencimento=vencimento.id WHERE nota.id_empresa=$empresa->id AND nota.cancelada=false GROUP BY vencimento.id", 0);

        $this->nome = "Contas Pagar/Receber";

        $saida_entrada = new CampoRelatorio('tipo', 'Tipo de Movimento', 'T');
        $saida_entrada->possiveis = array("Saida", "Entrada");
        $saida_entrada->filtro = "k.tipo='Saida'";
        $cliente = new CampoRelatorio('cliente', 'Cliente', 'T');

        $fornecedor = new CampoRelatorio('fornecedor', 'Fornecedor', 'T');

        $valor = new CampoRelatorio('valor', 'Valor da Pendencia', 'N');
        $valor->agrupado = false;
        $dia = new CampoRelatorio('dia', 'Dia', 'N', false, true);
        $dia->agrupado = false;
        $mes = new CampoRelatorio('mes', 'Mes', 'N', false, true);
        $ano = new CampoRelatorio('ano', 'Ano', 'N', false, true);
        $ficha = new CampoRelatorio('ficha', 'Ficha', 'T');
        $ficha->agrupado = false;
        $data = new CampoRelatorio('data', 'Data', 'D');
        $data->somente_filtro = true;


        $this->campos = array(
            $saida_entrada,
            $data,
            $cliente,
            $fornecedor,
            $valor,
            $dia,
            $mes,
            $ano,
            $ficha);
    }

}
