<?php

class ConnectionFactory {

    private static $conexao;

    public function getConexao() {

        if (self::$conexao == null) {
            self::$conexao = new mysqli("rtcd.rtcagro.com.br", "root", "4gft3cm4st3r", "novo_rtc", 45853);
        }
        
        return self::$conexao;
    }

}

?>