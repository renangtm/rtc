<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CotacaoEntrada
 *
 * @author Renan
 */
class Logger {

    public static function gerarLog($entidade, $observacao, $notificados = "") {

        $log = new Log();

        $id_usuario = 0;

        $ses = new SessionManager();
        $us = $ses->get('usuario');

        if ($us !== null) {
            $id_usuario = $us->id;
            $log->usuario = $us->id . " - " . $us->nome;
        }

        $con = new ConnectionFactory();


        $agora = round(microtime(true));

        $log->momento = $agora * 1000;
        $log->obs = $observacao;

        $ps = $con->getConexao()->prepare("INSERT INTO logs(id_entidade,tipo_entidade,id_usuario,momento,observacao,notificar) VALUES($entidade->id,'" . get_class($entidade) . "',$id_usuario,FROM_UNIXTIME($agora),'".addslashes($observacao)."','$notificados')");
        $ps->execute();
        $log->id = $ps->insert_id;
        $ps->close();


        $log->notificados = $notificados;

        return $log;
    }

    public static function getLogs($entidade) {

        $con = new ConnectionFactory();

        $ps = $con->getConexao()->prepare("SELECT logs.id,usuario.id,usuario.nome,UNIX_TIMESTAMP(logs.momento)*1000,logs.observacao FROM logs INNER JOIN usuario ON logs.id_usuario=usuario.id WHERE logs.id_entidade=$entidade->id AND logs.tipo_entidade='" . get_class($entidade) . "'");
        $ps->execute();
        $ps->bind_result($id, $id_u, $nome, $momento, $obs);

        $logs = array();

        while ($ps->fetch()) {

            $log = new Log();
            $log->id = $id;
            $log->usuario = $id_u . " - " . $nome;
            $log->momento = $momento;
            $log->obs = $obs;

            $logs[] = $log;
        }

        $ps->close();

        return $logs;
    }

}
