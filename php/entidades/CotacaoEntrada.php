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
class CotacaoEntrada {

    public $id;
    public $fornecedor;
    public $frete;
    public $status;
    public $excluida;
    public $usuario;
    public $empresa;
    public $data;
    public $produtos;
    public $tratar_em_litros;
    public $observacao;
    public $enviar_email;
    
    function __construct() {

        $this->id = 0;
        $this->fornecedor = null;
        $this->frete = 0;
        $this->status = null;
        $this->excluida = false;
        $this->tratar_em_litros = true;
        $this->usuario = null;
        $this->empresa = null;
        $this->data = round(microtime(true) * 1000);
        $this->produtos = null;
        $this->enviar_email = true;
        
    }

    public function getProdutos($con) {

        $campanhas = array();
        $ofertas = array();

        $ps = $con->getConexao()->prepare("SELECT "
                . "campanha.id,"
                . "campanha.nome,"
                . "UNIX_TIMESTAMP(campanha.inicio)*1000,"
                . "UNIX_TIMESTAMP(campanha.fim)*1000,"
                . "campanha.prazo,"
                . "campanha.parcelas,"
                . "campanha.cliente_expression,"
                . "produto_campanha.id,"
                . "produto_campanha.id_produto,"
                . "UNIX_TIMESTAMP(produto_campanha.validade)*1000,"
                . "produto_campanha.limite,"
                . "produto_campanha.valor, "
                . "empresa.id,"
                . "empresa.tipo_empresa,"
                . "empresa.nome,"
                . "empresa.inscricao_estadual,"
                . "empresa.consigna,"
                . "empresa.aceitou_contrato,"
                . "empresa.juros_mensal,"
                . "empresa.cnpj,"
                . "endereco.numero,"
                . "endereco.id,"
                . "endereco.rua,"
                . "endereco.bairro,"
                . "endereco.cep,"
                . "cidade.id,"
                . "cidade.nome,"
                . "estado.id,"
                . "estado.sigla,"
                . "email.id,"
                . "email.endereco,"
                . "email.senha,"
                . "telefone.id,"
                . "telefone.numero "
                . "FROM campanha "
                . "INNER JOIN produto_campanha ON campanha.id = produto_campanha.id_campanha "
                . "INNER JOIN empresa ON campanha.id_empresa=empresa.id "
                . "INNER JOIN endereco ON endereco.id_entidade=empresa.id AND endereco.tipo_entidade='EMP' "
                . "INNER JOIN email ON email.id_entidade=empresa.id AND email.tipo_entidade='EMP' "
                . "INNER JOIN telefone ON telefone.id_entidade=empresa.id AND telefone.tipo_entidade='EMP' "
                . "INNER JOIN cidade ON endereco.id_cidade=cidade.id "
                . "INNER JOIN estado ON cidade.id_estado = estado.id "
                . " WHERE campanha.inicio<=CURRENT_TIMESTAMP AND campanha.fim>=CURRENT_TIMESTAMP AND campanha.excluida=false");

        $ps->execute();
        $ps->bind_result($id, $camp_nome, $inicio, $fim, $prazo, $parcelas, $cliente, $id_produto_campanha, $id_produto, $validade, $limite, $valor, $id_empresa,$tipo_empresa, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        while ($ps->fetch()) {

            if (!isset($campanhas[$id])) {

                $campanhas[$id] = new Campanha();
                $campanhas[$id]->id = $id;
                $campanhas[$id]->nome = $camp_nome;
                $campanhas[$id]->inicio = $inicio;
                $campanhas[$id]->fim = $fim;
                $campanhas[$id]->prazo = $prazo;
                $campanhas[$id]->parcelas = $parcelas;
                $campanhas[$id]->cliente_expression = $cliente;

                $empresa = Sistema::getEmpresa($tipo_empresa);
                
                $empresa->id = $id_empresa;
                $empresa->cnpj = new CNPJ($cnpj);
                $empresa->inscricao_estadual = $inscricao_empresa;
                $empresa->nome = $nome_empresa;
                $empresa->aceitou_contrato = $aceitou_contrato;
                $empresa->juros_mensal = $juros_mensal;
                $empresa->consigna = $consigna;

                $endereco = new Endereco();
                $endereco->id = $id_endereco;
                $endereco->rua = $rua;
                $endereco->bairro = $bairro;
                $endereco->cep = new CEP($cep);
                $endereco->numero = $numero_endereco;

                $cidade = new Cidade();
                $cidade->id = $id_cidade;
                $cidade->nome = $nome_cidade;

                $estado = new Estado();
                $estado->id = $id_estado;
                $estado->sigla = $nome_estado;

                $cidade->estado = $estado;

                $endereco->cidade = $cidade;

                $empresa->endereco = $endereco;

                $email = new Email($endereco_email);
                $email->id = $id_email;
                $email->senha = $senha_email;

                $empresa->email = $email;

                $telefone = new Telefone($numero_telefone);
                $telefone->id = $id_telefone;

                $empresa->telefone = $telefone;

                $campanhas[$id]->empresa = $empresa;
            }

            $campanha = $campanhas[$id];

            $p = new ProdutoCampanha();
            $p->id = $id_produto_campanha;
            $p->validade = $validade;
            $p->limite = $limite;
            $p->valor = $valor;
            $p->campanha = $campanha;

            if (!isset($ofertas[$id_produto])) {

                $ofertas[$id_produto] = array();
            }

            $campanhas[$id]->produtos[] = $p;

            $ofertas[$id_produto][] = $p;
        }

        $ps->close();

        $ps = $con->getConexao()->prepare("SELECT produto_cotacao_entrada.id,"
                . "produto_cotacao_entrada.quantidade,"
                . "produto_cotacao_entrada.valor,"
                . "produto.id,"
                . "produto.codigo,"
                . "produto.id_logistica,"
                . "produto.classe_risco,"
                . "produto.fabricante,"
                . "produto.imagem,"
                . "produto.id_universal,"
                . "produto.liquido,"
                . "produto.quantidade_unidade,"
                . "produto.habilitado,"
                . "produto.valor_base,"
                . "produto.custo,"
                . "produto.peso_bruto,"
                . "produto.peso_liquido,"
                . "produto.estoque,"
                . "produto.disponivel,"
                . "produto.transito,"
                . "produto.grade,"
                . "produto.unidade,"
                . "produto.ncm,"
                . "produto.nome,"
                . "produto.lucro_consignado,"
                . "produto.ativo,"
                . "produto.concentracao,"
                . "produto.sistema_lotes,"
                . "produto.nota_usuario,"
                . "produto.id_categoria,"
                . "empresa.id,"
                . "empresa.tipo_empresa,"
                . "empresa.nome,"
                . "empresa.inscricao_estadual,"
                . "empresa.consigna,"
                . "empresa.aceitou_contrato,"
                . "empresa.juros_mensal,"
                . "empresa.cnpj,"
                . "endereco.numero,"
                . "endereco.id,"
                . "endereco.rua,"
                . "endereco.bairro,"
                . "endereco.cep,"
                . "cidade.id,"
                . "cidade.nome,"
                . "estado.id,"
                . "estado.sigla,"
                . "email.id,"
                . "email.endereco,"
                . "email.senha,"
                . "telefone.id,"
                . "telefone.numero"
                . " FROM produto_cotacao_entrada "
                . "INNER JOIN produto ON produto_cotacao_entrada.id_produto=produto.id "
                . "INNER JOIN empresa ON produto.id_empresa=empresa.id "
                . "INNER JOIN endereco ON endereco.id_entidade=empresa.id AND endereco.tipo_entidade='EMP' "
                . "INNER JOIN email ON email.id_entidade=empresa.id AND email.tipo_entidade='EMP' "
                . "INNER JOIN telefone ON telefone.id_entidade=empresa.id AND telefone.tipo_entidade='EMP' "
                . "INNER JOIN cidade ON endereco.id_cidade=cidade.id "
                . "INNER JOIN estado ON cidade.id_estado = estado.id "
                . " WHERE produto_cotacao_entrada.id_cotacao=$this->id");

        $ps->execute();
        $ps->bind_result($id, $quantidade, $valor, $id_pro,$cod_pro,$id_log, $classe_risco, $fabricante, $imagem, $id_uni, $liq, $qtd_un, $hab, $vb, $cus, $pb, $pl, $est, $disp, $tr, $gr, $uni, $ncm, $nome, $lucro, $ativo, $conc,$sistema_lotes,$nota_usuario, $cat_id, $id_empresa,$tipo_empresa, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        $retorno = array();


        while ($ps->fetch()) {

            $p = new Produto();
            $p->logistica =  $id_log;
            $p->id = $id_pro;
            $p->codigo = $cod_pro;
            $p->nome = $nome;
            $p->classe_risco = $classe_risco;
            $p->fabricante = $fabricante;
            $p->imagem = $imagem;
            $p->id_universal = $id_uni;
            $p->liquido = $liq;
            $p->quantidade_unidade = $qtd_un;
            $p->habilitado = $hab;
            $p->valor_base = $vb;
            $p->custo = $cus;
            $p->peso_bruto = $pb;
            $p->peso_liquido = $pl;
            $p->estoque = $est;
            $p->disponivel = $disp;
            $p->sistema_lotes = $sistema_lotes==1;
            $p->nota_usuario = $nota_usuario;
            $p->ativo = $ativo;
            $p->concentracao = $conc;
            $p->transito = $tr;
            $p->grade = new Grade($gr);
            $p->unidade = $uni;
            $p->ncm = $ncm;
            $p->lucro_consignado = $lucro;
            $p->ofertas = (!isset($ofertas[$p->id]) ? array() : $ofertas[$p->id]);

            foreach ($p->ofertas as $key => $oferta) {

                $oferta->produto = $p;
            }

            $p->categoria = Sistema::getCategoriaProduto(null,$cat_id);

            $empresa = Sistema::getEmpresa($tipo_empresa);
            
            $empresa->id = $id_empresa;
            $empresa->cnpj = new CNPJ($cnpj);
            $empresa->inscricao_estadual = $inscricao_empresa;
            $empresa->nome = $nome_empresa;
            $empresa->aceitou_contrato = $aceitou_contrato;
            $empresa->juros_mensal = $juros_mensal;
            $empresa->consigna = $consigna;

            $endereco = new Endereco();
            $endereco->id = $id_endereco;
            $endereco->rua = $rua;
            $endereco->bairro = $bairro;
            $endereco->cep = new CEP($cep);
            $endereco->numero = $numero_endereco;

            $cidade = new Cidade();
            $cidade->id = $id_cidade;
            $cidade->nome = $nome_cidade;

            $estado = new Estado();
            $estado->id = $id_estado;
            $estado->sigla = $nome_estado;

            $cidade->estado = $estado;

            $endereco->cidade = $cidade;

            $empresa->endereco = $endereco;

            $email = new Email($endereco_email);
            $email->id = $id_email;
            $email->senha = $senha_email;

            $empresa->email = $email;

            $telefone = new Telefone($numero_telefone);
            $telefone->id = $id_telefone;

            $empresa->telefone = $telefone;


            $p->empresa = $empresa;

            $pp = new ProdutoCotacaoEntrada();
            $pp->id = $id;
            $pp->quantidade = $quantidade;
            $pp->valor = $valor;
            $pp->cotacao = $this;
            $pp->produto = $p;


            $retorno[$pp->id] = $pp;
        }

        $ps->close();
        
        foreach($retorno as $key=>$value){
            $value->produto->logistica = Sistema::getLogisticaById($con,$value->produto->logistica);
        }

        $real_ret = array();

        foreach ($retorno as $key => $value) {

            $real_ret[] = $value;
        }

        return $real_ret;
    }
    
    public function formarPedido($con,$transportadora,$frete){
        
        $this->status = Sistema::getStatusCotacaoEntrada();
        $this->status = $this->status[2];
        
        $ped = new PedidoEntrada();
        $ped->fornecedor = $this->fornecedor;
        $ped->usuario = $this->usuario;
        $ped->transportadora = $transportadora;
        $ped->frete = $frete;
        $ped->empresa = $this->empresa;
        $ped->observacoes = $this->observacao;
        $p = array();
        
        foreach($this->produtos as $key=>$value){
            
            $prod = new ProdutoPedidoEntrada();
            $prod->quantidade = $value->quantidade;
            $prod->valor = $value->valor;
            $prod->produto = $value->produto;
            $prod->pedido = $ped;
            
            $p[] = $prod;
            
        }
        
        $ped->produtos = $p;
        
        $ped->status = Sistema::getStatusPedidoEntrada();
        $ped->status = $ped->status[0];
        
        $this->merge($con);
        $ped->merge($con);
        
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO cotacao_entrada(id_fornecedor,frete,id_status,excluida,id_usuario,id_empresa,data,tratar_em_litros,observacao) VALUES(" . $this->fornecedor->id . ",$this->frete," . $this->status->id . ",false," . $this->usuario->id . "," . $this->empresa->id . ",FROM_UNIXTIME($this->data)," . ($this->tratar_em_litros ? "true" : "false") . ",'".addslashes($this->observacao)."')");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE cotacao_entrada SET id_fornecedor=" . $this->fornecedor->id . ",frete=$this->frete,id_status=" . $this->status->id . ",excluida=false,id_usuario=" . $this->usuario->id . ",id_empresa=" . $this->empresa->id . ",data=FROM_UNIXTIME($this->data), tratar_em_litros=" . ($this->tratar_em_litros ? "true" : "false") . ",observacao='".addslashes($this->observacao)."' WHERE id = $this->id");
            $ps->execute();
            $ps->close();
        }

        $prods = $this->getProdutos($con);
        
        if($this->produtos === null){
            
            $this->produtos = $prods;
            
        }

        foreach ($prods as $key => $value) {

            foreach ($this->produtos as $key2 => $value2) {

                if ($value->id == $value2->id) {

                    continue 2;
                }
            }

            $value->delete($con);
        }

        foreach ($this->produtos as $key2 => $value2) {

            $value2->merge($con);
        }


        if ($this->status->envia_email && $this->enviar_email) {
            try {
                
                $html = Sistema::getHtml("visualizar-cotacao-entrada", $this);

                $this->empresa->email->enviarEmail($this->fornecedor->email->filtro(Email::$VENDAS), "Cotacao de produtos", $html);
                $this->empresa->email->enviarEmail($this->empresa->email->filtro(Email::$COMPRAS), "Cotacao de produtos", $html);
                
            } catch (Exception $ex) {
                
            }
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE cotacao_entrada SET excluida=true WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
