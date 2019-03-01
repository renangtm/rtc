<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegraTabela
 *
 * @author Renan
 */
class Banner {

    public $id;
    public $campanha;
    public $data_inicial;
    public $data_final;
    public $json;
    public $empresa;
    public $tipo;

    function __construct() {

        $this->id = 0;
        $this->campanha = null;
        $this->data_inicial = round(microtime(true) * 1000);
        $this->data_final = round(microtime(true) * 1000);
        $this->json = null;
        $this->tipo = 0;
        $this->empresa = null;
    }

    public function merge($con) {

        if ($this->id == 0) {
            
            $ps = $con->getConexao()->prepare("INSERT INTO banner(id_campanha,data_inicial,data_final,json,id_empresa,tipo) VALUES(" . (($this->campanha !== null) ? $this->campanha->id : 0) . ",FROM_UNIXTIME($this->data_inicial/1000),FROM_UNIXTIME($this->data_final/1000),'" . addslashes($this->json) . "',".$this->empresa->id.",$this->tipo)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE banner SET id_campanha=" . (($this->campanha !== null) ? $this->campanha->id : 0) . ",data_inicial=FROM_UNIXTIME($this->data_inicial/1000),data_final=FROM_UNIXTIME($this->data_final/1000),json='" . addslashes($this->json) . "',id_empresa=" . $this->empresa->id . ", tipo=$this->tipo  WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("DELETE FROM banner WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

    private function replacer($str, $produto) {

        date_default_timezone_set('America/Sao_Paulo');
        
        if ($produto === null) {

            return $str;
        }

        $nome_produto = $produto->produto->nome;
        $validade = date('d/m/y', $produto->validade/1000);
        $inicio = date('d/m/y', $produto->campanha->inicio/1000);;
        $fim = date('d/m/y', $produto->campanha->fim/1000);;
        $valor = $produto->valor;
        $limite = $produto->limite;
        $imagem = $produto->produto->imagem;
        if ($limite < 0) {
            $limite = "Sem limite";
        }

        return str_replace(array("@nome_produto", "@validade", "@incio", "@fim", "@valor", "@limite","@imagem"), array($nome_produto, $validade, $inicio, $fim, $valor, $limite, $imagem), $str);
    }

    private function compileJson($item, $produto) {

        $p = $produto;

        if ($item->tipo === -1) {

            return "</$item->valor>";
        }

        if ($item->tipo === 0) {

            $tag = "<$item->valor";

            foreach ($item->atributos as $att => $value) {

                if ($value === true) {
                    $tag .= " $att";
                    continue;
                }

                $tag .= " $att=$value";
            }

            $tag .= ">";

            if (isset($item->atributos->inicio) && isset($item->atributos->fim)) {

                if ($this->campanha === null)
                    return "";

                $str = "";

                $pri = intval($item->atributos->inicio);
                $ult = intval($item->atributos->fim);

                for (; $pri < $ult; $pri++) {
                    if (isset($this->campanha->produtos[$pri])) {
                        $prod = $this->campanha->produtos[$pri];
                        $str .= $this->replacer($tag, $prod);
                        foreach ($item->filhos as $key => $value) {
                            $str .= $this->compileJson($value, $prod);
                        }
                        if ($item->fechamento !== null) {
                            $str .= $this->compileJson($item->fechamento, $prod);
                        }
                    }
                }

                return $str;
            } else if (isset($item->atributos->produto)) {

                if ($this->campanha === null)
                    return "";

                $pro = intval($item->atributos->produto);

                if (isset($this->campanha->produtos[$pro])) {
                    $str = "";
                    $prod = $this->campanha->produtos[$pro];
                    $str .= $this->replacer($tag, $prod);
                    foreach ($item->filhos as $key => $value) {
                        $str .= $this->compileJson($value, $prod);
                    }
                    if ($item->fechamento !== null) {
                        $str .= $this->compileJson($item->fechamento, $prod);
                    }
                }

                return $str;
            } else {

                $str = "";
                $str .= $this->replacer($tag, $produto);
                foreach ($item->filhos as $key => $value) {
                    $str .= $this->compileJson($value, $produto);
                }
                if ($item->fechamento !== null) {
                    $str .= $this->compileJson($item->fechamento, $produto);
                }

                return $str;
            }
        }

        if ($item->tipo === 1) {

            return $this->replacer($item->valor, $produto);
        }

        return "";
    }

    public function getHTML() {

        $json = file_get_contents($this->json);

        $obj = json_decode($json);

        return $this->compileJson($obj, null);
    }

}
