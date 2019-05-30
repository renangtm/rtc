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
class TTRecepcaoCliente extends TipoTarefa {

    public $id_empresa;

    function __construct($id_empresa) {

        parent::__construct(12, $id_empresa);

        $this->id_empresa = $id_empresa;

        $this->classes = array(
            array(
                "<strong style='color:black'>Indefinido, jogar para o suporte</strong>"
                ,"<strong style='color:green'>Aderiu ao RTC, jogar para o suporte</strong>",
                "<strong style='color:Orange'>Nao quer trabalhar momentaneamente com a agrofauna</strong>",
                "<strong style='color:Red'>Nao quer trabalhar com a Agro Fauna</strong>",
                "<strong style='color:Purple'>Faliu ou morreu</strong>",
                "<strong style='color:Gray'>Nao atende</strong>",
                "<strong style='color:Brown'>Nao se encontra</strong>"));
        
        $this->nome = "Recepcao de Cliente";
        $this->tempo_medio = 0.2;
        $this->prioridade = 10;
        $this->cargos = array(
            Virtual::CF_ASSISTENTE_VIRTUAL_RECEPCAO(new Empresa($id_empresa))
        );
        $this->carregarDados();
    }
    
    public function getOpcoes($con,$tarefa) {
        
        $ps = $con->getConexao()->prepare("SELECT classe_virtual FROM cliente WHERE id=$tarefa->id_entidade_relacionada");
        $ps->execute();
        $ps->bind_result($classe_virtual);
        if($ps->fetch()){
            return array($classe_virtual);
        }
        $ps->close();
        return array(0);
        
    }

    public function getObservacaoPadrao($tarefa) {
        $this->observacao_padrao = "#AGENDAR_PROXIMA_PARA: " . date('d/m/Y H:i') . "<br>";
        $this->observacao_padrao .= "#OBSERVACOES: _____ ";
        return $this->observacao_padrao;
    }

    public function aoAtribuir($id_usuario, $tarefa) {

        $con = new ConnectionFactory();
        $relacionamento = new RelacaoUsuarioCliente();
        $relacionamento->situacao = RelacaoUsuarioCliente::$RECEPCAO;
        $relacionamento->cliente = new stdClass();
        $relacionamento->cliente->id = $tarefa->id_entidade_relacionada;
        $relacionamento->merge($con);

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
        
        $con = new ConnectionFactory();
        
        $ps = $con->getConexao()->prepare("UPDATE cliente SET classe_virtual=".$tarefa->opcoes[0]." WHERE id=".$tarefa->id_entidade_relacionada);
        $ps->execute();
        $ps->close();
        
    }

    public function aoFinalizar($tarefa, $usuario) {

        $str = "";

        foreach ($tarefa->observacoes as $key => $obs) {

            $str .= $obs->observacao;
        }
        
        $con = new ConnectionFactory();
        
        $ps = $con->getConexao()->prepare("UPDATE cliente SET classe_virtual=".$tarefa->opcoes[0]." WHERE id=".$tarefa->id_entidade_relacionada);
        $ps->execute();
        $ps->close();
        
        if ($tarefa->opcoes[0] >1) {

            $ps = $con->getConexao()->prepare("UPDATE tarefa SET sucesso=0,inicio_minimo=inicio_minimo WHERE id=$tarefa->id");
            $ps->execute();
            $ps->close();

            return;
        }

        

        $tarefa_ = new Tarefa();
        $tarefa_->tipo_tarefa = Sistema::TT_SUPORTE_CLIENTE($this->id_empresa);
        $tarefa_->titulo = "Suporte ao Cliente";
        $tarefa_->descricao = "Preste suporte ao cliente " . $tarefa->id_entidade_relacionada . " para o RTC ";
        $tarefa_->id_entidade_relacionada = $tarefa->id_entidade_relacionada;
        $tarefa_->tipo_entidade_relacionada = $tarefa->tipo_entidade_relacionada;

        $tamanho = 0;

        foreach ($tarefa->observacoes as $key => $value) {
            $tamanho += strlen($value->observacao);
        }

        $pontos = ($tamanho > 500) ? 3 : ($tamanho > 200 ? 2 : 1);
        $atividade = $usuario->getAtividadeUsuarioClienteAtual($con);
        $atividade->pontos_atendimento += $pontos;
        $atividade->merge($con);

        Sistema::novaTarefaEmpresa($con, $tarefa_, new Virtual($this->id_empresa, $con));

        $ps = $con->getConexao()->prepare("UPDATE usuario_cliente SET data_inicio=data_inicio, data_fim=data_fim,situacao=" . RelacaoUsuarioCliente::$RECEPCAO_INATIVA . " WHERE id_usuario=$usuario->id AND id_cliente=$tarefa->id_entidade_relacionada");
        $ps->execute();
        $ps->close();
    }

}
