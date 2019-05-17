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
class TTRecepcaoCliente2 extends TipoTarefa {

    public $id_empresa;

    function __construct($id_empresa) {

        parent::__construct(19, $id_empresa);

        $this->id_empresa = $id_empresa;

        $this->nome = "Recepcao de Cliente M2";
        $this->tempo_medio = 0.2;
        $this->prioridade = 10;
        $this->cargos = array(
            Virtual::CF_ASSISTENTE_VIRTUAL_RECEPCAO_M2(new Empresa($id_empresa))
        );
        $this->carregarDados();
    }

    public function getObservacaoPadrao($tarefa) {
        $this->observacao_padrao = "#AGENDAR_PROXIMA_PARA: " . date('d/m/Y H:i') . "<br>";
        $this->observacao_padrao .= "#OBSERVACOES: _____ ";
        return $this->observacao_padrao;
    }

    public function aoAtribuir($id_usuario, $tarefa) {

    }

    public function init($tarefa) {
        date_default_timezone_set("America/Sao_Paulo");
        $dados = array();

        foreach ($tarefa->observacoes as $key => $value) {
            if (!$value->cadastrada_agora) {
                continue;
            }
            $o = str_replace(array("<br>"), array(" "), $value->observacao);
            $o = explode("#", $o);
            foreach ($o as $k => $d) {
                $val = explode(":", $d, 2);
                if (count($val) < 2) {
                    continue;
                }
                $val2 = $val[1];
                $val = $val[0];
                if (strlen($val) === 0 || strlen($val2) === 0) {
                    continue;
                }
                while ($val2{0} === " ") {
                    $val2 = substr($val2, 1);
                }
                $dados[strtolower($val)] = $val2;
            }
        }


        if (isset($dados['agendar_proxima_para'])) {

            $time = $dados['agendar_proxima_para'];
            $time = str_replace("/", "-", $time);
            $time = strtotime($time);

            $con = new ConnectionFactory();
            $ps = $con->getConexao()->prepare("UPDATE tarefa SET inicio_minimo=inicio_minimo, agendamento=FROM_UNIXTIME($time) WHERE id=$tarefa->id");
            $ps->execute();
            $ps->close();
        }
    }

}
