<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Atividade
 *
 * @author Renan
 */
class Atividade {

    public static $SINAL = 0;
    public static $ADCIONAR_CARRINHO = 1;
    public static $PESQUISAR = 2;
    public static $ITEM_MENU = 3;
    public static $PRODUTO = 4;
    public static $PEDIDO = 5;
    
    public $id;
    public $usuario;
    public $momento;
    public $tipo;
    public $descricao;
    public $pontos;

    public function __construct($usuario = null, $tipo = -1) {

        if ($usuario === null) {

            return;
        }

        if ($tipo === -1) {

            $tipo = Atividade::$SINAL;
        }

        $this->id = 0;
        $this->usuario = $usuario;
        $this->momento = round(microtime(true) * 1000);
        $this->tipo = $tipo;
        $this->descricao = "";
        $this->pontos = 0;
        
    }

    public function merge($con) {

        if ($this->id === 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO atividade_usuario(id_usuario,tipo,momento,descricao,pontuacao) VALUES(" . $this->usuario->id . ",$this->tipo,FROM_UNIXTIME(" . $this->momento . "/1000),'".addslashes($this->descricao)."',$this->pontos)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE atividade_usuario SET id_usuario=" . $this->usuario->id . ", tipo=$this->tipo, momento=FROM_UNIXTIME(" . $this->momento . "/1000), descricao='".addslashes($this->descricao)."', pontuacao=$this->pontos WHERE id=$this->id");
            $ps->execute();
            $ps->close();
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("DELETE FROM atividade_usuario WHERE id=$this->id");
        $ps->execute();
        $ps->close();
    }

}
