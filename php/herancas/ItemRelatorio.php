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
class ItemRelatorio {

    public $campos_agrupados;
    public $valores_campos_agrupados;
    public $campos;
    public $valores_campos;
    public $relatorio;
    public $quantidade_filhos;

    function __construct($relatorio) {

        $this->relatorio = $relatorio;

        $this->campos_agrupados = array();
        $this->valores_campos_agrupados = array();

        $this->campos = array();
        $this->valores_campos = array();

        $this->quantidade_filhos = 0;
    }

    public function getFilhos($con) {

        if ($this->quantidade_filhos === 0) {

            return 0;
        }

        $query = "SELECT ";

        $a = false;
        foreach ($this->campos_agrupados as $key => $value) {

            if ($a) {
                $query .= ",";
            }

            $query .= "k.$value->nome";

            $a = true;
        }

        $query .= " FROM (" . $this->relatorio->sql . ") k ";

        $w = "";

        foreach ($this->campos as $key => $campo) {

            if ($w === "") {

                $w .= "WHERE k.$campo->nome='" . $this->valores_campos[$key] . "'";
            } else {

                $w .= " AND k.$campo->nome='" . $this->valores_campos[$key] . "'";
            }
        }



        $query .= $w;

        if ($this->relatorio->order !== "") {

            $query .= " ORDER BY " . $this->relatorio->order;
        }


        $filhos = array();
        $ps = mysqli_query($con->getConexao(), $query);
        while ($n = mysqli_fetch_array($ps)) {

            $filho = new ItemRelatorio($this->relatorio);

            foreach ($n as $key => $value) {
                if (isset($this->campos_agrupados[$key])) {
                    $campo = $this->campos_agrupados[$key];

                    $filho->campos[] = $campo;
                    $filho->valores_campos[] = $value;
                }
            }

            $filhos[] = $filho;
        }

        return $filhos;
    }

}
