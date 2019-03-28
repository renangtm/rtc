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

class clonarDadosIniciaisRTC extends PHPUnit_Framework_TestCase {

    private static $conexao;

    public function getConexao() {

        if (self::$conexao == null) {
            self::$conexao = new mysqli("192.168.0.104", "SYSTEMUSER", "senha5dosistema1", "db_agrofauna", 10049);
        }

        return self::$conexao;
    }

    public function testSimple() {

        $con = new ConnectionFactory();

        if (true) {

            //retire para realmente executar o script
            //return;
        }
        
        $t = array();
        $ps = $this->getConexao()->prepare("SELECT F_CODPROD,IFNULL(F_FABVEND,F_MARCA) FROM db_agrofauna.PRODUTO");
        $ps->execute();
        $ps->bind_result($id,$tipo);
        while($ps->fetch()){
            $t[$id]=$tipo;
        }
        $ps->close();
        
        foreach($t as $id=>$tipo){
            
            
            $ps = $con->getConexao()->prepare("UPDATE produto SET fabricante='$tipo' WHERE id_universal=$id");
            $ps->execute();
            $ps->close();
            
        }
        
        return;

        $cidades = array();



        $ps = $con->getConexao()->prepare("SELECT id,nome FROM cidade");
        $ps->execute();
        $ps->bind_result($id, $nome);
        while ($ps->fetch()) {
            $c = new Cidade();
            $c->id = $id;
            $c->nome = $nome;
            $cidades[] = $c;
        }
        $ps->close();

        $filial = new Empresa(1733);
        $matriz = new Empresa(1734);

        // categorias de cliente;

        $ps = $con->getConexao()->prepare("DELETE FROM novo_rtc.categoria_cliente");
        $ps->execute();
        $ps->close();

        $c = new CategoriaCliente();
        $c->nome = "Micro empresa";
        $c->merge($con);

        $c = new CategoriaCliente();
        $c->nome = "Pequeno Porte";
        $c->merge($con);

        $c = new CategoriaCliente();
        $c->nome = "Medio Porte";
        $c->merge($con);

        $c = new CategoriaCliente();
        $c->nome = "Grande Porte";
        $c->merge($con);

        $c = new CategoriaCliente();
        $c->nome = "Sem categoria";
        $c->merge($con);

        // ------------------------------

        $ps = $con->getConexao()->prepare("DELETE FROM novo_rtc.cliente");
        $ps->execute();
        $ps->close();

        $ps = $this->getConexao()->prepare("SELECT c.CODCLI,"
                . "fn_remove_accents(c.NOMFAN),"
                . "fn_remove_accents(c.NOMCLI),"
                . "GROUP_CONCAT(IFNULL(t.TELEFONE,'00000000') separator ';'),"
                . "c.ENDPRI,c.NUMRES,fn_remove_accents(cid.NOMCID),cid.ESTCID,"
                . "c.CEPPRI,c.CGCCPF,INSEST,c.EMAIL,ia.INSCRICAO_SUFRAMA,(ia.REGULAR_SUFRAMA='S' AND ia.ISENCAO_SUFRAMA='S') FROM db_agrofauna.FATFCLIE c LEFT JOIN db_agrofauna.TELEFONE t ON t.CODCLI=c.CODCLI "
                . "INNER JOIN db_agrofauna.FATFCIDI cid ON cid.CODCID=c.CODCID LEFT JOIN db_agrofauna.INFO_ADIC_CLIENTE ia ON ia.CODIGO_CLIENTE=c.CODCLI GROUP BY c.CODCLI");
        $ps->execute();
        $ps->bind_result($codigo, $nomfan, $nomcli, $telefones, $endereco, $numero, $cidade, $estado, $cep, $cnpj, $ie, $email, $suf, $ise);
        $clientes = array();
        $clientes_matriz = array();
        while ($ps->fetch()) {

            $cliente = new Cliente();
            $cliente->nome_fantasia = $nomfan."__$codigo";
            $cliente->razao_social = $nomcli;
            $cliente->codigo = $codigo;

            $tels = array();
            $ts = explode(';', $telefones);
            foreach ($ts as $key => $value) {
                $tels[] = new Telefone($value);
            }

            $cliente->telefones = $tels;
            $cliente->email = new Email($email);
            $cliente->inscricao_estadual = $ie;
            $cliente->cnpj = new CNPJ($cnpj);
            $cliente->pessoa_fisica = false;
            $cliente->empresa = $filial;

            $end = new Endereco();
            $end->rua = $endereco;
            $end->cep = new CEP($cep);
            $end->numero = $numero;
            $end->cidade = $cidades[0];
            $cliente->categoria = $c;

            if ($ise) {

                $cliente->suframado = true;
                $cliente->inscricao_suframa = $suf;
            } else {

                $cliente->suframado = false;
            }

            foreach ($cidades as $key => $value) {

                if (Utilidades::eq($value->nome) === Utilidades::eq($cidade) || Utilidades::eq($value->nome) === Utilidades::eq($cidade . " " . $estado)) {

                    $end->cidade = $value;
                    break;
                }
            }

            $cliente->endereco = $end;
             
            $clientes[] = $cliente;
            $clientes_matriz[] = Utilidades::copyId0($cliente);
            
        }
        $ps->close();

        foreach ($clientes as $key => $value) {

            $value->merge($con);
            $ps = $con->getConexao()->prepare("UPDATE cliente SET id=$value->codigo WHERE id=$value->id");
            $ps->execute();
            $ps->close();
            $value->id = $value->codigo;
            $value->merge($con);
            
            $cli_matriz = $clientes_matriz[$key];
            $cli_matriz->empresa = $matriz;
            $cli_matriz->merge($con);
            
        }
        
        //--------------------------------------------------------
        
        
    }

}
