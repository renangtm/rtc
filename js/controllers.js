rtc.controller("crtPedidos", function ($scope, $window, pedidoService, tabelaService, baseService, produtoService, sistemaService, statusPedidoSaidaService, formaPagamentoService, transportadoraService, clienteService, produtoPedidoService) {

    $scope.pedidos = createAssinc(pedidoService, 1, 10, 10);
    $scope.pedidos.attList();
    assincFuncs(
            $scope.pedidos,
            "pedido",
            ["id", "cliente.razao_social", "data", "frete", "id_status", "usuario.nome"]);

    $scope.produtos = createAssinc(produtoService, 1, 3, 4);
    $scope.produtos.attList();
    assincFuncs(
            $scope.produtos,
            "produto",
            ["id", "nome", "disponivel"], "filtroProdutos");

    $scope.transportadoras = createAssinc(transportadoraService, 1, 3, 4);
    $scope.transportadoras.attList();
    assincFuncs(
            $scope.transportadoras,
            "transportadora",
            ["id", "razao_social"], "filtroTransportadoras");

    $scope.clientes = createAssinc(clienteService, 1, 3, 4);
    $scope.clientes.attList();
    assincFuncs(
            $scope.clientes,
            "cliente",
            ["id", "razao_social"], "filtroClientes");


    $scope.meses_validade_curta = 3;

    $scope.status_pedido = [];

    $scope.status_excluido = {};

    $scope.pedido_novo = {};

    $scope.produto_pedido_novo = {};

    $scope.pedido = {};

    $scope.fretes = [];

    $scope.qtd = 0;

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

            tot += (p.valor_base + p.icms + p.juros + p.frete) * p.quantidade;

        }

        return tot;

    }

    $scope.formas_pagamento = {};



    statusPedidoSaidaService.getStatus(function (st) {

        $scope.status_pedido = st.status;

        statusPedidoSaidaService.getStatusExcluido(function (st) {

            $scope.status_excluido = st.status;

            $scope.status_pedido[$scope.status_pedido.length] = $scope.status_excluido;

        })

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

        for (var i = 0; i < validades.length; i++) {
            
            if(quantidades[i]==0)
                continue;
            
            var pp = angular.copy($scope.produto_pedido_novo);
            pp.produto = produto;
            pp.pedido = $scope.pedido;
            pp.validade_minima = validades[i].validade;
            pp.valor_base = validade.valor;
            pp.quantidade = quantidades[i];
            $scope.pedido.produtos[$scope.pedido.produtos.length] = pp;
        }

        $scope.atualizaCustos();

    }

    $scope.removerProduto = function (produto) {

        remove($scope.pedido.produtos, produto);
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

        baseService.merge(p, function (r) {
            if (r.sucesso) {
                $scope.pedido = r.o;
                equalize($scope.pedido, "status", $scope.status_pedido);
                equalize($scope.pedido, "forma_pagamento", $scope.formas_pagamento);
                msg.alerta("Operacao efetuada com sucesso");
            } else {
                $scope.pedido = r.o;
                equalize($scope.pedido, "status", $scope.status_pedido);
                equalize($scope.pedido, "forma_pagamento", $scope.formas_pagamento);
                msg.erro("Ocorreu o seguinte problema: " + r.mensagem);
            }
        });

    }

    $scope.setFrete = function (fr) {

        $scope.pedido.frete = fr.valor;
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

        tabelaService.getFretes(null, {cidade: $scope.pedido.cliente.endereco.cidade, valor: valorTotal, peso: pesoTotal}, function (f) {

            $scope.fretes = f.fretes;

        })

    }

    $scope.atualizaCustos = function () {

        pedidoService.atualizarCustos($scope.pedido, function (np) {

            $scope.pedido = np.o;

            equalize($scope.pedido, "status", $scope.status_pedido);
            equalize($scope.pedido, "forma_pagamento", $scope.formas_pagamento);

        })

    }

    pedidoService.getPedido(function (ped) {

        ped.pedido.produtos = [];
        $scope.pedido_novo = ped.pedido;

    })

    $scope.novoPedido = function () {

        $scope.setPedido(angular.copy($scope.pedido_novo));

    }

    $scope.setPedido = function (pedido) {

        $scope.pedido = pedido;

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
            ic.find("#nomeCliente").html($scope.pedido.cliente.nome);
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
                p.find("[data-tipo='total']").html(((pro.valor_base + pro.frete + pro.juros + pro.icms) * pro.quantidade).toFixed(2));
                p.data("gerado", true);

                ic.find("#produtos").append(p);
                p.show();

                total += (pro.valor_base + pro.frete + pro.juros + pro.icms) * pro.quantidade;

            }
            var alicota = (icms * 100 / base).toFixed(2);

            ic.find("#prazo").html(pedido.prazo);
            ic.find("#alicota").html(alicota);
            ic.find("#icms").html(icms);

            ic.find("#tipoFrete").html(pedido.frete_incluso ? 'CIF' : 'FOB');
            ic.find("#nomeTransportadora").html(pedido.transportadora.nome);
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
            ["id", "nome", "estoque", "disponivel", "transito", "valor_base", "ativo", "classe_risco"]);

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

    $scope.campanhas = createAssinc(campanhaService, 1, 3, 10);
    $scope.campanhas.attList();
    assincFuncs(
            $scope.campanhas,
            "campanha",
            ["id", "nome", "inicio", "fim", "prazo", "parcelas"]);

    $scope.produtos = createAssinc(produtoService, 1, 3, 4);
    $scope.produtos.attList();
    assincFuncs(
            $scope.produtos,
            "produto",
            ["id", "nome", "estoque", "disponivel"], "filtroProdutos");


    $scope.campanha = {};
    $scope.campanha_nova = {};

    $scope.criacao_campanhas = [];

    $scope.produto_campanha_novo = {};

    $scope.produto = {};
    $scope.produto_campanha_validade = {};

    $scope.meses_validade_curta = 3;

    var data = new Date();
    var dia = 1000 * 60 * 60 * 24;

    campanhaService.getProdutoCampanha(function (p) {

        $scope.produto_campanha_novo = p.produto_campanha;

    })

    $scope.setAutoValidade = function (v) {

        $scope.produto_campanha_validade.validade = v.validade;
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

    campanhaService.getCampanha(function (p) {

        $scope.campanha_nova = p.campanha;

        for (var i = 0; i < 5; i++) {

            var c = angular.copy($scope.campanha_nova);
            c.campanhas = [{
                    inicio: toTime(data.getTime() + dia * i),
                    fim: toTime(data.getTime() + (dia + 1) * i),
                    nome: "Campanha A",
                    id: 0,
                    prazo: 0,
                    parcelas: 1
                }]
            c.inicio = toTime(data.getTime() + dia * i);
            c.fim = toTime(data.getTime() + (dia + 1) * i);
            c.nome = "Nova campanha";

            c.numero = i;

            while (new Date(c.fim).getDay() == 0 || new Date(c.fim).getDay() == 6) {

                c.fim += dia;

            }

            $scope.criacao_campanhas[$scope.criacao_campanhas.length] = c;

        }

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
            camp.inicio = fromTime(c.inicio);
            camp.fim = fromTime(c.fim);

            if (camp.inicio < 0 || camp.fim < 0) {
                msg.erro("Data da campanha '" + camp.nome + "' invalida");
                return;
            }

            camp.produtos = [];

            for (var j = 0; j < $scope.campanha.produtos.length; j++) {

                var p = $scope.campanha.produtos[j];

                if (p.numeracao !== c.id || p.validade < 0) {

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

    }

    $scope.setCampanhaCriacao = function (campanha) {

        if (campanha.produtos.length === 0) {

            campanhaService.getProdutosDia(new Date(campanha.inicio).getDay(), function (prods) {

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

                campanha.lista = createList(campanha.produtos, 1, 3, "produto.nome");



            })

        }

        $scope.campanha = campanha;

    }

    sistemaService.getMesesValidadeCurta(function (p) {

        $scope.meses_validade_curta = p.meses_validade_curta;

    })

    $scope.setCampanha = function (campanha) {

        $scope.campanha = campanha;
        $scope.campanha.inicio_texto = toTime(campanha.inicio);
        $scope.campanha.fim_texto = toTime(campanha.fim);

    }

    $scope.mergeCampanha = function () {
        $scope.campanha.inicio = fromTime($scope.campanha.inicio_texto);
        $scope.campanha.fim = fromTime($scope.campanha.fim_texto);

        if ($scope.campanha.inicio < 0) {

            msg.erro("Data de inicio incorreta");
            return;

        }

        if ($scope.campanha.fim < 0) {

            msg.erro("Data de fim incorreta");
            return;

        }

        baseService.merge($scope.campanha, function (r) {
            if (r.sucesso) {
                $scope.campanha = r.o;
                if (r.sucesso) {
                    msg.alerta("Operacao efetuada com sucesso");
                    $scope.campanhas.attList();
                } else {
                    msg.erro("Fornecedor alterado, porém ocorreu um problema ao subir os documentos");
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


    $scope.lotes = createAssinc(loteService, 1, 3, 10);
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

        loteService.getEtiquetas(etiquetas, function (a) {
            if (a.sucesso) {
                window.open(projeto + "/php/uploads/" + a.arquivo);
            } else {
                msg.erro("Ocorreu um problema de servidor, tente mais tarde");
            }
        });

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
        
        if((palet%pendencia.grade.gr[pendencia.grade.gr.length-1]) != 0){
            
            msg.erro("A quantidade de palet deve ser multipla de "+pendencia.grade.gr[pendencia.grade.gr.length-1]);
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
            ["id", "nome", "email_fornecedor.endereco", "cnpj", "inscricao_estadual", "habilitado"]);

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
                        msg.erro("Fornecedor alterado, porém ocorreu um problema ao subir os documentos");

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
            if (r.usuario === null || !r.sucesso) {
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