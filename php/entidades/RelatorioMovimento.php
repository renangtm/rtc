
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
class RelatorioMovimento extends Relatorio {

    public function __construct($empresa = null) {

        if ($empresa === null) {

            return;
        }


        parent::__construct("SELECT movimento.data as 'data_movimento',movimento.saldo_anterior as 'saldo_anterior',movimento.valor as 'valor',movimento.juros as 'juros',movimento.descontos as 'desconto',(CASE WHEN operacao.debito THEN 'Debito' ELSE 'Credito' END) as 'tipo_movimento',nota.numero as 'nota',nota.ficha as 'ficha', operacao.nome as 'operacao', historico.nome as 'historico', (CASE WHEN nota.saida THEN cliente.razao_social ELSE fornecedor.nome END) as 'destinatario' FROM movimento INNER JOIN vencimento ON vencimento.id=movimento.id_vencimento INNER JOIN nota ON vencimento.id_nota=nota.id INNER JOIN operacao ON movimento.id_operacao=operacao.id INNER JOIN historico ON movimento.id_historico=historico.id LEFT JOIN fornecedor ON fornecedor.id=nota.id_fornecedor LEFT JOIN cliente ON cliente.id =nota.id_cliente WHERE nota.id_empresa=$empresa->id AND nota.excluida=false", 1);

        $this->nome = "Relatorio de Movimentos";

        $data = new CampoRelatorio('data_movimento', 'Data Mov', 'D');
        
        
        $saldo_anterior = new CampoRelatorio('saldo_anterior', 'Saldo Anterior', 'N');
       
        
        $valor = new CampoRelatorio('valor', 'Valor', 'N');
       
        
        $juros = new CampoRelatorio('juros', 'Juros', 'N');
        
        
        $desconto = new CampoRelatorio('desconto', 'Desconto', 'N');
      
        
        $tipo = new CampoRelatorio('tipo_movimento', 'Tipo Movimento', 'T');
        $tipo->possiveis = array("Debito","Credito");
       
        
        $nota = new CampoRelatorio('nota', 'NF', 'N');
     
        
        $ficha = new CampoRelatorio('ficha', 'Ficha', 'N');
     
        
        $operacao = new CampoRelatorio('operacao', 'Operacao', 'T');

        
        $historico = new CampoRelatorio('historico', 'Historico', 'T');
  
        
        $destinatario = new CampoRelatorio('destinatario', 'Pessoa', 'T');
    



        $this->campos = array(
            $data,
            $saldo_anterior,
            $valor,
            $juros,
            $desconto,
            $tipo,
            $nota,
            $ficha,
            $operacao,
            $historico,
            $destinatario);
    }

}