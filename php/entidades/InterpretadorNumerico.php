<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InterpretadorNumerico
 *
 * @author Renan
 */
class InterpretadorNumerico {

    private static $STR_IDENT = "'";
    private static $IF = '[';
    private static $SF = ',';
    private static $FF = ']';
    private static $VAR_DETECT = "!";
    private static $VAR_SEP = ".";
    private static $FB = ')';
    private static $IB = '(';
    private static $ADD = '+';
    private static $SUB = '-';
    private static $MULT = '*';
    private static $DIV = '/';
    private $replacer;
    private $index;
    public $funcoesNumericas;
    private $obj;

    private function executeReplace($obj, $str, $prefix = "") {

        if ($obj == null) {

            return $str;
        }

        foreach ($obj as $key => $value) {

            if (!is_object($value)) {

                $str = str_replace(self::$VAR_DETECT . $prefix . $key, $value, $str);
            } else {


                $str = $this->executeReplace($value, $str, $prefix . $key . self::$VAR_SEP);
            }
        }

        return $str;
    }

    function __construct() {
        
        $this->funcoesNumericas = array(new Max(), new Min(), new Baixo(), new Cima());
        
    }

    public function setVariaveis($obj) {

        $this->obj = $obj;
    }

    private function valor($exp, $in = false) {

        if (!$in) {

            $this->index = 0;

            $exp = $this->executeReplace($this->obj, $exp);
        }

        $resultado = 0;

        $multiplex = 1;

        $sub = false;

        $div = false;

        $prem = "";


        for (; $this->index < strlen($exp); $this->index++) {

            $c = $exp{$this->index};


            if ($c == self::$ADD || $c == self::$FB || $c == self::$SUB) {

                $val = doubleval($prem);

                if ($div) {

                    $val = $multiplex / $val;
                } else {

                    $val = $multiplex * $val;
                }


                if ($sub) {
                    $resultado -= $val;
                } else {
                    $resultado += $val;
                }


                $prem = "";

                $multiplex = 1;

                $sub = $c == self::$SUB;

                $div = false;

                if ($c == self::$FB) {

                    break;
                }
            } else if ($c == self::$MULT || $c == self::$DIV) {

                $val = doubleval($prem);

                if ($div) {

                    $multiplex /= $val;
                } else {

                    $multiplex *= $val;
                }

                $div = $c == self::$DIV;

                $prem = "";
            } else if ($c == self::$IB) {

                $this->index++;
                $prem = "" . $this->valor($exp, true);
                $this->index--;
            } else if ($c == self::$IF) {


                $sk = "";

                $this->index++;
                for ($l = 1; $this->index < strlen($exp); $this->index++) {
                    $cc = $exp{$this->index};
                    if ($cc == self::$IF) {
                        $l++;
                    } else if ($cc == self::$FF) {
                        $l--;
                    }
                    if ($l == 0 && $cc == self::$FF)
                        break;
                    $sk .= $cc;
                }

                $args = array("");
                $k = 0;

                for ($i = 0; $i < strlen($sk); $i++) {
                    $cc = $sk{$i};
                    if ($cc == self::$IF) {
                        $k++;
                    } else if ($cc == self::$FF) {
                        $k--;
                    }

                    if ($k == 0 && $cc == self::$SF) {
                        $args[] = "";
                        continue;
                    }

                    $args[count($args) - 1] .= $cc;
                }


                foreach ($args as $key => $arg) {
                    if ($arg{0} == self::$STR_IDENT) {
                        $args[$key] = substr(substr($args[$key], 1), 0, -1);
                    } else {
                        $sl = new InterpretadorNumerico(null);
                        $sl->funcoesNumericas = $this->funcoesNumericas;
                        $args[$key] = $sl->valor($arg);
                    }
                }

                foreach ($this->funcoesNumericas as $key => $func) {
                    if ($func->getTermo() == $prem) {
                        $prem = $func->interpretar($args);
                        break;
                    }
                }
            } else {

                $prem .= $c;
            }
        }

        if ($this->index == strlen($exp)) {

            $val = doubleval($prem);

            if ($div) {

                $val = $multiplex / $val;
            } else {

                $val = $multiplex * $val;
            }


            if ($sub) {
                $resultado -= $val;
            } else {
                $resultado += $val;
            }
        }

        $this->index++;
        return $resultado;
    }

    public function interpretar($str) {

        return $this->valor($str);
    }

}
