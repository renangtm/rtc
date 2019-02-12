<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CotacaoEntrada
 *
 * @author Renan
 */
class Getter {

    public $empresa;

    function __construct($emp) {
        $this->empresa = $emp;
    }

    public function getFornecedorViaEmpresa($con, $empresa) {

        $fornecedores = $this->empresa->getFornecedores($con, 0, 1, "fornecedor.cnpj='" . $empresa->cnpj->valor . "'");

        if (count($fornecedores) > 0) {

            return $fornecedores[0];
        }

        $fornecedor = new Fornecedor();
        $fornecedor->nome = $empresa->nome;
        $fornecedor->empresa = $this->empresa;
        $fornecedor->cnpj = $empresa->cnpj;
        $fornecedor->habilitado = true;
        $fornecedor->inscricao_estadual = $empresa->inscricao_estadual;
        $fornecedor->email = Utilidades::copyId0($empresa->email);
        $fornecedor->telefones = array(Utilidades::copyId0($empresa->telefone));
        $fornecedor->endereco = Utilidades::copyId0($empresa->endereco);

        $fornecedor->merge($con);

        return $fornecedor;
    }

    public function getClienteViaEmpresa($con, $empresa) {

        $clientes = $this->empresa->getClientes($con, 0, 1, "cliente.cnpj='" . $empresa->cnpj->valor . "'");

        if (count($clientes) > 0) {

            return $clientes[0];
        }

        $cliente = new Cliente();
        $cliente->razao_social = $empresa->nome;
        $cliente->nome_fantasia = $empresa->nome;
        $cliente->pessoa_fisica = false;

        $cliente->empresa = $this->empresa;
        $cliente->cnpj = $empresa->cnpj;
        $cliente->inscricao_estadual = $empresa->inscricao_estadual;
        $cliente->email = Utilidades::copyId0($empresa->email);
        $cliente->telefones = array(Utilidades::copyId0($empresa->telefone));
        $cliente->endereco = Utilidades::copyId0($empresa->endereco);

        $cliente->categoria = Sistema::getCategoriaCliente($con);
        $cliente->categoria = $cliente->categoria[0];


        $cliente->merge($con);

        return $cliente;
    }

}
