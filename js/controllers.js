rtc.controller("crtFechamentoCaixa", function ($scope, baseService, fechamentoCaixaService, bancoService, movimentosFechamentoService) {

    $scope.fechamentos = createAssinc(fechamentoCaixaService, 1, 5, 10);
    assincFuncs(
            $scope.fechamentos,
            "fechamento_caixa",
            ["id", "valor", "data", "banco.codigo", "banco.nome", "banco.saldo"]);
    $scope.fechamentos.attList();
   
    $scope.movimentos = createAssinc(movimentosFechamentoService, 1, 12, 15);
    assincFuncs(
            $scope.movimentos,
            "movimento",
            ["data","id", "valor", "juros", "descontos", "saldo_anterior", "operacao.nome", "historico.nome"]);

    $scope.bancos = [];

    $scope.banco = null;
    $scope.fechamento = null;


    $scope.setBanco = function (banco) {

        $scope.banco = banco;

        bancoService.getFechamento($scope.banco, function (f) {

            $scope.fechamento = f.fechamento;

        })

        movimentosFechamentoService.banco = $scope.banco;
        $scope.movimentos.attList();
        
    }

    fechamentoCaixaService.getBancosFechar(function (e) {

        $scope.bancos = e.bancos;

        if ($scope.bancos.length > 0) {

            $scope.setBanco($scope.bancos[0]);

        }

    })
    
    $scope.mergeFechamento = function(){
        
        baseService.merge($scope.fechamento,function(s){
            
            if(s.sucesso){
                
                msg.alerta("Banco "+$scope.banco.nome+", fechado com sucesso até a data atual, o sistema ira atualizar a pagina automaticamente.");
                document.location.reload();
                
            }else{
                
                msg.erro('Houve um problema ao efetuar a operacao, tente novamente mais tarde');
                
            }
            
            
        })
        
    }

})
rtc.controller("crtRelacaoCliente", function ($scope, relacaoClienteService, baseService) {


    $scope.relacaoCliente = null;
    $scope.contatos = [];

    $scope.contato_novo = null;
    $scope.contato = null;

    $scope.clientes = createAssinc(relacaoClienteService, 1, 5, 10);
    assincFuncs(
            $scope.clientes,
            "cliente",
            ["codigo", "email.endereco", "razao_social", "cnpj", "cpf", "empresa.nome"]);
    $scope.clientes.attList();


    $scope.atividade = null;

    relacaoClienteService.getContato(function (c) {

        $scope.contato_novo = c.contato;
        $scope.contato = angular.copy(c.contato);

    })

    $scope.novoContato = function () {

        $scope.contato = angular.copy($scope.contato_novo);

    }

    $scope.mergeContato = function (c) {

        c.descricao = formatTextArea(c.descricao);
        c.relacao = $scope.relacaoCliente;

        baseService.merge(c, function (r) {
            if (r.sucesso) {

                $scope.contato = r.o;

                msg.alerta("Operacao efetuada com sucesso.");


            } else {
                msg.erro("Problema ao efetuar operacao. ");
            }
        });

    }

    relacaoClienteService.getAtividadeUsuarioClienteAtual(function (r) {

        $scope.atividade = r.atividade;

    })

    $scope.setRelacaoCliente = function (r) {

        $scope.relacaoCliente = r;

        relacaoClienteService.getContatos(r, function (c) {

            $scope.contatos = c.contatos;

        })

    }

})
rtc.controller("crtCobranca", function ($scope, $timeout, tarefaService) {

    $scope.cobrancas = [];
    $scope.cobrar = false;

    var att = function () {
        tarefaService.getTarefasAtivas(function (t) {

            $scope.cobrancas = t.tarefas;
            if ($scope.cobrancas.length > 0) {
                $scope.cobrar = true;
            } else {
                $scope.cobrar = false;
            }

        })
    }


    $timeout(function () {
        att();
    }, 10000);

})
rtc.controller("crtTarefas", function ($scope, tarefaService, observacaoTarefaService, usuarioService, tipoTarefaService, empresaService) {

    $scope.tarefas = {};

    $scope.empresas = [];
    $scope.empresa = null;

    $scope.tipos_tarefa = [];
    $scope.tipos_tarefa_usuario = [];

    $scope.tipo_tarefa_usuario = null;
    $scope.tipo_tarefa = null;

    $scope.recorrencia = 0;

    $scope.usuario = null;

    $scope.obs_padrao = "";

    $scope.empresarial = false;
    $scope.tarefa_novo = null;
    $scope.tarefa = null;

    $scope.tarefa_principal = null;

    $scope.observacao_tarefa = {};

    $scope.novaObservacaoTarefa = function () {

        observacaoTarefaService.getObservacaoTarefa(function (o) {

            $scope.observacao_tarefa = o.observacao_tarefa;
            $scope.observacao_tarefa.observacao = $scope.observacao_padrao;
            
        })

    }

    $scope.addObservacao = function () {

        if ($scope.observacao_tarefa.observacao === "") {
            msg.alerta("Digite uma observacao");
            return;
        }

        $scope.observacao_tarefa.observacao = formatTextArea($scope.observacao_tarefa.observacao);

        var c = $scope.tarefa.porcentagem_conclusao;
        var dif = $scope.observacao_tarefa.porcentagem - c;
        $scope.observacao_tarefa.porcentagem = dif;


        tarefaService.addObservacao($scope.tarefa, $scope.observacao_tarefa, function (f) {

            if (f.sucesso) {

                msg.alerta("Operacao efetuada com sucesso");

                tarefaService.getTarefasAtivas(function (t) {

                    $scope.tarefas = createList(t.tarefas, 1, 7, "titulo");
                    $scope.tarefa_principal = t.tarefas[0];

                })
                
                $scope.tarefa.observacoes[$scope.tarefa.observacoes.length] = $scope.observacao_tarefa;

                observacaoTarefaService.getObservacaoTarefa(function (o) {

                    $scope.observacao_tarefa = o.observacao_tarefa;

                })

            } else {

                msg.erro("Falha ao efetuar operacao");

            }


        })

    }

    $scope.usuarios = createAssinc(usuarioService, 1, 5, 10);
    assincFuncs(
            $scope.usuarios,
            "usuario",
            ["id", "email_usu.endereco", "nome", "cpf", "rg", "login"]);

    empresaService.getGrupoEmpresarial(function (f) {

        $scope.empresas = f.grupo;

        if ($scope.empresas.length > 0) {

            $scope.setEmpresa($scope.empresas[0]);

        }

    })

    $scope.setTarefa = function (tarefa) {

        $scope.tarefa = tarefa;
        observacaoTarefaService.getObservacaoTarefa(function (o) {

            $scope.observacao_tarefa = o.observacao_tarefa;
            
            tipoTarefaService.getObservacaoPadrao($scope.tarefa,function(t){
                
                $scope.observacao_padrao = t.observacao.split("<br>").join("\n");
                
                $scope.observacao_tarefa.observacao = $scope.observacao_padrao;
                
            })

        })
    }

    tipoTarefaService.getTiposTarefaUsuario(function (t) {

        $scope.tipos_tarefa_usuario = t.tipos_tarefa;

        if (t.tipos_tarefa.length > 0) {
            $scope.tipo_tarefa_usuario = t.tipos_tarefa[0];
        }

    })

    tarefaService.getTarefasAtivas(function (t) {

        $scope.tarefas = createList(t.tarefas, 1, 7, "descricao");
        $scope.tarefa_principal = t.tarefas[0];

    })

    tarefaService.getTarefa(function (t) {

        $scope.tarefa = t.tarefa;
        $scope.tarefa_novo = angular.copy(t.tarefa);

    })

    $scope.novaTarefa = function () {

        $scope.tarefa = angular.copy($scope.tarefa_novo);

    }

    $scope.setUsuario = function (u) {

        $scope.usuario = u;

    }

    $scope.setTipoTarefaUsuario = function (t) {

        $scope.tipo_tarefa_usuario = t;

    }

    $scope.setTipoTarefa = function (t) {

        $scope.tipo_tarefa = t;
        usuarioService.empresa = $scope.empresa;

        var filtro = "usuario.id_cargo IN (";

        var a = false;
        for (var i = 0; i < t.cargos.length; i++) {
            if (a)
                filtro += ",";
            filtro += t.cargos[i].id;
            a = true;
        }

        if (!a) {
            filtro += '0';
        }

        filtro += ")";

        if (!a) {

            filtro += " AND false";

        }

        usuarioService.filtro_base = filtro;
        $scope.usuario = null;

        $scope.tarefa.prioridade = $scope.tipo_tarefa.prioridade;

    }

    $scope.setEmpresa = function (emp) {

        $scope.empresa = emp;

        tipoTarefaService.empresa = $scope.empresa;
        tipoTarefaService.getTiposTarefa(function (t) {

            $scope.tipos_tarefa = t.tipos_tarefa;
            if ($scope.tipos_tarefa.length > 0) {
                $scope.setTipoTarefa($scope.tipos_tarefa[0]);
            }

        })

    }

    $scope.salvarTarefaUsuario = function () {

        $scope.tarefa.titulo = formatTextArea($scope.tarefa.titulo);
        $scope.tarefa.descricao = formatTextArea($scope.tarefa.descricao);
        $scope.tarefa.tipo_tarefa = $scope.tipo_tarefa_usuario;
        $scope.tarefa.realocavel = false;

        tarefaService.atribuirTarefaUsuarioSessao($scope.tarefa, function (r) {

            if (r.sucesso) {

                msg.alerta("Operacao efetuada com sucesso");

                tarefaService.getTarefasAtivas(function (t) {

                    $scope.tarefas = createList(t.tarefas, 1, 5, "descricao");
                    $scope.tarefa_principal = t.tarefas[0];

                })

            } else {

                msg.erro("Problema ao efetuar operacao");

            }

        })

    }

    $scope.salvarTarefa = function () {

        $scope.tarefa.titulo = formatTextArea($scope.tarefa.titulo);
        $scope.tarefa.descricao = formatTextArea($scope.tarefa.descricao);

        $scope.tarefa.tipo_tarefa = $scope.tipo_tarefa;
        $scope.tarefa.realocavel = $scope.empresarial;

        if ($scope.empresarial) {

            tarefaService.atribuirTarefaEmpresa($scope.empresa, $scope.tarefa, function (r) {

                if (r.sucesso) {

                    msg.alerta("Operacao efetuada com sucesso");

                    tarefaService.getTarefasAtivas(function (t) {

                        $scope.tarefas = createList(t.tarefas, 1, 5, "descricao");

                    })

                } else {

                    msg.erro("Problema ao efetuar operacao");

                }

            })

        } else {

            tarefaService.atribuirTarefaUsuario($scope.usuario, $scope.tarefa, function (r) {

                if (r.sucesso) {

                    msg.alerta("Operacao efetuada com sucesso");

                } else {

                    msg.erro("Problema ao efetuar operacao");

                }

            })

        }

    }


})
rtc.controller("crtGerenciador", function ($scope, $interval, gerenciadorService) {

    $scope.ativos = null;
    $scope.gerenciadorUsuarios = null;
    $scope.gerenciadorEstat = null;

    $scope.qtdAcessos = 0;
    $scope.maximoUsuariosOnline = 0;
    $scope.pontosGrafico = [];
    $scope.intervaloEstat = 3600000; //1 hora inicialmente;

    $scope.pontosGraficoInfoUsu = [];
    $scope.intervaloInfoUsu = 3600000;
    $scope.selecionado = null;
    $scope.informacoes = null;

    $scope.numero_empresas = 0;

    $scope.grupo = false;

    $scope.attGrupo = function () {



        $scope.gerenciadorUsuarios.grupo = $scope.grupo;
        $scope.gerenciadorEstat.grupo = $scope.grupo;

        $scope.ativos.attList();
        $scope.attEstat();
        $scope.attInfoUsu();


    }

    $scope.selecionar = function (atv) {

        $scope.selecionado = atv;
        $scope.attInfoUsu();


    }

    gerenciadorService.getGerenciador(function (g) {

        $scope.gerenciadorUsuarios = g.gerenciador;
        $scope.gerenciadorEstat = angular.copy(g.gerenciador);
        gerenciadorService.gerenciador = $scope.gerenciadorUsuarios;

        $scope.ativos = createAssinc(gerenciadorService, 1, 10, 10);
        $scope.ativos["posload"] = function (els) {

            if ($scope.selecionado === null) {
                $scope.selecionar(els[0]);
            } else {
                for (var i = 0; i < els.length; i++) {
                    if (els[i].id === $scope.selecionado.id) {
                        $scope.selecionado = els[i];
                    }
                }
            }

        }
        assincFuncs(
                $scope.ativos,
                "a",
                ["u.id", "u.nome", "e.id", "e.nome", "e.cnpj"], "filtro", false);

        $scope.ativos.attList();

        $scope.attEstat();

    })

    $scope.reduzirIntervaloEstat = function () {

        $scope.intervaloEstat = parseInt($scope.intervaloEstat / 2);

        $scope.attEstat();

    }

    $scope.attUsuarios = function () {

        $scope.ativos.attList();
        $scope.attInfoUsu();

    }

    $scope.attInfoUsu = function () {

        gerenciadorService.getNumeroEmpresas($scope.gerenciadorEstat, function (q) {

            $scope.numero_empresas = q.qtd;

        })

        gerenciadorService.getAtividadeUsuario($scope.selecionado, $scope.intervaloInfoUsu, function (p) {

            $scope.pontosGraficoInfoUsu = [];

            for (var i = 0; i < p.pontos.length; i++) {

                var momento = $scope.intervaloInfoUsu * i + $scope.gerenciadorUsuarios.periodo_inicial;
                var momentoFinal = momento + $scope.intervaloInfoUsu;
                var titulo = toTime(momento).split(" ")[1] + " a " + toTime(momentoFinal).split(" ")[1];

                $scope.pontosGraficoInfoUsu[$scope.pontosGraficoInfoUsu.length] = {nome: titulo, valor: p.pontos[i]};

            }


        })

        gerenciadorService.getInformacoesUsuario($scope.selecionado, function (inf) {

            $scope.informacoes = inf;
            $scope.informacoes.logs = createList($scope.informacoes.logs, 1, 5, "log.descricao");

        })


    }

    $scope.reduzirIntervaloInfoUsu = function () {

        $scope.intervaloEstat = parseInt($scope.intervaloInfoUsu / 2);

        $scope.attInfoUsu();

    }

    $scope.aumentarIntervaloInfoUsu = function () {

        $scope.intervaloEstatInfoUsu = parseInt($scope.intervaloEstat * 2);

        $scope.attInfoUsu();

    }

    $scope.aumentarIntervaloEstat = function () {

        $scope.intervaloEstat = Math.min(parseInt($scope.intervaloEstat * 2), 86400000);

        $scope.attEstat();

    }

    var interval = false;

    $scope.attEstat = function () {

        gerenciadorService.getCount('', function (r) {
            $scope.qtdAcessos = r.qtd;
        }, $scope.gerenciadorEstat);

        gerenciadorService.getMaximoUsuariosOnline($scope.gerenciadorEstat, function (r) {
            $scope.maximoUsuariosOnline = r.qtd;
        })

        gerenciadorService.getTempo_Usuarios($scope.gerenciadorEstat, $scope.intervaloEstat, function (p) {

            $scope.pontosGrafico = [];

            for (var i = 0; i < p.pontos.length; i++) {

                var momento = $scope.intervaloEstat * i + $scope.gerenciadorEstat.periodo_inicial;
                var momentoFinal = momento + $scope.intervaloEstat;
                var titulo = toTime(momento).split(" ").join("<br>") + " a " + toTime(momentoFinal).split(" ")[1];

                $scope.pontosGrafico[$scope.pontosGrafico.length] = {nome: titulo, valor: p.pontos[i]};

            }


        })

        if (!interval) {

            $interval(function () {

                $scope.ativos.attList();
                $scope.attEstat();
                $scope.attInfoUsu();

            }, 30000);

            interval = true;

        }

    }





});


rtc.controller("crtAtividade", function ($scope, $timeout, $interval, atividadeService) {

    atividadeService.sinal();

    $interval(function () {
        atividadeService.sinal();
    }, 60000);

    $(document).click(function (e) {

        var x = e.clientX;
        var y = e.clientY;

        atividadeService.cliqueComum("Clique (" + x + "," + y + ")");

    })


    $(document).find("input[type=search]").each(function () {
        $(this).change(function () {
            atividadeService.pesquisar("Digitou: " + $(this).val());
        })
    })



});

rtc.controller("crtBanners", function ($scope, bannerService, campanhaService, uploadService, empresaService, baseService) {

    $scope.banners = createAssinc(bannerService, 1, 5, 10);

    assincFuncs(
            $scope.banners,
            "banner",
            ["id", "data_inicial", "data_final", "tipo"]);

    $scope.campanhas = createAssinc(campanhaService, 1, 10, 10);
    assincFuncs(
            $scope.campanhas,
            "campanha",
            ["id", "nome", "inicio", "fim"], "filtroCampanhas");

    $scope.banner_novo = {};
    $scope.banner = {};
    $scope.bannerService = bannerService;

    $scope.clientes = [];

    $scope.trocaEmpresa = function () {

        bannerService.getBanner(function (p) {
            $scope.banner_novo = p.banner;
        })

        $scope.novoBanner = function () {
            $scope.banner = angular.copy($scope.banner_novo);
        }

        campanhaService.empresa = bannerService.empresa;
        $scope.banners.attList();

    }

    empresaService.getEmpresasClientes(function (c) {

        $scope.clientes = c.clientes;
        if ($scope.clientes.length > 0) {
            bannerService.empresa = $scope.clientes[0];
            $scope.trocaEmpresa();
        }

    })

    $scope.data_atual = new Date().getTime();

    $scope.tipos_banner = ["Frontal", "Lateral", "Email Marketing"];

    $("#uploaderHTML").change(function () {

        var arquivos = $(this).prop("files");

        for (var i = 0; i < arquivos.length; i++) {
            var sp = arquivos[i].name.split(".");
            if (sp[sp.length - 1] !== "html") {
                msg.alerta("Arquivo: " + arquivos[i].name + ", invalido");
                return;
            }
        }


        uploadService.upload(arquivos, function (arqs, sucesso) {

            if (!sucesso) {

                msg.erro("Falha ao subir arquivo");

            } else {

                $scope.arquivos = arqs;

                for (var i = 0; i < arquivos.length; i++) {
                    var reader = new FileReader();
                    reader["ii"] = i;
                    reader.onload = function (arquivo) {

                        var html = arquivo.target.result;

                        var json = DOMToJson(html);

                        json = JSON.stringify(json);


                        uploadService.uploadStr([json], function (arqs2, sucesso2) {

                            if (sucesso2) {

                                msg.alerta("Upload efetuado com sucesso");
                                $scope.banner.json = arqs2[0];

                            } else {

                                msg.alerta("Falha ao subir banner");

                            }


                        })




                    };
                    reader.readAsText(arquivos[i]);
                }

            }

        })

    });

    bannerService.getBanner(function (p) {
        $scope.banner_novo = p.banner;
    })

    $scope.novoBanner = function () {
        $scope.banner = angular.copy($scope.banner_novo);
    }

    $scope.setCampanha = function (campanha) {

        $scope.banner.campanha = campanha;

    }

    $scope.deleteCampanha = function () {

        $scope.banner.campanha = null;

    }

    $scope.setBanner = function (banner) {

        $scope.banner = banner;
        banner.html = "";

        bannerService.getHTML(banner, function (h) {

            banner.html = window.atob(h.html);

            $("#html_" + banner.id).html(banner.html);

        })

    }

    $scope.mergeBanner = function () {

        if ($scope.banner.json == null) {
            msg.erro("Realize o upload do arquivo");
            return;
        }
        $scope.banner.html = "";

        baseService.merge($scope.banner, function (r) {
            if (r.sucesso) {
                $scope.banner = r.o;

                msg.alerta("Operacao efetuada com sucesso");
                $scope.banners.attList();

            } else {
                msg.erro("Problema ao efetuar operacao. ");
            }
        });

    }
    $scope.deleteBanner = function () {
        $scope.banner.html = "";

        baseService.delete($scope.banner, function (r) {
            if (r.sucesso) {
                msg.alerta("Operacao efetuada com sucesso");
                $scope.banners.attList();
            } else {
                msg.erro("Problema ao efetuar operacao");
            }
        });
    }

})
rtc.controller("crtRelatorio", function ($scope, relatorioService) {

    $scope.relatorios = [];
    $scope.gerado = null;

    $scope.modos = ["Igual a", "Maior que", "Menor que"];
    $scope.mn = [0, 1, 2];

    $scope.filhos = [];

    if (typeof rtc["relatorio"] !== 'undefined') {

        $scope.relatorio = rtc["relatorio"];


    }

    $scope.addOrdem = function (campo) {
        campo.ordem++;
    }

    $scope.removeOrdem = function (campo) {
        campo.ordem = Math.max(0, campo.ordem - 1);
    }

    $scope.inverteGroup = function (campo) {
        campo.agrupado = !campo.agrupado;
    }

    $scope.detalhes = function (item) {


        relatorioService.getFilhos(item, function (f) {

            $scope.filhos = f.filhos;
            $("#mdlFilhos").modal("show");

        })

    }
    $scope.xsd = "";
    $scope.gerarXsd = function () {

        relatorioService.relatorio = $scope.relatorio;
        relatorioService.getXsd(function (x) {

            $scope.xsd = projeto + "/php/uploads/" + x.arquivo;
            $("#mdlXsd").modal('show');

        });

    }

    $scope.gerarRelatorio = function () {

        var order = "";
        var order_fields = [];
        for (var i = 0; i < $scope.relatorio.campos.length; i++) {

            var campo = $scope.relatorio.campos[i];

            if (campo.ordem > 0) {
                var j = 0
                for (; j < order_fields.length; j++) {
                    if (campo.ordem >= order_fields[j].ordem) {
                        for (var k = order_fields.length - 1; k >= j; k--) {
                            order_fields[k + 1] = order_fields[k];
                        }
                        break;
                    }
                }
                order_fields[j] = campo;
            }

            if (campo.possiveis.length > 0) {

                var sub = "";
                for (var j = 0; j < campo.possiveis.length; j++) {
                    var p = campo.possiveis[j];

                    if (p.selecionado) {

                        if (sub !== "") {
                            sub += " OR ";
                        }

                        sub += "k." + campo.nome + "='" + p.termo + "'";
                    }
                }
                if (sub !== "") {
                    campo.filtro = "(" + sub + ") ";
                } else {
                    campo.filtro = "";
                }
            } else if (campo.tipo === 'T') {


                campo.filtro = "k." + campo.nome + " like '%" + campo.texto + "%' ";

            } else if (campo.tipo === 'N') {

                if (campo.numero !== 0) {


                    campo.filtro = "k." + campo.nome;

                    if (campo.modo === 0) {
                        campo.filtro += "=";
                    } else if (campo.modo === 1) {
                        campo.filtro += ">";
                    } else if (campo.modo === 2) {
                        campo.filtro += "<";
                    }

                    campo.filtro += campo.numero + " ";

                } else {
                    campo.filtro = "";
                }

            } else if (campo.tipo === 'D') {


                campo.filtro = "(k." + campo.nome + " >= FROM_UNIXTIME(" + campo.inicio + "/1000) AND k." + campo.nome + " <= FROM_UNIXTIME(" + campo.fim + "/1000)) ";

            }

        }

        for (var i = 0; i < order_fields.length; i++) {
            if (i > 0) {
                order += ",";
            }
            order += "k." + order_fields[i].nome;
        }

        $scope.relatorio.order = order;


        relatorioService.relatorio = $scope.relatorio;

        $scope.gerado = createAssinc(relatorioService, 1, 20, 1000);
        $scope.gerado.attList();

        $("#mdlRelatorio").modal("show");

    }

    $scope.init = function () {

        var r = $scope.relatorio;

        for (var i = 0; i < r.campos.length; i++) {

            var campo = r.campos[i];

            campo.ordem = 0;
            if (campo.possiveis.length > 0) {

                for (var j = 0; j < campo.possiveis.length; j++) {

                    campo.possiveis[j] = {termo: campo.possiveis[j], selecionado: true};

                }

            } else if (campo.tipo === 'T') {

                campo.texto = "";

            } else if (campo.tipo === 'N') {

                campo.modo = 0;
                campo.numero = 0;

            } else if (campo.tipo === 'D') {

                campo.inicio = new Date().getTime();
                campo.fim = new Date().getTime() + (24 * 60 * 60 * 1000);

            }

        }

    }


    relatorioService.getRelatorios(function (f) {

        $scope.relatorios = f.relatorios;

        if (typeof $scope["relatorio"] !== 'undefined') {

            for (var i = 0; i < $scope.relatorios.length; i++) {
                if (($scope.relatorios[i].id + "") === ($scope.relatorio + "")) {
                    $scope.relatorio = $scope.relatorios[i];
                    $scope.init();
                    break;
                }
            }

        }

    })




})
rtc.controller("crtEmpresaConfig", function ($scope, empresaService, sistemaService, cidadeService, baseService, uploadService) {

    $scope.empresa = null;
    $scope.filiais = [];
    $scope.parametros_emissao = null;
    $scope.estados = [];
    $scope.cidades = [];
    $scope.estado = null;
    $scope.marketings = [];
    $scope.marketing = null;



    $("#uploaderCertificadoDigital").change(function () {

        var ext = ['pfx'];
        var pre_arquivos = $(this).prop("files");
        var arquivos = [];
        var e = [];

        var total_size = 0;

        for (var i = 0; i < pre_arquivos.length; i++) {
            for (var j = 0; j < ext.length; j++) {
                if (ext[j] === pre_arquivos[i].name.split('.')[pre_arquivos[i].name.split('.').length - 1]) {
                    arquivos[arquivos.length] = pre_arquivos[i];
                    e[e.length] = pre_arquivos[i].name.split('.')[pre_arquivos[i].name.split('.').length - 1];
                    total_size += pre_arquivos[i].size;
                    break;
                }
            }
        }

        if (arquivos.length === 0) {
            msg.alerta("O Certificado deve ser do tipo PFX A1");
            return;
        }

        uploadService.upload($(this).prop("files"), function (arquivos, sucesso) {

            if (!sucesso) {

                msg.erro("Falha ao subir arquivo");

            } else {

                for (var i = 0; i < arquivos.length; i++) {

                    $scope.parametros_emissao.certificado = arquivos[i];

                }

                msg.alerta("Upload feito com sucesso");
            }

        })

    })

    $scope.setMarketing = function (mkt) {

        $scope.marketing = mkt;


    }

    empresaService.getEmpresa(function (r) {


        $scope.empresa = r.empresa;

        $scope.filiais = [];
        $scope.filiais[$scope.filiais.length] = r.empresa;

        empresaService.getFiliais(function (rr) {

            for (var i = 0; i < rr.filiais.length; i++) {
                if (rr.filiais[i].id === $scope.empresa.id)
                    continue;
                $scope.filiais[$scope.filiais.length] = rr.filiais[i];

            }

        })

        sistemaService.getMarketings(function (r) {

            $scope.marketings = r.marketings;

            empresaService.getMarketing($scope.empresa, function (m) {

                $scope.marketing = m.marketing;

                if ($scope.marketing !== null) {
                    equalize($scope, "marketing", $scope.marketings);
                }
                $scope.marketings[$scope.marketings.length] = null;

            })

        })




        empresaService.getParametrosEmissao($scope.empresa, function (e) {

            $scope.parametros_emissao = e.parametros_emissao;
            if ($scope.empresa !== null) {
                equalize($scope.empresa.endereco, "cidade", $scope.cidades);
                if (typeof $scope.empresa.endereco.cidade !== 'undefined') {
                    $scope.estado = $scope.empresa.endereco.cidade.estado;
                } else {
                    $scope.empresa.endereco.cidade = $scope.cidades[0];
                    $scope.estado = $scope.empresa.endereco.cidade.estado;
                }
            }
        })

    })

    $scope.mergeEmpresa = function () {

        if ($scope.empresa.endereco.cidade == null) {
            msg.erro("Empresa sem cidade.");
            return;
        }

        baseService.merge($scope.empresa, function (r) {
            if (r.sucesso) {

                $scope.empresa = r.o;

                empresaService.setMarketing($scope.empresa, $scope.marketing, function (rr) {


                })

                equalize($scope.empresa.endereco, "cidade", $scope.cidades);
                if (typeof $scope.empresa.endereco.cidade !== 'undefined') {
                    $scope.estado = $scope.empresa.endereco.cidade.estado;
                } else {
                    $scope.empresa.endereco.cidade = $scope.cidades[0];
                    $scope.estado = $scope.empresa.endereco.cidade.estado;
                }

                baseService.merge($scope.parametros_emissao, function (rr) {
                    if (rr.sucesso) {
                        $scope.parametros_emissao = rr.o;

                        msg.alerta("Operacao efetuada com sucesso. Relogue para surtir as alteracoes");

                    } else {
                        msg.erro("Problema ao efetuar operacao.#");
                    }
                });

            } else {
                msg.erro("Problema ao efetuar operacao. ");
            }
        });

    }

    cidadeService.getElementos(function (p) {
        var estados = [];
        var cidades = p.elementos;
        $scope.cidades = cidades;

        lbl:
                for (var i = 0; i < cidades.length; i++) {
            var c = cidades[i];
            for (var j = 0; j < estados.length; j++) {
                if (estados[j].id === c.estado.id) {
                    estados[j].cidades[estados[j].cidades.length] = c;
                    c.estado = estados[j];
                    continue lbl;
                }
            }
            c.estado["cidades"] = [c];
            estados[estados.length] = c.estado;
        }

        $scope.estados = estados;
        if ($scope.empresa !== null) {
            equalize($scope.empresa.endereco, "cidade", $scope.cidades);
            if (typeof $scope.empresa.endereco.cidade !== 'undefined') {
                $scope.estado = $scope.empresa.endereco.cidade.estado;
            } else {
                $scope.empresa.endereco.cidade = $scope.cidades[0];
                $scope.estado = $scope.empresa.endereco.cidade.estado;
            }
        }
    })

})

rtc.controller("crtCarrinhoFinal", function ($scope, sistemaService, tabelaService, carrinhoService, pedidoService, formaPagamentoService, transportadoraService) {

    $scope.transportadoras = createAssinc(transportadoraService, 1, 3, 4);
    $scope.transportadoras.attList();
    assincFuncs(
            $scope.transportadoras,
            "transportadora",
            ["codigo", "razao_social"], "filtroTransportadoras");

    $scope.atualizando_custo = false;
    $scope.pedidos = [];
    $scope.pedido_contexto = null;
    $scope.carrinho = [];
    $scope.fretes = [];
    $scope.possibilidades = [
        {id: 0, prazo: 0, parcelas: 1, nome: "Antecipado"},
        {id: 1, prazo: 30, parcelas: 1, nome: null},
        {id: 2, prazo: 60, parcelas: 1, nome: null},
        {id: 3, prazo: 90, parcelas: 1, nome: null}
    ];

    carrinhoService.getCarrinho(function (c) {

        $scope.carrinho = c.carrinho;

    })

    $scope.finalizarPedido = function (pedido) {
        pedido.status_finalizacao = {valor: "Aguarde... O Sistema esta fechando seu pedido", classe: "btn-primary", final: false};

        sistemaService.finalizarCompraParceiros(pedido, function (r) {

            var novo_carrinho = [];

            lbl:
                    for (var i = 0; i < $scope.carrinho.length; i++) {

                var it = $scope.carrinho[i];

                for (var j = 0; j < pedido.produtos.length; j++) {

                    var p = pedido.produtos[j];

                    if (it.id === p.produto.id) {

                        continue lbl;

                    }

                }

                novo_carrinho[novo_carrinho.length] = it;

            }

            $scope.carrinho = novo_carrinho;
            var p = r.o;
            carrinhoService.setCarrinho($scope.carrinho, function (s) {

                pedido.status_finalizacao = {valor: "O Sistema esta gerando a cobranca, aguarde mais um pouco...", classe: "btn-outline-success", final: false};
                pedidoService.gerarCobranca(p, function (r) {
                    $("#finalizarCompraModal").modal('show');
                    if (r.sucesso) {
                        $("#finalizarCompra").html("Cobranca gerada com sucesso. <hr> " + r.retorno);
                    } else {
                        $("#finalizarCompra").html("Compra finalizada porem houve um problema ao gerar a cobranca");
                    }

                    pedido.cobranca_gerada = true;
                    pedido.status_finalizacao = {valor: "O Pedido foi realizado com sucesso !, verifique a confirmacao em seu email", classe: "btn btn-warning", final: true};
                })


            })



        })

    }


    $scope.getFormasPagamento = function (pedido) {

        formaPagamentoService.getFormasPagamento(pedido, function (f) {

            pedido.formas_pagamento = f.formas;

            if (pedido.forma_pagamento !== null) {

                equalize(pedido, "forma_pagamento", pedido.formas_pagamento);
            } else {
                pedido.forma_pagamento = f.formas_pagamento[0];
            }
        })

    }

    $scope.setTransportadora = function (t) {

        $scope.pedido_contexto.transportadora = t;

    }

    $scope.setFrete = function (frete) {


        $scope.pedido_contexto.transportadora = frete.transportadora;
        $scope.pedido_contexto.frete = parseFloat(frete.valor.toFixed(2));
        $scope.atualizaCustos($scope.pedido_contexto);


    }

    $scope.getFretes = function (pedido) {

        $scope.pedido_contexto = pedido;

        var empresa = pedido.empresa;

        if (pedido.logistica !== null) {

            empresa = pedido.logistica;

        }

        //---- parametros de frete

        var pesoTotal = 0;
        var valorTotal = 0;

        for (var i = 0; i < pedido.produtos.length; i++) {
            var p = pedido.produtos[i];
            valorTotal += (p.valor_base + p.ipi + p.icms + p.juros) * p.quantidade;
            pesoTotal += p.produto.peso_bruto * p.quantidade;
        }

        //------------------------

        tabelaService.getFretes(empresa, {cidade: pedido.cliente.endereco.cidade, valor: valorTotal, peso: pesoTotal}, function (f) {

            $scope.fretes = f.fretes;

        })

    }

    carrinhoService.getPedidosResultantes(function (r) {

        if (r.sucesso) {

            $scope.pedidos = r.pedidos;

            for (var i = 0; i < r.pedidos.length; i++) {

                r.pedidos[i].identificador = i;
                r.pedidos[i].status_finalizacao = null;
                r.pedidos[i].prazo_parcelas = $scope.possibilidades[0];
                equalize(r.pedidos[i], "forma_pagamento", r.pedidos[i].formas_pagamento);
            }

        }

    });

    $scope.setPedidoContexto = function (pedido) {

        $scope.pedido_contexto = pedido;

    }

    $scope.atualizaCustosResetandoFrete = function (pedido) {

        pedido.transportadora = null;
        pedido.frete = 0;

        $scope.atualizaCustos(pedido);

    }

    $scope.remover = function (produto) {

        var nc = [];
        for (var i = 0; i < $scope.carrinho.length; i++) {
            if ($scope.carrinho[i].id === produto.produto.id) {
                continue;
            }
            nc[nc.length] = $scope.carrinho[i];
        }

        carrinhoService.setCarrinho(nc, function () {

            location.reload();

        })

    }

    $scope.retirouPromocao = function (produto) {

        if (typeof produto["retirou_promocao"] === 'undefined') {

            return 0;

        }

        return produto.retirou_promocao;

    }

    $scope.attPrazoParcelas = function (pedido) {

        pedido.prazo = pedido.prazo_parcelas.prazo;
        pedido.parcelas = pedido.prazo_parcelas.parcelas;



        $scope.atualizaCustos(pedido);

    }

    $scope.atualizaCustos = function (pedido) {
        $scope.atualizando_custo = true;
        var i = 0;
        for (; i < $scope.pedidos.length; i++) {
            if ($scope.pedidos[i] === pedido) {
                break;
            }
        }

        pedidoService.atualizarCustos(pedido, function (np) {

            $scope.pedidos[i] = np.o;
            $scope.pedidos[i].identificador = i;
            $scope.pedidos[i].status_finalizacao = null;

            $scope.getFormasPagamento($scope.pedidos[i]);
            equalize($scope.pedidos[i], "prazo_parcelas", $scope.possibilidades);
            $scope.pedido_contexto = $scope.pedidos[i];
            $scope.atualizando_custo = false;
        })

    }


})
rtc.controller("crtCarrinho", function ($scope, sistemaService, carrinhoService) {

    $scope.carrinho = [];

    $scope.attCarrinho = function () {

        carrinhoService.getCarrinho(function (c) {

            $scope.carrinho = c.carrinho;

        })

    }

    $scope.attCarrinho();

    $scope.removerProduto = function (produto) {

        remove($scope.carrinho, produto);

        carrinhoService.setCarrinho($scope.carrinho, function (r) {

            if (r.sucesso) {

                msg.alerta("Removido com sucesso");

            } else {

                msg.erro("Falha ao remover do carrinho");

            }

        })

    }

})
rtc.controller("crtEmpresa", function ($scope, empresaService) {

    $scope.empresa = null;
    $scope.filiais = [];

    empresaService.getEmpresa(function (r) {


        $scope.empresa = r.empresa;

        $scope.filiais = [];
        $scope.filiais[$scope.filiais.length] = r.empresa;

        empresaService.getFiliais(function (rr) {

            for (var i = 0; i < rr.filiais.length; i++) {
                if (rr.filiais[i].id === $scope.empresa.id)
                    continue;
                $scope.filiais[$scope.filiais.length] = rr.filiais[i];

            }

        })

    })

    $scope.setEmpresa = function () {

        loading.show();
        empresaService.setEmpresa($scope.empresa, function (r) {
            loading.close();

            if (r.sucesso) {
                if (r.aceito) {
                    window.location = 'index_em_branco.php';
                } else {
                    msg.alerta("Voce nao tem acesso a empresa " + $scope.empresa.nome);
                }
            }

        });

    }

})

rtc.controller("crtCompraParceiros", function ($scope, produtoService, compraParceiroService, sistemaService, carrinhoService) {

    $scope.tv = function (produto) {

        return typeof produto["validades"] !== 'undefined';

    }

    $scope.produtos = createFilterList(compraParceiroService, 3, 6, 10);
    $scope.produtos["posload"] = function (elementos) {
        sistemaService.getMesesValidadeCurta(function (p) {
            produtoService.remessaGetValidades(p.meses_validade_curta, elementos, function () {});
        });
    }
    $scope.produtos.attList();


    $scope.qtd = 0;
    $scope.prod = null;
    $scope.val = null;
    $scope.meses_validade_curta = 3;

    var carrinho = [];


    carrinhoService.getCarrinho(function (c) {

        carrinho = c.carrinho;

    })

    sistemaService.getMesesValidadeCurta(function (p) {

        $scope.meses_validade_curta = p.meses_validade_curta;

    })

    $scope.addCarrinho = function (produto, validade) {

        $scope.prod = produto;

        $scope.qtd = parseFloat(window.prompt("Quantidade"));
        if (isNaN($scope.qtd)) {
            msg.erro("Quantidade incorreta");
            return;
        }

        $scope.qtd = parseInt(($scope.qtd + ""));

        $scope.val = validade;

        if ($scope.qtd > $scope.val.quantidade) {

            msg.erro("Nao temos essa quantidade");
            return;

        }

        var p = angular.copy($scope.prod);
        p.validade = $scope.val;
        p.quantidade_comprada = $scope.qtd;

        var limite = p.validade.limite;

        var a = false;
        for (var i = 0; i < carrinho.length; i++) {
            if (carrinho[i].id === p.id && carrinho[i].validade.validade === p.validade.validade) {
                a = true;
                if ((p.quantidade_comprada + carrinho[i].quantidade_comprada) > p.validade.quantidade) {
                    msg.erro("Nao temos essa quantidade");
                    return;
                }
                if ((p.quantidade_comprada + carrinho[i].quantidade_comprada) > limite && limite > 0) {
                    msg.erro("Voce esta ultrapassando o limite de compra");
                    return;
                }
            }
        }

        if (!a) {
            carrinho[carrinho.length] = p;
        }
        carrinhoService.setCarrinho(carrinho, function (r) {

            if (r.sucesso) {

                msg.alerta("Adicionado com sucesso");

                $("#indicadorAdd").css('visibility', 'initial');

            } else {

                msg.erro("Falha ao adicionar o produto");

            }

        })

    }


    $scope.setProduto = function (produto) {
        $scope.prod = produto;
        produtoService.getValidades($scope.meses_validade_curta, produto, function (v) {
            produto.validades = v;
        })
    }

    $scope.addLevel = function (op, filtro) {
        op.selecionada++;
        op.selecionada = op.selecionada % 2;

        for (var i = 0; i < filtro.opcoes.length; i++) {
            if (filtro.opcoes[i].selecionada > 0 && filtro.opcoes[i].id !== op.id) {
                filtro.opcoes[i].selecionada = 0;
            }
        }

        $scope.produtos.attList();
    }

    $scope.resetarFiltro = function () {

        for (var i = 0; i < $scope.produtos.filtro.length; i++) {
            var f = $scope.produtos.filtro[i];
            if (f._classe === 'FiltroTextual') {
                f.valor = "";
            } else if (f._classe === 'FiltroOpcional') {
                for (var j = 0; j < f.opcoes.length; j++) {
                    f.opcoes[j].selecionada = 0;
                }
            }
        }

        $scope.produtos.attList();

    }

    $scope.dividir = function (produtos, qtd) {

        var k = Math.ceil((produtos.length) / qtd);

        var m = [];

        for (var a = 0; a < qtd; a++) {
            m[a] = [];
            for (var i = a * k; i < (a + 1) * k && i < produtos.length; i++) {
                for (var j = 0; j < produtos[i].length; j++) {
                    m[a][m[a].length] = produtos[i][j];
                }
            }
        }

        return m;

    }

})

rtc.controller("crtExpediente", function ($scope, $timeout, usuarioService, ausenciaService, expedienteService) {

    $scope.usuarios = createAssinc(usuarioService, 1, 3, 10);
    $scope.usuarios.posload = function (e) {
        if (e.length > 0) {
            $timeout(function () {

                $scope.setUsuario(e[0]);

            }, 500)
        }
    }
    $scope.usuarios.attList();
    assincFuncs(
            $scope.usuarios,
            "usuario",
            ["id", "email_usu.endereco", "nome", "cpf", "rg", "login"], "filtroUsuarios");

    $scope.usuario = null;
    $scope.ausencias = [];
    $scope.expedientes = [];

    $scope.dias = [
        {id: 0, nome: "Dom"},
        {id: 1, nome: "Seg"},
        {id: 2, nome: "Ter"},
        {id: 3, nome: "Qua"},
        {id: 4, nome: "Qui"},
        {id: 5, nome: "Sex"},
        {id: 6, nome: "Sab"}];

    $scope.ausencia_novo = {};

    $scope.expediente_novo = {};

    ausenciaService.getAusencia(function (a) {
        $scope.ausencia_novo = a.ausencia;
    })

    expedienteService.getExpediente(function (e) {
        $scope.expediente_novo = e.expediente;
    })

    $scope.setUsuario = function (usuario) {

        $scope.usuario = usuario;

        ausenciaService.getAusencias($scope.usuario, function (a) {

            $scope.usuario.ausencias = a.ausencias;
            $scope.ausencias = createList(a.ausencias, 1, 5);

        })

        expedienteService.getExpedientes($scope.usuario, function (e) {

            $scope.usuario.expedientes = e.expedientes;
            $scope.expedientes = createList(e.expedientes, 1, 14);

        })

        $scope.getTempo = function (t) {

            var h = parseInt(t);
            var m = ((t % 1) * 60).toFixed(0);

            return h + "h:" + m + "m";

        }

    }

    $scope.removeExpediente = function (ee) {

        var ne = [];

        for (var i = 0; i < $scope.usuario.expedientes.length; i++) {
            var e = $scope.usuario.expedientes[i];
            if (e !== ee) {
                ne[ne.length] = e;
            }
        }

        $scope.usuario.expedientes = ne;
        $scope.expedientes = createList($scope.usuario.expedientes, 1, 14);

    }

    $scope.removeAusencia = function (aa) {

        var na = [];

        for (var i = 0; i < $scope.usuario.ausencias.length; i++) {
            var a = $scope.usuario.ausencias[i];
            if (a !== aa) {
                na[na.length] = a;
            }
        }

        $scope.usuario.ausencias = na;
        $scope.ausencias = createList($scope.usuario.ausencias, 1, 5);

    }

    $scope.addAusencia = function () {

        $scope.usuario.ausencias[$scope.usuario.ausencias.length] = angular.copy($scope.ausencia_novo);
        $scope.ausencias.attList();

    }

    $scope.addExpediente = function () {

        $scope.usuario.expedientes[$scope.usuario.expedientes.length] = angular.copy($scope.expediente_novo);
        $scope.expedientes.attList();

    }

    $scope.confirmarExpedientes = function () {


        expedienteService.setExpedientes($scope.usuario, $scope.usuario.expedientes, function (f) {

            if (f.sucesso) {

                msg.alerta("Operacao confirmada com sucesso");

            } else {

                msg.erro("Problema ao confirmar operacoes");

            }

        })

    }

    $scope.confirmarAusencias = function () {


        ausenciaService.setAusencias($scope.usuario, $scope.usuario.ausencias, function (f) {

            if (f.sucesso) {

                msg.alerta("Operacao confirmada com sucesso");

            } else {

                msg.erro("Problema ao confirmar operacoes");

            }

        })

    }


})

rtc.controller("crtOrganograma", function ($scope, usuarioService) {

    $scope.usuarios = createAssinc(usuarioService, 1, 3, 10);
    $scope.usuarios.attList();
    assincFuncs(
            $scope.usuarios,
            "usuario",
            ["id", "email_usu.endereco", "nome", "cpf", "rg", "login"], "filtroUsuarios");

})


rtc.controller("crtUsuarios", function ($scope, $timeout, usuarioService, permissaoService, cidadeService, baseService, telefoneService, cargoService, tipoTarefaService) {

    $scope.usuarios = createAssinc(usuarioService, 1, 3, 10);
    $scope.usuarios.posload = function (e) {
        if (e.length > 0) {
            $timeout(function () {

                $scope.setUsuario(e[0]);

            }, 500)
        }
    }
    $scope.usuarios.attList();
    assincFuncs(
            $scope.usuarios,
            "usuario",
            ["id", "email_usu.endereco", "nome", "cpf", "rg", "login"]);

    $scope.usuario_novo = {};
    $scope.usuario = {};
    $scope.estado = {};

    $scope.tipo_tarefa = null;
    $scope.tipo_tarefa_novo = {};

    $scope.tipos_tarefa = [];

    tipoTarefaService.getTipoTarefa(function (t) {

        $scope.tipo_tarefa_novo = t.tipo_tarefa;

    })


    var attTiposTarefa = function () {
        tipoTarefaService.getTiposTarefa(function (t) {

            if ($scope.tipo_tarefa === null) {
                if (t.tipos_tarefa.length > 0) {
                    $scope.setTipoTarefa(t.tipos_tarefa[0]);
                } else {
                    $scope.tipo_tarefa = {};
                }
            }

            $scope.tipos_tarefa = createList(t.tipos_tarefa, 1, 5, "nome");

        })
    }

    attTiposTarefa();

    $scope.cargos = [];
    $scope.lstCargos = {};

    $scope.cargo = {};
    $scope.cargo_novo = {};

    cargoService.getCargo(function (c) {

        $scope.cargo = c.cargo;
        $scope.cargo_novo = angular.copy(c.cargo);

    })

    var attCargos = function () {
        cargoService.getCargos(function (c) {
            $scope.cargos = c.cargos;
            $scope.lstCargos = createList(angular.copy(c.cargos), 1, 5, "nome");
            if ($scope.usuario !== null) {
                $scope.setUsuario($scope.usuario);
            }
        })
    }

    attCargos();

    $scope.email = {};

    $scope.data_atual = new Date().getTime();

    $scope.telefone_novo = {};
    $scope.telefone = {};

    $scope.permissoes = [];

    $scope.estados = [];
    $scope.cidades = [];

    permissaoService.getPermissoes(function (p) {
        $scope.permissoes = p.permissoes;
    })

    $scope.cargo_tipo_tarefa = [];

    $scope.addCargo = function (cargo) {

        for (var i = 0; i < $scope.tipo_tarefa.cargos.length; i++) {
            if ($scope.tipo_tarefa.cargos[i].id === cargo.id) {
                msg.erro("Esse cargo ja esta relacionado com essa tarefa");
                return;
            }
        }

        $scope.tipo_tarefa.cargos[$scope.tipo_tarefa.cargos.length] = cargo;
        $scope.setTipoTarefa($scope.tipo_tarefa);

    }

    $scope.removeCargoTarefa = function (cargo) {

        var nc = [];

        for (var i = 0; i < $scope.tipo_tarefa.cargos.length; i++) {
            if ($scope.tipo_tarefa.cargos[i].id !== cargo.id) {
                nc[nc.length] = $scope.tipo_tarefa.cargos[i];
            }
        }

        $scope.tipo_tarefa.cargos = nc;

        $scope.setTipoTarefa($scope.tipo_tarefa);

    }

    $scope.setTipoTarefa = function (tt) {

        $scope.tipo_tarefa = tt;
        $scope.cargos_tipo_tarefa = createList(tt.cargos, 1, 3, "nome");

    }

    usuarioService.getUsuario(function (p) {
        $scope.usuario_novo = p.usuario;
    })
    telefoneService.getTelefone(function (p) {
        $scope.telefone_novo = p.telefone;
        $scope.telefone = angular.copy($scope.telefone_novo);
    })



    cidadeService.getElementos(function (p) {
        var estados = [];
        var cidades = p.elementos;
        $scope.cidades = cidades;

        lbl:
                for (var i = 0; i < cidades.length; i++) {
            var c = cidades[i];
            for (var j = 0; j < estados.length; j++) {
                if (estados[j].id === c.estado.id) {
                    estados[j].cidades[estados[j].cidades.length] = c;
                    c.estado = estados[j];
                    continue lbl;
                }
            }
            c.estado["cidades"] = [c];
            estados[estados.length] = c.estado;
        }

        $scope.estados = estados;
    })
    $scope.novoUsuario = function () {

        $scope.usuario = angular.copy($scope.usuario_novo);

    }

    $scope.removeTelefone = function (tel) {

        remove($scope.usuario.telefones, tel);

    }
    $scope.addTelefone = function () {
        $scope.usuario.telefones[$scope.usuario.telefones.length] = $scope.telefone;
        $scope.telefone = angular.copy($scope.telefone_novo);
    }

    $scope.marginTop = 0;
    $scope.setUsuario = function (usuario) {

        $scope.usuario = usuario;

        equalize(usuario, "cargo", $scope.cargos);

        var dv = $("#dvUsuarios");
        var tr = $("#tr_" + $scope.usuario.id);

        $scope.marginTop = tr.offset().top - dv.offset().top;


        equalize(usuario.endereco, "cidade", $scope.cidades);
        if (typeof usuario.endereco.cidade !== 'undefined') {
            $scope.estado = usuario.endereco.cidade.estado;
        } else {
            usuario.endereco.cidade = $scope.cidades[0];
            $scope.estado = usuario.endereco.cidade.estado;
        }

    }

    $scope.novoTipoTarefa = function () {

        $scope.tipo_tarefa = angular.copy($scope.tipo_tarefa_novo);
        $scope.setTipoTarefa($scope.tipo_tarefa);

    }

    $scope.mergeTipoTarefa = function (tt) {
        if (tt.nome === "") {
            msg.erro("Digite o nome");
            return;
        }
        baseService.merge(tt, function (r) {
            if (r.sucesso) {
                $scope.tipo_tarefa = r.o;
                msg.alerta("Operacao efetuada com sucesso");
                attTiposTarefa();
            } else {
                msg.erro("Problema ao efetuar operacao. " + r.mensagem);
            }
        });
    }

    $scope.deleteTipoTarefa = function (tt) {
        baseService.delete(tt, function (r) {
            if (r.sucesso) {
                msg.alerta("Operacao efetuada com sucesso");
                attTiposTarefa();
            } else {
                msg.erro("Problema ao efetuar operacao");
            }
        });
    }

    $scope.mergeCargo = function (cargo) {
        if (cargo.nome === "") {
            msg.erro("Digite o nome");
            return;
        }
        baseService.merge(cargo, function (r) {
            if (r.sucesso) {
                msg.alerta("Operacao efetuada com sucesso");
                $scope.cargo = angular.copy($scope.cargo_novo);
                attCargos();
            } else {
                msg.erro("Problema ao efetuar operacao. " + r.mensagem);
            }
        });
    }

    $scope.deleteCargo = function (cargo) {
        baseService.delete(cargo, function (r) {
            if (r.sucesso) {
                msg.alerta("Operacao efetuada com sucesso");
                attCargos();
            } else {
                msg.erro("Problema ao efetuar operacao");
            }
        });
    }

    $scope.mergeUsuario = function () {

        if ($scope.usuario.endereco.cidade == null) {
            msg.erro("Usuario sem cidade.");
            return;
        }

        baseService.merge($scope.usuario, function (r) {
            if (r.sucesso) {
                $scope.usuario = r.o;

                msg.alerta("Operacao efetuada com sucesso");
                $scope.setUsuario($scope.usuario);
                $scope.usuarios.attList();

            } else {
                msg.erro("Problema ao efetuar operacao. " + r.mensagem);
            }
        });

    }
    $scope.deleteUsuario = function () {
        baseService.delete($scope.usuario, function (r) {
            if (r.sucesso) {
                msg.alerta("Operacao efetuada com sucesso");
                $scope.fornecedores.attList();
            } else {
                msg.erro("Problema ao efetuar operacao");
            }
        });
    }

    $scope.removeUsuario = function (tel) {

        remove($scope.usuario.telefones, tel);

    }
    $scope.addUsuario = function () {
        $scope.usuario.telefones[$scope.usuario.telefones.length] = $scope.telefone;
        $scope.telefone = angular.copy($scope.telefone_novo);
    }

})

rtc.controller("crtEntrada", function ($scope, sistemaService, uploadService) {

    $scope.xmls = [];

    $scope.pedidos = [];

    $scope.arquivos = [];

    var buscarPedido = function (xml, i) {

        sistemaService.getPedidoEntradaSemelhante(xml, function (p) {

            if (p.sucesso) {

                var pedidos = p.pedidos;

                if (pedidos.length == 0) {

                    msg.erro("Nao foi encontrado nenhum pedido de compra referente a essa Nota");

                } else {

                    var p = pedidos[0];
                    p.nota.xml = $scope.arquivos[i];
                    p.notas_logisticas[p.notas_logisticas.length] = p.nota;

                    $scope.pedidos = [p];

                }

            } else {

                msg.erro(p.mensagem);

            }

        })

    }

    $scope.removeOperacao = function (op) {

        remove($scope.pedidos[0].notas_logisticas, op);

    }

    $scope.finalizarNotas = function (notas, pedido) {

        sistemaService.finalizarNotas(notas, function (r) {

            if (r.sucesso) {

                msg.alerta("Operacao efetuada com sucesso");
                $scope.pedidos = [];

            } else {

                msg.erro("Problema ao efetuar operacao " + r.mensagem);

            }

        })

    }

    $("#flXML").change(function () {

        var arquivos = $(this).prop("files");

        for (var i = 0; i < arquivos.length; i++) {
            var sp = arquivos[i].name.split(".");
            if (sp[sp.length - 1] != "xml") {
                msg.alerta("Arquivo: " + arquivos[i].name + ", invalido");
                $("#grpArquivos").removeClass("has-success").addClass("has-error");
                return;
            }
        }


        uploadService.upload(arquivos, function (arqs, sucesso) {

            if (!sucesso) {

                msg.erro("Falha ao subir arquivo");

            } else {

                $scope.arquivos = arqs;

                for (var i = 0; i < arquivos.length; i++) {
                    var reader = new FileReader();
                    reader["ii"] = i;
                    reader.onload = function (arquivo) {

                        buscarPedido(xmlToJson(arquivo.target.result), this.ii);

                    };
                    reader.readAsText(arquivos[i]);
                }

            }

        })

    });


})
rtc.controller("crtProdutoClienteLogistic", function ($scope, produtoClienteLogisticService) {

    $scope.produtos = createAssinc(produtoClienteLogisticService, 1, 3, 10);
    $scope.produtos.attList();
    assincFuncs(
            $scope.produtos,
            "produto",
            ["id_universal", "nome", "empresa.nome"]);

    $scope.to = function (num) {
        var k = [];
        for (var i = 0; i < num; i++) {
            k[i] = i;
        }
        return k;
    }


})
rtc.controller("crtMovimentos", function ($scope, movimentoService, sistemaService, notaService, bancoService, baseService) {

    $scope.movimentos = createAssinc(movimentoService, 1, 10, 10);
    $scope.movimentos.attList();
    assincFuncs(
            $scope.movimentos,
            "movimento",
            ["id", "valor", "juros", "descontos", "data", "banco.nome", "saldo_anterior", "operacao.nome", "historico.nome"]);

    $scope.bancos = createAssinc(bancoService, 1, 3, 10);

    assincFuncs(
            $scope.bancos,
            "banco",
            ["id", "codigo", "nome", "conta", "agencia", "saldo"], "filtroBanco");


    notaService.filtro_base = "nota.emitida=true AND nota.cancelada=false";
    $scope.notas = createAssinc(notaService, 1, 10, 10);

    assincFuncs(
            $scope.notas,
            "nota",
            ["ficha", "numero", "saida", "data_emissao", "cliente.razao_social", "fornecedor.nome"], "filtroNota");

    $scope.movimento_novo = {};
    $scope.movimento = {};

    $scope.data_atual = new Date().getTime();

    movimentoService.getMovimento(function (m) {

        $scope.movimento_novo = m.movimento;
        $scope.movimento = angular.copy(m.movimento);

    })

    sistemaService.getOperacoes(function (o) {

        $scope.operacoes = o.operacoes;

    })

    sistemaService.getHistoricos(function (h) {

        $scope.historicos = h.historicos;

    })

    $scope.getVencimentos = function (nota) {

        notaService.getVencimentos(nota, function (v) {

            nota.vencimentos = v.vencimentos;

        })

    }


    $scope.novoMovimento = function () {

        $scope.movimento = angular.copy($scope.movimento_novo);
        $scope.movimento.data_texto = toTime($scope.movimento.data);
        $scope.movimento.historico = $scope.historicos[0];
        $scope.movimento.operacao = $scope.operacoes[0];


    }

    $scope.criarEstorno = function (movimento) {

        $scope.novoMovimento();

        var m = $scope.movimento;
        m.data = movimento.data;
        m.data_texto = toTime(m.data);
        m.banco = movimento.banco;
        m.estorno = movimento.id;
        m.valor = movimento.valor + movimento.juros - movimento.descontos;
        m.vencimento = movimento.vencimento;
        m.juros = 0;
        m.descontos = 0;

    }

    $scope.setMovimento = function (movimento) {

        $scope.movimento = movimento;
        $scope.movimento.data_texto = toTime($scope.movimento.data);
        equalize(movimento, "operacao", $scope.operacoes);
        equalize(movimento, "historico", $scope.historicos);

    }

    $scope.setBanco = function (banco) {

        $scope.movimento.banco = banco;

    }

    $scope.setVencimento = function (vencimento) {

        $scope.movimento.vencimento = vencimento;
        vencimento.movimento = $scope.movimento;

    }

    $scope.mergeMovimento = function () {

        if ($scope.movimento.banco == null) {
            msg.erro("Movimento sem banco");
            return;
        }

        if ($scope.movimento.operacao == null) {
            msg.erro("Movimento sem operacao");
            return;
        }

        if ($scope.movimento.historico == null) {
            msg.erro("Movimento sem historico");
            return;
        }
        /*
         $scope.movimento.data = fromTime($scope.movimento.data_texto);
         
         if ($scope.movimento.data < 0) {
         
         msg.alerta("Data do movimento incorreta");
         return;
         
         }
         */

        baseService.insert($scope.movimento, function (r) {
            if (r.sucesso) {
                $scope.movimento = r.o;
                equalize($scope.movimento, "operacao", $scope.operacoes);
                equalize($scope.movimento, "historico", $scope.historicos);
                msg.alerta("Operacao efetuada com sucesso");
                $scope.movimentos.attList();
            } else {
                msg.erro("Problema ao efetuar operacao. " + r.mensagem);
            }
        });

    }
    $scope.deleteMovimento = function () {
        baseService.delete($scope.movimento, function (r) {
            if (r.sucesso) {
                msg.alerta("Operacao efetuada com sucesso");
                $scope.movimentos.attList();
            } else {
                msg.erro("Problema ao efetuar operacao");
            }
        });
    }

    $scope.removeDocumento = function (documento) {
        remove($scope.fornecedor.documentos, documento);
    }

})
rtc.controller("crtNotas", function ($scope, notaService, baseService, produtoService, produtoNotaService, vencimentoService, sistemaService, formaPagamentoService, transportadoraService, clienteService, fornecedorService, uploadService) {

    $scope.notas = createAssinc(notaService, 1, 10, 10);
    $scope.notas.attList();
    assincFuncs(
            $scope.notas,
            "nota",
            ["ficha", "numero", "transportadora.razao_social", "saida", "data_emissao", "cliente.razao_social", "fornecedor.nome"]);

    $scope.produtos = createAssinc(produtoService, 1, 3, 4);

    assincFuncs(
            $scope.produtos,
            "produto",
            ["codigo", "nome", "disponivel"], "filtroProdutos");

    $scope.transportadoras = createAssinc(transportadoraService, 1, 3, 4);

    assincFuncs(
            $scope.transportadoras,
            "transportadora",
            ["codigo", "razao_social"], "filtroTransportadoras");

    $scope.clientes = createAssinc(clienteService, 1, 3, 4);

    assincFuncs(
            $scope.clientes,
            "cliente",
            ["codigo", "razao_social"], "filtroClientes");

    $scope.fornecedores = createAssinc(fornecedorService, 1, 3, 4);

    assincFuncs(
            $scope.fornecedores,
            "fornecedor",
            ["codigo", "nome"], "filtroFornecedores");



    $scope.uploadXML = function (k) {
        $("#" + k).change(function () {

            uploadService.upload($(this).prop("files"), function (arquivos, sucesso) {

                if (!sucesso) {

                    msg.erro("Falha ao subir arquivo");

                } else {

                    for (var i = 0; i < arquivos.length; i++) {

                        $scope.nota.xml = arquivos[i];

                    }

                    msg.alerta("Upload feito com sucesso");
                }

            })

        }).click();
    }
    $scope.uploadDANFE = function (k) {
        $("#" + k).change(function () {

            uploadService.upload($(this).prop("files"), function (arquivos, sucesso) {

                if (!sucesso) {

                    msg.erro("Falha ao subir arquivo");

                } else {

                    for (var i = 0; i < arquivos.length; i++) {

                        $scope.nota.danfe = arquivos[i];

                    }

                    msg.alerta("Upload feito com sucesso");
                }

            })

        }).click();
    }

    $scope.nova_novo = {};

    $scope.produto_nota_novo = {};

    $scope.produto_nota = {};

    $scope.vencimento_novo = {};

    $scope.vencimento = {};

    $scope.nota = {};

    $scope.produto = {};

    $scope.formas_pagamento = {};

    $scope.setTransportadora = function (trans) {

        $scope.nota.transportadora = trans;

    }


    $scope.getTotalNota = function () {

        var total = 0;

        for (var i = 0; i < $scope.nota.produtos.length; i++) {

            var p = $scope.nota.produtos[i];

            total += p.valor_total;

        }

        return total;

    }

    $scope.calcular = function () {

        for (var i = 0; i < $scope.nota.produtos.length; i++) {
            var p = $scope.nota.produtos[i];
            p.valor_total = p.valor_unitario * p.quantidade;
        }

        if ($scope.nota.calcular_valores) {
            notaService.calcularImpostosAutomaticamente($scope.nota, function (n) {

                $scope.nota = n.o;
                $scope.nota.calcular_valores = true;
                equalize($scope.nota, "forma_pagamento", $scope.formas_pagamento);

            })
        }

    }

    $scope.setCliente = function (cli) {

        $scope.nota.cliente = cli;

    }

    $scope.setFornecedor = function (forn) {

        $scope.nota.fornecedor = forn;

    }

    vencimentoService.getVencimento(function (v) {

        $scope.vencimento = v.vencimento;
        $scope.vencimento.data_texto = toDate(v.vencimento.data);

        $scope.vencimento_novo = angular.copy($scope.vencimento);

    })

    produtoNotaService.getProdutoNota(function (pp) {

        $scope.produto_nota_novo = pp.produto_nota;
        $scope.produto_nota = angular.copy(pp.produto_nota);

    })

    $scope.setProduto = function (produto) {

        $scope.produto_nota.produto = produto;
        $scope.addProduto();

    }

    $scope.addProduto = function (produto) {


        $scope.nota.produtos[$scope.nota.produtos.length] = $scope.produto_nota;
        $scope.produto_nota.nota = $scope.nota;
        $scope.produto_nota = angular.copy($scope.produto_nota_novo);
        $scope.calcular();

    }

    $scope.removerProduto = function (produto) {

        remove($scope.nota.produtos, produto);

    }

    $scope.mergeNota = function () {

        var n = $scope.nota;

        if (n.cliente == null && n.saida) {
            msg.erro("Nota de saida sem cliente.");
            return;
        }

        if (n.transportadora == null) {
            msg.erro("Nota sem transportadora.");
            return;
        }

        if (n.fornecedor == null && !n.saida) {
            msg.erro("Nota de entrada sem fornecedor.");
            return;
        }

        if (n.forma_pagamento == null) {
            msg.erro("Nota sem forma de pagamento");
            return;
        }

        for (var i = 0; i < $scope.nota.vencimentos.length; i++) {
            $scope.nota.vencimentos[i].data = fromDate($scope.nota.vencimentos[i].data_texto);
            if ($scope.nota.vencimentos[i].data < 0) {
                msg.alerta("Data do " + (i + 1) + "?� vencimento, incorreta");
                return;
            }
        }

        $scope.nota.data_emissao = fromTime($scope.nota.data_emissao_texto);
        if ($scope.nota.data_emissao < 0) {
            msg.alerta("Data de emissao incorreta");
            return;
        }

        baseService.merge(n, function (r) {
            if (r.sucesso) {
                $scope.nota = r.o;
                equalize($scope.nota, "forma_pagamento", $scope.formas_pagamento);
                msg.alerta("Operacao efetuada com sucesso");
                $scope.notas.attList();
            } else {
                $scope.nota = r.o;
                equalize($scope.nota, "forma_pagamento", $scope.formas_pagamento);
                msg.erro("Ocorreu o seguinte problema: " + r.mensagem);
            }
        });

    }

    notaService.getNota(function (n) {

        n.nota.produtos = [];
        n.nota.xml = "";
        n.nota.danfe = "";
        $scope.nota_novo = angular.copy(n.nota);

    })

    $scope.removeVencimento = function (v) {

        if (v.movimento !== null) {

            msg.erro("O vencimento tem um movimento relacionado e nao pode ser excluido");
            return;

        }

        remove($scope.nota.vencimentos, v);

    }

    $scope.addVencimento = function () {

        $scope.nota.vencimentos[$scope.nota.vencimentos.length] = $scope.vencimento;
        $scope.vencimento.nota = $scope.nota;
        $scope.vencimento = angular.copy($scope.vencimento_novo);

    }

    $scope.novoNota = function () {

        $scope.setNota(angular.copy($scope.nota_novo));

    }

    $scope.setNota = function (nota) {

        $scope.nota = nota;
        $scope.nota.calcular_valores = false;

        $scope.nota.data_emissao_texto = toTime($scope.nota.data_emissao);

        if ($scope.nota.id === 0) {

            $scope.nota.vencimentos = [];
            $scope.nota.produtos = [];

            formaPagamentoService.getFormasPagamento($scope.nota, function (f) {

                $scope.formas_pagamento = f.formas;
                $scope.nota.forma_pagamento = $scope.formas_pagamento[0];
                loading.close();

            });

            $scope.calcular();

            return;

        }

        notaService.getProdutos(nota, function (p) {

            nota.produtos = p.produtos;

            notaService.getVencimentos(nota, function (v) {

                nota.vencimentos = v.vencimentos;

                for (var i = 0; i < nota.vencimentos.length; i++) {

                    nota.vencimentos[i].data_texto = toDate(nota.vencimentos[i].data);

                }

                formaPagamentoService.getFormasPagamento(nota, function (f) {
                    $scope.formas_pagamento = f.formas;
                    equalize(nota, "forma_pagamento", $scope.formas_pagamento);
                    $scope.calcular();
                })

            })

        })

    }

    $scope.deleteNota = function () {

        baseService.delete($scope.nota, function (r) {
            if (r.sucesso) {
                msg.alerta("Operacao efetuada com sucesso");
                $scope.nota = angular.copy($scope.novo_pedido);
                $scope.notas.attList();
            } else {
                msg.erro("Problema ao efetuar operacao");
            }
        });

    }

})
rtc.controller("crtBancos", function ($scope, bancoService, baseService) {

    $scope.bancos = createAssinc(bancoService, 1, 3, 10);
    $scope.bancos.attList();
    assincFuncs(
            $scope.bancos,
            "banco",
            ["id", "codigo", "nome", "conta", "agencia", "saldo"]);

    $scope.banco_novo = {};
    $scope.banco = {};
    $scope.estado = {};

    $scope.data_atual = new Date().getTime();

    bancoService.getBanco(function (p) {

        $scope.banco_novo = p.banco;

    })


    $scope.novoBanco = function () {

        $scope.banco = angular.copy($scope.banco_novo);

    }

    $scope.setBanco = function (banco) {

        $scope.banco = banco;
    }

    $scope.mergeBanco = function () {

        baseService.merge($scope.banco, function (r) {
            if (r.sucesso) {
                $scope.banco = r.o;


                msg.alerta("Operacao efetuada com sucesso");
                $scope.setBanco($scope.banco);
                $scope.bancos.attList();



            } else {
                msg.erro("Problema ao efetuar operacao. ");
            }
        });

    }
    $scope.deleteBanco = function () {
        baseService.delete($scope.banco, function (r) {
            if (r.sucesso) {
                msg.alerta("Operacao efetuada com sucesso");
                $scope.bancos.attList();
            } else {
                msg.erro("Problema ao efetuar operacao");
            }
        });
    }

})
rtc.controller("crtCotacoesEntrada", function ($scope, cotacaoEntradaService, transportadoraService, tabelaService, baseService, produtoService, sistemaService, statusCotacaoEntradaService, fornecedorService, produtoCotacaoEntradaService) {

    $scope.cotacoes = createAssinc(cotacaoEntradaService, 1, 10, 10);
    $scope.cotacoes.attList();
    assincFuncs(
            $scope.cotacoes,
            "cotacao_entrada",
            ["id", "fornecedor.nome", "id_status", "data", "usuario.nome"]);

    if (typeof rtc["id_cotacao"] !== 'undefined' && typeof rtc['id_empresa'] !== 'undefined') {

        produtoService.empresa = rtc['id_empresa'];

    }

    $scope.produtos = createAssinc(produtoService, 1, 3, 4);

    assincFuncs(
            $scope.produtos,
            "produto",
            ["codigo", "nome", "disponivel"], "filtroProdutos");


    $scope.fornecedores = createAssinc(fornecedorService, 1, 3, 4);

    assincFuncs(
            $scope.fornecedores,
            "fornecedor",
            ["codigo", "nome"], "filtroFornecedores");


    $scope.status_cotacao = [];

    $scope.cotacao_novo = {};

    $scope.produto_cotacao_novo = {};

    $scope.cotacao = {};

    $scope.qtd = 0;

    $scope.frete = 0;

    $scope.valor = 0;

    $scope.produto = {};

    $scope.fretes = [];

    $scope.podeFormarPedido = function () {

        return $scope.cotacao.status.id == 2;

    }



    $scope.formarPedido = function (transportadora) {

        cotacaoEntradaService.formarPedido($scope.cotacao, transportadora, $scope.frete, function (f) {

            if (f.sucesso) {

                $scope.cotacao = f.o.cotacao;
                equalize($scope.cotacao, "status", $scope.status_cotacao);
                msg.alerta("Operacao efetuada com sucesso, altere os detahes do pedido gerado.");

            } else {

                msg.erro("Problema ao efetuar operacao");

            }


        })

    }

    statusCotacaoEntradaService.getStatus(function (st) {

        $scope.status_cotacao = st.status;

    })


    $scope.setFornecedor = function (forn) {

        $scope.pedido.fornecedor = forn;

    }

    produtoCotacaoEntradaService.getProdutoCotacao(function (pp) {

        $scope.produto_cotacao_novo = pp.produto_cotacao;

    })

    $scope.getTotalCotacao = function () {

        var tot = 0;

        for (var i = 0; i < $scope.cotacao.produtos.length; i++) {

            var p = $scope.cotacao.produtos[i];

            tot += (p.valor) * p.quantidade;

        }

        return tot;

    }

    $scope.addProduto = function (produto) {

        var pp = angular.copy($scope.produto_cotacao_novo);
        pp.produto = produto;
        pp.cotacao = $scope.cotacao;
        pp.valor = $scope.valor;
        pp.quantidade = $scope.qtd;

        for (var j = 0; j < $scope.cotacao.produtos.length; j++) {

            var pr = $scope.cotacao.produtos[j];

            if (pr.produto.id === pp.produto.id) {

                pr.quantidade += pp.quantidade;
                return;

            }

        }

        pp.valor_unitario = pp.valor / pp.produto.quantidade_unidade;

        $scope.cotacao.produtos[$scope.cotacao.produtos.length] = pp;

    }

    $scope.removerProduto = function (produto) {

        remove($scope.cotacao.produtos, produto);

    }

    $scope.mergeCotacao = function () {

        var p = $scope.cotacao;

        if (typeof rtc["id_cotacao"] !== 'undefined' && typeof rtc['id_empresa'] !== 'undefined') {

            $scope.cotacao.status = $scope.status_cotacao[1];

        }

        if (p.fornecedor == null) {
            msg.erro("Cotacao sem fornecedor.");
            return;
        }

        if (p.status == null) {
            msg.erro("Cotacao sem status.");
            return;
        }

        p.observacao = formatTextArea(p.observacao);

        baseService.merge(p, function (r) {
            if (r.sucesso) {
                $scope.cotacao = r.o;
                equalize($scope.cotacao, "status", $scope.status_cotacao);
                $scope.cotacoes.attList();
                msg.alerta("Operacao efetuada com sucesso");
            } else {
                $scope.cotacao = r.o;
                equalize($scope.cotacao, "status", $scope.status_cotacao);
                msg.erro("Ocorreu o seguinte problema: " + r.mensagem);
            }
        });

    }

    $scope.calculoPronto = function () {

        if ($scope.cotacao.fornecedor != null && $scope.cotacao.produtos != null) {
            if ($scope.cotacao.produtos.length > 0) {
                return true;
            }
        }
        return false;

    }


    $scope.getFretes = function () {

        var pesoTotal = 0;
        var valorTotal = 0;

        for (var i = 0; i < $scope.cotacao.produtos.length; i++) {
            var p = $scope.cotacao.produtos[i];
            valorTotal += (p.valor_base) * p.quantidade;
            pesoTotal += p.produto.peso_bruto * p.quantidade;
        }

        tabelaService.getFretes(null, {cidade: $scope.cotacao.fornecedor.endereco.cidade, valor: valorTotal, peso: pesoTotal}, function (f) {

            $scope.fretes = f.fretes;

        })

    }


    cotacaoEntradaService.getCotacao(function (ped) {

        ped.cotacao.produtos = [];
        $scope.cotacao_novo = ped.cotacao;

    })

    $scope.temCotacao = function () {

        return typeof $scope.cotacao["id"] !== 'undefined';

    }

    if (typeof rtc["id_cotacao"] !== 'undefined' && typeof rtc['id_empresa'] !== 'undefined') {

        cotacaoEntradaService.getCotacaoEspecifica(rtc["id_cotacao"], rtc["id_empresa"], function (f) {
            if (f.cotacoes.length > 0) {
                $scope.cotacao = f.cotacoes[0];
                $scope.setCotacao($scope.cotacao);
            }
        })

    }

    $scope.novoCotacao = function () {

        $scope.setCotacao(angular.copy($scope.cotacao_novo));

    }

    $scope.attValorUnitario = function (produto) {

        produto.valor = produto.valor_unitario * produto.produto.quantidade_unidade;

    }

    $scope.attValor = function (produto) {

        produto.valor_unitario = produto.valor / produto.produto.quantidade_unidade;

    }

    $scope.setCotacao = function (cotacao) {

        $scope.cotacao = cotacao;

        if ($scope.cotacao.id === 0) {

            $scope.cotacao.status = $scope.status_cotacao[0];

            return;

        }

        cotacaoEntradaService.getProdutos(cotacao, function (p) {

            cotacao.produtos = p.produtos;
            equalize(cotacao, "status", $scope.status_cotacao);

            var ic = $("#myIframe").contents();

            ic.find("#logoEmpresa img").remove();
            ic.find("#logoEmpresa").append($("#logo").clone().addClass("product-image"));
            ic.find("#infoEmpresa").html(cotacao.empresa.nome + ", " + cotacao.empresa.endereco.cidade.nome + "-" + cotacao.empresa.endereco.cidade.estado.sigla);
            ic.find("#infoEmpresa2").html(cotacao.empresa.endereco.bairro + ", " + cotacao.empresa.endereco.cep.valor + " - " + cotacao.empresa.telefone.numero);

            ic.find("#idPedido").html($scope.cotacao.id);
            ic.find("#nomeUsuario").html($scope.cotacao.usuario.nome);
            ic.find("#nomeCliente").html($scope.cotacao.fornecedor.nome);
            ic.find("#cnpjCliente").html($scope.cotacao.fornecedor.cnpj.valor);
            ic.find("#ruaCliente").html($scope.cotacao.fornecedor.endereco.rua);
            ic.find("#cidadeCliente").html($scope.cotacao.fornecedor.endereco.cidade.nome);


            var p = ic.find("#produto").each(function () {
                p = $(this);
            });

            p.hide();

            ic.find("#produtos").find("tr").each(function () {
                if (typeof $(this).data("gerado") !== 'undefined') {
                    $(this).remove();
                }
            });

            var p = p.clone();

            var icms = 0;
            var base = 0;
            var total = 0;
            for (var i = 0; i < $scope.cotacao.produtos.length; i++) {

                p = p.clone();

                var pro = $scope.cotacao.produtos[i];

                pro.valor_unitario = pro.valor / pro.produto.quantidade_unidade;

                icms += pro.icms;
                base += pro.base_calculo;
                p.find("[data-tipo='nome']").html(pro.produto.nome);
                p.find("[data-tipo='valor']").html(($scope.cotacao.tratar_em_litros ? (pro.valor / pro.produto.quantidade_unidade) : pro.valor).toFixed(2));
                p.find("[data-tipo='quantidade']").html(($scope.cotacao.tratar_em_litros ? (pro.quantidade * pro.produto.quantidade_unidade) : pro.quantidade).toFixed(2));
                p.find("[data-tipo='validade']").html('-----');
                p.find("[data-tipo='total']").html(((pro.valor) * pro.quantidade).toFixed(2));
                p.data("gerado", true);

                ic.find("#produtos").append(p);
                p.show();

                total += (pro.valor) * pro.quantidade;

            }
            var alicota = (icms * 100 / base).toFixed(2);

            ic.find("#prazo").html(cotacao.prazo);
            ic.find("#alicota").html('----');
            ic.find("#icms").html('-----');

            ic.find("#tipoFrete").html(cotacao.frete_incluso ? 'CIF' : 'FOB');
            ic.find("#nomeTransportadora").html(cotacao.transportadora.razao_social);
            ic.find("#contato").html(cotacao.transportadora.email.endereco);
            ic.find("#valorFrete").html(cotacao.frete);

            ic.find("#observacoes").html(cotacao.observacoes);
            ic.find("#nomeUsuario2").html(cotacao.usuario.nome);

        })


    }


    $scope.setFornecedor = function (forn) {

        $scope.cotacao.fornecedor = forn;

    }

    $scope.deleteCotacao = function () {

        baseService.delete($scope.cotacao, function (r) {
            if (r.sucesso) {
                msg.alerta("Operacao efetuada com sucesso");
                $scope.cotacao = angular.copy($scope.novo_cotacao);
                $scope.cotacoes.attList();
            } else {
                msg.erro("Problema ao efetuar operacao");
            }
        });

    }



})
rtc.controller("crtPedidosEntrada", function ($scope, pedidoEntradaService, tabelaService, baseService, produtoService, sistemaService, statusPedidoEntradaService, transportadoraService, fornecedorService, produtoPedidoEntradaService) {

    $scope.pedidos = createAssinc(pedidoEntradaService, 1, 10, 10);
    $scope.pedidos.attList();
    assincFuncs(
            $scope.pedidos,
            "pedido_entrada",
            ["id", "fornecedor.nome", "id_status", "frete", "prazo", "data"]);

    $scope.produtos = createAssinc(produtoService, 1, 3, 4);

    assincFuncs(
            $scope.produtos,
            "produto",
            ["codigo", "nome", "disponivel"], "filtroProdutos");

    $scope.transportadoras = createAssinc(transportadoraService, 1, 3, 4);

    assincFuncs(
            $scope.transportadoras,
            "transportadora",
            ["codigo", "razao_social"], "filtroTransportadoras");

    $scope.fornecedores = createAssinc(fornecedorService, 1, 3, 4);

    assincFuncs(
            $scope.fornecedores,
            "fornecedor",
            ["codigo", "nome"], "filtroFornecedores");


    $scope.meses_validade_curta = 3;

    $scope.status_pedido = [];

    $scope.pedido_novo = {};

    $scope.produto_pedido_novo = {};

    $scope.pedido = {};

    $scope.fretes = [];

    $scope.qtd = 0;

    $scope.valor = 0;

    $scope.produto = {};



    $scope.getPesoBrutoPedido = function () {

        var tot = 0;

        for (var i = 0; i < $scope.pedido.produtos.length; i++) {

            var p = $scope.pedido.produtos[i];

            tot += (p.produto.peso_bruto) * p.quantidade;

        }

        return tot;

    }

    $scope.getTotalPedido = function () {

        var tot = 0;

        for (var i = 0; i < $scope.pedido.produtos.length; i++) {

            var p = $scope.pedido.produtos[i];

            tot += (p.valor) * p.quantidade;

        }

        return tot;

    }

    statusPedidoEntradaService.getStatus(function (st) {

        $scope.status_pedido = st.status;

    })

    $scope.setTransportadora = function (trans) {

        $scope.pedido.transportadora = trans;
        $scope.atualizaCustos();

    }

    $scope.setFornecedor = function (forn) {

        $scope.pedido.fornecedor = forn;

    }

    produtoPedidoEntradaService.getProdutoPedido(function (pp) {

        $scope.produto_pedido_novo = pp.produto_pedido;

    })

    $scope.addProduto = function (produto) {

        var pp = angular.copy($scope.produto_pedido_novo);
        pp.produto = produto;
        pp.pedido = $scope.pedido;
        pp.valor = $scope.valor;
        pp.quantidade = $scope.qtd;

        for (var j = 0; j < $scope.pedido.produtos.length; j++) {

            var pr = $scope.pedido.produtos[j];

            if (pr.produto.id === pp.produto.id) {

                pr.quantidade += pp.quantidade;
                return;

            }

        }

        pp.valor_unitario = pp.valor / pp.produto.quantidade_unidade;

        $scope.pedido.produtos[$scope.pedido.produtos.length] = pp;

    }

    $scope.removerProduto = function (produto) {

        remove($scope.pedido.produtos, produto);

    }

    $scope.mergePedido = function () {

        var p = $scope.pedido;

        if (p.fornecedor == null) {
            msg.erro("Pedido sem fornecedor.");
            return;
        }

        if (p.transportadora == null) {
            msg.erro("Pedido sem transportadora.");
            return;
        }

        if (p.status == null) {
            msg.erro("Pedido sem status.");
            return;
        }
        p.observacoes = formatTextArea(p.observacoes);

        baseService.merge(p, function (r) {
            if (r.sucesso) {
                $scope.pedido = r.o;
                equalize($scope.pedido, "status", $scope.status_pedido);
                msg.alerta("Operacao efetuada com sucesso");
            } else {
                $scope.pedido = r.o;
                equalize($scope.pedido, "status", $scope.status_pedido);
                msg.erro("Ocorreu o seguinte problema: " + r.mensagem);
            }
        });

    }

    $scope.setFrete = function (fr) {

        $scope.pedido.frete = fr.valor + fr.transportadora.despacho;
        $scope.pedido.transportadora = fr.transportadora;
        $scope.atualizaCustos();

    }

    $scope.calculoPronto = function () {

        if ($scope.pedido.fornecedor != null && $scope.pedido.produtos != null) {
            if ($scope.pedido.produtos.length > 0) {
                return true;
            }
        }
        return false;

    }


    $scope.getFretes = function () {

        var pesoTotal = 0;
        var valorTotal = 0;

        for (var i = 0; i < $scope.pedido.produtos.length; i++) {
            var p = $scope.pedido.produtos[i];
            valorTotal += (p.valor_base) * p.quantidade;
            pesoTotal += p.produto.peso_bruto * p.quantidade;
        }

        tabelaService.getFretes(null, {cidade: $scope.pedido.fornecedor.endereco.cidade, valor: valorTotal, peso: pesoTotal}, function (f) {

            $scope.fretes = f.fretes;

        })

    }


    pedidoEntradaService.getPedido(function (ped) {

        ped.pedido.produtos = [];
        $scope.pedido_novo = ped.pedido;

    })

    $scope.novoPedido = function () {

        $scope.setPedido(angular.copy($scope.pedido_novo));

    }

    $scope.attValorUnitario = function (produto) {

        produto.valor = produto.valor_unitario * produto.produto.quantidade_unidade;

    }

    $scope.attValor = function (produto) {

        produto.valor_unitario = produto.valor / produto.produto.quantidade_unidade;

    }

    $scope.setPedido = function (pedido) {

        $scope.pedido = pedido;

        if ($scope.pedido.id === 0) {

            $scope.pedido.status = $scope.status_pedido[0];

            return;

        }

        pedidoEntradaService.getProdutos(pedido, function (p) {

            pedido.produtos = p.produtos;
            equalize(pedido, "status", $scope.status_pedido);

            var ic = $("#myIframe").contents();

            ic.find("#logoEmpresa img").remove();
            ic.find("#logoEmpresa").append($("#logo").clone().addClass("product-image"));
            ic.find("#infoEmpresa").html(pedido.empresa.nome + ", " + pedido.empresa.endereco.cidade.nome + "-" + pedido.empresa.endereco.cidade.estado.sigla);
            ic.find("#infoEmpresa2").html(pedido.empresa.endereco.bairro + ", " + pedido.empresa.endereco.cep.valor + " - " + pedido.empresa.telefone.numero);

            ic.find("#idPedido").html($scope.pedido.id);
            ic.find("#nomeUsuario").html($scope.pedido.usuario.nome);
            ic.find("#nomeCliente").html($scope.pedido.fornecedor.nome);
            ic.find("#cnpjCliente").html($scope.pedido.fornecedor.cnpj.valor);
            ic.find("#ruaCliente").html($scope.pedido.fornecedor.endereco.rua);
            ic.find("#cidadeCliente").html($scope.pedido.fornecedor.endereco.cidade.nome);


            var p = ic.find("#produto").each(function () {
                p = $(this);
            });

            p.hide();

            ic.find("#produtos").find("tr").each(function () {
                if (typeof $(this).data("gerado") !== 'undefined') {
                    $(this).remove();
                }
            });

            var p = p.clone();

            var icms = 0;
            var base = 0;
            var total = 0;
            for (var i = 0; i < $scope.pedido.produtos.length; i++) {

                p = p.clone();

                var pro = $scope.pedido.produtos[i];

                pro.valor_unitario = pro.valor / pro.produto.quantidade_unidade;

                icms += pro.icms;
                base += pro.base_calculo;
                p.find("[data-tipo='nome']").html(pro.produto.nome);
                p.find("[data-tipo='valor']").html((pro.valor / pro.produto.quantidade_unidade).toFixed(2));
                p.find("[data-tipo='quantidade']").html((pro.quantidade * pro.produto.quantidade_unidade).toFixed(2));
                p.find("[data-tipo='validade']").html('-----');
                p.find("[data-tipo='total']").html(((pro.valor) * pro.quantidade).toFixed(2));
                p.data("gerado", true);

                ic.find("#produtos").append(p);
                p.show();

                total += (pro.valor) * pro.quantidade;

            }
            var alicota = (icms * 100 / base).toFixed(2);

            ic.find("#prazo").html(pedido.prazo);
            ic.find("#alicota").html('----');
            ic.find("#icms").html('-----');

            ic.find("#tipoFrete").html(pedido.frete_incluso ? 'CIF' : 'FOB');
            ic.find("#nomeTransportadora").html(pedido.transportadora.razao_social);
            ic.find("#contato").html(pedido.transportadora.email.endereco);
            ic.find("#valorFrete").html(pedido.frete);

            ic.find("#observacoes").html(pedido.observacoes);
            ic.find("#nomeUsuario2").html(pedido.usuario.nome);

        })


    }

    $scope.deletePedido = function () {

        baseService.delete($scope.pedido, function (r) {
            if (r.sucesso) {
                msg.alerta("Operacao efetuada com sucesso");
                $scope.pedido = angular.copy($scope.novo_pedido);
                $scope.pedidos.attList();
            } else {
                msg.erro("Problema ao efetuar operacao");
            }
        });

    }



})
rtc.controller("crtAcompanharPedidos", function ($scope, acompanharPedidoService, logService, tabelaService, baseService, produtoService, sistemaService, statusPedidoSaidaService, formaPagamentoService, transportadoraService, clienteService, produtoPedidoService) {

    $scope.pedidos = createAssinc(acompanharPedidoService, 1, 10, 10);
    $scope.pedidos.attList();
    assincFuncs(
            $scope.pedidos,
            "pedido",
            ["id", "empresa.nome", "data", "frete", "id_status", "usuario.nome"]);


    $scope.gerarCobranca = function () {

        pedidoService.gerarCobranca($scope.pedido, function (r) {

            if (r.sucesso) {
                $("#retCob").html("Cobranca gerada com sucesso. <hr> " + r.retorno);
            } else {
                $("#retCob").html("Problema ao gerar cobranca");
            }

        })

    }

    sistemaService.getLogisticas(function (rr) {

        $scope.logisticas = rr.logisticas;

    })

    $scope.getLogsPedido = function (pedido) {

        logService.getLogs(pedido, function (l) {

            $scope.logs = l.logs;

            $("#shLogs").children("*").each(function () {
                $(this).remove();
            })

            for (var i = 0; i < $scope.logs.length; i++) {

                var l = $scope.logs[i];

                $("<div></div>").css('width', '100%').css('display', 'block').css('border-bottom', '1px solid Gray').css('padding', '10px').html(l.usuario + " / " + toTime(l.momento) + " / " + l.obs).appendTo($("#shLogs"));

            }

        })
    }

    $scope.getLogs = function () {

        logService.getLogs($scope.pedido, function (l) {

            $scope.logs = l.logs;

            $("#shLogs").children("*").each(function () {
                $(this).remove();
            })

            for (var i = 0; i < $scope.logs.length; i++) {

                var l = $scope.logs[i];

                $("<div></div>").css('width', '100%').css('display', 'block').css('border-bottom', '1px solid Gray').css('padding', '10px').html(l.usuario + " / " + toTime(l.momento) + " / " + l.obs).appendTo($("#shLogs"));

            }

        })
    }

    $scope.getPesoBrutoPedido = function () {

        var tot = 0;

        for (var i = 0; i < $scope.pedido.produtos.length; i++) {

            var p = $scope.pedido.produtos[i];

            tot += (p.produto.peso_bruto) * p.quantidade;

        }

        return tot;

    }

    $scope.getTotalPedido = function () {

        var tot = 0;

        for (var i = 0; i < $scope.pedido.produtos.length; i++) {

            var p = $scope.pedido.produtos[i];

            tot += (p.valor_base + p.icms + p.ipi + p.juros + p.frete) * p.quantidade;

        }

        return tot;

    }

    $scope.formas_pagamento = {};

    statusPedidoSaidaService.getStatus(function (st) {

        $scope.status_pedido = st.status;

    })

    $scope.setPedido = function (pedido) {

        $scope.pedido = pedido;

        if (pedido.logistica !== null) {

            equalize($scope.pedido, "logistica", $scope.logisticas);

        }

        if ($scope.pedido.logistica === null) {
            produtoService.filtro_base = "produto.id_logistica=0";
            transportadoraService.empresa = $scope.pedido.empresa;
        } else {
            produtoService.filtro_base = "produto.id_logistica=" + $scope.pedido.logistica.id;
            transportadoraService.empresa = $scope.pedido.logistica;
        }

        if ($scope.pedido.id === 0) {

            $scope.pedido.status = $scope.status_pedido[0];

            formaPagamentoService.getFormasPagamento($scope.pedido, function (f) {

                $scope.formas_pagamento = f.formas;
                $scope.pedido.forma_pagamento = $scope.formas_pagamento[0];

            });

            return;

        }

        acompanharPedidoService.getProdutos(pedido, function (p) {

            pedido.produtos = p.produtos;
            equalize(pedido, "status", $scope.status_pedido);

            formaPagamentoService.getFormasPagamento($scope.pedido, function (f) {
                $scope.formas_pagamento = f.formas;
                equalize(pedido, "forma_pagamento", $scope.formas_pagamento);
            })

            var ic = $("#myIframe").contents();

            ic.find("#logoEmpresa img").remove();
            ic.find("#logoEmpresa").append($("#logo").clone().addClass("product-image"));
            ic.find("#infoEmpresa").html(pedido.empresa.nome + ", " + pedido.empresa.endereco.cidade.nome + "-" + pedido.empresa.endereco.cidade.estado.sigla);
            ic.find("#infoEmpresa2").html(pedido.empresa.endereco.bairro + ", " + pedido.empresa.endereco.cep.valor + " - " + pedido.empresa.telefone.numero);

            ic.find("#idPedido").html($scope.pedido.id);
            ic.find("#nomeUsuario").html($scope.pedido.usuario.nome);
            ic.find("#nomeCliente").html($scope.pedido.cliente.razao_social);
            ic.find("#cnpjCliente").html($scope.pedido.cliente.cnpj.valor);
            ic.find("#ruaCliente").html($scope.pedido.cliente.endereco.rua);
            ic.find("#cidadeCliente").html($scope.pedido.cliente.endereco.cidade.nome);


            var p = ic.find("#produto").each(function () {
                p = $(this);
            });

            p.hide();

            ic.find("#produtos").find("tr").each(function () {
                if (typeof $(this).data("gerado") !== 'undefined') {
                    $(this).remove();
                }
            });

            var p = p.clone();

            var icms = 0;
            var base = 0;
            var total = 0;
            for (var i = 0; i < $scope.pedido.produtos.length; i++) {

                p = p.clone();

                var pro = $scope.pedido.produtos[i];
                icms += pro.icms;
                base += pro.base_calculo;
                p.find("[data-tipo='nome']").html(pro.produto.nome);
                p.find("[data-tipo='valor']").html((pro.valor_base + pro.frete + pro.juros + pro.icms).toFixed(2));
                p.find("[data-tipo='quantidade']").html(pro.quantidade);
                p.find("[data-tipo='validade']").html(toDate(pro.validade_minima));
                p.find("[data-tipo='total']").html(((pro.valor_base + pro.frete + pro.ipi + pro.juros + pro.icms) * pro.quantidade).toFixed(2));
                p.data("gerado", true);

                ic.find("#produtos").append(p);
                p.show();

                total += (pro.valor_base + pro.frete + pro.juros + pro.ipi + pro.icms) * pro.quantidade;

            }
            var alicota = (icms * 100 / base).toFixed(2);

            ic.find("#prazo").html(pedido.prazo);
            ic.find("#alicota").html(alicota);
            ic.find("#icms").html(icms);

            ic.find("#tipoFrete").html(pedido.frete_incluso ? 'CIF' : 'FOB');
            ic.find("#nomeTransportadora").html(pedido.transportadora.razao_social);
            ic.find("#contato").html(pedido.transportadora.email.endereco);
            ic.find("#valorFrete").html(pedido.frete);

            ic.find("#observacoes").html(pedido.observacoes);
            ic.find("#nomeUsuario2").html(pedido.usuario.nome);

        })


    }

    $scope.deletePedido = function () {

        baseService.delete($scope.pedido, function (r) {
            if (r.sucesso) {
                msg.alerta("Operacao efetuada com sucesso");
                $scope.pedido = angular.copy($scope.novo_pedido);
                $scope.pedidos.attList();
            } else {
                msg.erro("Problema ao efetuar operacao");
            }
        });

    }

})


rtc.controller("crtPedidos", function ($scope, pedidoService, logService, tabelaService, baseService, produtoService, sistemaService, statusPedidoSaidaService, formaPagamentoService, transportadoraService, clienteService, produtoPedidoService) {

    $scope.pedidos = createAssinc(pedidoService, 1, 10, 10);
    $scope.pedidos.attList();
    assincFuncs(
            $scope.pedidos,
            "pedido",
            ["id", "cliente.razao_social", "data", "frete", "id_status", "usuario.nome"]);

    $scope.produtos = createAssinc(produtoService, 1, 3, 4);

    assincFuncs(
            $scope.produtos,
            "produto",
            ["codigo", "nome", "disponivel"], "filtroProdutos");

    $scope.transportadoras = createAssinc(transportadoraService, 1, 3, 4);

    assincFuncs(
            $scope.transportadoras,
            "transportadora",
            ["codigo", "razao_social"], "filtroTransportadoras");

    $scope.clientes = createAssinc(clienteService, 1, 3, 4);

    assincFuncs(
            $scope.clientes,
            "cliente",
            ["codigo", "razao_social"], "filtroClientes");


    $scope.meses_validade_curta = 3;

    $scope.status_pedido = [];

    $scope.status_excluido = {};

    $scope.pedido_novo = {};

    $scope.produto_pedido_novo = {};

    $scope.pedido = {};

    $scope.fretes = [];

    $scope.qtd = 0;

    $scope.produto = {};

    $scope.logisticas = [];

    $scope.logs = [];

    $scope.retorno_cobranca = ""

    sistemaService.getLogisticas(function (rr) {

        $scope.logisticas = rr.logisticas;

    })


    $scope.gerarCobranca = function () {

        pedidoService.gerarCobranca($scope.pedido, function (r) {

            if (r.sucesso) {
                $("#retCob").html("Cobranca gerada com sucesso. <hr> " + r.retorno);
            } else {
                $("#retCob").html("Problema ao gerar cobranca");
            }

        })

    }

    $scope.getLogs = function () {

        logService.getLogs($scope.pedido, function (l) {

            $scope.logs = l.logs;

            $("#shLogs").children("*").each(function () {
                $(this).remove();
            })

            for (var i = 0; i < $scope.logs.length; i++) {

                var l = $scope.logs[i];

                $("<div></div>").css('width', '100%').css('display', 'block').css('border-bottom', '1px solid Gray').css('padding', '10px').html(l.usuario + " / " + toTime(l.momento) + " / " + l.obs).appendTo($("#shLogs"));

            }

        })


    }

    $scope.getPesoBrutoPedido = function () {

        var tot = 0;

        for (var i = 0; i < $scope.pedido.produtos.length; i++) {

            var p = $scope.pedido.produtos[i];

            tot += (p.produto.peso_bruto) * p.quantidade;

        }

        return tot;

    }

    $scope.getTotalPedido = function () {

        var tot = 0;

        for (var i = 0; i < $scope.pedido.produtos.length; i++) {

            var p = $scope.pedido.produtos[i];

            tot += (p.valor_base + p.icms + p.ipi + p.juros + p.frete) * p.quantidade;

        }

        return tot;

    }

    $scope.formas_pagamento = {};

    statusPedidoSaidaService.getStatus(function (st) {

        $scope.status_pedido = st.status;

    })

    $scope.setTransportadora = function (trans) {

        $scope.pedido.transportadora = trans;
        $scope.atualizaCustos();

    }

    $scope.setCliente = function (cli) {

        $scope.pedido.cliente = cli;
        $scope.atualizaCustos();

    }

    produtoPedidoService.getProdutoPedido(function (pp) {

        $scope.produto_pedido_novo = pp.produto_pedido;

    })

    $scope.addProduto = function (produto, validade) {

        var validades = [angular.copy(validade)];

        for (var i = 0; i < validades[0].validades.length; i++) {

            validades[0].quantidade -= validades[0].validades[i].quantidade;

        }

        var quantidades = [Math.min($scope.qtd, (validade.limite > 0) ? validade.limite : $scope.qtd)];

        while (validades[validades.length - 1].quantidade < quantidades[quantidades.length - 1]) {

            var v = validades[validades.length - 1];

            quantidades[quantidades.length] = quantidades[quantidades.length - 1] - v.quantidade;

            quantidades[quantidades.length - 2] = v.quantidade;

            var v0 = validades[0];

            if (v0.validades.length < validades.length) {

                msg.erro("Sem estoque suficiente");
                return;

            }

            validades[validades.length] = v0.validades[validades.length - 1];

        }

        lbl:
                for (var i = 0; i < validades.length; i++) {

            if (quantidades[i] === 0)
                continue;


            var pp = angular.copy($scope.produto_pedido_novo);
            pp.produto = produto;
            pp.pedido = $scope.pedido;
            pp.validade_minima = validades[i].validade;
            pp.valor_base = validade.valor;
            pp.quantidade = quantidades[i];

            for (var j = 0; j < $scope.pedido.produtos.length; j++) {

                var pr = $scope.pedido.produtos[j];

                if (pr.produto.id === pp.produto.id && pr.validade_minima === pp.validade_minima) {

                    pr.quantidade += pp.quantidade;
                    continue lbl;

                }

            }

            $scope.pedido.produtos[$scope.pedido.produtos.length] = pp;

        }



        $scope.atualizaCustos();

    }

    $scope.removerProduto = function (produto) {

        var dt = new Date().getTime();
        dt += $scope.meses_validade_curta * 30 * 24 * 60 * 60 * 1000;

        remove($scope.pedido.produtos, produto);

        if (produto.validade_minima > dt) {
            for (var i = 0; i < $scope.pedido.produtos.length; i++) {

                var p = $scope.pedido.produtos[i];

                if (p.validade_minima > produto.validade_minima && p.produto.id === produto.produto.id) {

                    remove($scope.pedido.produtos, p);
                    i--;

                }
            }
        }

        $scope.atualizaCustos();

    }

    $scope.mergePedido = function () {

        var p = $scope.pedido;

        if (p.cliente == null) {
            msg.erro("Pedido sem cliente.");
            return;
        }

        if (p.transportadora == null) {
            msg.erro("Pedido sem transportadora.");
            return;
        }

        if (p.status == null) {
            msg.erro("Pedido sem status.");
            return;
        }

        if (p.forma_pagamento == null) {
            msg.erro("Pedido sem forma de pagamento.");
            return;
        }


        baseService.merge(p, function (r) {
            if (r.sucesso) {
                $scope.pedido = r.o;
                if ($scope.pedido.logistica !== null) {
                    equalize($scope.pedido, "logistica", $scope.logisticas);
                }
                equalize($scope.pedido, "status", $scope.status_pedido);
                equalize($scope.pedido, "forma_pagamento", $scope.formas_pagamento);

                msg.alerta("Operacao efetuada com sucesso");

                if (typeof $scope.pedido["retorno"] !== 'undefined') {

                    msg.alerta($scope.pedido["retorno"]);

                }

            } else {
                $scope.pedido = r.o;
                if ($scope.pedido.logistica !== null) {
                    equalize($scope.pedido, "logistica", $scope.logisticas);
                }
                equalize($scope.pedido, "status", $scope.status_pedido);
                equalize($scope.pedido, "forma_pagamento", $scope.formas_pagamento);
                msg.erro("Ocorreu o seguinte problema: " + r.mensagem);
            }
        });

    }

    $scope.setFrete = function (fr) {

        $scope.pedido.frete = fr.valor + fr.transportadora.despacho;
        $scope.pedido.transportadora = fr.transportadora;
        $scope.atualizaCustos();

    }

    $scope.setProduto = function (produto) {

        produtoService.getValidades($scope.meses_validade_curta, produto, function (v) {

            produto.validades = v;

        })

    }

    $scope.calculoPronto = function () {

        if ($scope.pedido.cliente != null && $scope.pedido.produtos != null) {
            if ($scope.pedido.produtos.length > 0) {
                return true;
            }
        }
        return false;

    }


    $scope.getFretes = function () {

        var pesoTotal = 0;
        var valorTotal = 0;

        for (var i = 0; i < $scope.pedido.produtos.length; i++) {
            var p = $scope.pedido.produtos[i];
            valorTotal += (p.valor_base + p.juros + p.icms) * p.quantidade;
            pesoTotal += p.produto.peso_bruto * p.quantidade;
        }
        if ($scope.pedido.logistica === null) {
            tabelaService.getFretes(null, {cidade: $scope.pedido.cliente.endereco.cidade, valor: valorTotal, peso: pesoTotal}, function (f) {

                $scope.fretes = f.fretes;

            })
        } else {

            tabelaService.getFretes($scope.pedido.logistica, {cidade: $scope.pedido.cliente.endereco.cidade, valor: valorTotal, peso: pesoTotal}, function (f) {

                $scope.fretes = f.fretes;

            })
        }

    }

    $scope.atualizaCustos = function () {

        pedidoService.atualizarCustos($scope.pedido, function (np) {

            $scope.pedido = np.o;

            equalize($scope.pedido, "status", $scope.status_pedido);
            equalize($scope.pedido, "forma_pagamento", $scope.formas_pagamento);

            if ($scope.pedido.logistica !== null) {
                equalize($scope.pedido, "logistica", $scope.logisticas);
            }

        })

    }

    pedidoService.getPedido(function (ped) {

        ped.pedido.produtos = [];
        $scope.pedido_novo = ped.pedido;

    })

    $scope.novoPedido = function () {

        $scope.setPedido(angular.copy($scope.pedido_novo));

    }

    $scope.resetarPedido = function () {

        $scope.pedido.transportadora = null;
        $scope.pedido.produtos = [];

        if ($scope.pedido.logistica === null) {
            produtoService.filtro_base = "produto.id_logistica=0";
            transportadoraService.empresa = $scope.pedido.empresa;
        } else {
            produtoService.filtro_base = "produto.id_logistica=" + $scope.pedido.logistica.id;
            transportadoraService.empresa = $scope.pedido.logistica;
        }

        $scope.produtos.attList();
        $scope.transportadoras.attList();

    }

    $scope.setPedido = function (pedido) {

        $scope.pedido = pedido;

        if (pedido.logistica !== null) {

            equalize($scope.pedido, "logistica", $scope.logisticas);

        }

        if ($scope.pedido.logistica === null) {
            produtoService.filtro_base = "produto.id_logistica=0";
            transportadoraService.empresa = $scope.pedido.empresa;
        } else {
            produtoService.filtro_base = "produto.id_logistica=" + $scope.pedido.logistica.id;
            transportadoraService.empresa = $scope.pedido.logistica;
        }

        if ($scope.pedido.id === 0) {

            $scope.pedido.status = $scope.status_pedido[0];

            formaPagamentoService.getFormasPagamento($scope.pedido, function (f) {

                $scope.formas_pagamento = f.formas;
                $scope.pedido.forma_pagamento = $scope.formas_pagamento[0];

            });

            return;

        }

        pedidoService.getProdutos(pedido, function (p) {

            pedido.produtos = p.produtos;
            equalize(pedido, "status", $scope.status_pedido);

            formaPagamentoService.getFormasPagamento($scope.pedido, function (f) {
                $scope.formas_pagamento = f.formas;
                equalize(pedido, "forma_pagamento", $scope.formas_pagamento);
            })

            var ic = $("#myIframe").contents();

            ic.find("#logoEmpresa img").remove();
            ic.find("#logoEmpresa").append($("#logo").clone().addClass("product-image"));
            ic.find("#infoEmpresa").html(pedido.empresa.nome + ", " + pedido.empresa.endereco.cidade.nome + "-" + pedido.empresa.endereco.cidade.estado.sigla);
            ic.find("#infoEmpresa2").html(pedido.empresa.endereco.bairro + ", " + pedido.empresa.endereco.cep.valor + " - " + pedido.empresa.telefone.numero);

            ic.find("#idPedido").html($scope.pedido.id);
            ic.find("#nomeUsuario").html($scope.pedido.usuario.nome);
            ic.find("#nomeCliente").html($scope.pedido.cliente.razao_social);
            ic.find("#cnpjCliente").html($scope.pedido.cliente.cnpj.valor);
            ic.find("#ruaCliente").html($scope.pedido.cliente.endereco.rua);
            ic.find("#cidadeCliente").html($scope.pedido.cliente.endereco.cidade.nome);


            var p = ic.find("#produto").each(function () {
                p = $(this);
            });

            p.hide();

            ic.find("#produtos").find("tr").each(function () {
                if (typeof $(this).data("gerado") !== 'undefined') {
                    $(this).remove();
                }
            });

            var p = p.clone();

            var icms = 0;
            var base = 0;
            var total = 0;
            for (var i = 0; i < $scope.pedido.produtos.length; i++) {

                p = p.clone();

                var pro = $scope.pedido.produtos[i];
                icms += pro.icms * pro.quantidade;
                base += pro.base_calculo * pro.quantidade;
                p.find("[data-tipo='nome']").html(pro.produto.nome);
                p.find("[data-tipo='valor']").html((pro.valor_base + pro.frete + pro.juros + pro.icms).toFixed(2));
                p.find("[data-tipo='quantidade']").html(pro.quantidade);
                p.find("[data-tipo='validade']").html(toDate(pro.validade_minima));
                p.find("[data-tipo='total']").html(((pro.valor_base + pro.frete + pro.ipi + pro.juros + pro.icms) * pro.quantidade).toFixed(2));
                p.data("gerado", true);

                ic.find("#produtos").append(p);
                p.show();

                total += (pro.valor_base + pro.frete + pro.juros + pro.ipi + pro.icms) * pro.quantidade;

            }
            var alicota = (icms * 100 / base);

            ic.find("#prazo").html(pedido.prazo);
            ic.find("#alicota").html(alicota.toFixed(0));
            ic.find("#icms").html(icms.toFixed(2));

            ic.find("#tipoFrete").html(pedido.frete_incluso ? 'CIF' : 'FOB');
            ic.find("#nomeTransportadora").html(pedido.transportadora.razao_social);
            ic.find("#contato").html(pedido.transportadora.email.endereco);
            ic.find("#valorFrete").html(pedido.frete);

            ic.find("#observacoes").html(pedido.observacoes);
            ic.find("#nomeUsuario2").html(pedido.usuario.nome);

        })


    }

    $scope.deletePedido = function () {

        baseService.delete($scope.pedido, function (r) {
            if (r.sucesso) {
                msg.alerta("Operacao efetuada com sucesso");
                $scope.pedido = angular.copy($scope.novo_pedido);
                $scope.pedidos.attList();
            } else {
                msg.erro("Problema ao efetuar operacao");
            }
        });

    }


})

rtc.controller("crtListaPreco", function ($scope, listaPrecoProdutoService, listaPrecoPragaService, listaPrecoCulturaService) {

    $scope.produtos = createAssinc(listaPrecoProdutoService, 1, 3, 10);
    $scope.produtos.attList();
    assincFuncs(
            $scope.produtos,
            "produto",
            ["codigo", "nome", "estoque", "disponivel", "transito", "valor_base", "ativo", "classe_risco"]);

    $scope.culturas = createAssinc(listaPrecoCulturaService, 1, 3, 5);
    $scope.culturas.attList();
    assincFuncs(
            $scope.culturas,
            "cultura",
            ["id", "nome"], "filtroCultura");

    $scope.pragas = createAssinc(listaPrecoPragaService, 1, 3, 5);
    $scope.pragas.attList();
    assincFuncs(
            $scope.pragas,
            "praga",
            ["id", "nome"], "filtroPraga");

    $scope.produto = null;
    $scope.cultura = null;
    $scope.praga = null;

    $scope.setCultura = function (cultura) {

        $scope.cultura = cultura;
        listaPrecoPragaService.cultura = cultura;
        listaPrecoProdutoService.cultura = cultura;

        $scope.pragas.attList();
        $scope.culturas.attList();
        $scope.produtos.attList();

    }

    $scope.setPraga = function (praga) {

        $scope.praga = praga;
        listaPrecoCulturaService.praga = praga;
        listaPrecoProdutoService.praga = praga;

        $scope.pragas.attList();
        $scope.culturas.attList();
        $scope.produtos.attList();

    }

    $scope.setProduto = function (produto) {

        $scope.produto = produto;
        listaPrecoCulturaService.produto = produto;
        listaPrecoPragaService.produto = produto;


        $scope.produtos.attList();
        $scope.pragas.attList();
        $scope.culturas.attList();


    }

})
rtc.controller("crtCampanhas", function ($scope, campanhaService, baseService, produtoService, sistemaService) {

    $scope.campanhas = createAssinc(campanhaService, 1, 10, 10);
    $scope.campanhas.attList();
    assincFuncs(
            $scope.campanhas,
            "campanha",
            ["id", "nome", "inicio", "fim", "prazo", "parcelas"]);

    $scope.produtos = createAssinc(produtoService, 1, 3, 4);
    assincFuncs(
            $scope.produtos,
            "produto",
            ["codigo", "nome", "estoque", "disponivel"], "filtroProdutos");

    $scope.produtos2 = createAssinc(produtoService, 1, 3, 4);
    assincFuncs(
            $scope.produtos2,
            "produto",
            ["codigo", "nome", "estoque", "disponivel"], "filtroProdutos2");

    $scope.agora = new Date().getTime();
    $scope.campanha = {inicio: $scope.agora, fim: $scope.agora, id: 0};
    $scope.campanha_nova = {};

    $scope.criacao_campanhas = [];
    $scope.cc = null;



    $scope.produto_campanha_novo = {};

    $scope.teste = new Date().getTime();
    $scope.teste2 = new Date().getTime() + (10 * 24 * 60 * 60 * 1000);
    $scope.teste3 = function () {
        alert("teste4");
    }

    $scope.produto = {};
    $scope.produto_campanha_validade = {};

    $scope.meses_validade_curta = 3;

    var data = new Date();
    var dia = 1000 * 60 * 60 * 24;

    campanhaService.getProdutoCampanha(function (p) {

        $scope.produto_campanha_novo = p.produto_campanha;

    })

    $scope.quantidadeNumero = function (campanha, cc) {

        var qtd = 0;

        var numero = 0;
        for (var i = 0; i < campanha.campanhas.length; i++) {
            if (campanha.campanhas[i] === cc) {
                numero = campanha.campanhas[i].id;
                break;
            }
        }

        for (var i = 0; i < campanha.produtos.length; i++) {

            var p = campanha.produtos[i];

            if (p.numeracao === numero) {

                qtd++;

            }

        }

        return qtd;

    }

    $scope.setAutoValidade = function (v) {

        $scope.produto_campanha_validade.validade = v.validade;
        $scope.produto_campanha_validade.quantidade_validade = v.quantidade;
    }

    $scope.setProdutoValidade = function (produto_campanha) {

        $scope.produto = produto_campanha.produto;
        $scope.produto_campanha_validade = produto_campanha;

        $scope.getValidades($scope.produto);


    }

    $scope.selecionarValor = function (produto, v) {

        var k = !v.selecionado;

        for (var i = 0; i < produto.valores.length; i++) {
            produto.valores[i].selecionado = false;
        }
        produto.valor_editavel.selecionado = false;

        v.selecionado = k;

    }

    var okc = false;
    campanhaService.getCampanha(function (p) {

        $scope.campanha_nova = p.campanha;
        $scope.campanha = p.campanha;
        okc = true;
        $scope.setDataCampanha();


    })

    $scope.getNumeracaoAlfabetica = function (numero) {

        var c = "A B C D E F G H I J K L M N O P Q R S T U V W X Y Z";

        c = c.split(" ");
        var r = "";
        do {
            r = c[numero % c.length] + r;
            numero = (numero - (numero % c.length)) / c.length;
        } while (numero > 0)

        return r;
    }

    $scope.addNumeracao = function (prod) {

        prod.numeracao++;

        var c = prod.campanha.campanhas;
        var add = true;

        for (var i = 0; i < c.length; i++) {
            if (c[i].id === prod.numeracao) {
                add = false;
                break;
            }
        }
        if (add) {
            c = prod.campanha;

            c.campanhas[c.campanhas.length] = {
                inicio: c.inicio,
                fim: c.fim,
                nome: "Campanha " + $scope.getNumeracaoAlfabetica(prod.numeracao),
                id: prod.numeracao,
                prazo: 0,
                parcelas: 1
            };
        }
        var c = prod.campanha.campanhas;

        lbl:
                for (var i = 0; i < c.length; i++) {

            for (var j = 0; j < prod.campanha.produtos.length; j++) {

                if (prod.campanha.produtos[j].numeracao === c[i].id) {

                    continue lbl;

                }

            }

            c[i] = null;

            for (var a = i; a < c.length - 1; a++) {
                c[a] = c[a + 1];
            }
            c.length--;

        }

    }



    $scope.removeNumeracao = function (prod) {

        prod.numeracao--;

        prod.numeracao = Math.max(0, prod.numeracao);

        var c = prod.campanha.campanhas;
        var add = true;

        for (var i = 0; i < c.length; i++) {
            if (c[i].id === prod.numeracao) {
                add = false;
                break;
            }
        }
        if (add) {
            c = prod.campanha;

            c.campanhas[c.campanhas.length] = {
                inicio: c.inicio,
                fim: c.fim,
                nome: "Campanha " + $scope.getNumeracaoAlfabetica(prod.numeracao),
                id: prod.numeracao,
                prazo: 0,
                parcelas: 1
            };
        }
        var c = prod.campanha.campanhas;

        lbl:
                for (var i = 0; i < c.length; i++) {

            for (var j = 0; j < prod.campanha.produtos.length; j++) {

                if (prod.campanha.produtos[j].numeracao === c[i].id) {

                    continue lbl;

                }

            }

            c[i] = null;

            for (var a = i; a < c.length - 1; a++) {
                c[a] = c[a + 1];
            }
            c.length--;

        }

    }

    $scope.getNumeracaoCor = function (numero) {

        var c = ['DarkRed', 'DarkGreen', 'DarkGray', 'DarkBlue', 'Purple', 'DarkOrange', 'SteelBlue'];

        return c[numero % c.length];

    }

    var salvarCampanha = function (obj, campanha) {

        baseService.merge(campanha, function (r) {
            if (r.sucesso) {
                obj.atual++;
            } else {
                obj.erro++;
            }
            loading.setProgress(obj.atual * 100 / obj.total);
            if (obj.total == (obj.erro + obj.atual)) {
                msg.alerta("Campanhas cadastradas" + (obj.erro > 0 ? ". Porem contem erros" : " com sucesso"));

                $scope.campanhas.attList();
            }
        });

    }

    $scope.terminarCadastro = function () {

        var r = [];

        for (var i = 0; i < $scope.campanha.campanhas.length; i++) {

            var c = $scope.campanha.campanhas[i];

            var camp = angular.copy($scope.campanha_nova);
            camp.nome = c.nome;
            camp.prazo = c.prazo;
            camp.parcelas = c.parcelas;
            camp.inicio = c.inicio;
            camp.fim = c.fim;
            camp.produtos = [];

            for (var j = 0; j < $scope.campanha.produtos.length; j++) {

                var p = $scope.campanha.produtos[j];

                if (p.validade < 0) {

                    msg.alerta("O Produto " + p.produto.nome + ", esta sem validade selecionada");
                    return;

                }

                if (p.numeracao !== c.id) {

                    continue;

                }


                var prod = angular.copy($scope.produto_campanha_novo);
                prod.produto = p.produto;
                prod.campanha = camp;
                prod.limite = p.limite;
                prod.valor = -1;
                prod.validade = p.validade;

                for (var k = 0; k < p.valores.length; k++) {
                    if (p.valores[k].selecionado) {
                        prod.valor = p.valores[k].valor;
                        break;
                    }
                }

                if (p.valor_editavel.selecionado) {

                    prod.valor = p.valor_editavel.valor;

                }

                if (prod.valor <= 0) {
                    msg.alerta("O produto " + prod.produto.nome + ", esta sem valor selecionado");
                    return;

                }

                if (prod.valor > 0) {

                    camp.produtos[camp.produtos.length] = prod;

                }

            }

            if (camp.produtos.length > 0) {

                r[r.length] = camp;

            }

        }

        var obj = {total: r.length, atual: 0, erro: 0};

        for (var i = 0; i < r.length; i++) {
            salvarCampanha(obj, r[i]);
        }

        $scope.campanha.terminada = true;

    }

    $scope.millis = [];


    $scope.setDataCampanha = function () {

        if (!okc)
            return;
        $scope.setCampanhaCriacao($scope.agora);

    }

    $scope.removeProdutoCamp = function (campanha, produto) {

        if (campanha.produtos.length === 1) {
            msg.alerta("A Campanha nao pode ficar sem produtos");
            return;
        }

        var np = [];
        for (var i = 0; i < campanha.produtos.length; i++) {
            if (campanha.produtos[i] !== produto) {
                np[np.length] = campanha.produtos[i];
            }
        }
        campanha.produtos = np;

        $scope.addNumeracao(campanha.produtos[0]);
        $scope.removeNumeracao(campanha.produtos[0]);
        campanha.lista = createList(campanha.produtos, 1, 5, "produto.nome");
    }

    $scope.addProdutoCamp = function (campanha, produto) {

        var produto_campanha = angular.copy($scope.produto_campanha_novo);
        produto_campanha.produto = produto;
        produto_campanha.validade = -1;
        produto_campanha.campanha = campanha;
        produto_campanha.valores = [{valor: produto.valor_base, selecionado: false}];
        produto_campanha.valor_editavel = {valor: produto.valor_base, selecionado: false};
        produto_campanha.numeracao = -1;

        for (var j = 0; j < 3; j++) {
            produto_campanha.valores[j + 1] = {valor: (produto_campanha.valores[j].valor * 0.95).toFixed(2), selecionado: false};
        }

        campanha.produtos[campanha.produtos.length] = produto_campanha;

        $scope.addNumeracao(produto_campanha);

        campanha.lista.attList();

    }


    var inl = false;
    $scope.setCampanhaCriacao = function (millis) {

        if (inl)
            return;

        var campanha = null;
        inl = true;
        for (var i = 0; i < $scope.millis.length; i++) {
            if ($scope.millis[i] === millis) {
                campanha = $scope.criacao_campanhas[i];
                break;
            }
        }

        if (campanha === null) {
            var ms = new Date(parseFloat(millis + ""));
            var c = angular.copy($scope.campanha_nova);
            c.campanhas = [{
                    inicio: ms.getTime() + dia * i,
                    fim: ms.getTime() + (dia) * (i + 1),
                    nome: "Campanha A",
                    id: 0,
                    prazo: 0,
                    parcelas: 1
                }]
            c.inicio = ms.getTime() + dia * i;
            c.fim = ms.getTime() + (dia * (i + 1));
            c.nome = "Nova campanha";

            c.numero = i;
            while (new Date(parseFloat(c.fim + "")).getDay() == 0 || new Date(parseFloat(c.fim + "")).getDay() == 6) {
                c.fim += dia;
            }
            c.terminada = false;
            $scope.criacao_campanhas[$scope.criacao_campanhas.length] = c;
            $scope.millis[$scope.millis.length] = millis;
            campanha = c;
        }

        $scope.c = campanha;

        if (campanha.produtos.length === 0) {

            campanhaService.getProdutosDia(new Date(parseFloat(millis + "")).getDay(), function (prods) {

                for (var i = 0; i < prods.produtos.length; i++) {

                    var produto = prods.produtos[i];

                    var produto_campanha = angular.copy($scope.produto_campanha_novo);
                    produto_campanha.produto = produto;
                    produto_campanha.validade = -1;
                    produto_campanha.campanha = campanha;
                    produto_campanha.valores = [{valor: produto.valor_base, selecionado: false}];
                    produto_campanha.valor_editavel = {valor: produto.valor_base, selecionado: false};
                    produto_campanha.numeracao = 0;

                    for (var j = 0; j < 3; j++) {
                        produto_campanha.valores[j + 1] = {valor: (produto_campanha.valores[j].valor * 0.95).toFixed(2), selecionado: false};
                    }

                    campanha.produtos[campanha.produtos.length] = produto_campanha;

                }

                campanha.lista = createList(campanha.produtos, 1, 5, "produto.nome");

                inl = false;

            })

        } else {
            inl = false;
        }

        $scope.campanha = campanha;

    }

    sistemaService.getMesesValidadeCurta(function (p) {

        $scope.meses_validade_curta = p.meses_validade_curta;

    })

    $scope.setCampanha = function (campanha) {

        $scope.campanha = campanha;

    }

    $scope.mergeCampanha = function () {
        baseService.merge($scope.campanha, function (r) {
            if (r.sucesso) {
                $scope.campanha = r.o;
                if (r.sucesso) {
                    msg.alerta("Operacao efetuada com sucesso");
                    $scope.campanhas.attList();
                } else {
                    msg.erro("Fornecedor alterado, por?�m ocorreu um problema ao subir os documentos");
                }
            } else {
                msg.erro("Problema ao efetuar operacao. ");
            }
        });
    }

    $scope.getValidades = function (produto) {

        produtoService.getValidades($scope.meses_validade_curta, produto, function (validades) {

            produto.validades = validades;

        })

    }

    $scope.addProdutoCampanha = function (produto, validade) {

        var pc = angular.copy($scope.produto_campanha_novo);
        pc.produto = produto;
        pc.campanha = $scope.campanha;
        $scope.campanha.produtos[$scope.campanha.produtos.length] = pc;
        pc.valor = produto.valor_base;
        pc.validade = validade.validade;
        pc.limite = validade.quantidade;

        msg.alerta("Adicionado com sucesso");

    }

    $scope.deleteProdutoCampanha = function (campanha, produto) {

        remove(campanha.produtos, produto);

    }

    $scope.deleteCampanha = function () {
        baseService.delete($scope.campanha, function (r) {
            if (r.sucesso) {
                msg.alerta("Operacao efetuada com sucesso");
                $scope.campanhas.attList();
            } else {
                msg.erro("Problema ao efetuar operacao");
            }
        });
    }

})
rtc.controller("crtLotes", function ($scope, loteService, baseService) {


    $scope.lotes = createAssinc(loteService, 1, 10, 10);
    $scope.lotes.attList();
    assincFuncs(
            $scope.lotes,
            "lote",
            ["id", "produto.nome", "quantidade_real", "validade", "numero", "rua", "altura", "data_entrada", "codigo_fabricante"]);

    $scope.lote_novo = {};

    $scope.lote = {};

    $scope.lotes_cadastro = [];

    $scope.pendencias = [];
    $scope.todas_pendencias = [];

    loteService.getLote(function (l) {

        $scope.lote_novo = l.lote;

    })

    $scope.deletarLote = function () {
        baseService.delete($scope.lote, function (r) {
            if (r.sucesso) {
                msg.alerta("Deletado com sucesso");
                $scope.lotes.attList();
            } else {
                msg.erro("Problema ao deletar");
            }
        });
    }

    $scope.setLote = function (lote, elemento) {

        $scope.lote = lote;

        $scope.lote.validade_texto = toDate($scope.lote.validade);

        loteService.getItem(lote, function (i) {

            $scope.lote.item = i.item;

            if (elemento != null) {

                $scope.formarArvore(lote, elemento);

            }

        })

    }

    $scope.atualizaPendencias = function () {

        loteService.getPendenciasCadastro('', function (p) {

            for (var i = 0; i < p.pendencias.length; i++) {
                p.pendencias[i].divisao = parseInt(p.pendencias[i].grade.str.split(',')[0]) * 48;
            }

            $scope.todas_pendencias = angular.copy(p.pendencias);
            $scope.pendencias = createList(p.pendencias, 1, 10, "nome_produto");
            $scope.pendencias.attList();

        })

    }

    $scope.atualizaPendencias();

    var ml = function (obj, lote) {
        baseService.merge(lote, function (r) {
            if (r.sucesso) {
                obj.atual++;
                loading.setProgress(obj.atual * 100 / obj.total);
                if ((obj.atual + obj.erros) == obj.total) {
                    if (obj.erros == 0) {
                        msg.alerta("Lotes cadastrados com sucesso");
                    } else {
                        msg.alerta("Ocorreu problema no cadastro de alguns lotes");
                    }
                    $scope.lotes.attList();
                    $scope.atualizaPendencias();
                    $scope.lotes_cadastro = [];
                }
            } else {
                obj.erros++;
            }
        });
    }
    var kk = 0;
    var fa = function (els, lote) {
        var id = kk;
        kk++;
        if (els == null) {
            return $('<ul></ul>').html('ESGOTADO').css('border-color', 'DarkRed').css('color', 'DarkRed');
        }
        var n = "";
        for (var i = 0; i < els.numero.length; i++) {
            if (n != "")
                n += "-";
            n += els.numero[i];
        }
        n = "[" + n + "]";

        var e = $('<ul></ul>');

        e.data("item", els);
        e.data("lote", lote);

        e.attr('id', 'a' + id);


        if (els.filhos.length > 0) {

            e.append($('<i></i>').addClass('fas fa-plus-circle').attr('id', 'b' + id).click(function () {

                $(this).hide(100);
                $('#l' + id).show(100);
                $('#a' + id).children('li').show(100);

            })).append($('<i></i>').addClass('fas fa-minus-circle').attr('id', 'l' + id).click(function () {

                $(this).hide();
                $('#b' + id).show(100);
                $('#a' + id).children('li').hide(100);

            }).hide()).append($('<i></i>').addClass('fas fa-sitemap').click(function () {

                $scope.imprimirItens($(this).parent().data("item").filhos.filter(function (el) {
                    return el != null
                }), $(this).parent().data("lote"));

            }));

        }

        e.append($('<i></i>').addClass("fas fa-print").click(function () {

            $scope.imprimirItens([$(this).parent().data("item")], $(this).parent().data("lote"));

        }))

        e.append(n + " &nbsp Quantidade: <strong>" + els.quantidade + "</strong>")

        for (var i = 0; i < els.filhos.length; i++) {

            e.append($('<li></li>').hide().append(fa(els.filhos[i], lote)));

        }



        return e;
    }

    $scope.imprimirItens = function (itens, lote) {
        var etiquetas = [];
        for (var i = 0; i < itens.length; i++) {
            var cod = fix(lote.id + "", 7);
            for (var j = 1; j < itens[i].numero.length; j++) {
                cod += fix(itens[i].numero[j] + "", 4);
            }
            var etiqueta = {
                id: lote.id,
                id_produto: lote.produto.id,
                nome_produto: lote.produto.nome,
                validade: toDate(lote.validade),
                codigo: "*" + cod + "*",
                empresa: lote.produto.empresa.nome
            };
            etiquetas[etiquetas.length] = etiqueta;
        }

        var buffer = 20;
        var buff = [];

        for (var i = 0; i < etiquetas.length; i++) {
            var k = parseInt(i / buffer);
            if (i % buffer === 0) {
                buff[k] = [];
            }
            buff[k][buff[k].length] = etiquetas[i];
        }

        for (var i = 0; i < buff.length; i++) {
            loteService.getEtiquetas(buff[i], function (a) {
                if (a.sucesso) {

                    window.open(projeto + "/php/uploads/" + a.arquivo);
                } else {

                    msg.erro("Ocorreu um problema de servidor, tente mais tarde");
                }
            });
        }

    }


    $scope.formarArvore = function (lote, elemento) {

        var i = lote.item;

        $("#" + elemento).html('');

        $('#' + elemento).append('<strong>Legenda:</strong><br>').append($('<i></i>').addClass('fas fa-sitemap')).append(' Imprimir todos sub-itens, ').append($('<i></i>').addClass('fas fa-print')).append(' Imprimir item <hr>');

        $("#" + elemento).append(fa(i, lote));

    }
    $scope.mergeLotes = function () {
        var progresso = {atual: 0, total: $scope.lotes_cadastro.length, erros: 0};
        for (var i = 0; i < $scope.lotes_cadastro.length; i++) {

            var l = $scope.lotes_cadastro[i];

            l.validade = fromDate(l.validade_texto);

            if (l.validade < 0) {
                progresso.erros++;
                continue;
            }

            ml(progresso, l);

        }
    }

    $scope.mergeLote = function () {

        $scope.lote.validade = fromDate($scope.lote.validade_texto);

        if ($scope.lote.validade < 0) {

            msg.erro("Validade incorreta");
            return;

        }

        baseService.merge($scope.lote, function (r) {
            if (r.sucesso) {
                msg.alerta("Operacao efetuada com sucesso");
                $scope.lote = r.o;
                $scope.lotes.attList();
            } else {
                msg.erro("Problema ao efetuar operacao");
            }
        });
    }

    $scope.setPendencia = function (pendencia, palet) {

        if (palet <= 0) {

            msg.erro("A quantidade de palet deve ser maior do que 0");
            return;

        }

        if ((palet % pendencia.grade.gr[pendencia.grade.gr.length - 1]) != 0) {

            msg.erro("A quantidade de palet deve ser multipla de " + pendencia.grade.gr[pendencia.grade.gr.length - 1]);
            return;

        }

        var qtd = pendencia.quantidade;

        var produtoSimulado = {id: pendencia.id_produto, nome: pendencia.nome_produto};

        $scope.lotes_cadastro = [];

        while (qtd > 0) {

            var z = palet;

            qtd -= z;

            if (qtd < 0)
                z += qtd;

            var lote = angular.copy($scope.lote_novo);

            lote.grade = pendencia.grade;
            lote.quantidade_inicial = z;
            lote.quantidade_real = z;
            lote.produto = produtoSimulado;
            lote.validade_texto = toDate(lote.validade);

            $scope.lotes_cadastro[$scope.lotes_cadastro.length] = lote;

        }

    }


})
rtc.controller("crtFornecedores", function ($scope, fornecedorService, categoriaDocumentoService, documentoService, cidadeService, baseService, telefoneService, uploadService) {

    $scope.fornecedores = createAssinc(fornecedorService, 1, 3, 10);
    $scope.fornecedores.attList();
    assincFuncs(
            $scope.fornecedores,
            "fornecedor",
            ["codigo", "nome", "email_fornecedor.endereco", "cnpj", "inscricao_estadual", "habilitado"]);

    $scope.fornecedor_novo = {};
    $scope.fornecedor = {};
    $scope.estado = {};

    $scope.email = {};

    $scope.data_atual = new Date().getTime();


    $scope.documento_novo = {};
    $scope.documento = {};

    $scope.telefone_novo = {};
    $scope.telefone = {};

    $scope.categorias_documento = [];
    $scope.estados = [];
    $scope.cidades = [];

    $("#uploaderDocumentoFornecedor").change(function () {

        uploadService.upload($(this).prop("files"), function (arquivos, sucesso) {

            if (!sucesso) {

                msg.erro("Falha ao subir arquivo");

            } else {

                var doc = angular.copy($scope.documento);

                for (var i = 0; i < arquivos.length; i++) {

                    var d = angular.copy(doc);
                    $scope.documento = d;
                    d.link = arquivos[i];

                    $scope.addDocumento();

                }

                msg.alerta("Upload feito com sucesso");
            }

        })

    })

    fornecedorService.getFornecedor(function (p) {
        $scope.fornecedor_novo = p.fornecedor;
        $scope.fornecedor_novo["documentos"] = [];
    })
    categoriaDocumentoService.getElementos(function (p) {
        $scope.categorias_documento = p.elementos;
        $scope.documento.categoria = $scope.categorias_documento[0];
    })
    documentoService.getDocumento(function (p) {
        $scope.documento_novo = p.documento;
        $scope.documento = angular.copy($scope.documento_novo);
        $scope.documento.categoria = $scope.categorias_documento[0];
    })
    telefoneService.getTelefone(function (p) {
        $scope.telefone_novo = p.telefone;
        $scope.telefone = angular.copy($scope.telefone_novo);
    })

    cidadeService.getElementos(function (p) {
        var estados = [];
        var cidades = p.elementos;
        $scope.cidades = cidades;

        lbl:
                for (var i = 0; i < cidades.length; i++) {
            var c = cidades[i];
            for (var j = 0; j < estados.length; j++) {
                if (estados[j].id === c.estado.id) {
                    estados[j].cidades[estados[j].cidades.length] = c;
                    c.estado = estados[j];
                    continue lbl;
                }
            }
            c.estado["cidades"] = [c];
            estados[estados.length] = c.estado;
        }

        $scope.estados = estados;
    })

    $scope.novoFornecedor = function () {

        $scope.fornecedor = angular.copy($scope.fornecedor_novo);

    }

    $scope.setFornecedor = function (fornecedor) {

        $scope.fornecedor = fornecedor;

        fornecedorService.getDocumentos($scope.fornecedor, function (d) {
            $scope.fornecedor["documentos"] = d.documentos;
            for (var i = 0; i < d.documentos.length; i++) {
                equalize(d.documentos[i], "categoria", $scope.categorias_documento);
            }
        })

        equalize(fornecedor.endereco, "cidade", $scope.cidades);

        if (typeof fornecedor.endereco.cidade !== 'undefined') {
            $scope.estado = fornecedor.endereco.cidade.estado;
        } else {
            fornecedor.endereco.cidade = $scope.cidades[0];
            $scope.estado = fornecedor.endereco.cidade.estado;
        }

    }

    $scope.mergeFornecedor = function () {

        if ($scope.fornecedor.endereco.cidade == null) {
            msg.erro("Fornecedor sem cidade.");
            return;
        }

        baseService.merge($scope.fornecedor, function (r) {
            if (r.sucesso) {
                $scope.fornecedor = r.o;
                fornecedorService.setDocumentos($scope.fornecedor, $scope.fornecedor.documentos, function (rr) {

                    if (rr.sucesso) {

                        msg.alerta("Operacao efetuada com sucesso");
                        $scope.setFornecedor($scope.fornecedor);
                        $scope.fornecedores.attList();

                    } else {
                        msg.erro("Fornecedor alterado, por?�m ocorreu um problema ao subir os documentos");

                    }

                })


            } else {
                msg.erro("Problema ao efetuar operacao. ");
            }
        });

    }
    $scope.deleteFornecedor = function () {
        baseService.delete($scope.fornecedor, function (r) {
            if (r.sucesso) {
                msg.alerta("Operacao efetuada com sucesso");
                $scope.fornecedores.attList();
            } else {
                msg.erro("Problema ao efetuar operacao");
            }
        });
    }

    $scope.removeDocumento = function (documento) {
        remove($scope.fornecedor.documentos, documento);
    }

    $scope.addDocumento = function () {

        $scope.fornecedor.documentos[$scope.fornecedor.documentos.length] = $scope.documento;
        $scope.documento = angular.copy($scope.documento_novo);
        $scope.documento.categoria = $scope.categorias_documento[0];

    }
    $scope.removeTelefone = function (tel) {

        remove($scope.fornecedor.telefones, tel);

    }
    $scope.addTelefone = function () {
        $scope.fornecedor.telefones[$scope.fornecedor.telefones.length] = $scope.telefone;
        $scope.telefone = angular.copy($scope.telefone_novo);
    }

})
rtc.controller("crtTransportadoras", function ($scope, clienteService, transportadoraService, regraTabelaService, tabelaService, categoriaDocumentoService, documentoService, cidadeService, baseService, telefoneService, uploadService) {

    $scope.transportadoras = createAssinc(transportadoraService, 1, 3, 10);
    $scope.transportadoras.attList();
    assincFuncs(
            $scope.transportadoras,
            "transportadora",
            ["codigo", "razao_social", "nome_fantasia", "despacho", "cnpj", "inscricao_estadual", "habilitada"]);

    $scope.clientes = createAssinc(clienteService, 1, 3, 4);
    $scope.clientes.attList();
    assincFuncs(
            $scope.clientes,
            "cliente",
            ["codigo", "razao_social"], "filtroClientes");

    $scope.transportadora_novo = {};
    $scope.transportadora = {};
    $scope.estado = {};
    $scope.cliente = {};
    $scope.email = {};

    $scope.tabela_nova = {};
    $scope.tabela = {};

    $scope.documento_novo = {};
    $scope.documento = {};

    $scope.tabela_selecionada = {};
    $scope.transportadora_tabela = {};

    $scope.resultado_individual = {};

    $scope.telefone_novo = {};
    $scope.telefone = {};

    $scope.regra_nova = {};
    $scope.regra = {};

    $scope.estado_teste = null;
    $scope.cidade_teste = null;
    $scope.valor_teste = 0;
    $scope.peso_teste = 0;

    $scope.categorias_documento = [];
    $scope.estados = [];
    $scope.cidades = [];

    $scope.fretes = [];

    $("#uploaderDocumentoTransportadora").change(function () {

        uploadService.upload($(this).prop("files"), function (arquivos, sucesso) {

            if (!sucesso) {

                msg.erro("Falha ao subir arquivo");

            } else {

                var doc = angular.copy($scope.documento);

                for (var i = 0; i < arquivos.length; i++) {

                    var d = angular.copy(doc);
                    $scope.documento = d;
                    d.link = arquivos[i];

                    $scope.addDocumento();

                }

                msg.alerta("Upload feito com sucesso");
            }

        })

    })

    transportadoraService.getTransportadora(function (p) {
        $scope.transportadora_novo = p.transportadora;
        $scope.transportadora_novo["documentos"] = [];
    })
    categoriaDocumentoService.getElementos(function (p) {
        $scope.categorias_documento = p.elementos;
        $scope.documento.categoria = $scope.categorias_documento[0];
    })
    documentoService.getDocumento(function (p) {
        $scope.documento_novo = p.documento;
        $scope.documento = angular.copy($scope.documento_novo);
        $scope.documento.categoria = $scope.categorias_documento[0];
    })
    telefoneService.getTelefone(function (p) {
        $scope.telefone_novo = p.telefone;
        $scope.telefone = angular.copy($scope.telefone_novo);
    })
    tabelaService.getTabela(function (p) {
        $scope.tabela_nova = p.tabela;
        $scope.tabela = angular.copy($scope.tabela_nova);
    })
    regraTabelaService.getRegraTabela(function (p) {
        $scope.regra_nova = p.regra_tabela;
        $scope.regra = angular.copy($scope.regra_nova);
    })

    $scope.addRegra = function () {

        $scope.tabela_selecionada.regras[$scope.tabela_selecionada.regras.length] = angular.copy($scope.regra_nova);

    }

    $scope.setCliente = function (cliente) {

        lbl:
                for (var i = 0; i < $scope.estados.length; i++) {
            if ($scope.estados[i].id === cliente.endereco.cidade.estado.id) {
                var e = $scope.estados[i];
                $scope.estado_teste = $scope.estados[i];
                for (var j = 0; j < e.cidades.length; j++) {
                    if (e.cidades[j].id === cliente.endereco.cidade.id) {
                        $scope.cidade_teste = e.cidades[j];
                        break lbl;
                    }
                }
            }
        }

        $scope.cliente = cliente;

    }

    $scope.attResultadoIndividual = function () {

        tabelaService.getValorTabela($scope.tabela_selecionada, {cidade: $scope.cidade_teste, valor: $scope.valor_teste, peso: $scope.peso_teste}, function (f) {

            $scope.resultado_individual = f.valor;

        })

    }

    $scope.attResultado = function () {

        tabelaService.getFretes(null, {cidade: $scope.cidade_teste, valor: $scope.valor_teste, peso: $scope.peso_teste}, function (f) {

            $scope.fretes = f.fretes;

        })

    }

    $scope.copiarRegra = function (regra) {

        var c = angular.copy(regra);
        c.id = 0;
        c.copia = regra.id;
        if (regra.copia > 0) {
            c.copia = regra.copia;
        }
        $scope.tabela_selecionada.regras[$scope.tabela_selecionada.regras.length] = c;

    }

    $scope.removerRegra = function (regra) {

        remove($scope.tabela_selecionada.regras, regra);

    }

    $scope.selecionarTabela = function (transp) {

        $scope.tabela_selecionada = transp.tabela;
        $scope.transportadora_tabela = transp;

    }

    cidadeService.getElementos(function (p) {
        var estados = [];
        var cidades = p.elementos;
        $scope.cidades = cidades;

        lbl:
                for (var i = 0; i < cidades.length; i++) {
            var c = cidades[i];
            for (var j = 0; j < estados.length; j++) {
                if (estados[j].id === c.estado.id) {
                    estados[j].cidades[estados[j].cidades.length] = c;
                    c.estado = estados[j];
                    continue lbl;
                }
            }
            c.estado["cidades"] = [c];
            estados[estados.length] = c.estado;
        }
        $scope.estado_teste = estados[0];
        $scope.cidade_teste = $scope.estado_teste.cidades[0];
        $scope.estados = estados;
    })

    $scope.selecionarRegra = function (regra) {

        $scope.regra = regra;

    }

    $scope.novoTransportadora = function () {

        $scope.transportadora = angular.copy($scope.transportadora_novo);

    }

    $scope.criarTabela = function (transp) {

        transp.tabela = $scope.tabela;
        $scope.tabela = angular.copy($scope.tabela_nova);

    }

    $scope.setTransportadora = function (transportadora) {

        $scope.transportadora = transportadora;

        transportadoraService.getDocumentos($scope.transportadora, function (d) {
            $scope.transportadora["documentos"] = d.documentos;
            for (var i = 0; i < d.documentos.length; i++) {
                equalize(d.documentos[i], "categoria", $scope.categorias_documento);
            }
        })

        equalize(transportadora.endereco, "cidade", $scope.cidades);
        if (typeof transportadora.endereco.cidade !== 'undefined') {
            $scope.estado = transportadora.endereco.cidade.estado;
        } else {
            transportadora.endereco.cidade = $scope.cidades[0];
            $scope.estado = transportadora.endereco.cidade.estado;
        }

    }

    $scope.mergeTransportadoraTabela = function () {

        if ($scope.transportadora_tabela.endereco.cidade == null) {
            msg.erro("Transportadora sem cidade.");
            return;
        }

        baseService.merge($scope.transportadora_tabela, function (r) {
            if (r.sucesso) {
                $scope.transportadora_tabela = r.o;
                $scope.tabela_selecionada = r.o.tabela;
                if (r.sucesso) {
                    msg.alerta("Operacao efetuada com sucesso");
                } else {
                    msg.erro("Transportadora alterada, por?�m ocorreu um problema ao subir os documentos");

                }
            } else {
                msg.erro("Problema ao efetuar operacao. ");
            }
        });

    }

    $scope.mergeTransportadora = function () {

        if ($scope.transportadora.endereco.cidade == null) {
            msg.erro("Transportadora sem cidade.");
            return;
        }

        baseService.merge($scope.transportadora, function (r) {

            if (r.sucesso) {
                $scope.transportadora = r.o;
                transportadoraService.setDocumentos($scope.transportadora, $scope.transportadora.documentos, function (rr) {

                    if (rr.sucesso) {

                        msg.alerta("Operacao efetuada com sucesso");
                        $scope.setTransportadora($scope.transportadora);
                        $scope.transportadoras.attList();

                    } else {
                        msg.erro("Transportadora alterada, por?�m ocorreu um problema ao subir os documentos");

                    }

                })


            } else {

                msg.erro("Problema ao efetuar operacao. ");
            }
        });

    }
    $scope.deleteTransportadora = function () {
        baseService.delete($scope.transportadora, function (r) {
            if (r.sucesso) {
                msg.alerta("Operacao efetuada com sucesso");
                $scope.transportadoras.attList();
            } else {
                msg.erro("Problema ao efetuar operacao");
            }
        });
    }

    $scope.removeDocumento = function (documento) {
        remove($scope.transportadora.documentos, documento);
    }

    $scope.addDocumento = function () {

        $scope.transportadora.documentos[$scope.transportadora.documentos.length] = $scope.documento;
        $scope.documento = angular.copy($scope.documento_novo);
        $scope.documento.categoria = $scope.categorias_documento[0];

    }
    $scope.removeTelefone = function (tel) {

        remove($scope.transportadora.telefones, tel);

    }
    $scope.addTelefone = function () {
        $scope.transportadora.telefones[$scope.transportadora.telefones.length] = $scope.telefone;
        $scope.telefone = angular.copy($scope.telefone_novo);
    }

})
rtc.controller("crtClientes", function ($scope, clienteService, sistemaService, empresaService, categoriaClienteService, categoriaDocumentoService, documentoService, cidadeService, baseService, telefoneService, uploadService) {

    $scope.clientes = createAssinc(clienteService, 1, 20, 10);
    $scope.clientes.attList();
    assincFuncs(
            $scope.clientes,
            "cliente",
            ["codigo", "razao_social", "nome_fantasia", "inscricao_estadual", "cnpj", "cpf", "limite_credito", "termino_limite", "empresa.nome"]);

    $scope.cliente_novo = {};
    $scope.cliente = {};
    $scope.estado = {};

    $scope.email = {};

    $scope.data_atual = new Date().getTime();


    $scope.documento_novo = {};
    $scope.documento = {};

    $scope.telefone_novo = {};
    $scope.telefone = {};

    $scope.categorias_cliente = [];
    $scope.categorias_documento = [];
    $scope.estados = [];
    $scope.cidades = [];


    $scope.empresas_clientes = [];

    empresaService.getEmpresasClientes(function (e) {

        $scope.empresas_clientes = e.clientes;

    })

    $("#uploaderDocumentoCliente").change(function () {

        uploadService.upload($(this).prop("files"), function (arquivos, sucesso) {

            if (!sucesso) {

                msg.erro("Falha ao subir arquivo");

            } else {

                var doc = angular.copy($scope.documento);

                for (var i = 0; i < arquivos.length; i++) {

                    var d = angular.copy(doc);
                    $scope.documento = d;
                    d.link = arquivos[i];

                    $scope.addDocumento();

                }

                msg.alerta("Upload feito com sucesso");
            }

        })

    })

    clienteService.getCliente(function (p) {
        $scope.cliente_novo = p.cliente;
        $scope.cliente_novo["documentos"] = [];
    })
    categoriaClienteService.getElementos(function (p) {
        $scope.categorias_cliente = p.elementos;
    })
    categoriaDocumentoService.getElementos(function (p) {
        $scope.categorias_documento = p.elementos;
        $scope.documento.categoria = $scope.categorias_documento[0];
    })
    documentoService.getDocumento(function (p) {
        $scope.documento_novo = p.documento;
        $scope.documento = angular.copy($scope.documento_novo);
        $scope.documento.categoria = $scope.categorias_documento[0];
    })
    telefoneService.getTelefone(function (p) {

        $scope.telefone_novo = p.telefone;
        $scope.telefone = angular.copy($scope.telefone_novo);
    })

    cidadeService.getElementos(function (p) {
        var estados = [];
        var cidades = p.elementos;
        $scope.cidades = cidades;

        lbl:
                for (var i = 0; i < cidades.length; i++) {
            var c = cidades[i];
            for (var j = 0; j < estados.length; j++) {
                if (estados[j].id === c.estado.id) {
                    estados[j].cidades[estados[j].cidades.length] = c;
                    c.estado = estados[j];
                    continue lbl;
                }
            }
            c.estado["cidades"] = [c];
            estados[estados.length] = c.estado;
        }

        $scope.estados = estados;
    })

    $scope.novoCliente = function () {

        $scope.cliente = angular.copy($scope.cliente_novo);
        equalize($scope.cliente, "empresa", $scope.empresas_clientes);

    }

    $scope.setCliente = function (cliente) {

        $scope.cliente = cliente;

        equalize($scope.cliente, "categoria", $scope.categorias_cliente);
        equalize($scope.cliente, "empresa", $scope.empresas_clientes);

        clienteService.getDocumentos($scope.cliente, function (d) {
            $scope.cliente["documentos"] = d.documentos;
            for (var i = 0; i < d.documentos.length; i++) {
                equalize(d.documentos[i], "categoria", $scope.categorias_documento);
            }
        })

        equalize(cliente.endereco, "cidade", $scope.cidades);
        if (typeof cliente.endereco.cidade !== 'undefined') {
            $scope.estado = cliente.endereco.cidade.estado;
        } else {
            cliente.endereco.cidade = $scope.cidades[0];
            $scope.estado = cliente.endereco.cidade.estado;
        }

    }

    $scope.mergeCliente = function () {

        if ($scope.cliente.categoria == null) {
            msg.erro("Cliente sem categoria.");
            return;
        }

        if ($scope.cliente.endereco.cidade == null) {
            msg.erro("Cliente sem cidade.");
            return;
        }

        var alterar = $scope.cliente.id > 0;

        baseService.merge($scope.cliente, function (r) {
            if (r.sucesso) {
                $scope.cliente = r.o;
                clienteService.setDocumentos($scope.cliente, $scope.cliente.documentos, function (rr) {

                    if (rr.sucesso) {

                        msg.alerta("Operacao efetuada com sucesso");

                        if (alterar) {

                            sistemaService.aoAlterarCliente($scope.cliente, function (c) {});

                        } else {

                            sistemaService.aoCadastrarCliente($scope.cliente, function (c) {});

                        }

                        $scope.setCliente($scope.cliente);
                        $scope.clientes.attList();


                    } else {
                        msg.erro("Cliente alterado, porem ocorreu um problema ao subir os documentos");

                    }

                })


            } else {
                msg.erro("Problema ao efetuar operacao. ");
            }
        });

    }
    $scope.deleteCliente = function () {
        baseService.delete($scope.cliente, function (r) {
            if (r.sucesso) {
                msg.alerta("Operacao efetuada com sucesso");
                $scope.clientes.attList();
            } else {
                msg.erro("Problema ao efetuar operacao");
            }
        });
    }

    $scope.removeDocumento = function (documento) {
        remove($scope.cliente.documentos, documento);
    }

    $scope.addDocumento = function () {

        $scope.cliente.documentos[$scope.cliente.documentos.length] = $scope.documento;
        $scope.documento = angular.copy($scope.documento_novo);
        $scope.documento.categoria = $scope.categorias_documento[0];

    }
    $scope.removeTelefone = function (tel) {

        remove($scope.cliente.telefones, tel);

    }
    $scope.addTelefone = function () {

        $scope.cliente.telefones[$scope.cliente.telefones.length] = $scope.telefone;
        $scope.telefone = angular.copy($scope.telefone_novo);
    }

})
rtc.controller("crtProdutos", function ($scope,fabricanteService,ativoService, culturaService, sistemaService, uploadService, pragaService, produtoService, baseService, categoriaProdutoService, receituarioService) {

    $scope.produtos = createAssinc(produtoService, 1, 3, 10);
    $scope.produtos.attList();
    assincFuncs(
            $scope.produtos,
            "produto",
            ["codigo", "nome", "estoque", "disponivel", "transito", "valor_base", "ativo", "classe_risco"],
            null,false);

    $scope.produto = {};
    $scope.produto_novo = {};

    $scope.receituario_novo = {};
    $scope.receituario = {};
    
    
    $scope.ativos = [];

    $scope.categorias = [];

    $scope.culturas = [];

    $scope.pragas = [];

    $scope.logisticas = [];
    
    $scope.fabricantes = [];
    
    sistemaService.getLogisticas(function (rr) {
        
        $scope.logisticas = rr.logisticas;

    })
    
    ativoService.getAtivos(function(a){
        
        $scope.ativos = a.ativos;
        
    })
    
    fabricanteService.getFabricantes(function(f){
        
        $scope.fabricantes = f.fabricantes;
        
    })

    $("#uploaderImagemProduto").change(function () {

        uploadService.upload($(this).prop("files"), function (arquivos, sucesso) {

            if (!sucesso) {

                msg.erro("Falha ao subir arquivo de imagem");

            } else {

                $scope.produto.imagem = arquivos[0];

                msg.alerta("Upload feito com sucesso");
            }

        })

    })

    $scope.deletarProduto = function () {

        baseService.delete($scope.produto, function (r) {

            if (r.sucesso) {

                msg.alerta("Deletado com sucesso");
                $scope.produtos.attList();

            } else {

                msg.erro("Problema ao deletar");

            }



        });

    }

    $scope.mergeProduto = function () {

        var validaGrade = $scope.produto.grade.str.split(",");
        var ant = -1;
        for (var i = 0; i < validaGrade.length; i++) {
            if (!isNormalInteger(validaGrade[i]) || parseInt(validaGrade[i]) == 0) {
                msg.erro("Grade incorreta");
                return;
            }

            if (parseInt(validaGrade[i]) > ant && ant >= 0) {
                msg.erro("Grade incorreta, sub unidade maior que unidade");
                return;
            }

            ant = parseInt(validaGrade[i]);
        }

        baseService.merge($scope.produto, function (r) {

            if (r.sucesso) {

                msg.alerta("Operacao efetuada com sucesso");
                $scope.produto = r.o;
                $scope.receituario.produto = $scope.produto;
                $scope.getReceituario($scope.produto);
                equalize($scope.produto, "categoria", $scope.categorias);
                $scope.produtos.attList();

                if ($scope.produto.logistica !== null) {
                    equalize($scope.produto, "logistica", $scope.logisticas);
                }

            } else {

                msg.erro("Problema ao efetuar operacao");

            }



        });

    }
   
    $scope.deleteReceituario = function (rec, produto) {

        baseService.delete(rec, function (r) {

            if (r.sucesso) {

                msg.alerta("Deletado com sucesso");
                $scope.getReceituario(produto);

            } else {

                msg.erro("Problema ao deletar");

            }



        })

    }

    $scope.mergeReceituario = function () {

        if ($scope.produto.id == 0) {

            msg.erro("Efetue o cadastro do produto primeiro");

            return;

        }

        if ($scope.receituario.cultura === null) {


            msg.erro("Selecione uma cultura");

            return;

        }

        if ($scope.receituario.praga === null) {


            msg.erro("Selecione uma praga");

            return;

        }

        baseService.merge($scope.receituario, function (r) {


            if (r.sucesso) {

                $scope.receituario = angular.copy($scope.receituario_novo);
                $scope.receituario.produto = $scope.produto;
                $scope.getReceituario($scope.produto);
                msg.alerta("Operacoes efetuada com sucesso");


            } else {

                msg.erro("Problema ao efetuar operacao");

            }



        });

    }

    $scope.getReceituario = function (p) {

        produtoService.getReceituario(p, function (r) {

            p.receituario = r.receituario;

        });

    }

    $scope.novoProduto = function () {

        $scope.produto = angular.copy($scope.produto_novo);
    }


    $scope.setProduto = function (produto) {
        $scope.produto = produto;
        $scope.receituario.produto = $scope.produto;
        equalize($scope.produto, "categoria", $scope.categorias);
        if ($scope.produto.logistica !== null) {
            equalize($scope.produto, "logistica", $scope.logisticas);
        }
    }

    produtoService.getProduto(function (p) {
        $scope.produto_novo = p.produto;
        $scope.receituario.produto = $scope.produto;
    })

    receituarioService.getReceituario(function (p) {
        $scope.receituario_novo = p.receituario;
        $scope.receituario = angular.copy(p.receituario);
        $scope.receituario.produto = $scope.produto;
    })

    categoriaProdutoService.getElementos(function (f) {
        $scope.categorias = f.elementos
    })

    culturaService.getElementos(function (f) {

        $scope.culturas = f.culturas;

    })

    pragaService.getElementos(function (f) {

        $scope.pragas = f.pragas;

    })

})
rtc.controller("crtLogin", function ($scope, loginService, sistemaService) {
    $scope.usuario = "";
    $scope.senha = "";
    $scope.email = "";

    $scope.email_cliente = "";
    $scope.cliente = null;

    $scope.cadastrar = function () {

        if ($scope.cliente.senha === $scope.cliente.confirmacao_senha) {

            sistemaService.inserirClienteRTC($scope.cliente, function (s) {

                if (s.sucesso) {
                    $scope.cliente = null;
                    $scope.email_cliente = "";
                    msg.alerta("Cadastrado com sucesso, feche a tela e efetue o Login");
                } else {
                    msg.alerta("Erro: " + s.mensagem);
                }

            });

        } else {

            msg.erro("A confirmacao de senha difere da senha");

        }


    }

    $scope.buscar = function () {

        sistemaService.getClienteCadastro($scope.email_cliente, function (f) {

            if (f.clientes.length > 0) {
                $scope.cliente = f.clientes[0];
                msg.alerta("Escolha o login e senha");
            } else {
                $scope.cliente = null;
                msg.erro("Email nao cadastrado");
            }

        });

    }

    $scope.logar = function () {

        loginService.login($scope.usuario, $scope.senha, function (r) {


            if (r.usuario === null || !r.sucesso) {
                msg.erro("Esse usuario nao existe");
            } else {

                window.location = "comprar.php";
            }
        });
    };

    $scope.recuperar = function () {

        loginService.recuperar($scope.email, function (r) {
            if (r.sucesso) {

                msg.alerta("Senha enviada para o email");

            } else {

                msg.erro("Falha ao recuperar, provavelmente esse email nao esta cadastrado");

            }

        });

    }

})
rtc.controller("crtLogo", function ($scope, empresaService, uploadService) {

    $("#pic").change(function () {

        var ext = ['png', 'jpg'];
        var pre_arquivos = $(this).prop("files");
        var arquivos = [];
        var e = [];

        var total_size = 0;

        for (var i = 0; i < pre_arquivos.length; i++) {
            for (var j = 0; j < ext.length; j++) {
                if (ext[j] === pre_arquivos[i].name.split('.')[pre_arquivos[i].name.split('.').length - 1]) {
                    arquivos[arquivos.length] = pre_arquivos[i];
                    e[e.length] = pre_arquivos[i].name.split('.')[pre_arquivos[i].name.split('.').length - 1];
                    total_size += pre_arquivos[i].size;
                    break;
                }
            }
        }

        if (arquivos.length === 0) {
            msg.alerta("A Imagem deve ser do tipo PNG");
            return;
        }


        uploadService.upload(arquivos, function (arquivos, sucesso) {



            if (!sucesso) {

                msg.erro("Falha ao subir arquivo");

            } else {

                empresaService.setLogo(arquivos[0], function (t) {

                    if (t.sucesso) {

                        msg.alerta("Upload feito com sucesso");
                        location.reload();

                    } else {

                        msg.erro("Falha ao trocar logo");

                    }


                })


            }

        })

    })

})
