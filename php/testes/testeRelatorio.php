<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of testeConnectionFactory
 *
 * @author Renan
 */

include('includes.php');

class testeConnectionFactory extends PHPUnit_Framework_TestCase {

    public function testSimple() {
//        
        $con = new ConnectionFactory();
        
        $rf = Utilidades::fromJson('{"_classe":"RelatorioMovimento","id":1,"nome":"Relatorio de Movimentos","campos":[{"_classe":"CampoRelatorio","titulo":"Data Mov","agrupado":true,"filtro":"(k.data_movimento >= FROM_UNIXTIME(1551240160219/1000) AND k.data_movimento <= FROM_UNIXTIME(1551326560219/1000)) ","nome":"data_movimento","tipo":"D","possiveis":[],"somente_filtro":false,"null_on_group":false,"ordem":0,"inicio":1551240160219,"fim":1551326560219},{"_classe":"CampoRelatorio","titulo":"Saldo Anterior","agrupado":true,"filtro":"","nome":"saldo_anterior","tipo":"N","possiveis":[],"somente_filtro":false,"null_on_group":false,"ordem":0,"modo":0,"numero":0},{"_classe":"CampoRelatorio","titulo":"Valor","agrupado":true,"filtro":"","nome":"valor","tipo":"N","possiveis":[],"somente_filtro":false,"null_on_group":false,"ordem":0,"modo":0,"numero":0},{"_classe":"CampoRelatorio","titulo":"Juros","agrupado":true,"filtro":"","nome":"juros","tipo":"N","possiveis":[],"somente_filtro":false,"null_on_group":false,"ordem":0,"modo":0,"numero":0},{"_classe":"CampoRelatorio","titulo":"Desconto","agrupado":true,"filtro":"","nome":"desconto","tipo":"N","possiveis":[],"somente_filtro":false,"null_on_group":false,"ordem":0,"modo":0,"numero":0},{"_classe":"CampoRelatorio","titulo":"Tipo Movimento","agrupado":true,"filtro":"(k.tipo_movimento=\'Debito\' OR k.tipo_movimento=\'Credito\') ","nome":"tipo_movimento","tipo":"T","possiveis":[{"termo":"Debito","selecionado":true,"_classe":"stdClass"},{"termo":"Credito","selecionado":true,"_classe":"stdClass"}],"somente_filtro":false,"null_on_group":false,"ordem":0},{"_classe":"CampoRelatorio","titulo":"NF","agrupado":true,"filtro":"","nome":"nota","tipo":"N","possiveis":[],"somente_filtro":false,"null_on_group":false,"ordem":0,"modo":0,"numero":0},{"_classe":"CampoRelatorio","titulo":"Ficha","agrupado":true,"filtro":"","nome":"ficha","tipo":"N","possiveis":[],"somente_filtro":false,"null_on_group":false,"ordem":0,"modo":0,"numero":0},{"_classe":"CampoRelatorio","titulo":"Operacao","agrupado":true,"filtro":"k.operacao like \'%%\' ","nome":"operacao","tipo":"T","possiveis":[],"somente_filtro":false,"null_on_group":false,"ordem":0,"texto":""},{"_classe":"CampoRelatorio","titulo":"Historico","agrupado":true,"filtro":"k.historico like \'%%\' ","nome":"historico","tipo":"T","possiveis":[],"somente_filtro":false,"null_on_group":false,"ordem":0,"texto":""},{"_classe":"CampoRelatorio","titulo":"Pessoa","agrupado":true,"filtro":"k.destinatario like \'%%\' ","nome":"destinatario","tipo":"T","possiveis":[],"somente_filtro":false,"null_on_group":false,"ordem":0,"texto":""}],"sql":"SELECT UNIX_TIMESTAMP(movimento.data)*1000 as \'data_movimento\',movimento.saldo_anterior as \'saldo_anterior\',movimento.valor as \'valor\',movimento.juros as \'juros\',movimento.descontos as \'desconto\',(CASE WHEN operacao.debito THEN \'Debito\' ELSE \'Credito\' END) as \'tipo_movimento\',nota.numero as \'nota\',nota.ficha as \'ficha\', operacao.nome as \'operacao\', historico.nome as \'historico\', (CASE WHEN nota.saida THEN cliente.razao_social ELSE fornecedor.nome END) as \'destinatario\' FROM movimento INNER JOIN vencimento ON vencimento.id=movimento.id_vencimento INNER JOIN nota ON vencimento.id_nota=nota.id INNER JOIN operacao ON movimento.id_operacao=operacao.id INNER JOIN historico ON movimento.id_historico=historico.id LEFT JOIN fornecedor ON fornecedor.id=nota.id_fornecedor LEFT JOIN cliente ON cliente.id =nota.id_cliente WHERE nota.id_empresa=1733","order":""}');
  
        echo Utilidades::toJson($rf->getItens($con,0,10));
        
        
    }

}
