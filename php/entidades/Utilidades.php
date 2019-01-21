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

    public static function base64encode($val) {

        $this->chrArr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";

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
                    $res .= $this->chrArr{((($k >> ((3 - $j) * 6)) & 63))};
                }
            }
        }

        return $res;
    }

    public function base64decode($val) {

        $this->chrArr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";

        for ($i = 0; $i < strlen($this->chrArr); $i++) {
            $this->invMap[$this->chrArr{$i}] = $i;
        }

        $res = "";

        for ($i = 0; $i < strlen($val); $i += 4) {
            $k = 0;

            $x = 0;
            for ($u = 0; $u < 4 && ($i + $u) < strlen($val); $u++) {

                if ($val{$i + $u} != '=') {
                    if (!isset($this->invMap[$val{$i + $u}])) {
                        return "";
                    }
                    $k = $k << 6 | $this->invMap[$val{$i + $u}];
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

}
