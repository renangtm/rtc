<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProdutoCotacaoEntrada
 *
 * @author Renan
 */
class AnaliseCotacaoEntrada {

    public $id;
    public $nome_produto;
    public $quantidade_produto;
    public $valor;
    public $valor_maximo;
    public $valor_minimo;
    public $data;
    public $ids_produtos;
    public $custo_atual;
    public $id_cotacao;
    public $nome_fornecedor;
    public $ultimo_custo;
    public $recusada;
    
    function __construct() {

        $this->id = 0;
        $this->nome_produto = "";
        $this->quantidade_produto = 0;
        $this->valor = 0;
        $this->valor_maximo = 0;
        $this->valor_minimo = 0;
        $this->data = round(microtime(true) * 1000);
        $this->ids_produtos = array();
        $this->custo_atual = 0;
        $this->id_cotacao = 0;
        $this->nome_fornecedor = "";
        $this->ultimo_custo = 0;
       
    }

    public function recusar($con, $empresa) {

        $in = "(-1";
        foreach ($this->ids_produtos as $key => $value) {

            $ps = $con->getConexao()->prepare("UPDATE produto_cotacao_entrada SET checado=2 WHERE id=$value");
            $ps->execute();
            $ps->close();

            $in .= ",$value";
        }

        $in .= ")";


        $adm = $empresa->getAdm($con);
        if ($adm !== null) {
            $empresa = $adm;
        }

        $t = new Tarefa();
        $t->tipo_tarefa = Sistema::TT_COTACAO($empresa->id);
        $t->titulo = "Preco de cotacao do produto $this->nome_produto rejeitado";
        $t->descricao = "Preco de cotacao do produto $this->nome_produto rejeitado, efetue novas cotacoes";
        $t->tipo_entidade_relacionada = "COT_" . $empresa->id;
        $t->id_entidade_relacionada = $empresa->id;

        try {
            Sistema::novaTarefaEmpresa($con, $t, $empresa);
        } catch (Exception $e) {
            
        }

        $cargo = Empresa::CF_ASSISTENTE_COMPRAS($empresa);
        $usuario = $empresa->getUsuarios($con, 0, 10000, "usuario.id_cargo=$cargo->id");


        $email = "Produtos recusados, cotar novamente: <hr> <ul>";

        $ps = $con->getConexao()->prepare("SELECT p.nome,cp.valor,f.nome FROM produto p INNER JOIN produto_cotacao_entrada cp ON cp.id_produto=p.id INNER JOIN cotacao_entrada c ON cp.id_cotacao=c.id INNER JOIN fornecedor f ON f.id=c.id_fornecedor WHERE cp.id IN $in");
        $ps->execute();
        $ps->bind_result($nome_produto, $valor, $nome_fornecedor);

        while ($ps->fetch()) {

            $email .= "<li>Produto: $nome_produto, Valor: R$ " . round($valor, 2) . ", Fornecedor: $nome_fornecedor </li>";
        }

        $email .= "</ul>";

        foreach ($usuario as $key => $value) {

            $empresa->email->enviarEmail($value->email, "Recusa de valor da cotacao", $email);
        }
    }

    public function passar($con) {

        foreach ($this->ids_produtos as $key => $value) {

            $ps = $con->getConexao()->prepare("UPDATE produto_cotacao_entrada SET checado=1 WHERE id=$value");
            $ps->execute();
            $ps->close();
        }
    }

    public function aprovar($con, $empresa) {

        $ids = "($empresa->id";

        $filiais = $empresa->getFiliais($con);

        foreach ($filiais as $key => $value) {
            $ids .= ",$value->id";
        }

        $ids .= ")";

        $ps = $con->getConexao()->prepare("UPDATE produto SET custo=$this->valor,valor_base=ROUND($this->valor/0.821,2) WHERE codigo=$this->id AND id_empresa IN $ids");
        $ps->execute();
        $ps->close();
    }

    public function campanha($con, $empresa, $dias) {

        $ps = $con->getConexao()->prepare("INSERT INTO campanha_encomenda(valor_base,termino,id_empresa,codigo_produto) VALUES($this->valor,DATE_ADD(CURRENT_DATE,INTERVAL $dias DAY),$empresa->id,$this->id)");
        $ps->execute();
        $ps->close();
    }

}
