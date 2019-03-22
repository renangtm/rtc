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
            $virtuais[] = $id;
        }
        $ps->close();

        foreach ($virtuais as $key => $virtual) {

            $virtual = new Virtual($virtual, $con);

            //----- INICIAR PERCURSO DE PROSPECCAO

            $empresas = array();

            $ps = $con->getConexao()->prepare("SELECT id FROM empresa WHERE empresa_vendas=$virtual->id");
            $ps->execute();
            $ps->bind_result($id);
            while ($ps->fetch()) {
                $empresas[] = $id;
            }
            $ps->close();

            //-------------------------------------

            foreach ($empresas as $key2 => $empresa) {

                $empresa = new Empresa($empresa, $con);

                $clientes = $empresa->getClientes($con, 0, $virtual->getCountUsuarios($con, "usuario.id_cargo=" . Virtual::CF_ASSISTENTE_VIRTUAL_PROSPECCAO($virtual)->id) * 5, "cliente.id NOT IN (SELECT uc.id_cliente FROM usuario_cliente uc WHERE uc.data_fim IS NULL)");

                foreach ($clientes as $key3 => $cliente) {

                    $tarefa = new Tarefa();
                    $tarefa->tipo_tarefa = Sistema::TT_PROSPECCAO_CLIENTE($virtual->id);
                    $tarefa->prioridade = $tarefa->tipo_tarefa->prioridade;
                    $tarefa->descricao = "Verificar dados do cliente $cliente->razao_social, codigo $cliente->codigo, e tambem verificar o recebimento dos emails promocionais";
                    $tarefa->titulo = "Prospeccao de Cliente";
                    $tarefa->tipo_entidade_relacionada = "CLI";
                    $tarefa->id_entidade_relacionada = $cliente->id;

                    Sistema::novaTarefaEmpresa($con, $tarefa, $virtual);
                }
            }
        }
    }

}
