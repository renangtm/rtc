<?php

class ConnectionFactory {

    private static $conexao;

    public function getConexao() {

        if (self::$conexao == null) {
            self::$conexao = new mysqli("www.rtcagro.com.br", "root", "4gft3cm4st3r", "novo_rtc", 3306);
        }


        return self::$conexao;
    }

}

?>