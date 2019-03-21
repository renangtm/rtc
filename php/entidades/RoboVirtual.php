<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegraTabela
 *
 * @author Renan
 */
class RoboVirtual {

    public $dia;
    public $mes;
    public $ano;
    public $hora;
    public $minuto;
    public $segundo;
    public $momento;

    public function __construct() {

        date_default_timezone_set("America/Sao_Paulo");

        $this->momento = round(microtime(true) * 1000);

        $str = explode(':', date('d:m:Y:H:i:s', $this->momento / 1000));
        $this->dia = intval($str[0]);
        $this->mes = intval($str[1]);
        $this->ano = intval($str[2]);
        $this->hora = intval($str[3]);
        $this->minuto = intval($str[4]);
        $this->segundo = intval($str[5]);
    }

    public function executar($con) {

        $virtuais = array();
        $ps = $con->getConexao()->prepare("SELECT id FROM empresa WHERE tipo_empresa=3");
        $ps->execute();
        $ps->bind_result($id);
        while ($ps->fetch()) {
            $v = new Empresa($id,$con);
            $virtuais[] = $v;
        }
        $ps->close();

        foreach ($virtuais as $key => $virtual) {

            $i = 0;
            $usuarios = $virtual->getUsuarios($con, 0, 200000, "usuario.id_cargo=" . Virtual::CF_ASSISTENTE_VIRTUAL_PROSPECCAO($virtual)->id);

            //----- INICIAR PERCURSO DE PROSPECCAO

            $empresas = array();

            $ps = $con->getConexao()->prepare("SELECT id FROM empresa WHERE empresa_vendas=$virtual->id");
            $ps->execute();
            $ps->bind_result($id);
            while ($ps->fetch()) {
                $empresas[] = new Empresa($id);
            }
            $ps->close();

            //-------------------------------------

            foreach ($empresas as $key2 => $empresa) {

                $clientes = $empresa->getClientes($con, 0, count($usuarios) * 5, "cliente.id NOT IN (SELECT uc.id_cliente FROM usuario_cliente uc WHERE uc.data_fim IS NULL)");

                foreach ($clientes as $key3 => $cliente) {

                    $usuario = $usuarios[$i];
                    $i = ($i + 1) % count($usuarios);
                    $usuario->addCliente($con, $cliente, RelacaoUsuarioCliente::$PROSPECCAO);
                }
            }
        }
    }

}
