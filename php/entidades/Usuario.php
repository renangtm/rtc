<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Fornecedor
 *
 * @author Renan
 */
class Usuario {

    public $id;
    public $nome;
    public $email;
    public $telefones;
    public $endereco;
    public $cpf;
    public $excluido;
    public $empresa;
    public $login;
    public $senha;
    public $rg;
    public $permissoes;
    public $cargo;

    function __construct() {

        $this->id = 0;
        $this->email = null;
        $this->telefones = array();
        $this->endereco = new Endereco();
        $this->excluido = false;
        $this->cpf = new CPF("");
        $this->rg = new RG("");
        $this->email = new Email("");
        $this->empresa = null;
        $this->permissoes = array();
        $this->cargo = null;
    }

    public function getTarefas($con,$filtro = "", $ordem = "") {

        $tipos_tarefa = $this->empresa->getTiposTarefa($con);

        $sql = "SELECT "
                . "tarefa.id,"
                . "UNIX_TIMESTAMP(tarefa.inicio_minimo)*1000,"
                . "tarefa.ordem,"
                . "tarefa.porcentagem_conclusao,"
                . "tarefa.tipo_entidade_relacionada,"
                . "tarefa.id_entidade_relacionada,"
                . "tarefa.titulo,"
                . "tarefa.descricao,"
                . "tarefa.intervalos_execucao,"
                . "tarefa.realocavel,"
                . "tarefa.id_tipo_tarefa,"
                . "tarefa.prioridade,"
                . "observacao.id,"
                . "observacao.porcentagem,"
                . "UNIX_TIMESTAMP(observacao.momento), "
                . "observacao.observacao "
                . "FROM tarefa LEFT JOIN (SELECT * FROM observacao WHERE observacao.excluida = false) observacao ON tarefa.id=observacao.id_tarefa "
                . "WHERE tarefa.excluida=false AND tarefa.id_usuario=$this->id";

        if ($filtro !== "") {

            $sql .= " AND $filtro";
        }

        if ($ordem !== "") {

            $sql .= " ORDER BY $ordem";
        }

        $tarefas = array();
        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id, $inicio_minimo, $ordem, $porcentagem_conclusao, $tipo_entidade_relacionada, $id_entidade_relacionada, $titulo, $descricao, $intervalos_execucao, $realocavel, $id_tipo_tarefa, $prioridade, $id_observacao, $porcentagem_observacao, $momento_observacao, $observacao);
        while ($ps->fetch()) {

            if (!isset($tarefas[$id])) {

                $t = new Tarefa();
                $t->id = $id;
                $t->inicio_minimo = $inicio_minimo;
                $t->ordem = $ordem;
                $t->porcentagem_conclusao = $porcentagem_conclusao;
                $t->tipo_entidade_relacionada = $tipo_entidade_relacionada;
                $t->id_entidade_relacionada = $id_entidade_relacionada;
                $t->titulo = $titulo;
                $t->descricao = $descricao;
                $t->intervalos_execucao = $intervalos_execucao;
                $t->realocavel = $realocavel == 1;

                foreach ($tipos_tarefa as $key => $tipo) {
                    if ($tipo->id === $id_tipo_tarefa) {
                        $t->tipo_tarefa = $tipo;
                        break;
                    }
                }

                $t->prioridade = $prioridade;

                $t->intervalos_execucao = explode(";",$t->intervalos_execucao);
                $intervalos = array();
                foreach ($t->intervalos_execucao as $key => $intervalo) {
                    if ($intervalo === "")
                        continue;
                    $k = explode('@', $intervalo);
                    $intervalos[] = array($k[0]+0, $k[1]+0);
                }
                $t->intervalos_execucao = $intervalos;

                $tarefas[$id] = $t;
            }

            $t = $tarefas[$id];

            if ($id_observacao !== null) {

                $obs = new ObservacaoTarefa();
                $obs->id = $id_observacao;
                $obs->momento = $momento_observacao;
                $obs->porcentagem = $porcentagem_observacao;
                $obs->observacao = $observacao;

                $t->observacoes[] = $obs;
            }
        }

        $retorno = array();

        foreach ($tarefas as $key => $value) {

            $retorno[] = $value;
        }

        return $retorno;
    }

    public function addTarefa($con, $tarefa) {

        $tarefa->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE tarefa SET id_usuario = $this->id,inicio_minimo=inicio_minimo WHERE id=$tarefa->id");
        $ps->execute();
        $ps->close();
    }

    public function getAusencias($con,$filtro = "") {

        $sql = "SELECT id,UNIX_TIMESTAMP(inicio)*1000,UNIX_TIMESTAMP(fim)*1000 FROM ausencia WHERE id_usuario=$this->id";
        
        if($filtro !== ""){
            
            $sql .= " AND $filtro";
            
        }
        
        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id, $inicio, $fim);
        $ausencias = array();
        while ($ps->fetch()) {

            $a = new Ausencia();
            $a->id = $id;
            $a->inicio = $inicio;
            $a->fim = $fim;
            $ausencias[] = $a;
        }
        $ps->close();

        return $ausencias;
    }

    public function getExpedientes($con) {

        $ps = $con->getConexao()->prepare("SELECT id,inicio,fim,dia_semana FROM expediente WHERE id_usuario=$this->id");
        $ps->execute();
        $ps->bind_result($id, $inicio, $fim, $dia_semana);
        $expedientes = array();
        while ($ps->fetch()) {

            $e = new Expediente();
            $e->id = $id;
            $e->inicio = $inicio;
            $e->fim = $fim;
            $e->dia_semana = $dia_semana;
            $expedientes[] = $e;
        }
        $ps->close();

        return $expedientes;
    }

    public function setExpedientes($con, $expedientes) {

        $in = "(-1";

        foreach ($expedientes as $key => $value) {

            $in .= ",$value->id";
        }

        $in .= ")";

        $ps = $con->getConexao()->prepare("DELETE FROM expediente WHERE id_usuario=$this->id AND id NOT IN $in");
        $ps->execute();
        $ps->close();

        foreach ($expedientes as $key => $value) {

            $value->merge($con);

            $ps = $con->getConexao()->prepare("UPDATE expediente SET id_usuario=$this->id WHERE id=$value->id");
            $ps->execute();
            $ps->close();
        }
    }

    public function setAusencias($con, $ausencias) {

        $in = "(-1";

        foreach ($ausencias as $key => $value) {

            $in .= ",$value->id";
        }

        $in .= ")";

        $ps = $con->getConexao()->prepare("DELETE FROM ausencia WHERE id_usuario=$this->id AND id NOT IN $in");
        $ps->execute();
        $ps->close();

        foreach ($ausencias as $key => $value) {

            $value->merge($con);

            $ps = $con->getConexao()->prepare("UPDATE ausencia SET id_usuario=$this->id WHERE id=$value->id");
            $ps->execute();
            $ps->close();
        }
    }

    public function merge($con) {


        $ps = $con->getConexao()->prepare("SELECT id FROM usuario WHERE (cpf='" . $this->cpf->valor . "' OR login='$this->login') AND id <> $this->id AND id_empresa=" . $this->empresa->id);
        $ps->execute();
        $ps->bind_result($id);
        if ($ps->fetch()) {
            $ps->close();
            throw new Exception("Ja existe um usuario com os mesmos dados $id");
        }
        $ps->close();

        if ($this->id == 0) {
            $ps = $con->getConexao()->prepare("INSERT INTO usuario(login,senha,nome,cpf,excluido,id_empresa,rg,id_cargo) VALUES('" . addslashes($this->login) . "','" . addslashes($this->senha) . "','" . addslashes($this->nome) . "','" . $this->cpf->valor . "',false," . $this->empresa->id . ",'" . addslashes($this->rg->valor) . "')");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {
            $ps = $con->getConexao()->prepare("UPDATE usuario SET login='" . addslashes($this->login) . "',senha='" . addslashes($this->senha) . "', nome = '" . addslashes($this->nome) . "', cpf='" . $this->cpf->valor . "',excluido=false, id_empresa=" . $this->empresa->id . ",rg='" . addslashes($this->rg->valor) . "' WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();
        }

        if ($this->cargo !== null) {

            $ps = $con->getConexao()->prepare("UPDATE usuario SET id_cargo=" . $this->cargo->id . " WHERE id=" . $this->id);
            $ps->execute();
            $ps->close();
        }

        $this->email->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE email SET id_entidade=" . $this->id . ", tipo_entidade='USU' WHERE id = " . $this->email->id);
        $ps->execute();
        $ps->close();

        $this->endereco->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE endereco SET id_entidade=" . $this->id . ", tipo_entidade='USU' WHERE id = " . $this->endereco->id);
        $ps->execute();
        $ps->close();

        $ps = $con->getConexao()->prepare("DELETE FROM usuario_permissao WHERE id_usuario=$this->id");
        $ps->execute();
        $ps->close();

        foreach ($this->permissoes as $key => $value) {

            $in = ($value->in ? "true" : "false");
            $del = ($value->del ? "true" : "false");
            $alt = ($value->alt ? "true" : "false");
            $cons = ($value->cons ? "true" : "false");

            $ps = $con->getConexao()->prepare("INSERT INTO usuario_permissao(id_usuario,id_permissao,incluir,deletar,alterar,consultar) VALUES($this->id,$value->id,$in,$del,$alt,$cons)");
            $ps->execute();
            $ps->close();
        }

        $ps = $con->getConexao()->prepare("DELETE FROM usuario_permissao WHERE id_usuario=$this->id AND incluir=false AND deletar=false AND alterar=false AND consultar=false");
        $ps->execute();
        $ps->close();

        $tels = array();
        $ps = $con->getConexao()->prepare("SELECT id,numero FROM telefone WHERE tipo_entidade='USU' AND id_entidade=$this->id AND excluido=false");
        $ps->execute();
        $ps->bind_result($idt, $numerot);
        while ($ps->fetch()) {
            $t = new Telefone($numerot);
            $t->id = $idt;
            $tels[] = $t;
        }

        foreach ($tels as $key => $value) {

            foreach ($this->telefones as $key2 => $value2) {

                if ($value->id == $value2->id) {

                    continue 2;
                }
            }

            $value->delete($con);
        }

        foreach ($this->telefones as $key => $value) {

            $value->merge($con);

            $ps = $con->getConexao()->prepare("UPDATE telefone SET tipo_entidade='USU', id_entidade=$this->id WHERE id=" . $value->id);
            $ps->execute();
            $ps->close();
        }
    }

    public function temPermissao($p) {

        foreach ($this->permissoes as $key => $value) {

            if ($value->nome == $p->nome) {

                if ($p->in && !$value->in) {
                    return false;
                } else if ($p->del && !$value->del) {
                    return false;
                } else if ($p->alt && !$value->alt) {
                    return false;
                } else if ($p->cons && !$value->cons) {
                    return false;
                } else {

                    foreach ($this->empresa->rtc->permissoes as $key2 => $value2) {
                        if ($value2->id === $value->id) {
                            return true;
                        }
                    }

                    foreach ($this->empresa->permissoes_especiais as $key3 => $value3) {
                        if ($key3 >= $this->empresa->rtc->numero) {
                            continue;
                        }
                        foreach ($value3 as $key2 => $value2) {
                            if ($value2->id === $value->id) {
                                return true;
                            }
                        }
                    }

                    return false;
                }
            }
        }

        return false;
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE usuario SET excluido = true WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
