<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Email
 *
 * @author Renan
 */
class RelacaoUsuarioCliente {

    public static $RECEPCAO = 0;
    public static $RECEPCAO_INATIVA = 1;
    public static $QUARENTENA_PASSADA = 6;
    public static $QUARENTENA = 2;
    public static $QUARENTENA_INATIVA = 3;
    public static $PROSPECCAO = 4;
    public static $PROSPECCAO_INATIVA = 5;
    public $id;
    public $cliente;
    public $data_inicio;
    public $data_fim;
    public $situacao;

    function __construct() {

        $this->id = 0;
        $this->data_inicio = round(microtime(true) * 1000);
        $this->data_fim = null;
        $this->cliente = null;
        $this->situacao = 0;
    }

    public function getContatos($con) {

        $contatos = array();
        $ps = $con->getConexao()->prepare("SELECT id,UNIX_TIMESTAMP(data)*1000,descricao FROM contato WHERE id_relacao=$this->id");
        $ps->execute();
        $ps->bind_result($id, $data, $descricao);

        while ($ps->fetch()) {

            $c = new Contato();
            $c->id = $id;
            $c->data = $data;
            $c->descricao = $descricao;
            $c->relacao = $this;

            $contatos[] = $c;
        }

        $ps->close();

        return $contatos;
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO usuario_cliente(id_cliente,data_inicio,data_fim,situacao) VALUES(" . $this->cliente->id . ",FROM_UNIXTIME($this->data_inicio/1000)," . ($this->data_fim == null ? "null" : "FROM_UNIXTIME($this->data_fim/1000)") . ",$this->situacao)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE usuario_cliente SET id_cliente=" . $this->cliente->id . ",data_inicio=FROM_UNIXTIME($this->data_inicio/1000),data_fim=" . ($this->data_fim == null ? "null" : "FROM_UNIXTIME($this->data_fim/1000)") . ",situacao=$this->situacao WHERE id=$this->id");
            $ps->execute();
            $ps->close();
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE usuario_cliente SET data_inicio=data_incio, data_fim=CURRENT_TIMESTAMP WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
