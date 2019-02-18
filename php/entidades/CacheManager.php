<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CacheManager
 *
 * @author T-Gamer
 */
class CacheManager {

    private static $TIME = 720000; //12 minutos;

    public function getCache($nome) {

        $agora = round(microtime(true) * 1000);

        $f = $nome . ".txt";
        $q = $nome . "_time.txt";

        if (!file_exists($f) || !file_exists($q)) {

            if (file_exists($f)) {

                unlink($f);
            }

            if (file_exists($q)) {

                unlink($q);
            }

            return null;
        }

        $tm = doubleval(file_get_contents($q));

        if (($agora - $tm) > self::$TIME) {

            unlink($f);
            unlink($q);

            return null;
        }

        $conteudo = file_get_contents($f);
        $conteudo = mb_convert_encoding($conteudo, "UTF-8", "UTF-8");


        $obj = Utilidades::fromJson($conteudo);

        return $obj;
    }

    public function setCache($nome, $valor) {

        $str = Utilidades::toJson($valor);

        $agora = round(microtime(true) * 1000);

        $f = $nome . ".txt";
        $q = $nome . "_time.txt";

        if (file_exists($f)) {

            unlink($f);
        }

        if (file_exists($q)) {

            unlink($q);
        }


        $handler = fopen($f, 'w');
        fwrite($handler, $str);
        fclose($handler);

        $handler = fopen($q, 'w');
        fwrite($handler, $agora);
        fclose($handler);
    }

}
