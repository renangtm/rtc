<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of testeConnectionFactory
 *
 * @author Renan
 */
include('includes.php');

class testeEmpresa extends PHPUnit_Framework_TestCase {

    public function testSimple() {

        $con = new ConnectionFactory();
        /*
          $empresa = new Empresa();

          $empresa->nome = "Teste";
          $empresa->cnpj = new CNPJ("11122233344455");
          $empresa->inscricao_estadual = "1234412";

          $e = new Endereco();

          $e->rua = "Rua Teste";
          $e->bairro = "Bairro Teste";
          $e->numero = 0;
          $e->cep = new CEP("07195201");
          $e->cidade = new stdClass();
          $e->cidade->id = 3;

          $empresa->endereco = $e;

          $empresa->email = new Email("teserewfdwefd");

          $empresa->telefone = new Telefone("t1241243");


          $empresa->merge(new ConnectionFactory());

          $empresa->merge(new ConnectionFactory());


          $empresa2 = new Empresa();

          $empresa2->nome = "Teste";
          $empresa2->cnpj = new CNPJ("11122233344455");
          $empresa2->inscricao_estadual = "1234412";

          $e = new Endereco();

          $e->rua = "Rua Teste";
          $e->bairro = "Bairro Teste";
          $e->numero = 0;
          $e->cep = new CEP("07195201");
          $e->cidade = new stdClass();
          $e->cidade->id = 3;

          $empresa2->endereco = $e;

          $empresa2->email = new Email("teserewfdwefd");

          $empresa2->telefone = new Telefone("t1241243");

          $empresa2->merge(new ConnectionFactory());

          $empresa2->merge(new ConnectionFactory());

          $empresa3 = new Empresa();

          $empresa3->nome = "Teste";
          $empresa3->cnpj = new CNPJ("11122233344455");
          $empresa3->inscricao_estadual = "1234412";

          $e = new Endereco();

          $e->rua = "Rua Teste";
          $e->bairro = "Bairro Teste";
          $e->numero = 0;
          $e->cep = new CEP("07195201");
          $e->cidade = new stdClass();
          $e->cidade->id = 3;

          $empresa3->endereco = $e;

          $empresa3->email = new Email("teserewfdwefd");

          $empresa3->telefone = new Telefone("t1241243");

          $empresa3->merge(new ConnectionFactory());

          $empresa3->merge(new ConnectionFactory());

          Sistema::relacionarFilial($empresa, $empresa2);
          Sistema::relacionarFilial($empresa2, $empresa3);

          $filiais = $empresa->getFiliais(new ConnectionFactory());

          $this->assertEquals(count($filiais),2);

          $this->assertEquals($filiais[0]->id, $empresa2->id);
          $this->assertEquals($filiais[1]->id, $empresa3->id);

          $filiais = $empresa2->getFiliais(new ConnectionFactory());

          $this->assertEquals(count($filiais),2);

          $this->assertEquals($filiais[0]->id, $empresa->id);
          $this->assertEquals($filiais[1]->id, $empresa3->id);

          $filiais = $empresa3->getFiliais(new ConnectionFactory());

          $this->assertEquals(count($filiais),2);

          $this->assertEquals($filiais[0]->id, $empresa->id);
          $this->assertEquals($filiais[1]->id, $empresa2->id);

          $banco = new Banco();
          $banco->codigo = "123";
          $banco->conta = "123423";
          $banco->empresa = $empresa;
          $banco->nome = "Teste";
          $banco->saldo = 1234;

          $banco->merge($con);

          $banco2 = new Banco();
          $banco2->codigo = "321";
          $banco2->conta = "321321";
          $banco2->empresa = $empresa;
          $banco2->nome = "Teste321";
          $banco2->saldo = 4321;

          $banco2->merge($con);

          $bancos = $empresa->getBancos($con);

          $this->assertEquals(count($bancos),2);

          $this->assertEquals($bancos[0]->id,$banco->id);
          $this->assertEquals($bancos[1]->id,$banco2->id);


          $empresa = Utilidades::getEmpresaTeste();

          $pedido1 = Utilidades::getPedidoTeste($empresa);
          $pedido2 = Utilidades::getPedidoTeste($empresa);
          $pedido3 = Utilidades::getPedidoTeste($empresa);


          $pedidos = $empresa->getPedidos($con, 0, 2);

          $this->assertEquals($pedido1->id,$pedidos[0]->id);
          $this->assertEquals($pedido2->id,$pedidos[1]->id);

          $pedidos = $empresa->getPedidos($con, 2, 3);

          $this->assertEquals($pedido3->id,$pedidos[0]->id);

          echo "    ".Utilidades::toJson($pedidos);

          $this->assertEquals($empresa->getCountPedidos($con),3);



          $empresa = Utilidades::getEmpresaTeste();

          $campanha1 = Utilidades::getCampanhaTeste($empresa);
          $campanha2 = Utilidades::getCampanhaTeste($empresa);

          $campanhas = $empresa->getCampanhas($con, 0, 2);

          echo Utilidades::toJson($campanhas);

          $this->assertEquals($campanhas[0]->id,$campanha1->id);
          $this->assertEquals($campanhas[1]->id,$campanha2->id);

          $this->assertEquals($empresa->getCountCampanha($con),2);



          $empresa = Utilidades::getEmpresaTeste();

          $grupo1 = Utilidades::getGrupoCidadesTeste($empresa);
          $grupo2 = Utilidades::getGrupoCidadesTeste($empresa);
          $grupo3 = Utilidades::getGrupoCidadesTeste($empresa);

          $grupos = $empresa->getGruposCidades($con, 0, 2);

          $this->assertEquals($grupo1->id,$grupos[0]->id);
          $this->assertEquals($grupo2->id,$grupos[1]->id);

          $grupos = $empresa->getGruposCidades($con, 2, 3);

          $this->assertEquals($grupo3->id,$grupos[0]->id);

          $this->assertEquals($empresa->getCountGruposCidades($con),3);



          $empresa = Utilidades::getEmpresaTeste();

          $nota = Utilidades::getNotaTeste($empresa);

          $vencimento = Utilidades::getVencimentoTeste($nota);

          echo Utilidades::toJson($vencimento);



          $movimento = Utilidades::getMovimentoTeste($vencimento);

          $vencimento = Utilidades::getVencimentoTeste($nota);

          $movimento = Utilidades::getMovimentoTeste($vencimento);

          $nota = Utilidades::getNotaTeste($empresa);

          $vencimento = Utilidades::getVencimentoTeste($nota);

          $movimento = Utilidades::getMovimentoTeste($vencimento);

          $movimentos = $empresa->getMovimentos($con, 0, 3);

          $this->assertEquals($movimentos[2]->id,$movimento->id);

          $this->assertEquals($empresa->getCountMovimentos($con),3);

          $notas = $empresa->getNotas($con, 0, 2);

          $this->assertEquals($notas[1]->id,$nota->id);

          $this->assertEquals($empresa->getCountNotas($con),2);



          $empresa = Utilidades::getEmpresaTeste();

          $fornecedor = Utilidades::getFornecedorTeste($empresa);
          $fornecedor = Utilidades::getFornecedorTeste($empresa);
          $fornecedor = Utilidades::getFornecedorTeste($empresa);
          $fornecedor = Utilidades::getFornecedorTeste($empresa);
          $fornecedor = Utilidades::getFornecedorTeste($empresa);
          $fornecedor = Utilidades::getFornecedorTeste($empresa);

          $fornecedores = $empresa->getFornecedores($con, 0, 2);

          $this->assertEquals(count($fornecedores),2);

          $fornecedores = $empresa->getFornecedores($con, 2, 4);

          $this->assertEquals(count($fornecedores),2);

          $fornecedores = $empresa->getFornecedores($con, 4, 6);

          $this->assertEquals(count($fornecedores),2);

          $this->assertEquals($fornecedor->id,$fornecedores[1]->id);

          $this->assertEquals($empresa->getCountFornecedores($con),6);



          $empresa = Utilidades::getEmpresaTeste();

          $cotacao = Utilidades::getCotacaoEntradaTeste($empresa);
          $cotacao = Utilidades::getCotacaoEntradaTeste($empresa);
          $cotacao = Utilidades::getCotacaoEntradaTeste($empresa);
          $cotacao = Utilidades::getCotacaoEntradaTeste($empresa);
          $cotacao = Utilidades::getCotacaoEntradaTeste($empresa);

          $cotacoes = $empresa->getCotacoesEntrada($con, 0, 2);

          $this->assertEquals(count($cotacoes),2);

          $cotacoes = $empresa->getCotacoesEntrada($con, 2, 4);

          $this->assertEquals(count($cotacoes),2);

          $cotacoes = $empresa->getCotacoesEntrada($con, 4, 6);

          $this->assertEquals(count($cotacoes),1);

          $this->assertEquals($cotacoes[0]->id,$cotacao->id);

          $this->assertEquals($empresa->getCountCotacoesEntrada($con),5);


          $empresa = Utilidades::getEmpresaTeste();

          $produto = Utilidades::getProdutoTeste($empresa);

          Utilidades::getCampanhaTeste($empresa, $produto);

          $produto = Utilidades::getProdutoTeste($empresa);
          $produto = Utilidades::getProdutoTeste($empresa);
          $produto = Utilidades::getProdutoTeste($empresa);
          $produto = Utilidades::getProdutoTeste($empresa);

          $produtos = $empresa->getProdutos($con, 0, 2);

          $this->assertEquals(count($produtos),2);

          $produtos = $empresa->getProdutos($con, 2, 4);

          $this->assertEquals(count($produtos),2);

          $produtos = $empresa->getProdutos($con, 4, 6);

          $this->assertEquals(count($produtos),2);

          $this->assertEquals($produtos[1]->id,$produto->id);

          $this->assertEquals($empresa->getCountProdutos($con),6);




          $empresa = Utilidades::getEmpresaTeste();

          $r = Utilidades::getReceituarioTeste($empresa);
          $r = Utilidades::getReceituarioTeste($empresa);
          $r = Utilidades::getReceituarioTeste($empresa);
          $r = Utilidades::getReceituarioTeste($empresa);

          $recsg = $empresa->getReceituario($con, 0, 2,"","","cultura.id");

          echo Utilidades::toJson($recsg);


          $recs = $empresa->getReceituario($con, 2, 4);

          $this->assertEquals(count($recsg),1);

          $this->assertEquals(count($recs),2);

          $this->assertEquals($recs[1]->id, $r->id);

          $this->assertEquals($empresa->getCountReceituario($con),4);
          $this->assertEquals($empresa->getCountReceituario($con,"","produto.nome"),1);



          $empresa = Utilidades::getEmpresaTeste();

          $transportadora = Utilidades::getTransportadoraTeste($empresa);
          $transportadora = Utilidades::getTransportadoraTeste($empresa);
          $transportadora = Utilidades::getTransportadoraTeste($empresa);
          $transportadora = Utilidades::getTransportadoraTeste($empresa);
          $transportadora = Utilidades::getTransportadoraTeste($empresa);

          $transportadoras = $empresa->getTransportadoras($con, 0, 2);

          $this->assertEquals(count($transportadoras),2);

          $transportadoras = $empresa->getTransportadoras($con, 2, 4);

          $this->assertEquals(count($transportadoras),2);

          $transportadoras = $empresa->getTransportadoras($con,4, 6);

          $this->assertEquals(count($transportadoras),1);

          $this->assertEquals($transportadora->id,$transportadoras[0]->id);

          $this->assertEquals($empresa->getCountTransportadoras($con),5);




          $empresa = Utilidades::getEmpresaTeste();

          $cliente = Utilidades::getClienteTeste($empresa);
          $cliente = Utilidades::getClienteTeste($empresa);
          $cliente = Utilidades::getClienteTeste($empresa);
          $cliente = Utilidades::getClienteTeste($empresa);
          $cliente = Utilidades::getClienteTeste($empresa);

          $clientes = $empresa->getClientes($con, 0, 2);

          $this->assertEquals(count($clientes),2);

          $clientes = $empresa->getClientes($con, 2, 4);

          $this->assertEquals(count($clientes),2);

          $clientes = $empresa->getClientes($con, 4, 6);

          $this->assertEquals(count($clientes),1);

          $this->assertEquals($clientes[0]->id,$cliente->id);

          $this->assertEquals($empresa->getCountClientes($con),5);


          $empresa = Utilidades::getEmpresaTeste();

          $usuario = Utilidades::getUsuarioTeste($empresa);
          $usuario = Utilidades::getUsuarioTeste($empresa);
          $usuario = Utilidades::getUsuarioTeste($empresa);
          $usuario = Utilidades::getUsuarioTeste($empresa);
          $usuario = Utilidades::getUsuarioTeste($empresa);

          $usuarios = $empresa->getUsuarios($con, 0, 2);

          $this->assertEquals(count($usuarios),2);

          $usuarios = $empresa->getUsuarios($con, 2, 4);

          $this->assertEquals(count($usuarios),2);

          $usuarios = $empresa->getUsuarios($con, 4, 6);

          $this->assertEquals(count($usuarios),1);

          $this->assertEquals($usuarios[0]->id,$usuario->id);

          $this->assertEquals($empresa->getCountUsuarios($con),5);

          $empresa = Utilidades::getEmpresaTeste();

          $parametros = Utilidades::getParametrosEmissaoTeste($empresa);



          $empresa = Utilidades::getEmpresaTeste();

          $logo = Utilidades::getLogoTeste($empresa);
         */
        /*
          $empresa = Utilidades::getEmpresaTeste();

          $pedido = Utilidades::getPedidoTeste($empresa);

          $lotes = $empresa->getLotes($con, 0, 3);

          $qtd = $empresa->getCountLotes($con);

          echo $qtd;
         */
        /*
          $empresa = Utilidades::getEmpresaTeste();

          $pedido = Utilidades::getPedidoTeste($empresa);

          $pendentes = $empresa->getCadastroLotesPendentes($con);

          echo Utilidades::toJson($pendentes);
*/

        $teste = Utilidades::fromJson('[{"_classe":"PedidoEntrada","id":110,"fornecedor":{"_classe":"Fornecedor","id":245,"nome":"Teste","email":{"_classe":"Email","id":263095,"endereco":"renan.miranda@agrofauna.com.br","excluido":false,"senha":"","filtro":""},"telefones":[],"endereco":{"_classe":"Endereco","id":968,"rua":"0","bairro":"Bairro Teste","numero":"0","cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5619,"nome":"FELIZ DESERTO","excluida":false,"estado":{"_classe":"Estado","id":35,"sigla":"AL","excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluido":false,"empresa":{"_classe":"Empresa","id":58,"nome":"Teste","email":{"_classe":"Email","id":0,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":"","filtro":""},"telefone":{"_classe":"Telefone","id":0,"numero":"","excluido":false},"endereco":{"_classe":"Endereco","id":0,"rua":null,"bairro":null,"numero":null,"cep":{"_classe":"CEP","valor":"00000-000"},"cidade":{"_classe":"Cidade","id":0,"nome":null,"excluida":false,"estado":{"_classe":"Estado","id":0,"sigla":null,"excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":false,"aceitou_contrato":false,"juros_mensal":0,"inscricao_estadual":null,"is_logistica":false},"inscricao_estadual":"","habilitado":0},"frete":0,"status":{"_classe":"StatusPedidoEntrada","id":1,"nome":"Confirmacao de pedido","estoque":false,"transito":false,"envia_email":true},"excluido":false,"usuario":{"_classe":"Usuario","id":225,"nome":"Teste","email":{"_classe":"Email","id":263094,"endereco":"renan.miranda@agrofauna.com.br","excluido":false,"senha":"5hynespt","filtro":""},"telefones":[{"_classe":"Telefone","id":997,"numero":"1234","excluido":false}],"endereco":{"_classe":"Endereco","id":967,"rua":"0","bairro":"Bairro Teste","numero":"0","cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5568,"nome":"ACRELANDIA","excluida":false,"estado":{"_classe":"Estado","id":34,"sigla":"AC","excluido":false}}},"cpf":{"_classe":"CPF","valor":"000.000.000-00"},"excluido":false,"empresa":{"_classe":"Empresa","id":58,"nome":"Teste","email":{"_classe":"Email","id":0,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":"","filtro":""},"telefone":{"_classe":"Telefone","id":0,"numero":"","excluido":false},"endereco":{"_classe":"Endereco","id":0,"rua":null,"bairro":null,"numero":null,"cep":{"_classe":"CEP","valor":"00000-000"},"cidade":{"_classe":"Cidade","id":0,"nome":null,"excluida":false,"estado":{"_classe":"Estado","id":0,"sigla":null,"excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":false,"aceitou_contrato":false,"juros_mensal":0,"inscricao_estadual":null,"is_logistica":false},"login":"2","senha":"123456","permissoes":[{"_classe":"Permissao","id":1,"nome":"pedido_entrada","in":1,"del":1,"alt":1,"cons":1},{"_classe":"Permissao","id":2,"nome":"produto","in":1,"del":1,"alt":1,"cons":1},{"_classe":"Permissao","id":3,"nome":"cotacao","in":1,"del":1,"alt":1,"cons":1},{"_classe":"Permissao","id":4,"nome":"transportadora","in":1,"del":1,"alt":1,"cons":1},{"_classe":"Permissao","id":5,"nome":"cliente","in":1,"del":1,"alt":1,"cons":1},{"_classe":"Permissao","id":7,"nome":"lote","in":1,"del":1,"alt":1,"cons":1},{"_classe":"Permissao","id":13,"nome":"pedido_saida","in":1,"del":1,"alt":1,"cons":1},{"_classe":"Permissao","id":17,"nome":"fonecedor","in":1,"del":1,"alt":1,"cons":1},{"_classe":"Permissao","id":18,"nome":"cfg","in":1,"del":1,"alt":1,"cons":1},{"_classe":"Permissao","id":19,"nome":"configuracao_empresa","in":1,"del":1,"alt":1,"cons":1}]},"transportadora":{"_classe":"Transportadora","id":65789,"razao_social":"T1","nome_fantasia":"T2","telefones":[{"_classe":"Telefone","id":998,"numero":"1234432","excluido":false}],"despacho":999,"empresa":{"_classe":"Empresa","id":58,"nome":"Teste","email":{"_classe":"Email","id":0,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":"","filtro":""},"telefone":{"_classe":"Telefone","id":0,"numero":"","excluido":false},"endereco":{"_classe":"Endereco","id":0,"rua":null,"bairro":null,"numero":null,"cep":{"_classe":"CEP","valor":"00000-000"},"cidade":{"_classe":"Cidade","id":0,"nome":null,"excluida":false,"estado":{"_classe":"Estado","id":0,"sigla":null,"excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":false,"aceitou_contrato":false,"juros_mensal":0,"inscricao_estadual":null,"is_logistica":false},"endereco":{"_classe":"Endereco","id":969,"rua":"Rua Teste","bairro":"Bairro Teste","numero":"0","cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5568,"nome":"ACRELANDIA","excluida":false,"estado":{"_classe":"Estado","id":34,"sigla":"AC","excluido":false}}},"email":{"_classe":"Email","id":263096,"endereco":"renan_goncalves@outlook.com.br","excluido":false,"senha":"","filtro":""},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"inscricao_estadual":"333333333","habilitada":true,"tabela":{"_classe":"Tabela","id":648,"nome":"teste unitario","regras":[{"_classe":"RegraTabela","id":1301,"condicional":"!valor>50&\'!cliente.cidade\'=\'TESTE\'","resultante":"!valor+!peso*5","interpretadorNumerico":{"_classe":"InterpretadorNumerico","replacer":null,"index":null,"funcoesNumericas":[{"_classe":"Max"},{"_classe":"Min"},{"_classe":"Baixo"},{"_classe":"Cima"}],"obj":null},"interpretadorBooleano":{"_classe":"InterpretadorBooleano","funcoes":[{"_classe":"GrupoCidadesExp"}],"leitorNumerico":{"_classe":"InterpretadorNumerico","replacer":null,"index":null,"funcoesNumericas":[{"_classe":"Max"},{"_classe":"Min"},{"_classe":"Baixo"},{"_classe":"Cima"}],"obj":null},"obj":null}},{"_classe":"RegraTabela","id":1302,"condicional":"!valor>40&!valor<50&\'!cliente.cidade\'=\'TESTE\'","resultante":"!valor+!peso*4","interpretadorNumerico":{"_classe":"InterpretadorNumerico","replacer":null,"index":null,"funcoesNumericas":[{"_classe":"Max"},{"_classe":"Min"},{"_classe":"Baixo"},{"_classe":"Cima"}],"obj":null},"interpretadorBooleano":{"_classe":"InterpretadorBooleano","funcoes":[{"_classe":"GrupoCidadesExp"}],"leitorNumerico":{"_classe":"InterpretadorNumerico","replacer":null,"index":null,"funcoesNumericas":[{"_classe":"Max"},{"_classe":"Min"},{"_classe":"Baixo"},{"_classe":"Cima"}],"obj":null},"obj":null}}],"excluida":false}},"data":"1550026629000","produtos":[{"_classe":"ProdutoPedidoEntrada","id":427,"produto":{"_classe":"Produto","id":459570,"id_universal":12,"nome":"teste","categoria":{"_classe":"CategoriaProduto","id":1067,"nome":"","excluida":false,"base_calculo":40,"ipi":0,"icms_normal":1,"icms":0},"liquido":0,"unidade":"Galao","quantidade_unidade":0.25,"excluido":false,"habilitado":1,"empresa":{"_classe":"Empresa","id":58,"nome":"Teste","email":{"_classe":"Email","id":263093,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":"","filtro":""},"telefone":{"_classe":"Telefone","id":996,"numero":"t1241243","excluido":false},"endereco":{"_classe":"Endereco","id":966,"rua":"Rua Teste","bairro":"Bairro Teste","numero":"0","cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5568,"nome":"ACRELANDIA","excluida":false,"estado":{"_classe":"Estado","id":34,"sigla":"AC","excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":0,"aceitou_contrato":0,"juros_mensal":2,"inscricao_estadual":"1234412","is_logistica":false},"valor_base":15,"lucro_consignado":0,"custo":123,"ncm":"12341234","peso_liquido":12,"peso_bruto":23,"estoque":80,"ativo":"teste","concentracao":"","disponivel":80,"transito":0,"ofertas":[],"grade":{"_classe":"Grade","gr":[15,2,1],"str":"15,2,1"},"imagem":"","fabricante":"et","classe_risco":0,"logistica":{"_classe":"Logistica","id":59,"nome":"Logistic Center Gru","email":{"_classe":"Email","id":263114,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":"","filtro":""},"telefone":{"_classe":"Telefone","id":1021,"numero":"t1241243","excluido":false},"endereco":{"_classe":"Endereco","id":987,"rua":"Rua Teste","bairro":"Bairro Teste","numero":"0","cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5568,"nome":"ACRELANDIA","excluida":false,"estado":{"_classe":"Estado","id":34,"sigla":"AC","excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":0,"aceitou_contrato":0,"juros_mensal":2,"inscricao_estadual":"1234412","is_logistica":true}},"quantidade":1,"valor":31.22,"pedido":{"recursao":2},"influencia_estoque":0,"influencia_transito":0}],"incluir_frete":false,"nota":{"_classe":"Nota","id":0,"transportadora":{"_classe":"Transportadora","id":65789,"razao_social":"T1","nome_fantasia":"T2","telefones":[{"_classe":"Telefone","id":998,"numero":"1234432","excluido":false}],"despacho":999,"empresa":{"_classe":"Empresa","id":58,"nome":"Teste","email":{"_classe":"Email","id":0,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":"","filtro":""},"telefone":{"_classe":"Telefone","id":0,"numero":"","excluido":false},"endereco":{"_classe":"Endereco","id":0,"rua":null,"bairro":null,"numero":null,"cep":{"_classe":"CEP","valor":"00000-000"},"cidade":{"_classe":"Cidade","id":0,"nome":null,"excluida":false,"estado":{"_classe":"Estado","id":0,"sigla":null,"excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":false,"aceitou_contrato":false,"juros_mensal":0,"inscricao_estadual":null,"is_logistica":false},"endereco":{"_classe":"Endereco","id":969,"rua":"Rua Teste","bairro":"Bairro Teste","numero":"0","cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5568,"nome":"ACRELANDIA","excluida":false,"estado":{"_classe":"Estado","id":34,"sigla":"AC","excluido":false}}},"email":{"_classe":"Email","id":263096,"endereco":"renan_goncalves@outlook.com.br","excluido":false,"senha":"","filtro":""},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"inscricao_estadual":"333333333","habilitada":true,"tabela":{"_classe":"Tabela","id":648,"nome":"teste unitario","regras":[{"_classe":"RegraTabela","id":1301,"condicional":"!valor>50&\'!cliente.cidade\'=\'TESTE\'","resultante":"!valor+!peso*5","interpretadorNumerico":{"_classe":"InterpretadorNumerico","replacer":null,"index":null,"funcoesNumericas":[{"_classe":"Max"},{"_classe":"Min"},{"_classe":"Baixo"},{"_classe":"Cima"}],"obj":null},"interpretadorBooleano":{"_classe":"InterpretadorBooleano","funcoes":[{"_classe":"GrupoCidadesExp"}],"leitorNumerico":{"_classe":"InterpretadorNumerico","replacer":null,"index":null,"funcoesNumericas":[{"_classe":"Max"},{"_classe":"Min"},{"_classe":"Baixo"},{"_classe":"Cima"}],"obj":null},"obj":null}},{"_classe":"RegraTabela","id":1302,"condicional":"!valor>40&!valor<50&\'!cliente.cidade\'=\'TESTE\'","resultante":"!valor+!peso*4","interpretadorNumerico":{"_classe":"InterpretadorNumerico","replacer":null,"index":null,"funcoesNumericas":[{"_classe":"Max"},{"_classe":"Min"},{"_classe":"Baixo"},{"_classe":"Cima"}],"obj":null},"interpretadorBooleano":{"_classe":"InterpretadorBooleano","funcoes":[{"_classe":"GrupoCidadesExp"}],"leitorNumerico":{"_classe":"InterpretadorNumerico","replacer":null,"index":null,"funcoesNumericas":[{"_classe":"Max"},{"_classe":"Min"},{"_classe":"Baixo"},{"_classe":"Cima"}],"obj":null},"obj":null}}],"excluida":false}},"fornecedor":{"_classe":"Fornecedor","id":245,"nome":"Teste","email":{"_classe":"Email","id":263095,"endereco":"renan.miranda@agrofauna.com.br","excluido":false,"senha":"","filtro":""},"telefones":[],"endereco":{"_classe":"Endereco","id":968,"rua":"0","bairro":"Bairro Teste","numero":"0","cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5619,"nome":"FELIZ DESERTO","excluida":false,"estado":{"_classe":"Estado","id":35,"sigla":"AL","excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluido":false,"empresa":{"_classe":"Empresa","id":58,"nome":"Teste","email":{"_classe":"Email","id":0,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":"","filtro":""},"telefone":{"_classe":"Telefone","id":0,"numero":"","excluido":false},"endereco":{"_classe":"Endereco","id":0,"rua":null,"bairro":null,"numero":null,"cep":{"_classe":"CEP","valor":"00000-000"},"cidade":{"_classe":"Cidade","id":0,"nome":null,"excluida":false,"estado":{"_classe":"Estado","id":0,"sigla":null,"excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":false,"aceitou_contrato":false,"juros_mensal":0,"inscricao_estadual":null,"is_logistica":false},"inscricao_estadual":"","habilitado":0},"cliente":null,"saida":false,"empresa":{"_classe":"Empresa","id":58,"nome":"Teste","email":{"_classe":"Email","id":0,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":"","filtro":""},"telefone":{"_classe":"Telefone","id":0,"numero":"","excluido":false},"endereco":{"_classe":"Endereco","id":0,"rua":null,"bairro":null,"numero":null,"cep":{"_classe":"CEP","valor":"00000-000"},"cidade":{"_classe":"Cidade","id":0,"nome":null,"excluida":false,"estado":{"_classe":"Estado","id":0,"sigla":null,"excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":false,"aceitou_contrato":false,"juros_mensal":0,"inscricao_estadual":null,"is_logistica":false},"data_emissao":1550030334981,"excluida":false,"interferir_estoque":false,"produtos":[{"_classe":"ProdutoNota","id":0,"produto":{"_classe":"Produto","id":459570,"id_universal":12,"nome":"teste","categoria":{"_classe":"CategoriaProduto","id":1067,"nome":"","excluida":false,"base_calculo":40,"ipi":0,"icms_normal":1,"icms":0},"liquido":0,"unidade":"Galao","quantidade_unidade":0.25,"excluido":false,"habilitado":1,"empresa":{"_classe":"Empresa","id":58,"nome":"Teste","email":{"_classe":"Email","id":263093,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":"","filtro":""},"telefone":{"_classe":"Telefone","id":996,"numero":"t1241243","excluido":false},"endereco":{"_classe":"Endereco","id":966,"rua":"Rua Teste","bairro":"Bairro Teste","numero":"0","cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5568,"nome":"ACRELANDIA","excluida":false,"estado":{"_classe":"Estado","id":34,"sigla":"AC","excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":0,"aceitou_contrato":0,"juros_mensal":2,"inscricao_estadual":"1234412","is_logistica":false},"valor_base":15,"lucro_consignado":0,"custo":123,"ncm":"12341234","peso_liquido":12,"peso_bruto":23,"estoque":80,"ativo":"teste","concentracao":"","disponivel":80,"transito":0,"ofertas":[],"grade":{"_classe":"Grade","gr":[15,2,1],"str":"15,2,1"},"imagem":"","fabricante":"et","classe_risco":0,"logistica":{"_classe":"Logistica","id":59,"nome":"Logistic Center Gru","email":{"_classe":"Email","id":263114,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":"","filtro":""},"telefone":{"_classe":"Telefone","id":1021,"numero":"t1241243","excluido":false},"endereco":{"_classe":"Endereco","id":987,"rua":"Rua Teste","bairro":"Bairro Teste","numero":"0","cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5568,"nome":"ACRELANDIA","excluida":false,"estado":{"_classe":"Estado","id":34,"sigla":"AC","excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":0,"aceitou_contrato":0,"juros_mensal":2,"inscricao_estadual":"1234412","is_logistica":true}},"quantidade":1,"nota":{"recursao":2},"valor_total":31.22,"cfop":"5152","valor_unitario":31.22,"base_calculo":0,"icms":0,"ipi":0,"influencia_estoque":0,"informacao_adicional":null}],"observacao":null,"vencimentos":[{"_classe":"Vencimento","id":0,"valor":31.22,"data":1551999600000,"nota":{"recursao":2},"movimento":null}],"frete_destinatario_remetente":false,"forma_pagamento":{"_classe":"DepositoEmConta","id":1,"nome":"Deposito em conta"},"emitida":false,"xml":null,"danfe":null,"chave":"35190247626510000132550010000256281934006914","numero":"25628","ficha":0,"cancelada":false,"protocolo":null},"observacoes":"","prazo":0,"parcelas":1,"empresa":{"_classe":"Empresa","id":58,"nome":"Teste","email":{"_classe":"Email","id":0,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":"","filtro":""},"telefone":{"_classe":"Telefone","id":0,"numero":"","excluido":false},"endereco":{"_classe":"Endereco","id":0,"rua":null,"bairro":null,"numero":null,"cep":{"_classe":"CEP","valor":"00000-000"},"cidade":{"_classe":"Cidade","id":0,"nome":null,"excluida":false,"estado":{"_classe":"Estado","id":0,"sigla":null,"excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":false,"aceitou_contrato":false,"juros_mensal":0,"inscricao_estadual":null,"is_logistica":false},"frete_incluso":0,"notas_logisticas":[{"_classe":"Nota","id":0,"transportadora":{"_classe":"Transportadora","id":65789,"razao_social":"T1","nome_fantasia":"T2","telefones":[{"_classe":"Telefone","id":998,"numero":"1234432","excluido":false}],"despacho":999,"empresa":{"_classe":"Empresa","id":58,"nome":"Teste","email":{"_classe":"Email","id":0,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":"","filtro":""},"telefone":{"_classe":"Telefone","id":0,"numero":"","excluido":false},"endereco":{"_classe":"Endereco","id":0,"rua":null,"bairro":null,"numero":null,"cep":{"_classe":"CEP","valor":"00000-000"},"cidade":{"_classe":"Cidade","id":0,"nome":null,"excluida":false,"estado":{"_classe":"Estado","id":0,"sigla":null,"excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":false,"aceitou_contrato":false,"juros_mensal":0,"inscricao_estadual":null,"is_logistica":false},"endereco":{"_classe":"Endereco","id":969,"rua":"Rua Teste","bairro":"Bairro Teste","numero":"0","cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5568,"nome":"ACRELANDIA","excluida":false,"estado":{"_classe":"Estado","id":34,"sigla":"AC","excluido":false}}},"email":{"_classe":"Email","id":263096,"endereco":"renan_goncalves@outlook.com.br","excluido":false,"senha":"","filtro":""},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"inscricao_estadual":"333333333","habilitada":true,"tabela":{"_classe":"Tabela","id":648,"nome":"teste unitario","regras":[{"_classe":"RegraTabela","id":1301,"condicional":"!valor>50&\'!cliente.cidade\'=\'TESTE\'","resultante":"!valor+!peso*5","interpretadorNumerico":{"_classe":"InterpretadorNumerico","replacer":null,"index":null,"funcoesNumericas":[{"_classe":"Max"},{"_classe":"Min"},{"_classe":"Baixo"},{"_classe":"Cima"}],"obj":null},"interpretadorBooleano":{"_classe":"InterpretadorBooleano","funcoes":[{"_classe":"GrupoCidadesExp"}],"leitorNumerico":{"_classe":"InterpretadorNumerico","replacer":null,"index":null,"funcoesNumericas":[{"_classe":"Max"},{"_classe":"Min"},{"_classe":"Baixo"},{"_classe":"Cima"}],"obj":null},"obj":null}},{"_classe":"RegraTabela","id":1302,"condicional":"!valor>40&!valor<50&\'!cliente.cidade\'=\'TESTE\'","resultante":"!valor+!peso*4","interpretadorNumerico":{"_classe":"InterpretadorNumerico","replacer":null,"index":null,"funcoesNumericas":[{"_classe":"Max"},{"_classe":"Min"},{"_classe":"Baixo"},{"_classe":"Cima"}],"obj":null},"interpretadorBooleano":{"_classe":"InterpretadorBooleano","funcoes":[{"_classe":"GrupoCidadesExp"}],"leitorNumerico":{"_classe":"InterpretadorNumerico","replacer":null,"index":null,"funcoesNumericas":[{"_classe":"Max"},{"_classe":"Min"},{"_classe":"Baixo"},{"_classe":"Cima"}],"obj":null},"obj":null}}],"excluida":false}},"fornecedor":null,"cliente":{"_classe":"Cliente","id":163,"razao_social":"Logistic Center Gru","nome_fantasia":"Logistic Center Gru","email":{"_classe":"Email","id":263128,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":"","filtro":""},"limite_credito":0,"termino_limite":"1550027028000","inicio_limite":"1550027028000","pessoa_fisica":false,"cpf":{"_classe":"CPF","valor":"000.000.000-00"},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"rg":{"_classe":"RG","valor":"00.000.000-0"},"inscricao_estadual":"1234412","telefones":[{"_classe":"Telefone","id":1036,"numero":"t1241243","excluido":false}],"endereco":{"_classe":"Endereco","id":1001,"rua":"0","bairro":"Bairro Teste","numero":"0","cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5568,"nome":"ACRELANDIA","excluida":false,"estado":{"_classe":"Estado","id":34,"sigla":"AC","excluido":false}}},"suframado":false,"inscricao_suframa":"","empresa":{"_classe":"Empresa","id":58,"nome":"Teste","email":{"_classe":"Email","id":0,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":"","filtro":""},"telefone":{"_classe":"Telefone","id":0,"numero":"","excluido":false},"endereco":{"_classe":"Endereco","id":0,"rua":null,"bairro":null,"numero":null,"cep":{"_classe":"CEP","valor":"00000-000"},"cidade":{"_classe":"Cidade","id":0,"nome":null,"excluida":false,"estado":{"_classe":"Estado","id":0,"sigla":null,"excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":false,"aceitou_contrato":false,"juros_mensal":0,"inscricao_estadual":null,"is_logistica":false},"categoria":{"_classe":"CategoriaCliente","id":165,"nome":"Teste","excluida":false},"excluido":false},"saida":true,"empresa":{"_classe":"Empresa","id":58,"nome":"Teste","email":{"_classe":"Email","id":0,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":"","filtro":""},"telefone":{"_classe":"Telefone","id":0,"numero":"","excluido":false},"endereco":{"_classe":"Endereco","id":0,"rua":null,"bairro":null,"numero":null,"cep":{"_classe":"CEP","valor":"00000-000"},"cidade":{"_classe":"Cidade","id":0,"nome":null,"excluida":false,"estado":{"_classe":"Estado","id":0,"sigla":null,"excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":false,"aceitou_contrato":false,"juros_mensal":0,"inscricao_estadual":null,"is_logistica":false},"data_emissao":1550030334981,"excluida":false,"interferir_estoque":false,"produtos":[{"_classe":"ProdutoNota","id":0,"produto":{"_classe":"Produto","id":459570,"id_universal":12,"nome":"teste","categoria":{"_classe":"CategoriaProduto","id":1067,"nome":"","excluida":false,"base_calculo":40,"ipi":0,"icms_normal":1,"icms":0},"liquido":0,"unidade":"Galao","quantidade_unidade":0.25,"excluido":false,"habilitado":1,"empresa":{"_classe":"Empresa","id":58,"nome":"Teste","email":{"_classe":"Email","id":263093,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":"","filtro":""},"telefone":{"_classe":"Telefone","id":996,"numero":"t1241243","excluido":false},"endereco":{"_classe":"Endereco","id":966,"rua":"Rua Teste","bairro":"Bairro Teste","numero":"0","cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5568,"nome":"ACRELANDIA","excluida":false,"estado":{"_classe":"Estado","id":34,"sigla":"AC","excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":0,"aceitou_contrato":0,"juros_mensal":2,"inscricao_estadual":"1234412","is_logistica":false},"valor_base":15,"lucro_consignado":0,"custo":123,"ncm":"12341234","peso_liquido":12,"peso_bruto":23,"estoque":80,"ativo":"teste","concentracao":"","disponivel":80,"transito":0,"ofertas":[],"grade":{"_classe":"Grade","gr":[15,2,1],"str":"15,2,1"},"imagem":"","fabricante":"et","classe_risco":0,"logistica":{"_classe":"Logistica","id":59,"nome":"Logistic Center Gru","email":{"_classe":"Email","id":263114,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":"","filtro":""},"telefone":{"_classe":"Telefone","id":1021,"numero":"t1241243","excluido":false},"endereco":{"_classe":"Endereco","id":987,"rua":"Rua Teste","bairro":"Bairro Teste","numero":"0","cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5568,"nome":"ACRELANDIA","excluida":false,"estado":{"_classe":"Estado","id":34,"sigla":"AC","excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":0,"aceitou_contrato":0,"juros_mensal":2,"inscricao_estadual":"1234412","is_logistica":true}},"quantidade":1,"nota":{"recursao":2},"valor_total":31.22,"cfop":"5152","valor_unitario":31.22,"base_calculo":0,"icms":0,"ipi":0,"influencia_estoque":0,"informacao_adicional":null}],"observacao":"Nota referente a remessa da empresa 58","vencimentos":[{"_classe":"Vencimento","id":0,"valor":31.22,"data":1550030335432,"nota":{"recursao":2},"movimento":null}],"frete_destinatario_remetente":false,"forma_pagamento":{"_classe":"DepositoEmConta","id":1,"nome":"Deposito em conta"},"emitida":false,"xml":null,"danfe":null,"chave":"","numero":"25628","ficha":0,"cancelada":false,"protocolo":"","inverter":59},{"_classe":"Nota","id":0,"transportadora":{"_classe":"Transportadora","id":65789,"razao_social":"T1","nome_fantasia":"T2","telefones":[{"_classe":"Telefone","id":998,"numero":"1234432","excluido":false}],"despacho":999,"empresa":{"_classe":"Empresa","id":58,"nome":"Teste","email":{"_classe":"Email","id":0,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":"","filtro":""},"telefone":{"_classe":"Telefone","id":0,"numero":"","excluido":false},"endereco":{"_classe":"Endereco","id":0,"rua":null,"bairro":null,"numero":null,"cep":{"_classe":"CEP","valor":"00000-000"},"cidade":{"_classe":"Cidade","id":0,"nome":null,"excluida":false,"estado":{"_classe":"Estado","id":0,"sigla":null,"excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":false,"aceitou_contrato":false,"juros_mensal":0,"inscricao_estadual":null,"is_logistica":false},"endereco":{"_classe":"Endereco","id":969,"rua":"Rua Teste","bairro":"Bairro Teste","numero":"0","cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5568,"nome":"ACRELANDIA","excluida":false,"estado":{"_classe":"Estado","id":34,"sigla":"AC","excluido":false}}},"email":{"_classe":"Email","id":263096,"endereco":"renan_goncalves@outlook.com.br","excluido":false,"senha":"","filtro":""},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"inscricao_estadual":"333333333","habilitada":true,"tabela":{"_classe":"Tabela","id":648,"nome":"teste unitario","regras":[{"_classe":"RegraTabela","id":1301,"condicional":"!valor>50&\'!cliente.cidade\'=\'TESTE\'","resultante":"!valor+!peso*5","interpretadorNumerico":{"_classe":"InterpretadorNumerico","replacer":null,"index":null,"funcoesNumericas":[{"_classe":"Max"},{"_classe":"Min"},{"_classe":"Baixo"},{"_classe":"Cima"}],"obj":null},"interpretadorBooleano":{"_classe":"InterpretadorBooleano","funcoes":[{"_classe":"GrupoCidadesExp"}],"leitorNumerico":{"_classe":"InterpretadorNumerico","replacer":null,"index":null,"funcoesNumericas":[{"_classe":"Max"},{"_classe":"Min"},{"_classe":"Baixo"},{"_classe":"Cima"}],"obj":null},"obj":null}},{"_classe":"RegraTabela","id":1302,"condicional":"!valor>40&!valor<50&\'!cliente.cidade\'=\'TESTE\'","resultante":"!valor+!peso*4","interpretadorNumerico":{"_classe":"InterpretadorNumerico","replacer":null,"index":null,"funcoesNumericas":[{"_classe":"Max"},{"_classe":"Min"},{"_classe":"Baixo"},{"_classe":"Cima"}],"obj":null},"interpretadorBooleano":{"_classe":"InterpretadorBooleano","funcoes":[{"_classe":"GrupoCidadesExp"}],"leitorNumerico":{"_classe":"InterpretadorNumerico","replacer":null,"index":null,"funcoesNumericas":[{"_classe":"Max"},{"_classe":"Min"},{"_classe":"Baixo"},{"_classe":"Cima"}],"obj":null},"obj":null}}],"excluida":false}},"fornecedor":{"_classe":"Fornecedor","id":248,"nome":"Teste","email":{"_classe":"Email","id":263116,"endereco":"renan.miranda@agrofauna.com.br","excluido":false,"senha":"","filtro":""},"telefones":[{"_classe":"Telefone","id":null,"numero":null,"excluido":false}],"endereco":{"_classe":"Endereco","id":989,"rua":"0","bairro":"Bairro Teste","numero":"0","cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5619,"nome":"FELIZ DESERTO","excluida":false,"estado":{"_classe":"Estado","id":35,"sigla":"AL","excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluido":false,"empresa":{"_classe":"Logistica","id":59,"nome":"Logistic Center Gru","email":{"_classe":"Email","id":263114,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":"","filtro":""},"telefone":{"_classe":"Telefone","id":1021,"numero":"t1241243","excluido":false},"endereco":{"_classe":"Endereco","id":987,"rua":"Rua Teste","bairro":"Bairro Teste","numero":"0","cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5568,"nome":"ACRELANDIA","excluida":false,"estado":{"_classe":"Estado","id":34,"sigla":"AC","excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":0,"aceitou_contrato":0,"juros_mensal":2,"inscricao_estadual":"1234412","is_logistica":true},"inscricao_estadual":"","habilitado":false},"cliente":null,"saida":false,"empresa":{"_classe":"Logistica","id":59,"nome":"Logistic Center Gru","email":{"_classe":"Email","id":263114,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":"","filtro":""},"telefone":{"_classe":"Telefone","id":1021,"numero":"t1241243","excluido":false},"endereco":{"_classe":"Endereco","id":987,"rua":"Rua Teste","bairro":"Bairro Teste","numero":"0","cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5568,"nome":"ACRELANDIA","excluida":false,"estado":{"_classe":"Estado","id":34,"sigla":"AC","excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":0,"aceitou_contrato":0,"juros_mensal":2,"inscricao_estadual":"1234412","is_logistica":true},"data_emissao":1550030334981,"excluida":false,"interferir_estoque":false,"produtos":[{"_classe":"ProdutoNota","id":0,"produto":{"_classe":"Produto","id":459570,"id_universal":12,"nome":"teste","categoria":{"_classe":"CategoriaProduto","id":1067,"nome":"","excluida":false,"base_calculo":40,"ipi":0,"icms_normal":1,"icms":0},"liquido":0,"unidade":"Galao","quantidade_unidade":0.25,"excluido":false,"habilitado":1,"empresa":{"_classe":"Empresa","id":58,"nome":"Teste","email":{"_classe":"Email","id":263093,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":"","filtro":""},"telefone":{"_classe":"Telefone","id":996,"numero":"t1241243","excluido":false},"endereco":{"_classe":"Endereco","id":966,"rua":"Rua Teste","bairro":"Bairro Teste","numero":"0","cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5568,"nome":"ACRELANDIA","excluida":false,"estado":{"_classe":"Estado","id":34,"sigla":"AC","excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":0,"aceitou_contrato":0,"juros_mensal":2,"inscricao_estadual":"1234412","is_logistica":false},"valor_base":15,"lucro_consignado":0,"custo":123,"ncm":"12341234","peso_liquido":12,"peso_bruto":23,"estoque":80,"ativo":"teste","concentracao":"","disponivel":80,"transito":0,"ofertas":[],"grade":{"_classe":"Grade","gr":[15,2,1],"str":"15,2,1"},"imagem":"","fabricante":"et","classe_risco":0,"logistica":{"_classe":"Logistica","id":59,"nome":"Logistic Center Gru","email":{"_classe":"Email","id":263114,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":"","filtro":""},"telefone":{"_classe":"Telefone","id":1021,"numero":"t1241243","excluido":false},"endereco":{"_classe":"Endereco","id":987,"rua":"Rua Teste","bairro":"Bairro Teste","numero":"0","cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5568,"nome":"ACRELANDIA","excluida":false,"estado":{"_classe":"Estado","id":34,"sigla":"AC","excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":0,"aceitou_contrato":0,"juros_mensal":2,"inscricao_estadual":"1234412","is_logistica":true}},"quantidade":1,"nota":{"recursao":2},"valor_total":31.22,"cfop":"5152","valor_unitario":31.22,"base_calculo":0,"icms":0,"ipi":0,"influencia_estoque":0,"informacao_adicional":null}],"observacao":"Nota referente a remessa da empresa 58","vencimentos":[{"_classe":"Vencimento","id":0,"valor":31.22,"data":1550030335432,"nota":{"recursao":2},"movimento":null}],"frete_destinatario_remetente":false,"forma_pagamento":{"_classe":"DepositoEmConta","id":1,"nome":"Deposito em conta"},"emitida":false,"xml":null,"danfe":null,"chave":"","numero":"25628","ficha":0,"cancelada":true,"protocolo":""}]}]');
        
        $notas = $teste[0]->notas_logisticas;
        $notas[] = $teste[0]->nota;
        foreach($notas as $key=>$value){
            $value->numero = "4444444";
            $value->merge($con);
        }

        
    }

}
