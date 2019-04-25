<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cliente
 *
 * @author Renan
 */
class Cliente {

    public $id;
    public $razao_social;
    public $nome_fantasia;
    public $email;
    public $limite_credito;
    public $termino_limite;
    public $inicio_limite;
    public $pessoa_fisica;
    public $cpf;
    public $cnpj;
    public $rg;
    public $inscricao_estadual;
    public $telefones;
    public $endereco;
    public $suframado;
    public $inscricao_suframa;
    public $empresa;
    public $categoria;
    public $codigo;
    public $codigo_contimatic;

    function __construct() {

        $this->id = 0;
        $this->email = new Email("");
        $this->cpf = new CPF("");
        $this->cnpj = new CNPJ("");
        $this->rg = new RG("");
        $this->endereco = new Endereco();
        $this->empresa = null;
        $this->categoria = null;
        $this->pessoa_fisica = false;
        $this->telefones = array();
        $this->excluido = false;
        $this->suframado = false;
        $this->limite_credito = 0;
        $this->codigo_contimatic = 0;

        $this->inicio_limite = round(microtime(true) * 1000);
        $this->termino_limite = round(microtime(true) * 1000);

        $this->codigo = 0;
    }

    public function getLimiteCredito() {

        $agora = round(microtime(true) * 1000);

        if ($this->inicio_limite <= $agora && $this->termino_limite >= $agora) {

            return $this->limite_credito;
        }

        return -1;
    }

    public function getPrecoEspecial($con) {
        $ps = $con->getConexao()->prepare("SELECT valor FROM preco_especial WHERE id_cliente=$this->id");
        $ps->execute();
        $ps->bind_result($valor);
        if ($ps->fetch()) {
            $ps->close();

            return $valor;
        }
        $ps->close();

        return -1;
    }

    public function getDividas($con) {

        $valor = 0;

        $ps = $con->getConexao()->prepare("SELECT SUM(vencimento.valor-IFNULL(movimento.valor,0)) "
                . "FROM nota "
                . "INNER JOIN vencimento ON vencimento.id_nota=nota.id "
                . "LEFT JOIN movimento ON movimento.id_vencimento=vencimento.id "
                . "WHERE nota.cancelada=false "
                . "AND nota.excluida=false "
                . "AND nota.saida=true "
                . "AND nota.id_cliente=$this->id");
        $ps->execute();
        $ps->bind_result($divida);
        while ($ps->fetch()) {

            $valor += $divida;
        }
        $ps->close();

        return $divida;
    }

    public function setCategoriasProspeccao($con, $categorias) {

        $ps = $con->getConexao()->prepare("DELETE FROM cliente_categoria_prospeccao WHERE id_cliente=$this->id");
        $ps->execute();
        $ps->close();


        foreach ($categorias as $key => $value) {

            $ps = $con->getConexao()->prepare("INSERT INTO cliente_categoria_prospeccao(id_categoria,id_cliente) VALUES($value->id,$this->id)");
            $ps->execute();
            $ps->close();
        }
    }

    public function getCategoriasProspeccao($con) {

        $categorias = array();
        $ps = $con->getConexao()->prepare("SELECT c.id,c.nome FROM categoria_prospeccao c INNER JOIN cliente_categoria_prospeccao cc ON c.id=cc.id_categoria AND cc.id_cliente=$this->id");
        $ps->execute();
        $ps->bind_result($id, $nome);

        while ($ps->fetch()) {

            $cat = new CategoriaProspeccao();
            $cat->id = $id;
            $cat->nome = $nome;
            $categorias[] = $cat;
        }

        $ps->close();

        return $categorias;
    }

    public function merge($con) {

        $this->categoria->merge($con);

        if ($this->codigo === 0) {

            $ps = $con->getConexao()->prepare("SELECT IFNULL(MAX(codigo)+1,0) FROM cliente WHERE id_empresa=" . $this->empresa->id);
            $ps->execute();
            $ps->bind_result($idn);

            if ($ps->fetch()) {

                $this->codigo = $idn;
            }

            $ps->close();
        }

        if ($this->id == 0) {
            $ps = $con->getConexao()->prepare("INSERT INTO cliente(razao_social,nome_fantasia,limite_credito,inicio_limite,termino_limite,pessoa_fisica,cpf,rg,cnpj,excluido,id_categoria,id_empresa,inscricao_estadual,suframado,inscricao_suframa,codigo) VALUES('" . addslashes($this->razao_social) . "','" . addslashes($this->nome_fantasia) . "','$this->limite_credito',FROM_UNIXTIME($this->inicio_limite/1000),FROM_UNIXTIME($this->termino_limite/1000)," . ($this->pessoa_fisica ? "true" : "false") . ",'" . addslashes($this->cpf->valor) . "','" . addslashes($this->rg->valor) . "','" . $this->cnpj->valor . "',false," . $this->categoria->id . "," . $this->empresa->id . ",'$this->inscricao_estadual'," . ($this->suframado ? "true" : "false") . ",'" . addslashes($this->inscricao_suframa) . "',$this->codigo)");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE cliente SET razao_social='" . addslashes($this->razao_social) . "', nome_fantasia='" . addslashes($this->nome_fantasia) . "', limite_credito=$this->limite_credito, inicio_limite=FROM_UNIXTIME($this->inicio_limite/1000), termino_limite=FROM_UNIXTIME($this->termino_limite/1000), pessoa_fisica=" . ($this->pessoa_fisica ? "true" : "false") . ", cpf='" . addslashes($this->cpf->valor) . "', rg='" . addslashes($this->rg->valor) . "', cnpj='" . addslashes($this->cnpj->valor) . "', excluido= false, id_categoria=" . $this->categoria->id . ", id_empresa=" . $this->empresa->id . ", inscricao_estadual='" . addslashes($this->inscricao_estadual) . "',suframado=" . ($this->suframado ? "true" : "false") . ", inscricao_suframa='$this->inscricao_suframa', codigo=$this->codigo WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();

            if ($this->getLimiteCredito() !== $this->limite_credito) {
                $ps = $con->getConexao()->prepare("UPDATE cliente SET limite_credito=$this->limite_credito, inicio_limite=CURRENT_DATE,termino_limite=DATE_ADD(CURRENT_DATE,INTERVAL 10 DAY) WHERE id = " . $this->id);
                $ps->execute();
                $ps->close();
            }
        }

        if ($this->codigo_contimatic > 0) {

            $ps = $con->getConexao()->prepare("UPDATE cliente SET codigo_contimatic=$this->codigo_contimatic WHERE id=$this->id");
            $ps->execute();
            $ps->close();
        }

        $this->endereco->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE endereco SET tipo_entidade='CLI', id_entidade=$this->id WHERE id=" . $this->endereco->id);
        $ps->execute();
        $ps->close();

        $this->email->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE email SET tipo_entidade='CLI', id_entidade=$this->id WHERE id=" . $this->email->id);
        $ps->execute();
        $ps->close();


        $tels = array();
        $ps = $con->getConexao()->prepare("SELECT id,numero FROM telefone WHERE tipo_entidade='CLI' AND id_entidade=$this->id AND excluido=false");
        $ps->execute();
        $ps->bind_result($idt, $numerot);
        while ($ps->fetch()) {
            $t = new Telefone($numerot);
            $t->id = $idt;
            $tels[] = $t;
        }

        foreach ($tels as $key => $value) {

            foreach ($this->telefones as $key2 => $value2) {

                if ($value->id == $value2->id) {

                    continue 2;
                }
            }

            $value->delete($con);
        }

        foreach ($this->telefones as $key => $value) {

            $value->merge($con);

            $ps = $con->getConexao()->prepare("UPDATE telefone SET tipo_entidade='CLI', id_entidade=$this->id WHERE id=" . $value->id);
            $ps->execute();
            $ps->close();
        }
    }

    public function setDocumentos($docs, $con) {

        $ps = $con->getConexao()->prepare("UPDATE documento SET id_entidade=0 WHERE tipo_entidade='CLI' AND id_entidade=$this->id");
        $ps->execute();
        $ps->close();

        foreach ($docs as $key => $doc) {

            $doc->merge($con);

            $ps = $con->getConexao()->prepare("UPDATE documento SET tipo_entidade='CLI', id_entidade=$this->id WHERE id=$doc->id");
            $ps->execute();
            $ps->close();
        }
    }

    public function getDocumentos($con) {

        $categorias_documento = Sistema::getCategoriaDocumentos();

        $docs = array();

        $ps = $con->getConexao()->prepare("SELECT id,UNIX_TIMESTAMP(data_insercao)*1000,id_categoria,numero,link FROM documento WHERE tipo_entidade='CLI' AND id_entidade=$this->id AND excluido=false");
        $ps->execute();
        $ps->bind_result($id, $data, $id_categoria, $numero, $link);

        while ($ps->fetch()) {

            $d = new Documento();

            $d->id = $id;
            $d->data_insercao = $data;
            $d->numero = $numero;
            $d->link = $link;

            foreach ($categorias_documento as $key => $value) {
                if ($value->id == $id_categoria) {

                    $d->categoria = $value;

                    $docs[] = $d;

                    continue 2;
                }
            }
        }

        $ps->close();

        return $docs;
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE cliente SET excluido=true WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
