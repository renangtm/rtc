<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IATarefas
 *
 * @author T-Gamer
 */
class IATarefas {

    private static $PRIORIDADE_VS_TEMPO = 2;

    // Prioridade tem um valor X vezes maior do que o tempo pequeno sobre a formula de ordenacao
    // Ou seja, tarefas prioritaritarias, tem preferencia sob tarefas curtas, ate certo ponto obviamente
    // e este ponto e definido por essa constante

    private static function normalizarDia($ms) {

        $d = explode(':', date('H:i:s', $ms / 1000));

        $nm = $ms;

        $nm -= intval($d[0]) * 60 * 60 * 1000;
        $nm -= intval($d[1]) * 60 * 1000;
        $nm -= intval($d[2]) * 1000;

        return $nm;
    }

    public static function aplicar($expedientes, $ausencias, $tarefas) {

        date_default_timezone_set("America/Sao_Paulo");

        foreach ($tarefas as $key => $tarefa) {

            $intervalos_uteis = array();

            $tempo_real = 0;
            foreach ($tarefa->intervalos_execucao as $key2 => $intervalo) {
                $x1 = $intervalo[0];
                $x2 = $intervalo[1];
                $tempo_real += ($x2 - $x1);
                $d1 = intval(date('w', $x1 / 1000) . "");
                $dias = array();
                while ($x1 < $x2) {
                    $normal = min(self::normalizarDia($x1) + 24 * 60 * 60 * 1000, $x2);
                    $dias[] = array($x1, $normal, $d1);
                    $x1 = $normal;
                    $d1 = ($d1 + 1) % 7;
                }

                foreach ($dias as $key3 => $dia) {
                    $x1 = $dia[0];
                    $x2 = $dia[1];
                    $dia_semana = $dia[2];
                    foreach ($expedientes as $key4 => $expediente) {
                        if ($expediente->dia_semana === $dia_semana) {
                            $n = self::normalizarDia($x1);
                            $y1 = round($n + ($expediente->inicio * 60 * 60 * 1000));
                            $y2 = round($n + ($expediente->fim * 60 * 60 * 1000));
                            if ($y1 < $x2 && $y2 > $x1) {
                                $intervalos_uteis[] = array(max($x1, $y1), min($x2, $y2));
                            }
                        }
                    }
                }
            }

            $intervalos_realmente_uteis = array();
            foreach ($intervalos_uteis as $key => $intervalo) {
                $pilha = array($intervalo);
                foreach ($ausencias as $key2 => $ausencia) {
                    $x1 = $ausencia->inicio;
                    $x2 = $ausencia->fim;
                    for ($i = 0; $i < count($pilha); $i++) {
                        if ($pilha[$i] === null)
                            continue;
                        $y1 = $pilha[$i][0];
                        $y2 = $pilha[$i][1];
                        if ($x2 < $y1 || $x1 > $y2)
                            continue;
                        if ($x1 <= $y1 && $x2 >= $y2) {
                            $pilha[$i] = null;
                            continue;
                        } else if ($x1 > $y1 && $x2 < $y2) {
                            $pilha[$i] = array($y1, $x1);
                            $pilha[] = array($x2, $y2);
                        } else if ($x1 > $y1) {
                            $pilha[$i] = array($y1, $x1);
                        } else if ($x2 < $y2) {
                            $pilha[$i] = array($x2, $y2);
                        }
                    }
                }
                foreach ($pilha as $key2 => $value2) {
                    if ($value2 !== null) {
                        $intervalos_realmente_uteis[] = $value2;
                    }
                }
            }

            //------ intervalos_realmente_uteis contem os intervalos dentro do expediente e sem ausencias

            $tempo_util = 0;

            foreach ($intervalos_realmente_uteis as $key => $value) {

                $tempo_util += ($value[1] - $value[0]);
            }

            $tarefa->calculado_horas_reais_dispendidas = $tempo_real;
            $tarefa->calculado_horas_uteis_dispendidas = $tempo_util;

            if ($tempo_util > 0) {
                $tarefa->calculado_previsao_util_conclusao = $tempo_util * (100 / max($tarefa->porcentagem_conclusao, 1));
            } else {
                $tarefa->calculado_previsao_util_conclusao = $tarefa->tipo_tarefa->tempo_medio * 60 * 60 * 1000;
            }

            $tarefa->calculado_tempo_util_faltante = $tarefa->calculado_previsao_util_conclusao - $tarefa->calculado_horas_uteis_dispendidas;

            $tarefa->ordem = round((($tarefa->prioridade * self::$PRIORIDADE_VS_TEMPO) / ($tarefa->calculado_tempo_util_faltante / 10000)), 11);
            $tarefa->ordem_teste = $tarefa->ordem;
        }

        //ordenando tarefas;

        $tarefas_ativas_passivas = array(array(), array());

        foreach ($tarefas as $key => $tarefa) {
            $vetor = 0;
            if ($tarefa->inicio_minimo > round(microtime(true) * 1000)) {
                $vetor = 1;
            }

            $tarefas_ativas_passivas[$vetor][] = $tarefa;
            $i = count($tarefas_ativas_passivas[$vetor]) - 1;
            while ($i > 0) {
                if ($tarefas_ativas_passivas[$vetor][$i]->ordem > $tarefas_ativas_passivas[$vetor][$i - 1]->ordem) {
                    $k = $tarefas_ativas_passivas[$vetor][$i];
                    $tarefas_ativas_passivas[$vetor][$i] = $tarefas_ativas_passivas[$vetor][$i - 1];
                    $tarefas_ativas_passivas[$vetor][$i - 1] = $k;
                    $i--;
                } else {
                    break;
                }
            }
        }

        $tarefas_ativas = $tarefas_ativas_passivas[0];
        $tarefas_passivas = $tarefas_ativas_passivas[1];

        foreach ($tarefas_passivas as $key => $value) {
            $agora = round(microtime(true) * 1000);
            $i = count($tarefas_ativas);
            foreach ($tarefas_ativas as $key2 => $tarefa) {
                if ($value->inicio_minimo < $tarefa->inicio_minimo) {
                    $i = $key2;
                    break;
                }
                if ($agora >= $value->inicio_minimo) {
                    if ($tarefa->ordem < $value->ordem) {
                        $i = $key2;
                        break;
                    }
                }
                $agora += $tarefa->calculado_tempo_util_faltante * ($tempo_real / $tempo_util);
            }

            for ($j = count($tarefas_ativas); $j > $i; $j--) {
                $tarefas_ativas[$j] = $tarefas_ativas[$j - 1];
            }
            $tarefas_ativas[$i] = $value;
            
        }
        
        

        $x1 = round(microtime(true) * 1000);
        foreach ($tarefas_ativas as $key => $value) {

            $value->ordem = count($tarefas_ativas) - $key;


            $ajuste = $value->calculado_tempo_util_faltante;

            $x2 = max($x1, $value->inicio_minimo);

            while ($ajuste > 0 && count($expedientes)>0) {

                $normalizado = self::normalizarDia($x2);

                $dia_semana = intval(date('w', $x2 / 1000) . "");

                $itv_dia = array();

                foreach ($expedientes as $key2 => $value2) {
                    if ($value2->dia_semana === $dia_semana) {
                        $itv_dia[] = array(max($normalizado + (60 * 60 * 1000 * $value2->inicio), $x2), max($normalizado + (60 * 60 * 1000 * $value2->fim), $x2));
                    }
                }

                //-----
                $itv_dia_uteis = array();
                foreach ($itv_dia as $key => $intervalo) {
                    $pilha = array($intervalo);
                    foreach ($ausencias as $key2 => $ausencia) {
                        $xx1 = $ausencia->inicio;
                        $xx2 = $ausencia->fim;
                        for ($i = 0; $i < count($pilha); $i++) {
                            if ($pilha[$i] === null)
                                continue;
                            $y1 = $pilha[$i][0];
                            $y2 = $pilha[$i][1];
                            if ($xx2 < $y1 || $xx1 > $y2)
                                continue;
                            if ($xx1 <= $y1 && $xx2 >= $y2) {
                                $pilha[$i] = null;
                                continue;
                            } else if ($xx1 > $y1 && $xx2 < $y2) {
                                $pilha[$i] = array($y1, $xx1);
                                $pilha[] = array($xx2, $y2);
                            } else if ($xx1 > $y1) {
                                $pilha[$i] = array($y1, $xx1);
                            } else if ($xx2 < $y2) {
                                $pilha[$i] = array($xx2, $y2);
                            }
                        }
                    }
                    foreach ($pilha as $key2 => $value2) {
                        if ($value2 !== null) {
                            $itv_dia_uteis[] = $value2;
                        }
                    }
                }
                //-----

                foreach ($itv_dia_uteis as $key => $value2) {

                    if ($value->calculado_previsao_inicio === 0) {

                        $value->calculado_previsao_inicio = $value2[0];
                    }

                    $d = min($value2[1] - $value2[0], $ajuste);
                    $ajuste -= $d;
                    $x2 = $value2[0] + $d;
                    if ($ajuste <= 0) {
                        break 2;
                    }
                }

                $x2 = $normalizado + 24 * 60 * 60 * 1000;
            }

            $value->calculado_momento_conclusao = $x2;

            $x1 = $x2;
        }
        
        return $tarefas_ativas;
        
    }

}
