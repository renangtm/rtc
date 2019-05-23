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
class IAChat {

    public $empresa;

    public function __construct($empresa) {

        $this->empresa = $empresa;
    }

    public function getRaiz($con) {

        $arvore = array();
        $conexoes = array();

        $ps = $con->getConexao()->prepare("SELECT id,tipo_expressao,valor_expressao,conexoes FROM ia_chat WHERE id_empresa=" . $this->empresa->id);
        $ps->execute();
        $ps->bind_result($id, $tipo_expressao, $valor_expressao, $conex);

        while ($ps->fetch()) {

            $nodo = new NodoChat();
            $nodo->id = $id;
            $nodo->tipo = $tipo_expressao;
            $nodo->expressao = $valor_expressao;

            $arvore[$id] = $nodo;
            if($conex !== ""){
                $conexoes[$id] = explode(',', $conex);

                foreach ($conexoes[$id] as $key => $value) {
                    $conexoes[$id][$key] = intval($conexoes[$id][$key]);
                }
            }else{
                $conexoes[$id] = array();
            }
        }
        $ps->close();

        foreach ($arvore as $key => $value) {
            foreach ($conexoes[$key] as $key2 => $value2) {
                $arvore[$value2]->pai = $value;
                $value->filhos[] = $arvore[$value2];
            }
        }

        foreach ($arvore as $key => $value) {

            if ($value->pai === null) {

                return $value;
            }
        }
        
        $nodo = new NodoChat();
        $nodo->expressao = "";
        $nodo->id_empresa = $this->empresa->id;
        $nodo->pai = null;
        
        return $nodo;
        
    }

    public function alterar($con, $raiz,$n=0) {

        $ids = array();
        
        $conexoes = "";
        foreach($raiz->filhos as $key=>$value){
            
            $ids_otr = $this->alterar($con, $value,$n+1);
            $conexoes .= ",$value->id";
            
            foreach($ids_otr as $key2=>$value2){
                $ids[]=$value2;
            }
            
        }
        
        $conexoes = substr($conexoes, 1);
        
        if($raiz->id === 0){
            
            $ps = $con->getConexao()->prepare("INSERT INTO ia_chat(tipo_expressao,valor_expressao,conexoes,id_empresa) VALUES($raiz->tipo,'$raiz->expressao','$conexoes',".$this->empresa->id.")");
            $ps->execute();
            $raiz->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE ia_chat SET tipo_expressao=$raiz->tipo,valor_expressao='$raiz->expressao',conexoes='$conexoes',id_empresa=".$this->empresa->id." WHERE id=$raiz->id");
            $ps->execute();
            $ps->close();
            
        }
        
        $ids[] = $raiz->id;
        
        if($n===0){
            
            $part = "";
            
            foreach($ids as $key=>$value){
                $part .= ",$value";
            }
            
            $part = substr($part,1);
            Sistema::avisoDEVS("DELETE FROM ia_chat WHERE id NOT IN ($part) AND id_empresa=".$this->empresa->id);
            $ps = $con->getConexao()->prepare("DELETE FROM ia_chat WHERE id NOT IN ($part) AND id_empresa=".$this->empresa->id);
            $ps->execute();
            $ps->close();
            
        }
        
        return $ids;
        
    }

}
