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
class Chat {

    public $nodo_id;
    public $arvore;
    public $nodo_atual;
    public $variaveis;

    private function desmembrar($n) {

        $this->nodo_id[$n->id] = $n;

        foreach ($n->filhos as $key => $value) {

            $this->desmembrar($value);
        }
    }

    public function __construct($arvore) {

        $this->arvore = $arvore;
        $this->nodo_atual = $this->arvore;
        $this->variaveis = array();

        $this->nodo_id = array();
        $this->desmembrar($this->arvore);
    }

    private function interpretarFala($fala) {
        
        return $fala->expressao;
        
    }

    public function getFala() {

        $falas = array();

        foreach ($this->nodo_atual->filhos as $key => $value) {

            $nr = $value;

            if ($nr->tipo > 2) {

                $nr = $this->nodo_id[$nr->tipo - 2];
            }

            if ($nr->tipo === NodoChat::$FALA_CHAT) {

                $falas[] = $nr;
            }
        }

        $fala = $falas[rand(0, count($falas) - 1)];
        
        $this->nodo_atual = $fala;
        
        return $this->interpretarFala($fala);
        
    }
    
    public function analisar($string){
        
        $respostas = array();

        foreach ($this->nodo_atual->filhos as $key => $value) {
            $nr = $value;

            if ($nr->tipo > 2) {

                $nr = $this->nodo_id[$nr->tipo - 2];
            }

            if ($nr->tipo === NodoChat::$CAPTURA_USUARIO) {

                $respostas[] = $nr;
            }
        }
     
        $resultados = array();
        
        
        
        
    }

}
