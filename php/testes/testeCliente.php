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

class testeCliente extends PHPUnit_Framework_TestCase {

    public function testSimple() {
        
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
       
        $cliente = new Cliente();
        $cliente->razao_social = "T1";
        $cliente->nome_fantasia = "T2";
        $cliente->limite_credito = 100;
        $cliente->pessoa_fisica = true;
        $cliente->cpf = new CPF("11111111111");
        $cliente->rg = new RG("111111111");
        $cliente->categoria = $cat;
        $cliente->empresa = Utilidades::getEmpresaTeste();
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
        
        $cliente->setDocumentos(array($doc,$doc2),new ConnectionFactory());
        
        $nd = $cliente->getDocumentos(new ConnectionFactory());
        
        $this->assertTrue(count($nd)==2);
        
        $this->assertTrue($nd[0]->link==$doc->link && $nd[1]->link==$doc2->link);
        
        $cliente->delete(new ConnectionFactory());
        
        /*
        $cliente = Utilidades::fromJson('{"_classe":"Cliente","id":3,"razao_social":"T1","nome_fantasia":"T2","email":{"_classe":"Email","id":1438,"endereco":"renan_goncalves@outlook.com.br","excluido":false,"senha":""},"limite_credito":100,"termino_limite":1549068814000,"inicio_limite":1549068814000,"pessoa_fisica":true,"cpf":{"_classe":"CPF","valor":"111.111.111-11"},"cnpj":{"_classe":"CNPJ","valor":"00.000.000/0000-00"},"rg":{"_classe":"RG","valor":"11.111.111-1"},"inscricao_estadual":333333333,"telefones":[{"_classe":"Telefone","id":1135,"numero":2232233,"excluido":false}],"endereco":{"_classe":"Endereco","id":1442,"rua":0,"bairro":"Bairro Teste","numero":0,"cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5568,"nome":"ACRELANDIA","excluida":false,"estado":{"_classe":"Estado","id":34,"sigla":"AC","excluido":false,"cidades":[{"recursao":4},{"_classe":"Cidade","id":5569,"nome":"ASSIS BRASIL","excluida":false,"estado":{"recursao":4}},{"_classe":"Cidade","id":5570,"nome":"BRASILEIA","excluida":false,"estado":{"recursao":4}},{"_classe":"Cidade","id":5571,"nome":"BUJARI","excluida":false,"estado":{"recursao":4}},{"_classe":"Cidade","id":5572,"nome":"CAPIXABA","excluida":false,"estado":{"recursao":4}},{"_classe":"Cidade","id":5573,"nome":"CRUZEIRO DO SUL AC","excluida":false,"estado":{"recursao":4}},{"_classe":"Cidade","id":5574,"nome":"EPITACIOLANDIA","excluida":false,"estado":{"recursao":4}},{"_classe":"Cidade","id":5575,"nome":"FEIJO","excluida":false,"estado":{"recursao":4}},{"_classe":"Cidade","id":5576,"nome":"JORDAO","excluida":false,"estado":{"recursao":4}},{"_classe":"Cidade","id":5577,"nome":"MANCIO LIMA","excluida":false,"estado":{"recursao":4}},{"_classe":"Cidade","id":5578,"nome":"MANOEL URBANO","excluida":false,"estado":{"recursao":4}},{"_classe":"Cidade","id":5579,"nome":"MARECHAL THAUMATURGO","excluida":false,"estado":{"recursao":4}},{"_classe":"Cidade","id":5580,"nome":"PLACIDO DE CASTRO","excluida":false,"estado":{"recursao":4}},{"_classe":"Cidade","id":5581,"nome":"PORTO ACRE","excluida":false,"estado":{"recursao":4}},{"_classe":"Cidade","id":5582,"nome":"PORTO WALTER","excluida":false,"estado":{"recursao":4}},{"_classe":"Cidade","id":5583,"nome":"RIO BRANCO AC","excluida":false,"estado":{"recursao":4}},{"_classe":"Cidade","id":5584,"nome":"RODRIGUES ALVES","excluida":false,"estado":{"recursao":4}},{"_classe":"Cidade","id":5585,"nome":"SANTA ROSA DO PURUS","excluida":false,"estado":{"recursao":4}},{"_classe":"Cidade","id":5586,"nome":"SENA MADUREIRA","excluida":false,"estado":{"recursao":4}},{"_classe":"Cidade","id":5587,"nome":"SENADOR GUIOMARD","excluida":false,"estado":{"recursao":4}},{"_classe":"Cidade","id":5588,"nome":"TARAUACA","excluida":false,"estado":{"recursao":4}},{"_classe":"Cidade","id":5589,"nome":"XAPURI","excluida":false,"estado":{"recursao":4}}]}}},"suframado":0,"inscricao_suframa":444444444,"empresa":{"_classe":"Empresa","id":378,"nome":"Teste","email":{"_classe":"Email","id":1435,"endereco":"emailinvalido@invalido.com.br","excluido":false,"senha":""},"telefone":{"_classe":"Telefone","id":1130,"numero":"t1241243","excluido":false},"endereco":{"_classe":"Endereco","id":1439,"rua":"Rua Teste","bairro":"Bairro Teste","numero":0,"cep":{"_classe":"CEP","valor":"07195-201"},"cidade":{"_classe":"Cidade","id":5568,"nome":"ACRELANDIA","excluida":false,"estado":{"_classe":"Estado","id":34,"sigla":"AC","excluido":false}}},"cnpj":{"_classe":"CNPJ","valor":"11.122.233/3444-55"},"excluida":false,"consigna":0,"aceitou_contrato":0,"juros_mensal":2,"inscricao_estadual":1234412},"categoria_cliente":null,"excluido":false,"categoria":{"_classe":"CategoriaCliente","id":3,"nome":"Teste","excluida":false},"documentos":[{"_classe":"Documento","id":16,"data_insercao":1549068816000,"categoria":{"_classe":"CategoriaDocumento","id":2,"nome":"Certificado Comerciante de Agrotoxico"},"link":12344321,"excluido":false,"numero":12344321}]}');
        
        $cliente->merge(new ConnectionFactory());
        */
    }

}
