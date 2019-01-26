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
    
    public static function toHex($str){
        
        $hex = "";
        
        $n = array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f");
        
        for($i=0;$i<strlen($str);$i++){
            
            $k = ord($str{$i});
           
            $hi = "";
            
            while($k>0){
                
                $hi = $n[$k%16].$hi;
                
                $k = ($k-$k%16)/16;
                
            }
            
            $hex .= $hi;
            
        }
        
        return $hex;
        
    }

}
