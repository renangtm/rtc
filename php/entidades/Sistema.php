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

    public static function getTrabalhosCronometrados() {

        $trabalhos = array();

        $relatorios = new EnvioRelatorios();
        $relatorios->cronoExpression = "(19h:00m)";
        $trabalhos[] = $relatorios;

        $prospeccao = new RoboVirtual();
        $prospeccao->cronoExpression = "c(60m)";
        $trabalhos[] = $prospeccao;

        return $trabalhos;
    }

    public static function P_PEDIDO_ENTRADA() {
        return new Permissao(1, "pedido_entrada");
    }

    public static function P_PRODUTO() {
        return new Permissao(2, "produto");
    }

    public static function P_COTACAO() {
        return new Permissao(3, "cotacao");
    }

    public static function P_TRANSPORTADORA() {
        return new Permissao(4, "transportadora");
    }

    public static function P_CLIENTE() {
        return new Permissao(5, "cliente");
    }

    public static function P_NOTA() {
        return new Permissao(6, "nota");
    }

    public static function P_LOTE() {
        return new Permissao(7, "lote");
    }

    public static function P_TABELA() {
        return new Permissao(8, "tabela");
    }

    public static function P_CAMPANHA() {
        return new Permissao(9, "campanha");
    }

    public static function P_GRUPO_CIDADE() {
        return new Permissao(10, "grupo_cidades");
    }

    public static function P_BANCO() {
        return new Permissao(11, "banco");
    }

    public static function P_MOVIMENTO() {
        return new Permissao(12, "movimento");
    }

    public static function P_CATEGORIA_PRODUTO() {
        return new Permissao(14, "categoria_produto");
    }

    public static function P_CATEGORIA_CLIENTE() {
        return new Permissao(15, "categoria_cliente");
    }

    public static function P_CATEGORIA_DOCUMENTO() {
        return new Permissao(16, "categoria_documento");
    }

    public static function P_FORNECEDOR() {
        return new Permissao(17, "fonecedor");
    }

    public static function P_CFG() {
        return new Permissao(18, "cfg");
    }

    public static function P_CONFIGURACAO_EMPRESA() {
        return new Permissao(19, "configuracao_empresa");
    }

    public static function P_CULTURA() {
        return new Permissao(20, "cultura");
    }

    public static function P_PRAGA() {
        return new Permissao(21, "praga");
    }

    public static function P_LISTA_PRECO() {
        return new Permissao(23, "lista_preco");
    }

    public static function P_SEPARACAO() {
        return new Permissao(25, "separacao");
    }

    public static function P_LOGO() {
        return new Permissao(27, "logo");
    }

    public static function P_GERENCIADOR() {
        return new Permissao(28, "gerenciador");
    }

    public static function P_BANNERS() {
        return new Permissao(29, "banners");
    }

    public static function P_RELATORIO_FINANCEIRO() {
        return new Permissao(30, "RelatorioFinanceiro");
    }

    public static function P_RELATORIO_MOVIMENTO() {
        return new Permissao(31, "RelatorioMovimento");
    }

    public static function P_ENTRADA_NFE() {
        return new Permissao(32, "entrada nfe");
    }

    public static function P_PRODUTO_CLIENTE() {
        return new Permissao(33, "produto cliente");
    }

    public static function P_PEDIDO_SAIDA() {
        return new Permissao(34, "pedido saida");
    }

    public static function P_PARAMETRROS_TECNICOS_PRODUTO() {
        return new Permissao(35, "parametros agricolas cadastro de produto");
    }

    public static function P_EMPRESA_PEDIDO() {
        return new Permissao(36, "visualizar empresa do pedido");
    }

    public static function P_EXPORTAR_LANCAMENTO() {
        return new Permissao(37, "RelatorioExportaLancamento");
    }

    public static function P_RELATORIO_PRODUTO_LOGISTICA() {
        return new Permissao(38, "RelatorioProdutoLogistica");
    }

    public static function P_CONTROLADOR_TAREFAS() {
        return new Permissao(39, "Controlador de tarefas");
    }

    public static function P_ORGANOGRAMA() {
        return new Permissao(40, "Organograma da equipe");
    }

    public static function P_ORGANOGRAMA_TOTAL() {
        return new Permissao(41, "Organograma da empresa");
    }

    public static function P_EXPEDIENTE() {
        return new Permissao(42, "Expediente dos colaboradores");
    }

    public static function P_TAREFAS() {
        return new Permissao(43, "Tarefas");
    }

    public static function TT_ANALISE_CREDITO($id_empresa) {

        return new TTAnaliseCredito($id_empresa);
    }

    public static function TT_CONFIRMACAO_PAGAMENTO($id_empresa) {

        return new TTConfirmacaoPagamento($id_empresa);
    }

    public static function TT_PROBLEMA_INTERNET($id_empresa) {

        return new TTProblemaInternet($id_empresa);
    }

    public static function TT_PROBLEMA_ENVIO_EMAIL($id_empresa) {

        return new TTProblemaEnvioEmail($id_empresa);
    }

    public static function TT_PROBLEMA_MAQUINA($id_empresa) {

        return new TTProblemaMaquina($id_empresa);
    }

    public static function TT_MODIFICACAO_SIMPLES_SISTEMA($id_empresa) {

        return new TTModificacaoSimplesSistema($id_empresa);
    }

    public static function TT_MODIFICACAO_SISTEMA($id_empresa) {

        return new TTModificacaoSistema($id_empresa);
    }

    public static function TT_MODIFICACAO_COMPLEXA_SISTEMA($id_empresa) {

        return new TTModificacaoComplexaSistema($id_empresa);
    }

    public static function TT_ATIVIDADE_COMUM($id_empresa) {

        return new TTAtividadeComum($id_empresa);
    }

    public static function TT_PROSPECCAO_CLIENTE($id_empresa) {

        return new TTProspeccaoDeCliente($id_empresa);
    }

    public static function TT_RECEPCAO_CLIENTE($id_empresa) {

        return new TTRecepcaoCliente($id_empresa);
    }

    public static function TT_SUPORTE_CLIENTE($id_empresa) {

        return new TTSuporteCliente($id_empresa);
    }

    public static function TT_FAQ_CLIENTE($id_empresa) {

        return new TTFAQCliente($id_empresa);
    }

    public static function TT_ATENDIMENTO_POSVENDA($id_empresa) {

        return new TTAtendimentoPosVenda($id_empresa);
    }

    public static function avisoDEVS($aviso) {

        $email = new Email("renan.miranda@agrofauna.com.br");
        $email->senha = "5hynespt";
        $destino = new Email("renan_goncalves@outlook.com.br");

        try {

            $email->enviarEmail($destino, 'Aviso', $aviso);
        } catch (Exception $ex) {
            
        }
    }

    public static function getTarefasFixas($empresa) {

        $tarefas = $empresa->tarefas_fixas;

        $ret = array();

        foreach ($tarefas as $key => $value) {

            $t = call_user_func("self::" . $value, $empresa->id);
            $t->empresa = $empresa;
            $ret[] = $t;
        }

        return $ret;
    }

    public static function novaTarefaEmpresa($con, $tarefa, $empresa) {

        $tarefa->realocavel = true;

        $cargos = "(";

        foreach ($tarefa->tipo_tarefa->cargos as $key => $value) {
            if ($cargos !== "(") {
                $cargos .= ",";
            }
            $cargos .= "$value->id";
        }

        $cargos .= ")";

        $usuarios = array();
        $ps = $con->getConexao()->prepare("SELECT usuario.id FROM usuario WHERE id_empresa=$empresa->id AND id_cargo IN $cargos");
        $ps->execute();
        $ps->bind_result($id);
        while ($ps->fetch()) {
            $usuarios[] = $id;
        }
        $ps->close();

        $in = "(0";

        foreach ($usuarios as $key => $value) {
            $in .= ",$value";
        }

        $in .= ")";

        $tarefas = array();
        $expedientes = array();
        $ausencias = array();

        $ps = $con->getConexao()->prepare("SELECT id,UNIX_TIMESTAMP(inicio)*1000,UNIX_TIMESTAMP(fim)*1000,id_usuario FROM ausencia WHERE id_usuario IN $in AND fim>CURRENT_TIMESTAMP");
        $ps->execute();
        $ps->bind_result($id, $inicio, $fim, $id_usuario);
        while ($ps->fetch()) {

            $a = new Ausencia();
            $a->id = $id;
            $a->inicio = $inicio;
            $a->fim = $fim;

            if (!isset($ausencias[$id_usuario])) {
                $ausencias[$id_usuario] = array();
            }

            $ausencias[$id_usuario][] = $a;
        }
        $ps->close();


        $ps = $con->getConexao()->prepare("SELECT id,inicio,fim,dia_semana,id_usuario FROM expediente WHERE id_usuario IN $in");
        $ps->execute();
        $ps->bind_result($id, $inicio, $fim, $dia_semana, $id_usuario);

        while ($ps->fetch()) {
            $e = new Expediente();
            $e->id = $id;
            $e->inicio = $inicio;
            $e->fim = $fim;
            $e->dia_semana = $dia_semana;

            if (!isset($expedientes[$id_usuario])) {
                $expedientes[$id_usuario] = array();
            }

            $expedientes[$id_usuario][] = $e;
        }
        $ps->close();

        //------------------------

        $tipos_tarefa = $empresa->getTiposTarefa($con);

        $sql = "SELECT "
                . "tarefa.id,"
                . "UNIX_TIMESTAMP(tarefa.inicio_minimo)*1000,"
                . "tarefa.ordem,"
                . "tarefa.porcentagem_conclusao,"
                . "tarefa.tipo_entidade_relacionada,"
                . "tarefa.id_entidade_relacionada,"
                . "tarefa.titulo,"
                . "tarefa.descricao,"
                . "tarefa.intervalos_execucao,"
                . "tarefa.realocavel,"
                . "tarefa.id_tipo_tarefa,"
                . "tarefa.prioridade,"
                . "observacao.id,"
                . "observacao.porcentagem,"
                . "UNIX_TIMESTAMP(observacao.momento), "
                . "observacao.observacao,"
                . "tarefa.id_usuario "
                . "FROM tarefa LEFT JOIN (SELECT * FROM observacao WHERE observacao.excluida = false) observacao ON tarefa.id=observacao.id_tarefa "
                . "WHERE tarefa.excluida=false AND tarefa.id_usuario IN $in";

        $tmp = array();
        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id, $inicio_minimo, $ordem, $porcentagem_conclusao, $tipo_entidade_relacionada, $id_entidade_relacionada, $titulo, $descricao, $intervalos_execucao, $realocavel, $id_tipo_tarefa, $prioridade, $id_observacao, $porcentagem_observacao, $momento_observacao, $observacao, $id_usuario);
        while ($ps->fetch()) {

            if (!isset($tmp[$id])) {

                $t = new Tarefa();
                $t->id = $id;
                $t->inicio_minimo = $inicio_minimo;
                $t->ordem = $ordem;
                $t->porcentagem_conclusao = $porcentagem_conclusao;
                $t->tipo_entidade_relacionada = $tipo_entidade_relacionada;
                $t->id_entidade_relacionada = $id_entidade_relacionada;
                $t->titulo = $titulo;
                $t->descricao = $descricao;
                $t->intervalos_execucao = $intervalos_execucao;
                $t->realocavel = $realocavel == 1;

                foreach ($tipos_tarefa as $key => $tipo) {
                    if ($tipo->id === $id_tipo_tarefa) {
                        $t->tipo_tarefa = $tipo;
                        break;
                    }
                }

                $t->prioridade = $prioridade;

                $t->intervalos_execucao = explode(";", $t->intervalos_execucao);
                $intervalos = array();
                foreach ($t->intervalos_execucao as $key => $intervalo) {
                    if ($intervalo === "")
                        continue;
                    $k = explode('@', $intervalo);
                    $intervalos[] = array(doubleval($k[0]), doubleval($k[1]));
                }
                $t->intervalos_execucao = $intervalos;

                $tmp[$id] = $t;

                if (!isset($tarefas[$id_usuario])) {
                    $tarefas[$id_usuario] = array();
                }

                $tarefas[$id_usuario][] = $t;
            }

            $t = $tmp[$id];

            if ($id_observacao !== null) {

                $obs = new ObservacaoTarefa();
                $obs->id = $id_observacao;
                $obs->momento = $momento_observacao;
                $obs->porcentagem = $porcentagem_observacao;
                $obs->observacao = $observacao;

                $t->observacoes[] = $obs;
            }
        }

        $ps->close();

        $menor = -1;
        $tempo = -1;
        $tasks = null;

        foreach ($usuarios as $key => $usuario) {

            $a = array();
            $e = array();
            $t = array();

            if (isset($ausencias[$usuario])) {
                $a = $ausencias[$usuario];
            }

            if (isset($expedientes[$usuario])) {
                $e = $expedientes[$usuario];
            }

            if (isset($tarefas[$usuario])) {
                $t = Utilidades::copy($tarefas[$usuario]);
            }

            $t[] = $tarefa;

            IATarefas::aplicar($e, $a, $t);

            if ($menor < 0) {

                $menor = $usuario;
                $tempo = $tarefa->calculado_momento_conclusao;
                $tasks = $t;
            } else {
                if ($tempo > $tarefa->calculado_momento_conclusao) {
                    $menor = $usuario;
                    $tempo = $tarefa->calculado_momento_conclusao;
                    $tasks = $t;
                }
            }
        }

        if ($menor === -1) {

            throw new Exception('Sem usuarios para atribuir esta tarefa');
        }

        $tarefa->merge($con);
        $ps = $con->getConexao()->prepare("UPDATE tarefa SET id_usuario=$menor,inicio_minimo=inicio_minimo WHERE id=$tarefa->id");
        $ps->execute();
        $ps->close();

        foreach ($tasks as $key => $value) {
            $ps = $con->getConexao()->prepare("UPDATE tarefa SET ordem=$value->ordem,inicio_minimo=inicio_minimo WHERE id=$value->id");
            $ps->execute();
            $ps->close();
        }
    }

    public static function getTiposTarefaUsuario($con, $usuario) {

        $id_cargo = 0;
        if ($usuario->cargo !== null) {
            $id_cargo = $usuario->cargo->id;
        }

        $tipos_tarefa = $usuario->empresa->getTiposTarefa($con);

        $possiveis = array();

        foreach ($tipos_tarefa as $key => $value) {
            foreach ($value->cargos as $key2 => $value2) {
                if ($value2->id === $id_cargo) {
                    $possiveis[] = $value;
                    break;
                }
            }
        }

        return $possiveis;
    }

    public static function novaTarefaUsuario($con, $tarefa, $usuario) {

        $usuario->addTarefa($con, $tarefa);

        $tarefas = $usuario->getTarefas($con, 'tarefa.porcentagem_conclusao<100');
        $expedientes = $usuario->getExpedientes($con);
        $ausencias = $usuario->getAusencias($con, 'ausencia.fim>CURRENT_TIMESTAMP');

        IATarefas::aplicar($expedientes, $ausencias, $tarefas);


        foreach ($tarefas as $key => $value) {
            $ps = $con->getConexao()->prepare("UPDATE tarefa SET ordem=$value->ordem,inicio_minimo=inicio_minimo WHERE id=$value->id");
            $ps->execute();
            $ps->close();
        }
    }

    public static function getTarefaFixa($con, $empresa, $tarefa) {

        $t = call_user_func("self::" . $tarefa, $empresa->id);
        $tarefas = $empresa->getTiposTarefa($con, "tipo_tarefa.id=$t->id");

        foreach ($tarefas as $key => $value) {

            if ($value->id === $t->id) {

                return $value;
            }
        }

        return null;
    }

    public static function mesclarTarefas($empresa, $tarefas) {

        $default = Sistema::getTarefasFixas($empresa);

        foreach ($default as $key => $value) {

            foreach ($tarefas as $key2 => $value2) {

                if ($value->id === $value2->id) {

                    $value->tempo_medio = $value2->tempo_medio;
                    $value->prioridade = $value2->prioridade;
                    $value->cargos = $value2->cargos;
                    $value->empresa = $value2->empresa;

                    $tarefas[$key2] = $value;

                    continue 2;
                }
            }

            $tarefas[] = $value;
        }

        return $tarefas;
    }

    public static function getEmpresa($tipo) {

        $empresa = null;
        if ($tipo === 0) {
            $empresa = new EmpresaAgricola();
        } else if ($tipo === 1) {
            $empresa = new Logistica();
        } else if ($tipo === 2) {
            $empresa = new Marketing();
        } else if ($tipo === 3) {
            $empresa = new Virtual();
        } else if ($tipo === 4) {
            $empresa = new Leiloes();
        } else if ($tipo === 5) {
            $empresa = new Administracao();
        } else if ($tipo === 6) {
            $empresa = new Agronomia();
        } else if ($tipo === 7) {
            $empresa = new Empresa();
        } else if ($tipo === 8) {
            $empresa = new Tecnologia();
        }

        if ($empresa !== null) {

            $empresa->tipo_empresa = $tipo;
        }

        return $empresa;
    }

    public static function getCargo($con, $empresa, $id, $cache = true) {

        $ses = new SessionManager();

        if (($c = $ses->get("cargos_$empresa->id")) !== null && $cache) {

            foreach ($c as $key => $cargo) {

                if ($cargo->id === $id) {

                    return $cargo;
                }
            }

            return null;
        } else {

            $cargos = $empresa->getCargos($con);
            $ses->set("cargos_$empresa->id", $cargos);

            foreach ($cargos as $key => $cargo) {

                if ($cargo->id === $id) {

                    return $cargo;
                }
            }

            return null;
        }
    }

    public static function getRelatorios($empresa, $usuario) {

        $relatorios[] = new RelatorioFinanceiro($empresa);
        $relatorios[] = new RelatorioMovimento($empresa);
        $relatorios[] = new RelatorioExportaLancamento($empresa);
        $relatorios[] = new RelatorioProdutoLogistica($empresa);

        $permitidos = array();

        foreach ($relatorios as $key => $value) {
            $p = new Permissao(0, get_class($value));
            $p->m("C");
            if ($usuario->temPermissao($p)) {
                $permitidos[] = $value;
            }
        }

        return $permitidos;
    }

    public static function getProdutosDoDia($con, $dia, $num, $empresa) {

        $dia = $dia - 1;

        while ($dia < 0) {
            $dia += $num;
        }

        $dia = $dia % $num;

        $classes = array();
        $ps = $con->getConexao()->prepare("SELECT id,classificacao_saida FROM produto WHERE id_empresa=$empresa->id AND produto.disponivel > 0");
        $ps->execute();
        $ps->bind_result($id, $classe);
        while ($ps->fetch()) {
            if (!isset($classes[$classe])) {
                $classes[$classe] = array();
            }
            $classes[$classe][] = $id;
        }
        $ps->close();

        $produtos = "(-1";


        foreach ($classes as $key => $classe) {

            $fat = floor(count($classe) / $num);
            $rst = count($classe) % $num;

            for ($i = $fat * $dia; $i < $fat * ($dia + 1); $i++) {
                $produtos .= "," . $classe[$i];
            }

            if ($dia < $rst) {

                $produtos .= "," . $classe[$fat * $num + $dia];
            }
        }

        $produtos .= ")";


        return $empresa->getProdutos($con, 0, 10000000, "produto.id IN $produtos", "");
    }

    public static function getBanners($con) {

        $cm = new CacheManager(3600000);
        //1 hora de cahce de banners

        $cache = $cm->getCache("cbanner", false);

        if ($cache === null) {

            $empresas = array();

            $sql = "SELECT "
                    . "banner.id,"
                    . "UNIX_TIMESTAMP(banner.data_inicial)*1000,"
                    . "UNIX_TIMESTAMP(banner.data_final)*1000,"
                    . "banner.id_campanha,"
                    . "banner.tipo,"
                    . "banner.json,"
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
                    . "FROM banner "
                    . "INNER JOIN empresa ON banner.id_empresa=empresa.id "
                    . "INNER JOIN endereco ON endereco.id_entidade=empresa.id AND endereco.tipo_entidade='EMP' "
                    . "INNER JOIN email ON email.id_entidade=empresa.id AND email.tipo_entidade='EMP' "
                    . "INNER JOIN telefone ON telefone.id_entidade=empresa.id AND telefone.tipo_entidade='EMP' "
                    . "INNER JOIN cidade ON endereco.id_cidade=cidade.id "
                    . "INNER JOIN estado ON cidade.id_estado = estado.id "
                    . "WHERE empresa.vende_para_fora=true AND banner.data_inicial<=CURRENT_TIMESTAMP AND banner.data_final>=CURRENT_TIMESTAMP";

            $campanhas = "(-1";
            $qtd_campanhas = 0;

            $banners = array();

            $ps = $con->getConexao()->prepare($sql);
            $ps->execute();
            $ps->bind_result($id, $data_inicial, $data_final, $id_campanha, $tipo, $json, $id_empresa, $tipo_empresa, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

            while ($ps->fetch()) {

                $banner = new Banner();
                $banner->id = $id;
                $banner->data_inicial = $data_inicial;
                $banner->data_final = $data_final;
                $banner->campanha = $id_campanha;
                $banner->tipo = $tipo;
                $banner->json = $json;

                if (!isset($empresas[$id_empresa])) {

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

                    $empresas[$id_empresa] = $empresa;
                }

                $banner->empresa = $empresas[$id_empresa];

                $banners[] = $banner;

                if ($id_campanha > 0) {

                    $campanhas .= ",$id_campanha";
                    $qtd_campanhas++;
                }
            }

            $ps->close();

            $campanhas .= ")";

            $camps = array();

            foreach ($empresas as $key => $empresa) {

                $temp = $empresa->getCampanhas($con, 0, $qtd_campanhas, "campanha.id IN $campanhas", "");

                foreach ($temp as $key2 => $value) {
                    $camps[] = $value;
                }
            }

            $retorno = array();

            $campanhas = $camps;

            foreach ($banners as $key => $banner) {

                if (!isset($retorno[$banner->tipo])) {

                    $retorno[$banner->tipo] = array();
                }

                if ($banner->campanha > 0) {

                    foreach ($campanhas as $key2 => $campanha) {

                        if ($banner->campanha === $campanha->id) {

                            $banner->campanha = $campanha;
                            break;
                        }
                    }
                } else {

                    $banner->campanha = null;
                }

                $retorno[$banner->tipo][] = $banner->getHTML();
            }

            $strCache = "";

            foreach ($retorno as $key => $value) {
                $strCache .= "[[[divisao]]]$key{{{";
                foreach ($value as $key2 => $value2) {
                    $strCache .= "$value2;;;";
                }
            }

            $cm->setCache("cbanner", $strCache, false);
            return $retorno;
        } else {

            $retorno = array();
            $l = explode("[[[divisao]]]", $cache);

            foreach ($l as $key => $value) {
                if ($value === "")
                    continue;

                $k = explode("{{{", $value);
                $n = intval($k[0]);
                $retorno[$n] = array();
                $s = explode(";;;", $k[1]);
                foreach ($s as $key2 => $value2) {
                    if ($value2 === "")
                        continue;
                    $retorno[$n][] = $value2;
                }
            }

            return $retorno;
        }
    }

    public static function finalizarCompraParceiros($con, $pedido, $empresa) {

        $logistica = $pedido->empresa;

        if ($pedido->logistica !== null) {

            $logistica = $pedido->logistica;
        }

        $g = new Getter($logistica);
        $ge = new Getter($empresa);

        $transportadora = $g->getTransportadoraViaTransportadora($con, $pedido->transportadora);
        $pedido->transportadora = $transportadora;

        $pedido->merge($con);

        $produtos = array();

        foreach ($pedido->produtos as $key => $value) {

            $produtos[] = $value->produto;
        }

        $produtos = $ge->getProdutoViaProduto($con, $produtos);
        foreach ($produtos as $key => $value) {
            $produtos[$value->id_universal] = $value;
        }


        $entrada = new PedidoEntrada();
        $entrada->empresa = $empresa;
        $entrada->enviar_emails = false;
        $entrada->fornecedor = $ge->getFornecedorViaEmpresa($con, $pedido->empresa);
        $entrada->frete = $pedido->frete;
        $entrada->frete_incluso = $pedido->frete_incluso;
        $entrada->parcelas = $pedido->parcelas;
        $entrada->prazo = $pedido->prazo;
        $entrada->transportadora = $ge->getTransportadoraViaTransportadora($con, $pedido->transportadora);
        $entrada->usuario = $pedido->usuario;
        $entrada->status = Sistema::getStatusPedidoEntrada();
        $entrada->status = $entrada->status[0];
        $entrada->observacoes = "Pedido gerado referente a compra feita pelo RTC";
        $entrada->produtos = array();

        foreach ($pedido->produtos as $key => $value) {

            $pp = new ProdutoPedidoEntrada();
            $pp->pedido = $entrada;
            $pp->produto = $produtos[$value->produto->id_universal];
            $pp->valor = ($value->valor_base + $value->icms + $value->frete + $value->ipi);
            $pp->quantidade = $value->quantidade;

            $entrada->produtos[] = $pp;
        }


        $entrada->merge($con);
    }

    public static function getPedidosResultantes($con, $carrinho, $empresa, $usuario) {

        $grupos = array();
        $campanhas = array();

        foreach ($carrinho as $key => $item) {

            if ($item->quantidade_comprada <= 0)
                continue;

            $hash = "e" . $item->empresa->id;

            if ($item->logistica !== null) {

                $hash .= "l" . $item->logistica->id;
            }

            $campanha = null;

            foreach ($item->ofertas as $key => $value) {
                if ($value->validade == $item->validade->validade) {
                    $campanha = $value->campanha;
                    break;
                }
            }

            if ($campanha !== null) {
                $h = "c" . $campanha->prazo . "p" . $campanha->parcelas;

                if ($campanha->prazo < 0 || $campanha->parcelas < 0 || true) { //retirar esse true, para mudar a abordagem, apra dividir tambem pedidos entre campanhas de prazos diferentes
                    $hash .= "cp";
                } else {
                    $hash .= $h;
                    $campanhas[$hash] = $campanha;
                }
            } else {
                $hash .= "cp";
            }

            if (!isset($grupos[$hash])) {
                $grupos[$hash] = array();
            }

            $grupos[$hash][] = $item;
        }

        $pedidos = array();

        $formas = Sistema::getFormasPagamento();
        $status_inicial = Sistema::getStatusPedidoSaida();
        $status_inicial = $status_inicial[0];



        foreach ($grupos as $key => $value) {

            $base = $value[0];

            $emp = $base->empresa;


            $g = new Getter($emp);

            $cliente = $g->getClienteViaEmpresa($con, $empresa);

            $pedido = new Pedido();
            $pedido->empresa = $emp;
            $pedido->cliente = $cliente;

            if (isset($campanhas[$key])) {

                $campanha = $campanhas[$key];
            }

            foreach ($formas as $k2 => $v2) {
                if ($v2->habilitada($pedido)) {
                    $pedido->forma_pagamento = $v2;
                    break;
                }
            }

            if ($base->logistica !== null) {

                $pedido->logistica = $base->logistica;
            }

            $pedido->usuario = $usuario;
            $pedido->status = $status_inicial;
            $pedido->produtos = array();

            foreach ($value as $key2 => $produto) {

                if (!$produto->sistema_lotes) {

                    $p = new ProdutoPedidoSaida();
                    $p->produto = $produto;
                    $p->validade_minima = $produto->validade->validade;
                    $p->quantidade = $produto->quantidade_comprada;
                    $p->valor_base = $produto->validade->valor;

                    if ($p->quantidade > $produto->validade->limite && $produto->validade->limite > 0) {
                        $p->quantidade = $produto->validade->limite;
                    }

                    $pedido->produtos[] = $p;
                    $p->pedido = $pedido;
                } else {

                    $p = new ProdutoPedidoSaida();
                    $p->produto = $produto;
                    $p->validade_minima = $produto->validade->validade;
                    $p->quantidade = $produto->quantidade_comprada;
                    $p->valor_base = $produto->validade->valor;
                    $p->pedido = $pedido;
                    if ($p->quantidade > $produto->validade->limite && $produto->validade->limite > 0) {
                        $p->quantidade = $produto->validade->limite;
                    }

                    $pds = array($p);

                    if ($produto->validade->alem) {
                        $lotes = $produto->getLotes($con, 'lote.quantidade_real>0 AND (UNIX_TIMESTAMP(lote.validade)*1000) >= ' . $produto->validade->validade, 'lote.validade ASC');
                        for ($i = 0; $i < count($pds); $i++) {
                            $pp = $pds[$i];
                            $pp->aux = $pp->quantidade;
                            $primeira_maior = 0;
                            foreach ($lotes as $keyl => $lote) {
                                if ($lote->validade === $pp->validade_minima) {
                                    $pp->aux -= $lote->quantidade_real;
                                } else if ($lote->validade > $pp->validade_minima && $primeira_maior === 0) {
                                    $primeira_maior = $lote->validade;
                                }
                            }
                            $pp->aux = max(0, $pp->aux);
                            if ($pp->aux > 0 && $primeira_maior > 0) {
                                $np = Utilidades::copyId0($pp);
                                $np->quantidade = $pp->aux;
                                $np->validade_minima = $primeira_maior;
                                $np->pedido = $pedido;
                                $pds[] = $np;
                            }
                            $pp->quantidade -= $pp->aux;
                        }
                    }

                    foreach ($pds as $kp => $produto_pedido) {
                        $pedido->produtos[] = $produto_pedido;
                    }
                }
            }

            $pedido->atualizarCustos();
            $pedido->formas_pagamento = array();

            foreach ($formas as $keyf => $f) {
                if ($f->habilitada($pedido)) {
                    $pedido->formas_pagamento[] = $f;
                }
            }

            $pedido->forma_pagamento = $pedido->formas_pagamento[0];


            $pedidos[] = $pedido;
        }

        return $pedidos;
    }

    public static function getRemessasDeLote($con, $ids, $filtro = "", $ordem = "") {

        $produtos = "(0";

        foreach ($ids as $key => $value) {
            $produtos .= ",$value";
        }

        $produtos .= ")";

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
                . "lote.id_produto "
                . "FROM lote "
                . "LEFT JOIN retirada ON lote.id=retirada.id_lote "
                . "WHERE lote.id_produto IN $produtos AND lote.excluido = false ";

        if ($filtro != "") {

            $sql .= "AND $filtro ";
        }

        $sql .= "GROUP BY lote.id ";

        if ($ordem != "") {

            $sql .= "ORDER BY $ordem ";
        }

        $remessas = array();

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id, $numero, $rua, $altura, $validade, $entrada, $grade, $quantidade_inicial, $quantidade_real, $codigo_fabricante, $retirada, $id_produto);

        while ($ps->fetch()) {

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
            $lote->produto = null;
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

            if (!isset($remessas[$id_produto])) {
                $remessas[$id_produto] = array();
            }

            $remessas[$id_produto][] = $lote;
        }

        $retorno = array();

        foreach ($remessas as $key => $value) {

            $remessa = new stdClass();
            $remessa->id_produto = $key;
            $remessa->lotes = array();

            foreach ($value as $key2 => $value2) {
                $remessa->lotes[] = $value2;
            }

            $retorno[] = $remessa;
        }

        return $retorno;
    }

    public static function getCompraParceiros($con) {

        $cm = new CacheManager();

        $g = $cm->getCache('compra_parceiros');

        if ($g !== null) {

            return $g;
        }

        $vencidos = "(0";
        $ps = $con->getConexao()->prepare("SELECT k.id_produto FROM (SELECT id_produto,MAX(validade) as 'val' FROM lote GROUP BY id_produto) k WHERE k.val<CURRENT_DATE");
        $ps->execute();
        $ps->bind_result($id_produto);
        while ($ps->fetch()) {
            $vencidos .= "," . $id_produto;
        }
        $vencidos .= ")";

        $empresas = array();

        $ps = $con->getConexao()->prepare("SELECT "
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
                . "FROM empresa "
                . "INNER JOIN endereco ON endereco.id_entidade=empresa.id AND endereco.tipo_entidade='EMP' "
                . "INNER JOIN email ON email.id_entidade=empresa.id AND email.tipo_entidade='EMP' "
                . "INNER JOIN telefone ON telefone.id_entidade=empresa.id AND telefone.tipo_entidade='EMP' "
                . "INNER JOIN cidade ON endereco.id_cidade=cidade.id "
                . "INNER JOIN estado ON cidade.id_estado = estado.id "
                . "WHERE empresa.vende_para_fora = true");
        $ps->execute();
        $ps->bind_result($id_empresa, $tipo_empresa, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        while ($ps->fetch()) {

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

            $empresas[] = $empresa;
        }

        $ps->close();

        $categorias_loja = "(0";
        $categorias = Sistema::getCategoriaProduto();

        foreach ($categorias as $key => $value) {
            if ($value->loja) {
                $categorias_loja .= ",$value->id";
            }
        }

        $categorias_loja .= ")";

        $produtos = array();

        foreach ($empresas as $key => $value) {

            $prods = $value->getProdutos($con, 0, 500000, 'produto.id_categoria IN ' . $categorias_loja . ' AND produto.id NOT IN ' . $vencidos, '');

            foreach ($prods as $key2 => $value2) {

                $produtos[] = $value2;
            }
        }


        $cm->setCache('compra_parceiros', $produtos);

        return $produtos;
    }

    public static function getHtml($nom, $p = null) {

        global $obj;
        $obj = $p;

        $servico = realpath('../html_email');
        $servico .= "/$nom.php";

        ob_start();
        include($servico);
        $html = ob_get_clean();

        return utf8_decode($html);
    }

    public static function finalizarNotas($con, $notas) {



        for ($i = 0; $i < count($notas); $i++) {

            $value = $notas[$i];

            if ($value->emitida || $value->cancelada)
                continue;


            $value->merge($con);

            if ($value->saida) {

                $value->emitir($con);
            } else {

                $value->manifestar($con);
            }

            if (isset($value->inverter)) {

                $emp = new Empresa($value->inverter);
                $nota = $value->inverteOperacao($con, $emp);
                $nota->calcularImpostosAutomaticamente();
                $nota->emitida = false;
                $nota->cancelada = false;
                $notas[] = $nota;
            }
        }
    }

    public static function getPedidoEntradaSemelhante($con, $empresa, $xml) {

        if (!isset($xml->nfeProc->NFe)) {

            throw new Exception('XML em formato incorreto');
        }

        $nfe = $xml->nfeProc->NFe;

        $inf = $nfe->infNFe;

        if ($inf->ide->tpNF != "1") {

            throw new Exception('A Nota nao e de saida');
        }

        $cnpj_empresa = new CNPJ($inf->dest->CNPJ);
        $id_empresa = $empresa->id;

        if ($empresa->cnpj->valor !== $cnpj_empresa->valor) {

            $ps = $con->getConexao()->prepare("SELECT empresa.id FROM empresa INNER JOIN produto ON produto.id_empresa=empresa.id WHERE produto.id_logistica=$empresa->id AND empresa.cnpj='" . $cnpj_empresa->valor . "'");
            $ps->execute();
            $ps->bind_result($ide);
            if ($ps->fetch()) {
                $id_empresa = $ide;
            } else {
                $ps->close();
                throw new Exception('A Nota nao e dessa empresa, e nem de uma afiliada');
            }
            $ps->close();
        }

        $escolhido = -1;

        $possiveis = array();

        $cnpj_transportadora = new CNPJ($inf->transp->transporta->CNPJ);

        $ps = $con->getConexao()->prepare("SELECT pedido_entrada.id FROM pedido_entrada INNER JOIN transportadora ON pedido_entrada.id_transportadora=transportadora.id WHERE transportadora.cnpj='" . $cnpj_transportadora->valor . "' AND pedido_entrada.id_empresa=$id_empresa AND id_status<=2");
        $ps->execute();
        $ps->bind_result($idt);
        while ($ps->fetch()) {
            $possiveis[] = $idt;
        }
        $ps->close();

        if (count($possiveis) == 0) {

            throw new Exception('Nao foi encontrado nenhum pedido de compra equivalente, com o CNPJ dessa transportadora');
        } else if (count($possiveis) == 1) {

            $escolhido = $possiveis[0];
        } else {

            $in = "(-1";
            foreach ($possiveis as $key => $value) {
                $in .= ",$value";
            }
            $in .= ")";

            $cnpj_fornecedor = new CNPJ($inf->emit->CNPJ);

            $possiveis = array();
            $ps = $con->getConexao()->prepare("SELECT pedido_entrada.id FROM pedido_entrada INNER JOIN fornecedor ON fornecedor.id=pedido_entrada.id_fornecedor WHERE pedido_entrada.id IN $in AND fornecedor.cnpj='" . $cnpj_fornecedor->valor . "'");
            $ps->execute();
            $ps->bind_result($idp);
            while ($ps->fetch()) {
                $possiveis[] = $idp;
            }
            $ps->close();

            if (count($possiveis) == 0) {

                throw new Exception('Nao foi encontrado nenhum pedido de compra equivalente, com o CNPJ desse fornecedor');
            } else if (count($possiveis) == 1) {

                $escolhido = $possiveis[0];
            } else {

                $in = "(-1";
                foreach ($possiveis as $key => $value) {
                    $in .= ",$value";
                }
                $in .= ")";

                $produtos = array();

                if (!is_array($inf->det)) {
                    $inf->det = array($inf->det);
                }

                $total = 0;
                foreach ($inf->det as $key => $value) {

                    $value = $value->prod;

                    if (!isset($produtos[$value->cProd])) {

                        $p = new stdClass();
                        $p->id = $value->cProd;
                        $p->nome = $value->xProd;
                        $p->valor = doubleval($value->vUnCom . "");
                        $p->quantidade = 0;
                        $p->total = 0;

                        $produtos[$p->id] = $p;
                    }

                    $produtos[$value->cProd]->quantidade += doubleval($value->qCom . "");
                    $produtos[$value->cProd]->total += doubleval($value->qCom . "") * $produtos[$value->cProd]->valor;
                    $total += doubleval($value->qCom . "") * $produtos[$value->cProd]->valor;
                }

                $ps = $con->getConexao()->prepare("SELECT k.id FROM (SELECT produto_pedido_entrada.id_pedido as 'id',SUM(produto_pedido_entrada.valor*produto_pedido_entrada.quantidade) as 'soma' FROM produto_pedido_entrada WHERE produto_pedido_entrada.id_pedido IN $in GROUP BY produto_pedido_entrada.id_pedido) k WHERE (k.soma-0.5)<$total AND (k.soma+0.5)>$total");
                $ps->execute();

                $ps->bind_result($idp);
                if ($ps->fetch()) {
                    $escolhido = $idp;
                    $ps->close();
                } else {
                    $ps->close();
                    throw new Exception('Nao foi possivel selecionar o pedido de compra devido ao valor nao estar batendo ');
                }
            }
        }

        $e = new Empresa($id_empresa, new ConnectionFactory());

        $pedido = $e->getPedidosEntrada($con, 0, 1, "pedido_entrada.id=$escolhido");
        $pedido = $pedido[0];

        $nota = new Nota();
        $nota->numero = $inf->ide->nNF;
        $nota->transportadora = $pedido->transportadora;
        $nota->protocolo = $nfe->protNFe->infProt->nProt;
        $nota->saida = false;
        $nota->chave = explode('e', $inf->Id);
        $nota->chave = $nota->chave[1];

        $ps = $con->getConexao()->prepare("SELECT id FROM nota WHERE chave='$nota->chave' AND nota.excluida = false");
        $ps->execute();
        $ps->bind_result($t);
        if ($ps->fetch()) {
            $ps->close();
            throw new Exception('Ja existem operacoes realizadas referentes a essa NFe');
        }
        $ps->close();

        $nota->fornecedor = $pedido->fornecedor;
        $nota->emitida = false;
        $nota->forma_pagamento = Sistema::getFormasPagamento();
        $nota->forma_pagamento = $nota->forma_pagamento[0];
        $nota->interferir_estoque = false;
        $nota->empresa = $e;
        $nota->frete_destinatario_remetente = $pedido->frete_incluso;

        $vencimentos = array();
        $cobr = $inf->cobr->dup;
        if (!is_array($cobr)) {
            $cobr = array($cobr);
        }

        foreach ($cobr as $key => $value) {
            $v = new Vencimento();
            $v->nota = $nota;
            $v->valor = doubleval($value->vDup . "");
            $v->data = strtotime($value->dVenc) * 1000;
            $vencimentos[] = $v;
        }

        $nota->vencimentos = $vencimentos;

        $pp = $pedido->getProdutos($con);
        $pedido->produtos = $pp;
        $produtos = array();

        $logisticas = array();
        $logs = array();

        $dets = array();
        $dets_n = array();

        if (!is_array($inf->det)) {
            $inf->det = array($inf->det);
        }

        foreach ($inf->det as $key => $value) {

            $value = $value->prod;

            if (!isset($produtos[$value->cProd])) {

                $p = new stdClass();
                $p->id = $value->cProd;
                $p->nome = $value->xProd;
                $p->cfop = $value->CFOP;
                $p->valor = doubleval($value->vUnCom . "");
                $p->quantidade = 0;
                $p->total = 0;

                $dets[$p->id] = $p;
                $dets_n[] = $p;
            }

            $dets[$value->cProd]->quantidade += doubleval($value->qCom . "");
            $dets[$value->cProd]->total += doubleval($value->qCom . "") * $produtos[$value->cProd]->valor;
        }

        foreach ($pp as $key => $value) {

            $pn = new ProdutoNota();
            $pn->cfop = (isset($dets_n[$key]) ? $dets_n[$key]->cfop : "5152"); //verificar esse ponto aqui
            $pn->valor_unitario = doubleval($value->valor . "");
            $pn->quantidade = doubleval($value->quantidade . "");
            $pn->nota = $nota;
            $pn->valor_total = $pn->valor_unitario * $pn->quantidade;
            $pn->produto = $value->produto;

            $produtos[] = $pn;

            if ($value->produto->logistica !== null) {
                if (!isset($logisticas[$value->produto->logistica->id])) {
                    $nl = Utilidades::copyId0($nota);
                    $nl->emitida = false;
                    $nl->chave = "";
                    $nl->protocolo = "";
                    $nl->saida = true;
                    $nl->empresa = $e;
                    $nl->fornecedor = null;
                    $gt = new Getter($nl->empresa);
                    $nl->cliente = $gt->getClienteViaEmpresa($con, $value->produto->logistica);
                    $nl->observacao = "Nota referente a remessa da empresa " . $id_empresa;
                    $nl->produtos = array();
                    $logisticas[$value->produto->logistica->id] = $nl;
                    $logs[$value->produto->logistica->id] = $value->produto->logistica;
                }
                $n = $logisticas[$value->produto->logistica->id];
                $p = Utilidades::copyId0($pn);
                $p->nota = $logisticas[$value->produto->logistica->id];
                $n->produtos[] = $p;
            }
        }

        $rl = array();

        foreach ($logisticas as $key => $value) {
            $value->igualaVencimento();
            $value->calcularImpostosAutomaticamente();
            $value->inverter = $logs[$key]->id;
            $rl[] = $value;
            $inv = $value->inverteOperacao($con, $logs[$key]);
            $inv->calcularImpostosAutomaticamente();
            $inv->cancelada = true;
            $rl[] = $inv;
        }

        $nota->produtos = $produtos;
        $nota->calcularImpostosAutomaticamente();
        $pedido->nota = $nota;
        $pedido->notas_logisticas = $rl;


        return array($pedido);
    }

    public static function getMesesValidadeCurta() {

        return 4;
    }

    public static function getPedidosAcompanhamento($con, $emp, $x1, $x2, $filtro = "", $ordem = "") {

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
                . "cliente.id,"
                . "cliente.codigo, "
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
                . "transportadora.id,"
                . "transportadora.codigo, "
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
                . "email_usu.senha, "
                . "empresa.id,"
                . "empresa.tipo_empresa,"
                . "empresa.nome,"
                . "empresa.inscricao_estadual,"
                . "empresa.consigna,"
                . "empresa.aceitou_contrato,"
                . "empresa.juros_mensal,"
                . "empresa.cnpj,"
                . "endereco_empresa.numero,"
                . "endereco_empresa.id,"
                . "endereco_empresa.rua,"
                . "endereco_empresa.bairro,"
                . "endereco_empresa.cep,"
                . "cidade_empresa.id,"
                . "cidade_empresa.nome,"
                . "estado_empresa.id,"
                . "estado_empresa.sigla,"
                . "email_empresa.id,"
                . "email_empresa.endereco,"
                . "email_empresa.senha,"
                . "telefone_empresa.id,"
                . "telefone_empresa.numero "
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
                . "INNER JOIN empresa ON pedido.id_empresa=empresa.id "
                . "INNER JOIN endereco endereco_empresa ON endereco_empresa.id_entidade=empresa.id AND endereco_empresa.tipo_entidade='EMP' "
                . "INNER JOIN email email_empresa ON email_empresa.id_entidade=empresa.id AND email_empresa.tipo_entidade='EMP' "
                . "INNER JOIN telefone telefone_empresa ON telefone_empresa.id_entidade=empresa.id AND telefone_empresa.tipo_entidade='EMP' "
                . "INNER JOIN cidade cidade_empresa ON endereco_empresa.id_cidade=cidade_empresa.id "
                . "INNER JOIN estado estado_empresa ON cidade_empresa.id_estado = estado_empresa.id "
                . "WHERE cliente.cnpj='" . $emp->cnpj->valor . "' AND pedido.excluido = false ";

        if ($filtro != "") {

            $sql .= "AND $filtro ";
        }

        if ($ordem != "") {

            $sql .= "ORDER BY $ordem ";
        }

        $sql .= "LIMIT $x1, " . ($x2 - $x1);


        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id_pedido, $id_log, $id_nota, $frete_incluso, $data, $prazo, $parcelas, $id_status, $id_forma_pagamento, $frete, $obs, $id_cliente, $cod_cli, $nome_cliente, $nome_fantasia_cliente, $limite, $inicio, $fim, $pessoa_fisica, $cpf, $cnpj, $rg, $ie, $suf, $i_suf, $cat_id, $cat_nome, $end_cli_id, $end_cli_rua, $end_cli_numero, $end_cli_bairro, $end_cli_cep, $cid_cli_id, $cid_cli_nome, $est_cli_id, $est_cli_nome, $tra_id, $cod_tra, $tra_nome, $tra_nome_fantasia, $tra_despacho, $tra_cnpj, $tra_habilitada, $tra_ie, $end_tra_id, $end_tra_rua, $end_tra_numero, $end_tra_bairro, $end_tra_cep, $cid_tra_id, $cid_tra_nome, $est_tra_id, $est_tra_nome, $id_usu, $nome_usu, $login_usu, $senha_usu, $cpf_usu, $end_usu_id, $end_usu_rua, $end_usu_numero, $end_usu_bairro, $end_usu_cep, $cid_usu_id, $cid_usu_nome, $est_usu_id, $est_usu_nome, $email_cli_id, $email_cli_end, $email_cli_senha, $email_tra_id, $email_tra_end, $email_tra_senha, $email_usu_id, $email_usu_end, $email_usu_senha, $id_empresa_empresa, $tipo_empresa_empresa, $nome_empresa_empresa, $inscricao_empresa_empresa, $consigna_empresa, $aceitou_contrato_empresa, $juros_mensal_empresa, $cnpj_empresa, $numero_endereco_empresa, $id_endereco_empresa, $rua_empresa, $bairro_empresa, $cep_empresa, $id_cidade_empresa, $nome_cidade_empresa, $id_estado_empresa, $nome_estado_empresa, $id_email_empresa, $endereco_email_empresa, $senha_email_empresa, $id_telefone_empresa, $numero_telefone_empresa);


        $pedidos = array();
        $transportadoras = array();
        $usuarios = array();
        $clientes = array();

        while ($ps->fetch()) {

            $empresa = Sistema::getEmpresa($tipo_empresa_empresa);

            $empresa->id = $id_empresa_empresa;
            $empresa->cnpj = new CNPJ($cnpj_empresa);
            $empresa->inscricao_estadual = $inscricao_empresa_empresa;
            $empresa->nome = $nome_empresa_empresa;
            $empresa->aceitou_contrato = $aceitou_contrato_empresa;
            $empresa->juros_mensal = $juros_mensal_empresa;
            $empresa->consigna = $consigna_empresa;

            $endereco_empresa = new Endereco();
            $endereco_empresa->id = $id_endereco_empresa;
            $endereco_empresa->rua = $rua_empresa;
            $endereco_empresa->bairro = $bairro_empresa;
            $endereco_empresa->cep = new CEP($cep_empresa);
            $endereco_empresa->numero = $numero_endereco_empresa;

            $cidade_empresa = new Cidade();
            $cidade_empresa->id = $id_cidade_empresa;
            $cidade_empresa->nome = $nome_cidade_empresa;

            $estado_empresa = new Estado();
            $estado_empresa->id = $id_estado_empresa;
            $estado_empresa->sigla = $nome_estado_empresa;

            $cidade_empresa->estado = $estado_empresa;

            $endereco_empresa->cidade = $cidade_empresa;

            $empresa->endereco = $endereco_empresa;

            $email_empresa = new Email($endereco_email_empresa);
            $email_empresa->id = $id_email_empresa;
            $email_empresa->senha = $senha_email_empresa;

            $empresa->email = $email_empresa;

            $telefone_empresa = new Telefone($numero_telefone_empresa);
            $telefone_empresa->id = $id_telefone_empresa;

            $empresa->telefone = $telefone_empresa;

            //------------------------

            $cliente = new Cliente();
            $cliente->id = $id_cliente;
            $cliente->codigo = $cod_cli;
            $cliente->cnpj = new CNPJ($cnpj);
            $cliente->cpf = new CPF($cpf);
            $cliente->rg = new RG($rg);
            $cliente->pessoa_fisica = $pessoa_fisica == 1;
            $cliente->nome_fantasia = $nome_fantasia_cliente;
            $cliente->razao_social = $nome_cliente;
            $cliente->empresa = $empresa;
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
            $transportadora->codigo = $cod_tra;
            $transportadora->cnpj = new CNPJ($tra_cnpj);
            $transportadora->despacho = $tra_despacho;
            $transportadora->email = new Email($email_tra_end);
            $transportadora->email->id = $email_tra_id;
            $transportadora->email->senha = $email_tra_senha;
            $transportadora->habilitada = $tra_habilitada == 1;
            $transportadora->inscricao_estadual = $tra_ie;
            $transportadora->nome_fantasia = $tra_nome_fantasia;
            $transportadora->razao_social = $tra_nome;
            $transportadora->empresa = $empresa;

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
            $usuario->id = $id_usu;
            $usuario->login = $login_usu;
            $usuario->senha = $senha_usu;
            $usuario->nome = $nome_usu;
            $usuario->empresa = $empresa;

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
            $pedido->empresa = $empresa;
            $pedido->id_nota = $id_nota;

            $formas_pagamento = Sistema::getFormasPagamento();

            foreach ($formas_pagamento as $key => $forma) {
                if ($forma->id == $id_forma_pagamento) {
                    $pedido->forma_pagamento = $forma;
                    break;
                }
            }

            $pedido->frete = $frete;
            $pedido->frete_incluso = $frete_incluso == 1;
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

            $telefone = new Telefone($numero);
            $telefone->id = $id;


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

        foreach ($usuarios as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $value2->permissoes = Sistema::getPermissoes($value2->empresa);
            }
        }

        $ps = $con->getConexao()->prepare("SELECT id_usuario, id_permissao,incluir,deletar,alterar,consultar FROM usuario_permissao WHERE id_usuario IN ($in_usu)");
        $ps->execute();
        $ps->bind_result($id_usuario, $id_permissao, $incluir, $deletar, $alterar, $consultar);

        while ($ps->fetch()) {

            foreach ($usuarios[$id_usuario] as $key => $usu) {

                $permissoes = $usu->permissoes;

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
            }
        }

        $ps->close();

        return $pedidos;
    }

    public static function getCountPedidosAcompanhamento($con, $emp, $filtro = "") {

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
                . "WHERE cliente.cnpj='" . $emp->cnpj->valor . "' AND pedido.excluido=false ";

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

    public static function mergeArquivo($nome, $conteudo, $b64 = true) {

        $handle = fopen('../uploads/' . $nome, 'a');
        $c = $conteudo;
        if ($b64) {
            $c = Utilidades::base64decode($c);
        }
        fwrite($handle, $c);
        fflush($handle);
        fclose($handle);
    }

    public static function getMicroServicoJava($nome, $parametros = null) {

        $servico = realpath('../micro_servicos_java');
        $servico .= "/$nome.jar";
        $comando = "java -jar \"$servico\"";

        if ($parametros !== null) {
            $comando .= " \"" . $parametros . "\"";
        } else {
            $comando .= " 200";
        }

        exec($comando, $output);

        return $output[0];
    }

    public static function getEtiquetas($etiquetas) {

        $caminho = realpath("../uploads");
        $arquivo = "etiqueta_" . round(microtime(true) * 1000) . ".pdf";
        $caminho_completo = $caminho . "/$arquivo";



        $request = new stdClass();
        $request->arquivo = $caminho_completo;
        $request->etiquetas = $etiquetas;

        $final_request = Utilidades::toJson($request);
        $final_request = addslashes($final_request);

        $resp = Utilidades::fromJson(self::getMicroServicoJava('GeradorEtiqueta', $final_request));

        if (!$resp->sucesso) {

            throw new Exception('falha');
        } else {

            return $arquivo;
        }
    }

    public static function getHistorico($con) {

        $historicos = array();

        $ps = $con->getConexao()->prepare("SELECT id,nome FROM historico WHERE excluido = false");
        $ps->execute();
        $ps->bind_result($id, $nome);

        while ($ps->fetch()) {

            $historico = new Historico();
            $historico->id = $id;
            $historico->nome = $nome;

            $historicos[] = $historico;
        }

        $ps->close();

        return $historicos;
    }

    public static function getOperacoes($con) {

        $operacoes = array();

        $ps = $con->getConexao()->prepare("SELECT id,nome,debito FROM operacao WHERE excluida=false");
        $ps->execute();
        $ps->bind_result($id, $nome, $debito);

        while ($ps->fetch()) {

            $operacao = new Operacao();
            $operacao->id = $id;
            $operacao->nome = $nome;
            $operacao->debito = $debito;

            $operacoes[] = $operacao;
        }

        $ps->close();

        return $operacoes;
    }

    public static function getStatusCanceladoPedidoEntrada() {

        $st = Sistema::getStatusPedidoEntrada();
        return $st[3];
    }

    public static function relacionarFilial($empresa1, $empresa2) {

        $con = new ConnectionFactory();

        $ps = $con->getConexao()->prepare("INSERT INTO filial(id_empresa1,id_empresa2) VALUES($empresa1->id,$empresa2->id)");
        $ps->execute();
        $ps->close();
    }

    public static function inserirClienteRTC($con, $cliente) {

        $ps = $con->getConexao()->prepare("SELECT id FROM empresa WHERE cnpj='" . $cliente->cnpj->valor . "'");
        $ps->execute();
        $ps->bind_result($id);

        if ($ps->fetch()) {
            $ps->close();
            throw new Exception("Essa empresa ja tem cadastro");
        }
        $ps->close();

        $ps = $con->getConexao()->prepare("SELECT id FROM usuario WHERE login='" . $cliente->login . "' AND senha='" . $cliente->senha . "'");
        $ps->execute();
        $ps->bind_result($id);

        if ($ps->fetch()) {
            $ps->close();
            throw new Exception("Ja existe alguem com o mesmo login e senha");
        }
        $ps->close();

        $empresa = Sistema::getEmpresa(7);
        $empresa->nome = $cliente->razao_social;
        $empresa->cnpj = $cliente->cnpj;
        $empresa->endereco = Utilidades::copyId0($cliente->endereco);
        $empresa->inscricao_estadual = $cliente->inscricao_estadual;
        $empresa->tem_suframa = $cliente->suframado;
        if (count($cliente->telefones) > 0) {
            $empresa->telefone = $cliente->telefones[0];
        }
        $empresa->aceitou_contrato = false;
        $empresa->email = Utilidades::copyId0($cliente->email);

        $empresa->merge($con);

        $empresa->setLogo($con, 'http://www.tratordecompras.com.br/renew/Status_3/php/uploads/arquivo_15501989058192.png');

        $rtc = Sistema::getRTCS();
        $rtc = $rtc[0];
        $empresa->setRTC($con, $rtc);

        $u = new Usuario();
        $u->nome = $empresa->nome;
        $u->empresa = $empresa;
        $u->email = Utilidades::copyId0($cliente->email);
        $u->endereco = Utilidades::copyId0($cliente->endereco);
        $u->telefones = Utilidades::copyId0($cliente->telefones);
        $u->login = $cliente->login;
        $u->senha = $cliente->senha;
        $u->cpf = $cliente->cpf;
        $u->permissoes = $rtc->permissoes;

        foreach ($u->permissoes as $key => $value) {
            $value->in = true;
            $value->alt = true;
            $value->del = true;
            $value->cons = true;
        }

        $u->merge($con);
    }

    public static function getClienteCadastro($con, $parametro) {

        $sql = "SELECT "
                . "cliente.id,"
                . "cliente.codigo_contimatic,"
                . "cliente.codigo,"
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
                . "WHERE (email_cliente.endereco like '%Compras%$parametro,' OR email_cliente.endereco like '%Compras%$parametro' OR email_cliente.endereco like '%Compras%$parametro;') AND cliente.excluido=false";

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id_cliente, $cod_ctm, $cod_cli, $nome_cliente, $nome_fantasia_cliente, $limite, $inicio, $fim, $pessoa_fisica, $cpf, $cnpj, $rg, $ie, $suf, $i_suf, $cat_id, $cat_nome, $end_cli_id, $end_cli_rua, $end_cli_numero, $end_cli_bairro, $end_cli_cep, $cid_cli_id, $cid_cli_nome, $est_cli_id, $est_cli_nome, $email_cli_id, $email_cli_end, $email_cli_senha);

        $clientes = array();

        while ($ps->fetch()) {

            $cliente = new Cliente();
            $cliente->id = $id_cliente;
            $cliente->codigo_contimatic = $cod_ctm;
            $cliente->codigo = $cod_cli;
            $cliente->cnpj = new CNPJ($cnpj);
            $cliente->cpf = new CPF($cpf);
            $cliente->rg = new RG($rg);
            $cliente->pessoa_fisica = $pessoa_fisica == 1;
            $cliente->nome_fantasia = $nome_fantasia_cliente;
            $cliente->razao_social = $nome_cliente;
            $cliente->empresa = null;
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

            $telefone = new Telefone($numero);
            $telefone->id = $id;


            $v[$id_entidade]->telefones[] = $telefone;
        }
        $ps->close();

        $real = array();

        foreach ($clientes as $key => $value) {

            $real[] = $value;
        }

        return $real;
    }

    public static function getPragas($con) {

        $pragas = array();

        $ps = $con->getConexao()->prepare("SELECT id,nome FROM praga WHERE excluida = false ORDER BY nome");
        $ps->execute();
        $ps->bind_result($id, $nome);

        while ($ps->fetch()) {

            $praga = new Praga();
            $praga->id = $id;
            $praga->nome = $nome;

            $pragas[] = $praga;
        }

        $ps->close();

        return $pragas;
    }

    public static function getCategoriaCliente($con) {

        $cats = array();

        $ps = $con->getConexao()->prepare("SELECT id,nome FROM categoria_cliente WHERE excluida = false ORDER BY nome");
        $ps->execute();
        $ps->bind_result($id, $nome);

        while ($ps->fetch()) {

            $cat = new CategoriaCliente();
            $cat->id = $id;
            $cat->nome = $nome;

            $cats[] = $cat;
        }

        $ps->close();

        return $cats;
    }

    public static function getCulturas($con) {

        $culturas = array();

        $ps = $con->getConexao()->prepare("SELECT id,nome FROM cultura WHERE excluida = false ORDER BY nome");
        $ps->execute();
        $ps->bind_result($id, $nome);

        while ($ps->fetch()) {

            $cultura = new Cultura();
            $cultura->id = $id;
            $cultura->nome = $nome;

            $culturas[] = $cultura;
        }

        $ps->close();

        return $culturas;
    }

    public static function getStatusPedidoEntrada() {

        $status = array();

        $status[] = new StatusPedidoEntrada(1, "Confirmacao de pedido", false, false, true);
        $status[] = new StatusPedidoEntrada(2, "Em transito", false, true, false);
        $status[] = new StatusPedidoEntrada(3, "Finalizado", true, false, false);
        $status[] = new StatusPedidoEntrada(4, "Cancelado", false, false, true);

        return $status;
    }

    public static function getFormasPagamento() {

        $formas = array();

        $formas[] = new BoletoEspecialAgroFauna();
        $formas[] = new DepositoEmConta();

        return $formas;
    }

    public static function getIcmsEstado($estado) {

        $doze = array("MG", "RS", "SC", "RJ", "PB");

        if (in_array($estado->sigla, $doze)) {

            return 12;
        }

        return 7;
    }

    public static function getMarketings($con) {

        $mkts = array();

        $ps = $con->getConexao()->prepare("SELECT "
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
                . "FROM empresa "
                . "INNER JOIN endereco ON endereco.id_entidade=empresa.id AND endereco.tipo_entidade='EMP' "
                . "INNER JOIN email ON email.id_entidade=empresa.id AND email.tipo_entidade='EMP' "
                . "INNER JOIN telefone ON telefone.id_entidade=empresa.id AND telefone.tipo_entidade='EMP' "
                . "INNER JOIN cidade ON endereco.id_cidade=cidade.id "
                . "INNER JOIN estado ON cidade.id_estado = estado.id "
                . "WHERE empresa.tipo_empresa=2");
        $ps->execute();

        $ps->bind_result($id_empresa, $tipo_empresa, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        while ($ps->fetch()) {

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

            $mkts[] = $empresa;
        }

        $ps->close();

        return $mkts;
    }

    public static function getCategoriaDocumentos() {

        $cats = array();

        $cats[] = new CategoriaDocumento(1, "NFE");
        $cats[] = new CategoriaDocumento(2, "Certificado Comerciante de Agrotoxico");
        $cats[] = new CategoriaDocumento(3, "Documentos Empresariais");
        $cats[] = new CategoriaDocumento(4, "Balanco");

        return $cats;
    }

    public static function getEmailSistema() {

        $email = new Email("renan.miranda@agrofauna.com.br");
        $email->senha = "5hynespt";

        return $email;
    }

    public static function getRTCS() {
        RTC::$RTCS = array();
        return array(new RTC(1, array(
                Sistema::P_CLIENTE(),
                Sistema::P_FORNECEDOR(),
                Sistema::P_TRANSPORTADORA(),
                Sistema::P_PEDIDO_SAIDA(),
                Sistema::P_PEDIDO_ENTRADA(),
                Sistema::P_LOGO(),
                Sistema::P_PRODUTO())
            ), new RTC(2, array(
                Sistema::P_CAMPANHA(),
                Sistema::P_CATEGORIA_CLIENTE(),
                Sistema::P_CATEGORIA_PRODUTO(),
                Sistema::P_CATEGORIA_DOCUMENTO(),
                Sistema::P_CONFIGURACAO_EMPRESA(),
                Sistema::P_COTACAO())
            ), new RTC(3, array(
                Sistema::P_GRUPO_CIDADE(),
                Sistema::P_CFG(),
                Sistema::P_TABELA())
            ), new RTC(4, array(
                Sistema::P_NOTA(),
                Sistema::P_ENTRADA_NFE()
                    )), new RTC(5, array(
                Sistema::P_BANCO(),
                Sistema::P_RELATORIO_FINANCEIRO(),
                Sistema::P_RELATORIO_MOVIMENTO(),
                Sistema::P_MOVIMENTO()
                    )), new RTC(6, array(
                Sistema::P_LOTE(),
                Sistema::P_SEPARACAO(),
                Sistema::P_EXPORTAR_LANCAMENTO(),
                Sistema::P_CONTROLADOR_TAREFAS(),
                Sistema::P_ORGANOGRAMA(),
                Sistema::P_ORGANOGRAMA_TOTAL(),
                Sistema::P_EXPEDIENTE(),
                Sistema::P_TAREFAS()
                    )), new RTC(7, array(
                Sistema::P_GERENCIADOR()
        )));
    }

    public static function getPermissoes($empresa = null) {

        $perms = array();

        if ($empresa !== null) {
            $rtc = $empresa->getRTC(new ConnectionFactory());
            foreach ($rtc->permissoes as $key => $value) {
                $perms[] = Utilidades::copy($value);
            }

            foreach ($empresa->permissoes_especiais as $key => $value) {
                if ($key < $rtc->numero) {
                    foreach ($value as $key2 => $value2) {
                        $perms[] = Utilidades::copy($value2);
                    }
                }
            }
        }

        return $perms;
    }

    public static function getStatusExcluidoPedidoSaida() {

        return new StatusPedidoSaida(30, "Excluido", false, false, false, true);
    }

    public static function getStatusPedidoSaida() {

        $status = array();

        $status[] = new StatusPedidoSaida(1, "Confirmacao de pedido", false, true, Email::$COMPRAS, Email::$VENDAS, true, true, false, false);
        $status[] = new StatusPedidoSaida(2, "Limite de credito", false, true, Email::$COMPRAS, Email::$FINANCEIRO, true, true, false, false);
        $status[] = new StatusPedidoSaida(3, "Autorizacao de pedido", false, Email::$COMPRAS, Email::$DIRETORIA, false, true, true, false, false);
        $status[] = new StatusPedidoSaida(4, "Confirmacao de pagamento", false, Email::$FINANCEIRO, Email::$FINANCEIRO, false, true, true, false, false);
        $status[] = new StatusPedidoSaida(5, "Separacao", false, Email::$COMPRAS, Email::$LOGISTICA, false, false, false, false, false);
        $status[] = new StatusPedidoSaida(6, "Faturamento", true, Email::$COMPRAS, Email::$LOGISTICA, false, false, false, false, true);
        $status[] = new StatusPedidoSaida(7, "Coleta", true, Email::$COMPRAS, Email::$LOGISTICA, true, false, false, false, true);
        $status[] = new StatusPedidoSaida(8, "Rastreio", true, Email::$COMPRAS, Email::$LOGISTICA, false, false, false, false, true);
        $status[] = new StatusPedidoSaida(9, "Finalizado", true, Email::$COMPRAS, Email::$LOGISTICA, false, false, false, true, true);
        $status[] = new StatusPedidoSaida(10, "Cancelado", false, Email::$COMPRAS, Email::$VENDAS, true, false, false, true, false);
        $status[] = new StatusPedidoSaida(11, "Orcamento", false, Email::$COMPRAS, Email::$VENDAS, true, true, true, false, false);
        $status[] = new StatusPedidoSaida(30, "Excluido", false, Email::$COMPRAS, Email::$VENDAS, true, false, false, true, false);


        return $status;
    }

    public static function getStatusCotacaoEntrada() {

        $sts = array();

        $sts[] = new StatusCotacaoEntrada(1, "Aguardando resposta", true);
        $sts[] = new StatusCotacaoEntrada(2, "Respondida", false);
        $sts[] = new StatusCotacaoEntrada(3, "Pedido fechado", false);
        $sts[] = new StatusCotacaoEntrada(4, "Cancelada", true);

        return $sts;
    }

    public static function CATP_AGRICOLA() {

        $cat = new CategoriaProduto();
        $cat->nome = "Agricola";
        $cat->id = 1164;
        $cat->base_calculo = 40;
        $cat->parametros_agricolas = true;
        $cat->loja = true;
        return $cat;
    }

    public static function CATP_AGRICOLA_IMPORTADO() {

        $cat = new CategoriaProduto();
        $cat->nome = "Agricola Importado";
        $cat->id = 1165;
        $cat->base_calculo = 100;
        $cat->icms_normal = false;
        $cat->icms = 4;
        $cat->parametros_agricolas = true;
        $cat->loja = true;
        return $cat;
    }

    public static function CATP_AGRICOLA_FORA_LINHA() {

        $cat = new CategoriaProduto();
        $cat->nome = "Agricola Fora de Linha";
        $cat->id = 2;
        $cat->base_calculo = 40;
        $cat->parametros_agricolas = true;
        $cat->loja = false;
        return $cat;
    }

    public static function CATP_OBJETO() {

        $cat = new CategoriaProduto();
        $cat->nome = "Objeto";
        $cat->id = 1166;
        $cat->base_calculo = 100;
        $cat->parametros_agricolas = false;
        $cat->loja = false;
        return $cat;
    }

    public static function CATP_ABSTRATO() {

        $cat = new CategoriaProduto();
        $cat->nome = "Abstrato";
        $cat->id = 4;
        $cat->base_calculo = 100;
        $cat->parametros_agricolas = false;
        $cat->desconta_estoque = false;
        $cat->loja = false;
        $cat->abstrato = true;

        return $cat;
    }

    public static function getCategoriaProduto($empresa = null, $id = -1) {

        $ret = array(Sistema::CATP_OBJETO(), Sistema::CATP_ABSTRATO());

        if ($empresa === null) {

            $ret[] = Sistema::CATP_AGRICOLA();
            $ret[] = Sistema::CATP_AGRICOLA_FORA_LINHA();
            $ret[] = Sistema::CATP_AGRICOLA_IMPORTADO();
        } else {
            $ret[] = Sistema::CATP_AGRICOLA();
            $ret[] = Sistema::CATP_AGRICOLA_FORA_LINHA();
            $ret[] = Sistema::CATP_AGRICOLA_IMPORTADO();
        }
        if ($id < 0) {
            return $ret;
        } else {
            foreach ($ret as $key => $value) {
                if ($value->id === $id) {
                    return $value;
                }
            }
            return null;
        }
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

    public static function getUsuario($filtro) {



        $con = new ConnectionFactory();

        $ses = new SessionManager();

        $sql = "SELECT "
                . "usuario.id,"
                . "usuario.id_cargo,"
                . "usuario.nome,"
                . "usuario.login,"
                . "usuario.senha,"
                . "usuario.cpf,"
                . "endereco_usuario.id,"
                . "endereco_usuario.rua,"
                . "endereco_usuario.numero,"
                . "endereco_usuario.bairro,"
                . "endereco_usuario.cep,"
                . "cidade_usuario.id,"
                . "cidade_usuario.nome,"
                . "estado_usuario.id,"
                . "estado_usuario.sigla,"
                . "email_usu.id,"
                . "email_usu.endereco,"
                . "email_usu.senha,"
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
                . "FROM usuario "
                . "INNER JOIN endereco endereco_usuario ON endereco_usuario.id_entidade=usuario.id AND endereco_usuario.tipo_entidade='USU' "
                . "INNER JOIN cidade cidade_usuario ON endereco_usuario.id_cidade=cidade_usuario.id "
                . "INNER JOIN estado estado_usuario ON estado_usuario.id=cidade_usuario.id_estado "
                . "INNER JOIN email email_usu ON email_usu.id_entidade=usuario.id AND email_usu.tipo_entidade='USU' "
                . "INNER JOIN empresa ON usuario.id_empresa=empresa.id "
                . "INNER JOIN endereco ON endereco.id_entidade=empresa.id AND endereco.tipo_entidade='EMP' "
                . "INNER JOIN email ON email.id_entidade=empresa.id AND email.tipo_entidade='EMP' "
                . "INNER JOIN telefone ON telefone.id_entidade=empresa.id AND telefone.tipo_entidade='EMP' "
                . "INNER JOIN cidade ON endereco.id_cidade=cidade.id "
                . "INNER JOIN estado ON cidade.id_estado = estado.id "
                . "WHERE " . $filtro;

        $ps = $con->getConexao()->prepare($sql);
        $ps->execute();
        $ps->bind_result($id_usu, $id_cargo, $nome_usu, $login_usu, $senha_usu, $cpf_usu, $end_usu_id, $end_usu_rua, $end_usu_numero, $end_usu_bairro, $end_usu_cep, $cid_usu_id, $cid_usu_nome, $est_usu_id, $est_usu_nome, $email_usu_id, $email_usu_end, $email_usu_senha, $id_empresa, $tipo_empresa, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        $usuarios = array();

        while ($ps->fetch()) {

            $usuario = new Usuario();

            $usuario->id_cargo = $id_cargo;
            $usuario->cpf = new CPF($cpf_usu);
            $usuario->email = new Email($email_usu_end);
            $usuario->email->id = $email_usu_id;
            $usuario->email->senha = $email_usu_senha;
            $usuario->id = $id_usu;
            $usuario->login = $login_usu;
            $usuario->senha = $senha_usu;
            $usuario->nome = $nome_usu;

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

            $usuario->empresa = $empresa;

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

        if (count($usuarios) === 0) {

            return null;
        }

        foreach ($usuarios as $key => $value) {
            $value->permissoes = Sistema::getPermissoes($value->empresa);
        }

        $ps = $con->getConexao()->prepare("SELECT id_usuario, id_permissao,incluir,deletar,alterar,consultar FROM usuario_permissao WHERE id_usuario IN ($in_usu)");
        $ps->execute();
        $ps->bind_result($id_usuario, $id_permissao, $incluir, $deletar, $alterar, $consultar);

        while ($ps->fetch()) {

            $permissoes = $usuarios[$id_usuario]->permissoes;

            $p = null;

            foreach ($permissoes as $key => $perm) {
                if ($perm->id === $id_permissao) {
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
        }

        $ps->close();

        $real = array();

        foreach ($usuarios as $key => $value) {

            $real[] = $value;
        }

        if (count($real) > 0) {

            $u = $real[0];

            $u->cargo = Sistema::getCargo($con, $u->empresa, $u->id_cargo);

            $ses->set("usuario", $u);
            $ses->set("empresa", $u->empresa);

            return $u;
        }

        return null;
    }

    public static function getLogisticaById($con, $id) {

        $logs = Sistema::getLogisticas($con, true);

        if (isset($logs[$id])) {
            return $logs[$id];
        }

        return null;
    }

    public static function getLogisticas($con, $id_array = false) {

        $ses = new SessionManager();

        if ($ses->get("logisticas") != null) {

            if ($id_array) {

                return $ses->get("logisticas_id");
            } else {

                return $ses->get("logisticas");
            }
        }

        $ps = $con->getConexao()->prepare("SELECT "
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
                . "FROM empresa "
                . "INNER JOIN endereco ON endereco.id_entidade=empresa.id AND endereco.tipo_entidade='EMP' "
                . "INNER JOIN email ON email.id_entidade=empresa.id AND email.tipo_entidade='EMP' "
                . "INNER JOIN telefone ON telefone.id_entidade=empresa.id AND telefone.tipo_entidade='EMP' "
                . "INNER JOIN cidade ON endereco.id_cidade=cidade.id "
                . "INNER JOIN estado ON cidade.id_estado = estado.id "
                . "WHERE empresa.tipo_empresa=1");
        $ps->execute();

        $empresas = array();
        $empresas_id = array();
        $ps->bind_result($id_empresa, $tipo_empresa, $nome_empresa, $inscricao_empresa, $consigna, $aceitou_contrato, $juros_mensal, $cnpj, $numero_endereco, $id_endereco, $rua, $bairro, $cep, $id_cidade, $nome_cidade, $id_estado, $nome_estado, $id_email, $endereco_email, $senha_email, $id_telefone, $numero_telefone);

        while ($ps->fetch()) {

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


            $empresas[] = $empresa;

            $empresas_id[$id_empresa] = $empresa;
        }

        $ps->close();

        $ses->set("logisticas_id", $empresas_id);
        $ses->set("logisticas", $empresas);

        if ($id_array) {

            return $empresas_id;
        } else {

            return $empresas;
        }
    }

    public static function logar($login, $senha) {

        return Sistema::getUsuario("usuario.login='$login' AND usuario.senha='$senha'");
        
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
