<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utilidades
 *
 * @author Renan
 */
class Utilidades {

    public static function toJson($object, $pilha = null) {

        if ($object === null) {

            return "null";
            
        }
        
        if(!is_object($object)){
            
            return $object;
            
        }

        if ($pilha == null) {

            $pilha = array();
        }

        $str = '{';

        $str .= "\"_classe\":\"" . get_class($object) . "\"";

        foreach ($pilha as $key => $value) {

            if ($value === $object) {

                $v = count($pilha) - $key;

                $str .= ",\"recursao\":$v";

                return $str . "}";
            }
        }

        $pilha[] = $object;

        foreach ($object as $atributo => $valor) {

            if (is_numeric($valor)) {

                $str .= ",\"$atributo\":$valor";
            } else if (is_string($valor)) {

                $str .= ",\"$atributo\":\"$valor\"";
                
            } else if (is_array($valor)) {

                $str .= ",\"$atributo\":[";

                foreach ($valor as $i => $val) {

                    if ($i > 0)
                        $str .= ",";

                    $str .= Utilidades::toJson($val, $pilha);
                }

                $str .= "]";
            }else if (is_object($valor)) {

                $str .= ",\"$atributo\":" . Utilidades::toJson($valor, $pilha);
            }
        }


        $str .= '}';

        unset($pilha[count($pilha) - 1]);

        return $str;
    }

    private static function getObject($obj, $pilha = null) {

        if ($pilha == null) {

            $pilha = array();
        }
        
        if(!is_object($obj)){
            
            return $obj;
            
        }

        if (isset($obj->recursao)) {

            return $pilha[count($pilha) - $obj->recursao];
        }

        $real = null;

        eval('$real = new ' . $obj->_classe . "();");

        $pilha[] = $real;

        foreach ($obj as $atributo => $valor) {

            if (is_numeric($valor) || is_string($valor)) {

                $real->$atributo = $valor;
            } else if (is_array($valor)) {

                $vet = array();

                foreach ($valor as $i => $val) {

                    $vet[] = self::getObject($val, $pilha);
                }

                $real->$atributo = $vet;
            } else if (is_object($valor)) {

                $real->$atributo = self::getObject($valor, $pilha);
            }
        }

        unset($pilha[count($pilha)]);

        return $real;
    }

    public static function fromJson($str) {

        $js = json_decode($str);
        
        return self::getObject($js);
        
    }

    public static function getEmpresaTeste() {

        $empresa = new Empresa();

        $empresa->nome = "Teste";
        $empresa->cnpj = new CNPJ("11122233344455");
        $empresa->inscricao_estadual = "1234412";
        $empresa->juros_mensal = 1.5;

        $e1 = new Endereco();

        $e1->rua = "Rua Teste";
        $e1->bairro = "Bairro Teste";
        $e1->numero = 0;
        $e1->cep = new CEP("07195201");
        $e1->cidade = Sistema::getCidades(new ConnectionFactory());
        $e1->cidade = $e1->cidade[0];

        $empresa->endereco = $e1;

        $empresa->email = new Email("teserewfdwefd");

        $empresa->telefone = new Telefone("t1241243");


        $empresa->merge(new ConnectionFactory());

        return $empresa;
    }

    public static function base64encode($val) {

        $chrArr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";

        $res = "";

        for ($i = 0; $i < strlen($val); $i += 3) {
            $k = 0;

            $u = 0;
            for (; $u < 3 && ($i + $u) < strlen($val); $u++)
                $k = $k << 8 | ord($val{$i + $u});
            for ($a = $u; $a < 3; $a++)
                $k = $k << 8;

            for ($j = 0; $j < 4; $j++) {
                if ($j > $u) {
                    $res .= "=";
                } else {
                    $res .= $chrArr{((($k >> ((3 - $j) * 6)) & 63))};
                }
            }
        }

        return $res;
    }

    public static function base64decode($val) {

        $chrArr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";

        for ($i = 0; $i < strlen($chrArr); $i++) {
            $invMap[$chrArr{$i}] = $i;
        }

        $res = "";

        for ($i = 0; $i < strlen($val); $i += 4) {
            $k = 0;

            $x = 0;
            for ($u = 0; $u < 4 && ($i + $u) < strlen($val); $u++) {

                if ($val{$i + $u} != '=') {
                    if (!isset($invMap[$val{$i + $u}])) {
                        return "";
                    }
                    $k = $k << 6 | $invMap[$val{$i + $u}];
                    $x += 6;
                } else {
                    $k = $k << 6;
                }
            }

            for ($j = 0; $j < 3 && $x >= 8; $j++, $x -= 8) {
                $res .= chr(($k >> (2 - $j) * 8) & 255);
            }
        }

        return $res;
    }

    public static function toHex($str) {

        $hex = "";

        $n = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");

        for ($i = 0; $i < strlen($str); $i++) {

            $k = ord($str{$i});

            $hi = "";

            while ($k > 0) {

                $hi = $n[$k % 16] . $hi;

                $k = ($k - $k % 16) / 16;
            }

            $hex .= $hi;
        }

        return $hex;
    }

}
