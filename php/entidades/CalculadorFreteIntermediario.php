<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Logistica
 *
 * @author Renan
 */
class CalculadorFreteIntermediario {

    public $empresa;
    public $filiais_logisticas;
    public $grafo;
    public $conexoes;
    public $peso;
    public $valor;
    public $con;

    public function __construct($con, $empresa, $peso, $valor) {

        $this->con = $con;
        $this->peso = $peso;
        $this->valor = $valor;

        $this->empresa = $empresa;
        $filiais = $empresa->getFiliais($con);
        $this->filiais_logisticas = array();
        foreach ($filiais as $key => $value) {
            if (get_class($value) === "Logistica" && $value->id !== $empresa->id) {
                $this->filiais_logisticas[] = $value;
            }
        }

        $this->conexoes = array();
        $this->grafo = array($this->empresa);
        foreach ($this->filiais_logisticas as $key => $value) {
            $this->grafo[] = $value;
        }

        foreach ($this->grafo as $key => $value) {
            $this->conexoes[$key] = array();
            $transportadoras = $value->getTransportadoras($con, 0, 100000, "tabela.id IS NOT NULL AND transportadora.habilitada");
            foreach ($this->grafo as $key2 => $value2) {
                if ($key2 === $key)
                    continue;
                if (!isset($this->conexoes[$key][$key2])) {
                    $this->conexoes[$key][$key2] = array();
                }
                foreach ($transportadoras as $kt => $transp) {
                    $t = $transp->tabela;
                    if ($t === null)
                        continue;
                    if ($t->atende($value2->endereco->cidade, $peso, $valor)) {
                        $s = new stdClass();
                        $s->transportadora = $transp;
                        $s->valor = $t->valor($value2->endereco->cidade, $peso, $valor);
                        if ((count($this->conexoes[$key][$key2]) === 1 && $this->conexoes[$key][$key2][0]->valor > $s->valor) || (count($this->conexoes[$key][$key2]) === 0)) {
                            $this->conexoes[$key][$key2][0] = $s;
                        }
                    }
                }
            }
        }
    }

    public function getPossibilidadesFrete($entidade, $maximo = 3) {

        $marcas = array();

        $m = new stdClass();
        $m->valor = 0;
        $m->transportadora = null;
        $m->pai = -1;
        $m->local = $this->empresa;

        $marcas[0] = $m;

        $pilha = array(0);

        for ($i = 0; $i < count($pilha); $i++) {
            $marca = $marcas[$pilha[$i]];
            $c = $this->conexoes[$pilha[$i]];
            foreach ($c as $key => $value) {
                $m = new stdClass();
                $m->valor = $marca->valor + $value[0]->valor;
                $m->transportadora = $value[0]->transportadora;
                $m->pai = $pilha[$i];
                $m->local = $this->grafo[$key];
                $t = false;
                if (!isset($marcas[$key])) {
                    $t = true;
                } else {
                    if ($marcas[$key]->valor > $m->valor) {
                        $t = true;
                    }
                }
                if ($t) {
                    $marcas[$key] = $m;
                    $pilha[] = $key;
                }
            }
        }

        $possibilidades = array();

        foreach ($marcas as $key => $value) {

            if ($value->transportadora !== null) {
                $value->transportadora = $value->transportadora->getReduzida();
            }

            $base = array($value);

            for ($i = 0; $i < count($base); $i++) {
                if (isset($marcas[$base[$i]->pai])) {
                    $base[] = $marcas[$base[$i]->pai];
                }
            }

            $transportadoras = $value->local->getTransportadoras($this->con, 0, 10000, "tabela.id IS NOT NULL AND transportadora.habilitada");

            foreach ($transportadoras as $key2 => $value2) {

                $t = $value2->tabela;
                if ($t === null)
                    continue;

                if ($t->atende($entidade->endereco->cidade, $this->peso, $this->valor)) {

                    $m = new stdClass();
                    $m->valor = $base[0]->valor + $t->valor($entidade->endereco->cidade, $this->peso, $this->valor);
                    $m->transportadora = $value2->getReduzida();
                    $m->local = $entidade;

                    $possibilidade = array($m);

                    foreach ($base as $key3 => $value3) {
                        $possibilidade[] = $value3;
                    }

                    $possibilidades[] = $possibilidade;
                }
            }
        }

        foreach ($possibilidades as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $value2->partida = false;
                $value2->chegada = false;
                if (isset($value[$key2 + 1])) {
                    $value2->valor -= $value[$key2 + 1]->valor;
                }
            }
            $value[0]->chegada = true;
            $value[count($value) - 1]->partida = true;
        }


        for ($i = 1; $i < count($possibilidades); $i++) {
            for ($j = $i; $j > 0 && $possibilidades[$j][0]->valor < $possibilidades[$j - 1][0]->valor; $j--) {
                $k = $possibilidades[$j];
                $possibilidades[$j] = $possibilidades[$j - 1];
                $possibilidades[$j - 1] = $k;
            }
        }

        $retorno = array();

        for ($i = 0; $i < min($maximo, count($possibilidades)); $i++) {
            $retorno[] = $possibilidades[$i];
        }

        return $retorno;
    }

}
