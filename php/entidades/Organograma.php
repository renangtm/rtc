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
class Organograma {

    public $empresa;

    public function __construct($empresa) {

        $this->empresa = $empresa;
    }

    public function getNodo($con, $usuario) {
        $pilha = array($this->getRaiz($con));
        for ($i = 0; $i < count($pilha); $i++) {
            $n = $pilha[$i];
            if ($n->id_usuario === $usuario->id) {
                return $n;
            }
            $filhos = $n->filhos;
            foreach ($filhos as $key => $value) {
                $pilha[] = $value;
            }
        }
        return null;
    }

    public function getSuperiores($con, $usuario) {

        $superiores = array();

        $nodo = $this->getNodo($con, $usuario);
        
        if($nodo === null){
            return null;
        }
        
        $aux = $nodo->pai;
        
        while ($nodo != null) {
            $superiores[] = $nodo;
            $nodo = $nodo->pai;
        }

        return $superiores;
    
    }

    public function getInferiores($con, $usuario) {
        $pilha = array(array($this->getRaiz($con), false));
        $inferiores = array();
        for ($i = 0; $i < count($pilha); $i++) {
            $n = $pilha[$i];
            if ($n[1]) {
                $inferiores[] = $n[0];
            }
            $filhos = $n[0]->filhos;

            foreach ($filhos as $key => $value) {
                $pilha[] = array($value, ($n[1] || $n[0]->id_usuario === $usuario->id));
            }
        }
        return $inferiores;
    }

    public function getRaiz($con) {

        $arvore = array();

        $ps = $con->getConexao()->prepare("SELECT "
                . "o.id,"
                . "o.id_usuario1,"
                . "o.id_usuario2,"
                . "u1.nome,"
                . "u2.nome "
                . "FROM organograma o "
                . "INNER JOIN usuario u1 ON o.id_usuario1=u1.id "
                . "INNER JOIN usuario u2 ON o.id_usuario2=u2.id "
                . "WHERE u1.id_empresa=" . $this->empresa->id . " AND u2.id_empresa=" . $this->empresa->id);

        $ps->execute();
        $ps->bind_result($id, $id_usuario1, $id_usuario2, $nome_usuario1, $nome_usuario2);
        while ($ps->fetch()) {
            $n = new NodoOrganograma();
            $n->id_usuario = $id_usuario1;
            $n->nome_usuario = $nome_usuario1;
            $n2 = new NodoOrganograma();
            $n2->id = $id;
            $n2->id_usuario = $id_usuario2;
            $n2->nome_usuario = $nome_usuario2;
            if (!isset($arvore[$id_usuario1])) {
                $arvore[$id_usuario1] = $n;
            }
            if (!isset($arvore[$id_usuario2])) {
                $arvore[$id_usuario2] = $n2;
            } else {
                if ($arvore[$id_usuario2]->id === 0) {
                    $arvore[$id_usuario2]->id = $n2->id;
                }
            }
            $arvore[$id_usuario2]->pai = $arvore[$id_usuario1];
            $arvore[$id_usuario1]->filhos[] = $arvore[$id_usuario2];
        }
        $ps->close();

        foreach ($arvore as $key => $value) {
            if ($value->id === 0) {
                return $value;
            }
        }

        $usuario_main = $this->empresa->getUsuarios($con, 0, 1, '', 'usuario.id ASC');

        if (count($usuario_main) > 0) {

            $usuario_main = $usuario_main[0];

            $n = new NodoOrganograma();
            $n->id = 0;
            $n->id_usuario = $usuario_main->id;
            $n->nome_usuario = $usuario_main->nome;

            return $n;
        }

        return null;
    }

    public function alterar($con, $raiz) {

        $in = "(-1";

        foreach ($raiz->filhos as $key => $value) {

            $in .= ",$value->id";
        }

        $in .= ")";

        $ps = $con->getConexao()->prepare("DELETE FROM organograma WHERE id_usuario1=$raiz->id_usuario AND id NOT IN $in");
        $ps->execute();
        $ps->close();

        foreach ($raiz->filhos as $key => $value) {
            if ($value->id === 0) {
                $ps = $con->getConexao()->prepare("INSERT INTO organograma(id_usuario1,id_usuario2) VALUES($raiz->id_usuario,$value->id_usuario)");
                $ps->execute();
                $value->id = $ps->insert_id;
                $ps->close();
            } else {
                $ps = $con->getConexao()->prepare("UPDATE organograma SET id_usuario1=$raiz->id_usuario,id_usuario2=$value->id_usuario WHERE id=$value->id");
                $ps->execute();
                $ps->close();
            }
            $this->alterar($con, $value);
        }
    }

}
