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
class CriadorCotacaoGrupalComBaseEncomenda {

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

        $empresas = array();
        $ps = $con->getConexao()->prepare("SELECT id FROM empresa WHERE id=1734");
        $ps->execute();
        $ps->bind_result($id);
        while ($ps->fetch()) {
            $empresas[] = $id;
        }
        $ps->close();

        foreach ($empresas as $key => $value) {
            $empresas[$key] = new Empresa($value, $con);
        }

        foreach ($empresas as $key => $empresa) {

            $fornecedor_produto = array();

            $grupo_empresarial = "($empresa->id";
            $filiais = $empresa->getFiliais($con);
            foreach ($filiais as $k => $v) {
                $grupo_empresarial .= ",$v->id";
            }
            $grupo_empresarial .= ")";

            $fornecedor_produto = array();

            $ps = $con->getConexao()->prepare("SELECT f.id,f.nome,p.codigo FROM cotacao_entrada c INNER JOIN fornecedor f ON c.id_fornecedor=f.id INNER JOIN produto_cotacao_entrada pc ON pc.id_cotacao=c.id INNER JOIN produto p ON pc.id_produto=p.id WHERE pc.quantidade>0 AND f.habilitado AND c.id_empresa IN $grupo_empresarial");
            $ps->execute();
            $ps->bind_result($id, $nome, $codigo);
            while ($ps->fetch()) {
                $hash = $id . "_" . $nome;
                if (!isset($fornecedor_produto[$hash])) {
                    $fornecedor_produto[$hash] = array();
                }
                $fornecedor_produto[$hash][] = $codigo;
            }
            $ps->close();

            $ps = $con->getConexao()->prepare("SELECT f.id,f.nome,c.codigo_produto FROM cnpj_produto c INNER JOIN fornecedor f ON f.cnpj=c.cnpj AND c.id_empresa=f.id_empresa WHERE f.habilitado AND c.id_empresa IN $grupo_empresarial");
            $ps->execute();
            $ps->bind_result($id, $nome, $codigo);
            while ($ps->fetch()) {
                $hash = $id . "_" . $nome;
                if (!isset($fornecedor_produto[$hash])) {
                    $fornecedor_produto[$hash] = array();
                }
                $fornecedor_produto[$hash][] = $codigo;
            }
            $ps->close();

            $produto_fornecedor = array();

            foreach ($fornecedor_produto as $f => $produtos) {
                $forn = explode('_', $f, 2);
                $fornecedor = new FornecedorReduzido();
                $fornecedor->id = intval($forn[0]);
                $fornecedor->nome = $forn[1];
                foreach ($produtos as $key2 => $produto) {
                    if (!isset($produtos_fornecedor[$produto])) {
                        $produto_fornecedor[$produto] = array();
                    }
                    $produto_fornecedor[$produto][] = $fornecedor;
                }
            }
           
            $encomendas = $empresa->getEncomendas($con, 0, 10, "encomenda.agrupada=false");

            $cotacoes = $empresa->getCotacoesGrupais($con, 0, 50, "", "c.id DESC");

            $cotacao_dia = array();

            foreach ($cotacoes as $key2 => $value) {

                $data = Utilidades::normalizarDia($value->data);

                $cotacao_dia[$data] = $value;
            }

            foreach ($encomendas as $key2 => $value) {

                $data = Utilidades::normalizarDia($value->data);

                $cotacao = null;
                if (!isset($cotacao_dia[$data])) {

                    $c = new CotacaoGrupal();
                    $c->empresa = $empresa;
                    $c->enviada = false;
                    $c->observacoes = "Cotacao gerada automaticamente pelo sistema referente a data " . date("d/m/Y", $data / 1000);
                    $c->merge($con);

                    $cotacao = $c;

                    $cotacao_dia[$data] = $cotacao;
                } else {

                    $cotacao = $cotacao_dia[$data];
                }

                $value->produtos = $value->getProdutos($con);
                foreach ($value->produtos as $ep => $produto_encomenda) {

                    $pc = new ProdutoCotacaoGrupal();
                    $pc->cotacao = $cotacao;
                    $pc->data = $data;
                    $pc->produto = $produto_encomenda->produto;
                    $pc->quantidade = $produto_encomenda->quantidade;

                    $a = -1;
                    foreach ($cotacao->produtos as $k2 => $produto_cotacao) {
                        if ($produto_cotacao->produto->codigo === $pc->produto->codigo) {
                            $a = $k2;
                            break;
                        }
                    }

                    if ($a > 0) {

                        $cotacao->produtos[$a]->quantidade += $pc->quantidade;
                        
                    } else {

                        $cotacao->produtos[] = $pc;

                        $tmp = array();
                        if (isset($produto_fornecedor[$pc->produto->codigo])) {
                            $tmp = $produto_fornecedor[$pc->produto->codigo];
                        }

                        foreach ($tmp as $kk => $ff) {

                            //----- colocando fornecedor se nao exite

                            foreach ($cotacao->fornecedores as $kf => $fff) {
                                if ($fff->id === $ff->id) {
                                    continue 2;
                                }
                            }

                            $cotacao->fornecedores[] = $ff;

                            //----------------------------------------
                        }
                    }
                }

                $cotacao->merge($con);

                $ps = $con->getConexao()->prepare("UPDATE encomenda SET agrupada=true,data=data WHERE id=$value->id");
                $ps->execute();
                $ps->close();
                
                
            }
        }
    }

}
