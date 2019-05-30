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
class RelatorioInventario extends Relatorio {

    public function getObservacoes($empresa) {
        
        $con = new ConnectionFactory();
        
        $sql = "SELECT SUM(total),SUM(total_liquido) FROM inventario i INNER JOIN produto p ON i.id_produto=p.id LEFT JOIN empresa l ON p.id_logistica=l.id WHERE i.id_empresa=$empresa->id";
        
        $sql .= " AND i.data>=FROM_UNIXTIME(".$this->campos[0]->inicio."/1000) AND i.data<=FROM_UNIXTIME(".$this->campos[0]->fim."/1000)";
        
        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($total,$total_liquido);
        if($ps->fetch()){
            return "Total: R$ $total; Total Liquido: R$ $total_liquido";
        }
        $ps->close();
        return "";
        
    }
    
    public function __construct($empresa = null) {

        if ($empresa === null) {

            return;
        }

        parent::__construct("SELECT i.data as 'data',p.codigo as 'codigo',p.nome as 'nome',IFNULL(l.nome,'Propria') as 'logistica',i.quantidade as 'quantidade',i.valor_medio as 'valor',i.icms_recuperado as 'icms',i.total as 'total',i.total_liquido as 'total_liquido' FROM inventario i INNER JOIN produto p ON i.id_produto=p.id LEFT JOIN empresa l ON p.id_logistica=l.id WHERE i.id_empresa=$empresa->id", 34);

        $this->nome = "Relatorio Inventario";

        $data = new CampoRelatorio('data', 'Data Inventario', 'D');
        $codigo = new CampoRelatorio('codigo', 'Codigo Produto', 'N');
        $nome = new CampoRelatorio('nome', 'Nome Produto', 'T',false,false,20);
        $logistica = new CampoRelatorio('logistica', 'Logistica', 'T');
        $quantidade = new CampoRelatorio('quantidade', 'Quantidade', 'N');
        $valor_medio = new CampoRelatorio('valor', 'Valor Medio', 'N');
        $icms = new CampoRelatorio('icms', 'Icms Recup', 'N');
        $total = new CampoRelatorio('total', 'Total', 'N');
        $total_liquido = new CampoRelatorio('total_liquido', 'Total Liquido', 'N');

        $this->campos = array(
            $data,
            $codigo,
            $nome,
            $logistica,
            $quantidade,
            $valor_medio,
            $icms,
            $total,
            $total_liquido);
    }

}
