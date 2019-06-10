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
    public $tem_dados_adcionais;
    public $codigo_barras;

    public function __construct($sql, $id) {

        $this->id = $id;
        $this->sql = $sql;
        $this->campos = array();
        $this->order = "";
        $this->tem_dados_adcionais = false;
        $this->codigo_barras = false;

    }
    
    public function getObservacoes($empresa){
        
        return "";
        
    }


    public function getDadosAdcionais($linha){

        return "<strong>teste</strong>";

    }

    public function getPdf($con, $empresa) {

        $id = round(microtime(true) * 1000);

        $logo = $empresa->getLogo($con);

        $bytes = Utilidades::base64decode($logo->logo);

        $aux = strlen($bytes);
        for ($i = 0; $i < $aux; $i += 1024) {
            $buffer = substr($bytes, 0, 1024);
            Sistema::mergeArquivo("bytes_logo_$id.txt", $buffer, false);
            $bytes = substr($bytes, 1024);
        }

        $logo = Sistema::$ENDERECO . "php/uploads/bytes_logo_$id.txt";

        $qtd = $this->getCount($con);

        if ($qtd === 0) {

            throw new Exception("Nao contem registros");
        }

        $mov = $this->getItens($con, 0, $qtd);

        $json = new stdClass();

        $json->logo = $logo;
        $json->titulo_relatorio = $this->nome;
        $json->nome_empresa = $empresa->nome;


        $campos = array();

        foreach ($this->campos as $key => $value) {
            
            if (!$value->agrupado || $value->somente_filtro || $value->porcentagem_coluna_pdf === 0)
                continue;
            
            $campo = new stdClass();
            $campo->porcentagem = $value->porcentagem_coluna_pdf;
            $campo->titulo = $value->titulo;
            $campo->valor = $value->nome;

            $campos[] = $campo;
        }


        $json->campos = $campos;

        $valores = array();


        foreach ($mov as $key => $value) {

            $linha = new stdClass();
            $i = 0;
            foreach ($this->campos as $key2 => $campo) {
                if (!$campo->agrupado || $campo->somente_filtro || $value->porcentagem_coluna_pdf===0)
                    continue;
                $n = $campo->nome;
                $linha->$n = $value->valores_campos[$i];
                $i++;
            }

            $valores[] = $linha;
        }

        $json->elementos = $valores;

        $retorno = str_replace("\\","/",realpath("../uploads")) . "/relatorio_$id.pdf";

        $json->arquivo_retorno = $retorno;
        
        $json->observacoes = $this->getObservacoes($empresa);

        $comando = Utilidades::toJson($json);

        $arquivo = "comando_$id.json";

        Sistema::mergeArquivo($arquivo, $comando, false);

        $comando = Sistema::$ENDERECO . "php/uploads/$arquivo";
        try{
            if(!$this->codigo_barras){
                Sistema::getMicroServicoJava('GeradorRelatorio', $comando);
            }else{
                Sistema::getMicroServicoJava('GeradorRelatorioStart', $comando);
            }
        }catch(Exception $ex){
            
        }
        return Sistema::$ENDERECO . "php/uploads/relatorio_$id.pdf";
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

        if($this->tem_dados_adcionais){

            $query .= "k.id";
            $a = true;

        }

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


            $num = 0;
            $xx = 0;
            foreach ($n as $key => $value) {

                if(!is_numeric($key)){
                    continue;
                }

                if($this->tem_dados_adcionais && $num === 0){
                    $item->id = $value;
                    $xx=1;
                    $num++;
                    continue;
                }

                if (isset($campo_valor[intval($key)-$xx])) {

                    $campo = $campo_valor[intval($key)-$xx];

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
