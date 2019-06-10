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


    public function getDadosAdcionais($linha){

        $id = $linha->id;

        $id_produto = 0;
        $ms = 0;

        $con = new ConnectionFactory();

        $emp = null;
        $ps = $con->getConexao()->prepare("SELECT p.id_empresa,i.id_produto,UNIX_TIMESTAMP(i.data) FROM inventario i INNER JOIN produto p ON p.id=i.id_produto WHERE i.id=$id");
        $ps->execute();
        $ps->bind_result($id_empresa,$id_prod,$data);
        if($ps->fetch()){
            $emp = $id_empresa;
            $id_produto = $id_prod;
            $ms = $data*1000;
        }
        $ps->close();

        $emp = new Empresa($emp,$con);

        if($emp === null){

            return "";

        }

        $html = "<table class='table table-striped'><tr><th>Qtd</th><th>Data</th><th>Pessoa</th><th>ICMS</th><th>NF</th></tr>";

        $movimentos = $emp->getMovimentosProduto($con,"pr.id=$id_produto");

        $mes = date('m',$ms/1000);

        foreach($movimentos as $key=>$m){

            if($m->influencia_estoque === 0){continue;}

            if(date('m',$m->momento/1000) !== $mes){
                continue;
            }

            $tr = "<tr><td><strong>$m->influencia_estoque</strong></td><td>".date('d/m/Y',$m->momento/1000)."</td><td>$m->pessoa</td><td>".($m->icms*abs($m->influencia_estoque))."</td><td>$m->numero_nota</td></tr>";

            $html .= $tr;

        }

        $html .= "</table>";


        return $html;

    }

    public function getObservacoes($empresa) {
        
        $con = new ConnectionFactory();
        
        $sql = "SELECT SUM(total),SUM(total_liquido),SUM(icms_recuperado) FROM inventario i INNER JOIN produto p ON i.id_produto=p.id LEFT JOIN empresa l ON p.id_logistica=l.id WHERE i.id_empresa=$empresa->id";
        
        $sql .= " AND DATE(i.data)=DATE(FROM_UNIXTIME(".$this->campos[0]->inicio."/1000)) AND MONTH(i.data)=MONTH(FROM_UNIXTIME(".$this->campos[0]->inicio."/1000)) AND YEAR(i.data)=YEAR(FROM_UNIXTIME(".$this->campos[0]->inicio."/1000))";
        
        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($total,$total_liquido,$icms);
        if($ps->fetch()){
            return "Parcial: R$ $total; Icms Recuperado: R$ $icms ;Total Liquido: R$ $total_liquido";
        }
        $ps->close();
        return "";
        
    }
    
    public function __construct($empresa = null) {

        if ($empresa === null) {

            return;
        }

        parent::__construct("SELECT i.id as 'id',p.ncm as 'ncm', p.unidade as 'unidade', DATE_SUB(i.data,INTERVAL 1 DAY) as 'data',p.codigo as 'codigo',p.nome as 'nome',IFNULL(l.nome,'Propria') as 'logistica',i.quantidade as 'quantidade',i.valor_medio as 'valor',i.icms_recuperado as 'icms',i.total as 'total',i.total_liquido as 'total_liquido',IFNULL(saidas.qtd,0) as 'saidas_mes',IFNULL(entradas.qtd,0) as 'entradas_mes' FROM inventario i INNER JOIN produto p ON i.id_produto=p.id LEFT JOIN empresa l ON p.id_logistica=l.id LEFT JOIN (SELECT ABS(SUM(pp.influencia_estoque)) as 'qtd',pp.id_produto as 'id_produto',MONTH(n.data_emissao) as 'mes',YEAR(n.data_emissao) as 'ano' FROM produto_pedido_saida pp INNER JOIN pedido pe ON pe.id=pp.id_pedido INNER JOIN nota n ON n.id_pedido=pe.id AND n.id_empresa=pe.id_empresa GROUP BY pp.id_produto,MONTH(n.data_emissao),YEAR(n.data_emissao)) saidas ON saidas.id_produto=i.id_produto AND saidas.mes=MONTH(DATE_SUB(i.data, INTERVAL 1 DAY)) AND saidas.ano=YEAR(DATE_SUB(i.data,INTERVAL 1 DAY)) LEFT JOIN (SELECT SUM(pp.influencia_estoque) as 'qtd',pp.id_produto as 'id_produto',MONTH(p.data) as 'mes',YEAR(p.data) as 'ano' FROM produto_pedido_entrada pp INNER JOIN pedido_entrada p ON pp.id_pedido=p.id GROUP BY pp.id_produto,MONTH(p.data),YEAR(p.data)) entradas ON entradas.id_produto=i.id_produto AND entradas.mes=MONTH(DATE_SUB(i.data,INTERVAL 1 DAY)) AND entradas.ano=YEAR(DATE_SUB(i.data,INTERVAL 1 DAY)) WHERE i.id_empresa=$empresa->id", 34);

        $this->nome = "Relatorio Inventario";

        $this->tem_dados_adcionais = true;

        $data = new CampoRelatorio('data', 'Data Inventario', 'DF',false,false,0);

        $data->inicio = (microtime(true)*1000)-(2*24*60*60*1000);
        $data->fim = microtime(true)*1000;

        $codigo = new CampoRelatorio('codigo', 'Cod Prod', 'N',false,false,7);
        $nome = new CampoRelatorio('nome', 'Descricao', 'T',false,false,20);
        $nome->ordem = 1;
        
        $logistica = new CampoRelatorio('logistica', 'Logistica', 'T');
        $quantidade = new CampoRelatorio('quantidade', 'Quant', 'N',false,false,6);
        $unidade = new CampoRelatorio('unidade', 'Un.', 'T',false,false,3);
        $valor_medio = new CampoRelatorio('valor', 'Unitario', 'N',false,false,10);
        $icms = new CampoRelatorio('icms', 'Icms Recup.', 'N',false,false,8);
        $total = new CampoRelatorio('total', 'Parcial', 'N',false,false,8);
        
        $saidas = new CampoRelatorio('saidas_mes', 'Sai', 'N',false,false,5);
        $entradas = new CampoRelatorio('entradas_mes', 'Ent', 'N',false,false,5);
        
        $ncm = new CampoRelatorio('ncm', 'NCM/SH', 'T',false,false,9);
        $total_liquido = new CampoRelatorio('total_liquido', 'Liquido', 'N');

        $this->campos = array(
            $data,
            $ncm,
            $codigo,
            $nome,
            $saidas,
            $entradas,
            $logistica,
            $unidade,
            $quantidade,
            $valor_medio,
            $total,
            $icms,
            $total_liquido);
    }

}
