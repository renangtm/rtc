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
class RelatorioEstoque extends Relatorio {


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
       
        return "Relatorio de Estoque Gerado na data de ".date('d/m/Y',($this->campos[1]->inicio/1000));
       
    }
    
    public function __construct($empresa = null) {

        if ($empresa === null) {

            return;
        }

        parent::__construct("SELECT i.id as 'id',p.ncm as 'ncm', p.unidade as 'unidade', DATE_SUB(i.data,INTERVAL 1 DAY) as 'data',p.codigo as 'codigo',p.nome as 'nome',IFNULL(l.nome,'Propria') as 'logistica',i.quantidade as 'quantidade',i.valor_medio as 'valor',i.icms_recuperado as 'icms',i.total as 'total',i.total_liquido as 'total_liquido' FROM inventario i INNER JOIN produto p ON i.id_produto=p.id LEFT JOIN empresa l ON p.id_logistica=l.id WHERE i.id_empresa=$empresa->id", 85);

        $this->nome = "Relatorio Estoque";

        $this->tem_dados_adcionais = true;

        $data = new CampoRelatorio('data', 'Data Inventario', 'DF',false,false,10);

        $data->inicio = (microtime(true)*1000)-(2*24*60*60*1000);
        $data->fim = microtime(true)*1000;

        $codigo = new CampoRelatorio('codigo', 'Cod Prod', 'N',false,false,10);
        $nome = new CampoRelatorio('nome', 'Descricao', 'T',false,false,40);
        $nome->ordem = 1;
        $logistica = new CampoRelatorio('logistica', 'Logistica', 'T',false,false,20);
        $quantidade = new CampoRelatorio('quantidade', 'Quant', 'N',false,false,10);
        $unidade = new CampoRelatorio('unidade', 'Unid.', 'T',false,false,10);
        $valor_medio = new CampoRelatorio('valor', 'Unitario', 'N');
        $icms = new CampoRelatorio('icms', 'Icms Recup.', 'N');
        $total = new CampoRelatorio('total', 'Parcial', 'N');
        $ncm = new CampoRelatorio('ncm', 'NCM/SH', 'T',false,false,9);
        $total_liquido = new CampoRelatorio('total_liquido', 'Liquido', 'N');

        $this->campos = array(
            $codigo,
            $data,
            $nome,
            $logistica,
            $unidade,
            $quantidade);
    }

}
