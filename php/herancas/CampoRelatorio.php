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
class CampoRelatorio {

    public $titulo;
    public $agrupado;
    public $filtro;
    public $nome;
    public $tipo;
    public $possiveis;
    public $somente_filtro;
    public $null_on_group;
    public $porcentagem_coluna_pdf;
    
    function __construct($nome = null, $titulo = null, $tipo = null, $sm=false, $null_on_group=false,$porcentagem_coluna_pdf=10) {

        $this->nome = $nome;
        $this->titulo = $titulo;
        $this->agrupado = true;
        $this->tipo = $tipo;
        $this->filtro = "";
        $this->somente_filtro = $sm;
        $this->null_on_group = $null_on_group;
        $this->possiveis = array();
        $this->porcentagem_coluna_pdf = $porcentagem_coluna_pdf;
        
    }

    function getCampo() {
        if ($this->agrupado) {
            return $this->nome;
        }else{
            if($this->null_on_group){
                return "'------'";
            }
            if($this->tipo === 'N'){
                return "SUM(k.$this->nome)";
            }else if($this->tipo === 'T'){
                return "CASE WHEN MAX(k.$this->nome) IS NOT NULL AND MAX(k.$this->nome) <> '' THEN CONCAT(CONCAT(CONCAT('Ultimo:',MAX(k.$this->nome)),' - Primeiro:'),MIN(k.$this->nome)) ELSE '------' END";
            }else if($this->tipo === 'D'){
                return "CONCAT(CONCAT(CONCAT('De:',FROM_UNIXTIME(MIN(k.$this->nome)/1000)),' - Ate:'),FROM_UNIXTIME(MAX(k.$this->nome)/1000))";
            }
        }
    }

}
