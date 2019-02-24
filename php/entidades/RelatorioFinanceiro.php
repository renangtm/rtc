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
class RelatorioFinanceiro extends Relatorio{
    
    public function __construct($empresa) {
        
        parent::__construct("SELECT (CASE WHEN nota.saida THEN 'Saida' ELSE 'Entrada' END) as 'tipo', (CASE WHEN nota.saida THEN CONCAT(CONCAT(nota.id_cliente,' - '),cliente.razao_social) ELSE '---------' END) as 'cliente',(CASE WHEN nota.saida THEN '----------' ELSE CONCAT(CONCAT(nota.id_fornecedor,' - '),fornecedor.nome) END) as 'fornecedor',(CASE WHEN nota.saida THEN vencimento.valor ELSE vencimento.valor*-1 END) as 'valor',DATE(vencimento.data) as 'dia', MONTH(vencimento.data) as 'mes', YEAR(vencimento.data) as 'ano', nota.ficha as 'ficha',(UNIX_TIMESTAMP(vencimento.data)*1000) as 'data' FROM nota INNER JOIN vencimento ON vencimento.id_nota = nota.id LEFT JOIN cliente ON cliente.id=nota.id_cliente LEFT JOIN fornecedor ON fornecedor.id=nota.id_fornecedor WHERE vencimento.id_movimento = 0 AND nota.id_empresa=$empresa->id AND nota.cancelada=false");
        
        $saida_entrada = new CampoRelatorio('tipo','Tipo de Movimento','S');
        $cliente = new CampoRelatorio('cliente','Cliente','S');
        $fornecedor = new CampoRelatorio('fornecedor','Fornecedor','S');
        $valor = new CampoRelatorio('valor','Valor da Pendencia','N');
        $dia = new CampoRelatorio('dia','Dia','N',false,true);
        $mes = new CampoRelatorio('mes','Mes','N',false,true);
        $ano = new CampoRelatorio('ano','Ano','N',false,true);
        $ficha = new CampoRelatorio('ficha','Ficha','T');
        $data = new CampoRelatorio('data','Data','D');
        $data->somente_filtro = true;
        
        
        $this->campos = array(
            $saida_entrada,
            $cliente,
            $fornecedor,
            $valor,
            $dia,
            $mes,
            $ano,
            $ficha,
            $data);
        
        
    }
    
    
}
