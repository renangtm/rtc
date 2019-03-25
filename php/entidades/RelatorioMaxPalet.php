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
class RelatorioMaxPalet extends Relatorio {

    public function __construct($empresa = null) {

        if ($empresa === null) {

            return;
        }
        
        parent::__construct("SELECT dias_corridos.dia as 'dia',CONCAT(CONCAT(k.id_empresa,' - '),k.nome_empresa) as 'empresa',COUNT(*) as 'quantidade' FROM dias_corridos LEFT JOIN (SELECT lote.id as 'id_lote',lote.data_entrada as 'entrada',CASE WHEN lote.quantidade_real=0 THEN IFNULL(MAX(pedido.data),lote.data_entrada) ELSE null END  as 'saida',empresa.id as 'id_empresa',empresa.nome as 'nome_empresa',empresa.cnpj as 'cnpj' FROM lote LEFT JOIN retirada ON retirada.id_lote=lote.id LEFT JOIN produto_pedido_saida ON produto_pedido_saida.id=retirada.id_produto_pedido LEFT JOIN pedido ON pedido.id=produto_pedido_saida.id_pedido INNER JOIN produto ON lote.id_produto=produto.id INNER JOIN empresa ON empresa.id=produto.id_empresa WHERE produto.id_logistica=1735 GROUP BY lote.id) k ON dias_corridos.dia>=k.entrada AND (dias_corridos.dia<=k.saida OR k.saida IS NULL) WHERE k.nome_empresa IS NOT NULL GROUP BY k.id_empresa,dias_corridos.dia", 6);

        $this->nome = "Quantidade Armazenagem";

        $dia = new CampoRelatorio('dia', 'Data', 'D');
        $emp = new CampoRelatorio('empresa', 'Empresa', 'T');
        $quantidade = new CampoRelatorio('quantidade', 'Quantidade', 'N');
        $quantidade->agrupado = true;
        
        $this->campos = array(
            $dia,
            $emp,
            $quantidade);
    }

}
