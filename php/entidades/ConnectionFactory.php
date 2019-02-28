<?php

class ConnectionFactory {

    private static $conexao;

    public function getConexao() {

        if (self::$conexao == null) {
            self::$conexao = new mysqli("192.168.0.251", "root", "m4st3rk3y1", "novo_rtc", 3306);
        }


        return self::$conexao;
    }

}

?>