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
class Relatorio {

    public $id;
    public $nome;
    public $campos;
    public $sql;
    public $order;

    public function __construct($sql, $id) {

        $this->id = $id;
        $this->sql = $sql;
        $this->campos = array();
        $this->order = "";
    }

    public function getXsd($con) {

        $qtd = $this->getCount($con);

        $mov = $this->getItens($con, 0, $qtd);

        $t = round(microtime(true) * 1000);

        $arquivo = get_class($this) . "_" . $t . ".xls";

        Sistema::mergeArquivo($arquivo, "<table>", false);

        $a = false;

        $buffer = "";
        foreach ($mov as $key => $value) {

            if (!$a) {

                $buffer .= "<tr>";

                foreach ($value->campos as $key2 => $value2) {

                    $buffer .= "<td>" . $value2->titulo . "</td>";
                }

                $buffer .= "</tr>";

                $a = true;
            }

            $buffer .= "<tr>";

            foreach ($value->valores_campos as $key2 => $value2) {


                if ($value->campos[$key2]->tipo === 'N') {

                    $value2 = str_replace('.', ',', $value2 . "");
                }

                $buffer .= "<td>" . $value2 . "</td>";
            }

            $buffer .= "</tr>";

            if (strlen($buffer) > 10000) {

                Sistema::mergeArquivo($arquivo, $buffer, false);
                $buffer = "";
            }
        }

        $buffer .= "</table>";

        Sistema::mergeArquivo($arquivo, $buffer, false);

        return $arquivo;
    }

    public function getCount($con) {

        $query = "SELECT *,COUNT(*) FROM ($this->sql) k";

        $where = "";
        $groupby = "";

        $a = false;
        foreach ($this->campos as $key => $campo) {

            if ($campo->filtro !== "") {

                if ($where === "") {
                    $where = "WHERE $campo->filtro";
                } else {
                    $where .= " AND $campo->filtro";
                }
            }

            if ($campo->somente_filtro) {
                continue;
            }

            if ($campo->agrupado) {
                if ($groupby === "") {
                    $groupby = "GROUP BY k.$campo->nome";
                } else {
                    $groupby .= ",k.$campo->nome";
                }
            }
        }

        if ($where !== "") {
            $query .= " $where";
        }

        if ($groupby !== "") {
            $query .= " $groupby";
        }

        $query = "SELECT COUNT(*) FROM ($query) kk";



        $ps = $con->getConexao()->prepare($query);
        $ps->execute();
        $ps->bind_result($qtd);
        if ($ps->fetch()) {
            $ps->close();
            return $qtd;
        }
        $ps->close();
        return 0;
    }

    public function getItens($con, $x1, $x2) {

        $query = "SELECT ";

        $where = "";
        $groupby = "";


        $campo_valor = array();

        $a = false;
        foreach ($this->campos as $key => $campo) {

            if ($campo->filtro !== "") {

                if ($where === "") {
                    $where = "WHERE $campo->filtro";
                } else {
                    $where .= " AND $campo->filtro";
                }
            }

            if ($campo->somente_filtro) {
                continue;
            }

            if ($a) {
                $query .= ",";
            }
            $campo_valor[] = $campo;
            $query .= $campo->getCampo();

            $a = true;



            if ($campo->agrupado) {
                if ($groupby === "") {
                    $groupby = "GROUP BY k.$campo->nome";
                } else {
                    $groupby .= ",k.$campo->nome";
                }
            }
        }

        $query .= ",COUNT(*) FROM ($this->sql) k";

        if ($where !== "") {
            $query .= " $where";
        }

        if ($groupby !== "") {
            $query .= " $groupby";
        }

        if ($this->order !== "") {
            $query .= " ORDER BY $this->order";
        }

        $query .= " LIMIT $x1, " . ($x2 - $x1);


        $ps = mysqli_query($con->getConexao(), $query);

        $itens = array();

        while ($n = mysqli_fetch_array($ps)) {

            $item = new ItemRelatorio($this);

            foreach ($n as $key => $value) {

                if (isset($campo_valor[$key])) {

                    $campo = $campo_valor[$key];

                    if ($campo->agrupado) {

                        $item->campos[] = $campo;
                        $item->valores_campos[] = $value;
                    } else {

                        $item->campos_agrupados[] = $campo;
                        $item->valores_campos_agrupados[] = $value;
                    }
                } else {

                    $item->quantidade_filhos = intval($value . "");
                }
            }

            $itens[] = $item;
        }

        return $itens;
    }

}
