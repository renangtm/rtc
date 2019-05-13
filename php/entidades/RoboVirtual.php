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

    private static $NUMERO_PROSPECCOES_EXTERNAS = 0;
    public $dia;
    public $mes;
    public $ano;
    public $hora;
    public $minuto;
    public $segundo;
    public $momento;
    public $dia_semana;
    
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
        $this->dia_semana = intval(date('w',$this->momento/1000));
        
    }

    public function executar($con) {
        
        if($this->dia_semana === 0 || $this->dia_semana === 6){
            return;
        }

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

                $clientes = $empresa->getClientes($con, 0, $virtual->getCountUsuarios($con, "usuario.id_cargo=" . Virtual::CF_ASSISTENTE_VIRTUAL_PROSPECCAO($virtual)->id) * 50, "cliente.id NOT IN (SELECT uc.id_cliente FROM usuario_cliente uc WHERE uc.data_fim IS NULL) AND cliente.prospectar_ignorar_pular=0 AND cliente.pessoa_fisica=false AND cliente.cnpj <> '00.000.000/0000-00'");

                foreach ($clientes as $key3 => $cliente) {

                    if (count($cliente->telefones) === 0) {
                        continue;
                    }

                    if ($cliente->telefones[0]->numero === "0000-0000") {
                        continue;
                    }
                    
                    if($cliente->cnpj->valor==='00.000.000/0000-00'){
                        continue;
                    }

                    $tarefa = new Tarefa();
                    $tarefa->tipo_tarefa = Sistema::TT_PROSPECCAO_CLIENTE($virtual->id);
                    $tarefa->prioridade = $tarefa->tipo_tarefa->prioridade;
                    $tarefa->descricao = "Cliente: $cliente->razao_social, Codigo: $cliente->codigo,"
                            . " Rua: " . $cliente->endereco->rua . ", Bairro: " . $cliente->endereco->bairro . ","
                            . " Estado: " . $cliente->endereco->cidade->estado->sigla . ","
                            . " Cidade: " . $cliente->endereco->cidade->nome . ","
                            . " Numero: " . $cliente->endereco->numero . ", Telefone(s): ";

                    foreach ($cliente->telefones as $tk => $tel) {
                        $tarefa->descricao .= $tel->numero . "; ";
                    }

                    $tarefa->titulo = "Prospeccao $cliente->razao_social";
                    $tarefa->tipo_entidade_relacionada = "CLI";
                    $tarefa->id_entidade_relacionada = $cliente->id;

                    Sistema::novaTarefaEmpresa($con, $tarefa, $virtual);
                }

                $clientes = $empresa->getClientes($con, 0, $virtual->getCountUsuarios($con, "usuario.id_cargo=" . Virtual::CF_ASSISTENTE_VIRTUAL_RECEPCAO($virtual)->id) * 50, "cliente.id NOT IN (SELECT uc.id_cliente FROM usuario_cliente uc WHERE uc.data_fim IS NULL) AND cliente.prospectar_ignorar_pular=2");

                foreach ($clientes as $key3 => $cliente) {

                    $tarefa = new Tarefa();
                    $tarefa->tipo_tarefa = Sistema::TT_RECEPCAO_CLIENTE($virtual->id);
                    $tarefa->prioridade = $tarefa->tipo_tarefa->prioridade;
                    $tarefa->descricao = "Recepcione o cliente $cliente->razao_social, codigo $cliente->codigo, verifique se ja se encontra no RTC, caso nao esteja apresente o sistema para ele";
                    $tarefa->titulo = "Recepcao de Cliente";
                    $tarefa->tipo_entidade_relacionada = "CLI";
                    $tarefa->id_entidade_relacionada = $cliente->id;

                    Sistema::novaTarefaEmpresa($con, $tarefa, $virtual);
                }
                
                $clientes = $empresa->getClientes($con, 0, $virtual->getCountUsuarios($con, "usuario.id_cargo=" . Virtual::CF_ASSISTENTE_VIRTUAL_SUPORTE($virtual)->id) * 5, "cliente.id NOT IN (SELECT uc.id_cliente FROM usuario_cliente uc WHERE uc.data_fim IS NULL) AND cliente.suporte_imediato=true");

                foreach ($clientes as $key3 => $cliente) {

                    $tarefa = new Tarefa();
                    $tarefa->tipo_tarefa = Sistema::TT_SUPORTE_CLIENTE($virtual->id);
                    $tarefa->prioridade = $tarefa->tipo_tarefa->prioridade;
                    $tarefa->descricao = "Cliente: $cliente->razao_social, Codigo: $cliente->codigo,"
                            . " Rua: " . $cliente->endereco->rua . ", Bairro: " . $cliente->endereco->bairro . ","
                            . " Estado: " . $cliente->endereco->cidade->estado->sigla . ","
                            . " Cidade: " . $cliente->endereco->cidade->nome . ","
                            . " Numero: " . $cliente->endereco->numero . ", Telefone(s): ";
                    $tarefa->titulo = "Suporte de Cliente $cliente->razao_social";
                    $tarefa->tipo_entidade_relacionada = "CLI";
                    $tarefa->id_entidade_relacionada = $cliente->id;

                    Sistema::novaTarefaEmpresa($con, $tarefa, $virtual);
                    
                    $ps = $con->getConexao()->prepare("UPDATE cliente SET suporte_imediato=false WHERE id=$cliente->id");
                    $ps->execute();
                    $ps->close();
                    
                }

                for ($i = 0; $i < self::$NUMERO_PROSPECCOES_EXTERNAS; $i++) {

                    $tarefa = new Tarefa();
                    $tarefa->tipo_tarefa = Sistema::TT_PROSPECCAO_EXTERNA_CLIENTE($virtual->id);
                    $tarefa->prioridade = $tarefa->tipo_tarefa->prioridade;
                    $tarefa->descricao = "Cadastre um cliente externo na $empresa->nome, para cumprir a atividade de prospeccao externa";
                    $tarefa->titulo = "Prosp. Externa";
                    $tarefa->tipo_entidade_relacionada = "EMP";
                    $tarefa->id_entidade_relacionada = $empresa->id;

                    Sistema::novaTarefaEmpresa($con, $tarefa, $virtual);
                }
            }
        }
    }

}
