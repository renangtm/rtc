
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
class RelatorioConferenciaEstoque extends Relatorio {

    public function getObservacoes($empresa) {
       
        return "Relatorio para conferencia de estoque com todos produtos movimentados no dia ".date("d/m/Y",$this->campos[7]->inicio/1000);
       
    }
    
    public function __construct($empresa = null) {

        if ($empresa === null) {

            return;
        }

        if($empresa->tipo_empresa !== 1){
                    parent::__construct("SELECT p.codigo as 'codigo',p.nome as 'nome',p.local as 'local',i.quantidade as 'estoque_anterior',k.saidas as 'saidas',k.entradas as 'entradas',(i.quantidade-k.saidas+k.entradas) as 'atual',DATE_FORMAT(k.data,'%d/%m/%Y') as 'data' FROM 
            (SELECT produto.id as 'id',produto.id_empresa as 'empresa',produto.codigo as 'codigo',produto.estoque as 'estoque',produto.nome as 'nome',IFNULL(empresa.nome,'Propria') as 'local' FROM produto LEFT JOIN empresa ON empresa.id=produto.id_logistica) p 
            INNER JOIN 
            (SELECT IFNULL(entradas.id_produto,saidas.id_produto) as 'id_produto', IFNULL(entradas.qtd,0) as 'entradas', IFNULL(saidas.qtd,0) as 'saidas',IFNULL(entradas.data,saidas.data) as 'data' FROM
             (SELECT SUM(pp.influencia_estoque) as 'qtd',pp.id_produto as 'id_produto',cast(p.data as date) as 'data' FROM produto_pedido_entrada pp INNER JOIN pedido_entrada p ON pp.id_pedido=p.id GROUP BY pp.id_produto,DATE(p.data),MONTH(p.data),YEAR(p.data)) entradas 
             LEFT JOIN (SELECT ABS(SUM(pp.influencia_estoque)) as 'qtd',pp.id_produto as 'id_produto',GROUP_CONCAT(pe.id separator ','),cast(n.data_emissao as date) as 'data' FROM produto_pedido_saida pp INNER JOIN pedido pe ON pe.id=pp.id_pedido INNER JOIN nota n ON n.id_pedido=pe.id AND n.id_empresa=pe.id_empresa AND n.excluida=false AND pe.excluido=false GROUP BY pp.id_produto,DATE(n.data_emissao),MONTH(n.data_emissao),YEAR(n.data_emissao)) saidas 
             ON entradas.data=saidas.data AND entradas.id_produto=saidas.id_produto 
             UNION
             SELECT IFNULL(entradas.id_produto,saidas.id_produto) as 'id_produto', IFNULL(entradas.qtd,0) as 'entradas', IFNULL(saidas.qtd,0) as 'saidas',IFNULL(entradas.data,saidas.data) as 'data' FROM (SELECT SUM(pp.influencia_estoque) as 'qtd',pp.id_produto as 'id_produto',cast(p.data as date) as 'data' FROM produto_pedido_entrada pp INNER JOIN pedido_entrada p ON pp.id_pedido=p.id GROUP BY pp.id_produto,DATE(p.data),MONTH(p.data),YEAR(p.data)) entradas 
             RIGHT JOIN (SELECT ABS(SUM(pp.influencia_estoque)) as 'qtd',pp.id_produto as 'id_produto',GROUP_CONCAT(pe.id separator ','),cast(n.data_emissao as date) as 'data' FROM produto_pedido_saida pp INNER JOIN pedido pe ON pe.id=pp.id_pedido INNER JOIN nota n ON n.id_pedido=pe.id AND n.id_empresa=pe.id_empresa AND n.excluida=false AND pe.excluido=false GROUP BY pp.id_produto,DATE(n.data_emissao),MONTH(n.data_emissao),YEAR(n.data_emissao)) saidas 
             ON entradas.data=saidas.data AND entradas.id_produto=saidas.id_produto WHERE entradas.data IS NULL) k 
             ON k.id_produto=p.id 
             INNER JOIN inventario i ON i.id_produto = p.id AND i.data=DATE_SUB(k.data,INTERVAL 1 DAY) 
             WHERE p.empresa=$empresa->id", 66);
        }else{
            parent::__construct("SELECT p.codigo as 'codigo',p.nome as 'nome',p.local as 'local',i.quantidade as 'estoque_anterior',k.saidas as 'saidas',k.entradas as 'entradas',(i.quantidade-k.saidas+k.entradas) as 'atual',DATE_FORMAT(k.data,'%d/%m/%Y') as 'data' FROM 
            (SELECT produto.id as 'id',produto.id_logistica as 'id_logistica',produto.id_empresa as 'empresa',produto.codigo as 'codigo',produto.estoque as 'estoque',produto.nome as 'nome',IFNULL(empresa.nome,'Propria') as 'local' FROM produto LEFT JOIN empresa ON empresa.id=produto.id_empresa) p 
            INNER JOIN 
            (SELECT IFNULL(entradas.id_produto,saidas.id_produto) as 'id_produto', IFNULL(entradas.qtd,0) as 'entradas', IFNULL(saidas.qtd,0) as 'saidas',IFNULL(entradas.data,saidas.data) as 'data' FROM
             (SELECT SUM(pp.influencia_estoque) as 'qtd',pp.id_produto as 'id_produto',cast(p.data as date) as 'data' FROM produto_pedido_entrada pp INNER JOIN pedido_entrada p ON pp.id_pedido=p.id GROUP BY pp.id_produto,DATE(p.data),MONTH(p.data),YEAR(p.data)) entradas 
             LEFT JOIN (SELECT ABS(SUM(pp.influencia_estoque)) as 'qtd',pp.id_produto as 'id_produto',GROUP_CONCAT(pe.id separator ','),cast(n.data_emissao as date) as 'data' FROM produto_pedido_saida pp INNER JOIN pedido pe ON pe.id=pp.id_pedido INNER JOIN nota n ON n.id_pedido=pe.id AND n.id_empresa=pe.id_empresa AND n.excluida=false AND pe.excluido=false GROUP BY pp.id_produto,DATE(n.data_emissao),MONTH(n.data_emissao),YEAR(n.data_emissao)) saidas 
             ON entradas.data=saidas.data AND entradas.id_produto=saidas.id_produto 
             UNION
             SELECT IFNULL(entradas.id_produto,saidas.id_produto) as 'id_produto', IFNULL(entradas.qtd,0) as 'entradas', IFNULL(saidas.qtd,0) as 'saidas',IFNULL(entradas.data,saidas.data) as 'data' FROM (SELECT SUM(pp.influencia_estoque) as 'qtd',pp.id_produto as 'id_produto',cast(p.data as date) as 'data' FROM produto_pedido_entrada pp INNER JOIN pedido_entrada p ON pp.id_pedido=p.id GROUP BY pp.id_produto,DATE(p.data),MONTH(p.data),YEAR(p.data)) entradas 
             RIGHT JOIN (SELECT ABS(SUM(pp.influencia_estoque)) as 'qtd',pp.id_produto as 'id_produto',GROUP_CONCAT(pe.id separator ','),cast(n.data_emissao as date) as 'data' FROM produto_pedido_saida pp INNER JOIN pedido pe ON pe.id=pp.id_pedido INNER JOIN nota n ON n.id_pedido=pe.id AND n.id_empresa=pe.id_empresa AND n.excluida=false AND pe.excluido=false GROUP BY pp.id_produto,DATE(n.data_emissao),MONTH(n.data_emissao),YEAR(n.data_emissao)) saidas 
             ON entradas.data=saidas.data AND entradas.id_produto=saidas.id_produto WHERE entradas.data IS NULL) k 
             ON k.id_produto=p.id 
             INNER JOIN inventario i ON i.id_produto = p.id AND i.data=DATE_SUB(k.data,INTERVAL 1 DAY)
              WHERE p.empresa=$empresa->id OR p.id_logistica = $empresa->id", 66);
        }
        
        $this->nome = "Relatorio de Conferencia de Estoque";

        $this->codigo_barras = true;

        $codigo = new CampoRelatorio('codigo', 'Codigo', 'N');

        $nome = new CampoRelatorio('nome', 'Nome', 'T', false, false, 20);

        $local = new CampoRelatorio('local', 'Local', 'T', false, false, 20);
        
        if($empresa->tipo_empresa === 1){
            
            $local = new CampoRelatorio('local', 'Empresa', 'T', false, false, 20);
            
        }

        $anterior = new CampoRelatorio('estoque_anterior', 'Anterior', 'N');

        $atual = new CampoRelatorio('atual', 'Atual', 'N');

        $saidas = new CampoRelatorio('saidas', 'Saidas', 'N');

        $entradas = new CampoRelatorio('entradas', 'Entradas', 'N');

        $data = new CampoRelatorio('data', 'Data', 'DF');
        $data->inicio = Utilidades::normalizarDia(round(microtime(true)*1000)-24*60*60*1000);
        
        $this->campos = array(
            $codigo,
            $nome,
            $local,
            $anterior,
            $saidas,
            $entradas,
            $atual,
            $data);
    }

}
