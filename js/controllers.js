rtc.controller("crtTransportadoras", function ($scope, transportadoraService, regraTabelaService, tabelaService, categoriaDocumentoService, documentoService, cidadeService, baseService, telefoneService, uploadService) {

    $scope.transportadoras = createAssinc(transportadoraService, 1, 3, 10);
    $scope.transportadoras.attList();
    assincFuncs(
            $scope.transportadoras,
            "transportadora",
            ["id", "razao_social", "nome_fantasia", "despacho", "cnpj", "inscricao_estadual", "habilitada"]);

    $scope.transportadora_novo = {};
    $scope.transportadora = {};
    $scope.estado = {};

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
                    msg.erro("Transportadora alterada, porém ocorreu um problema ao subir os documentos");

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
                        msg.erro("Transportadora alterada, porém ocorreu um problema ao subir os documentos");

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

rtc.controller("crtClientes", function ($scope, clienteService, categoriaClienteService, categoriaDocumentoService, documentoService, cidadeService, baseService, telefoneService, uploadService) {

    $scope.clientes = createAssinc(clienteService, 1, 3, 10);
    $scope.clientes.attList();
    assincFuncs(
            $scope.clientes,
            "cliente",
            ["id", "razao_social", "nome_fantasia", "inscricao_estadual", "limite_credito", "inicio_limite", "termino_limite"]);

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

    }

    $scope.setCliente = function (cliente) {

        $scope.cliente = cliente;

        equalize($scope.cliente, "categoria", $scope.categorias_cliente);

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

        baseService.merge($scope.cliente, function (r) {
            if (r.sucesso) {
                $scope.cliente = r.o;
                clienteService.setDocumentos($scope.cliente, $scope.cliente.documentos, function (rr) {

                    if (rr.sucesso) {

                        msg.alerta("Operacao efetuada com sucesso");
                        $scope.setCliente($scope.cliente);
                        $scope.clientes.attList();

                    } else {
                        msg.erro("Cliente alterado, porém ocorreu um problema ao subir os documentos");

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

rtc.controller("crtProdutos", function ($scope, culturaService, uploadService, pragaService, produtoService, baseService, categoriaProdutoService, receituarioService) {

    $scope.produtos = createAssinc(produtoService, 1, 3, 10);
    $scope.produtos.attList();
    assincFuncs(
            $scope.produtos,
            "produto",
            ["id", "nome", "estoque", "disponivel", "transito", "valor_base", "ativo", "classe_risco"]);

    $scope.produto = {};
    $scope.produto_novo = {};

    $scope.receituario_novo = {};
    $scope.receituario = {};

    $scope.categorias = [];

    $scope.culturas = [];

    $scope.pragas = [];

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

rtc.controller("crtLogin", function ($scope, loginService) {
    $scope.usuario = "";
    $scope.senha = "";
    $scope.email = "";
    $scope.logar = function () {
        loginService.login($scope.usuario, $scope.senha, function (r) {
            if (r.usuario == null || !r.sucesso) {
                msg.erro("Esse usuário não existe");
            } else {
                window.location = "index_em_branco.php";
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