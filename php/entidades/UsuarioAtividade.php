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
class UsuarioAtividade {

    public $id;
    public $nome;
    public $id_empresa;
    public $nome_empresa;
    public $cnpj_empresa;
    public $ultima_atividade;
    public $online;
    public $gerenciador;
    public $empresa_consulta;

    public function __construct($empresa) {
        $this->empresa_consulta = $empresa;
    }

    public function getProdutos($con, $inicio = -1, $fim = -1) {

        if ($inicio < 0) {

            $inicio = $this->gerenciador->periodo_inicial;
        }

        if ($fim < 0) {

            $fim = $this->gerenciador->periodo_final;
        }

        $produtos = array();

        $ps = $con->getConexao()->prepare("SELECT produto.id,produto.nome FROM atividade_usuario a INNER JOIN produto ON a.descricao LIKE CONCAT(CONCAT('% ',produto.id),' %') OR a.descricao LIKE CONCAT(produto.id,' %') WHERE a.id_usuario=$this->id AND a.momento > FROM_UNIXTIME($inicio/1000) AND a.fim < FROM_UNIXTIME($fim/1000) a.tipo = " . Atividade::$PRODUTO . " GROUP BY produto.id");
        $ps->execute();
        $ps->bind_result($id, $nome);

        while ($ps->fetch()) {

            $produto = new ProdutoAtividade();
            $produto->id = $id;
            $produto->nome = $nome;
            $produtos[] = $produto;
        }

        $ps->close();

        return $produtos;
    }

    public function getPontos($con, $inicio = -1, $fim = -1) {

        if ($inicio < 0) {

            $inicio = $this->gerenciador->periodo_inicial;
        }

        if ($fim < 0) {

            $fim = $this->gerenciador->periodo_final;
        }

        $ps = $con->getConexao()->prepare("SELECT SUM(a.pontuacao) FROM atividade_usuario a WHERE a.id_usuario=$this->id AND momento > FROM_UNIXTIME($inicio/1000) AND momento < FROM_UNIXTIME($fim/1000)");
        $ps->execute();
        $ps->bind_result($vl);
        if ($ps->fetch()) {
            $ps->close();
            return $vl;
        }
        $ps->close();
        return 0;
    }

    public function getTelefones($con) {

        $telefones = array();

        $ps = $con->getConexao()->prepare("SELECT id, numero FROM telefone WHERE tipo_entidade='USU' AND id_entidade=$this->id");
        $ps->execute();
        $ps->bind_result($id, $numero);

        while ($ps->fetch()) {

            $t = new Telefone($numero);
            $t->id = $id;
            $telefones[] = $t;
        }
        $ps->close();

        return $telefones;
    }

    public function getEmail($con) {

        $ps = $con->getConexao()->prepare("SELECT id, endereco FROM email WHERE tipo_entidade='USU' AND id_entidade=$this->id");
        $ps->execute();
        $ps->bind_result($id, $endereco);

        if ($ps->fetch()) {
            $ps->close();

            $em = new Email($endereco);
            $em->id = $id;

            return $em;
        }
        $ps->close();

        return new Email("");
    }

    public function getValorComprado($con, $inicio = -1, $fim = -1) {

        if ($inicio < 0) {

            $inicio = $this->gerenciador->periodo_inicial;
        }

        if ($fim < 0) {

            $fim = $this->gerenciador->periodo_final;
        }

        $ps = $con->getConexao()->prepare("SELECT IFNULL(SUM((p.valor_base+p.juros+p.frete+p.icms+p.ipi)*p.quantidade),0) FROM produto_pedido_saida p INNER JOIN pedido ON p.id_pedido=pedido.id INNER JOIN cliente c ON c.id=pedido.id_cliente INNER JOIN empresa ON empresa.cnpj=c.cnpj INNER JOIN usuario u ON u.id_empresa=empresa.id WHERE u.id=$this->id AND pedido.data > FROM_UNIXTIME($inicio/1000) AND pedido.data < FROM_UNIXTIME($fim/1000)");
        $ps->execute();
        $ps->bind_result($vl);
        if ($ps->fetch()) {
            $ps->close();
            return $vl;
        }
        $ps->close();
        return 0;
    }

    public function getAtividade($con, $intervalo, $inicio = -1, $fim = -1) {

        if ($inicio < 0) {

            $inicio = $this->gerenciador->periodo_inicial;
        }

        if ($fim < 0) {

            $fim = $this->gerenciador->periodo_final;
        }

        $atividades = array();
        $hora = 1000 * 60 * 60;
        $dia = $hora * 24;
        $ps = $con->getConexao()->prepare("SELECT UNIX_TIMESTAMP(momento)*1000 FROM atividade_usuario WHERE momento>=FROM_UNIXTIME($inicio/1000) AND momento<=FROM_UNIXTIME($fim/1000) AND id_usuario=$this->id ORDER BY momento");
        $ps->execute();
        $ps->bind_result($momento);
        while ($ps->fetch()) {
            $atividades[] = fmod($momento + $hora * 21, $dia);
        }
        $ps->close();

        $percentuais = array();


        for ($i = 0; $i < $dia; $i += $intervalo) {

            $time = 0;
            $periodos = array(array($i, $i + $intervalo));

            foreach ($atividades as $key => $x1) {

                $x2 = $x1 + GerenciadorAtividade::$TIME_SINAL;

                foreach ($periodos as $key2 => $periodo) {

                    $y1 = $periodo[0];
                    $y2 = $periodo[1];

                    if ($y2 > $x2 && $y1 < $x1) {

                        $time += $x2 - $x1;

                        $periodos[$key2] = array($y1, $x1);
                        $periodos[] = array($x2, $y2);
                    } else if ($y2 < $x2 && $y1 > $x1) {

                        $time += $y2 - $y1;

                        unset($periodos[$key2]);
                        
                    } else if ($x2 < $y2 && $x2 > $y1) {

                        $time += $x2 - $y1;
                        $periodos[$key2][0] = $x2;
                        
                    } else if ($x1 > $y1 && $x1 < $y2) {

                        $time += $y2 - $x1;
                        $periodos[$key2][1] = $x1;
                    }
                }
            }

            $percentuais[] = round(($time / $intervalo) * 100, 2);
        }

        return $percentuais;
    }

    public function getLogs($con, $inicio = -1, $fim = -1) {

        if ($inicio < 0) {

            $inicio = $this->gerenciador->periodo_inicial;
        }

        if ($fim < 0) {

            $fim = $this->gerenciador->periodo_final;
        }

        $atvs = array();

        $ps = $con->getConexao()->prepare("SELECT id,descricao,tipo,pontuacao,UNIX_TIMESTAMP(momento)*1000 FROM atividade_usuario WHERE id_usuario=$this->id AND momento > FROM_UNIXTIME($inicio/1000) AND momento < FROM_UNIXTIME($fim/1000) AND tipo <> " . Atividade::$SINAL." ORDER BY momento DESC");
        $ps->execute();
        $ps->bind_result($id, $descricao, $tipo,$pontos,$momento);

        while ($ps->fetch()) {

            $atv = new Atividade();
            $atv->id = $id;
            $atv->descricao = $descricao;
            $atv->momento = $momento;
            $atv->tipo = $tipo;
            $atv->pontos = $pontos;
            $atvs[] = $atv;
        }

        $ps->close();

        return $atvs;
    }

}
