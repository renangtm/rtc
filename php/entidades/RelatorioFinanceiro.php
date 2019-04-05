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

    public function getObservacoes($empresa) {

        return "Relatorio de contas a pagar e receber da empresa '$empresa->nome' de " .
                date("d/m/Y", doubleval($this->campos[1]->inicio . "") / 1000) .
                " ate " . date("d/m/Y", doubleval($this->campos[1]->fim . "") / 1000);
        
    }

    public function __construct($empresa = null) {

        if ($empresa === null) {

            return;
        }

        parent::__construct("SELECT (CASE WHEN nota.saida THEN 'S' ELSE 'E' END) as 'tipo', (CASE WHEN nota.saida THEN CONCAT(CONCAT(nota.id_cliente,' - '),cliente.razao_social) ELSE '---------' END) as 'cliente',(CASE WHEN nota.saida THEN '----------' ELSE CONCAT(CONCAT(nota.id_fornecedor,' - '),fornecedor.nome) END) as 'fornecedor',((CASE WHEN nota.saida THEN 1 ELSE -1 END)*GREATEST(ROUND((vencimento.valor-(SUM(IFNULL(movimento.valor,0)))),2)),0) as 'valor',UNIX_TIMESTAMP(vencimento.data)*1000 as 'vencimento', nota.ficha as 'ficha', vencimento.data as 'data', MONTH(vencimento.data) as 'mes', YEAR(vencimento.data) as 'ano', DAY(vencimento.data) as 'dia', nota.numero as 'numero_nota' FROM nota INNER JOIN vencimento ON vencimento.id_nota = nota.id LEFT JOIN cliente ON cliente.id=nota.id_cliente LEFT JOIN fornecedor ON fornecedor.id=nota.id_fornecedor LEFT JOIN movimento ON movimento.id_vencimento=vencimento.id WHERE nota.id_empresa=$empresa->id AND nota.cancelada=false AND nota.excluida=false GROUP BY vencimento.id", 0);

        $this->nome = "Contas Pagar/Receber";

        $saida_entrada = new CampoRelatorio('tipo', 'Tipo de Movimento', 'T');
        $saida_entrada->possiveis = array("S", "E");
        $saida_entrada->filtro = "k.tipo='Saida'";
        $saida_entrada->porcentagem_coluna_pdf = 6;

        $cliente = new CampoRelatorio('cliente', 'Cliente', 'T');
        $cliente->porcentagem_coluna_pdf = 25;

        $fornecedor = new CampoRelatorio('fornecedor', 'Fornecedor', 'T');
        $fornecedor->porcentagem_coluna_pdf = 25;

        $valor = new CampoRelatorio('valor', 'Valor da Pendencia', 'N');
        $valor->agrupado = true;
        $valor->porcentagem_coluna_pdf = 10;

        $dia = new CampoRelatorio('dia', 'Dia', 'N', false, true);
        $dia->agrupado = true;
        $dia->porcentagem_coluna_pdf = 5;

        $mes = new CampoRelatorio('mes', 'Mes', 'N', false, true);
        $mes->porcentagem_coluna_pdf = 5;

        $ano = new CampoRelatorio('ano', 'Ano', 'N', false, true);
        $ano->porcentagem_coluna_pdf = 5;

        $ficha = new CampoRelatorio('ficha', 'Ficha', 'T');
        $ficha->porcentagem_coluna_pdf = 10;
        $ficha->agrupado = true;

        $data = new CampoRelatorio('data', 'Data', 'D');
        $data->somente_filtro = true;

        $nota = new CampoRelatorio('numero_nota', 'Numero Nota', 'N');
        $nota->agrupado = true;
        $nota->porcentagem_coluna_pdf = 10;

        $this->campos = array(
            $saida_entrada,
            $data,
            $cliente,
            $fornecedor,
            $valor,
            $dia,
            $mes,
            $ano,
            $ficha,
            $nota);
    }

}
