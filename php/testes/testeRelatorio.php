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
        
        $rf = Utilidades::fromJson('{"_classe":"RelatorioFinanceiro","id":0,"nome":"Contas Pagar/Receber","campos":[{"_classe":"CampoRelatorio","titulo":"Tipo de Movimento","agrupado":true,"filtro":"(k.tipo=\'Saida\' OR k.tipo=\'Entrada\') ","nome":"tipo","tipo":"T","possiveis":[{"termo":"Saida","selecionado":true,"_classe":"stdClass"},{"termo":"Entrada","selecionado":true,"_classe":"stdClass"}],"somente_filtro":false,"null_on_group":false,"ordem":0},{"_classe":"CampoRelatorio","titulo":"Data","agrupado":true,"filtro":"(k.data >= FROM_UNIXTIME(1551072555405/1000) AND k.data <= FROM_UNIXTIME(1551158955405/1000)) ","nome":"data","tipo":"D","possiveis":[],"somente_filtro":true,"null_on_group":false,"ordem":0,"inicio":1551072555405,"fim":1551158955405},{"_classe":"CampoRelatorio","titulo":"Cliente","agrupado":true,"filtro":"k.cliente like \'%%\' ","nome":"cliente","tipo":"T","possiveis":[],"somente_filtro":false,"null_on_group":false,"ordem":0,"texto":""},{"_classe":"CampoRelatorio","titulo":"Fornecedor","agrupado":true,"filtro":"k.fornecedor like \'%Henz%\' ","nome":"fornecedor","tipo":"T","possiveis":[],"somente_filtro":false,"null_on_group":false,"ordem":0,"texto":"henz"},{"_classe":"CampoRelatorio","titulo":"Valor da Pendencia","agrupado":false,"filtro":"","nome":"valor","tipo":"N","possiveis":[],"somente_filtro":false,"null_on_group":false,"ordem":0,"modo":0,"numero":0},{"_classe":"CampoRelatorio","titulo":"Dia","agrupado":false,"filtro":"","nome":"dia","tipo":"N","possiveis":[],"somente_filtro":false,"null_on_group":true,"ordem":0,"modo":0,"numero":0},{"_classe":"CampoRelatorio","titulo":"Mes","agrupado":true,"filtro":"","nome":"mes","tipo":"N","possiveis":[],"somente_filtro":false,"null_on_group":true,"ordem":0,"modo":0,"numero":0},{"_classe":"CampoRelatorio","titulo":"Ano","agrupado":true,"filtro":"","nome":"ano","tipo":"N","possiveis":[],"somente_filtro":false,"null_on_group":true,"ordem":0,"modo":0,"numero":0},{"_classe":"CampoRelatorio","titulo":"Ficha","agrupado":false,"filtro":"k.ficha like \'%%\' ","nome":"ficha","tipo":"T","possiveis":[],"somente_filtro":false,"null_on_group":false,"ordem":0,"texto":""}],"sql":"SELECT (CASE WHEN nota.saida THEN \'Saida\' ELSE \'Entrada\' END) as \'tipo\', (CASE WHEN nota.saida THEN CONCAT(CONCAT(nota.id_cliente,\' - \'),cliente.razao_social) ELSE \'---------\' END) as \'cliente\',(CASE WHEN nota.saida THEN \'----------\' ELSE CONCAT(CONCAT(nota.id_fornecedor,\' - \'),fornecedor.nome) END) as \'fornecedor\',((CASE WHEN nota.saida THEN 1 ELSE -1 END)*(vencimento.valor-(SUM(IFNULL(movimento.valor,0))))) as \'valor\',UNIX_TIMESTAMP(vencimento.data)*1000 as \'vencimento\', nota.ficha as \'ficha\', vencimento.data as \'data\', MONTH(vencimento.data) as \'mes\', YEAR(vencimento.data) as \'ano\', DAY(vencimento.data) as \'dia\' FROM nota INNER JOIN vencimento ON vencimento.id_nota = nota.id LEFT JOIN cliente ON cliente.id=nota.id_cliente LEFT JOIN fornecedor ON fornecedor.id=nota.id_fornecedor LEFT JOIN movimento ON movimento.id_vencimento=vencimento.id AND nota.id_empresa=1733 AND nota.cancelada=false GROUP BY vencimento.id","order":""}');
  
        echo $rf->getCount($con);
        
        
    }

}
