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

    private static $TIME = 720000;
    //12 minutos por default;

    private $tempo;

    function __construct($tempo = 0) {
        if ($tempo === 0) {
            $this->tempo = self::$TIME;
        } else {
            $this->tempo = $tempo;
        }
    }

    public function getCache($nome, $json = true) {

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

        if (($agora - $tm) > $this->tempo) {

            unlink($f);
            unlink($q);

            return null;
        }

        $conteudo = file_get_contents($f);
        $conteudo = mb_convert_encoding($conteudo, "UTF-8", "UTF-8");

        if ($json) {
            $obj = Utilidades::fromJson($conteudo);
        } else {
            $obj = $conteudo;
        }
        return $obj;
    }

    public function setCache($nome, $valor, $json = true) {

        $str = $valor;

        if ($json) {
            $str = Utilidades::toJson($valor);
        }

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
