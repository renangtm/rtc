<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sistema
 *
 * @author Renan
 */
class Sistema {
    
    
    public static function getIcmsEstado($estado){
        
        $doze = array("MG","RS","SC","RJ","PB");
        
        if(in_array($estado->sigla, $doze)){
            
            return 12;
            
        } 
        
        return 7;
        
    }
    
    public static function getCategoriaDocumentos(){
        
        $cats = array();
        
        $cats[] = new CategoriaDocumento(1, "NFE");
        $cats[] = new CategoriaDocumento(2, "Certificado Comerciante de Agrotoxico");
        $cats[] = new CategoriaDocumento(3, "Documentos Empresariais");
        $cats[] = new CategoriaDocumento(4, "Balanco");
        
        return $cats;
        
    }
    
    public function getPermissoes(){
        
        $perms = array();
        
        $perms[] = new Permissao(1,"pedido_entrada");
        $perms[] = new Permissao(2,"produto"); 
        $perms[] = new Permissao(3,"cotacao");
        $perms[] = new Permissao(4,"transportadora"); 
        $perms[] = new Permissao(5,"cliente"); 
        $perms[] = new Permissao(6,"nota");
        $perms[] = new Permissao(7,"lote");
        $perms[] = new Permissao(8,"tabela");
        $perms[] = new Permissao(9,"campanha");
        $perms[] = new Permissao(10,"grupo_cidades");
        $perms[] = new Permissao(11,"banco");
        $perms[] = new Permissao(12,"movimento");
        $perms[] = new Permissao(13,"pedido_saida");
        $perms[] = new Permissao(14,"categoria_produto");
        $perms[] = new Permissao(15,"categoria_cliente");
        $perms[] = new Permissao(16,"categoria_documento");
        $perms[] = new Permissao(17,"fonecedor");
        $perms[] = new Permissao(18,"cfg");
        $perms[] = new Permissao(19,"configuracao_empresa");
        $perms[] = new Permissao(20,"cultura");
        $perms[] = new Permissao(21,"praga");
        $perms[] = new Permissao(22,"receita");
        
        
        return $perms;
        
    }
    
    public static function getStatusPedidoSaida(){
        
        $status = array();
        
        $status[] = new StatusPedidoSaida(1,"Confirmacao de pedido",false,true,true,true);
        $status[] = new StatusPedidoSaida(2,"Limite de credito",false,true,false,false);
        $status[] = new StatusPedidoSaida(3,"Autorizacao de pedido",false,true,false,false);
        $status[] = new StatusPedidoSaida(4,"Confirmacao de pagamento",false,true,true,false);
        $status[] = new StatusPedidoSaida(5,"Separacao",false,true,true,false);
        $status[] = new StatusPedidoSaida(6,"Faturamento",true,true,true,false);
        $status[] = new StatusPedidoSaida(7,"Coleta",true,true,true,true);
        $status[] = new StatusPedidoSaida(8,"Rastreio",true,true,true,false);
        $status[] = new StatusPedidoSaida(9,"Finalizado",true,true,true,false);
        $status[] = new StatusPedidoSaida(10,"Cancelado",true,true,true,true);
        
        return $status;
        
    }
    
    public static function getStatusCotacaoEntrada(){
        
        $sts = array();
        
        $sts[] = new StatusCotacaoEntrada(1,"Aguardando resposta");
        $sts[] = new StatusCotacaoEntrada(2,"Respondida");
        $sts[] = new StatusCotacaoEntrada(3,"Pedido fechado");
        $sts[] = new StatusCotacaoEntrada(4,"Cancelada");
        
        return $sts;
     
    }
    
    public static function getPermissoesIniciais(){
        
        $perms = array();
        
        $perms[] = new Permissao(1,"pedido_entrada",true,true,true,true);
        $perms[] = new Permissao(2,"produto",true,true,true,true); 
        $perms[] = new Permissao(3,"cotacao",true,true,true,true);
        $perms[] = new Permissao(4,"transportadora",true,true,true,true); 
        $perms[] = new Permissao(5,"cliente",true,true,true,true); 
        $perms[] = new Permissao(7,"lote",true,true,true,true);
        $perms[] = new Permissao(13,"pedido_saida",true,true,true,true);
        $perms[] = new Permissao(17,"fonecedor",true,true,true,true);
        $perms[] = new Permissao(18,"cfg",true,true,true,true);
        $perms[] = new Permissao(19,"configuracao_empresa",true,true,true,true);
    
        return $perms;
        
    }
    
    public static function getCategoriaCliente($con){
        
        $cats = array();
        
        $ps = $con->getConexao()->prepare("SELECT id, nome FROM categoria_cliente");
        $ps->execute();
        $ps->bind_result($id, $nome);
        
        while($ps->fetch())
        {
            
            $cat = new CategoriaCliente();
            $cat->id = $id;
            $cat->nome = $nome;
            
            $cats[] = $cat;
            
        }        
        
        $ps->close();
        
        return $cats;
        
    }
    
    public static function getEstados($con) {

        $estados = array();

        $ps = $con->getConexao()->prepare("SELECT id, sigla FROM estado WHERE excluido=false");
        $ps->execute();
        $ps->bind_result($id, $sigla);

        while ($ps->fetch()) {

            $e = new Estado();
            $e->id = $id;
            $e->sigla = $sigla;

            $estados[] = $e;
        }

        $ps->close();

        return $estados;
    }

    public static function getCidades($con) {

        $cidades = array();

        $ps = $con->getConexao()->prepare("SELECT estado.id, estado.sigla, cidade.id, cidade.nome FROM cidade INNER JOIN estado ON cidade.id_estado=estado.id WHERE cidade.excluida=false");
        $ps->execute();
        $ps->bind_result($id_estado, $sigla_estado, $id_cidade, $nome_cidade);

        while ($ps->fetch()) {

            $e = new Estado();
            $e->id = $id_estado;
            $e->sigla = $sigla_estado;

            $c = new Cidade();
            $c->id = $id_cidade;
            $c->nome = $nome_cidade;
            $c->estado = $e;

            $cidades[] = $c;
        }

        $ps->close();

        return $cidades;
    }

}
