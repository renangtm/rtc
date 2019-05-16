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
class Chat {

    public $nodo_id;
    public $arvore;
    public $nodo_atual;
    public $variaveis;
    public $caminho = array();
    public $empresa;

    private function desmembrar($n) {

        $this->nodo_id[$n->id] = $n;

        foreach ($n->filhos as $key => $value) {

            $this->desmembrar($value);
        }
    }

    private function mostrarProdutos($v) {
        
        $v = explode(' ', $v);

        $filtro = "produto.disponivel > 0";

        
        $a = false;
        foreach ($v as $key => $value) {

            if (strlen($value) < 3) {
                continue;
            }
            
            
            if(!$a){
                $filtro .= " AND (produto.nome like '%$value%' OR produto.ativo like '%$value%'";
            }else{
                $filtro .= " OR produto.nome like '%$value%' OR produto.ativo like '%$value%'";
            }
            
            $a = true;
        }
        
        if($a){
            $filtro .= ")";
        }

        $con = new ConnectionFactory();
        $produtos = $this->empresa->getProdutos($con, 0, 5, $filtro, "produto.disponivel DESC");

        $str = "";


        foreach ($produtos as $key => $value) {

            $str .= "<br><strong>$value->nome</strong>, valor de lista R$ $value->valor_base";

            if (count($value->ofertas) > 0) {

                $str .= ", <h4>OFERTAS</h4><br>";

                foreach ($value->ofertas as $key2 => $value2) {

                    $str .= "Validade: <strong>" . date("d/m/Y", $value2->validade / 1000) . "</strong>, saindo a <strong>R$ " . round($value2->valor, 2) . "</strong><br>";
                }
            }

            $str .= "<hr>";
        }

        if ($str === "") {

            $str = "Nao encontrei produtos, semelhantes ao que voce escreveu.";
        }

        return $str;
    }

    private function unir($n) {

        $n->unido = true;

        foreach ($n->filhos as $key => $value) {

            if ($value->tipo > 2) {

                unset($n->filhos[$key]);

                foreach ($this->nodo_id[$value->tipo - 2]->filhos as $key2 => $value2) {

                    $n->filhos[] = $value2;
                }
            }
        }

        foreach ($n->filhos as $key => $value) {

            if (!isset($value->unido)) {

                $this->unir($value);
            }
        }
    }

    public function __construct($arvore, $empresa) {

        $this->arvore = $arvore;
        $this->nodo_atual = $this->arvore;
        $this->variaveis = array();
        $this->empresa = $empresa;
        $this->nodo_id = array();
        $this->desmembrar($this->arvore);

        $this->unir($this->arvore);

        $this->caminho[] = $this->nodo_atual;
    }

    private function interpretarFala($fala) {

        $str = $fala->expressao;

        if (strpos($str, "mostrarProdutos") !== false) {

            $str = explode("(", $str);
            $str = $str[1];
            $str = substr($str, 0, strlen($str) - 1);

            return $this->mostrarProdutos($this->variaveis[$str]);
        }

        foreach ($this->variaveis as $key => $value) {

            $str = str_replace("($key)", $value, $str);
        }

        return $str;
    }

    public function getFala() {

        $falas = array();

        foreach ($this->nodo_atual->filhos as $key => $value) {

            $nr = $value;

            if ($nr->tipo === NodoChat::$FALA_CHAT) {

                $falas[] = $nr;
            }
        }

        $fala = $falas[rand(0, count($falas) - 1)];

        $this->nodo_atual = $fala;
        $this->caminho[] = $fala;

        return $this->interpretarFala($fala);
    }

    public function analisar($string) {

        $respostas = array();

        foreach ($this->nodo_atual->filhos as $key => $value) {
            $nr = $value;

            if ($nr->tipo === NodoChat::$CAPTURA_USUARIO) {

                $respostas[] = $nr;
            }
        }



        $str = explode(' ', $string);

        foreach ($respostas as $key => $value) {

            $resultado = array($value, 0, 0); //nodo,matches,quantidade,parametros
            $parametros = array(); //parametros

            $partes = explode(' ', $value->expressao);
            $resultado[2] = count($partes);

            foreach ($partes as $key2 => $parametro) {

                if ($parametro{0} === "(" && $parametro{strlen($parametro) - 1} === ")") {

                    $parametros[] = substr($parametro, 1, strlen($parametro) - 2);
                }
            }

            $resultado[2] -= count($parametros);

            $resultado[3] = $parametros;

            $resto = array();

            foreach ($str as $key2 => $palavra) {

                foreach ($partes as $key3 => $alvo) {

                    if (soundex($palavra) == soundex($alvo)) {

                        $resultado[1] ++;

                        continue 2;
                    }
                }

                $resto[] = $palavra;
            }

            if ($resultado[1] >= $resultado[2]) {

                foreach ($parametros as $key2 => $value2) {

                    if (!isset($this->variaveis[$value2])) {

                        $this->variaveis[$value2] = "";
                    }

                    $this->variaveis[$value2] .= $resto[min(count($resto) - 1, $key2)] . " ";

                    if ($key2 === count($parametros) - 1) {

                        for ($i = $key2 + 1; $i < count($resto); $i++) {

                            $this->variaveis[$value2] .= " ".$resto[$i];
                            
                        }
                    }
                }

                $this->nodo_atual = $value;
                $this->caminho[] = $value;

                return true;
            }
        }


        if (count($this->caminho) > 1) {

            $tmp = $this->nodo_atual;
            $this->nodo_atual = $this->caminho[count($this->caminho) - 2];
            unset($this->caminho[count($this->caminho) - 1]);

            if (!$this->analisar($string)) {

                $this->nodo_atual = $tmp;
                $this->caminho[] = $tmp;

                return false;
            } else {

                return true;
            }
        } else {

            return false;
        }
    }

}
