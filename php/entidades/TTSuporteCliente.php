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
class TTSuporteCliente extends TipoTarefa {

    public $id_empresa;
    
    function __construct($id_empresa) {

        parent::__construct(11, $id_empresa);

        $this->id_empresa = $id_empresa;
        
        $this->nome = "Suporte para Cliente";
        $this->tempo_medio = 0.2;
        $this->prioridade = 15;
        $this->cargos = array(
            Virtual::CF_ASSISTENTE_VIRTUAL_SUPORTE(new Empresa($id_empresa))
        );
        $this->carregarDados();
    }

    public function aoAtribuir($id_usuario, $tarefa) {

        $con = new ConnectionFactory();
        $relacionamento = new RelacaoUsuarioCliente();
        $relacionamento->situacao = RelacaoUsuarioCliente::$QUARENTENA;
        $relacionamento->cliente = new stdClass();
        $relacionamento->cliente->id = $tarefa->id_entidade_relacionada;
        $relacionamento->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE usuario_cliente SET id_usuario=$id_usuario,data_inicio=data_inicio,data_fim=data_fim WHERE id=$relacionamento->id");
        $ps->execute();
        $ps->close();
    }

    public function aoFinalizar($tarefa, $usuario) {

        $str = "";

        foreach ($tarefa->observacoes as $key => $obs) {

            $str .= $obs->observacao;
        }


        if (Utilidades::has($str, array("nao trabalha", "sem sucesso", "xingou", "desligou", "nao quer"))) {

            return;
        }

        $con = new ConnectionFactory();
        
        
        $telefones = array();
        $emails = array();
        $nome = "";
        $cnpj = "";
        
        $ps = $con->getConexao()->prepare("SELECT c.razao_social, c.cnpj, t.numero, e.endereco FROM cliente c LEFT JOIN email e ON e.id_entidade=c.id AND e.tipo_entidade='CLI' LEFT JOIN telefone t ON t.id_entidade=c.id AND t.tipo_entidade='CLI' WHERE c.id=$tarefa->id_entidade_relacionada");
     
        
        $ps->execute();
        
        $ps->bind_result($nome_cliente, $cnpj_cliente, $telefone_cliente, $email_cliente);
        while ($ps->fetch()) {
            $nome = $nome_cliente;
            $cnpj = $cnpj_cliente;
            $telefones[$telefone_cliente] = "";
            $emails[$email_cliente] = "";
        }
        $ps->close();

        $str_telefones = "";
        foreach ($telefones as $key => $value) {
            $str_telefones .= "$key<br>";
        }

        $str_emails = "";
        foreach ($emails as $key => $value) {
            $str_emails .= "$key<br>";
        }
        
        $tarefa_ = new Tarefa();
        $tarefa_->tipo_tarefa = Sistema::TT_RECEPCAO_CLIENTE_M2($this->id_empresa);
        $tarefa_->titulo = "Recepcao de Cliente para Modulo 2";
        $tarefa_->descricao = "Recepcione o cliente " . $tarefa->id_entidade_relacionada . " - $nome para o RTC no Modulo 2 CNPJ: $cnpj<hr>Telefones:<br>$str_telefones<hr>Emails:<br>$str_emails<hr>";
        $tarefa_->id_entidade_relacionada = $tarefa->id_entidade_relacionada;
        $tarefa_->tipo_entidade_relacionada = $tarefa->tipo_entidade_relacionada;
            
    }

}
