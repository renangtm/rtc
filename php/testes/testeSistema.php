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

class testeSistema extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
        
        
        $con = new ConnectionFactory();
        /*
        $estados = Sistema::getEstados($con);
        
        $this->assertTrue(count($estados)>1);
        $this->assertTrue(strlen($estados[0]->sigla)==2);
        $this->assertTrue($estados[0]->id>0);
        
        $cidades = Sistema::getCidades($con);
        
        $this->assertTrue(count($cidades)>1);
        $this->assertTrue(strlen($cidades[0]->nome)>2);
        $this->assertTrue($cidades[0]->id>0);
        
        $this->assertTrue(strlen($cidades[0]->estado->sigla)==2);
        $this->assertTrue($cidades[0]->estado->id>0);
        
        $categorias_cliente = Sistema::getCategoriaCliente($con);
        
        $historicos = Sistema::getHistorico($con);
        
        $operacoes = Sistema::getOperacoes($con);
        
        
        echo Utilidades::toJson($historicos);
        
        echo Utilidades::toJson($operacoes);
        
        
        
        $empresa = Utilidades::getEmpresaTeste();
        
        $usuario = Utilidades::getUsuarioTeste($empresa);
        
        $this->assertEquals(Sistema::getUsuario("usuario.login='teste' AND usuario.senha='123456'")->empresa->id,$empresa->id);
        
        $this->assertEquals(Sistema::getUsuario("usuario.login='teste' AND usuario.senha='123456'")->id,$usuario->id);
        
        $this->assertEquals(Sistema::getUsuario("usuario.login='teste' AND usuario.senha='12346'"),null);
        */
        /*
        $cats = Sistema::getCategoriaProduto($con);
        
        echo Utilidades::toJson($cats);
        */
        /*
        $str = '{"_classe":"stdClass","bs":"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"}';
        
        echo Utilidades::toJson(Utilidades::fromJson($str));
        */
      /*
        $obj = Utilidades::fromJson('{"_classe":"Campanha","id":0,"inicio":1549410140820,"fim":1549410140820,"prazo":0,"parcelas":1,"excluida":false,"cliente_expression":"*","empresa":{"_classe":"Empresa","id":430,"nome":"Teste","email":{"_classe":"Email","id":1831,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":""},"telefone":{"_classe":"Telefone","id":1632,"numero":"t1241243","excluido":false},"endereco":{"_classe":"Endereco","id":1835,"rua":"Rua Teste","bairro":"Bairro Teste","numero":0,"cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5568,"nome":"ACRELANDIA","excluida":false,"estado":{"_classe":"Estado","id":34,"sigla":"AC","excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":0,"aceitou_contrato":0,"juros_mensal":2,"inscricao_estadual":1234412},"produtos":[{"_classe":"ProdutoCampanha","id":0,"validade":1549245600000,"campanha":{"recursao":2},"produto":{"_classe":"Produto","id":389,"id_universal":12,"nome":"teste","categoria":{"_classe":"CategoriaProduto","id":2,"nome":"Teste","excluida":false,"base_calculo":40,"ipi":10,"icms_normal":0,"icms":null},"liquido":false,"unidade":"Galao","quantidade_unidade":0.25,"excluido":false,"habilitado":1,"empresa":{"_classe":"Empresa","id":430,"nome":"Teste","email":{"_classe":"Email","id":1831,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":""},"telefone":{"_classe":"Telefone","id":1632,"numero":"t1241243","excluido":false},"endereco":{"_classe":"Endereco","id":1835,"rua":"Rua Teste","bairro":"Bairro Teste","numero":0,"cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5568,"nome":"ACRELANDIA","excluida":false,"estado":{"_classe":"Estado","id":34,"sigla":"AC","excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":0,"aceitou_contrato":0,"juros_mensal":2,"inscricao_estadual":1234412},"valor_base":10,"lucro_consignado":0,"custo":123,"ncm":12341234,"peso_liquido":12,"peso_bruto":23,"estoque":80,"ativo":"","concentracao":"","disponivel":24,"transito":80,"ofertas":[],"grade":{"_classe":"Grade","gr":[40,10,2],"str":"40,10,2"},"imagem":"","fabricante":"","classe_risco":0,"validades":[{"validade":1549245600000,"quantidade":24,"alem":false,"_classe":"stdClass"}]},"valor":"9.03","limite":0},{"_classe":"ProdutoCampanha","id":0,"validade":1554346800000,"campanha":{"recursao":2},"produto":{"_classe":"Produto","id":390,"id_universal":12,"nome":"teste","categoria":{"_classe":"CategoriaProduto","id":2,"nome":"Teste","excluida":false,"base_calculo":40,"ipi":10,"icms_normal":0,"icms":null},"liquido":false,"unidade":"Galao","quantidade_unidade":0.25,"excluido":false,"habilitado":1,"empresa":{"_classe":"Empresa","id":430,"nome":"Teste","email":{"_classe":"Email","id":1831,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":""},"telefone":{"_classe":"Telefone","id":1632,"numero":"t1241243","excluido":false},"endereco":{"_classe":"Endereco","id":1835,"rua":"Rua Teste","bairro":"Bairro Teste","numero":0,"cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5568,"nome":"ACRELANDIA","excluida":false,"estado":{"_classe":"Estado","id":34,"sigla":"AC","excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":0,"aceitou_contrato":0,"juros_mensal":2,"inscricao_estadual":1234412},"valor_base":100,"lucro_consignado":0,"custo":123,"ncm":12341234,"peso_liquido":12,"peso_bruto":23,"estoque":85,"ativo":"","concentracao":"","disponivel":20,"transito":14,"ofertas":[],"grade":{"_classe":"Grade","gr":[15,2,1],"str":"15,2,1"},"imagem":"","fabricante":"","classe_risco":0,"validades":[{"validade":1549245600000,"quantidade":20,"alem":false,"_classe":"stdClass"},{"validade":1554346800000,"quantidade":100,"alem":false,"_classe":"stdClass"}]},"valor":"95.00","limite":0}],"nome":"Campanha B"}');
        
        echo $obj->merge(new ConnectionFactory());
       */
        /*
        $empresa = new Empresa();
        $empresa->id=35;
        
        $pedido = $empresa->getPedidos($con, 0, 1);
        $pedido = $pedido[0];
        $pedido->produtos = $pedido->getProdutos($con);
        
        $em = new Email("renan.miranda@agrofauna.com.br");
        $em->senha = "5hynespt";
        
   
        $em->enviarEmail(new Email("renan_goncalves@outlook.com.br"), "teste", "testew");
        */
        
        
        //echo Utilidades::toJson($produtos);
        
    }

}
