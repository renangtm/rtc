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
class RelatorioProduto extends Relatorio {

    public function __construct($empresa = null) {

        if ($empresa === null) {

            return;
        }
        
        $categorias = Sistema::getCategoriaProduto();
        
        $categoria = "CASE";
        
        foreach($categorias as $key=>$value){
            
            $categoria.=" WHEN p.id_categoria=".$value->id." THEN '".$value->nome."'";
            
        }
        
        $categoria .= " END as 'categoria'";

        parent::__construct("SELECT p.codigo as 'codigo',$categoria,p.nome as 'nome',p.unidade as 'unidade',CASE WHEN p.liquido THEN 'Liquido' ELSE 'Solido' END as 'estado',p.estoque as 'estoque',p.disponivel as 'disponivel', p.transito as 'transito', p.grade as 'grade', e.nome as 'empresa'  FROM produto p INNER JOIN empresa e ON p.id_empresa=e.id WHERE p.id_empresa=$empresa->id AND p.id_logistica=0", 30);

        $this->nome = "Relatorio Produtos";

        $codigo = new CampoRelatorio('codigo', 'Cod', 'N');
        $categoria = new CampoRelatorio('categoria', 'Categoria', 'T');
        $unidade = new CampoRelatorio('unidade', 'Un', 'T');
        $nome = new CampoRelatorio('nome', 'Nome', 'T');
        $estado = new CampoRelatorio('estado', 'Tipo', 'T');
        $est = new CampoRelatorio('estoque', 'Estq', 'N');
        $disp = new CampoRelatorio('disponivel', 'Disp', 'N');
        $tran = new CampoRelatorio('transito', 'Tran', 'N');
        $cliente = new CampoRelatorio('grade', 'Grade', 'T');
        $empresa = new CampoRelatorio('empresa', 'Empresa', 'T');

        $this->campos = array(
            $codigo,
            $nome,
            $categoria,
            $unidade,
            $estado,
            $est,
            $disp,
            $tran,
            $cliente,
            $empresa);
    }

}
