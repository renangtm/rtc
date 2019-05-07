<?php

class ConnectionFactory {

    private static $conexao;

    public function getConexao() {

        if (self::$conexao == null) {
            self::$conexao = new mysqli("192.168.0.43", "root", "4gft3cm4st3r", "novo_rtc", 3306);
        }


        return self::$conexao;
    }

}

?>