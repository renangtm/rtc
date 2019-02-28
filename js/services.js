var debuger = function (l) {
    alert(paraJson(l));
}
rtc.service('bannerService', function ($http, $q) {
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: {filtro: filtro},
            query: "$r->qtd=$empresa->getCountBanners($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x1, x2, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x1: x1, x2: x2, ordem: ordem, filtro: filtro},
            query: "$r->elementos=$empresa->getBanners($c,$o->x1,$o->x2,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getBanner = function (fn) {
        baseService($http, $q, {
            query: "$r->banner=new Banner()",
            sucesso: fn,
            falha: fn
        });
    }
    this.getJson = function (banner, fn) {
        baseService($http, $q, {
            o: banner,
            query: "$r->json=$o->getJson($c)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('relatorioService', function ($http, $q) {
    this.getRelatorios = function (fn) {
        baseService($http, $q, {
            query: "$r->relatorios=Sistema::getRelatorios($empresa)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getFilhos = function (item,fn) {
        baseService($http, $q, {
            o:item,
            query: "$r->filhos=$o->getFilhos($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.relatorio = null;
    this.getCount = function(filtro,fn){
        baseService($http, $q, {
            o: this.relatorio,
            query: "$r->qtd=$o->getCount($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x0: x0, x1: x1, relatorio:this.relatorio},
            query: "$r->elementos=$o->relatorio->getItens($c,$o->x0,$o->x1)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('logService', function ($http, $q) {
    this.getLogs = function (entidade, fn) {
        baseService($http, $q, {
            o: entidade,
            query: "$r->logs=Logger::getLogs($o)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('compraParceiroService', function ($http, $q) {
    this.getElementos = function (x1, x2, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x1: x1, x2: x2, ordem: ordem, filtro: filtro},
            query: "$r->elementos=Sistema::getCompraParceiros($c);$op=new OpProdutos($r->elementos);$r->elementos=$op->filtrar($o->x1,$o->x2,$o->filtro,$o->ordem);$r->qtd=$op->getLastQtd();$r->filtros=$op->getFiltrosPossiveis();$r->ordens=$op->getOrdensPossiveis()",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('usuarioService', function ($http, $q) {
    this.getRTC = function (fn) {
        baseService($http, $q, {
            query: "$r->rtc=$empresa->getRTC($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getUsuario = function (fn) {
        baseService($http, $q, {
            query: "$r->usuario=new Usuario();$r->usuario->empresa=$empresa",
            sucesso: fn,
            falha: fn
        });
    }
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: {filtro: filtro},
            query: "$r->qtd=$empresa->getCountUsuarios($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
            query: "$r->elementos=$empresa->getUsuarios($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('produtoClienteLogisticService', function ($http, $q) {
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: {filtro: filtro},
            query: "$r->qtd=$empresa->getCountProdutoClienteLogistic($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
            query: "$r->elementos=$empresa->getProdutoClienteLogistic($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('movimentoService', function ($http, $q) {
    this.getMovimento = function (fn) {
        baseService($http, $q, {
            query: "$r->movimento=new Movimento();",
            sucesso: fn,
            falha: fn
        });
    }
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: {filtro: filtro},
            query: "$r->qtd=$empresa->getCountMovimentos($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
            query: "$r->elementos=$empresa->getMovimentos($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('notaService', function ($http, $q) {
    this.getNota = function (fn) {
        baseService($http, $q, {
            query: "$r->nota=new Nota();$r->nota->empresa=$empresa",
            sucesso: fn,
            falha: fn
        });
    }
    this.calcularImpostosAutomaticamente = function (nota, fn) {
        baseService($http, $q, {
            o: nota,
            query: "$o->calcularImpostosAutomaticamente()",
            sucesso: fn,
            falha: fn
        });
    }
    this.getProdutos = function (nota, fn) {
        var f = function (p) {
            for (var i = 0; i < p.produtos.length; i++) {
                p.produtos[i].nota = nota;
            }
            fn(p);
        }
        baseService($http, $q, {
            o: nota,
            query: "$r->produtos=$o->getProdutos($c)",
            sucesso: f,
            falha: f
        });
    }
    this.getVencimentos = function (nota, fn) {
        var f = function (p) {
            for (var i = 0; i < p.vencimentos.length; i++) {
                p.vencimentos[i].nota = nota;
            }
            fn(p);
        }
        baseService($http, $q, {
            o: nota,
            query: "$r->vencimentos=$o->getVencimentos($c)",
            sucesso: f,
            falha: f
        });
    }
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: {filtro: filtro},
            query: "$r->qtd=$empresa->getCountNotas($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        if (typeof this["filtro_base"] === 'undefined') {
            baseService($http, $q, {
                o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
                query: "$r->elementos=$empresa->getNotas($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
                sucesso: fn,
                falha: fn
            });
        } else {
            baseService($http, $q, {
                o: {x0: x0, x1: x1, filtro: filtro + (filtro !== "" ? "AND " : "") + this["filtro_base"] + " ", ordem: ordem},
                query: "$r->elementos=$empresa->getNotas($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
                sucesso: fn,
                falha: fn
            });
        }
    }
})
rtc.service('produtoNotaService', function ($http, $q) {
    this.getProdutoNota = function (fn) {
        baseService($http, $q, {
            query: "$r->produto_nota=new ProdutoNota()",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('vencimentoService', function ($http, $q) {
    this.getVencimento = function (fn) {
        baseService($http, $q, {
            query: "$r->vencimento=new Vencimento()",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('bancoService', function ($http, $q) {
    this.getBanco = function (fn) {
        baseService($http, $q, {
            query: "$r->banco=new Banco();$r->banco->empresa=$empresa",
            sucesso: fn,
            falha: fn
        });
    }
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: {filtro: filtro},
            query: "$r->qtd=$empresa->getCountBancos($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
            query: "$r->elementos=$empresa->getBancos($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('cotacaoEntradaService', function ($http, $q) {
    this.getCotacao = function (fn) {
        baseService($http, $q, {
            query: "$r->cotacao=new CotacaoEntrada();$r->cotacao->usuario=$usuario;$r->cotacao->empresa=$empresa",
            sucesso: fn,
            falha: fn
        });
    }
    this.getCotacaoEspecifica = function (id_cotacao, id_empresa, fn) {
        baseService($http, $q, {
            o: {id_cotacao: id_cotacao, id_empresa: id_empresa},
            query: "$e=new Empresa($o->id_empresa);$cots=$e->getCotacoesEntrada($c,0,1,'cotacao_entrada.id_status=1 AND cotacao_entrada.id='.$o->id_cotacao,'');$r->cotacoes=$cots;",
            sucesso: fn,
            falha: fn
        });
    }
    this.formarPedido = function (cotacao, transportadora, frete, fn) {
        baseService($http, $q, {
            o: {cotacao: cotacao, transportadora: transportadora, frete: frete},
            query: "$o->cotacao->formarPedido($c,$o->transportadora,$o->frete)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getProdutos = function (pedido, fn) {
        var f = function (p) {
            for (var i = 0; i < p.produtos.length; i++) {
                p.produtos[i].cotacao = pedido;
            }
            fn(p);
        }
        baseService($http, $q, {
            o: pedido,
            query: "$r->produtos=$o->getProdutos($c)",
            sucesso: f,
            falha: f
        });
    }
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: {filtro: filtro},
            query: "$r->qtd=$empresa->getCountCotacoesEntrada($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
            query: "$r->elementos=$empresa->getCotacoesEntrada($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('produtoCotacaoEntradaService', function ($http, $q) {
    this.getProdutoCotacao = function (fn) {
        baseService($http, $q, {
            query: "$r->produto_cotacao=new ProdutoCotacaoEntrada()",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('statusCotacaoEntradaService', function ($http, $q) {
    this.getStatus = function (fn) {
        baseService($http, $q, {
            query: "$r->status=Sistema::getStatusCotacaoEntrada()",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('pedidoEntradaService', function ($http, $q) {
    this.getPedido = function (fn) {
        baseService($http, $q, {
            query: "$r->pedido=new PedidoEntrada();$r->pedido->usuario=$usuario;$r->pedido->empresa=$empresa",
            sucesso: fn,
            falha: fn
        });
    }
    this.getProdutos = function (pedido, fn) {
        var f = function (p) {
            for (var i = 0; i < p.produtos.length; i++) {
                p.produtos[i].pedido = pedido;
            }
            fn(p);
        }
        baseService($http, $q, {
            o: pedido,
            query: "$r->produtos=$o->getProdutos($c)",
            sucesso: f,
            falha: f
        });
    }
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: {filtro: filtro},
            query: "$r->qtd=$empresa->getCountPedidosEntrada($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
            query: "$r->elementos=$empresa->getPedidosEntrada($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('produtoPedidoEntradaService', function ($http, $q) {
    this.getProdutoPedido = function (fn) {
        baseService($http, $q, {
            query: "$r->produto_pedido=new ProdutoPedidoEntrada()",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('statusPedidoEntradaService', function ($http, $q) {
    this.getStatus = function (fn) {
        baseService($http, $q, {
            query: "$r->status=Sistema::getStatusPedidoEntrada()",
            sucesso: fn,
            falha: fn
        });
    }
    this.getStatusCancelado = function (fn) {
        baseService($http, $q, {
            query: "$r->status=Sistema::getStatusCanceladoPedidoEntrada()",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('pedidoService', function ($http, $q) {
    this.getPedido = function (fn) {
        baseService($http, $q, {
            query: "$r->pedido=new Pedido();$r->pedido->usuario=$usuario;$r->pedido->empresa=$empresa",
            sucesso: fn,
            falha: fn
        });
    }
    this.gerarCobranca = function (pedido, fn) {
        baseService($http, $q, {
            o: pedido,
            query: "$r->retorno=$o->gerarCobranca()",
            sucesso: fn,
            falha: fn
        });
    }
    this.atualizarCustos = function (pedido, fn) {
        baseService($http, $q, {
            o: pedido,
            query: "$o->atualizarCustos()",
            sucesso: fn,
            falha: fn
        });
    }
    this.getProdutos = function (pedido, fn) {
        var f = function (p) {
            for (var i = 0; i < p.produtos.length; i++) {
                p.produtos[i].pedido = pedido;
            }
            fn(p);
        }
        baseService($http, $q, {
            o: pedido,
            query: "$r->produtos=$o->getProdutos($c)",
            sucesso: f,
            falha: f
        });
    }
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: {filtro: filtro},
            query: "$r->qtd=$empresa->getCountPedidos($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
            query: "$r->elementos=$empresa->getPedidos($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('produtoPedidoService', function ($http, $q) {
    this.getProdutoPedido = function (fn) {
        baseService($http, $q, {
            query: "$r->produto_pedido=new ProdutoPedidoSaida()",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('formaPagamentoService', function ($http, $q) {
    this.getFormasPagamento = function (pedido, fn) {
        baseService($http, $q, {
            o: pedido,
            query: "$formas=Sistema::getFormasPagamento();$r->formas=array();foreach($formas as $key=>$value){if($value->habilitada($o)){$r->formas[]=$value;}}",
            sucesso: fn,
            falha: fn
        });
    }
    this.aoFinalizarPedido = function (forma, pedido, fn) {
        baseService($http, $q, {
            o: {forma: forma, pedido: pedido},
            query: "$r->retorno=$o->forma->aoFinalizarPedido($o->pedido)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('listaPrecoProdutoService', function ($http, $q) {
    this.cultura = null;
    this.praga = null;
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        var convert = function (r) {
            for (var i = 0; i < r.elementos.length; i++) {
                r.elementos[i] = r.elementos[i].produto;
            }
            fn(r);
        }
        baseService($http, $q, {
            o: {cultura: this.cultura, praga: this.praga, x1: x1, x0: x0, filtro: filtro, ordem: ordem},
            query: "$filtro=$o->filtro;if($o->cultura!=null){if($filtro!=''){$filtro.='AND';}$filtro.=' cultura.id = '.$o->cultura->id.' ';};if($o->praga!=null){if($filtro!=''){$filtro.='AND';}$filtro.=' praga.id = '.$o->praga->id;};$r->elementos=$empresa->getReceituario($c,$o->x0,$o->x1,$filtro,$o->ordem,'produto.id');",
            sucesso: convert,
            falha: convert
        });
    }
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: {cultura: this.cultura, praga: this.praga, filtro: filtro},
            query: "$filtro=$o->filtro;if($o->cultura!=null){if($filtro!=''){$filtro.='AND';}$filtro.=' cultura.id = '.$o->cultura->id.' ';};if($o->praga!=null){if($filtro!=''){$filtro.='AND';}$filtro.=' praga.id = '.$o->praga->id;};$r->qtd=$empresa->getCountReceituario($c,$filtro,'produto.id');",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('listaPrecoCulturaService', function ($http, $q) {
    this.produto = null;
    this.praga = null;
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        var convert = function (r) {
            for (var i = 0; i < r.elementos.length; i++) {
                r.elementos[i] = r.elementos[i].cultura;
            }
            fn(r);
        }
        baseService($http, $q, {
            o: {produto: this.produto, praga: this.praga, x1: x1, x0: x0, filtro: filtro, ordem: ordem},
            query: "$filtro=$o->filtro;if($o->produto!=null){if($filtro!=''){$filtro.='AND';}$filtro.=' produto.id = '.$o->produto->id.' ';};if($o->praga!=null){if($filtro!=''){$filtro.='AND';}$filtro.=' praga.id = '.$o->praga->id;};$r->elementos=$empresa->getReceituario($c,$o->x0,$o->x1,$filtro,$o->ordem,'cultura.id');",
            sucesso: convert,
            falha: convert
        });
    }
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: {produto: this.produto, praga: this.praga, filtro: filtro},
            query: "$filtro=$o->filtro;if($o->produto!=null){if($filtro!=''){$filtro.='AND';}$filtro.=' produto.id = '.$o->produto->id.' ';};if($o->praga!=null){if($filtro!=''){$filtro.='AND';}$filtro.=' praga.id = '.$o->praga->id;};$r->qtd=$empresa->getCountReceituario($c,$filtro,'cultura.id');",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('listaPrecoPragaService', function ($http, $q) {
    this.produto = null;
    this.cultura = null;
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        var convert = function (r) {
            for (var i = 0; i < r.elementos.length; i++) {
                r.elementos[i] = r.elementos[i].praga;
            }
            fn(r);
        }
        baseService($http, $q, {
            o: {produto: this.produto, cultura: this.cultura, x1: x1, x0: x0, filtro: filtro, ordem: ordem},
            query: "$filtro=$o->filtro;if($o->produto!=null){if($filtro!=''){$filtro.='AND';}$filtro.=' produto.id = '.$o->produto->id.' ';};if($o->cultura!=null){if($filtro!=''){$filtro.='AND';}$filtro.=' cultura.id = '.$o->cultura->id;};$r->elementos=$empresa->getReceituario($c,$o->x0,$o->x1,$filtro,$o->ordem,'praga.id');",
            sucesso: convert,
            falha: convert
        });
    }
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: {produto: this.produto, praga: this.praga, filtro: filtro},
            query: "$filtro=$o->filtro;if($o->produto!=null){if($filtro!=''){$filtro.='AND';}$filtro.=' produto.id = '.$o->produto->id.' ';};if($o->cultura!=null){if($filtro!=''){$filtro.='AND';}$filtro.=' cultura.id = '.$o->cultura->id;};$r->qtd=$empresa->getCountReceituario($c,$filtro,'praga.id');",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('campanhaService', function ($http, $q) {
    this.getCampanha = function (fn) {
        baseService($http, $q, {
            query: "$r->campanha=new Campanha();$r->campanha->empresa=$empresa",
            sucesso: fn,
            falha: fn
        });
    }
    this.getProdutoCampanha = function (fn) {
        baseService($http, $q, {
            query: "$r->produto_campanha=new ProdutoCampanha()",
            sucesso: fn,
            falha: fn
        });
    }
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: {filtro: filtro},
            query: "$r->qtd=$empresa->getCountCampanha($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
            query: "$r->elementos=$empresa->getCampanhas($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getProdutosDia = function (dia, fn) {
        baseService($http, $q, {
            o: {dia: dia},
            query: "$r->produtos=Sistema::getProdutosDoDia($c,$o->dia,5,$empresa)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('loteService', function ($http, $q) {
    this.getLote = function (fn) {
        baseService($http, $q, {
            query: "$r->lote=new Lote()",
            sucesso: fn,
            falha: fn
        });
    }
    this.getItem = function (lote, fn) {
        baseService($http, $q, {
            o: {lote: lote},
            query: "$r->item=$o->lote->getItem()",
            sucesso: fn,
            falha: fn
        });
    }
    this.getEtiquetas = function (itens, fn) {
        baseService($http, $q, {
            o: {etiquetas: itens},
            query: "$r->arquivo=Sistema::getEtiquetas($o->etiquetas)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getPendenciasCadastro = function (filtro, fn) {
        baseService($http, $q, {
            o: {filtro: filtro},
            query: "$r->pendencias=$empresa->getCadastroLotesPendentes($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getCount = function (filtro, fn) {
        if (filtro != "") {
            filtro += " AND ";
        }
        filtro += "quantidade_real>0";
        baseService($http, $q, {
            o: {filtro: filtro},
            query: "$r->qtd=$empresa->getCountLotes($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        if (filtro != "") {
            filtro += " AND ";
        }
        filtro += "quantidade_real>0";
        baseService($http, $q, {
            o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
            query: "$r->elementos=$empresa->getLotes($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('transportadoraService', function ($http, $q) {
    this.getTransportadora = function (fn) {
        baseService($http, $q, {
            query: "$r->transportadora=new Transportadora();$r->transportadora->empresa=$empresa",
            sucesso: fn,
            falha: fn
        });
    }
    this.setDocumentos = function (transportadora, documentos, fn) {
        baseService($http, $q, {
            o: {transportadora: transportadora, documentos: documentos},
            query: "$o->transportadora->setDocumentos($o->documentos,$c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getDocumentos = function (transportadora, fn) {
        baseService($http, $q, {
            o: transportadora,
            query: "$r->documentos=$o->getDocumentos($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getCount = function (filtro, fn) {
        if (typeof this["empresa"] === "undefined") {
            baseService($http, $q, {
                o: {filtro: filtro},
                query: "$r->qtd=$empresa->getCountTransportadoras($c,$o->filtro)",
                sucesso: fn,
                falha: fn
            });
        } else {
            baseService($http, $q, {
                o: {filtro: filtro, empresa: this["empresa"]},
                query: "$r->qtd=$o->empresa->getCountTransportadoras($c,$o->filtro)",
                sucesso: fn,
                falha: fn
            });
        }
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        if (typeof this["empresa"] === "undefined") {
            baseService($http, $q, {
                o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
                query: "$r->elementos=$empresa->getTransportadoras($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
                sucesso: fn,
                falha: fn
            });
        } else {
            baseService($http, $q, {
                o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem, empresa: this["empresa"]},
                query: "$r->elementos=$o->empresa->getTransportadoras($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
                sucesso: fn,
                falha: fn
            });
        }
    }
})
rtc.service('tabelaService', function ($http, $q) {
    this.getTabela = function (fn) {
        baseService($http, $q, {
            query: "$r->tabela=new Tabela()",
            sucesso: fn,
            falha: fn
        });
    }
    this.getValorTabela = function (tabela, parametros, fn) {
        baseService($http, $q, {
            o: {tabela: tabela, p: parametros},
            query: "$r->valor=(($o->tabela->atende($o->p->cidade,$o->p->peso,$o->p->valor))?$o->tabela->valor($o->p->cidade,$o->p->peso,$o->p->valor):-1)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getFretes = function (empresa, parametros, fn) {
        baseService($http, $q, {
            o: {p: parametros, e: empresa},
            query: "if(isset($o->e)){$empresa=$o->e;}$r->fretes=array();$t=$empresa->getTransportadoras($c,0,$empresa->getCountTransportadoras($c,'transportadora.habilitada=true AND tabela.nome IS NOT NULL'),'transportadora.habilitada=true AND tabela.nome IS NOT NULL','');$valores=array();foreach($t as $key=>$tr){if($tr->tabela->atende($o->p->cidade,$o->p->peso,$o->p->valor)){$f=new stdClass();$f->transportadora=$tr;$f->valor=$tr->tabela->valor($o->p->cidade,$o->p->peso,$o->p->valor);$r->fretes[]=$f;}}",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('regraTabelaService', function ($http, $q) {
    this.getRegraTabela = function (fn) {
        baseService($http, $q, {
            query: "$r->regra_tabela=new RegraTabela()",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('telefoneService', function ($http, $q) {
    this.getTelefone = function (fn) {
        baseService($http, $q, {
            query: "$r->telefone=new Telefone()",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('cidadeService', function ($http, $q) {
    this.getElementos = function (fn) {
        baseService($http, $q, {
            query: "$r->elementos=Sistema::getCidades($c)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('fornecedorService', function ($http, $q) {
    this.getFornecedor = function (fn) {
        baseService($http, $q, {
            query: "$r->fornecedor=new Fornecedor();$r->fornecedor->empresa=$empresa",
            sucesso: fn,
            falha: fn
        });
    }
    this.setDocumentos = function (fornecedor, documentos, fn) {
        baseService($http, $q, {
            o: {fornecedor: fornecedor, documentos: documentos},
            query: "$o->fornecedor->setDocumentos($o->documentos,$c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getDocumentos = function (fornecedor, fn) {
        baseService($http, $q, {
            o: fornecedor,
            query: "$r->documentos=$o->getDocumentos($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: {filtro: filtro},
            query: "$r->qtd=$empresa->getCountFornecedores($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
            query: "$r->elementos=$empresa->getFornecedores($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('clienteService', function ($http, $q) {
    this.getCliente = function (fn) {
        baseService($http, $q, {
            query: "$r->cliente=new Cliente();$r->cliente->empresa=$empresa",
            sucesso: fn,
            falha: fn
        });
    }
    this.setDocumentos = function (cliente, documentos, fn) {
        baseService($http, $q, {
            o: {cliente: cliente, documentos: documentos},
            query: "$o->cliente->setDocumentos($o->documentos,$c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getDocumentos = function (cliente, fn) {
        baseService($http, $q, {
            o: cliente,
            query: "$r->documentos=$o->getDocumentos($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: {filtro: filtro},
            query: "$r->qtd=$empresa->getCountClientes($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
            query: "$r->elementos=$empresa->getClientes($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('telefoneService', function ($http, $q) {
    this.getTelefone = function (fn) {
        baseService($http, $q, {
            query: "$r->telefone=new Telefone()",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('cidadeService', function ($http, $q) {
    this.getElementos = function (fn) {
        baseService($http, $q, {
            query: "$r->elementos=Sistema::getCidades($c)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('documentoService', function ($http, $q) {
    this.getDocumento = function (fn) {
        baseService($http, $q, {
            query: "$r->documento=new Documento()",
            sucesso: fn,
            falha: fn
        });
    }

})
rtc.service('categoriaDocumentoService', function ($http, $q) {
    this.getElementos = function (fn) {
        baseService($http, $q, {
            query: "$r->elementos=Sistema::getCategoriaDocumentos($c)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('statusPedidoSaidaService', function ($http, $q) {
    this.getStatus = function (fn) {
        baseService($http, $q, {
            query: "$r->status=Sistema::getStatusPedidoSaida()",
            sucesso: fn,
            falha: fn
        });
    }
    this.getStatusExcluido = function (fn) {
        baseService($http, $q, {
            query: "$r->status=Sistema::getStatusExcluidoPedidoSaida()",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('categoriaClienteService', function ($http, $q) {
    this.getElementos = function (fn) {
        baseService($http, $q, {
            query: "$r->elementos=Sistema::getCategoriaCliente($c)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('categoriaProdutoService', function ($http, $q) {
    this.getElementos = function (fn) {
        baseService($http, $q, {
            query: "$r->elementos=Sistema::getCategoriaProduto($c)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('pragaService', function ($http, $q) {
    this.getElementos = function (fn) {
        baseService($http, $q, {
            query: "$r->pragas=Sistema::getPragas($c)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('culturaService', function ($http, $q) {
    this.getElementos = function (fn) {
        baseService($http, $q, {
            query: "$r->culturas=Sistema::getCulturas($c)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('receituarioService', function ($http, $q) {
    this.getReceituario = function (fn) {
        baseService($http, $q, {
            query: "$r->receituario=new Receituario()",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('baseService', function ($http, $q) {
    this.delete = function (obj, fn) {
        baseService($http, $q, {
            o: obj,
            query: "$o->delete($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.merge = function (obj, fn) {
        baseService($http, $q, {
            o: obj,
            query: "$o->merge($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.insert = function (obj, fn) {
        baseService($http, $q, {
            o: obj,
            query: "$o->insert($c)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('produtoService', function ($http, $q) {
    this.getProduto = function (fn) {
        baseService($http, $q, {
            query: "$r->produto=new Produto();$r->produto->empresa=$empresa",
            sucesso: fn,
            falha: fn
        });
    }
    this.getLotes = function (produto, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {produto: produto, filtro: filtro, ordem: ordem},
            query: "$r->lotes=$o->produto->getLotes($c,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getValidades = function (meses_validade_curta, produto, fn) {

        if (!produto.sistema_lotes) {

            var validade = {validade: 1000, quantidade: produto.disponivel, alem: false, limite: -1, valor: produto.valor_base, validades: []};

            for (var j = 0; j < produto.ofertas.length; j++) {

                validade.valor = produto.ofertas[j].valor;
                validade.limite = produto.ofertas[j].limite;

            }

            fn([validade]);
            return;

        }

        this.getLotes(produto, '', 'lote.validade', function (l) {

            var lotes = l.lotes;

            var validades = [];

            lbl:
                    for (var i = 0; i < lotes.length; i++) {

                var lote = lotes[i];

                for (var j = 0; j < validades.length; j++) {

                    if (validades[j].validade === lote.validade) {

                        validades[j].quantidade += lote.quantidade_real;
                        continue lbl;

                    }

                }

                var diff = ((((((lote.validade - new Date().getTime()) / 1000) / 60) / 60) / 24) / 30);

                if (diff < meses_validade_curta) {

                    validades[validades.length] = {validade: lote.validade, quantidade: lote.quantidade_real, alem: false, validades: []};

                } else {

                    var criar = validades.length === 0;

                    if (!criar) {

                        var diff = ((((((validades[validades.length - 1].validade - new Date().getTime()) / 1000) / 60) / 60) / 24) / 30);
                        criar = diff < meses_validade_curta;

                    }

                    if (criar) {

                        validades[validades.length] = {validade: lote.validade, quantidade: lote.quantidade_real, alem: false, validades: []};

                    } else {

                        var v = validades[validades.length - 1];

                        v.quantidade += lote.quantidade_real;
                        v.alem = true;

                        for (var m = 0; m < v.validades.length; m++) {
                            if (v.validades[m].validade === lote.validade) {
                                v.validades[m].quantidade += lote.quantidade_real;
                                continue lbl;
                            }
                        }

                        v.validades[v.validades.length] = {validade: lote.validade, quantidade: lote.quantidade_real};

                    }


                }

            }

            lbl:
                    for (var i = 0; i < validades.length; i++) {

                for (var j = 0; j < produto.ofertas.length; j++) {

                    if (validades[i].validade === produto.ofertas[j].validade) {

                        validades[i].valor = produto.ofertas[j].valor;
                        validades[i].limite = produto.ofertas[j].limite;
                        continue lbl;

                    }

                }

                validades[i].valor = produto.valor_base;
                validades[i].limite = -1;

            }

            fn(validades);

        })

    }
    this.getReceituario = function (produto, fn) {
        baseService($http, $q, {
            o: produto,
            query: "$r->receituario=$o->getReceituario($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getCount = function (filtro, fn) {
        if (typeof this["empresa"] === 'undefined') {
            if (typeof this["filtro_base"] === 'undefined') {
                baseService($http, $q, {
                    o: {filtro: filtro},
                    query: "$r->qtd=$empresa->getCountProdutos($c,$o->filtro)",
                    sucesso: fn,
                    falha: fn
                });
            } else {
                baseService($http, $q, {
                    o: {filtro: (filtro + (filtro !== "" ? "AND " : "") + this["filtro_base"] + " ")},
                    query: "$r->qtd=$empresa->getCountProdutos($c,$o->filtro)",
                    sucesso: fn,
                    falha: fn
                });
            }
        } else {
            baseService($http, $q, {
                o: {filtro: filtro, id_empresa: this["empresa"]},
                query: "$e=new Empresa($o->id_empresa);$r->qtd=$e->getCountProdutos($c,$o->filtro)",
                sucesso: fn,
                falha: fn
            });
        }
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        if (typeof this["empresa"] === 'undefined') {
            if (typeof this["filtro_base"] === 'undefined') {
                baseService($http, $q, {
                    o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
                    query: "$r->elementos=$empresa->getProdutos($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
                    sucesso: fn,
                    falha: fn
                });
            } else {
                baseService($http, $q, {
                    o: {x0: x0, x1: x1, filtro: (filtro + (filtro !== "" ? "AND " : "") + this["filtro_base"] + " "), ordem: ordem},
                    query: "$r->elementos=$empresa->getProdutos($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
                    sucesso: fn,
                    falha: fn
                });
            }
        } else {
            baseService($http, $q, {
                o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem, id_empresa: this["empresa"]},
                query: "$e=new Empresa($o->id_empresa);$r->elementos=$e->getProdutos($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
                sucesso: fn,
                falha: fn
            });
        }
    }
})
rtc.service('acessoService', function ($http, $q) {
    this.getAcesso = function (fn) {
        baseService($http, $q, {
            query: "$r->usuario=$ses->get('usuario');$r->empresa=$ses->get('empresa');$r->logo=$r->empresa->getLogo($c)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('loginService', function ($http, $q) {
    this.login = function (usuario, senha, fn) {
        baseService($http, $q, {
            o: {u: usuario, s: senha},
            query: "$r->usuario=Sistema::logar($o->u,$o->s)",
            sucesso: fn,
            falha: fn
        }, null, true);
    }
    this.recuperar = function (email, fn) {
        baseService($http, $q, {
            o: {email: email},
            query: "$u=Sistema::getUsuario(\"email_usu.endereco='\".$o->email.\"'\");if($u==null)throw new Exception('');$s=Sistema::getEmailSistema();$s->enviarEmail($u->email,'Recuperacao de Senha','Sua senha do RTC: '.$u->senha)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('sistemaService', function ($http, $q) {
    this.finalizarCompraParceiros = function (pedido, fn) {
        baseService($http, $q, {
            o: pedido,
            query: "$r->retorno=Sistema::finalizarCompraParceiros($c,$o,$empresa);",
            sucesso: fn,
            falha: fn
        });
    }
    this.getMesesValidadeCurta = function (fn) {
        baseService($http, $q, {
            query: "$r->meses_validade_curta=Sistema::getMesesValidadeCurta()",
            sucesso: fn,
            falha: fn
        });
    }
    this.getPedidoEntradaSemelhante = function (xml, fn) {
        baseService($http, $q, {
            o: {xml: xml},
            query: "$r->pedidos=Sistema::getPedidoEntradaSemelhante($c,$empresa,$o->xml)",
            sucesso: fn,
            falha: fn
        });
    }
    this.finalizarNotas = function (notas, fn) {
        baseService($http, $q, {
            o: {notas: notas},
            query: "Sistema::finalizarNotas($c,$o->notas)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getIcmsEstado = function (estado, fn) {
        baseService($http, $q, {
            o: estado,
            query: "$r->icms=Sistema::getIcmsEstado($o)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getIcmsAndEmpresa = function (estado, fn) {
        baseService($http, $q, {
            query: "$r->icms=Sistema::getIcmsEstado($empresa->endereco->cidade->estado);$r->empresa=$empresa",
            sucesso: fn,
            falha: fn
        });
    }
    this.getOperacoes = function (fn) {
        baseService($http, $q, {
            query: "$r->operacoes=Sistema::getOperacoes($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getLogisticas = function (fn) {
        baseService($http, $q, {
            query: "$r->logisticas=Sistema::getLogisticas($c,false)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getHistoricos = function (fn) {
        baseService($http, $q, {
            query: "$r->historicos=Sistema::getHistorico($c)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('empresaService', function ($http, $q) {
    this.setLogo = function (logo, fn) {
        baseService($http, $q, {
            o: {logo: logo},
            query: "$empresa->setLogo($c,$o->logo)",
            sucesso: fn,
            falha: fn
        }, null, true);
    }
    this.getFiliais = function (fn) {
        baseService($http, $q, {
            query: "$r->filiais=$empresa->getFiliais($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getParametrosEmissao = function(empresa,fn){
        baseService($http, $q, {
            o: empresa,
            query: "$r->parametros_emissao = $o->getParametrosEmissao($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.setParametrosEmissao = function(pe,fn){
        baseService($http, $q, {
            o: pe,
            query: "$o->merge($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.setEmpresa = function (empresa, fn) {
        baseService($http, $q, {
            o: empresa,
            query: "$empresa=$o;$ses->set('empresa',$empresa)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getEmpresa = function (fn) {
        baseService($http, $q, {
            query: "$r->empresa=$empresa",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('carrinhoService', function ($http, $q) {
    this.getCarrinho = function (fn) {
        baseService($http, $q, {
            query: "$car=$ses->get('carrinho');if($car===null){$car=array();$ses->set('carrinho',$car);};$r->carrinho=$car",
            sucesso: fn,
            falha: fn
        });
    }
    this.setCarrinho = function (carrinho, fn) {
        baseService($http, $q, {
            o: {carrinho: carrinho},
            query: "$ses->set('carrinho',$o->carrinho)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getPedidosResultantes = function (fn) {
        baseService($http, $q, {
            query: "$car=$ses->get('carrinho');if($car===null){$car=array();$ses->set('carrinho',$car);};$r->pedidos=Sistema::getPedidosResultantes($c,$car,$empresa,$usuario)",
            sucesso: fn,
            falha: fn
        });
    }
})
