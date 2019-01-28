<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InterpretadorBooleano
 *
 * @author Renan
 */
class InterpretadorBooleano {

    private static $STR_IDENT = "'";
    private static $VAR_DETECT = "!";
    private static $VAR_SEP = ".";
    private static $FB = ')';
    private static $IB = '(';
    private static $FF = ']';
    private static $SF = ',';
    private static $IF = '[';
    private static $AND = '&';
    private static $OR = '|';
    private static $MAX = '>';
    private static $MIN = '<';
    private static $EQ = '=';
    private static $NG = '~';
    public $funcoes;
    public $leitorNumerico;
    public $obj;

    function __construct() {

        $this->funcoes = array(new GrupoCidadesExp());
        $this->leitorNumerico = new InterpretadorNumerico();
    }

    public function setVariaveis($obj) {

        $this->obj = $obj;
        $this->leitorNumerico->setVariaveis($obj);
    }

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

    public function interpretar($str) {

        return $this->is($str);
    }

    private function is($exp, $in = false) {

        if (!$in) {

            $exp = $this->executeReplace($this->obj, $exp);
        }


        $or = false;
        $exps = array();
        $tps = array();

        $k = 0;
        $p = "";
        for ($i = 0; $i < strlen($exp); $i++) {

            $c = $exp{$i};

            if ($c == self::$IB) {
                $k++;
            } else if ($c == self::$FB) {
                $k--;
            }


            if ($k == 0) {

                if ($c == self::$AND || $c == self::$OR) {

                    $exps[] = $p;
                    $tps[] = $or;
                    $p = "";

                    $or = $c == self::$OR;

                    continue;
                }
            }

            $p .= $c;
        }

        if ($p != "" && $k == 0) {
            $exps[] = $p;
            $tps[] = $or;
            $p = "";
        }

        $resultado = true;

        foreach ($exps as $key => $value) {

            $resultado = $this->basicOp($tps[$key], $resultado, $value);
        }

        return $resultado;
    }

    private function basicOp($or, $op1, $op2) {

        $resultado = -1;

        $ops = array($op1, $op2);


        foreach ($ops as $key => $value) {

            if (is_bool($value)) {

                if (is_bool($resultado)) {
                    $resultado = $or ? ($resultado || $value) : ($resultado && $value);
                } else {
                    $resultado = $value;
                }
            } else {

                $exp = array();
                $sn = array();
                $neg = array();
                $l = 0;

                $k = "";
                for ($i = 0; $i < strlen($value); $i++) {

                    $c = $value{$i};

                    if ($c == self::$IB) {
                        $l++;
                    } else if ($c == self::$FB) {
                        $l--;
                    }

                    if (($c == self::$MAX || $c == self::$MIN || $c == self::$EQ) && $l == 0) {

                        $exp[] = $k;
                        $sn[] = $c;
                        $neg[] = true;
                        $k = "";
                    } else {

                        $k .= $c;
                    }
                }

                if ($k != "" && $l == 0) {

                    $exp[] = $k;
                    $neg[] = true;
                    $k = "";
                }

                foreach ($exp as $key => $value) {

                    while ($exp[$key]{0} == self::$NG) {

                        $exp[$key] = substr($exp[$key], 1);
                        $neg[$key] = !$neg[$key];
                    }
                }



                if (count($sn) == 1) {

                    if ($sn[0] == self::$MAX || $sn[0] == self::$MIN) {

                        $n1 = $this->leitorNumerico->interpretar($exp[0]);
                        $n2 = $this->leitorNumerico->interpretar($exp[1]);

                        $sr = $n1 > $n2;

                        if ($sn[0] == self::$MIN) {

                            $sr = $n1 < $n2;
                        }

                        if (!$neg[0])
                            $sr = !$sr;

                        if (is_bool($resultado)) {
                            $resultado = $or ? ($resultado || $sr) : ($resultado && $sr);
                        } else {
                            $resultado = $sr;
                        }
                    } else if ($sn[0] == self::$EQ) {

                        $sr = true;

                        if ($exp[0]{0} == self::$STR_IDENT) {

                            $sr = $exp[0] == $exp[1];

                            if (!$neg[0])
                                $sr = !$sr;

                            if (is_bool($resultado)) {
                                $resultado = $or ? ($resultado || $sr) : ($resultado && $sr);
                            } else {
                                $resultado = $sr;
                            }
                        } else {

                            $n1 = $this->leitorNumerico->interpretar($exp[0]);
                            $n2 = $this->leitorNumerico->interpretar($exp[1]);

                            $sr = $n1 == $n2;

                            if (!$neg[0])
                                $sr = !$sr;

                            if (is_bool($resultado)) {
                                $resultado = $or ? ($resultado || $sr) : ($resultado && $sr);
                            } else {
                                $resultado = $sr;
                            }
                        }
                    }
                } else if (count($sn) == 0) {

                    if ($exp[0]{0} == self::$IB) {

                        $e = substr(substr($exp[0], 1), 0, -1);

                        $sr = $this->is($e, true);

                        if (!$neg[0])
                            $sr = !$sr;

                        if (is_bool($resultado)) {
                            $resultado = $or ? ($resultado || $sr) : ($resultado && $sr);
                        } else {
                            $resultado = $sr;
                        }
                    } else {


                        $e = substr($exp[0], 0, -1);

                        $ek = explode(self::$IF, $e, 2);

                        if (count($ek) != 2) {

                            return false;
                        }

                        $fn = $ek[0];

                        $args = array("");
                        $k = 0;

                        for ($i = 0; $i < strlen($ek[1]); $i++) {
                            $cc = $ek[1]{$i};
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

                        foreach ($args as $key => $value) {
                            if ($value{0} != self::$STR_IDENT) {

                                $args[$key] = $this->leitorNumerico->interpretar($args[$key]);
                            } else {

                                $args[$key] = substr(substr($args[$key], 1), 0, -1);
                            }
                        }

                        foreach ($this->funcoes as $key => $value) {

                            if ($value->getTermo() == $fn) {

                                if (!$neg[0]) {

                                    $sr = !$value->interpretar($args);

                                    if (is_bool($resultado)) {
                                        $resultado = $or ? ($resultado || $sr) : ($resultado && $sr);
                                    } else {
                                        $resultado = $sr;
                                    }
                                } else {

                                    $sr = $value->interpretar($args);

                                    if (is_bool($resultado)) {
                                        $resultado = $or ? ($resultado || $sr) : ($resultado && $sr);
                                    } else {
                                        $resultado = $sr;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $resultado;
    }

}
