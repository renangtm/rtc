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
class RoboDetona {

    public $dia;
    public $mes;
    public $ano;
    public $hora;
    public $minuto;
    public $segundo;
    public $momento;

    public function __construct() {

        date_default_timezone_set("America/Sao_Paulo");

        $this->momento = round(microtime(true) * 1000);

        $str = explode(':', date('d:m:Y:H:i:s', $this->momento / 1000));
        $this->dia = intval($str[0]);
        $this->mes = intval($str[1]);
        $this->ano = intval($str[2]);
        $this->hora = intval($str[3]);
        $this->minuto = intval($str[4]);
        $this->segundo = intval($str[5]);
    }

    public function executar($con) {

        $empresas = Sistema::getEmpresas($con, 'empresa.rtc>=5');

        foreach ($empresas as $key => $empresa) {

            $relatorio = new stdClass();
            $relatorio->empresa = $empresa;
            $relatorio->data = round(microtime(true) * 1000);

            $produtos = array();
            $ps = $con->getConexao()->prepare("SELECT p.codigo,p.nome,UNIX_TIMESTAMP(l.validade)*1000,CASE WHEN SUM(l.quantidade_real)>p.disponivel THEN p.disponivel ELSE SUM(l.quantidade_real) END,ABS(UNIX_TIMESTAMP(l.validade)-UNIX_TIMESTAMP(CURRENT_TIMESTAMP))<60*60*24*2,IFNULL(e.nome,'$empresa->nome') FROM produto p INNER JOIN lote l ON l.id_produto=p.id LEFT JOIN empresa e ON e.id=p.id_logistica WHERE p.id_empresa=$empresa->id AND l.validade<=DATE_ADD(CURRENT_DATE,INTERVAL " . Sistema::getMesesValidadeCurta() . " MONTH) AND l.excluido=false GROUP BY p.codigo,l.validade,p.id_logistica");
            $ps->execute();
            $ps->bind_result($codigo, $nome, $validade, $quantidade, $criado, $armazem);
            while ($ps->fetch()) {

                $p = new stdClass();
                $p->codigo = $codigo;
                $p->nome = $nome . " - " . $armazem;
                $p->validade = $validade;
                $p->quantidade = $quantidade;
                $p->situacao = ($criado == 1) ? "CRIADO RECENTEMENTE" : "ATUALIZADO";

                if ($p->quantidade <= 0)
                    continue;

                $produtos[] = $p;
            }
            $ps->close();
            if (count($produtos) === 0) {
                continue;
            }
            $relatorio->produtos = $produtos;

            $html = Sistema::getHtml('relatorio_detona', $relatorio);
            //Sistema::avisoDEVS($html);
            $empresa->email->enviarEmail($empresa->email->filtro(Email::$LOGISTICA), "RELATORIO DETONA RTC $empresa->nome", $html);
        }
    }

}
