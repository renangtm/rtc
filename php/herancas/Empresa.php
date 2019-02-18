<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Fornecedor
 *
 * @author Renan
 */
class Empresa {

    public $id;
    public $nome;
    public $email;
    public $telefone;
    public $endereco;
    public $cnpj;
    public $excluida;
    public $consigna;
    public $aceitou_contrato;
    public $juros_mensal;
    public $inscricao_estadual;
    public $is_logistica;
    public $tem_suframa;

    function __construct($id = 0, $cf = null) {

        $this->id = $id;
        $this->email = null;
        $this->telefone = null;
        $this->endereco = null;
        $this->email = null;
        $this->excluida = false;
        $this->cnpj = new CNPJ("");
        $this->aceitou_contrato = false;
        $this->consigna = false;
        $this->juros_mensal = 0;
        $this->telefone = new Telefone();
        $this->email = new Email();
        $this->endereco = new Endereco();
        $this->is_logistica = false;

        if ($id > 0 & $cf !== null) {

            $ps = $cf->getConexao()->prepare("SELECT nome,cnpj FROM empresa WHERE id=$id");
            $ps->execute();
            $ps->bind_result($nome, $cnpj);
            if ($ps->fetch()) {
                $this->nome = $nome;
                $this->cnpj = new CNPJ($cnpj);
            }
            $ps->close();
        }
    }

    public function setRTC($con, $rtc) {

        $ps = $con->getConexao()->prepare("UPDATE empresa SET rtc=$rtc->numero WHERE id=$this->id");
        $ps->execute();
        $ps->close();
    }

    public function getRTC($con) {

        $r = 1;
        $ps = $con->getConexao()->prepare("SELECT rtc FROM empresa WHERE id=$this->id");
        $ps->execute();
        $ps->bind_result($rtc);
        if ($ps->fetch()) {
            $r = $rtc;
        }
        $ps->close();

        $rtcs = Sistema::getRTCS();

        foreach (Sistema::getRTCS() as $key => $rtc) {
            if ($rtc->numero === $r) {
                return $rtc;
            }
        }

        return null;
    }

    public function merge($con) {

        if ($this->id == 0) {
            
            $ps = $con->getConexao()->prepare("INSERT INTO empresa(nome,excluida,inscricao_estadual,consigna,aceitou_contrato,juros_mensal,cnpj,is_logistica) VALUES('" . addslashes($this->nome) . "',false,'" . $this->inscricao_estadual . "'," . ($this->consigna ? "true" : "false") . "," . ($this->aceitou_contrato ? "true" : "false") . ",$this->juros_mensal,'" . $this->cnpj->valor . "'," . ($this->is_logistica ? "true" : "false") . ")");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE empresa SET nome='" . addslashes($this->nome) . "',excluida=false,inscricao_estadual = '" . addslashes($this->inscricao_estadual) . "', consigna=" . ($this->consigna ? "true" : "false") . ",aceitou_contrato=" . ($this->aceitou_contrato ? "true" : "false") . ", juros_mensal=" . $this->juros_mensal . ", cnpj='" . $this->cnpj->valor . "', is_logistica=" . ($this->is_logistica ? "true" : "false") . " WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();
        }

        $this->email->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE email SET id_entidade=" . $this->id . ", tipo_entidade='EMP' WHERE id = " . $this->email->id);
        $ps->execute();
        $ps->close();

        $this->endereco->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE endereco SET id_entidade=" . $this->id . ", tipo_entidade='EMP' WHERE id = " . $this->endereco->id);
        $ps->execute();
        $ps->close();

        $this->telefone->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE telefone SET id_entidade=" . $this->id . ", tipo_entidade='EMP' WHERE id = " . $this->telefone->id);
        $ps->execute();
        $ps->close();
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE empresa SET excluida = true WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }
    
    public function setFilial($con,$empresa){
        
        $ps = $con->getConexao()->prepare("INSERT INTO filial(id_empresa1,id_empresa2) VALUES($this->id,$empresa->id)");
        $ps->execute();
        $ps->close();
        
    }

    public function getFiliais($con) {

        $ids = $this->id;

        for ($i = 0; $i < count(explode(',', $ids)); $i++) {

            $id = explode(',', $ids);
            $id = $id[$i];

            $ps = $con->getConexao()->prepare("SELECT CASE WHEN id_empresa1 <> $id THEN id_empresa1 ELSE id_empresa2 END FROM filial WHERE (id_empresa1=$id OR id_empresa2=$id) AND (CASE WHEN id_empresa1 <> $id THEN id_empresa1 ELSE id_empresa2 END) NOT IN ($ids)");
            $ps->execute();
            $ps->bind_result($id_filial);
            while ($ps->fetch()) {
                $ids .= ",$id_filial";
            }
            $ps->close();
        }

        $ps = $con->getConexao()->prepare("SELECT "
                . "empresa.id,"
                . "empresa.is_logistica,"
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
                . "FROM empresa "
                . "INNER JOIN endereco ON endereco.id_entidade=empresa.id AND endereco.tipo_entidade='EMP' "
                . "INNER JOIN email ON email.id_entidade=empresa.id AND email.tipo_entidade='EMP' "
                . "INNER JOIN telefone ON telefone.id_entidade=empresa.id AND telefone.tipo_entidade='EMP' "
                . "INNER JOIN cidade ON endereco.id_cidade=cidade.id "
                . "INNER JOIN estado ON cidade.id_estado = estado.id "
                . "WHERE empresa.id IN ($ids) AND empresa.id <> $this->id");
        $ps->execute();
        $filiais = array();
        $ps->bind_result($id_empresa, $is_logistica, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        while ($ps->fetch()) {

            $empresa = new Empresa();

            if ($is_logistica == 1) {

                $empresa = new Logistica();
            }

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

            $filiais[] = $empresa;
        }

        $ps->close();

        return $filiais;
    }

    public function getCountBancos($con, $filtro = "") {

        $sql = "SELECT COUNT(*) FROM banco WHERE id_empresa=$this->id AND excluido=false ";

        if ($filtro != "") {
            $sql .= "AND $filtro";
        }

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($qtd);

        if ($ps->fetch()) {
            $ps->close();
            return $qtd;
        }
        $ps->close();
        return 0;
    }

    public function getBancos($con, $x1, $x2, $filtro = "", $ordem = "") {

        $bancos = array();

        $sql = "SELECT id,nome,saldo,conta,codigo,agencia FROM banco WHERE id_empresa=$this->id AND excluido=false ";

        if ($filtro != "") {
            $sql .= "AND $filtro ";
        }

        if ($ordem != "") {
            $sql .= "ORDER BY $ordem ";
        }

        $sql .= "LIMIT $x1, " . ($x2 - $x1);

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id, $nome, $saldo, $conta, $codigo, $agencia);

        while ($ps->fetch()) {

            $banco = new Banco();

            $banco->id = $id;
            $banco->nome = $nome;
            $banco->saldo = $saldo;
            $banco->conta = $conta;
            $banco->codigo = $codigo;
            $banco->agencia = $agencia;

            $banco->empresa = $this;

            $bancos[] = $banco;
        }

        $ps->close();

        return $bancos;
    }

    public function getParametrosEmissao($con) {

        $ps = $con->getConexao()->prepare("SELECT id,nota,lote,serie,certificado,senha_certificado FROM parametros_emissao WHERE id_empresa=$this->id");
        $ps->execute();
        $ps->bind_result($id, $nota, $lote, $serie, $certificado, $senha_certificado);

        if ($ps->fetch()) {

            $ps->close();

            $p = new ParametrosEmissao();
            $p->id = $id;
            $p->nota = $nota;
            $p->lote = $lote;
            $p->serie = $serie;
            $p->certificado = Utilidades::base64encode($certificado);
            $p->senha_certificado = $senha_certificado;
            $p->empresa = $this;

            return $p;
        }

        $ps->close();

        return null;
    }

    public function setLogo($con, $logo) {

        $colors = array();
        $frequencia = array();

        $path = file_get_contents($logo);
        $logo = Utilidades::base64encode($path);
        $img = imagecreatefromstring($path);

        $x = imagesx($img);
        $y = imagesy($img);

        $tolerancia = 10;
        $mais_frequente = "";

        for ($i = 0; $i < $y; $i++) {
            for ($j = 0; $j < $x; $j++) {

                $rgb = imagecolorat($img, $j, $i);


                $rgb = array(($rgb >> 16) & 0xFF, ($rgb >> 8) & 0xFF, ($rgb) & 0xFF);
                if ($rgb[0] === 0 && $rgb[1] === 0 && $rgb[2] === 0)
                    continue;

                if ($rgb[0] === 255 && $rgb[1] === 255 && $rgb[2] === 255)
                    continue;
                
                $hash = "";

                foreach ($rgb as $key => $p) {
                    $hash .= ($p - ($p % $tolerancia)) . ".";
                }

                if ($mais_frequente === "") {

                    $mais_frequente = $hash;
                }

                if (isset($colors[$hash])) {
                    $frequencia[$hash] ++;
                    foreach ($rgb as $key => $p) {
                        $colors[$hash][$key] += $p;
                        $colors[$hash][$key] = floor($colors[$hash][$key] / 2);
                    }
                } else {
                    $frequencia[$hash] = 1;
                    $colors[$hash] = $rgb;
                }

                if ($frequencia[$hash] > $frequencia[$mais_frequente]) {
                    $mais_frequente = $hash;
                }
            }
        }

        $cor_predominante = $colors[$mais_frequente];
        $cor = "#";

        foreach ($cor_predominante as $key => $value) {
            $cor .= Utilidades::decimalToHex($value);
        }

        $cor_predominante = $cor;

        $tem_logo = false;
        $ps = $con->getConexao()->prepare("SELECT id FROM logo WHERE id_empresa = $this->id");
        $ps->execute();
        $ps->bind_result($id);
        if ($ps->fetch()) {
            $tem_logo = true;
        }
        $ps->close();

        if ($tem_logo) {
            $ps = $con->getConexao()->prepare("UPDATE logo SET logo='$logo',cor_predominante='$cor' WHERE id_empresa=$this->id");
            $ps->execute();
            $ps->close();
        } else {
            $ps = $con->getConexao()->prepare("INSERT INTO logo(id_empresa,logo,cor_predominante) VALUES($this->id,'$logo','$cor')");
            $ps->execute();
            $ps->close();
        }

        $ses = new SessionManager();
        $ses->deset("logo_$this->id");
    }

    public function getLogo($com) {

        $ses = new SessionManager();

        if (($n = $ses->get("logo_$this->id")) != null) {

            return $n;
        }

        $ps = $com->getConexao()->prepare("SELECT id,logo,cor_predominante FROM logo WHERE id_empresa=$this->id");
        $ps->execute();
        $ps->bind_result($id, $logo, $cor_predominante);
        if ($ps->fetch()) {

            $ps->close();

            $l = new Logo();
            $l->id = $id;
            $l->logo = $logo;
            $l->cor_predominante = $cor_predominante;
            $l->empresa = $this;

            $ses->set("logo_$this->id", $l);

            return $l;
        }

        $ps->close();

        return null;
    }

    public function getCadastroLotesPendentes($con) {

        $sql = "SELECT "
                . "produto.id,"
                . "produto.nome,"
                . "(produto.disponivel-IFNULL(l.quantidade,0)),"
                . "produto.grade "
                . "FROM produto "
                . "LEFT JOIN (SELECT lote.id_produto,SUM(lote.quantidade_real) as 'quantidade' FROM lote WHERE lote.excluido=false GROUP BY lote.id_produto) l ON l.id_produto=produto.id "
                . "WHERE produto.id_empresa = $this->id AND produto.excluido = false AND (produto.disponivel-IFNULL(l.quantidade,0))>0 AND produto.id_logistica=0 AND produto.sistema_lotes=true";


        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id, $nome, $quantidade, $grade);

        $p = array();

        while ($ps->fetch()) {

            $c = new CadastroLotePendente();
            $c->id_produto = $id;
            $c->nome_produto = $nome;
            $c->quantidade = $quantidade;
            $c->grade = new Grade($grade);

            $p[] = $c;
        }

        $ps->close();

        return $p;
    }

    public function getCountLotes($con, $filtro = "") {

        $sql = "SELECT COUNT(*) FROM lote INNER JOIN produto ON produto.id=lote.id_produto WHERE produto.id_empresa=$this->id AND lote.excluido=false ";

        if ($filtro != "") {

            $sql .= "AND $filtro";
        }

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($qtd);

        if ($ps->fetch()) {

            $ps->close();
            return $qtd;
        }

        $ps->close();
        return 0;
    }

    public function getLotes($con, $x1, $x2, $filtro = "", $ordem = "") {

        $campanhas = array();
        $ofertas = array();

        $ps = $con->getConexao()->prepare("SELECT "
                . "campanha.id,"
                . "campanha.inicio,"
                . "campanha.fim,"
                . "campanha.prazo,"
                . "campanha.parcelas,"
                . "campanha.cliente_expression,"
                . "produto_campanha.id,"
                . "produto_campanha.id_produto,"
                . "UNIX_TIMESTAMP(produto_campanha.validade)*1000,"
                . "produto_campanha.limite,"
                . "produto_campanha.valor, "
                . "empresa.id,"
                . "empresa.is_logistica,"
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
        $ps->bind_result($id, $inicio, $fim, $prazo, $parcelas, $cliente, $id_produto_campanha, $id_produto, $validade, $limite, $valor, $id_empresa, $is_logistica, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        while ($ps->fetch()) {

            if (!isset($campanhas[$id])) {

                $campanhas[$id] = new Campanha();
                $campanhas[$id]->id = $id;
                $campanhas[$id]->inicio = $inicio;
                $campanhas[$id]->fim = $fim;
                $campanhas[$id]->prazo = $prazo;
                $campanhas[$id]->parcelas = $parcelas;
                $campanhas[$id]->cliente_expression = $cliente;

                $empresa = new Empresa();

                if ($is_logistica == 1) {

                    $empresa = new Logistica();
                }

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

            $ofertas[$id_produto][] = $p;

            $campanhas[$id]->produtos[] = $p;
        }
        $ps->close();

        $sql = "SELECT "
                . "lote.id,"
                . "lote.numero,"
                . "lote.rua,"
                . "lote.altura,"
                . "UNIX_TIMESTAMP(lote.validade)*1000,"
                . "UNIX_TIMESTAMP(lote.data_entrada)*1000,"
                . "lote.grade,"
                . "lote.quantidade_inicial,"
                . "lote.quantidade_real,"
                . "lote.codigo_fabricante,"
                . "GROUP_CONCAT(retirada.retirada separator ';'),"
                . "produto.id,"
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
                . "categoria_produto.id,"
                . "categoria_produto.nome,"
                . "categoria_produto.base_calculo,"
                . "categoria_produto.ipi,"
                . "categoria_produto.icms_normal,"
                . "categoria_produto.icms "
                . "FROM lote "
                . "LEFT JOIN retirada ON lote.id=retirada.id_lote "
                . "INNER JOIN produto ON lote.id_produto=produto.id "
                . "INNER JOIN categoria_produto ON categoria_produto.id=produto.id_categoria "
                . "WHERE produto.id_empresa = $this->id AND lote.excluido = false ";

        if ($filtro != "") {

            $sql .= "AND $filtro ";
        }

        $sql .= "GROUP BY lote.id ";

        if ($ordem != "") {

            $sql .= "ORDER BY $ordem ";
        }

        $sql .= "LIMIT $x1," . ($x2 - $x1);


        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id, $numero, $rua, $altura, $validade, $entrada, $grade, $quantidade_inicial, $quantidade_real, $codigo_fabricante, $retirada, $id_pro, $id_log, $classe_risco, $fabricante, $imagem, $id_uni, $liq, $qtd_un, $hab, $vb, $cus, $pb, $pl, $est, $disp, $tr, $gr, $uni, $ncm, $nome, $lucro, $ativo, $conc, $sistema_lotes, $nota_usuario, $cat_id, $cat_nom, $cat_bs, $cat_ipi, $cat_icms_normal, $cat_icms);

        $lotes = array();

        $produtos = array();

        while ($ps->fetch()) {

            if (!isset($produtos[$id_pro])) {

                $p = new Produto();
                $p->logistica = $id_log;
                $p->id = $id_pro;
                $p->classe_risco = $classe_risco;
                $p->fabricante = $fabricante;
                $p->imagem = $imagem;
                $p->nome = $nome;
                $p->id_universal = $id_uni;
                $p->sistema_lotes = $sistema_lotes == 1;
                $p->nota_usuario = $nota_usuario;
                $p->liquido = $liq == 1;
                $p->quantidade_unidade = $qtd_un;
                $p->habilitado = $hab;
                $p->empresa = $this;
                $p->valor_base = $vb;
                $p->custo = $cus;
                $p->peso_bruto = $pb;
                $p->peso_liquido = $pl;
                $p->estoque = $est;
                $p->disponivel = $disp;
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

                $p->categoria = new CategoriaProduto();

                $p->categoria->id = $cat_id;
                $p->categoria->nome = $cat_nom;
                $p->categoria->base_calculo = $cat_bs;
                $p->categoria->icms = $cat_icms;
                $p->categoria->icms_normal = $cat_icms_normal;
                $p->categoria->ipi = $cat_ipi;

                $p->empresa = $this;

                $produtos[$id_pro] = $p;
            }


            $lote = new Lote();
            $lote->id = $id;
            $lote->numero = $numero;
            $lote->rua = $rua;
            $lote->altura = $altura;
            $lote->validade = $validade;
            $lote->entrada = $entrada;
            $lote->quantidade_inicial = $quantidade_inicial;
            $lote->grade = new Grade($grade);
            $lote->quantidade_real = $quantidade_real;
            $lote->produto = $produtos[$id_pro];
            $lote->codigo_fabricante = $codigo_fabricante;

            if ($retirada != null) {

                $rets = explode(';', $retirada);

                foreach ($rets as $key => $value) {

                    $ret = explode(',', $value);
                    foreach ($ret as $key => $value) {

                        $ret[$key] = intval($ret[$key]);
                    }

                    $lote->retiradas[] = $ret;
                }
            }

            $lotes[] = $lote;
        }

        $ps->close();

        foreach ($produtos as $key => $value) {
            $value->logistica = Sistema::getLogisticaById($con, $value->logistica);
        }

        return $lotes;
    }

    public function getPedidos($con, $x1, $x2, $filtro = "", $ordem = "") {

        $sql = "SELECT "
                . "pedido.id,"
                . "pedido.id_logistica, "
                . "pedido.id_nota, "
                . "pedido.frete_inclusao, "
                . "UNIX_TIMESTAMP(pedido.data)*1000, "
                . "pedido.prazo, "
                . "pedido.parcelas, "
                . "pedido.id_status, "
                . "pedido.id_forma_pagamento, "
                . "pedido.frete, "
                . "pedido.observacoes, "
                . "cliente.id, "
                . "cliente.razao_social, "
                . "cliente.nome_fantasia, "
                . "cliente.limite_credito, "
                . "UNIX_TIMESTAMP(cliente.inicio_limite)*1000, "
                . "UNIX_TIMESTAMP(cliente.termino_limite)*1000, "
                . "cliente.pessoa_fisica, "
                . "cliente.cpf, "
                . "cliente.cnpj, "
                . "cliente.rg, "
                . "cliente.inscricao_estadual, "
                . "cliente.suframado, "
                . "cliente.inscricao_suframa, "
                . "categoria_cliente.id, "
                . "categoria_cliente.nome, "
                . "endereco_cliente.id, "
                . "endereco_cliente.rua, "
                . "endereco_cliente.numero, "
                . "endereco_cliente.bairro, "
                . "endereco_cliente.cep, "
                . "cidade_cliente.id, "
                . "cidade_cliente.nome, "
                . "estado_cliente.id, "
                . "estado_cliente.sigla, "
                . "transportadora.id, "
                . "transportadora.razao_social, "
                . "transportadora.nome_fantasia, "
                . "transportadora.despacho, "
                . "transportadora.cnpj, "
                . "transportadora.habilitada, "
                . "transportadora.inscricao_estadual,"
                . "endereco_transportadora.id, "
                . "endereco_transportadora.rua, "
                . "endereco_transportadora.numero, "
                . "endereco_transportadora.bairro, "
                . "endereco_transportadora.cep, "
                . "cidade_transportadora.id, "
                . "cidade_transportadora.nome, "
                . "estado_transportadora.id, "
                . "estado_transportadora.sigla, "
                . "usuario.id, "
                . "usuario.nome, "
                . "usuario.login, "
                . "usuario.senha, "
                . "usuario.cpf, "
                . "endereco_usuario.id, "
                . "endereco_usuario.rua, "
                . "endereco_usuario.numero, "
                . "endereco_usuario.bairro, "
                . "endereco_usuario.cep, "
                . "cidade_usuario.id, "
                . "cidade_usuario.nome, "
                . "estado_usuario.id, "
                . "estado_usuario.sigla,"
                . "email_cliente.id,"
                . "email_cliente.endereco,"
                . "email_cliente.senha, "
                . "email_tra.id, "
                . "email_tra.endereco, "
                . "email_tra.senha, "
                . "email_usu.id, "
                . "email_usu.endereco,"
                . "email_usu.senha "
                . "FROM pedido "
                . "INNER JOIN cliente ON cliente.id=pedido.id_cliente "
                . "INNER JOIN endereco endereco_cliente ON endereco_cliente.id_entidade=cliente.id AND endereco_cliente.tipo_entidade='CLI' "
                . "INNER JOIN cidade cidade_cliente ON endereco_cliente.id_cidade=cidade_cliente.id "
                . "INNER JOIN estado estado_cliente ON estado_cliente.id=cidade_cliente.id_estado "
                . "INNER JOIN transportadora ON transportadora.id = pedido.id_transportadora "
                . "INNER JOIN endereco endereco_transportadora ON endereco_transportadora.id_entidade=transportadora.id AND endereco_transportadora.tipo_entidade='TRA' "
                . "INNER JOIN cidade cidade_transportadora ON endereco_transportadora.id_cidade=cidade_transportadora.id "
                . "INNER JOIN estado estado_transportadora ON estado_transportadora.id=cidade_transportadora.id_estado "
                . "INNER JOIN usuario ON usuario.id=pedido.id_usuario "
                . "INNER JOIN endereco endereco_usuario ON endereco_usuario.id_entidade=usuario.id AND endereco_usuario.tipo_entidade='USU' "
                . "INNER JOIN cidade cidade_usuario ON endereco_usuario.id_cidade=cidade_usuario.id "
                . "INNER JOIN estado estado_usuario ON estado_usuario.id=cidade_usuario.id_estado "
                . "INNER JOIN categoria_cliente ON cliente.id_categoria=categoria_cliente.id "
                . "INNER JOIN email email_cliente ON email_cliente.id_entidade=cliente.id AND email_cliente.tipo_entidade='CLI' "
                . "INNER JOIN email email_tra ON email_tra.id_entidade=transportadora.id AND email_tra.tipo_entidade='TRA' "
                . "INNER JOIN email email_usu ON email_usu.id_entidade=usuario.id AND email_usu.tipo_entidade='USU' "
                . "WHERE pedido.id_empresa = $this->id AND pedido.excluido = false ";

        if ($filtro != "") {

            $sql .= "AND $filtro ";
        }

        if ($ordem != "") {

            $sql .= "ORDER BY $ordem ";
        }

        $sql .= "LIMIT $x1, " . ($x2 - $x1);

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id_pedido, $id_log, $id_nota, $frete_incluso, $data, $prazo, $parcelas, $id_status, $id_forma_pagamento, $frete, $obs, $id_cliente, $nome_cliente, $nome_fantasia_cliente, $limite, $inicio, $fim, $pessoa_fisica, $cpf, $cnpj, $rg, $ie, $suf, $i_suf, $cat_id, $cat_nome, $end_cli_id, $end_cli_rua, $end_cli_numero, $end_cli_bairro, $end_cli_cep, $cid_cli_id, $cid_cli_nome, $est_cli_id, $est_cli_nome, $tra_id, $tra_nome, $tra_nome_fantasia, $tra_despacho, $tra_cnpj, $tra_habilitada, $tra_ie, $end_tra_id, $end_tra_rua, $end_tra_numero, $end_tra_bairro, $end_tra_cep, $cid_tra_id, $cid_tra_nome, $est_tra_id, $est_tra_nome, $id_usu, $nome_usu, $login_usu, $senha_usu, $cpf_usu, $end_usu_id, $end_usu_rua, $end_usu_numero, $end_usu_bairro, $end_usu_cep, $cid_usu_id, $cid_usu_nome, $est_usu_id, $est_usu_nome, $email_cli_id, $email_cli_end, $email_cli_senha, $email_tra_id, $email_tra_end, $email_tra_senha, $email_usu_id, $email_usu_end, $email_usu_senha);


        $pedidos = array();
        $transportadoras = array();
        $usuarios = array();
        $clientes = array();

        while ($ps->fetch()) {

            $cliente = new Cliente();
            $cliente->id = $id_cliente;
            $cliente->cnpj = new CNPJ($cnpj);
            $cliente->cpf = new CPF($cpf);
            $cliente->rg = new RG($rg);
            $cliente->pessoa_fisica = $pessoa_fisica == 1;
            $cliente->nome_fantasia = $nome_fantasia_cliente;
            $cliente->razao_social = $nome_cliente;
            $cliente->empresa = $this;
            $cliente->email = new Email($email_cli_end);
            $cliente->email->id = $email_cli_id;
            $cliente->email->senha = $email_cli_senha;
            $cliente->categoria = new CategoriaCliente();
            $cliente->categoria->id = $cat_id;
            $cliente->categoria->nome = $cat_nome;
            $cliente->inicio_limite = $inicio;
            $cliente->termino_limite = $fim;
            $cliente->limite_credito = $limite;
            $cliente->inscricao_suframa = $i_suf;
            $cliente->suframado = $suf == 1;
            $cliente->empresa = $this;
            $cliente->inscricao_estadual = $ie;

            $end = new Endereco();
            $end->id = $end_cli_id;
            $end->bairro = $end_cli_bairro;
            $end->cep = new CEP($end_cli_cep);
            $end->numero = $end_cli_numero;
            $end->rua = $end_cli_numero;

            $end->cidade = new Cidade();
            $end->cidade->id = $cid_cli_id;
            $end->cidade->nome = $cid_cli_nome;

            $end->cidade->estado = new Estado();
            $end->cidade->estado->id = $est_cli_id;
            $end->cidade->estado->sigla = $est_cli_nome;

            $cliente->endereco = $end;

            if (!isset($clientes[$cliente->id])) {

                $clientes[$cliente->id] = array();
            }

            $clientes[$cliente->id][] = $cliente;

            $transportadora = new Transportadora();
            $transportadora->id = $tra_id;
            $transportadora->cnpj = new CNPJ($tra_cnpj);
            $transportadora->despacho = $tra_despacho;
            $transportadora->email = new Email($email_tra_end);
            $transportadora->email->id = $email_tra_id;
            $transportadora->email->senha = $email_tra_senha;
            $transportadora->habilitada = $tra_habilitada == 1;
            $transportadora->inscricao_estadual = $tra_ie;
            $transportadora->nome_fantasia = $tra_nome_fantasia;
            $transportadora->razao_social = $tra_nome;
            $transportadora->empresa = $this;

            $end = new Endereco();
            $end->id = $end_tra_id;
            $end->bairro = $end_tra_bairro;
            $end->cep = new CEP($end_tra_cep);
            $end->numero = $end_tra_numero;
            $end->rua = $end_tra_rua;

            $end->cidade = new Cidade();
            $end->cidade->id = $cid_tra_id;
            $end->cidade->nome = $cid_tra_nome;

            $end->cidade->estado = new Estado();
            $end->cidade->estado->id = $est_tra_id;
            $end->cidade->estado->sigla = $est_tra_nome;

            $transportadora->endereco = $end;

            if (!isset($transportadoras[$transportadora->id])) {

                $transportadoras[$transportadora->id] = array();
            }

            $transportadoras[$transportadora->id][] = $transportadora;

            $usuario = new Usuario();

            $usuario->cpf = new CPF($cpf_usu);
            $usuario->email = new Email($email_usu_end);
            $usuario->email->id = $email_usu_id;
            $usuario->email->senha = $email_usu_senha;
            $usuario->empresa = $this;
            $usuario->id = $id_usu;
            $usuario->login = $login_usu;
            $usuario->senha = $senha_usu;
            $usuario->nome = $nome_usu;
            $usuario->empresa = $this;

            $end = new Endereco();
            $end->id = $end_usu_id;
            $end->bairro = $end_usu_bairro;
            $end->cep = new CEP($end_usu_cep);
            $end->numero = $end_usu_numero;
            $end->rua = $end_usu_numero;

            $end->cidade = new Cidade();
            $end->cidade->id = $cid_usu_id;
            $end->cidade->nome = $cid_usu_nome;

            $end->cidade->estado = new Estado();
            $end->cidade->estado->id = $est_usu_id;
            $end->cidade->estado->sigla = $est_usu_nome;

            $usuario->endereco = $end;

            if (!isset($usuarios[$usuario->id])) {

                $usuarios[$usuario->id] = array();
            }

            $usuarios[$usuario->id][] = $usuario;


            $pedido = new Pedido();

            $pedido->logistica = $id_log;
            $pedido->cliente = $cliente;
            $pedido->data = $data;
            $pedido->empresa = $this;
            $pedido->id_nota = $id_nota;

            $formas_pagamento = Sistema::getFormasPagamento();

            foreach ($formas_pagamento as $key => $forma) {
                if ($forma->id == $id_forma_pagamento) {
                    $pedido->forma_pagamento = $forma;
                    break;
                }
            }

            $pedido->frete = $frete;
            $pedido->incluir_frete = $frete_incluso == 1;
            $pedido->id = $id_pedido;
            $pedido->observacoes = $obs;
            $pedido->parcelas = $parcelas;
            $pedido->prazo = $prazo;

            $status = Sistema::getStatusPedidoSaida();

            foreach ($status as $key => $st) {
                if ($st->id == $id_status) {
                    $pedido->status = $st;
                    break;
                }
            }

            $pedido->transportadora = $transportadora;

            $pedido->usuario = $usuario;

            $pedidos[] = $pedido;
        }

        $ps->close();

        foreach ($pedidos as $key => $value) {
            $value->logistica = Sistema::getLogisticaById($con, $value->logistica);
        }

        $in_tra = "-1";
        $in_usu = "-1";
        $in_cli = "-1";

        foreach ($clientes as $id => $cliente) {
            $in_cli .= ",";
            $in_cli .= $id;
        }

        foreach ($transportadoras as $id => $transportadora) {
            $in_tra .= ",";
            $in_tra .= $id;
        }

        foreach ($usuarios as $id => $usuario) {
            $in_usu .= ",";
            $in_usu .= $id;
        }

        $ps = $con->getConexao()->prepare("SELECT telefone.id_entidade, telefone.tipo_entidade, telefone.id, telefone.numero FROM telefone WHERE (telefone.id_entidade IN($in_tra) AND telefone.tipo_entidade='TRA') OR (telefone.id_entidade IN ($in_cli) AND telefone.tipo_entidade='CLI') OR (telefone.id_entidade IN ($in_usu) AND telefone.tipo_entidade='USU') AND telefone.excluido = false");
        $ps->execute();
        $ps->bind_result($id_entidade, $tipo_entidade, $id, $numero);
        while ($ps->fetch()) {

            $v = $clientes;
            if ($tipo_entidade == 'TRA') {
                $v = $transportadoras;
            } else if ($tipo_entidade == 'USU') {
                $v = $usuarios;
            }

            $telefone = new Telefone();
            $telefone->id = $id;
            $telefone->numero = $numero;

            foreach ($v[$id_entidade] as $key => $ent) {

                $ent->telefones[] = $telefone;
            }
        }
        $ps->close();

        $ps = $con->getConexao()->prepare("SELECT tabela.id,tabela.nome,tabela.id_transportadora,regra_tabela.id,regra_tabela.condicional,regra_tabela.resultante FROM tabela INNER JOIN regra_tabela ON regra_tabela.id_tabela = tabela.id WHERE tabela.id_transportadora IN ($in_tra) AND tabela.excluida=false");
        $ps->execute();
        $ps->bind_result($id, $nome, $id_tra, $idr, $cond, $res);
        while ($ps->fetch()) {

            $ts = $transportadoras[$id_tra];

            foreach ($ts as $key => $t) {

                if ($t->tabela == null) {

                    $t->tabela = new Tabela();
                    $t->tabela->nome = $nome;
                    $t->tabela->id = $id;
                }

                $regra = new RegraTabela();
                $regra->id = $idr;
                $regra->condicional = $cond;
                $regra->resultante = $res;

                $t->tabela->regras[] = $regra;
            }
        }

        $ps->close();

        $permissoes = Sistema::getPermissoes();

        $ps = $con->getConexao()->prepare("SELECT id_usuario, id_permissao,incluir,deletar,alterar,consultar FROM usuario_permissao WHERE id_usuario IN ($in_usu)");
        $ps->execute();
        $ps->bind_result($id_usuario, $id_permissao, $incluir, $deletar, $alterar, $consultar);

        while ($ps->fetch()) {

            $p = null;

            foreach ($permissoes as $key => $perm) {
                if ($perm->id == $id_permissao) {
                    $p = $perm;
                    break;
                }
            }

            if ($p == null) {

                continue;
            }

            $p->alt = $alterar == 1;
            $p->in = $incluir == 1;
            $p->del = $deletar == 1;
            $p->cons = $consultar == 1;

            foreach ($usuarios[$id_usuario] as $key => $usu) {

                $usu->permissoes[] = $p;
            }
        }

        $ps->close();

        return $pedidos;
    }

    public function getCountPedidos($con, $filtro = "") {

        $sql = "SELECT COUNT(*) "
                . "FROM pedido "
                . "INNER JOIN cliente ON cliente.id=pedido.id_cliente "
                . "INNER JOIN endereco endereco_cliente ON endereco_cliente.id_entidade=cliente.id AND endereco_cliente.tipo_entidade='CLI' "
                . "INNER JOIN cidade cidade_cliente ON endereco_cliente.id_cidade=cidade_cliente.id "
                . "INNER JOIN estado estado_cliente ON estado_cliente.id=cidade_cliente.id_estado "
                . "INNER JOIN transportadora ON transportadora.id = pedido.id_transportadora "
                . "INNER JOIN endereco endereco_transportadora ON endereco_transportadora.id_entidade=transportadora.id AND endereco_transportadora.tipo_entidade='TRA' "
                . "INNER JOIN cidade cidade_transportadora ON endereco_transportadora.id_cidade=cidade_transportadora.id "
                . "INNER JOIN estado estado_transportadora ON estado_transportadora.id=cidade_transportadora.id_estado "
                . "INNER JOIN usuario ON usuario.id=pedido.id_usuario "
                . "INNER JOIN endereco endereco_usuario ON endereco_usuario.id_entidade=usuario.id AND endereco_usuario.tipo_entidade='USU' "
                . "INNER JOIN cidade cidade_usuario ON endereco_usuario.id_cidade=cidade_usuario.id "
                . "INNER JOIN estado estado_usuario ON estado_usuario.id=cidade_usuario.id_estado "
                . "INNER JOIN categoria_cliente ON cliente.id_categoria=categoria_cliente.id "
                . "INNER JOIN email email_cliente ON email_cliente.id_entidade=cliente.id AND email_cliente.tipo_entidade='CLI' "
                . "INNER JOIN email email_tra ON email_tra.id_entidade=transportadora.id AND email_tra.tipo_entidade='TRA' "
                . "INNER JOIN email email_usu ON email_usu.id_entidade=usuario.id AND email_usu.tipo_entidade='USU' "
                . "WHERE pedido.id_empresa = $this->id ";

        if ($filtro != "") {

            $sql .= " AND $filtro ";
        }

        $ps = $con->getConexao()->prepare($sql);

        $ps->execute();

        $ps->bind_result($qtd);

        if ($ps->fetch()) {

            $ps->close();

            return $qtd;
        }

        $ps->close();

        return 0;
    }

    public function getCampanhas($con, $x1, $x2, $filtro = "", $ordem = "") {

        $sql = "SELECT "
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
                . "produto.id,"
                . "produto.id_logistica,"
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
                . "categoria_produto.id,"
                . "categoria_produto.nome,"
                . "categoria_produto.base_calculo,"
                . "categoria_produto.ipi,"
                . "categoria_produto.icms_normal,"
                . "categoria_produto.icms,"
                . "empresa.id,"
                . "empresa.is_logistica,"
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
                . "FROM (SELECT * FROM campanha WHERE campanha.excluida=false AND campanha.id_empresa=$this->id ";

        if ($filtro != "") {

            $sql .= "AND $filtro ";
        }

        if ($ordem != "") {

            $sql .= "ORDER BY $ordem ";
        }

        $sql .= "LIMIT $x1, " . ($x2 - $x1);

        $sql .= ") campanha "
                . "INNER JOIN produto_campanha ON campanha.id = produto_campanha.id_campanha "
                . "INNER JOIN produto ON produto.id = produto_campanha.id_produto "
                . "INNER JOIN categoria_produto ON categoria_produto.id=produto.id_categoria "
                . "INNER JOIN empresa ON produto.id_empresa=empresa.id "
                . "INNER JOIN endereco ON endereco.id_entidade=empresa.id AND endereco.tipo_entidade='EMP' "
                . "INNER JOIN email ON email.id_entidade=empresa.id AND email.tipo_entidade='EMP' "
                . "INNER JOIN telefone ON telefone.id_entidade=empresa.id AND telefone.tipo_entidade='EMP' "
                . "INNER JOIN cidade ON endereco.id_cidade=cidade.id "
                . "INNER JOIN estado ON cidade.id_estado = estado.id ";

        if ($ordem != "") {

            $sql .= "ORDER BY $ordem ";
        }

        $campanhas = array();

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id, $camp_nome, $inicio, $fim, $prazo, $parcelas, $cliente, $id_produto_campanha, $id_produto, $validade, $limite, $valor, $id_pro,$id_log, $id_uni, $liq, $qtd_un, $hab, $vb, $cus, $pb, $pl, $est, $disp, $tr, $gr, $uni, $ncm, $nome, $lucro, $ativo, $conc, $cat_id, $cat_nom, $cat_bs, $cat_ipi, $cat_icms_normal, $cat_icms, $id_empresa, $is_logistica, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);



        $prods = array();
        $id_order = array();

        while ($ps->fetch()) {

            if (!isset($campanhas[$id])) {

                $id_order[] = $id;

                $campanhas[$id] = new Campanha();
                $campanhas[$id]->id = $id;
                $campanhas[$id]->nome = $camp_nome;
                $campanhas[$id]->inicio = $inicio;
                $campanhas[$id]->fim = $fim;
                $campanhas[$id]->prazo = $prazo;
                $campanhas[$id]->parcelas = $parcelas;
                $campanhas[$id]->cliente_expression = $cliente;


                $campanhas[$id]->empresa = $this;
            }

            $campanha = $campanhas[$id];

            $p = new ProdutoCampanha();
            $p->id = $id_produto_campanha;
            $p->validade = $validade;
            $p->limite = $limite;
            $p->valor = $valor;
            $p->campanha = $campanha;

            if (!isset($prods[$id_pro])) {

                $pro = new Produto();
                $pro->logistica = $id_log;
                $pro->id = $id_pro;
                $pro->nome = $nome;
                $pro->id_universal = $id_uni;
                $pro->liquido = $liq == 1;
                $pro->quantidade_unidade = $qtd_un;
                $pro->habilitado = $hab;
                $pro->valor_base = $vb;
                $pro->custo = $cus;
                $pro->ativo = $ativo;
                $pro->concentracao = $conc;
                $pro->peso_bruto = $pb;
                $pro->peso_liquido = $pl;
                $pro->estoque = $est;
                $pro->disponivel = $disp;
                $pro->transito = $tr;
                $pro->grade = new Grade($gr);
                $pro->unidade = $uni;
                $pro->ncm = $ncm;
                $pro->lucro_consignado = $lucro;

                $pro->categoria = new CategoriaProduto();

                $pro->categoria->id = $cat_id;
                $pro->categoria->nome = $cat_nom;
                $pro->categoria->base_calculo = $cat_bs;
                $pro->categoria->icms = $cat_icms;
                $pro->categoria->icms_normal = $cat_icms_normal;
                $pro->categoria->ipi = $cat_ipi;

                $empresa = new Empresa();

                if ($is_logistica == 1) {

                    $empresa = new Logistica();
                }

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


                $pro->empresa = $empresa;

                $prods[$id_pro] = $pro;
            }

            //----


            $campanhas[$id]->produtos[] = $p;

            $p->produto = $prods[$id_pro];

            $prods[$id_pro]->ofertas[] = $p;
        }

        $ps->close();

        foreach ($prods as $key => $value) {
            $value->logistica = Sistema::getLogisticaById($con, $value->logistica);
        }

        $real = array();

        foreach ($campanhas as $key => $value) {

            $real[] = $value;
        }

        return $real;
    }

    public function getCountCampanha($con, $filtro = "") {

        $sql = "SELECT COUNT(*) FROM campanha WHERE campanha.excluida=false AND campanha.id_empresa=$this->id ";

        if ($filtro != "") {

            $sql .= "AND $filtro ";
        }

        $ps = $con->getConexao()->prepare($sql);

        $ps->execute();

        $ps->bind_result($qtd);

        if ($ps->fetch()) {

            $ps->close();

            return $qtd;
        }

        $ps->close();

        return 0;
    }

    public function getGruposCidades($con, $x1, $x2, $filtro = "", $ordem = "") {

        $sql = "SELECT grupo_cidades.id,grupo_cidades.nome,cidade.id,cidade.nome,estado.id,estado.sigla FROM (SELECT * FROM grupo_cidades WHERE id_empresa = $this->id ";

        if ($filtro != "") {

            $sql .= "AND $filtro ";
        }

        if ($ordem != "") {

            $sql .= "ORDER BY $ordem ";
        }

        $sql .= "LIMIT $x1, " . ($x2 - $x1);


        $sql .= ") grupo_cidades LEFT JOIN grupo_cidade ON grupo_cidade.id_grupo=grupo_cidades.id LEFT JOIN cidade ON cidade.id=grupo_cidade.id_cidade LEFT JOIN estado ON estado.id=cidade.id_estado";

        $grupos = array();

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id, $nome, $id_cidade, $nome_cidade, $id_estado, $nome_estado);

        while ($ps->fetch()) {

            if (!isset($grupos[$id])) {

                $g = new GrupoCidades();

                $g->id = $id;
                $g->nome = $nome;
                $g->empresa = $this;
                $grupos[$id] = $g;
            }

            $c = new Cidade();
            $c->id = $id_cidade;
            $c->nome = $nome_cidade;

            $e = new Estado();
            $e->id = $id_estado;
            $e->sigla = $nome_estado;

            $c->estado = $e;

            $grupos[$id]->cidades[] = $c;
        }

        $ps->close();

        $real = array();

        foreach ($grupos as $key => $grupo) {

            $real[] = $grupo;
        }

        return $real;
    }

    public function getCountGruposCidades($con, $filtro = "") {

        $sql = "SELECT COUNT(*) FROM grupo_cidades WHERE id_empresa = $this->id ";

        if ($filtro != "") {

            $sql .= "AND $filtro";
        }

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($qtd);

        if ($ps->fetch()) {

            $ps->close();

            return $qtd;
        }

        $ps->close();

        return 0;
    }

    public function getMovimentos($con, $x1, $x2, $filtro = "", $ordem = "") {

        $sql = "SELECT "
                . "movimento.id,"
                . "UNIX_TIMESTAMP(movimento.data)*1000,"
                . "movimento.saldo_anterior,"
                . "movimento.valor,"
                . "movimento.juros,"
                . "movimento.descontos,"
                . "movimento.estorno,"
                . "vencimento.id,"
                . "vencimento.valor,"
                . "UNIX_TIMESTAMP(vencimento.data)*1000,"
                . "historico.id,"
                . "historico.nome,"
                . "operacao.id,"
                . "operacao.nome,"
                . "operacao.debito,"
                . "banco.id,"
                . "banco.nome,"
                . "banco.codigo,"
                . "banco.saldo,"
                . "banco.conta, "
                . "cliente.id, "
                . "cliente.razao_social, "
                . "cliente.nome_fantasia, "
                . "cliente.limite_credito, "
                . "UNIX_TIMESTAMP(cliente.inicio_limite)*1000, "
                . "UNIX_TIMESTAMP(cliente.termino_limite)*1000, "
                . "cliente.pessoa_fisica, "
                . "cliente.cpf, "
                . "cliente.cnpj, "
                . "cliente.rg, "
                . "cliente.inscricao_estadual, "
                . "cliente.suframado, "
                . "cliente.inscricao_suframa, "
                . "categoria_cliente.id, "
                . "categoria_cliente.nome, "
                . "endereco_cliente.id, "
                . "endereco_cliente.rua, "
                . "endereco_cliente.numero, "
                . "endereco_cliente.bairro, "
                . "endereco_cliente.cep, "
                . "cidade_cliente.id, "
                . "cidade_cliente.nome, "
                . "estado_cliente.id, "
                . "estado_cliente.sigla,"
                . "email_cliente.id,"
                . "email_cliente.endereco,"
                . "email_cliente.senha,"
                . "fornecedor.id, "
                . "fornecedor.nome,"
                . "fornecedor.cnpj,"
                . "fornecedor.habilitado,"
                . "fornecedor.inscricao_estadual,"
                . "endereco_fornecedor.id, "
                . "endereco_fornecedor.rua, "
                . "endereco_fornecedor.numero, "
                . "endereco_fornecedor.bairro, "
                . "endereco_fornecedor.cep, "
                . "cidade_fornecedor.id, "
                . "cidade_fornecedor.nome, "
                . "estado_fornecedor.id, "
                . "estado_fornecedor.sigla,"
                . "email_fornecedor.id,"
                . "email_fornecedor.endereco,"
                . "email_fornecedor.senha, "
                . "transportadora.id, "
                . "transportadora.razao_social, "
                . "transportadora.nome_fantasia, "
                . "transportadora.despacho, "
                . "transportadora.cnpj, "
                . "transportadora.habilitada, "
                . "transportadora.inscricao_estadual,"
                . "endereco_transportadora.id, "
                . "endereco_transportadora.rua, "
                . "endereco_transportadora.numero, "
                . "endereco_transportadora.bairro, "
                . "endereco_transportadora.cep, "
                . "cidade_transportadora.id, "
                . "cidade_transportadora.nome, "
                . "estado_transportadora.id, "
                . "estado_transportadora.sigla, "
                . "email_transportadora.id,"
                . "email_transportadora.endereco,"
                . "email_transportadora.senha, "
                . "nota.id,"
                . "nota.saida,"
                . "nota.chave,"
                . "nota.observacao,"
                . "UNIX_TIMESTAMP(nota.data_emissao)*1000,"
                . "nota.influenciar_estoque, "
                . "nota.id_forma_pagamento,"
                . "nota.frete_destinatario_remetente,"
                . "nota.emitida,"
                . "nota.danfe,"
                . "nota.xml,"
                . "nota.numero,"
                . "nota.ficha,"
                . "nota.cancelada,"
                . "nota.protocolo "
                . "FROM movimento "
                . "INNER JOIN vencimento ON vencimento.id=movimento.id_vencimento "
                . "INNER JOIN nota ON nota.id=vencimento.id_nota "
                . "INNER JOIN operacao ON movimento.id_operacao=operacao.id "
                . "INNER JOIN historico ON historico.id=movimento.id_historico "
                . "INNER JOIN banco ON banco.id=movimento.id_banco "
                . "LEFT JOIN cliente ON nota.id_cliente=cliente.id "
                . "LEFT JOIN categoria_cliente ON categoria_cliente.id = cliente.id_categoria "
                . "LEFT JOIN endereco endereco_cliente ON endereco_cliente.id_entidade=cliente.id AND endereco_cliente.tipo_entidade='CLI' "
                . "LEFT JOIN cidade cidade_cliente ON endereco_cliente.id_cidade=cidade_cliente.id "
                . "LEFT JOIN estado estado_cliente ON estado_cliente.id=cidade_cliente.id_estado "
                . "LEFT JOIN email email_cliente ON email_cliente.id_entidade = cliente.id AND email_cliente.tipo_entidade='CLI' "
                . "LEFT JOIN fornecedor ON nota.id_fornecedor=fornecedor.id "
                . "LEFT JOIN endereco endereco_fornecedor ON endereco_fornecedor.id_entidade=fornecedor.id AND endereco_fornecedor.tipo_entidade='FOR' "
                . "LEFT JOIN cidade cidade_fornecedor ON endereco_fornecedor.id_cidade=cidade_fornecedor.id "
                . "LEFT JOIN estado estado_fornecedor ON estado_fornecedor.id=cidade_fornecedor.id_estado "
                . "LEFT JOIN email email_fornecedor ON email_fornecedor.id_entidade = fornecedor.id AND email_fornecedor.tipo_entidade='FOR' "
                . "INNER JOIN transportadora ON nota.id_transportadora=transportadora.id "
                . "INNER JOIN endereco endereco_transportadora ON endereco_transportadora.id_entidade=transportadora.id AND endereco_transportadora.tipo_entidade='TRA' "
                . "INNER JOIN cidade cidade_transportadora ON endereco_transportadora.id_cidade=cidade_transportadora.id "
                . "INNER JOIN estado estado_transportadora ON estado_transportadora.id=cidade_transportadora.id_estado "
                . "INNER JOIN email email_transportadora ON email_transportadora.id_entidade = transportadora.id AND email_transportadora.tipo_entidade='TRA' "
                . "WHERE nota.id_empresa = $this->id ";

        if ($filtro != "") {

            $sql .= "AND $filtro ";
        }

        if ($ordem != "") {

            $sql .= "ORDER BY $ordem ";
        }

        $sql .= "LIMIT $x1, " . ($x2 - $x1);

        $transportadoras = array();
        $movimentos = array();
        $fornecedores = array();
        $clientes = array();

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id_mov, $data_mov, $saldo_mov, $valor_mov, $juros_mov, $desc_mov, $estorno, $id_venc, $val_venc, $data_venc, $hist_id, $hist_nom, $op_id, $op_nom, $op_deb, $ban_id, $ban_nom, $ban_cod, $ban_sal, $ban_con, $id_cliente, $nome_cliente, $nome_fantasia_cliente, $limite, $inicio, $fim, $pessoa_fisica, $cpf, $cnpj, $rg, $ie, $suf, $i_suf, $cat_id, $cat_nome, $end_cli_id, $end_cli_rua, $end_cli_numero, $end_cli_bairro, $end_cli_cep, $cid_cli_id, $cid_cli_nome, $est_cli_id, $est_cli_nome, $id_email_cliente, $end_email_cliente, $senh_email_cliente, $id_for, $nom_for, $cnpj_for, $hab_for, $ie_for, $end_for_id, $end_for_rua, $end_for_numero, $end_for_bairro, $end_for_cep, $cid_for_id, $cid_for_nome, $est_for_id, $est_for_nome, $id_email_for, $end_email_for, $sen_email_for, $tra_id, $tra_nome, $tra_nome_fantasia, $tra_despacho, $tra_cnpj, $tra_habilitada, $tra_ie, $end_tra_id, $end_tra_rua, $end_tra_numero, $end_tra_bairro, $end_tra_cep, $cid_tra_id, $cid_tra_nome, $est_tra_id, $est_tra_nome, $id_email_tra, $end_email_tra, $sen_email_tra, $id_nf, $sai_nf, $cha_nf, $obs_nf, $dt_nf, $nf_inf_est, $id_fp_nf, $fdr, $emitida, $danfe, $xml, $numero, $ficha, $cancelada, $protocolo);

        while ($ps->fetch()) {



            $m = new Movimento();
            $m->id = $id_mov;
            $m->data = $data_mov;
            $m->saldo_anterior = $saldo_mov;
            $m->valor = $valor_mov;
            $m->juros = $juros_mov;
            $m->descontos = $desc_mov;
            $m->estorno = $estorno;

            $v = new Vencimento();
            $v->id = $id_venc;
            $v->valor = $val_venc;
            $v->data = $data_venc;

            $v->movimento = $m;
            $m->vencimento = $v;

            $h = new Historico();
            $h->id = $hist_id;
            $h->nome = $hist_nom;

            $m->historico = $h;

            $o = new Operacao();
            $o->id = $op_id;
            $o->nome = $op_nom;
            $o->debito = $op_deb;

            $m->operacao = $o;

            $b = new Banco();
            $b->id = $ban_id;
            $b->nome = $ban_nom;
            $b->codigo = $ban_cod;
            $b->saldo = $ban_sal;
            $b->conta = $ban_con;
            $b->empresa = $this;

            $m->banco = $b;

            $cliente = null;

            if ($id_cliente != null) {

                $cliente = new Cliente();
                $cliente->id = $id_cliente;
                $cliente->cnpj = new CNPJ($cnpj);
                $cliente->cpf = new CPF($cpf);
                $cliente->rg = new RG($rg);
                $cliente->pessoa_fisica = $pessoa_fisica == 1;
                $cliente->nome_fantasia = $nome_fantasia_cliente;
                $cliente->razao_social = $nome_cliente;
                $cliente->empresa = $this;
                $cliente->email = new Email($end_email_cliente);
                $cliente->email->id = $id_email_cliente;
                $cliente->email->senha = $senh_email_cliente;
                $cliente->categoria = new CategoriaCliente();
                $cliente->categoria->id = $cat_id;
                $cliente->categoria->nome = $cat_nome;
                $cliente->inicio_limite = $inicio;
                $cliente->termino_limite = $fim;
                $cliente->limite_credito = $limite;
                $cliente->inscricao_suframa = $i_suf;
                $cliente->suframado = $suf == 1;
                $cliente->empresa = $this;
                $cliente->inscricao_estadual = $ie;

                $end = new Endereco();
                $end->id = $end_cli_id;
                $end->bairro = $end_cli_bairro;
                $end->cep = new CEP($end_cli_cep);
                $end->numero = $end_cli_numero;
                $end->rua = $end_cli_numero;

                $end->cidade = new Cidade();
                $end->cidade->id = $cid_cli_id;
                $end->cidade->nome = $cid_cli_nome;

                $end->cidade->estado = new Estado();
                $end->cidade->estado->id = $est_cli_id;
                $end->cidade->estado->sigla = $est_cli_nome;

                $cliente->endereco = $end;

                if (!isset($clientes[$cliente->id])) {

                    $clientes[$cliente->id] = array();
                }

                $clientes[$cliente->id][] = $cliente;
            }

            $fornecedor = null;

            if ($id_for != null) {

                $fornecedor = new Fornecedor();
                $fornecedor->id = $id_for;
                $fornecedor->nome = $nom_for;
                $fornecedor->habilitado = $hab_for == 1;
                $fornecedor->inscricao_estadual = $ie_for;
                $fornecedor->cnpj = new CNPJ($cnpj_for);
                $fornecedor->empresa = $this;
                $fornecedor->email = new Email($end_email_for);
                $fornecedor->email->id = $id_email_for;
                $fornecedor->email->senha = $sen_email_for;

                $end = new Endereco();
                $end->id = $end_for_id;
                $end->bairro = $end_for_bairro;
                $end->cep = new CEP($end_for_cep);
                $end->numero = $end_for_numero;
                $end->rua = $end_for_numero;

                $end->cidade = new Cidade();
                $end->cidade->id = $cid_for_id;
                $end->cidade->nome = $cid_for_nome;

                $end->cidade->estado = new Estado();
                $end->cidade->estado->id = $est_for_id;
                $end->cidade->estado->sigla = $est_for_nome;

                $fornecedor->endereco = $end;

                if (!isset($fornecedores[$fornecedor->id])) {

                    $fornecedores[$fornecedor->id] = array();
                }

                $fornecedores[$fornecedor->id][] = $fornecedor;
            }

            $transportadora = new Transportadora();
            $transportadora->id = $tra_id;
            $transportadora->cnpj = new CNPJ($tra_cnpj);
            $transportadora->despacho = $tra_despacho;
            $transportadora->email = new Email($end_email_tra);
            $transportadora->email->id = $id_email_tra;
            $transportadora->email->senha = $sen_email_tra;
            $transportadora->habilitada = $tra_habilitada == 1;
            $transportadora->inscricao_estadual = $tra_ie;
            $transportadora->nome_fantasia = $tra_nome_fantasia;
            $transportadora->razao_social = $tra_nome;
            $transportadora->empresa = $this;

            $end = new Endereco();
            $end->id = $end_tra_id;
            $end->bairro = $end_tra_bairro;
            $end->cep = new CEP($end_tra_cep);
            $end->numero = $end_tra_numero;
            $end->rua = $end_tra_rua;

            $end->cidade = new Cidade();
            $end->cidade->id = $cid_tra_id;
            $end->cidade->nome = $cid_tra_nome;

            $end->cidade->estado = new Estado();
            $end->cidade->estado->id = $est_tra_id;
            $end->cidade->estado->sigla = $est_tra_nome;

            $transportadora->endereco = $end;

            if (!isset($transportadoras[$transportadora->id])) {

                $transportadoras[$transportadora->id] = array();
            }

            $transportadoras[$transportadora->id][] = $transportadora;


            $nota = new Nota();
            $nota->id = $id_nf;
            $nota->chave = $cha_nf;
            $nota->data_emissao = $dt_nf;
            $nota->interferir_estoque = $nf_inf_est;
            $nota->observacao = $obs_nf;
            $nota->saida = $sai_nf == 1;
            $nota->cliente = $cliente;
            $nota->fornecedor = $fornecedor;
            $nota->transportadora = $transportadora;
            $nota->empresa = $this;

            $nota->frete_destinatario_remetente = $fdr == 1;
            $nota->emitida = $emitida == 1;
            $nota->danfe = $danfe;
            $nota->xml = $xml;
            $nota->numero = $numero;
            $nota->ficha = $ficha;
            $nota->cancelada = $cancelada == 1;
            $nota->protocolo = $protocolo;

            $formas = Sistema::getFormasPagamento();

            foreach ($formas as $key => $value) {
                if ($value->id == $id_fp_nf) {
                    $nota->forma_pagamento = $value;
                    break;
                }
            }

            $v->nota = $nota;

            $movimentos[] = $m;
        }

        //---------------------------

        $in_tra = "-1";
        $in_for = "-1";
        $in_cli = "-1";

        foreach ($clientes as $id => $cliente) {
            $in_cli .= ",";
            $in_cli .= $id;
        }

        foreach ($transportadoras as $id => $transportadora) {
            $in_tra .= ",";
            $in_tra .= $id;
        }

        foreach ($fornecedores as $id => $fornecedor) {
            $in_for .= ",";
            $in_for .= $id;
        }

        $ps = $con->getConexao()->prepare("SELECT telefone.id_entidade, telefone.tipo_entidade, telefone.id, telefone.numero FROM telefone WHERE (telefone.id_entidade IN($in_tra) AND telefone.tipo_entidade='TRA') OR (telefone.id_entidade IN ($in_cli) AND telefone.tipo_entidade='CLI') OR (telefone.id_entidade IN ($in_for) AND telefone.tipo_entidade='FOR') AND telefone.excluido = false");
        $ps->execute();
        $ps->bind_result($id_entidade, $tipo_entidade, $id, $numero);
        while ($ps->fetch()) {

            $v = $clientes;
            if ($tipo_entidade == 'TRA') {
                $v = $transportadoras;
            } else if ($tipo_entidade == 'FOR') {
                $v = $fornecedores;
            }

            $telefone = new Telefone();
            $telefone->id = $id;
            $telefone->numero = $numero;

            foreach ($v[$id_entidade] as $key => $ent) {

                $ent->telefones[] = $telefone;
            }
        }
        $ps->close();

        $ps = $con->getConexao()->prepare("SELECT tabela.id,tabela.nome,tabela.id_transportadora,regra_tabela.id,regra_tabela.condicional,regra_tabela.resultante FROM tabela INNER JOIN regra_tabela ON regra_tabela.id_tabela = tabela.id WHERE tabela.id_transportadora IN ($in_tra) AND tabela.excluida=false");
        $ps->execute();
        $ps->bind_result($id, $nome, $id_tra, $idr, $cond, $res);
        while ($ps->fetch()) {

            $ts = $transportadoras[$id_tra];

            foreach ($ts as $key => $t) {

                if ($t->tabela == null) {

                    $t->tabela = new Tabela();
                    $t->tabela->nome = $nome;
                    $t->tabela->id = $id;
                }

                $regra = new RegraTabela();
                $regra->id = $idr;
                $regra->condicional = $cond;
                $regra->resultante = $res;

                $t->tabela->regras[] = $regra;
            }
        }

        $ps->close();


        //---------------------------

        return $movimentos;
    }

    public function getCountMovimentos($con, $filtro = "") {

        $sql = "SELECT COUNT(*) "
                . "FROM movimento "
                . "INNER JOIN vencimento ON vencimento.id=movimento.id_vencimento "
                . "INNER JOIN nota ON nota.id=vencimento.id_nota "
                . "INNER JOIN operacao ON movimento.id_operacao=operacao.id "
                . "INNER JOIN historico ON historico.id=movimento.id_historico "
                . "INNER JOIN banco ON banco.id=movimento.id_banco "
                . "LEFT JOIN cliente ON nota.id_cliente=cliente.id "
                . "LEFT JOIN categoria_cliente ON categoria_cliente.id = cliente.id_categoria "
                . "LEFT JOIN endereco endereco_cliente ON endereco_cliente.id_entidade=cliente.id AND endereco_cliente.tipo_entidade='CLI' "
                . "LEFT JOIN cidade cidade_cliente ON endereco_cliente.id_cidade=cidade_cliente.id "
                . "LEFT JOIN estado estado_cliente ON estado_cliente.id=cidade_cliente.id_estado "
                . "LEFT JOIN email email_cliente ON email_cliente.id_entidade = cliente.id AND email_cliente.tipo_entidade='CLI' "
                . "LEFT JOIN fornecedor ON nota.id_fornecedor=fornecedor.id "
                . "LEFT JOIN endereco endereco_fornecedor ON endereco_fornecedor.id_entidade=fornecedor.id AND endereco_fornecedor.tipo_entidade='FOR' "
                . "LEFT JOIN cidade cidade_fornecedor ON endereco_fornecedor.id_cidade=cidade_fornecedor.id "
                . "LEFT JOIN estado estado_fornecedor ON estado_fornecedor.id=cidade_fornecedor.id_estado "
                . "LEFT JOIN email email_fornecedor ON email_fornecedor.id_entidade = fornecedor.id AND email_fornecedor.tipo_entidade='FOR' "
                . "INNER JOIN transportadora ON nota.id_transportadora=transportadora.id "
                . "INNER JOIN endereco endereco_transportadora ON endereco_transportadora.id_entidade=transportadora.id AND endereco_transportadora.tipo_entidade='TRA' "
                . "INNER JOIN cidade cidade_transportadora ON endereco_transportadora.id_cidade=cidade_transportadora.id "
                . "INNER JOIN estado estado_transportadora ON estado_transportadora.id=cidade_transportadora.id_estado "
                . "INNER JOIN email email_transportadora ON email_transportadora.id_entidade = transportadora.id AND email_transportadora.tipo_entidade='TRA' "
                . "WHERE nota.id_empresa = $this->id ";

        if ($filtro != "") {

            $sql .= "AND $filtro";
        }

        $ps = $con->getConexao()->prepare($sql);

        $ps->execute();
        $ps->bind_result($qtd);

        if ($ps->fetch()) {
            $ps->close();
            return $qtd;
        }
        $ps->close();
        return 0;
    }

    public function getNotas($con, $x1, $x2, $filtro = "", $ordem = "") {

        $sql = "SELECT "
                . "cliente.id, "
                . "cliente.razao_social, "
                . "cliente.nome_fantasia, "
                . "cliente.limite_credito, "
                . "UNIX_TIMESTAMP(cliente.inicio_limite)*1000, "
                . "UNIX_TIMESTAMP(cliente.termino_limite)*1000, "
                . "cliente.pessoa_fisica, "
                . "cliente.cpf, "
                . "cliente.cnpj, "
                . "cliente.rg, "
                . "cliente.inscricao_estadual, "
                . "cliente.suframado, "
                . "cliente.inscricao_suframa, "
                . "categoria_cliente.id, "
                . "categoria_cliente.nome, "
                . "endereco_cliente.id, "
                . "endereco_cliente.rua, "
                . "endereco_cliente.numero, "
                . "endereco_cliente.bairro, "
                . "endereco_cliente.cep, "
                . "cidade_cliente.id, "
                . "cidade_cliente.nome, "
                . "estado_cliente.id, "
                . "estado_cliente.sigla,"
                . "email_cliente.id,"
                . "email_cliente.endereco,"
                . "email_cliente.senha,"
                . "fornecedor.id, "
                . "fornecedor.nome,"
                . "fornecedor.cnpj,"
                . "fornecedor.habilitado,"
                . "fornecedor.inscricao_estadual,"
                . "endereco_fornecedor.id, "
                . "endereco_fornecedor.rua, "
                . "endereco_fornecedor.numero, "
                . "endereco_fornecedor.bairro, "
                . "endereco_fornecedor.cep, "
                . "cidade_fornecedor.id, "
                . "cidade_fornecedor.nome, "
                . "estado_fornecedor.id, "
                . "estado_fornecedor.sigla,"
                . "email_fornecedor.id,"
                . "email_fornecedor.endereco,"
                . "email_fornecedor.senha, "
                . "transportadora.id, "
                . "transportadora.razao_social, "
                . "transportadora.nome_fantasia, "
                . "transportadora.despacho, "
                . "transportadora.cnpj, "
                . "transportadora.habilitada, "
                . "transportadora.inscricao_estadual,"
                . "endereco_transportadora.id, "
                . "endereco_transportadora.rua, "
                . "endereco_transportadora.numero, "
                . "endereco_transportadora.bairro, "
                . "endereco_transportadora.cep, "
                . "cidade_transportadora.id, "
                . "cidade_transportadora.nome, "
                . "estado_transportadora.id, "
                . "estado_transportadora.sigla, "
                . "email_transportadora.id,"
                . "email_transportadora.endereco,"
                . "email_transportadora.senha, "
                . "nota.id,"
                . "nota.saida,"
                . "nota.chave,"
                . "nota.observacao,"
                . "nota.id_forma_pagamento,"
                . "UNIX_TIMESTAMP(nota.data_emissao)*1000,"
                . "nota.influenciar_estoque,"
                . "nota.frete_destinatario_remetente,"
                . "nota.emitida,"
                . "nota.danfe,"
                . "nota.xml,"
                . "nota.numero,"
                . "nota.ficha,"
                . "nota.cancelada,"
                . "nota.protocolo "
                . "FROM nota "
                . "LEFT JOIN cliente ON nota.id_cliente=cliente.id "
                . "LEFT JOIN categoria_cliente ON categoria_cliente.id = cliente.id_categoria "
                . "LEFT JOIN endereco endereco_cliente ON endereco_cliente.id_entidade=cliente.id AND endereco_cliente.tipo_entidade='CLI' "
                . "LEFT JOIN cidade cidade_cliente ON endereco_cliente.id_cidade=cidade_cliente.id "
                . "LEFT JOIN estado estado_cliente ON estado_cliente.id=cidade_cliente.id_estado "
                . "LEFT JOIN email email_cliente ON email_cliente.id_entidade = cliente.id AND email_cliente.tipo_entidade='CLI' "
                . "LEFT JOIN fornecedor ON nota.id_fornecedor=fornecedor.id "
                . "LEFT JOIN endereco endereco_fornecedor ON endereco_fornecedor.id_entidade=fornecedor.id AND endereco_fornecedor.tipo_entidade='FOR' "
                . "LEFT JOIN cidade cidade_fornecedor ON endereco_fornecedor.id_cidade=cidade_fornecedor.id "
                . "LEFT JOIN estado estado_fornecedor ON estado_fornecedor.id=cidade_fornecedor.id_estado "
                . "LEFT JOIN email email_fornecedor ON email_fornecedor.id_entidade = fornecedor.id AND email_fornecedor.tipo_entidade='FOR' "
                . "INNER JOIN transportadora ON nota.id_transportadora=transportadora.id "
                . "INNER JOIN endereco endereco_transportadora ON endereco_transportadora.id_entidade=transportadora.id AND endereco_transportadora.tipo_entidade='TRA' "
                . "INNER JOIN cidade cidade_transportadora ON endereco_transportadora.id_cidade=cidade_transportadora.id "
                . "INNER JOIN estado estado_transportadora ON estado_transportadora.id=cidade_transportadora.id_estado "
                . "INNER JOIN email email_transportadora ON email_transportadora.id_entidade = transportadora.id AND email_transportadora.tipo_entidade='TRA' "
                . "WHERE nota.id_empresa = $this->id AND nota.excluida = false ";

        if ($filtro != "") {

            $sql .= "AND $filtro ";
        }

        if ($ordem != "") {

            $sql .= "ORDER BY $ordem ";
        }

        $sql .= "LIMIT $x1, " . ($x2 - $x1);

        $transportadoras = array();
        $notas = array();
        $fornecedores = array();
        $clientes = array();

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id_cliente, $nome_cliente, $nome_fantasia_cliente, $limite, $inicio, $fim, $pessoa_fisica, $cpf, $cnpj, $rg, $ie, $suf, $i_suf, $cat_id, $cat_nome, $end_cli_id, $end_cli_rua, $end_cli_numero, $end_cli_bairro, $end_cli_cep, $cid_cli_id, $cid_cli_nome, $est_cli_id, $est_cli_nome, $id_email_cliente, $end_email_cliente, $senh_email_cliente, $id_for, $nom_for, $cnpj_for, $hab_for, $ie_for, $end_for_id, $end_for_rua, $end_for_numero, $end_for_bairro, $end_for_cep, $cid_for_id, $cid_for_nome, $est_for_id, $est_for_nome, $id_email_for, $end_email_for, $sen_email_for, $tra_id, $tra_nome, $tra_nome_fantasia, $tra_despacho, $tra_cnpj, $tra_habilitada, $tra_ie, $end_tra_id, $end_tra_rua, $end_tra_numero, $end_tra_bairro, $end_tra_cep, $cid_tra_id, $cid_tra_nome, $est_tra_id, $est_tra_nome, $id_email_tra, $end_email_tra, $sen_email_tra, $id_nf, $sai_nf, $cha_nf, $obs_nf, $id_pag_nf, $dt_nf, $nf_inf_est, $fdr, $emitida, $danfe, $xml, $numero, $ficha, $cancelada, $protocolo);

        while ($ps->fetch()) {

            $cliente = null;

            if ($id_cliente != null) {

                $cliente = new Cliente();
                $cliente->id = $id_cliente;
                $cliente->cnpj = new CNPJ($cnpj);
                $cliente->cpf = new CPF($cpf);
                $cliente->rg = new RG($rg);
                $cliente->pessoa_fisica = $pessoa_fisica == 1;
                $cliente->nome_fantasia = $nome_fantasia_cliente;
                $cliente->razao_social = $nome_cliente;
                $cliente->empresa = $this;
                $cliente->email = new Email($end_email_cliente);
                $cliente->email->id = $id_email_cliente;
                $cliente->email->senha = $senh_email_cliente;
                $cliente->categoria = new CategoriaCliente();
                $cliente->categoria->id = $cat_id;
                $cliente->categoria->nome = $cat_nome;
                $cliente->inicio_limite = $inicio;
                $cliente->termino_limite = $fim;
                $cliente->limite_credito = $limite;
                $cliente->inscricao_suframa = $i_suf;
                $cliente->suframado = $suf == 1;
                $cliente->empresa = $this;
                $cliente->inscricao_estadual = $ie;

                $end = new Endereco();
                $end->id = $end_cli_id;
                $end->bairro = $end_cli_bairro;
                $end->cep = new CEP($end_cli_cep);
                $end->numero = $end_cli_numero;
                $end->rua = $end_cli_numero;

                $end->cidade = new Cidade();
                $end->cidade->id = $cid_cli_id;
                $end->cidade->nome = $cid_cli_nome;

                $end->cidade->estado = new Estado();
                $end->cidade->estado->id = $est_cli_id;
                $end->cidade->estado->sigla = $est_cli_nome;

                $cliente->endereco = $end;

                if (!isset($clientes[$cliente->id])) {

                    $clientes[$cliente->id] = array();
                }

                $clientes[$cliente->id][] = $cliente;
            }

            $fornecedor = null;

            if ($id_for != null) {

                $fornecedor = new Fornecedor();
                $fornecedor->id = $id_for;
                $fornecedor->nome = $nom_for;
                $fornecedor->habilitado = $hab_for == 1;
                $fornecedor->inscricao_estadual = $ie_for;
                $fornecedor->cnpj = new CNPJ($cnpj_for);
                $fornecedor->empresa = $this;
                $fornecedor->email = new Email($end_email_for);
                $fornecedor->email->id = $id_email_for;
                $fornecedor->email->senha = $sen_email_for;

                $end = new Endereco();
                $end->id = $end_for_id;
                $end->bairro = $end_for_bairro;
                $end->cep = new CEP($end_for_cep);
                $end->numero = $end_for_numero;
                $end->rua = $end_for_numero;

                $end->cidade = new Cidade();
                $end->cidade->id = $cid_for_id;
                $end->cidade->nome = $cid_for_nome;

                $end->cidade->estado = new Estado();
                $end->cidade->estado->id = $est_for_id;
                $end->cidade->estado->sigla = $est_for_nome;

                $fornecedor->endereco = $end;

                if (!isset($fornecedores[$fornecedor->id])) {

                    $fornecedores[$fornecedor->id] = array();
                }

                $fornecedores[$fornecedor->id][] = $fornecedor;
            }

            $transportadora = new Transportadora();
            $transportadora->id = $tra_id;
            $transportadora->cnpj = new CNPJ($tra_cnpj);
            $transportadora->despacho = $tra_despacho;
            $transportadora->email = new Email($end_email_tra);
            $transportadora->email->id = $id_email_tra;
            $transportadora->email->senha = $sen_email_tra;
            $transportadora->habilitada = $tra_habilitada == 1;
            $transportadora->inscricao_estadual = $tra_ie;
            $transportadora->nome_fantasia = $tra_nome_fantasia;
            $transportadora->razao_social = $tra_nome;
            $transportadora->empresa = $this;

            $end = new Endereco();
            $end->id = $end_tra_id;
            $end->bairro = $end_tra_bairro;
            $end->cep = new CEP($end_tra_cep);
            $end->numero = $end_tra_numero;
            $end->rua = $end_tra_rua;

            $end->cidade = new Cidade();
            $end->cidade->id = $cid_tra_id;
            $end->cidade->nome = $cid_tra_nome;

            $end->cidade->estado = new Estado();
            $end->cidade->estado->id = $est_tra_id;
            $end->cidade->estado->sigla = $est_tra_nome;

            $transportadora->endereco = $end;

            if (!isset($transportadoras[$transportadora->id])) {

                $transportadoras[$transportadora->id] = array();
            }

            $transportadoras[$transportadora->id][] = $transportadora;


            $nota = new Nota();
            $nota->id = $id_nf;
            $nota->chave = $cha_nf;
            $nota->frete_destinatario_remetente = $fdr == 1;
            $nota->data_emissao = $dt_nf;
            $nota->interferir_estoque = $nf_inf_est;
            $nota->observacao = $obs_nf;
            $nota->saida = $sai_nf == 1;
            $nota->cliente = $cliente;
            $nota->fornecedor = $fornecedor;
            $nota->transportadora = $transportadora;
            $nota->empresa = $this;
            $nota->emitida = $emitida == 1;
            $nota->danfe = $danfe;
            $nota->xml = $xml;
            $nota->numero = $numero;
            $nota->ficha = $ficha;
            $nota->cancelada = $cancelada == 1;
            $nota->protocolo = $protocolo;

            $formas = Sistema::getFormasPagamento();

            foreach ($formas as $key => $value) {
                if ($value->id == $id_pag_nf) {
                    $nota->forma_pagamento = $value;
                    break;
                }
            }

            $notas[] = $nota;
        }

        //---------------------------

        $in_tra = "-1";
        $in_for = "-1";
        $in_cli = "-1";

        foreach ($clientes as $id => $cliente) {
            $in_cli .= ",";
            $in_cli .= $id;
        }

        foreach ($transportadoras as $id => $transportadora) {
            $in_tra .= ",";
            $in_tra .= $id;
        }

        foreach ($fornecedores as $id => $fornecedor) {
            $in_for .= ",";
            $in_for .= $id;
        }

        $ps = $con->getConexao()->prepare("SELECT telefone.id_entidade, telefone.tipo_entidade, telefone.id, telefone.numero FROM telefone WHERE (telefone.id_entidade IN($in_tra) AND telefone.tipo_entidade='TRA') OR (telefone.id_entidade IN ($in_cli) AND telefone.tipo_entidade='CLI') OR (telefone.id_entidade IN ($in_for) AND telefone.tipo_entidade='FOR') AND telefone.excluido = false");
        $ps->execute();
        $ps->bind_result($id_entidade, $tipo_entidade, $id, $numero);
        while ($ps->fetch()) {

            $v = $clientes;
            if ($tipo_entidade == 'TRA') {
                $v = $transportadoras;
            } else if ($tipo_entidade == 'FOR') {
                $v = $fornecedores;
            }

            $telefone = new Telefone();
            $telefone->id = $id;
            $telefone->numero = $numero;

            foreach ($v[$id_entidade] as $key => $ent) {

                $ent->telefones[] = $telefone;
            }
        }
        $ps->close();

        $ps = $con->getConexao()->prepare("SELECT tabela.id,tabela.nome,tabela.id_transportadora,regra_tabela.id,regra_tabela.condicional,regra_tabela.resultante FROM tabela INNER JOIN regra_tabela ON regra_tabela.id_tabela = tabela.id WHERE tabela.id_transportadora IN ($in_tra) AND tabela.excluida=false");
        $ps->execute();
        $ps->bind_result($id, $nome, $id_tra, $idr, $cond, $res);
        while ($ps->fetch()) {

            $ts = $transportadoras[$id_tra];

            foreach ($ts as $key => $t) {

                if ($t->tabela == null) {

                    $t->tabela = new Tabela();
                    $t->tabela->nome = $nome;
                    $t->tabela->id = $id;
                }

                $regra = new RegraTabela();
                $regra->id = $idr;
                $regra->condicional = $cond;
                $regra->resultante = $res;

                $t->tabela->regras[] = $regra;
            }
        }

        $ps->close();


        //---------------------------

        return $notas;
    }

    public function getCountNotas($con, $filtro = "") {

        $sql = "SELECT COUNT(*) "
                . "FROM nota "
                . "LEFT JOIN cliente ON nota.id_cliente=cliente.id "
                . "LEFT JOIN categoria_cliente ON categoria_cliente.id = cliente.id_categoria "
                . "LEFT JOIN endereco endereco_cliente ON endereco_cliente.id_entidade=cliente.id AND endereco_cliente.tipo_entidade='CLI' "
                . "LEFT JOIN cidade cidade_cliente ON endereco_cliente.id_cidade=cidade_cliente.id "
                . "LEFT JOIN estado estado_cliente ON estado_cliente.id=cidade_cliente.id_estado "
                . "LEFT JOIN email email_cliente ON email_cliente.id_entidade = cliente.id AND email_cliente.tipo_entidade='CLI' "
                . "LEFT JOIN fornecedor ON nota.id_fornecedor=fornecedor.id "
                . "LEFT JOIN endereco endereco_fornecedor ON endereco_fornecedor.id_entidade=fornecedor.id AND endereco_fornecedor.tipo_entidade='FOR' "
                . "LEFT JOIN cidade cidade_fornecedor ON endereco_fornecedor.id_cidade=cidade_fornecedor.id "
                . "LEFT JOIN estado estado_fornecedor ON estado_fornecedor.id=cidade_fornecedor.id_estado "
                . "LEFT JOIN email email_fornecedor ON email_fornecedor.id_entidade = fornecedor.id AND email_fornecedor.tipo_entidade='FOR' "
                . "INNER JOIN transportadora ON nota.id_transportadora=transportadora.id "
                . "INNER JOIN endereco endereco_transportadora ON endereco_transportadora.id_entidade=transportadora.id AND endereco_transportadora.tipo_entidade='TRA' "
                . "INNER JOIN cidade cidade_transportadora ON endereco_transportadora.id_cidade=cidade_transportadora.id "
                . "INNER JOIN estado estado_transportadora ON estado_transportadora.id=cidade_transportadora.id_estado "
                . "INNER JOIN email email_transportadora ON email_transportadora.id_entidade = transportadora.id AND email_transportadora.tipo_entidade='TRA' "
                . "WHERE nota.id_empresa = $this->id AND nota.excluida = false ";

        if ($filtro != "") {

            $sql .= "AND $filtro";
        }

        $ps = $con->getConexao()->prepare($sql);

        $ps->execute();
        $ps->bind_result($qtd);

        if ($ps->fetch()) {
            $ps->close();
            return $qtd;
        }
        $ps->close();
        return 0;
    }

    public function getPedidosEntrada($con, $x1, $x2, $filtro = "", $ordem = "") {

        $sql = "SELECT "
                . "pedido_entrada.id, "
                . "pedido_entrada.frete_inclusao, "
                . "UNIX_TIMESTAMP(pedido_entrada.data)*1000, "
                . "pedido_entrada.prazo, "
                . "pedido_entrada.parcelas, "
                . "pedido_entrada.id_status, "
                . "pedido_entrada.frete, "
                . "pedido_entrada.observacoes, "
                . "transportadora.id, "
                . "transportadora.razao_social, "
                . "transportadora.nome_fantasia, "
                . "transportadora.despacho, "
                . "transportadora.cnpj, "
                . "transportadora.habilitada, "
                . "transportadora.inscricao_estadual,"
                . "endereco_transportadora.id, "
                . "endereco_transportadora.rua, "
                . "endereco_transportadora.numero, "
                . "endereco_transportadora.bairro, "
                . "endereco_transportadora.cep, "
                . "cidade_transportadora.id, "
                . "cidade_transportadora.nome, "
                . "estado_transportadora.id, "
                . "estado_transportadora.sigla, "
                . "usuario.id, "
                . "usuario.nome, "
                . "usuario.login, "
                . "usuario.senha, "
                . "usuario.cpf, "
                . "endereco_usuario.id, "
                . "endereco_usuario.rua, "
                . "endereco_usuario.numero, "
                . "endereco_usuario.bairro, "
                . "endereco_usuario.cep, "
                . "cidade_usuario.id, "
                . "cidade_usuario.nome, "
                . "estado_usuario.id, "
                . "estado_usuario.sigla,"
                . "email_tra.id, "
                . "email_tra.endereco, "
                . "email_tra.senha, "
                . "email_usu.id, "
                . "email_usu.endereco,"
                . "email_usu.senha, "
                . "fornecedor.id, "
                . "fornecedor.nome,"
                . "fornecedor.cnpj,"
                . "fornecedor.habilitado,"
                . "fornecedor.inscricao_estadual,"
                . "endereco_fornecedor.id, "
                . "endereco_fornecedor.rua, "
                . "endereco_fornecedor.numero, "
                . "endereco_fornecedor.bairro, "
                . "endereco_fornecedor.cep, "
                . "cidade_fornecedor.id, "
                . "cidade_fornecedor.nome, "
                . "estado_fornecedor.id, "
                . "estado_fornecedor.sigla,"
                . "email_fornecedor.id,"
                . "email_fornecedor.endereco,"
                . "email_fornecedor.senha "
                . "FROM pedido_entrada "
                . "INNER JOIN fornecedor ON pedido_entrada.id_fornecedor=fornecedor.id "
                . "INNER JOIN endereco endereco_fornecedor ON endereco_fornecedor.id_entidade=fornecedor.id AND endereco_fornecedor.tipo_entidade='FOR' "
                . "INNER JOIN cidade cidade_fornecedor ON endereco_fornecedor.id_cidade=cidade_fornecedor.id "
                . "INNER JOIN estado estado_fornecedor ON estado_fornecedor.id=cidade_fornecedor.id_estado "
                . "INNER JOIN email email_fornecedor ON email_fornecedor.id_entidade = fornecedor.id AND email_fornecedor.tipo_entidade='FOR' "
                . "INNER JOIN transportadora ON transportadora.id = pedido_entrada.id_transportadora "
                . "INNER JOIN endereco endereco_transportadora ON endereco_transportadora.id_entidade=transportadora.id AND endereco_transportadora.tipo_entidade='TRA' "
                . "INNER JOIN cidade cidade_transportadora ON endereco_transportadora.id_cidade=cidade_transportadora.id "
                . "INNER JOIN estado estado_transportadora ON estado_transportadora.id=cidade_transportadora.id_estado "
                . "INNER JOIN usuario ON usuario.id=pedido_entrada.id_usuario "
                . "INNER JOIN endereco endereco_usuario ON endereco_usuario.id_entidade=usuario.id AND endereco_usuario.tipo_entidade='USU' "
                . "INNER JOIN cidade cidade_usuario ON endereco_usuario.id_cidade=cidade_usuario.id "
                . "INNER JOIN estado estado_usuario ON estado_usuario.id=cidade_usuario.id_estado "
                . "INNER JOIN email email_tra ON email_tra.id_entidade=transportadora.id AND email_tra.tipo_entidade='TRA' "
                . "INNER JOIN email email_usu ON email_usu.id_entidade=usuario.id AND email_usu.tipo_entidade='USU' "
                . "WHERE pedido_entrada.id_empresa = $this->id AND pedido_entrada.excluido = false ";

        if ($filtro != "") {

            $sql .= "AND $filtro ";
        }

        if ($ordem != "") {

            $sql .= "ORDER BY $ordem ";
        }

        $sql .= "LIMIT $x1, " . ($x2 - $x1);

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id_pedido, $frete_incluso, $data, $prazo, $parcelas, $id_status, $frete, $obs, $tra_id, $tra_nome, $tra_nome_fantasia, $tra_despacho, $tra_cnpj, $tra_habilitada, $tra_ie, $end_tra_id, $end_tra_rua, $end_tra_numero, $end_tra_bairro, $end_tra_cep, $cid_tra_id, $cid_tra_nome, $est_tra_id, $est_tra_nome, $id_usu, $nome_usu, $login_usu, $senha_usu, $cpf_usu, $end_usu_id, $end_usu_rua, $end_usu_numero, $end_usu_bairro, $end_usu_cep, $cid_usu_id, $cid_usu_nome, $est_usu_id, $est_usu_nome, $email_tra_id, $email_tra_end, $email_tra_senha, $email_usu_id, $email_usu_end, $email_usu_senha, $id_for, $nom_for, $cnpj_for, $hab_for, $ie_for, $end_for_id, $end_for_rua, $end_for_numero, $end_for_bairro, $end_for_cep, $cid_for_id, $cid_for_nome, $est_for_id, $est_for_nome, $id_email_for, $end_email_for, $sen_email_for);


        $pedidos = array();
        $transportadoras = array();
        $usuarios = array();
        $fornecedores = array();

        while ($ps->fetch()) {

            $fornecedor = new Fornecedor();
            $fornecedor->id = $id_for;
            $fornecedor->nome = $nom_for;
            $fornecedor->habilitado = $hab_for;
            $fornecedor->inscricao_estadual = $ie_for;
            $fornecedor->cnpj = new CNPJ($cnpj_for);
            $fornecedor->empresa = $this;
            $fornecedor->email = new Email($end_email_for);
            $fornecedor->email->id = $id_email_for;
            $fornecedor->email->senha = $sen_email_for;

            $end = new Endereco();
            $end->id = $end_for_id;
            $end->bairro = $end_for_bairro;
            $end->cep = new CEP($end_for_cep);
            $end->numero = $end_for_numero;
            $end->rua = $end_for_numero;

            $end->cidade = new Cidade();
            $end->cidade->id = $cid_for_id;
            $end->cidade->nome = $cid_for_nome;

            $end->cidade->estado = new Estado();
            $end->cidade->estado->id = $est_for_id;
            $end->cidade->estado->sigla = $est_for_nome;

            $fornecedor->endereco = $end;

            if (!isset($fornecedores[$fornecedor->id])) {

                $fornecedores[$fornecedor->id] = array();
            }

            $fornecedores[$fornecedor->id][] = $fornecedor;


            $transportadora = new Transportadora();
            $transportadora->id = $tra_id;
            $transportadora->cnpj = new CNPJ($tra_cnpj);
            $transportadora->despacho = $tra_despacho;
            $transportadora->email = new Email($email_tra_end);
            $transportadora->email->id = $email_tra_id;
            $transportadora->email->senha = $email_tra_senha;
            $transportadora->habilitada = $tra_habilitada == 1;
            $transportadora->inscricao_estadual = $tra_ie;
            $transportadora->nome_fantasia = $tra_nome_fantasia;
            $transportadora->razao_social = $tra_nome;
            $transportadora->empresa = $this;

            $end = new Endereco();
            $end->id = $end_tra_id;
            $end->bairro = $end_tra_bairro;
            $end->cep = new CEP($end_tra_cep);
            $end->numero = $end_tra_numero;
            $end->rua = $end_tra_rua;

            $end->cidade = new Cidade();
            $end->cidade->id = $cid_tra_id;
            $end->cidade->nome = $cid_tra_nome;

            $end->cidade->estado = new Estado();
            $end->cidade->estado->id = $est_tra_id;
            $end->cidade->estado->sigla = $est_tra_nome;

            $transportadora->endereco = $end;

            if (!isset($transportadoras[$transportadora->id])) {

                $transportadoras[$transportadora->id] = array();
            }

            $transportadoras[$transportadora->id][] = $transportadora;

            $usuario = new Usuario();

            $usuario->cpf = new CPF($cpf_usu);
            $usuario->email = new Email($email_usu_end);
            $usuario->email->id = $email_usu_id;
            $usuario->email->senha = $email_usu_senha;
            $usuario->empresa = $this;
            $usuario->id = $id_usu;
            $usuario->login = $login_usu;
            $usuario->senha = $senha_usu;
            $usuario->nome = $nome_usu;
            $usuario->empresa = $this;

            $end = new Endereco();
            $end->id = $end_usu_id;
            $end->bairro = $end_usu_bairro;
            $end->cep = new CEP($end_usu_cep);
            $end->numero = $end_usu_numero;
            $end->rua = $end_usu_numero;

            $end->cidade = new Cidade();
            $end->cidade->id = $cid_usu_id;
            $end->cidade->nome = $cid_usu_nome;

            $end->cidade->estado = new Estado();
            $end->cidade->estado->id = $est_usu_id;
            $end->cidade->estado->sigla = $est_usu_nome;

            $usuario->endereco = $end;

            if (!isset($usuarios[$usuario->id])) {

                $usuarios[$usuario->id] = array();
            }

            $usuarios[$usuario->id][] = $usuario;


            $pedido = new PedidoEntrada();

            $pedido->fornecedor = $fornecedor;
            $pedido->data = $data;
            $pedido->empresa = $this;
            $pedido->frete = $frete;
            $pedido->frete_incluso = $frete_incluso;
            $pedido->id = $id_pedido;
            $pedido->observacoes = $obs;
            $pedido->parcelas = $parcelas;
            $pedido->prazo = $prazo;

            $status = Sistema::getStatusPedidoEntrada();

            foreach ($status as $key => $st) {
                if ($st->id == $id_status) {
                    $pedido->status = $st;
                    break;
                }
            }

            $pedido->transportadora = $transportadora;

            $pedido->usuario = $usuario;

            $pedidos[] = $pedido;
        }

        $ps->close();

        $in_tra = "-1";
        $in_usu = "-1";
        $in_for = "-1";

        foreach ($fornecedores as $id => $fornecedor) {
            $in_for .= ",";
            $in_for .= $id;
        }

        foreach ($transportadoras as $id => $transportadora) {
            $in_tra .= ",";
            $in_tra .= $id;
        }

        foreach ($usuarios as $id => $usuario) {
            $in_usu .= ",";
            $in_usu .= $id;
        }

        $ps = $con->getConexao()->prepare("SELECT telefone.id_entidade, telefone.tipo_entidade, telefone.id, telefone.numero FROM telefone WHERE (telefone.id_entidade IN($in_tra) AND telefone.tipo_entidade='TRA') OR (telefone.id_entidade IN ($in_for) AND telefone.tipo_entidade='FOR') OR (telefone.id_entidade IN ($in_usu) AND telefone.tipo_entidade='USU') AND telefone.excluido = false");
        $ps->execute();
        $ps->bind_result($id_entidade, $tipo_entidade, $id, $numero);
        while ($ps->fetch()) {

            $v = $fornecedores;
            if ($tipo_entidade == 'TRA') {
                $v = $transportadoras;
            } else if ($tipo_entidade == 'USU') {
                $v = $usuarios;
            }

            $telefone = new Telefone();
            $telefone->id = $id;
            $telefone->numero = $numero;

            foreach ($v[$id_entidade] as $key => $ent) {

                $ent->telefones[] = $telefone;
            }
        }
        $ps->close();

        $ps = $con->getConexao()->prepare("SELECT tabela.id,tabela.nome,tabela.id_transportadora,regra_tabela.id,regra_tabela.condicional,regra_tabela.resultante FROM tabela INNER JOIN regra_tabela ON regra_tabela.id_tabela = tabela.id WHERE tabela.id_transportadora IN ($in_tra) AND tabela.excluida=false");
        $ps->execute();
        $ps->bind_result($id, $nome, $id_tra, $idr, $cond, $res);
        while ($ps->fetch()) {

            $ts = $transportadoras[$id_tra];

            foreach ($ts as $key => $t) {

                if ($t->tabela == null) {

                    $t->tabela = new Tabela();
                    $t->tabela->nome = $nome;
                    $t->tabela->id = $id;
                }

                $regra = new RegraTabela();
                $regra->id = $idr;
                $regra->condicional = $cond;
                $regra->resultante = $res;

                $t->tabela->regras[] = $regra;
            }
        }

        $ps->close();

        $permissoes = Sistema::getPermissoes();

        $ps = $con->getConexao()->prepare("SELECT id_usuario, id_permissao,incluir,deletar,alterar,consultar FROM usuario_permissao WHERE id_usuario IN ($in_usu)");
        $ps->execute();
        $ps->bind_result($id_usuario, $id_permissao, $incluir, $deletar, $alterar, $consultar);

        while ($ps->fetch()) {

            $p = null;

            foreach ($permissoes as $key => $perm) {
                if ($perm->id == $id_permissao) {
                    $p = $perm;
                    break;
                }
            }

            if ($p == null) {

                continue;
            }

            $p->alt = $alterar == 1;
            $p->in = $incluir == 1;
            $p->del = $deletar == 1;
            $p->cons = $consultar == 1;

            foreach ($usuarios[$id_usuario] as $key => $usu) {

                $usu->permissoes[] = $p;
            }
        }

        $ps->close();

        return $pedidos;
    }

    public function getCountPedidosEntrada($con, $filtro = "") {

        $sql = "SELECT COUNT(*) FROM pedido_entrada WHERE id_empresa=$this->id AND excluido=false ";

        if ($filtro != "") {

            $sql .= "AND $filtro";
        }

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($qtd);

        if ($ps->fetch()) {

            $ps->close();
            return $qtd;
        }

        $ps->close();

        return 0;
    }

    public function getFornecedores($con, $x1, $x2, $filtro = "", $ordem = "") {

        $sql = "SELECT "
                . "fornecedor.id, "
                . "fornecedor.nome,"
                . "fornecedor.cnpj,"
                . "fornecedor.habilitado,"
                . "fornecedor.inscricao_estadual,"
                . "endereco_fornecedor.id, "
                . "endereco_fornecedor.rua, "
                . "endereco_fornecedor.numero, "
                . "endereco_fornecedor.bairro, "
                . "endereco_fornecedor.cep, "
                . "cidade_fornecedor.id, "
                . "cidade_fornecedor.nome, "
                . "estado_fornecedor.id, "
                . "estado_fornecedor.sigla,"
                . "email_fornecedor.id,"
                . "email_fornecedor.endereco,"
                . "email_fornecedor.senha "
                . "FROM fornecedor "
                . "INNER JOIN endereco endereco_fornecedor ON endereco_fornecedor.id_entidade=fornecedor.id AND endereco_fornecedor.tipo_entidade='FOR' "
                . "INNER JOIN cidade cidade_fornecedor ON endereco_fornecedor.id_cidade=cidade_fornecedor.id "
                . "INNER JOIN estado estado_fornecedor ON estado_fornecedor.id=cidade_fornecedor.id_estado "
                . "INNER JOIN email email_fornecedor ON email_fornecedor.id_entidade = fornecedor.id AND email_fornecedor.tipo_entidade='FOR' "
                . "WHERE fornecedor.id_empresa=$this->id AND fornecedor.excluido = false ";

        if ($filtro != "") {

            $sql .= "AND $filtro ";
        }

        if ($ordem != "") {

            $sql .= "ORDER BY $ordem ";
        }

        $sql .= "LIMIT $x1, " . ($x2 - $x1);

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id_for, $nom_for, $cnpj_for, $hab, $ie, $end_for_id, $end_for_rua, $end_for_numero, $end_for_bairro, $end_for_cep, $cid_for_id, $cid_for_nome, $est_for_id, $est_for_nome, $id_email_for, $end_email_for, $sen_email_for);

        $fornecedores = array();

        while ($ps->fetch()) {

            $fornecedor = new Fornecedor();
            $fornecedor->id = $id_for;
            $fornecedor->habilitado = $hab == 1;
            $fornecedor->inscricao_estadual = $ie;
            $fornecedor->nome = $nom_for;
            $fornecedor->cnpj = new CNPJ($cnpj_for);
            $fornecedor->empresa = $this;
            $fornecedor->email = new Email($end_email_for);
            $fornecedor->email->id = $id_email_for;
            $fornecedor->email->senha = $sen_email_for;

            $end = new Endereco();
            $end->id = $end_for_id;
            $end->bairro = $end_for_bairro;
            $end->cep = new CEP($end_for_cep);
            $end->numero = $end_for_numero;
            $end->rua = $end_for_numero;

            $end->cidade = new Cidade();
            $end->cidade->id = $cid_for_id;
            $end->cidade->nome = $cid_for_nome;

            $end->cidade->estado = new Estado();
            $end->cidade->estado->id = $est_for_id;
            $end->cidade->estado->sigla = $est_for_nome;

            $fornecedor->endereco = $end;

            $fornecedores[$id_for] = $fornecedor;
        }

        $ps->close();

        $in_for = "-1";

        foreach ($fornecedores as $id => $fornecedor) {
            $in_for .= ",";
            $in_for .= $id;
        }

        $ps = $con->getConexao()->prepare("SELECT telefone.id_entidade, telefone.tipo_entidade, telefone.id, telefone.numero FROM telefone WHERE (telefone.id_entidade IN ($in_for) AND telefone.tipo_entidade='FOR') AND telefone.excluido = false");
        $ps->execute();
        $ps->bind_result($id_entidade, $tipo_entidade, $id, $numero);
        while ($ps->fetch()) {

            $v = $fornecedores;

            $telefone = new Telefone();
            $telefone->id = $id;
            $telefone->numero = $numero;

            foreach ($v[$id_entidade] as $key => $ent) {

                $ent->telefones[] = $telefone;
            }
        }
        $ps->close();


        $real = array();

        foreach ($fornecedores as $key => $value) {

            $real[] = $value;
        }

        return $real;
    }

    public function getCountFornecedores($con, $filtro = "") {

        $sql = "SELECT COUNT(*) FROM fornecedor LEFT JOIN email email_fornecedor ON email_fornecedor.id_entidade=fornecedor.id AND email_fornecedor.tipo_entidade='FOR' WHERE fornecedor.id_empresa=$this->id AND fornecedor.excluido=false ";

        if ($filtro != "") {

            $sql .= "AND $filtro";
        }

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($qtd);

        if ($ps->fetch()) {

            $ps->close();
            return $qtd;
        }

        $ps->close();

        return 0;
    }

    public function getCotacoesEntrada($con, $x1, $x2, $filtro = "", $ordem = "") {

        $sql = "SELECT "
                . "cotacao_entrada.id,"
                . "cotacao_entrada.observacao,"
                . "cotacao_entrada.frete, "
                . "UNIX_TIMESTAMP(cotacao_entrada.data)*1000, "
                . "cotacao_entrada.tratar_em_litros, "
                . "cotacao_entrada.id_status, "
                . "usuario.id, "
                . "usuario.nome, "
                . "usuario.login, "
                . "usuario.senha, "
                . "usuario.cpf, "
                . "endereco_usuario.id, "
                . "endereco_usuario.rua, "
                . "endereco_usuario.numero, "
                . "endereco_usuario.bairro, "
                . "endereco_usuario.cep, "
                . "cidade_usuario.id, "
                . "cidade_usuario.nome, "
                . "estado_usuario.id, "
                . "estado_usuario.sigla,"
                . "email_usu.id, "
                . "email_usu.endereco,"
                . "email_usu.senha, "
                . "fornecedor.id, "
                . "fornecedor.nome,"
                . "fornecedor.cnpj,"
                . "fornecedor.habilitado,"
                . "fornecedor.inscricao_estadual,"
                . "endereco_fornecedor.id, "
                . "endereco_fornecedor.rua, "
                . "endereco_fornecedor.numero, "
                . "endereco_fornecedor.bairro, "
                . "endereco_fornecedor.cep, "
                . "cidade_fornecedor.id, "
                . "cidade_fornecedor.nome, "
                . "estado_fornecedor.id, "
                . "estado_fornecedor.sigla,"
                . "email_fornecedor.id,"
                . "email_fornecedor.endereco,"
                . "email_fornecedor.senha "
                . "FROM cotacao_entrada "
                . "INNER JOIN fornecedor ON cotacao_entrada.id_fornecedor=fornecedor.id "
                . "INNER JOIN endereco endereco_fornecedor ON endereco_fornecedor.id_entidade=fornecedor.id AND endereco_fornecedor.tipo_entidade='FOR' "
                . "INNER JOIN cidade cidade_fornecedor ON endereco_fornecedor.id_cidade=cidade_fornecedor.id "
                . "INNER JOIN estado estado_fornecedor ON estado_fornecedor.id=cidade_fornecedor.id_estado "
                . "INNER JOIN email email_fornecedor ON email_fornecedor.id_entidade = fornecedor.id AND email_fornecedor.tipo_entidade='FOR' "
                . "INNER JOIN usuario ON usuario.id=cotacao_entrada.id_usuario "
                . "INNER JOIN endereco endereco_usuario ON endereco_usuario.id_entidade=usuario.id AND endereco_usuario.tipo_entidade='USU' "
                . "INNER JOIN cidade cidade_usuario ON endereco_usuario.id_cidade=cidade_usuario.id "
                . "INNER JOIN estado estado_usuario ON estado_usuario.id=cidade_usuario.id_estado "
                . "INNER JOIN email email_usu ON email_usu.id_entidade=usuario.id AND email_usu.tipo_entidade='USU' "
                . "WHERE cotacao_entrada.id_empresa = $this->id AND cotacao_entrada.excluida = false ";

        if ($filtro != "") {

            $sql .= "AND $filtro ";
        }

        if ($ordem != "") {

            $sql .= "ORDER BY $ordem ";
        }

        $sql .= "LIMIT $x1, " . ($x2 - $x1);



        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id_cotacao, $obs, $frete, $data, $em_litros, $id_status, $id_usu, $nome_usu, $login_usu, $senha_usu, $cpf_usu, $end_usu_id, $end_usu_rua, $end_usu_numero, $end_usu_bairro, $end_usu_cep, $cid_usu_id, $cid_usu_nome, $est_usu_id, $est_usu_nome, $email_usu_id, $email_usu_end, $email_usu_senha, $id_for, $nom_for, $cnpj_for, $hab, $ie, $end_for_id, $end_for_rua, $end_for_numero, $end_for_bairro, $end_for_cep, $cid_for_id, $cid_for_nome, $est_for_id, $est_for_nome, $id_email_for, $end_email_for, $sen_email_for);

        $cotacoes = array();
        $usuarios = array();
        $fornecedores = array();

        while ($ps->fetch()) {

            $fornecedor = new Fornecedor();
            $fornecedor->id = $id_for;
            $fornecedor->nome = $nom_for;
            $fornecedor->habilitado = $hab == 1;
            $fornecedor->inscricao_estadual = $ie;
            $fornecedor->cnpj = new CNPJ($cnpj_for);
            $fornecedor->empresa = $this;
            $fornecedor->email = new Email($end_email_for);
            $fornecedor->email->id = $id_email_for;
            $fornecedor->email->senha = $sen_email_for;

            $end = new Endereco();
            $end->id = $end_for_id;
            $end->bairro = $end_for_bairro;
            $end->cep = new CEP($end_for_cep);
            $end->numero = $end_for_numero;
            $end->rua = $end_for_numero;

            $end->cidade = new Cidade();
            $end->cidade->id = $cid_for_id;
            $end->cidade->nome = $cid_for_nome;

            $end->cidade->estado = new Estado();
            $end->cidade->estado->id = $est_for_id;
            $end->cidade->estado->sigla = $est_for_nome;

            $fornecedor->endereco = $end;

            if (!isset($fornecedores[$fornecedor->id])) {

                $fornecedores[$fornecedor->id] = array();
            }

            $fornecedores[$fornecedor->id][] = $fornecedor;

            $usuario = new Usuario();

            $usuario->cpf = new CPF($cpf_usu);
            $usuario->email = new Email($email_usu_end);
            $usuario->email->id = $email_usu_id;
            $usuario->email->senha = $email_usu_senha;
            $usuario->empresa = $this;
            $usuario->id = $id_usu;
            $usuario->login = $login_usu;
            $usuario->senha = $senha_usu;
            $usuario->nome = $nome_usu;
            $usuario->empresa = $this;

            $end = new Endereco();
            $end->id = $end_usu_id;
            $end->bairro = $end_usu_bairro;
            $end->cep = new CEP($end_usu_cep);
            $end->numero = $end_usu_numero;
            $end->rua = $end_usu_numero;

            $end->cidade = new Cidade();
            $end->cidade->id = $cid_usu_id;
            $end->cidade->nome = $cid_usu_nome;

            $end->cidade->estado = new Estado();
            $end->cidade->estado->id = $est_usu_id;
            $end->cidade->estado->sigla = $est_usu_nome;

            $usuario->endereco = $end;

            if (!isset($usuarios[$usuario->id])) {

                $usuarios[$usuario->id] = array();
            }

            $usuarios[$usuario->id][] = $usuario;


            $cotacao = new CotacaoEntrada();

            $cotacao->id = $id_cotacao;
            $cotacao->observacao = $obs;
            $cotacao->fornecedor = $fornecedor;
            $cotacao->data = $data;
            $cotacao->empresa = $this;
            $cotacao->frete = $frete;
            $cotacao->tratar_em_litros = $em_litros;

            $status = Sistema::getStatusCotacaoEntrada();

            foreach ($status as $key => $st) {
                if ($st->id == $id_status) {
                    $cotacao->status = $st;
                    break;
                }
            }

            $cotacao->usuario = $usuario;

            $cotacoes[] = $cotacao;
        }

        $ps->close();

        $in_usu = "-1";
        $in_for = "-1";

        foreach ($fornecedores as $id => $fornecedor) {
            $in_for .= ",";
            $in_for .= $id;
        }

        foreach ($usuarios as $id => $usuario) {
            $in_usu .= ",";
            $in_usu .= $id;
        }

        $ps = $con->getConexao()->prepare("SELECT telefone.id_entidade, telefone.tipo_entidade, telefone.id, telefone.numero FROM telefone WHERE (telefone.id_entidade IN ($in_for) AND telefone.tipo_entidade='FOR') OR (telefone.id_entidade IN ($in_usu) AND telefone.tipo_entidade='USU') AND telefone.excluido = false");
        $ps->execute();
        $ps->bind_result($id_entidade, $tipo_entidade, $id, $numero);
        while ($ps->fetch()) {

            $v = $fornecedores;
            if ($tipo_entidade == 'USU') {
                $v = $usuarios;
            }

            $telefone = new Telefone();
            $telefone->id = $id;
            $telefone->numero = $numero;

            foreach ($v[$id_entidade] as $key => $ent) {

                $ent->telefones[] = $telefone;
            }
        }
        $ps->close();

        $permissoes = Sistema::getPermissoes();

        $ps = $con->getConexao()->prepare("SELECT id_usuario, id_permissao,incluir,deletar,alterar,consultar FROM usuario_permissao WHERE id_usuario IN ($in_usu)");
        $ps->execute();
        $ps->bind_result($id_usuario, $id_permissao, $incluir, $deletar, $alterar, $consultar);

        while ($ps->fetch()) {

            $p = null;

            foreach ($permissoes as $key => $perm) {
                if ($perm->id == $id_permissao) {
                    $p = $perm;
                    break;
                }
            }

            if ($p == null) {

                continue;
            }

            $p->alt = $alterar == 1;
            $p->in = $incluir == 1;
            $p->del = $deletar == 1;
            $p->cons = $consultar == 1;

            foreach ($usuarios[$id_usuario] as $key => $usu) {

                $usu->permissoes[] = $p;
            }
        }

        $ps->close();

        return $cotacoes;
    }

    public function getCountCotacoesEntrada($con, $filtro = "") {

        $sql = "SELECT COUNT(*) FROM cotacao_entrada WHERE id_empresa=$this->id AND excluida = false ";

        if ($filtro != "") {

            $sql .= "AND $filtro";
        }

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($qtd);

        if ($ps->fetch()) {

            $ps->close();

            return $qtd;
        }

        $ps->close();

        return 0;
    }

    public function getProdutos($con, $x1, $x2, $filtro = "", $ordem = "") {

        $campanhas = array();
        $ofertas = array();

        $ps = $con->getConexao()->prepare("SELECT "
                . "campanha.id,"
                . "campanha.inicio,"
                . "campanha.fim,"
                . "campanha.prazo,"
                . "campanha.parcelas,"
                . "campanha.cliente_expression,"
                . "produto_campanha.id,"
                . "produto_campanha.id_produto,"
                . "UNIX_TIMESTAMP(produto_campanha.validade)*1000,"
                . "produto_campanha.limite,"
                . "produto_campanha.valor, "
                . "empresa.id,"
                . "empresa.is_logistica,"
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
        $ps->bind_result($id, $inicio, $fim, $prazo, $parcelas, $cliente, $id_produto_campanha, $id_produto, $validade, $limite, $valor, $id_empresa, $is_logistica, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        while ($ps->fetch()) {

            if (!isset($campanhas[$id])) {

                $campanhas[$id] = new Campanha();
                $campanhas[$id]->id = $id;
                $campanhas[$id]->inicio = $inicio;
                $campanhas[$id]->fim = $fim;
                $campanhas[$id]->prazo = $prazo;
                $campanhas[$id]->parcelas = $parcelas;
                $campanhas[$id]->cliente_expression = $cliente;

                $empresa = new Empresa();

                if ($is_logistica == 1) {

                    $empresa = new Logistica();
                }

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


        $sql = "SELECT "
                . "produto.id,"
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
                . "categoria_produto.id,"
                . "categoria_produto.nome,"
                . "categoria_produto.base_calculo,"
                . "categoria_produto.ipi,"
                . "categoria_produto.icms_normal,"
                . "categoria_produto.icms "
                . "FROM produto "
                . "INNER JOIN categoria_produto ON categoria_produto.id=produto.id_categoria "
                . "WHERE produto.id_empresa = $this->id AND produto.excluido = false ";


        if ($filtro != "") {

            $sql .= "AND $filtro ";
        }

        if ($ordem != "") {

            $sql .= "ORDER BY $ordem ";
        }

        $produtos = array();

        $sql .= "LIMIT $x1, " . ($x2 - $x1);


        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id_pro, $id_log, $classe_risco, $fabricante, $imagem, $id_uni, $liq, $qtd_un, $hab, $vb, $cus, $pb, $pl, $est, $disp, $tr, $gr, $uni, $ncm, $nome, $lucro, $ativo, $conc, $sistema_lotes, $nota_usuario, $cat_id, $cat_nom, $cat_bs, $cat_ipi, $cat_icms_normal, $cat_icms);

        while ($ps->fetch()) {

            $p = new Produto();

            $p->logistica = $id_log;

            $p->id = $id_pro;
            $p->classe_risco = $classe_risco;
            $p->fabricante = $fabricante;
            $p->imagem = $imagem;
            $p->nome = $nome;
            $p->id_universal = $id_uni;
            $p->sistema_lotes = $sistema_lotes == 1;
            $p->nota_usuario = $nota_usuario;
            $p->liquido = $liq == 1;
            $p->quantidade_unidade = $qtd_un;
            $p->habilitado = $hab;
            $p->valor_base = $vb;
            $p->custo = $cus;
            $p->peso_bruto = $pb;
            $p->peso_liquido = $pl;
            $p->estoque = $est;
            $p->disponivel = $disp;
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

            $p->categoria = new CategoriaProduto();

            $p->categoria->id = $cat_id;
            $p->categoria->nome = $cat_nom;
            $p->categoria->base_calculo = $cat_bs;
            $p->categoria->icms = $cat_icms;
            $p->categoria->icms_normal = $cat_icms_normal;
            $p->categoria->ipi = $cat_ipi;

            $p->empresa = $this;

            $produtos[] = $p;
        }

        $ps->close();

        foreach ($produtos as $key => $value) {

            $value->logistica = Sistema::getLogisticaById($con, $value->logistica);
        }

        return $produtos;
    }

    public function getCountProdutos($con, $filtro = "") {

        $sql = "SELECT COUNT(*) FROM produto INNER JOIN categoria_produto ON categoria_produto.id=produto.id_categoria WHERE produto.id_empresa=$this->id AND produto.excluido=false ";

        if ($filtro != "") {

            $sql .= "AND $filtro";
        }

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($qtd);

        if ($ps->fetch()) {

            $ps->close();
            return $qtd;
        }

        $ps->close();
        return 0;
    }

    public function getReceituario($con, $x1, $x2, $filtro = "", $ordem = "", $group = "") {


        $campanhas = array();
        $ofertas = array();

        $ps = $con->getConexao()->prepare("SELECT "
                . "campanha.id,"
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
                . "empresa.is_logistica,"
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
        $ps->bind_result($id, $inicio, $fim, $prazo, $parcelas, $cliente, $id_produto_campanha, $id_produto, $validade, $limite, $valor, $id_empresa, $is_logistica, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        while ($ps->fetch()) {

            if (!isset($campanhas[$id])) {

                $campanhas[$id] = new Campanha();
                $campanhas[$id]->id = $id;
                $campanhas[$id]->inicio = $inicio;
                $campanhas[$id]->fim = $fim;
                $campanhas[$id]->prazo = $prazo;
                $campanhas[$id]->parcelas = $parcelas;
                $campanhas[$id]->cliente_expression = $cliente;

                $empresa = new Empresa();

                if ($is_logistica == 1) {

                    $empresa = new Logistica();
                }

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

        $receituarios = array();

        $sql = "SELECT "
                . "produto.id,"
                . "produto.id_logistica,"
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
                . "categoria_produto.id,"
                . "categoria_produto.nome,"
                . "categoria_produto.base_calculo,"
                . "categoria_produto.ipi,"
                . "categoria_produto.icms_normal,"
                . "categoria_produto.icms,"
                . "receituario.id, "
                . "receituario.instrucoes,"
                . "cultura.id,"
                . "cultura.nome,"
                . "praga.id,"
                . "praga.nome "
                . "FROM produto "
                . "INNER JOIN categoria_produto ON categoria_produto.id=produto.id_categoria "
                . "INNER JOIN receituario ON receituario.id_produto=produto.id "
                . "INNER JOIN praga ON receituario.id_praga = praga.id "
                . "INNER JOIN cultura ON receituario.id_cultura = cultura.id "
                . "WHERE receituario.excluido = false AND produto.id_empresa = $this->id ";

        if ($filtro != "") {

            $sql .= "AND $filtro ";
        }

        if ($group != "") {

            $sql .= "GROUP BY $group ";
        }

        if ($ordem != "") {

            $sql .= "ORDER BY $ordem ";
        }

        $produtos = array();

        $sql .= "LIMIT $x1, " . ($x2 - $x1);

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id_pro, $id_log, $id_uni, $liq, $qtd_un, $hab, $vb, $cus, $pb, $pl, $est, $disp, $tr, $gr, $uni, $ncm, $nome, $lucro, $ativo, $conc, $sistema_lotes, $nota_usuario, $cat_id, $cat_nom, $cat_bs, $cat_ipi, $cat_icms_normal, $cat_icms, $rec_id, $rec_ins, $cul_id, $cul_nom, $prag_id, $prag_nom);

        while ($ps->fetch()) {

            $p = new Produto();
            $p->logistica = $id_log;
            $p->id = $id_pro;
            $p->nome = $nome;
            $p->id_universal = $id_uni;
            $p->liquido = $liq == 1;
            $p->quantidade_unidade = $qtd_un;
            $p->habilitado = $hab;
            $p->valor_base = $vb;
            $p->custo = $cus;
            $p->peso_bruto = $pb;
            $p->peso_liquido = $pl;
            $p->estoque = $est;
            $p->disponivel = $disp;
            $p->sistema_lotes = $sistema_lotes == 1;
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

            $p->categoria = new CategoriaProduto();

            $p->categoria->id = $cat_id;
            $p->categoria->nome = $cat_nom;
            $p->categoria->base_calculo = $cat_bs;
            $p->categoria->icms = $cat_icms;
            $p->categoria->icms_normal = $cat_icms_normal;
            $p->categoria->ipi = $cat_ipi;

            $p->empresa = $this;

            $rec = new Receituario();
            $rec->id = $rec_id;
            $rec->instrucoes = $rec_ins;

            $cult = new Cultura();
            $cult->id = $cul_id;
            $cult->nome = $cul_nom;

            $prag = new Praga();
            $prag->id = $prag_id;
            $prag->nome = $prag_nom;

            $rec->cultura = $cult;
            $rec->praga = $prag;
            $rec->produto = $p;

            $receituarios[] = $rec;
        }

        $ps->close();

        foreach ($receituarios as $key => $value) {
            $value->produto->logistica = Sistema::getLogisticaById($con, $value->produto->logistica);
        }

        return $receituarios;
    }

    public function getCountReceituario($con, $filtro = "", $group = "") {

        $sql = "SELECT COUNT(*) FROM (SELECT receituario.id FROM receituario INNER JOIN produto ON produto.id=receituario.id_produto INNER JOIN cultura ON cultura.id=receituario.id_cultura INNER JOIN praga ON receituario.id_praga=praga.id WHERE receituario.excluido=false AND produto.id_empresa=$this->id";

        if ($filtro != "") {

            $sql .= " AND $filtro";
        }

        if ($group != "") {

            $sql .= " GROUP BY $group";
        }

        $sql .= ") k";

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($qtd);

        if ($ps->fetch()) {

            $ps->close();
            return $qtd;
        }

        $ps->close();

        return 0;
    }

    public function getTransportadoras($con, $x1, $x2, $filtro = "", $ordem = "") {

        $sql = "SELECT "
                . "transportadora.id, "
                . "transportadora.razao_social, "
                . "transportadora.nome_fantasia, "
                . "transportadora.despacho, "
                . "transportadora.cnpj, "
                . "transportadora.habilitada, "
                . "transportadora.inscricao_estadual,"
                . "endereco_transportadora.id, "
                . "endereco_transportadora.rua, "
                . "endereco_transportadora.numero, "
                . "endereco_transportadora.bairro, "
                . "endereco_transportadora.cep, "
                . "cidade_transportadora.id, "
                . "cidade_transportadora.nome, "
                . "estado_transportadora.id, "
                . "estado_transportadora.sigla, "
                . "email_transportadora.id,"
                . "email_transportadora.endereco,"
                . "email_transportadora.senha "
                . "FROM transportadora "
                . "INNER JOIN endereco endereco_transportadora ON endereco_transportadora.id_entidade=transportadora.id AND endereco_transportadora.tipo_entidade='TRA' "
                . "INNER JOIN cidade cidade_transportadora ON endereco_transportadora.id_cidade=cidade_transportadora.id "
                . "INNER JOIN estado estado_transportadora ON estado_transportadora.id=cidade_transportadora.id_estado "
                . "INNER JOIN email email_transportadora ON email_transportadora.id_entidade = transportadora.id AND email_transportadora.tipo_entidade='TRA' "
                . "LEFT JOIN tabela ON tabela.id_transportadora = transportadora.id "
                . "WHERE id_empresa=$this->id AND transportadora.excluida=false ";


        if ($filtro != "") {

            $sql .= "AND $filtro ";
        }

        if ($ordem != "") {

            $sql .= "ORDER BY $ordem ";
        }

        $sql .= "LIMIT $x1, " . ($x2 - $x1);

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($tra_id, $tra_nome, $tra_nome_fantasia, $tra_despacho, $tra_cnpj, $tra_habilitada, $tra_ie, $end_tra_id, $end_tra_rua, $end_tra_numero, $end_tra_bairro, $end_tra_cep, $cid_tra_id, $cid_tra_nome, $est_tra_id, $est_tra_nome, $id_email_tra, $end_email_tra, $sen_email_tra);

        $transportadoras = array();

        while ($ps->fetch()) {


            $transportadora = new Transportadora();
            $transportadora->id = $tra_id;
            $transportadora->cnpj = new CNPJ($tra_cnpj);
            $transportadora->despacho = $tra_despacho;
            $transportadora->email = new Email($end_email_tra);
            $transportadora->email->id = $id_email_tra;
            $transportadora->email->senha = $sen_email_tra;
            $transportadora->habilitada = $tra_habilitada == 1;
            $transportadora->inscricao_estadual = $tra_ie;
            $transportadora->nome_fantasia = $tra_nome_fantasia;
            $transportadora->razao_social = $tra_nome;
            $transportadora->empresa = $this;

            $end = new Endereco();
            $end->id = $end_tra_id;
            $end->bairro = $end_tra_bairro;
            $end->cep = new CEP($end_tra_cep);
            $end->numero = $end_tra_numero;
            $end->rua = $end_tra_rua;

            $end->cidade = new Cidade();
            $end->cidade->id = $cid_tra_id;
            $end->cidade->nome = $cid_tra_nome;

            $end->cidade->estado = new Estado();
            $end->cidade->estado->id = $est_tra_id;
            $end->cidade->estado->sigla = $est_tra_nome;

            $transportadora->endereco = $end;

            $transportadoras[$tra_id] = $transportadora;
        }

        $ps->close();

        $in_tra = "-1";

        foreach ($transportadoras as $id => $transportadora) {
            $in_tra .= ",";
            $in_tra .= $id;
        }

        $ps = $con->getConexao()->prepare("SELECT telefone.id_entidade, telefone.tipo_entidade, telefone.id, telefone.numero FROM telefone WHERE (telefone.id_entidade IN($in_tra) AND telefone.tipo_entidade='TRA') AND telefone.excluido = false");
        $ps->execute();
        $ps->bind_result($id_entidade, $tipo_entidade, $id, $numero);
        while ($ps->fetch()) {

            $v = $transportadoras;


            $telefone = new Telefone();
            $telefone->id = $id;
            $telefone->numero = $numero;

            $v[$id_entidade]->telefones[] = $telefone;
        }
        $ps->close();

        $ps = $con->getConexao()->prepare("SELECT tabela.id,tabela.nome,tabela.id_transportadora,regra_tabela.id,regra_tabela.condicional,regra_tabela.resultante FROM tabela INNER JOIN regra_tabela ON regra_tabela.id_tabela = tabela.id WHERE tabela.id_transportadora IN ($in_tra) AND tabela.excluida=false");
        $ps->execute();
        $ps->bind_result($id, $nome, $id_tra, $idr, $cond, $res);
        while ($ps->fetch()) {

            $t = $transportadoras[$id_tra];


            if ($t->tabela == null) {

                $t->tabela = new Tabela();
                $t->tabela->nome = $nome;
                $t->tabela->id = $id;
            }

            $regra = new RegraTabela();
            $regra->id = $idr;
            $regra->condicional = $cond;
            $regra->resultante = $res;

            $t->tabela->regras[] = $regra;
        }

        $ps->close();

        $real = array();

        foreach ($transportadoras as $key => $value) {

            $real[] = $value;
        }

        return $real;
    }

    public function getCountTransportadoras($con, $filtro = "") {


        $sql = "SELECT COUNT(*) FROM transportadora LEFT JOIN tabela ON tabela.id_transportadora=transportadora.id WHERE transportadora.id_empresa = $this->id AND transportadora.excluida=false ";

        if ($filtro != "") {

            $sql .= "AND $filtro";
        }

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($qtd);

        if ($ps->fetch()) {

            $ps->close();

            return $qtd;
        }

        $ps->close();

        return 0;
    }

    public function getClientes($con, $x1, $x2, $filtro = "", $ordem = "") {

        $sql = "SELECT "
                . "cliente.id,"
                . "cliente.razao_social, "
                . "cliente.nome_fantasia, "
                . "cliente.limite_credito, "
                . "UNIX_TIMESTAMP(cliente.inicio_limite)*1000, "
                . "UNIX_TIMESTAMP(cliente.termino_limite)*1000, "
                . "cliente.pessoa_fisica, "
                . "cliente.cpf, "
                . "cliente.cnpj, "
                . "cliente.rg, "
                . "cliente.inscricao_estadual, "
                . "cliente.suframado, "
                . "cliente.inscricao_suframa, "
                . "categoria_cliente.id, "
                . "categoria_cliente.nome, "
                . "endereco_cliente.id, "
                . "endereco_cliente.rua, "
                . "endereco_cliente.numero, "
                . "endereco_cliente.bairro, "
                . "endereco_cliente.cep, "
                . "cidade_cliente.id, "
                . "cidade_cliente.nome, "
                . "estado_cliente.id, "
                . "estado_cliente.sigla, "
                . "email_cliente.id,"
                . "email_cliente.endereco,"
                . "email_cliente.senha "
                . "FROM cliente "
                . "INNER JOIN endereco endereco_cliente ON endereco_cliente.id_entidade=cliente.id AND endereco_cliente.tipo_entidade='CLI' "
                . "INNER JOIN cidade cidade_cliente ON endereco_cliente.id_cidade=cidade_cliente.id "
                . "INNER JOIN estado estado_cliente ON estado_cliente.id=cidade_cliente.id_estado "
                . "INNER JOIN categoria_cliente ON cliente.id_categoria=categoria_cliente.id "
                . "INNER JOIN email email_cliente ON email_cliente.id_entidade=cliente.id AND email_cliente.tipo_entidade = 'CLI' "
                . "WHERE cliente.id_empresa=$this->id AND cliente.excluido=false ";

        if ($filtro != "") {

            $sql .= "AND $filtro ";
        }

        if ($ordem != "") {

            $sql .= "ORDER BY $ordem ";
        }

        $sql .= "LIMIT $x1, " . ($x2 - $x1);


        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id_cliente, $nome_cliente, $nome_fantasia_cliente, $limite, $inicio, $fim, $pessoa_fisica, $cpf, $cnpj, $rg, $ie, $suf, $i_suf, $cat_id, $cat_nome, $end_cli_id, $end_cli_rua, $end_cli_numero, $end_cli_bairro, $end_cli_cep, $cid_cli_id, $cid_cli_nome, $est_cli_id, $est_cli_nome, $email_cli_id, $email_cli_end, $email_cli_senha);

        $clientes = array();

        while ($ps->fetch()) {

            $cliente = new Cliente();
            $cliente->id = $id_cliente;
            $cliente->cnpj = new CNPJ($cnpj);
            $cliente->cpf = new CPF($cpf);
            $cliente->rg = new RG($rg);
            $cliente->pessoa_fisica = $pessoa_fisica == 1;
            $cliente->nome_fantasia = $nome_fantasia_cliente;
            $cliente->razao_social = $nome_cliente;
            $cliente->empresa = $this;
            $cliente->email = new Email($email_cli_end);
            $cliente->email->id = $email_cli_id;
            $cliente->email->senha = $email_cli_senha;
            $cliente->categoria = new CategoriaCliente();
            $cliente->categoria->id = $cat_id;
            $cliente->categoria->nome = $cat_nome;
            $cliente->inicio_limite = $inicio;
            $cliente->termino_limite = $fim;
            $cliente->limite_credito = $limite;
            $cliente->inscricao_suframa = $i_suf;
            $cliente->suframado = $suf == 1;
            $cliente->empresa = $this;
            $cliente->inscricao_estadual = $ie;

            $end = new Endereco();
            $end->id = $end_cli_id;
            $end->bairro = $end_cli_bairro;
            $end->cep = new CEP($end_cli_cep);
            $end->numero = $end_cli_numero;
            $end->rua = $end_cli_numero;

            $end->cidade = new Cidade();
            $end->cidade->id = $cid_cli_id;
            $end->cidade->nome = $cid_cli_nome;

            $end->cidade->estado = new Estado();
            $end->cidade->estado->id = $est_cli_id;
            $end->cidade->estado->sigla = $est_cli_nome;

            $cliente->endereco = $end;

            $clientes[$id_cliente] = $cliente;
        }

        $ps->close();

        $in_cli = "-1";

        foreach ($clientes as $id => $cliente) {
            $in_cli .= ",";
            $in_cli .= $id;
        }

        $ps = $con->getConexao()->prepare("SELECT telefone.id_entidade, telefone.tipo_entidade, telefone.id, telefone.numero FROM telefone WHERE (telefone.id_entidade IN ($in_cli) AND telefone.tipo_entidade='CLI') AND telefone.excluido=false");
        $ps->execute();
        $ps->bind_result($id_entidade, $tipo_entidade, $id, $numero);
        while ($ps->fetch()) {

            $v = $clientes;

            $telefone = new Telefone();
            $telefone->id = $id;
            $telefone->numero = $numero;

            $v[$id_entidade]->telefones[] = $telefone;
        }
        $ps->close();

        $real = array();

        foreach ($clientes as $key => $value) {

            $real[] = $value;
        }

        return $real;
    }

    public function getCountClientes($con, $filtro = "") {

        $sql = "SELECT COUNT(*) FROM cliente WHERE id_empresa=$this->id AND excluido=false ";

        if ($filtro != "") {

            $sql .= "AND $filtro";
        }

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($qtd);

        if ($ps->fetch()) {

            $ps->close();

            return $qtd;
        }

        $ps->close();

        return 0;
    }

    public function getUsuarios($con, $x1, $x2, $filtro = "", $ordem = "") {

        $sql = "SELECT "
                . "usuario.id,"
                . " usuario.nome,"
                . " usuario.login,"
                . " usuario.senha,"
                . " usuario.cpf,"
                . " endereco_usuario.id,"
                . " endereco_usuario.rua,"
                . " endereco_usuario.numero,"
                . " endereco_usuario.bairro,"
                . " endereco_usuario.cep,"
                . " cidade_usuario.id,"
                . " cidade_usuario.nome,"
                . " estado_usuario.id,"
                . " estado_usuario.sigla,"
                . " email_usu.id,"
                . " email_usu.endereco,"
                . "email_usu.senha "
                . "FROM usuario "
                . "INNER JOIN endereco endereco_usuario ON endereco_usuario.id_entidade=usuario.id AND endereco_usuario.tipo_entidade='USU' "
                . "INNER JOIN cidade cidade_usuario ON endereco_usuario.id_cidade=cidade_usuario.id "
                . "INNER JOIN estado estado_usuario ON estado_usuario.id=cidade_usuario.id_estado "
                . "INNER JOIN email email_usu ON email_usu.id_entidade=usuario.id AND email_usu.tipo_entidade='USU' "
                . "WHERE usuario.id_empresa=$this->id AND usuario.excluido = false ";

        if ($filtro != "") {

            $sql .= "AND $filtro ";
        }

        if ($ordem != "") {

            $sql .= "ORDER BY $ordem ";
        }

        $sql .= "LIMIT $x1, " . ($x2 - $x1);

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id_usu, $nome_usu, $login_usu, $senha_usu, $cpf_usu, $end_usu_id, $end_usu_rua, $end_usu_numero, $end_usu_bairro, $end_usu_cep, $cid_usu_id, $cid_usu_nome, $est_usu_id, $est_usu_nome, $email_usu_id, $email_usu_end, $email_usu_senha);

        $usuarios = array();

        while ($ps->fetch()) {

            $usuario = new Usuario();

            $usuario->cpf = new CPF($cpf_usu);
            $usuario->email = new Email($email_usu_end);
            $usuario->email->id = $email_usu_id;
            $usuario->email->senha = $email_usu_senha;
            $usuario->empresa = $this;
            $usuario->id = $id_usu;
            $usuario->login = $login_usu;
            $usuario->senha = $senha_usu;
            $usuario->nome = $nome_usu;
            $usuario->empresa = $this;

            $end = new Endereco();
            $end->id = $end_usu_id;
            $end->bairro = $end_usu_bairro;
            $end->cep = new CEP($end_usu_cep);
            $end->numero = $end_usu_numero;
            $end->rua = $end_usu_numero;

            $end->cidade = new Cidade();
            $end->cidade->id = $cid_usu_id;
            $end->cidade->nome = $cid_usu_nome;

            $end->cidade->estado = new Estado();
            $end->cidade->estado->id = $est_usu_id;
            $end->cidade->estado->sigla = $est_usu_nome;

            $usuario->endereco = $end;

            $usuarios[$usuario->id] = $usuario;
        }

        $ps->close();

        $in_usu = "-1";
        foreach ($usuarios as $id => $usuario) {
            $in_usu .= ",";
            $in_usu .= $id;
        }

        $ps = $con->getConexao()->prepare("SELECT telefone.id_entidade, telefone.tipo_entidade, telefone.id, telefone.numero FROM telefone WHERE (telefone.id_entidade IN ($in_usu) AND telefone.tipo_entidade='USU') AND telefone.excluido = false");
        $ps->execute();
        $ps->bind_result($id_entidade, $tipo_entidade, $id, $numero);
        while ($ps->fetch()) {

            $v = $usuarios;
            $telefone = new Telefone();
            $telefone->id = $id;
            $telefone->numero = $numero;

            $v[$id_entidade]->telefones[] = $telefone;
        }
        $ps->close();

        $permissoes = Sistema::getPermissoes();

        $ps = $con->getConexao()->prepare("SELECT id_usuario, id_permissao,incluir,deletar,alterar,consultar FROM usuario_permissao WHERE id_usuario IN ($in_usu)");
        $ps->execute();
        $ps->bind_result($id_usuario, $id_permissao, $incluir, $deletar, $alterar, $consultar);

        while ($ps->fetch()) {

            $p = null;

            foreach ($permissoes as $key => $perm) {
                if ($perm->id == $id_permissao) {
                    $p = Utilidades::copy($perm);
                    break;
                }
            }

            if ($p == null) {

                continue;
            }

            $p->alt = $alterar == 1;
            $p->in = $incluir == 1;
            $p->del = $deletar == 1;
            $p->cons = $consultar == 1;

            $usuarios[$id_usuario]->permissoes[] = $p;
        }

        $ps->close();

        $real = array();

        foreach ($usuarios as $key => $value) {

            $real[] = $value;
        }

        return $real;
    }

    public function getCountUsuarios($con, $filtro = "") {

        $sql = "SELECT "
                . "COUNT(*) "
                . "FROM usuario "
                . "INNER JOIN email email_usu ON email_usu.id_entidade=usuario.id AND email_usu.tipo_entidade='USU' "
                . "WHERE usuario.id_empresa=$this->id AND usuario.excluido=false ";

        if ($filtro != "") {

            $sql .= "AND $filtro";
        }

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($qtd);

        if ($ps->fetch()) {

            $ps->close();
            return $qtd;
        }

        $ps->close();
        return 0;
    }

}
