<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utilidades
 *
 * @author Renan
 */
class Utilidades {

    public static function getAttr($obj,$atributo){
        
        $a = explode('.', $atributo);
        $o = $obj;
        
        foreach($a as $key=>$value){
            
            if(!isset($o->$value)){
                
                return "";
                
            }
            
            $o = $o->$value;
            
        }
        
        return $o;
        
    }
    
    public static function eq($string) {

        return strtoupper($string);
        
    }

    public static function copy($entidade) {

        $ne = unserialize(serialize($entidade));

        return $ne;
    }

    public static function copyId0($entidade) {

        $ne = unserialize(serialize($entidade));
        
        if(!is_array($ne)){
            $ne->id = 0;
        }else{
            foreach($ne as $key=>$value){
                $ne[$key]->id = 0;
            }
        }

        return $ne;
    }

    public static function toJson($object, $pilha = null) {

        if ($object === null) {

            return "null";
        }

        if (is_array($object)) {

            $str = "[";

            foreach ($object as $i => $val) {

                if ($i > 0)
                    $str .= ",";

                $str .= Utilidades::toJson($val, $pilha);
            }

            $str .= "]";

            return $str;
        }else if (is_int($object)) {

            return intval($object . "");
        } else if (is_double($object)) {

            return doubleval($object . "");
        } else if (is_bool($object)) {

            return ($object ? "true" : "false");
        } else if (is_string($object)) {

            return '"' . $object . '"';
        }


        if ($pilha == null) {

            $pilha = array();
        }

        $str = '{';

        $str .= "\"_classe\":\"" . get_class($object) . "\"";

        foreach ($pilha as $key => $value) {

            if ($value === $object) {

                $v = count($pilha) - $key;

                $str .= ",\"recursao\":$v";

                return $str . "}";
            }
        }

        $pilha[] = $object;

        foreach ($object as $atributo => $valor) {

            $str .= ",\"$atributo\":" . Utilidades::toJson($valor, $pilha);
        }


        $str .= '}';

        unset($pilha[count($pilha) - 1]);

        return $str;
    }

    private static function getObject($obj, $pilha = null) {

        if ($pilha == null) {

            $pilha = array();
        }

        if (is_array($obj)) {

            foreach ($obj as $key => $value) {

                $obj[$key] = self::getObject($value, $pilha);
            }

            return $obj;
        }

        if (!is_object($obj)) {

            return $obj;
        }

        if (isset($obj->recursao)) {

            return $pilha[count($pilha) - $obj->recursao];
        }

        $real = null;

        eval('$real = new ' . $obj->_classe . "();");

        $pilha[] = $real;

        foreach ($obj as $atributo => $valor) {

            if ($atributo == "_classe")
                continue;

            if (is_numeric($valor) || is_string($valor) || is_bool($valor)) {

                $real->$atributo = $valor;
            } else if (is_array($valor)) {

                $vet = array();

                foreach ($valor as $i => $val) {

                    $vet[] = self::getObject($val, $pilha);
                }

                $real->$atributo = $vet;
            } else if (is_object($valor)) {

                $real->$atributo = self::getObject($valor, $pilha);
            }
        }

        unset($pilha[count($pilha)]);

        return $real;
    }

    public static function fromJson($str) {

        $js = json_decode($str);

        return self::getObject($js);
    }

    public static function getCotacaoEntradaTeste($empresa) {

        $e1 = new Endereco();

        $e1->rua = "Rua Teste";
        $e1->bairro = "Bairro Teste";
        $e1->numero = 0;
        $e1->cep = new CEP("07195201");
        $e1->cidade = Sistema::getCidades(new ConnectionFactory());
        $e1->cidade = $e1->cidade[0];


        $e2 = new Endereco();

        $e2->rua = "Rua Teste";
        $e2->bairro = "Bairro Teste";
        $e2->numero = 0;
        $e2->cep = new CEP("07195201");
        $e2->cidade = Sistema::getCidades(new ConnectionFactory());
        $e2->cidade = $e2->cidade[400];


        $e3 = new Endereco();

        $e3->rua = "Rua Teste";
        $e3->bairro = "Bairro Teste";
        $e3->numero = 0;
        $e3->cep = new CEP("07195201");
        $e3->cidade = Sistema::getCidades(new ConnectionFactory());
        $e3->cidade = $e3->cidade[100];

        $e4 = new Endereco();

        $e4->rua = "Rua Teste";
        $e4->bairro = "Bairro Teste";
        $e4->numero = 0;
        $e4->cep = new CEP("07195201");
        $e4->cidade = Sistema::getCidades(new ConnectionFactory());
        $e4->cidade = $e4->cidade[51];

        // criando categorias de produto

        $categoria = new CategoriaProduto();
        $categoria->ipi = 0;
        $categoria->base_calculo = 40;
        $categoria->icms = 0;
        $categoria->icms_normal = true;
        $categoria->merge(new ConnectionFactory());

        // criando produtos

        $produto = new Produto();

        $produto->nome = "teste";
        $produto->id_universal = 12;
        $produto->categoria = $categoria;
        $produto->liquido = false;
        $produto->unidade = "Galao";
        $produto->quantidade_unidade = 0.25;
        $produto->empresa = $empresa;
        $produto->valor_base = 100;
        $produto->custo = 123;
        $produto->ncm = "12341234";
        $produto->peso_liquido = 12;
        $produto->peso_bruto = 23;
        $produto->estoque = 85;
        $produto->disponivel = 85;
        $produto->transito = 14;
        $produto->grade = new Grade("15,2,1");

        $produto->merge(new ConnectionFactory());
        $produto->merge(new ConnectionFactory());

        $lote = new Lote();

        $lote->quantidade_inicial = 40;
        $lote->quantidade_real = 40;
        $lote->grade = $produto->grade;
        $lote->produto = $produto;
        $lote->codigo_fabricante = "1234";

        $lote->merge(new ConnectionFactory());

        $lote2 = new Lote();

        $lote2->quantidade_inicial = 45;
        $lote2->quantidade_real = 45;
        $lote2->grade = $produto->grade;
        $lote2->produto = $produto;
        $lote2->codigo_fabricante = "1234";

        $lote2->merge(new ConnectionFactory());

        $lote3 = new Lote();

        $lote3->quantidade_inicial = 0;
        $lote3->quantidade_real = 0;
        $lote3->grade = $produto->grade;
        $lote3->produto = $produto;
        $lote3->codigo_fabricante = "1234";

        $lote3->merge(new ConnectionFactory());

        $lote4 = new Lote();

        $lote4->quantidade_inicial = 100;
        $lote4->quantidade_real = 100;
        $lote4->validade = round(microtime(true) * 1000) + (60 * 24 * 60 * 60 * 1000);
        $lote4->grade = $produto->grade;
        $lote4->produto = $produto;
        $lote4->codigo_fabricante = "1234";

        $lote4->merge(new ConnectionFactory());

        $produto2 = new Produto();

        $produto2->nome = "teste";
        $produto2->id_universal = 12;
        $produto2->categoria = $categoria;
        $produto2->liquido = false;
        $produto2->unidade = "Galao";
        $produto2->quantidade_unidade = 0.25;
        $produto2->empresa = $empresa;
        $produto2->valor_base = 15;
        $produto2->custo = 123;
        $produto2->ncm = "12341234";
        $produto2->peso_liquido = 12;
        $produto2->peso_bruto = 23;
        $produto2->estoque = 80;
        $produto2->disponivel = 80;
        $produto2->transito = 14;
        $produto2->grade = new Grade("15,2,1");

        $produto2->merge(new ConnectionFactory());
        $produto2->merge(new ConnectionFactory());

        $lote = new Lote();

        $lote->quantidade_inicial = 30;
        $lote->quantidade_real = 30;
        $lote->grade = $produto2->grade;
        $lote->produto = $produto2;
        $lote->codigo_fabricante = "1234";

        $lote->merge(new ConnectionFactory());

        $lote2 = new Lote();

        $lote2->quantidade_inicial = 50;
        $lote2->quantidade_real = 50;
        $lote2->grade = $produto2->grade;
        $lote2->produto = $produto2;
        $lote2->codigo_fabricante = "1234";

        $lote2->merge(new ConnectionFactory());

        $produto3 = new Produto();

        $produto3->nome = "teste";
        $produto3->id_universal = 12;
        $produto3->categoria = $categoria;
        $produto3->liquido = false;
        $produto3->unidade = "Galao";
        $produto3->quantidade_unidade = 0.25;
        $produto3->empresa = $empresa;
        $produto3->valor_base = 10;
        $produto3->custo = 123;
        $produto3->ncm = "12341234";
        $produto3->peso_liquido = 12;
        $produto3->peso_bruto = 23;
        $produto3->estoque = 80;
        $produto3->disponivel = 80;
        $produto3->transito = 80;
        $produto3->grade = new Grade("40,10,2");

        $produto3->merge(new ConnectionFactory());
        $produto3->merge(new ConnectionFactory());

        $lote = new Lote();

        $lote->quantidade_inicial = 80;
        $lote->quantidade_real = 80;
        $lote->grade = $produto3->grade;
        $lote->produto = $produto3;
        $lote->codigo_fabricante = "1234";

        $lote->merge(new ConnectionFactory());

        // criando transportadora

        $tra = Utilidades::getTransportadoraTeste($empresa);

        //criando cliente

        $fornecedor = Utilidades::getFornecedorTeste($empresa);

        //------ criando pedido;

        $cot = new CotacaoEntrada();
        $cot->fornecedor = $fornecedor;
        $cot->transportadora = $tra;
        $cot->frete = 10;
        $cot->empresa = $empresa;
        $cot->status = Sistema::getStatusCotacaoEntrada();
        $cot->status = $cot->status[0];
        $cot->tratar_em_litros = false;
        $cot->usuario = Utilidades::getUsuarioTeste($empresa);


        $cot->produtos = array();

        $pp1 = new ProdutoCotacaoEntrada();
        $pp1->produto = $produto;
        $pp1->quantidade = 65;
        $pp1->valor = 10;
        $pp1->cotacao = $cot;

        $cot->produtos[] = $pp1;


        $pp2 = new ProdutoCotacaoEntrada();
        $pp2->produto = $produto2;
        $pp2->quantidade = 20;
        $pp2->valor = 100;
        $pp2->cotacao = $cot;

        $cot->produtos[] = $pp2;

        $pp3 = new ProdutoCotacaoEntrada();
        $pp3->produto = $produto;
        $pp3->quantidade = 21;
        $pp3->valor = 150;
        $pp3->cotacao = $cot;

        $cot->produtos[] = $pp3;

        $pp4 = new ProdutoCotacaoEntrada();
        $pp4->produto = $produto3;
        $pp4->quantidade = 56;
        $pp4->valor = 11;
        $pp4->cotacao = $cot;

        $cot->produtos[] = $pp4;


        $cot->merge(new ConnectionFactory());

        return $cot;
    }

    public static function getVencimentoTeste($nota) {

        $ven = new Vencimento();
        $ven->valor = 100;
        $ven->nota = $nota;
        $ven->nota->saida = true;

        $ven->merge(new ConnectionFactory());

        return $ven;
    }

    public static function getMovimentoTeste($ven) {

        $con = new ConnectionFactory();

        $historico = new Historico();
        $historico->nome = "Teste";
        $historico->merge($con);

        $operacao = new Operacao();
        $operacao->nome = "Teste2";
        $operacao->debito = false;
        $operacao->merge($con);

        $banco = new Banco();
        $banco->saldo = 10000;
        $banco->empresa = $ven->nota->empresa;
        $banco->nome = "Itau";
        $banco->conta = "dedede";

        $banco->merge(new ConnectionFactory());

        $m1 = new Movimento();
        $m1->banco = $banco;
        $m1->vencimento = $ven;
        $m1->valor = 100;
        $m1->juros = 1.5;
        $m1->descontos = 2;
        $m1->operacao = $operacao;
        $m1->historico = $historico;

        $m1->insert($con);

        return $m1;
    }

    public static function getNotaTeste($empresa) {

        $con = new ConnectionFactory();

        $e1 = new Endereco();

        $e1->rua = "Rua Teste";
        $e1->bairro = "Bairro Teste";
        $e1->numero = 0;
        $e1->cep = new CEP("07195201");
        $e1->cidade = Sistema::getCidades(new ConnectionFactory());
        $e1->cidade = $e1->cidade[0];


        $e2 = new Endereco();

        $e2->rua = "Rua Teste";
        $e2->bairro = "Bairro Teste";
        $e2->numero = 0;
        $e2->cep = new CEP("07195201");
        $e2->cidade = Sistema::getCidades(new ConnectionFactory());
        $e2->cidade = $e2->cidade[400];


        $e3 = new Endereco();

        $e3->rua = "Rua Teste";
        $e3->bairro = "Bairro Teste";
        $e3->numero = 0;
        $e3->cep = new CEP("07195201");
        $e3->cidade = Sistema::getCidades(new ConnectionFactory());
        $e3->cidade = $e3->cidade[100];

        $e4 = new Endereco();

        $e4->rua = "Rua Teste";
        $e4->bairro = "Bairro Teste";
        $e4->numero = 0;
        $e4->cep = new CEP("07195201");
        $e4->cidade = Sistema::getCidades(new ConnectionFactory());
        $e4->cidade = $e4->cidade[51];


        // criando categorias de produto

        $categoria = new CategoriaProduto();
        $categoria->ipi = 0;
        $categoria->base_calculo = 40;
        $categoria->icms = 0;
        $categoria->icms_normal = true;
        $categoria->merge($con);

        // criando produtos

        $produto = new Produto();

        $produto->nome = "teste";
        $produto->id_universal = 12;
        $produto->categoria = $categoria;
        $produto->liquido = false;
        $produto->unidade = "Galao";
        $produto->quantidade_unidade = 0.25;
        $produto->empresa = $empresa;
        $produto->valor_base = 100;
        $produto->custo = 123;
        $produto->ncm = "12341234";
        $produto->peso_liquido = 12;
        $produto->peso_bruto = 23;
        $produto->estoque = 85;
        $produto->disponivel = 85;
        $produto->grade = new Grade("15,2,1");

        $produto->merge(new ConnectionFactory());

        $lote = new Lote();

        $lote->quantidade_inicial = 40;
        $lote->quantidade_real = 40;
        $lote->grade = $produto->grade;
        $lote->produto = $produto;
        $lote->codigo_fabricante = "1234";

        $lote->merge(new ConnectionFactory());

        $lote2 = new Lote();

        $lote2->quantidade_inicial = 45;
        $lote2->quantidade_real = 45;
        $lote2->grade = $produto->grade;
        $lote2->produto = $produto;
        $lote2->codigo_fabricante = "1234";

        $lote2->merge(new ConnectionFactory());

        $lote3 = new Lote();

        $lote3->quantidade_inicial = 0;
        $lote3->quantidade_real = 0;
        $lote3->grade = $produto->grade;
        $lote3->produto = $produto;
        $lote3->codigo_fabricante = "1234";

        $lote3->merge(new ConnectionFactory());

        $lote4 = new Lote();

        $lote4->quantidade_inicial = 100;
        $lote4->quantidade_real = 100;
        $lote4->validade = round(microtime(true) * 1000) + (60 * 24 * 60 * 60 * 1000);
        $lote4->grade = $produto->grade;
        $lote4->produto = $produto;
        $lote4->codigo_fabricante = "1234";

        $lote4->merge(new ConnectionFactory());

        $produto2 = new Produto();

        $produto2->nome = "teste";
        $produto2->id_universal = 12;
        $produto2->categoria = $categoria;
        $produto2->liquido = false;
        $produto2->unidade = "Galao";
        $produto2->quantidade_unidade = 0.25;
        $produto2->empresa = $empresa;
        $produto2->valor_base = 15;
        $produto2->custo = 123;
        $produto2->ncm = "12341234";
        $produto2->peso_liquido = 12;
        $produto2->peso_bruto = 23;
        $produto2->estoque = 80;
        $produto2->disponivel = 80;
        $produto2->grade = new Grade("15,2,1");

        $produto2->merge(new ConnectionFactory());

        $lote = new Lote();

        $lote->quantidade_inicial = 30;
        $lote->quantidade_real = 30;
        $lote->grade = $produto2->grade;
        $lote->produto = $produto2;
        $lote->codigo_fabricante = "1234";

        $lote->merge(new ConnectionFactory());

        $lote2 = new Lote();

        $lote2->quantidade_inicial = 50;
        $lote2->quantidade_real = 50;
        $lote2->grade = $produto2->grade;
        $lote2->produto = $produto2;
        $lote2->codigo_fabricante = "1234";

        $lote2->merge(new ConnectionFactory());

        $produto3 = new Produto();

        $produto3->nome = "teste";
        $produto3->id_universal = 12;
        $produto3->categoria = $categoria;
        $produto3->liquido = false;
        $produto3->unidade = "Galao";
        $produto3->quantidade_unidade = 0.25;
        $produto3->empresa = $empresa;
        $produto3->valor_base = 10;
        $produto3->custo = 123;
        $produto3->ncm = "12341234";
        $produto3->peso_liquido = 12;
        $produto3->peso_bruto = 23;
        $produto3->estoque = 80;
        $produto3->disponivel = 80;
        $produto3->grade = new Grade("40,10,2");

        $produto3->merge(new ConnectionFactory());

        $lote = new Lote();

        $lote->quantidade_inicial = 80;
        $lote->quantidade_real = 80;
        $lote->grade = $produto3->grade;
        $lote->produto = $produto3;
        $lote->codigo_fabricante = "1234";

        $lote->merge(new ConnectionFactory());

        //criando cliente

        $fornecedor = new Fornecedor();

        $fornecedor->nome = "Teste";
        $fornecedor->telefone = "111111";
        $fornecedor->cnpj = new CNPJ("11122233344455");
        $fornecedor->empresa = $empresa;
        $fornecedor->email = new Email("renan.miranda@agrofauna.com.br");
        $fornecedor->endereco = $e4;
        $fornecedor->merge(new ConnectionFactory());

        $tra = Utilidades::getTransportadoraTeste($empresa);

        //------ criando cotacao;

        $nota = new Nota();
        $nota->fornecedor = $fornecedor;
        $nota->incluir_frete = true;
        $nota->transportadora = $tra;
        $nota->forma_pagamento = Sistema::getFormasPagamento();
        $nota->forma_pagamento = $nota->forma_pagamento[0];
        $nota->saida = false;
        $nota->chave = "";
        $nota->interferir_estoque = true;
        $nota->frete = 10;
        $nota->prazo = 20;
        $nota->empresa = $empresa;

        $nota->produtos = array();

        $pp1 = new ProdutoNota();
        $pp1->produto = $produto;
        $pp1->quantidade = 65;
        $pp1->cfop = "123";
        $pp1->valor_unitario = 10;
        $pp1->nota = $nota;

        $nota->produtos[] = $pp1;


        $pp2 = new ProdutoNota();
        $pp2->produto = $produto2;
        $pp2->quantidade = 20;
        $pp2->cfop = "123";
        $pp2->valor_unitario = 100;
        $pp2->nota = $nota;

        $nota->produtos[] = $pp2;

        $pp3 = new ProdutoNota();
        $pp3->produto = $produto;
        $pp3->quantidade = 21;
        $pp3->cfop = "123";
        $pp3->valor_unitario = 150;
        $pp3->nota = $nota;

        $nota->produtos[] = $pp3;

        $pp4 = new ProdutoNota();
        $pp4->produto = $produto3;
        $pp4->quantidade = 56;
        $pp4->cfop = "123";
        $pp4->valor_unitario = 11;
        $pp4->nota = $nota;

        $nota->produtos[] = $pp4;

        $nota->interferir_estoque = false;


        $nota->merge(new ConnectionFactory());

        return $nota;
    }

    public static function getProdutoTeste($empresa) {

        $con = new ConnectionFactory();

        $produto = new Produto();

        $produto->nome = "teste";
        $produto->id_universal = 12;
        $produto->categoria = new CategoriaProduto();
        $produto->categoria->nome = "TEste";
        $produto->categoria->merge($con);
        $produto->classe_risco = 23;
        $produto->fabricante = "FAB";
        $produto->imagem = "234fdff";

        $produto->liquido = false;
        $produto->unidade = "Galao";
        $produto->quantidade_unidade = 0.25;
        $produto->empresa = $empresa;
        $produto->valor_base = 0.3;
        $produto->custo = 123;
        $produto->ncm = "12341234";
        $produto->peso_liquido = 12;
        $produto->peso_bruto = 23;
        $produto->estoque = 4000;
        $produto->disponivel = 4000;
        $produto->transito = 0;
        $produto->grade = new Grade("15,2,1");

        $produto->merge(new ConnectionFactory());

        return $produto;
    }

    public static function getReceituarioTeste($empresa) {

        $con = new ConnectionFactory();

        $r = new Receituario();

        $produto = Utilidades::getProdutoTeste($empresa);

        $cult = new Cultura();
        $cult->nome = "Teste";
        $cult->merge($con);

        $prag = new Praga();
        $prag->nome = "Teste";
        $prag->merge($con);

        $r->produto = $produto;
        $r->cultura = $cult;
        $r->praga = $prag;

        $r->merge($con);

        return $r;
    }

    public static function getCampanhaTeste($empresa, $produto = null) {

        $cat = new Campanha();

        $cat->nome = "Campanha teste";
        $cat->prazo = 12;
        $cat->inicio -= 100000;
        $cat->fim += 100000;
        $cat->parcelas = 1;
        $cat->cliente_expression = "123";
        $cat->empresa = $empresa;

        $p = new ProdutoCampanha();

        $p->produto = ($produto == null) ? Utilidades::getProdutoTeste($empresa) : $produto;

        $p->campanha = $cat;

        $p2 = new ProdutoCampanha();

        $p2->produto = Utilidades::getProdutoTeste($empresa);

        $p2->campanha = $cat;

        $cat->produtos[] = $p;
        $cat->produtos[] = $p2;

        $cat->merge(new ConnectionFactory());


        return $cat;
    }

    public static function getGrupoCidadesTeste($empresa) {

        $con = new ConnectionFactory();

        $grupo = new GrupoCidades();
        $grupo->nome = "Teste";

        $grupo->empresa = $empresa;

        $cidades = Sistema::getCidades($con);

        $grupo->cidades = array($cidades[0], $cidades[1], $cidades[2], $cidades[3]);

        $grupo->merge($con);

        return $grupo;
    }

    public static function getTransportadoraTeste($empresa) {

        $doc = new Documento();

        $doc->categoria = Sistema::getCategoriaDocumentos();
        $doc->categoria = $doc->categoria[0];

        $doc->numero = "erfqwerewq";

        $doc->link = "dfdwerferwfffffff";


        $doc2 = new Documento();

        $doc2->categoria = Sistema::getCategoriaDocumentos();
        $doc2->categoria = $doc2->categoria[1];

        $doc2->numero = "12344321";

        $doc2->link = "12344321";


        $transportadora = new Transportadora();
        $transportadora->razao_social = "T1";
        $transportadora->nome_fantasia = "T2";
        $transportadora->cnpj = new CNPJ("11111111111111");
        $transportadora->empresa = $empresa;
        $transportadora->email = new Email("renan_goncalves@outlook.com.br");
        $transportadora->despacho = 999;
        $transportadora->habilitada = true;
        $transportadora->telefones[] = new Telefone("1234432");
        $transportadora->inscricao_estadual = "333333333";


        $e = new Endereco();

        $e->rua = "Rua Teste";
        $e->bairro = "Bairro Teste";
        $e->numero = 0;
        $e->cep = new CEP("07195201");
        $e->cidade = Sistema::getCidades(new ConnectionFactory());
        $e->cidade = $e->cidade[0];

        $transportadora->endereco = $e;

        $regra = new RegraTabela();

        $regra->condicional = "!valor>50&'!cliente.cidade'='TESTE'";
        $regra->resultante = "!valor+!peso*5";

        $regra2 = new RegraTabela();

        $regra2->condicional = "!valor>40&!valor<50&'!cliente.cidade'='TESTE'";
        $regra2->resultante = "!valor+!peso*4";



        $cidade = new stdClass();
        $cidade->nome = "TESTE";

        $cidade2 = new stdClass();
        $cidade2->nome = "TEST";


        $tabela = new Tabela();

        $tabela->nome = "teste unitario";
        $tabela->regras = array($regra, $regra2);

        $transportadora->tabela = $tabela;

        $transportadora->merge(new ConnectionFactory());

        $transportadora->setDocumentos(array($doc, $doc2), new ConnectionFactory());

        return $transportadora;
    }

    public static function getUsuarioTeste($empresa) {

        $usuario = new Usuario();

        $usuario->nome = "Teste";
        $usuario->telefones[] = new Telefone("1234");
        $usuario->cpf = new CPF("11122233344455");
        $usuario->empresa = $empresa;
        $usuario->login = "teste";
        $usuario->senha = "123456";

        $e = new Endereco();

        $e->rua = "Rua Teste";
        $e->bairro = "Bairro Teste";
        $e->numero = 0;
        $e->cep = new CEP("07195201");
        $e->cidade = Sistema::getCidades(new ConnectionFactory());
        $e->cidade = $e->cidade[0];

        $usuario->endereco = $e;

        $usuario->email = new Email("renan.miranda@agrofauna.com.br");
        $usuario->email->senha = "5hynespt";
        

        $usuario->merge(new ConnectionFactory());


        return $usuario;
    }

    public static function getLogoTeste($empresa) {

        $con = new ConnectionFactory();

        $p = new Logo();
        $p->empresa = $empresa;
        $p->cor_predominante = "255,255,255";
        $p->logo = Utilidades::base64encode("LOGO INVALIDO");

        $p->merge($con);

        return $p;
    }

    public static function getParametrosEmissaoTeste($empresa) {

        $con = new ConnectionFactory();

        $p = new ParametrosEmissao();
        $p->empresa = $empresa;
        $p->lote = 0;
        $p->senha_certificado = "1234";
        $p->serie = 0;
        $p->nota = 0;
        $p->certificado = Utilidades::base64encode("1234124rewrfw421412");

        $p->merge($con);

        return $p;
    }

    public static function getPedidoTeste($empresa) {

        $e1 = new Endereco();

        $e1->rua = "Rua Teste";
        $e1->bairro = "Bairro Teste";
        $e1->numero = 0;
        $e1->cep = new CEP("07195201");
        $e1->cidade = Sistema::getCidades(new ConnectionFactory());
        $e1->cidade = $e1->cidade[0];


        $e2 = new Endereco();

        $e2->rua = "Rua Teste";
        $e2->bairro = "Bairro Teste";
        $e2->numero = 0;
        $e2->cep = new CEP("07195201");
        $e2->cidade = Sistema::getCidades(new ConnectionFactory());
        $e2->cidade = $e2->cidade[400];


        $e3 = new Endereco();

        $e3->rua = "Rua Teste";
        $e3->bairro = "Bairro Teste";
        $e3->numero = 0;
        $e3->cep = new CEP("07195201");
        $e3->cidade = Sistema::getCidades(new ConnectionFactory());
        $e3->cidade = $e3->cidade[100];

        $e4 = new Endereco();

        $e4->rua = "Rua Teste";
        $e4->bairro = "Bairro Teste";
        $e4->numero = 0;
        $e4->cep = new CEP("07195201");
        $e4->cidade = Sistema::getCidades(new ConnectionFactory());
        $e4->cidade = $e4->cidade[51];

        // criando categorias de produto

        $categoria = new CategoriaProduto();
        $categoria->ipi = 0;
        $categoria->base_calculo = 40;
        $categoria->icms = 0;
        $categoria->icms_normal = true;
        $categoria->merge(new ConnectionFactory());

        // criando produtos

        $produto = new Produto();

        $produto->nome = "teste";
        $produto->id_universal = 12;
        $produto->categoria = $categoria;
        $produto->liquido = false;
        $produto->unidade = "Galao";
        $produto->quantidade_unidade = 0.25;
        $produto->empresa = $empresa;
        $produto->valor_base = 100;
        $produto->custo = 123;
        $produto->ncm = "12341234";
        $produto->peso_liquido = 12;
        $produto->peso_bruto = 23;
        $produto->estoque = 85;
        $produto->disponivel = 85;
        $produto->transito = 14;
        $produto->grade = new Grade("15,2,1");

        $produto->merge(new ConnectionFactory());
        $produto->merge(new ConnectionFactory());

        $lote = new Lote();

        $lote->quantidade_inicial = 40;
        $lote->quantidade_real = 40;
        $lote->grade = $produto->grade;
        $lote->produto = $produto;
        $lote->codigo_fabricante = "1234";

        $lote->merge(new ConnectionFactory());

        $lote2 = new Lote();

        $lote2->quantidade_inicial = 45;
        $lote2->quantidade_real = 45;
        $lote2->grade = $produto->grade;
        $lote2->produto = $produto;
        $lote2->codigo_fabricante = "1234";

        $lote2->merge(new ConnectionFactory());

        $lote3 = new Lote();

        $lote3->quantidade_inicial = 0;
        $lote3->quantidade_real = 0;
        $lote3->grade = $produto->grade;
        $lote3->produto = $produto;
        $lote3->codigo_fabricante = "1234";

        $lote3->merge(new ConnectionFactory());

        $produto2 = new Produto();

        $produto2->nome = "teste";
        $produto2->id_universal = 12;
        $produto2->categoria = $categoria;
        $produto2->liquido = false;
        $produto2->unidade = "Galao";
        $produto2->quantidade_unidade = 0.25;
        $produto2->empresa = $empresa;
        $produto2->valor_base = 15;
        $produto2->custo = 123;
        $produto2->ncm = "12341234";
        $produto2->peso_liquido = 12;
        $produto2->peso_bruto = 23;
        $produto2->estoque = 80;
        $produto2->disponivel = 80;
        $produto2->transito = 14;
        $produto2->grade = new Grade("15,2,1");

        $produto2->merge(new ConnectionFactory());
        $produto2->merge(new ConnectionFactory());

        $lote = new Lote();

        $lote->quantidade_inicial = 30;
        $lote->quantidade_real = 30;
        $lote->grade = $produto2->grade;
        $lote->produto = $produto2;
        $lote->codigo_fabricante = "1234";

        $lote->merge(new ConnectionFactory());

        $lote2 = new Lote();

        $lote2->quantidade_inicial = 50;
        $lote2->quantidade_real = 50;
        $lote2->grade = $produto2->grade;
        $lote2->produto = $produto2;
        $lote2->codigo_fabricante = "1234";

        $lote2->merge(new ConnectionFactory());

        $produto3 = new Produto();

        $produto3->nome = "teste";
        $produto3->id_universal = 12;
        $produto3->categoria = $categoria;
        $produto3->liquido = false;
        $produto3->unidade = "Galao";
        $produto3->quantidade_unidade = 0.25;
        $produto3->empresa = $empresa;
        $produto3->valor_base = 10;
        $produto3->custo = 123;
        $produto3->ncm = "12341234";
        $produto3->peso_liquido = 12;
        $produto3->peso_bruto = 23;
        $produto3->estoque = 80;
        $produto3->disponivel = 80;
        $produto3->transito = 80;
        $produto3->grade = new Grade("40,10,2");

        $produto3->merge(new ConnectionFactory());
        $produto3->merge(new ConnectionFactory());

        $lote = new Lote();

        $lote->quantidade_inicial = 80;
        $lote->quantidade_real = 80;
        $lote->grade = $produto3->grade;
        $lote->produto = $produto3;
        $lote->codigo_fabricante = "1234";

        $lote->merge(new ConnectionFactory());



        // criando transportadora

        $tra = Utilidades::getTransportadoraTeste($empresa);
        //criando cliente


        $cliente = Utilidades::getClienteTeste($empresa);

        //------ criando pedido;

        $pedido = new Pedido();
        $pedido->cliente = $cliente;
        $pedido->transportadora = $tra;
        $pedido->incluir_frete = true;
        $pedido->frete = 10;
        $pedido->prazo = 20;
        $pedido->empresa = $empresa;
        $pedido->forma_pagamento = Sistema::getFormasPagamento();
        $pedido->forma_pagamento = $pedido->forma_pagamento[0];
        $pedido->usuario = Utilidades::getUsuarioTeste($empresa);

        $pedido->status = Sistema::getStatusPedidoSaida();

        $cancelado = $pedido->status[9];

        $pedido->status = $pedido->status[0];

        $pedido->produtos = array();

        $pp1 = new ProdutoPedidoSaida();
        $pp1->produto = $produto;
        $pp1->validade_minima = $produto->getLotes(new ConnectionFactory());
        $pp1->validade_minima = $pp1->validade_minima[0]->validade;
        $pp1->quantidade = 65;
        $pp1->valor_base = 10;
        $pp1->pedido = $pedido;

        $pedido->produtos[] = $pp1;


        $pp2 = new ProdutoPedidoSaida();
        $pp2->produto = $produto2;
        $pp2->validade_minima = $produto2->getLotes(new ConnectionFactory());
        $pp2->validade_minima = $pp2->validade_minima[0]->validade;
        $pp2->quantidade = 20;
        $pp2->valor_base = 100;
        $pp2->pedido = $pedido;

        $pedido->produtos[] = $pp2;

        $pp3 = new ProdutoPedidoSaida();
        $pp3->produto = $produto;
        $pp3->validade_minima = $produto->getLotes(new ConnectionFactory());
        $pp3->validade_minima = $pp3->validade_minima[0]->validade;
        $pp3->quantidade = 21;
        $pp3->valor_base = 150;
        $pp3->pedido = $pedido;

        $pedido->produtos[] = $pp3;

        $pp4 = new ProdutoPedidoSaida();
        $pp4->produto = $produto3;
        $pp4->validade_minima = $produto3->getLotes(new ConnectionFactory());
        $pp4->validade_minima = $pp4->validade_minima[0]->validade;
        $pp4->quantidade = 56;
        $pp4->valor_base = 11;
        $pp4->pedido = $pedido;

        $pedido->produtos[] = $pp4;

        $categoria->icms_normal = false;
        $categoria->icms = 0;

        $pedido->atualizarCustos();

        try {

            $pedido->merge(new ConnectionFactory());
        } catch (Exception $e) {
            
        }

        return $pedido;
    }

    public static function getPedidoEntradaTeste($empresa) {

        $e1 = new Endereco();

        $e1->rua = "Rua Teste";
        $e1->bairro = "Bairro Teste";
        $e1->numero = 0;
        $e1->cep = new CEP("07195201");
        $e1->cidade = Sistema::getCidades(new ConnectionFactory());
        $e1->cidade = $e1->cidade[0];


        $e2 = new Endereco();

        $e2->rua = "Rua Teste";
        $e2->bairro = "Bairro Teste";
        $e2->numero = 0;
        $e2->cep = new CEP("07195201");
        $e2->cidade = Sistema::getCidades(new ConnectionFactory());
        $e2->cidade = $e2->cidade[400];


        $e3 = new Endereco();

        $e3->rua = "Rua Teste";
        $e3->bairro = "Bairro Teste";
        $e3->numero = 0;
        $e3->cep = new CEP("07195201");
        $e3->cidade = Sistema::getCidades(new ConnectionFactory());
        $e3->cidade = $e3->cidade[100];

        $e4 = new Endereco();

        $e4->rua = "Rua Teste";
        $e4->bairro = "Bairro Teste";
        $e4->numero = 0;
        $e4->cep = new CEP("07195201");
        $e4->cidade = Sistema::getCidades(new ConnectionFactory());
        $e4->cidade = $e4->cidade[51];

        // criando categorias de produto

        $categoria = new CategoriaProduto();
        $categoria->id = 0;
        $categoria->ipi = 0;
        $categoria->base_calculo = 40;
        $categoria->icms = 0;
        $categoria->icms_normal = true;
        $categoria->merge(new ConnectionFactory());

        // criando produtos

        $produto = new Produto();

        $produto->nome = "teste";
        $produto->id_universal = 12;
        $produto->categoria = $categoria;
        $produto->liquido = false;
        $produto->unidade = "Galao";
        $produto->quantidade_unidade = 0.25;
        $produto->empresa = $empresa;
        $produto->valor_base = 100;
        $produto->custo = 123;
        $produto->ncm = "12341234";
        $produto->peso_liquido = 12;
        $produto->peso_bruto = 23;
        $produto->estoque = 85;
        $produto->disponivel = 85;
        $produto->transito = 0;
        $produto->grade = new Grade("15,2,1");

        $produto->merge(new ConnectionFactory());
        $produto->merge(new ConnectionFactory());

        $lote = new Lote();

        $lote->quantidade_inicial = 40;
        $lote->quantidade_real = 40;
        $lote->grade = $produto->grade;
        $lote->produto = $produto;
        $lote->codigo_fabricante = "1234";

        $lote->merge(new ConnectionFactory());

        $lote2 = new Lote();

        $lote2->quantidade_inicial = 45;
        $lote2->quantidade_real = 45;
        $lote2->grade = $produto->grade;
        $lote2->produto = $produto;
        $lote2->codigo_fabricante = "1234";

        $lote2->merge(new ConnectionFactory());

        $lote3 = new Lote();

        $lote3->quantidade_inicial = 0;
        $lote3->quantidade_real = 0;
        $lote3->grade = $produto->grade;
        $lote3->produto = $produto;
        $lote3->codigo_fabricante = "1234";

        $lote3->merge(new ConnectionFactory());

        $lote4 = new Lote();

        $lote4->quantidade_inicial = 100;
        $lote4->quantidade_real = 100;
        $lote4->validade = round(microtime(true) * 1000) + (60 * 24 * 60 * 60 * 1000);
        $lote4->grade = $produto->grade;
        $lote4->produto = $produto;
        $lote4->codigo_fabricante = "1234";

        $lote4->merge(new ConnectionFactory());

        $produto2 = new Produto();

        $produto2->nome = "teste";
        $produto2->id_universal = 12;
        $produto2->categoria = $categoria;
        $produto2->liquido = false;
        $produto2->unidade = "Galao";
        $produto2->quantidade_unidade = 0.25;
        $produto2->empresa = $empresa;
        $produto2->valor_base = 15;
        $produto2->custo = 123;
        $produto2->ncm = "12341234";
        $produto2->peso_liquido = 12;
        $produto2->peso_bruto = 23;
        $produto2->estoque = 80;
        $produto2->disponivel = 80;
        $produto2->transito = 0;
        $produto2->grade = new Grade("15,2,1");

        $produto2->merge(new ConnectionFactory());

        $lote = new Lote();

        $lote->quantidade_inicial = 30;
        $lote->quantidade_real = 30;
        $lote->grade = $produto2->grade;
        $lote->produto = $produto2;
        $lote->codigo_fabricante = "1234";

        $lote->merge(new ConnectionFactory());

        $lote2 = new Lote();

        $lote2->quantidade_inicial = 50;
        $lote2->quantidade_real = 50;
        $lote2->grade = $produto2->grade;
        $lote2->produto = $produto2;
        $lote2->codigo_fabricante = "1234";

        $lote2->merge(new ConnectionFactory());

        $produto3 = new Produto();

        $produto3->nome = "teste";
        $produto3->id_universal = 12;
        $produto3->categoria = $categoria;
        $produto3->liquido = false;
        $produto3->unidade = "Galao";
        $produto3->quantidade_unidade = 0.25;
        $produto3->empresa = $empresa;
        $produto3->valor_base = 10;
        $produto3->custo = 123;
        $produto3->ncm = "12341234";
        $produto3->peso_liquido = 12;
        $produto3->peso_bruto = 23;
        $produto3->estoque = 80;
        $produto3->disponivel = 80;
        $produto3->transito = 0;
        $produto3->grade = new Grade("40,10,2");

        $produto3->merge(new ConnectionFactory());

        $lote = new Lote();

        $lote->quantidade_inicial = 80;
        $lote->quantidade_real = 80;
        $lote->grade = $produto3->grade;
        $lote->produto = $produto3;
        $lote->codigo_fabricante = "1234";

        $lote->merge(new ConnectionFactory());

        //criando cliente

        $fornecedor = new Fornecedor();

        $fornecedor->nome = "Teste";
        $fornecedor->telefone = "111111";
        $fornecedor->cnpj = new CNPJ("11122233344455");
        $fornecedor->empresa = $empresa;
        $fornecedor->email = new Email("renan.miranda@agrofauna.com.br");
        $fornecedor->endereco = $e4;
        $fornecedor->merge(new ConnectionFactory());

        //-----------------------

        $tra = Utilidades::getTransportadoraTeste($empresa);

        //------ criando cotacao;

        $pedido = new PedidoEntrada();
        $pedido->fornecedor = $fornecedor;
        $pedido->incluir_frete = true;
        $pedido->frete = 10;
        $pedido->prazo = 20;
        $pedido->usuario = Utilidades::getUsuarioTeste($empresa);
        $pedido->empresa = $empresa;
        $pedido->status = Sistema::getStatusPedidoEntrada();
        $pedido->transportadora = $tra;
        $cancelado = $pedido->status[3];

        $finalizado = $pedido->status[2];

        $pedido->status = $pedido->status[1];

        $pedido->produtos = array();

        $pp1 = new ProdutoPedidoEntrada();
        $pp1->produto = $produto;
        $pp1->quantidade = 65;
        $pp1->valor = 10;
        $pp1->pedido = $pedido;

        $pedido->produtos[] = $pp1;


        $pp2 = new ProdutoPedidoEntrada();
        $pp2->produto = $produto2;
        $pp2->quantidade = 20;
        $pp2->valor = 100;
        $pp2->pedido = $pedido;

        $pedido->produtos[] = $pp2;

        $pp3 = new ProdutoPedidoEntrada();
        $pp3->produto = $produto;
        $pp3->quantidade = 21;
        $pp3->valor = 150;
        $pp3->pedido = $pedido;

        $pedido->produtos[] = $pp3;

        $pp4 = new ProdutoPedidoEntrada();
        $pp4->produto = $produto3;
        $pp4->quantidade = 56;
        $pp4->valor = 11;
        $pp4->pedido = $pedido;

        $pedido->produtos[] = $pp4;

        //produto1 85 --> 45 e 40 | 65 + 21(3), produto2 80 --> 50 e 30 | 20, produto3 80 --> 80 | 56

        $pedido->merge(new ConnectionFactory());

        return $pedido;
    }

    public static function getClienteTeste($empresa) {

        $doc = new Documento();

        $doc->categoria = Sistema::getCategoriaDocumentos();
        $doc->categoria = $doc->categoria[0];

        $doc->numero = "erfqwerewq";

        $doc->link = "dfdwerferwfffffff";


        $doc2 = new Documento();

        $doc2->categoria = Sistema::getCategoriaDocumentos();
        $doc2->categoria = $doc2->categoria[1];

        $doc2->numero = "12344321";

        $doc2->link = "12344321";

        $cat = new CategoriaCliente();

        $cat->nome = "Teste";

        $cat->merge(new ConnectionFactory());

        $cliente = new Cliente();
        $cliente->razao_social = "T1";
        $cliente->nome_fantasia = "T2";
        $cliente->limite_credito = 100;
        $cliente->pessoa_fisica = true;
        $cliente->cpf = new CPF("11111111111");
        $cliente->rg = new RG("111111111");
        $cliente->categoria = $cat;
        $cliente->empresa = $empresa;
        $cliente->email = new Email("renan_goncalves@outlook.com.br");

        $cliente->telefones[] = new Telefone("1234412");
        $cliente->telefones[] = new Telefone("2232233");
        $cliente->inscricao_estadual = "333333333";
        $cliente->suframado = false;
        $cliente->inscricao_suframa = "444444444";

        $e = new Endereco();

        $e->rua = "Rua Teste";
        $e->bairro = "Bairro Teste";
        $e->numero = 0;
        $e->cep = new CEP("07195201");
        $e->cidade = Sistema::getCidades(new ConnectionFactory());
        $e->cidade = $e->cidade[0];

        $cliente->endereco = $e;

        $cliente->merge(new ConnectionFactory());

        unset($cliente->telefones[0]);

        $cliente->merge(new ConnectionFactory());

        $cliente->setDocumentos(array($doc, $doc2), new ConnectionFactory());

        return $cliente;
    }

    public static function getLogisticaTeste() {

        $empresa = new Logistica();

        $empresa->nome = "Logistic Center Gru";
        $empresa->cnpj = new CNPJ("11122233344455");
        $empresa->inscricao_estadual = "1234412";
        $empresa->juros_mensal = 1.5;

        $e1 = new Endereco();

        $e1->rua = "Rua Teste";
        $e1->bairro = "Bairro Teste";
        $e1->numero = 0;
        $e1->cep = new CEP("07195201");
        $e1->cidade = Sistema::getCidades(new ConnectionFactory());
        $e1->cidade = $e1->cidade[0];

        $empresa->endereco = $e1;

        $empresa->email = new Email("teserewfdwefd");

        $empresa->telefone = new Telefone("t1241243");


        $empresa->merge(new ConnectionFactory());

        return $empresa;
    }

    public static function getEmpresaTeste() {

        $empresa = new Empresa();

        $empresa->nome = "Teste";
        $empresa->cnpj = new CNPJ("11122233344455");
        $empresa->inscricao_estadual = "1234412";
        $empresa->juros_mensal = 1.5;

        $e1 = new Endereco();

        $e1->rua = "Rua Teste";
        $e1->bairro = "Bairro Teste";
        $e1->numero = 0;
        $e1->cep = new CEP("07195201");
        $e1->cidade = Sistema::getCidades(new ConnectionFactory());
        $e1->cidade = $e1->cidade[0];

        $empresa->endereco = $e1;

        $empresa->email = new Email("teserewfdwefd");

        $empresa->telefone = new Telefone("t1241243");


        $empresa->merge(new ConnectionFactory());

        return $empresa;
    }

    public static function getFornecedorTeste($empresa) {

        $con = new ConnectionFactory();

        $fornecedor = new Fornecedor();

        $fornecedor->nome = "Teste";
        $fornecedor->telefones[] = new Telefone("111111");
        $fornecedor->cnpj = new CNPJ("11122233344455");
        $fornecedor->empresa = $empresa;

        $e = new Endereco();

        $e->rua = "Rua Teste";
        $e->bairro = "Bairro Teste";
        $e->numero = 0;
        $e->cep = new CEP("07195201");
        $e->cidade = Sistema::getCidades($con);
        $e->cidade = $e->cidade[0];

        $fornecedor->endereco = $e;

        $fornecedor->email = new Email("teserewfdwefd");


        $fornecedor->merge(new ConnectionFactory());

        return $fornecedor;
    }

    public static function base64encode($val) {

        $chrArr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";

        $res = "";

        for ($i = 0; $i < strlen($val); $i += 3) {
            $k = 0;

            $u = 0;
            for (; $u < 3 && ($i + $u) < strlen($val); $u++)
                $k = $k << 8 | ord($val{$i + $u});
            for ($a = $u; $a < 3; $a++)
                $k = $k << 8;

            for ($j = 0; $j < 4; $j++) {
                if ($j > $u) {
                    $res .= "=";
                } else {
                    $res .= $chrArr{((($k >> ((3 - $j) * 6)) & 63))};
                }
            }
        }

        return $res;
    }

    public static function base64decode($val) {

        $chrArr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";

        for ($i = 0; $i < strlen($chrArr); $i++) {
            $invMap[$chrArr{$i}] = $i;
        }

        $res = "";

        for ($i = 0; $i < strlen($val); $i += 4) {
            $k = 0;

            $x = 0;
            for ($u = 0; $u < 4 && ($i + $u) < strlen($val); $u++) {

                if ($val{$i + $u} != '=') {
                    if (!isset($invMap[$val{$i + $u}])) {
                        return "";
                    }
                    $k = $k << 6 | $invMap[$val{$i + $u}];
                    $x += 6;
                } else {
                    $k = $k << 6;
                }
            }

            for ($j = 0; $j < 3 && $x >= 8; $j++, $x -= 8) {
                $res .= chr(($k >> (2 - $j) * 8) & 255);
            }
        }

        return $res;
    }

    public static function hexToDecimal($k) {

        $dec = 0;

        $n = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
        $a = array();
        foreach ($n as $key => $value) {
            $a[$value] = $key;
        }

        for ($i = 0; $i < strlen($k); $i++) {

            $dec *= count($n);
            $dec += $n[$k{$i}];
        }

        return $dec;
    }

    public static function decimalToHex($k, $s = 2) {

        $hex = "";

        $n = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");


        $hi = "";

        while ($k > 0 || $s > 0) {

            $hi = $n[$k % 16] . $hi;

            $k = ($k - $k % 16) / 16;

            $s--;
        }

        $hex .= $hi;


        return $hex;
    }

    public static function toHex($str) {

        $hex = "";

        $n = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");

        for ($i = 0; $i < strlen($str); $i++) {

            $k = ord($str{$i});

            $hi = "";

            while ($k > 0) {

                $hi = $n[$k % 16] . $hi;

                $k = ($k - $k % 16) / 16;
            }

            $hex .= $hi;
        }

        return $hex;
    }

}
