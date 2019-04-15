<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Grade
 *
 * @author Renan
 */
class Grade {

    public $gr;
    public $str;

    function __construct($str = "1") {

        $this->str = $str;
        $this->gr = array();

        $ex = explode(',', $str);

        foreach ($ex as $key => $value) {

            $ex = intval($value);

            if ($ex < 1)
                break;

            $this->gr[] = $ex;
        }
    }

    public function fractalizar($quantidade, $retiradas) {

        return $this->gerar($quantidade, $retiradas, null, array(0));
    }

    private function gerar($quantidade, $retiradas, $pai, $k) {

        foreach ($retiradas as $key => $value) {

            if (count($value) == count($k)) {

                for ($i = 0; $i < count($value); $i++) {

                    if ($k[$i] != $value[$i])
                        continue 2;
                }

                return null;
            }
        }

        $clone_k = array();

        foreach ($k as $key => $value) {
            $clone_k[] = $value;
        }

        if ((count($k) - 1) == count($this->gr)) {

            $it = new Item();
            $it->quantidade = $quantidade;
            $it->quantidade_filhos = 0;
            $it->removivel = false;
            /*
             * O Algorítmo de separação utilizado anteriormente, tinha este parametro como 'true',
             * no entando ao efetuar analise mais profunda, identificou-se varios problemas
             * nessa abordagem, dificultando muito a integridade dos dados do processo de
             * separação, quando colocado no contexto pratico de cancelamentos e alterações 
             * com essa analise também descobri que tendo o parametro como 'false', é possível
             * manter a integridade de forma muito mais simplificada, e facilitar diversos 
             * processos computacionais, portanto ao invés de trabalhar na complexidade maior da primeira
             * opção que tem seus beneficios, julguei como sendo melhor trabalhar com uma opção que me
             * reduza a complexidade e garanta integridade, tendo em vista o prazo de desenvolvimento,
             * posteriormente seria interessante pegar um tempo para estudar melhor a primeira, que
             * na pratica pode oferecer benefícios bastante interessantes também, mas no momento
             * fica inviável pelo prazo.
             */
            $it->pai = $pai;
            $it->numero = $clone_k;

            return $it;
        }

        $it = new Item();
        $it->quantidade = 0;
        $it->pai = $pai;
        $it->numero = $clone_k;

        $q = $this->gr[count($k) - 1];

        $z = count($k);

        $y = 0;
        $i = 0;
        while ($quantidade > 0) {

            $quantidade -= $q;

            if ($quantidade < 0) {

                $q += $quantidade;
            }

            $k[$z] = $i;

            $f = $this->gerar($q, $retiradas, $it, $k);

            unset($k[$z]);

            $it->filhos[] = $f;

            if ($f != null) {

                $it->quantidade += $f->quantidade;
                $y++;
            }

            $i++;
        }

        $it->quantidade_filhos = $y;

        if ($y == 1) {

            foreach ($it->filhos as $key => $value) {

                if ($value != null) {

                    if ($value->removivel) {

                        $it->removivel = true;

                        $it->quantidade_filhos = 0;

                        $it->filhos = array();
                    }

                    break;
                }
            }
        }

        if ($it->quantidade === 0) {

            return null;
        }


        return $it;
    }

}
