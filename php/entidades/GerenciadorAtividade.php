<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Gerenciador
 *
 * @author Renan
 */
class GerenciadorAtividade {

    public static $TIME_SINAL = 70000; //milisegundos
    public $empresa_consultora;
    public $periodo_inicial;
    public $periodo_final;

    public function __construct($empresa, $periodo_inicial = -1, $periodo_final = -1) {

        $this->empresa_consultora = $empresa;
        $this->periodo_inicial = $periodo_inicial;
        $this->periodo_final = $periodo_final;

        $hora = 1000 * 60 * 60;
        $dia = $hora * 24;


        if ($this->periodo_inicial < 0) {

            $agora = round(microtime(true) * 1000);
            $this->periodo_inicial = $agora - fmod($agora + $hora * 21, $dia);
        }


        if ($this->periodo_final < 0) {

            $this->periodo_final = ($this->periodo_inicial - fmod($this->periodo_inicial + $hora * 21, $dia)) + $dia;
        }
    }

    public function getQuantidadeUsuariosAtivos($con, $filtro = "") {

        $sql = "SELECT COUNT(*) FROM (SELECT a.id FROM atividade_usuario a INNER JOIN usuario u ON u.id=a.id_usuario INNER JOIN empresa e ON e.id=u.id_empresa WHERE a.momento>FROM_UNIXTIME($this->periodo_inicial/1000) AND a.momento<FROM_UNIXTIME($this->periodo_final/1000) ";

        if ($filtro !== "") {

            $sql .= "AND $filtro ";
        }

        $sql .= "GROUP BY id_usuario) k";

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($qtd);
        if ($ps->fetch()) {
            $ps->close();
            return $qtd;
        }
        $ps->close();
        return 0;
    }

    public function getUsuariosAtivos($con, $x1, $x2, $filtro = "", $ordem = "") {

        $sql = "SELECT "
                . "u.id,"
                . "u.nome,"
                . "e.id,"
                . "e.nome,"
                . "e.cnpj,"
                . "UNIX_TIMESTAMP(a.mom)*1000,"
                . "a.online "
                . "FROM "
                . "(SELECT id_usuario,MAX(momento) as 'mom',ABS(UNIX_TIMESTAMP(CURRENT_TIMESTAMP)-UNIX_TIMESTAMP(MAX(momento)))<" . self::$TIME_SINAL . "/1000 as 'online' FROM atividade_usuario WHERE tipo=" . Atividade::$SINAL . " AND momento>FROM_UNIXTIME($this->periodo_inicial/1000) AND momento<FROM_UNIXTIME($this->periodo_final/1000) GROUP BY id_usuario) a "
                . "INNER JOIN usuario u ON u.id=a.id_usuario INNER JOIN empresa e ON e.id=u.id_empresa WHERE a.id_usuario >= 0";


        if ($filtro !== "") {

            $sql .= " AND $filtro";
        }

        if ($ordem !== "") {

            $sql .= " ORDER BY $ordem";
        } else {

            $sql .= " ORDER BY a.online DESC,a.mom DESC";
        }

        $sql .= " LIMIT $x1, " . ($x2 - $x1);

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id, $nome, $id_empresa, $nome_empresa, $cnpj, $ua, $online);

        $usuarios = array();

        while ($ps->fetch()) {

            $usuario = new UsuarioAtividade($this->empresa_consultora);
            $usuario->cnpj_empresa = new CNPJ($cnpj);
            $usuario->nome_empresa = $nome_empresa;
            $usuario->nome = $nome;
            $usuario->gerenciador = $this;
            $usuario->online = $online === 1;
            $usuario->id = $id;
            $usuario->id_empresa = $id_empresa;
            $usuario->ultima_atividade = $ua;

            $usuarios[] = $usuario;
        }
        $ps->close();

        return $usuarios;
    }

    public function getMaximoUsuariosOnline($con) {
        
        
        $ps = $con->getConexao()->prepare("SELECT MAX(l.tt) FROM (SELECT COUNT(*) as 'tt' FROM (SELECT ROUND(UNIX_TIMESTAMP(a1.momento)/70) as 'm' FROM atividade_usuario a1 WHERE a1.momento > FROM_UNIXTIME($this->periodo_inicial/1000) AND a1.momento < FROM_UNIXTIME($this->periodo_final/1000) GROUP BY ROUND(UNIX_TIMESTAMP(a1.momento)/70),a1.id_usuario) k GROUP BY k.m) l");
        $ps->execute();
        $ps->bind_result($qtd);
        if ($ps->fetch()) {
            $ps->close();
            return $qtd;
        }
        $ps->close();
        return 0;
    }
    public function getTempo_Usuarios($con, $intervalo) {

        $atividades = array();

        $ps = $con->getConexao()->prepare("SELECT id_usuario,UNIX_TIMESTAMP(momento)*1000 FROM atividade_usuario WHERE momento>=FROM_UNIXTIME($this->periodo_inicial/1000) AND momento<=FROM_UNIXTIME($this->periodo_final/1000) ORDER BY momento");
        $ps->execute();
        $ps->bind_result($id_usuario, $momento);
        while ($ps->fetch()) {

            $atividades[] = array($id_usuario, $momento);
        }
        $ps->close();


        $pontos = array();

        $inicio = $this->periodo_inicial;
        $fim = $this->periodo_final;

        for (; $inicio <= $fim; $inicio += $intervalo) {

            $fn = $inicio+$intervalo;
            
            $qtd = 0;
            $usuarios = array();

            $i = 0;
            $f = count($atividades);

            while (($f - $i) > 1) {

                $m = floor(($i + $f) / 2);
                $a = $atividades[$m];
                if ($a[1] < $inicio) {
                    $i = $m;
                } else if ($a[1] > $fn) {
                    $f = $m;
                } else {

                    for ($i = $m; $i < $f; $i++) {

                        $aa = $atividades[$i];
                        if ($aa[1] > $fn)
                            break;
                        

                        if (isset($usuarios[$aa[0]]))
                            continue;

                        $qtd++;
                        $usuarios[$aa[0]] = true;
                    }

                    for ($i = $m; $i >= 0; $i--) {

                        $aa = $atividades[$i];

                        if ($aa[1] < $inicio)
                            break;

                        if (isset($usuarios[$aa[0]]))
                            continue;

                        $qtd++;
                        $usuarios[$aa[0]] = true;
                    }


                    break;
                }
            }

            $pontos[] = $qtd;
        }

        return $pontos;
    }
    /*
    public function getTempo_Usuarios($con, $intervalo) {

        $atividades = array();

        $ps = $con->getConexao()->prepare("SELECT id_usuario,UNIX_TIMESTAMP(momento)*1000 FROM atividade_usuario WHERE momento>=FROM_UNIXTIME($this->periodo_inicial/1000) AND momento<=FROM_UNIXTIME($this->periodo_final/1000) ORDER BY momento");
        $ps->execute();
        $ps->bind_result($id_usuario, $momento);
        while ($ps->fetch()) {

            $atividades[] = array($id_usuario, $momento);
        }
        $ps->close();


        $pontos = array();

        $inicio = $this->periodo_inicial;
        $fim = $this->periodo_final;

        for (; $inicio <= $fim; $inicio += $intervalo) {

            $qtd = 0;
            $usuarios = array();

            $i = 0;
            $f = count($atividades);

            while (($f - $i) > 1) {

                $m = floor(($i + $f) / 2);
                $a = $atividades[$m];
                if (($a[1] + self::$TIME_SINAL) < $inicio) {
                    $i = $m;
                } else if ($a[1] > $inicio) {
                    $f = $m;
                } else {

                    for ($i = $m; $i < $f; $i++) {

                        $aa = $atividades[$i];
                        if (($aa[1] + self::$TIME_SINAL) < $inicio)
                            break;
                        

                        if (isset($usuarios[$aa[0]]))
                            continue;

                        $qtd++;
                        $usuarios[$aa[0]] = true;
                    }

                    for ($i = $m; $i >= 0; $i--) {

                        $aa = $atividades[$i];

                        if ($aa[1] > $inicio)
                            break;

                        if (isset($usuarios[$aa[0]]))
                            continue;

                        $qtd++;
                        $usuarios[$aa[0]] = true;
                    }


                    break;
                }
            }

            $pontos[] = $qtd;
        }

        return $pontos;
    }
    */
}
