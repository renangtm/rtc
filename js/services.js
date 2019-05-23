var debuger = function (l) {
    document.write(paraJson(l));
}
rtc.service('aprovacaoConsignadoService', function ($http, $q) {
    this.getAprovacaoConsignado = function (fn) {
        baseService($http, $q, {
            query: "$r->aprovacao=new AprovacaoConsignado();",
            sucesso: fn,
            falha: fn
        });
    }
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: {filtro: filtro},
            query: "$r->qtd=$empresa->getCountAprovacoesConsignado($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
            query: "$r->elementos=$empresa->getAprovacoesConsignado($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('pardalService', function ($http, $q) {
    this.reset = function (fn) {
        baseService($http, $q, {
            query: "Sistema::setPardal(null)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getFala = function (fn) {
        baseService($http, $q, {
            query: "$pardal=Sistema::getPardal();$r->fala=$pardal->getFala();Sistema::setPardal($pardal);",
            sucesso: fn,
            falha: fn
        });
    }
    this.enviar = function (texto, fn) {
        baseService($http, $q, {
            o: {texto: texto},
            query: "$pardal=Sistema::getPardal();$pardal->analisar($o->texto);$r->fala=$pardal->getFala();Sistema::setPardal($pardal);",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('protocoloService', function ($http, $q) {
    this.getProtocolo = function (fn) {
        baseService($http, $q, {
            query: "$r->protocolo=new Protocolo();$r->protocolo->empresa=$empresa;$r->protocolo->iniciado_por=$usuario->id.' - '.$usuario->nome;",
            sucesso: fn,
            falha: fn
        });
    }
    this.terminar = function (protocolo, fn) {
        baseService($http, $q, {
            o: protocolo,
            query: "$o->terminar($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getMensagemProtocolo = function (fn) {
        baseService($http, $q, {
            query: "$r->mensagem=new MensagemProtocolo();$r->mensagem->dados_usuario=$usuario->id.' - '.$usuario->nome;",
            sucesso: fn,
            falha: fn
        });
    }
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: {filtro: filtro},
            query: "$r->qtd=$empresa->getCountProtocolos($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getMensagensProtocolo = function (protocolo, fn) {
        baseService($http, $q, {
            o: protocolo,
            query: "$r->mensagens=$o->getMensagensPosteriores($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getProtocolosAtivos = function (fn) {
        baseService($http, $q, {
            query: "$r->protocolos=$empresa->getProtocolos($c,0,2,'p.fim IS NULL','tp.prioridade DESC',$usuario);foreach($r->protocolos as $key=>$value){$value->init($c);}",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
            query: "$r->elementos=$empresa->getProtocolos($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('movimentosProdutoService', function ($http, $q) {
    this.getMovimentos = function (filtro, fn) {
        baseService($http, $q, {
            o: {filtro: filtro},
            query: "$r->movimentos=$empresa->getMovimentosProduto($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
})

rtc.service('cotacaoGrupalService', function ($http, $q) {
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: {filtro: filtro},
            query: "$r->qtd=$empresa->getCountCotacoesGrupais($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.enviarEmails = function (cotacao, fn) {
        baseService($http, $q, {
            o: cotacao,
            query: "$o->enviarEmails($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getCotacaoGrupal = function (fn) {
        baseService($http, $q, {
            query: "$r->cotacao_grupal=new CotacaoGrupal();$r->cotacao_grupal->empresa=$empresa",
            sucesso: fn,
            falha: fn
        });
    }
    this.getProdutoCotacaoGrupal = function (fn) {
        baseService($http, $q, {
            query: "$r->produto_cotacao_grupal=new ProdutoCotacaoGrupal();",
            sucesso: fn,
            falha: fn
        });
    }
    this.responder = function (respostas, fn) {
        baseService($http, $q, {
            o: {respostas: respostas},
            query: "foreach($o->respostas as $key=>$value){$value->merge($c);}",
            sucesso: fn,
            falha: fn
        });
    }
    this.getRespostasCotacaoGrupal = function (id_cotacao, id_fornecedor, id_empresa, fn) {
        baseService($http, $q, {
            o: {id_cotacao: id_cotacao, id_fornecedor: id_fornecedor, id_empresa: id_empresa},
            query: "$e=new Empresa($o->id_empresa,$c);$f=new FornecedorReduzido();$f->id=$o->id_fornecedor;$cotacao=$e->getCotacoesGrupais($c,0,1,'c.id='.$o->id_cotacao);if(count($cotacao)===0){$r->respostas=array();}else{$r->cotacao=$cotacao[0];$r->respostas=$cotacao[0]->getRespostasFaltantes($f);}",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
            query: "$r->elementos=$empresa->getCotacoesGrupais($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getFornecedores = function (produto, fn) {
        baseService($http, $q, {
            o: produto,
            query: "$r->fornecedores=CriadorCotacaoGrupalComBaseEncomenda::getFornecedores($c,$empresa,$o)",
            sucesso: fn,
            falha: fn
        });
    }
})

rtc.service('analiseCotacaoService', function ($http, $q) {
    this.getElementos = function (fn) {
        baseService($http, $q, {
            query: "$r->elementos=$empresa->getAnaliseCotacaoEntrada($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.recusar = function (analise, fn) {
        baseService($http, $q, {
            o: analise,
            query: "$o->recusar($c,$empresa)",
            sucesso: fn,
            falha: fn
        });
    }
    this.passar = function (analise, fn) {
        baseService($http, $q, {
            o: analise,
            query: "$o->passar($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.aprovar = function (analise, fn) {
        baseService($http, $q, {
            o: analise,
            query: "$o->aprovar($c,$empresa)",
            sucesso: fn,
            falha: fn
        });
    }
    this.campanha = function (analise, dias, fn) {
        baseService($http, $q, {
            o: {analise: analise, dias: dias},
            query: "$o->analise->campanha($c,$empresa,$o->dias)",
            sucesso: fn,
            falha: fn
        });
    }
})

rtc.service('encomendaService', function ($http, $q) {
    this.getEncomenda = function (fn) {
        baseService($http, $q, {
            query: "$r->encomenda=new Encomenda();$r->encomenda->usuario=$usuario;$r->encomenda->empresa=$empresa",
            sucesso: fn,
            falha: fn
        });
    }
    this.atualizarCustos = function (encomenda, fn) {
        baseService($http, $q, {
            o: encomenda,
            query: "$o->atualizarCustos()",
            sucesso: fn,
            falha: fn
        });
    }
    this.getProdutos = function (encomenda, fn) {
        var f = function (p) {
            for (var i = 0; i < p.produtos.length; i++) {
                p.produtos[i].pedido = encomenda;
            }
            fn(p);
        }
        baseService($http, $q, {
            o: encomenda,
            query: "$r->produtos=$o->getProdutos($c)",
            sucesso: f,
            falha: f
        });
    }
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: {filtro: filtro},
            query: "$r->qtd=$empresa->getCountEncomendas($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
            query: "$r->elementos=$empresa->getEncomendas($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });
    }
})


rtc.service('fechamentoCaixaService', function ($http, $q) {
    this.getBancosFechar = function (fn) {
        baseService($http, $q, {
            query: "$r->bancos=$empresa->getBancos($c,0,1000,'banco.fechamento=true')",
            sucesso: fn,
            falha: fn
        });
    }
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: {filtro: filtro},
            query: "$r->qtd=$empresa->getCountFechamento($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x1, x2, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x1: x1, x2: x2, ordem: ordem, filtro: filtro},
            query: "$r->elementos=$empresa->getFechamentosCaixa($c,$o->x1,$o->x2,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });
    }
})

rtc.service('tipoProtocoloService', function ($http, $q) {
    this.getTiposProtocolo = function (fn) {
        baseService($http, $q, {
            query: "$r->tipos=$empresa->getTiposProtocolo($c);",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('observacaoTarefaService', function ($http, $q) {
    this.getObservacaoTarefa = function (fn) {
        baseService($http, $q, {
            query: "$r->observacao_tarefa=new ObservacaoTarefa();",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('tarefaService', function ($http, $q) {
    this.getTarefasAtivas = function (fn) {
        baseService($http, $q, {
            query: "$a=$usuario->getAusencias($c,'ausencia.fim>CURRENT_TIMESTAMP');$e=$usuario->getExpedientes($c);$r->tarefas=$usuario->getTarefas($c,'tarefa.porcentagem_conclusao<100','tarefa.ordem DESC');$r->tarefas=IATarefas::aplicar($e,$a,$r->tarefas)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getOpcoes = function (tarefa, fn) {
        baseService($http, $q, {
            o: {tarefa: tarefa},
            query: "$r->opcoes=$o->tarefa->tipo_tarefa->getOpcoes($c,$o->tarefa);",
            sucesso: fn,
            falha: fn
        });
    }
    this.addObservacao = function (tarefa, observacao, fn) {
        baseService($http, $q, {
            o: {observacao: observacao, tarefa: tarefa},
            query: "$o->tarefa->addObservacao($c,$usuario,$o->observacao);",
            sucesso: fn,
            falha: fn
        });
    }
    this.getTarefa = function (fn) {
        baseService($http, $q, {
            query: "$r->tarefa=new Tarefa();$r->tarefa->criada_por=$usuario->id",
            sucesso: fn,
            falha: fn
        });
    }
    this.start = function (tarefa, fn) {
        baseService($http, $q, {
            o: tarefa,
            query: "$o->start($c,$usuario)",
            sucesso: fn,
            falha: fn
        });
    }
    this.pause = function (tarefa, fn) {
        baseService($http, $q, {
            o: tarefa,
            query: "$o->pause($c,$usuario)",
            sucesso: fn,
            falha: fn
        });
    }
    this.finish = function (tarefa, fn) {
        baseService($http, $q, {
            o: tarefa,
            query: "$o->finish($c,$usuario)",
            sucesso: fn,
            falha: fn
        });
    }
    this.atribuirTarefaEmpresa = function (empresa, tarefa, fn) {
        baseService($http, $q, {
            o: {empresa: empresa, tarefa: tarefa},
            query: "Sistema::novaTarefaEmpresa($c,$o->tarefa,$o->empresa)",
            sucesso: fn,
            falha: fn
        });
    }
    this.atribuirTarefaUsuario = function (usuario, tarefa, fn) {
        baseService($http, $q, {
            o: {usuario: usuario, tarefa: tarefa},
            query: "Sistema::novaTarefaUsuario($c,$o->tarefa,$o->usuario)",
            sucesso: fn,
            falha: fn
        });
    }
    this.atribuirTarefaUsuarioSessao = function (tarefa, fn) {
        baseService($http, $q, {
            o: {tarefa: tarefa},
            query: "Sistema::novaTarefaUsuario($c,$o->tarefa,$usuario)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('gerenciadorService', function ($http, $q) {
    var este = this;
    this.gerenciador = null;
    this.getGerenciador = function (fn) {
        baseService($http, $q, {
            query: "$r->gerenciador = new GerenciadorAtividade($empresa)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getInformacoesUsuario = function (usuario, fn) {
        baseService($http, $q, {
            o: {usuario: usuario},
            query: "$r->email=$o->usuario->getEmail($c);$r->telefones=$o->usuario->getTelefones($c);$r->valor_comprado=$o->usuario->getValorComprado($c);$r->pontos=$o->usuario->getPontos($c);$r->logs=$o->usuario->getLogs($c)",
            sucesso: fn,
            falha: fn
        });
    }

    this.getAtividadeUsuario = function (usuario, intervalo, fn) {
        baseService($http, $q, {
            o: {usuario: usuario, intervalo: intervalo},
            query: "$r->pontos = $o->usuario->getAtividade($c,$o->intervalo)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getNumeroEmpresas = function (gerenciador, fn) {
        baseService($http, $q, {
            o: gerenciador,
            query: "$r->qtd=$o->getNumeroEmpresas($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getMaximoUsuariosOnline = function (gerenciador, fn) {
        baseService($http, $q, {
            o: gerenciador,
            query: "$r->qtd=$o->getMaximoUsuariosOnline($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getTempo_Usuarios = function (gerenciador, intervalo, fn) {
        baseService($http, $q, {
            o: {gerenciador: gerenciador, intervalo: intervalo},
            query: "$r->pontos=$o->gerenciador->getTempo_Usuarios($c,$o->intervalo)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getCount = function (filtro, fn, gerenciador) {
        baseService($http, $q, {
            o: {gerenciador: (typeof gerenciador === 'undefined') ? este.gerenciador : gerenciador, filtro: filtro},
            query: "$r->qtd=$o->gerenciador->getQuantidadeUsuariosAtivos($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getCountForaGruopo = function (filtro, fn, gerenciador) {
        baseService($http, $q, {
            o: {gerenciador: (typeof gerenciador === 'undefined') ? este.gerenciador : gerenciador, filtro: filtro},
            query: "$r->qtd=$o->gerenciador->getQuantidadeUsuariosAtivosForaGrupo($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x1, x2, filtro, ordem, fn, gerenciador) {
        baseService($http, $q, {
            o: {gerenciador: (typeof gerenciador === 'undefined') ? este.gerenciador : gerenciador, x1: x1, x2: x2, filtro: filtro, ordem: ordem},
            query: "$r->elementos=$o->gerenciador->getUsuariosAtivos($c,$o->x1,$o->x2,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('atividadeService', function ($http, $q) {
    this.sinal = function () {
        baseService($http, $q, {
            query: "$atv=new Atividade($usuario);$atv->merge($c)",
            sucesso: function (r) {},
            falha: function (r) {}
        }, null, false, true);
    }
    this.adcionarCarrinho = function (item) {
        baseService($http, $q, {
            o: {descricao: item.quantidade_comprada + " " + item.nome + " no carrinho"},
            query: "$atv=new Atividade($usuario);$atv->descricao=$o->descricao;$atv->pontos=1;$atv->tipo=Atividade::$ADCIONAR_CARRINHO;$atv->merge($c)",
            sucesso: function (r) {},
            falha: function (r) {}
        }, null, false, true);
    }
    this.cliqueComum = function (descricao) {
        baseService($http, $q, {
            o: {descricao: descricao},
            query: "$atv=new Atividade($usuario);$atv->descricao=$o->descricao;$atv->pontos=0.01;$atv->tipo=Atividade::$ITEM_MENU;$atv->merge($c)",
            sucesso: function (r) {},
            falha: function (r) {}
        }, null, false, true);
    }
    this.pesquisar = function (descricao) {
        baseService($http, $q, {
            o: {descricao: descricao},
            query: "$atv=new Atividade($usuario);$atv->descricao=$o->descricao;$atv->pontos=0.02;$atv->tipo=Atividade::$PESQUISAR;$atv->merge($c)",
            sucesso: function (r) {},
            falha: function (r) {}
        }, null, false, true);
    }
    this.produto = function (produto) {
        baseService($http, $q, {
            o: {descricao: produto.id},
            query: "$atv=new Atividade($usuario);$atv->descricao=$o->descricao;$atv->pontos=1;$atv->tipo=Atividade::$PRODUTO;$atv->merge($c)",
            sucesso: function (r) {},
            falha: function (r) {}
        }, true);
    }
})
rtc.service('bannerService', function ($http, $q) {
    this.empresa = null;
    var este = this;
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: {filtro: filtro, empresa: este.empresa},
            query: "$r->qtd=$o->empresa->getCountBanners($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x1, x2, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x1: x1, x2: x2, ordem: ordem, filtro: filtro, empresa: este.empresa},
            query: "$r->elementos=$o->empresa->getBanners($c,$o->x1,$o->x2,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getBanner = function (fn) {
        baseService($http, $q, {
            o: {empresa: este.empresa},
            query: "$r->banner=new Banner();$r->banner->empresa=$o->empresa",
            sucesso: fn,
            falha: fn
        });
    }
    this.getHTML = function (banner, fn) {
        baseService($http, $q, {
            o: {banner: banner, empresa: este.empresa},
            query: "$r->html=Utilidades::base64encode($o->banner->getHTML())",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('relatorioService', function ($http, $q) {
    this.getRelatorios = function (fn) {
        baseService($http, $q, {
            query: "$r->relatorios=Sistema::getRelatorios($empresa,$usuario)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getPdf = function (fn) {
        baseService($http, $q, {
            o: this.relatorio,
            query: "$r->pdf=$o->getPdf($c,$empresa)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getFilhos = function (item, fn) {
        baseService($http, $q, {
            o: item,
            query: "$r->filhos=$o->getFilhos($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.relatorio = null;
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: this.relatorio,
            query: "$r->qtd=$o->getCount($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getXsd = function (fn) {
        baseService($http, $q, {
            o: this.relatorio,
            query: "$r->arquivo=$o->getXsd($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x0: x0, x1: x1, relatorio: this.relatorio},
            query: "$r->elementos=$o->relatorio->getItens($c,$o->x0,$o->x1)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('expedienteService', function ($http, $q) {
    this.getExpediente = function (fn) {
        baseService($http, $q, {
            query: "$r->expediente=new Expediente()",
            sucesso: fn,
            falha: fn
        });
    }
    this.getExpedientes = function (usuario, fn) {
        baseService($http, $q, {
            o: {usuario: usuario},
            query: "$r->expedientes=$o->usuario->getExpedientes($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.setExpedientes = function (usuario, expedientes, fn) {
        baseService($http, $q, {
            o: {usuario: usuario, expedientes: expedientes},
            query: "$o->usuario->setExpedientes($c,$o->expedientes)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('ausenciaService', function ($http, $q) {
    this.getAusencia = function (fn) {
        baseService($http, $q, {
            query: "$r->ausencia=new Ausencia()",
            sucesso: fn,
            falha: fn
        });
    }
    this.getAusencias = function (usuario, fn) {
        baseService($http, $q, {
            o: {usuario: usuario},
            query: "$r->ausencias=$o->usuario->getAusencias($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.setAusencias = function (usuario, ausencias, fn) {
        baseService($http, $q, {
            o: {usuario: usuario, ausencias: ausencias},
            query: "$o->usuario->setAusencias($c,$o->ausencias)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('tipoTarefaService', function ($http, $q) {
    var este = this;
    this.empresa = null;
    this.getObservacaoPadrao = function (tarefa, fn) {
        baseService($http, $q, {
            o: tarefa,
            query: "$r->observacao=$o->tipo_tarefa->getObservacaoPadrao($o)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getTiposTarefaUsuario = function (fn) {
        baseService($http, $q, {
            query: "$r->tipos_tarefa=Sistema::getTiposTarefaUsuario($c,$usuario)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getTiposTarefa = function (fn) {
        if (this.empresa === null) {
            baseService($http, $q, {
                query: "$r->tipos_tarefa=$empresa->getTiposTarefa($c)",
                sucesso: fn,
                falha: fn
            });
        } else {
            baseService($http, $q, {
                o: {empresa: este.empresa},
                query: "$r->tipos_tarefa=$o->empresa->getTiposTarefa($c)",
                sucesso: fn,
                falha: fn
            });
        }
    }
    this.getTipoTarefa = function (fn) {
        if (este.empresa === null) {
            baseService($http, $q, {
                query: "$r->tipo_tarefa=new TipoTarefa();$r->tipo_tarefa->empresa=$empresa",
                sucesso: fn,
                falha: fn
            });
        } else {
            baseService($http, $q, {
                o: este.empresa,
                query: "$r->tipo_tarefa=new TipoTarefa();$r->tipo_tarefa->empresa=$o",
                sucesso: fn,
                falha: fn
            });
        }
    }
})
rtc.service('cargoService', function ($http, $q) {
    var este = this;
    this.empresa = null;
    this.getCargos = function (fn) {
        if (este.empresa === null) {
            baseService($http, $q, {
                query: "$r->cargos=$empresa->getCargos($c)",
                sucesso: fn,
                falha: fn
            });
        } else {
            baseService($http, $q, {
                o: este.empresa,
                query: "$r->cargos=$o->getCargos($c)",
                sucesso: fn,
                falha: fn
            });
        }
    }
    this.getCargo = function (fn) {
        if (este.empresa === null) {
            baseService($http, $q, {
                query: "$r->cargo=new Cargo();$r->cargo->empresa=$empresa",
                sucesso: fn,
                falha: fn
            });
        } else {
            baseService($http, $q, {
                o: este.empresa,
                query: "$r->cargo=new Cargo();$r->cargo->empresa=$o",
                sucesso: fn,
                falha: fn
            });
        }
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
rtc.service('encomendaParceiroService', function ($http, $q) {
    this.getElementos = function (x1, x2, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x1: x1, x2: x2, ordem: ordem, filtro: filtro},
            query: "$r->elementos=Sistema::getEncomendaParceiros($c);$op=new OpProdutos($r->elementos);$r->elementos=$op->filtrar($o->x1,$o->x2,$o->filtro,$o->ordem,-10);$r->qtd=$op->getLastQtd();$r->filtros=$op->getFiltrosPossiveis();$r->ordens=$op->getOrdensPossiveis()",
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
rtc.service('permissaoService', function ($http, $q) {
    var este = this;
    this.empresa = null;
    this.getPermissoes = function (fn) {
        if (este.empresa === null) {
            baseService($http, $q, {
                query: "$r->permissoes=Sistema::getPermissoes($empresa)",
                sucesso: fn,
                falha: fn
            });
        } else {
            baseService($http, $q, {
                o: este.empresa,
                query: "$r->permissoes=Sistema::getPermissoes($o)",
                sucesso: fn,
                falha: fn
            });
        }
    }
})

rtc.service('relacaoClienteService', function ($http, $q) {
    this.getAtividadeUsuarioClienteAtual = function (fn) {
        baseService($http, $q, {
            query: "$r->atividade=$usuario->getAtividadeUsuarioClienteAtual($c)",
            sucesso: fn,
            falha: fn
        });

    }
    this.getContato = function (fn) {
        baseService($http, $q, {
            query: "$r->contato=new Contato()",
            sucesso: fn,
            falha: fn
        });
    }
    this.getContatos = function (relacao, fn) {
        baseService($http, $q, {
            o: relacao,
            query: "$r->contatos=$o->getContatos($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: {filtro: filtro},
            query: "$r->qtd=$usuario->getCountClientes($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });

    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
            query: "$r->elementos=$usuario->getClientes($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });

    }
})

rtc.service('usuarioService', function ($http, $q) {
    var este = this;
    this.empresa = null;
    this.filtro_base = "";

    this.getRTC = function (fn) {
        baseService($http, $q, {
            query: "$r->rtc=$empresa->getRTC($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getTarefasSolicitadas = function (fn) {
        baseService($http, $q, {
            query: "$r->tarefas=$usuario->getTarefasSolicitadas($c)",
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
        if (this.filtro_base === "") {
            baseService($http, $q, {
                o: {filtro: filtro},
                query: "$r->qtd=$empresa->getCountUsuarios($c,$o->filtro)",
                sucesso: fn,
                falha: fn
            });
        } else {
            baseService($http, $q, {
                o: {filtro: filtro + (filtro !== "" ? "AND " : "") + this["filtro_base"] + " ", empresa: este.empresa},
                query: "$r->qtd=$o->empresa->getCountUsuarios($c,$o->filtro)",
                sucesso: fn,
                falha: fn
            });
        }
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        if (this.filtro_base === "") {
            baseService($http, $q, {
                o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
                query: "$r->elementos=$empresa->getUsuarios($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
                sucesso: fn,
                falha: fn
            });
        } else {
            baseService($http, $q, {
                o: {x0: x0, x1: x1, filtro: filtro + (filtro !== "" ? "AND " : "") + this["filtro_base"] + " ", ordem: ordem, empresa: este.empresa},
                query: "$r->elementos=$o->empresa->getUsuarios($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
                sucesso: fn,
                falha: fn
            });
        }
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
    this.setVisto = function (movimento, fn) {
        baseService($http, $q, {
            o: movimento,
            query: "$o->setVisto($c,$o->visto);",
            sucesso: fn,
            falha: fn
        });
    }
    this.corretorSaldo = function (movimento, fn) {
        baseService($http, $q, {
            o: movimento,
            query: "$o->corrigirSaldo($c);",
            sucesso: fn,
            falha: fn
        });
    }
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
    this.emitir = function (nota, fn) {
        baseService($http, $q, {
            o: nota,
            query: "$r->retorno_sefaz=$o->emitir($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.cancelar = function (nota, motivo, fn) {
        baseService($http, $q, {
            o: {nota: nota, motivo: motivo},
            query: "$r->retorno_sefaz=$o->nota->cancelar($c,$o->motivo)",
            sucesso: fn,
            falha: fn
        });
    }
    this.corrigir = function (nota, correcao, fn) {
        baseService($http, $q, {
            o: {nota: nota, correcao: correcao},
            query: "$r->retorno_sefaz=$o->nota->corrigir($c,$o->correcao)",
            sucesso: fn,
            falha: fn
        });
    }
    this.manifestar = function (nota, fn) {
        baseService($http, $q, {
            o: {nota: nota},
            query: "$r->retorno_sefaz=$o->nota->manifestar($c)",
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
rtc.service('movimentosFechamentoService', function ($http, $q) {
    var este = this;
    this.banco = null;
    this.getCount = function (filtro, fn) {
        if (este.banco === null)
            return;
        baseService($http, $q, {
            o: {filtro: filtro, banco: este.banco},
            query: "$r->qtd=$o->banco->getCountMovimentosFechamento($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        if (este.banco === null)
            return;
        baseService($http, $q, {
            o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem, banco: este.banco},
            query: "$r->elementos=$o->banco->getMovimentosFechamento($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('bancoService', function ($http, $q) {
    var este = this;
    this.empresa = null;
    this.getFechamento = function (banco, fn) {
        baseService($http, $q, {
            o: banco,
            query: "$r->fechamento=$o->getFechamento($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getRelatorioFechamento = function (banco, fn) {
        baseService($http, $q, {
            o: banco,
            query: "$r->relatorio=$o->getRelatorioMovimentosFechamento($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getBanco = function (fn) {
        if (este.empresa === null) {
            baseService($http, $q, {
                query: "$r->banco=new Banco();$r->banco->empresa=$empresa",
                sucesso: fn,
                falha: fn
            });
        } else {
            baseService($http, $q, {
                o: este.empresa,
                query: "$r->banco=new Banco();$r->banco->empresa=$o",
                sucesso: fn,
                falha: fn
            });
        }
    }
    this.getCount = function (filtro, fn) {
        if (este.empresa === null) {
            baseService($http, $q, {
                o: {filtro: filtro},
                query: "$r->qtd=$empresa->getCountBancos($c,$o->filtro)",
                sucesso: fn,
                falha: fn
            });
        } else {
            baseService($http, $q, {
                o: {filtro: filtro, empresa: este.empresa},
                query: "$r->qtd=$o->empresa->getCountBancos($c,$o->filtro)",
                sucesso: fn,
                falha: fn
            });
        }
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        if (este.empresa === null) {
            baseService($http, $q, {
                o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
                query: "$r->elementos=$empresa->getBancos($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
                sucesso: fn,
                falha: fn
            });
        } else {
            baseService($http, $q, {
                o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem, empresa: este.empresa},
                query: "$r->elementos=$o->empresa->getBancos($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
                sucesso: fn,
                falha: fn
            });
        }
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

rtc.service('acompanharPedidoService', function ($http, $q) {
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
            query: "$r->qtd=Sistema::getCountPedidosAcompanhamento($c,$empresa,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
            query: "$r->elementos=Sistema::getPedidosAcompanhamento($c,$empresa,$o->x0,$o->x1,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });
    }
})

rtc.service('pedidoService', function ($http, $q) {
    this.getPedidoEspecifico = function (id_empresa, id_pedido, fn) {
        baseService($http, $q, {
            o: {id_empresa: id_empresa, id_pedido: id_pedido},
            query: "$e=new Empresa($o->id_empresa,$c);$r->pedido=$e->getPedidos($c,0,1,'pedido.id='.$o->id_pedido);$r->pedido=$r->pedido[0];$r->pedido->produtos=$r->pedido->getProdutos($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getPossibilidadesFreteIntermediario = function (pedido, fn) {
        var peso = 0;
        var valor = 0;
        for (var i = 0; i < pedido.produtos.length; i++) {
            var p = pedido.produtos[i];
            valor += p.quantidade * (p.valor_base + p.icms + p.ipi + p.frete + p.juros);
            peso += p.quantidade * p.produto.peso_bruto;
        }
        baseService($http, $q, {
            o: {p: pedido, peso: peso, valor: valor},
            query: "$f = new CalculadorFreteIntermediario($c,$o->p->logistica!==null?$o->p->logistica:$o->p->empresa,$o->peso,$o->valor);$r->possibilidades=$f->getPossibilidadesFrete($o->p->cliente)",
            sucesso: fn,
            falha: fn
        });
    }
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
            query: "$r->elementos=$empresa->getPedidos($c,$o->x0,$o->x1,$o->filtro,$o->ordem);if(!$usuario->temPermissao(Sistema::P_ALTERAR_SEM_REVISAR()->m('C'))){foreach($r->elementos as $key=>$value){$value->revisar=true;}}",
            sucesso: fn,
            falha: fn
        });
    }
})

rtc.service('produtoEncomendaService', function ($http, $q) {
    this.getProdutoEncomenda = function (fn) {
        baseService($http, $q, {
            query: "$r->produto_encomenda=new ProdutoEncomenda()",
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
    this.empresa = null;
    var este = this;
    this.getCampanha = function (fn) {
        if (este.empresa === null) {
            baseService($http, $q, {
                query: "$r->campanha=new Campanha();$r->campanha->empresa=$empresa",
                sucesso: fn,
                falha: fn
            });
        } else {
            baseService($http, $q, {
                o: {empresa: este.empresa},
                query: "$r->campanha=new Campanha();$r->campanha->empresa=$o->empresa",
                sucesso: fn,
                falha: fn
            });
        }
    }
    this.getProdutoCampanha = function (fn) {
        if (este.empresa === null) {
            baseService($http, $q, {
                query: "$r->produto_campanha=new ProdutoCampanha()",
                sucesso: fn,
                falha: fn
            });
        } else {
            baseService($http, $q, {
                query: "$r->produto_campanha=new ProdutoCampanha()",
                sucesso: fn,
                falha: fn
            });
        }
    }
    this.getCount = function (filtro, fn) {
        if (este.empresa === null) {
            baseService($http, $q, {
                o: {filtro: filtro},
                query: "$r->qtd=$empresa->getCountCampanha($c,$o->filtro)",
                sucesso: fn,
                falha: fn
            });
        } else {
            baseService($http, $q, {
                o: {filtro: filtro, empresa: este.empresa},
                query: "$r->qtd=$o->empresa->getCountCampanha($c,$o->filtro)",
                sucesso: fn,
                falha: fn
            });
        }
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        if (este.empresa === null) {
            baseService($http, $q, {
                o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
                query: "$r->elementos=$empresa->getCampanhas($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
                sucesso: fn,
                falha: fn
            });
        } else {
            baseService($http, $q, {
                o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem, empresa: este.empresa},
                query: "$r->elementos=$o->empresa->getCampanhas($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
                sucesso: fn,
                falha: fn
            });
        }
    }
    this.getProdutosDia = function (dia, fn) {
        if (este.empresa === null) {
            baseService($http, $q, {
                o: {dia: dia},
                query: "$r->produtos=Sistema::getProdutosDoDia($c,$o->dia,5,$empresa)",
                sucesso: fn,
                falha: fn
            });
        } else {
            baseService($http, $q, {
                o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem, empresa: este.empresa},
                query: "$r->elementos=$o->empresa->getCampanhas($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
                sucesso: fn,
                falha: fn
            });
        }
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
            query: "if(isset($o->e)){$empresa=$o->e;}$r->fretes=array();$t=$empresa->getTransportadoras($c,0,$empresa->getCountTransportadoras($c,'transportadora.habilitada=true AND tabela.nome IS NOT NULL'),'transportadora.habilitada=true AND tabela.nome IS NOT NULL','');$valores=array();foreach($t as $key=>$tr){if($tr->tabela===null){continue;}if($tr->tabela->atende($o->p->cidade,$o->p->peso,$o->p->valor)){$f=new stdClass();$f->transportadora=$tr;$f->valor=$tr->tabela->valor($o->p->cidade,$o->p->peso,$o->p->valor);$r->fretes[]=$f;}}",
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
rtc.service('produtoAlocalService', function ($http, $q) {
    this.getCount = function (filtro, fn) {
        baseService($http, $q, {
            o: {filtro: filtro},
            query: "$r->qtd=$empresa->getCountProdutosAlocais($c,$o->filtro)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getElementos = function (x0, x1, filtro, ordem, fn) {
        baseService($http, $q, {
            o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem},
            query: "$r->elementos=$empresa->getProdutosAlocais($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
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
    this.getCategoriasProspeccao = function (cliente, fn) {
        baseService($http, $q, {
            o: cliente,
            query: "$r->categorias=$o->getCategoriasProspeccao($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.setCategoriasProspeccao = function (cliente, categorias, fn) {
        baseService($http, $q, {
            o: {cliente: cliente, categorias: categorias},
            query: "$o->cliente->setCategoriasProspeccao($c,$o->categorias)",
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
    this.getClienteEspecifico = function (id_empresa, id_cliente, fn) {
        baseService($http, $q, {
            o: {id_empresa: id_empresa, id_cliente: id_cliente},
            query: "$emp=new Empresa($o->id_empresa);$r->cliente=$emp->getClientes($c,0,1,'cliente.id='.$o->id_cliente,'');$r->cliente=$r->cliente[0];",
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
rtc.service('statusEncomendaService', function ($http, $q) {
    this.getStatus = function (fn) {
        baseService($http, $q, {
            query: "$r->status=Sistema::getStatusEncomenda()",
            sucesso: fn,
            falha: fn
        });
    }
    this.getStatusExcluido = function (fn) {
        baseService($http, $q, {
            query: "$r->status=Sistema::STATUS_ENCOMENDA_CANCELADA()",
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
            query: "$r->elementos=Sistema::getCategoriaProduto($empresa)",
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
    this.setMaisFotos = function (produto, fotos, fn) {
        baseService($http, $q, {
            o: {produto: produto, fotos: fotos},
            query: "$o->produto->setMaisFotos($c,$o->fotos)",
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
    this.remessaGetLotes = function (produtos, filtro, ordem, fn) {
        var ids = [];
        for (var i = 0; i < produtos.length; i++) {
            ids[ids.length] = produtos[i].id;
        }
        baseService($http, $q, {
            o: {produtos: ids, filtro: filtro, ordem: ordem},
            query: "$r->remessas=Sistema::getRemessasDeLote($c,$o->produtos,$o->filtro,$o->ordem)",
            sucesso: fn,
            falha: fn
        });
    }
    this.vencidos = false;
    this.remessaGetValidades = function (meses_validade_curta, produtos, fn) {
        this.remessaGetLotes(produtos, 'lote.quantidade_real>0 AND lote.validade>CURRENT_DATE', 'lote.validade', function (l) {

            for (var qq = 0; qq < produtos.length; qq++) {

                var produto = produtos[qq];

                if (!produto.sistema_lotes) {

                    if (produto.disponivel === 0) {
                        produto.validades = [];
                        continue;
                    }

                    var validade = {validade: 1000, quantidade: produto.disponivel, alem: false, limite: -1, valor: produto.valor_base, validades: []};
                    var atual = new Date().getTime();
                    for (var j = 0; j < produto.ofertas.length; j++) {

                        validade.valor = produto.ofertas[j].valor;
                        validade.limite = produto.ofertas[j].limite;
                        validade.restante = produto.ofertas[j].campanha.fim - atual;
                        validade.oferta = true;

                    }

                    produto.validades = [validade];

                    continue;

                }

                //==============================================

                var lotes = [];

                for (var i = 0; i < l.remessas.length; i++) {
                    if (l.remessas[i].id_produto === produto.id) {
                        lotes = l.remessas[i].lotes;
                        for (var j = 0; j < lotes.length; j++) {
                            lotes[j].produto = produto;
                        }
                    }
                }

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

                    validades[i].oferta = false;



                    for (var j = 0; j < produto.ofertas.length; j++) {

                        var is = validades[i].validade === produto.ofertas[j].validade;

                        if (!is) {

                            var diff1 = ((((((validades[i].validade - new Date().getTime()) / 1000) / 60) / 60) / 24) / 30);
                            var diff2 = ((((((produto.ofertas[j].validade - new Date().getTime()) / 1000) / 60) / 60) / 24) / 30);

                            is = diff1 > meses_validade_curta && diff2 > meses_validade_curta;

                        }

                        if (is) {

                            validades[i].valor = produto.ofertas[j].valor;
                            validades[i].limite = produto.ofertas[j].limite;
                            validades[i].oferta = true;
                            var atual = new Date().getTime();
                            validades[i].restante = produto.ofertas[j].campanha.fim - atual;

                            continue lbl;

                        }

                    }

                    validades[i].valor = produto.valor_base;
                    validades[i].limite = -1;

                }

                produto.validades = validades;

            }

            fn();

        })
    }
    this.getValidades = function (meses_validade_curta, produto, fn) {

        if (!produto.sistema_lotes) {

            if (produto.disponivel === 0) {
                produto.validades = [];
                return;
            }

            var validade = {validade: 1000, quantidade: produto.disponivel, alem: false, limite: -1, valor: produto.valor_base, validades: []};
            var atual = new Date().getTime();
            for (var j = 0; j < produto.ofertas.length; j++) {

                validade.valor = produto.ofertas[j].valor;
                validade.limite = produto.ofertas[j].limite;
                validade.restante = produto.ofertas[j].campanha.fim - atual;
                validade.oferta = true;


            }

            fn([validade]);
            return;

        }

        this.getLotes(produto, 'lote.quantidade_real>0 AND lote.validade>CURRENT_DATE', 'lote.validade', function (l) {

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

                validades[i].oferta = false;



                for (var j = 0; j < produto.ofertas.length; j++) {

                    var is = validades[i].validade === produto.ofertas[j].validade;

                    if (!is) {

                        var diff1 = ((((((validades[i].validade - new Date().getTime()) / 1000) / 60) / 60) / 24) / 30);
                        var diff2 = ((((((produto.ofertas[j].validade - new Date().getTime()) / 1000) / 60) / 60) / 24) / 30);

                        is = diff1 > meses_validade_curta && diff2 > meses_validade_curta;

                    }

                    if (is) {

                        validades[i].valor = produto.ofertas[j].valor;
                        validades[i].limite = produto.ofertas[j].limite;
                        validades[i].oferta = true;
                        var atual = new Date().getTime();
                        validades[i].restante = produto.ofertas[j].campanha.fim - atual;

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
            if (typeof this["filtro_base"] === 'undefined') {
                baseService($http, $q, {
                    o: {filtro: filtro, id_empresa: this["empresa"]},
                    query: "$e=new Empresa($o->id_empresa);$r->qtd=$e->getCountProdutos($c,$o->filtro)",
                    sucesso: fn,
                    falha: fn
                });
            } else {
                baseService($http, $q, {
                    o: {filtro: (filtro + (filtro !== "" ? "AND " : "") + this["filtro_base"] + " "), id_empresa: this["empresa"]},
                    query: "$e=new Empresa($o->id_empresa);$r->qtd=$e->getCountProdutos($c,$o->filtro)",
                    sucesso: fn,
                    falha: fn
                });
            }
        }
    }
    this.getProdutosFiltro = function (filtro, fn) {
        baseService($http, $q, {
            o: {filtro:filtro},
            query: "$r->produtos=Sistema::getProdutos($c,0,5,$o->filtro,'produto.nome ASC')",
            sucesso: fn,
            falha: fn
        },null,true);
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
            if (typeof this["filtro_base"] === 'undefined') {
                baseService($http, $q, {
                    o: {x0: x0, x1: x1, filtro: filtro, ordem: ordem, id_empresa: this["empresa"]},
                    query: "$e=new Empresa($o->id_empresa);$r->elementos=$e->getProdutos($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
                    sucesso: fn,
                    falha: fn
                });
            } else {
                baseService($http, $q, {
                    o: {x0: x0, x1: x1, filtro: (filtro + (filtro !== "" ? "AND " : "") + this["filtro_base"] + " "), ordem: ordem, id_empresa: this["empresa"]},
                    query: "$e=new Empresa($o->id_empresa);$r->elementos=$e->getProdutos($c,$o->x0,$o->x1,$o->filtro,$o->ordem)",
                    sucesso: fn,
                    falha: fn
                });
            }
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
rtc.service('categoriaProspeccaoService', function ($http, $q) {
    this.getCategorias = function (fn) {
        baseService($http, $q, {
            query: "$r->categorias=Sistema::getCategoriasProspeccao($c)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('ativoService', function ($http, $q) {
    this.getAtivos = function (fn) {
        baseService($http, $q, {
            query: "$r->ativos=Sistema::getAtivos($c)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('fabricanteService', function ($http, $q) {
    this.getFabricantes = function (fn) {
        baseService($http, $q, {
            query: "$r->fabricantes=Sistema::getFabricantes($c)",
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
            query: "$u=Sistema::getUsuario(\"email_usu.endereco like '\".$o->email.\"%'\");if($u==null)throw new Exception('');$s=Sistema::getEmailSistema();Sistema::gerarSenha($u);$s->enviarEmail($u->email,'Recuperacao de Senha','Segue seus acessos: <hr> Login:'.$u->login.' <br> Senha: '.$u->senha)",
            sucesso: fn,
            falha: fn
        });
    }
})
rtc.service('sistemaService', function ($http, $q) {
    this.finalizarCompraParceiros = function (pedido, fn) {
        baseService($http, $q, {
            o: pedido,
            query: "Sistema::finalizarCompraParceiros($c,$o,$empresa);",
            sucesso: fn,
            falha: fn
        });
    }
    this.consignarProduto = function(produto,empresa,fn){
        baseService($http, $q, {
            o: {produto:produto,empresa:empresa},
            query: "Sistema::consignarProduto($c,$o->produto,$o->empresa);",
            sucesso: fn,
            falha: fn
        });
    }
    this.deconsignarProduto = function(produto,fn){
        baseService($http, $q, {
            o: {produto:produto},
            query: "Sistema::deconsignarProduto($c,$o->produto);",
            sucesso: fn,
            falha: fn
        });
    }
    this.addCarrinhoEncomendaCadastrando = function(produto,quantidade,fn){
        baseService($http, $q, {
            o: {produto:produto,quantidade:quantidade},
            query: "Sistema::addCarrinhoEncomendaCadastrando($c,$o->produto,$o->quantidade,$empresa);",
            sucesso: fn,
            falha: fn
        });
    }
    this.finalizarEncomendaParceiros = function (pedido, fn) {
        baseService($http, $q, {
            o: pedido,
            query: "Sistema::finalizarEncomendaParceiros($c,$o,$empresa);",
            sucesso: fn,
            falha: fn
        });
    }
    this.finalizarSeparacao = function (pedido, fn) {
        baseService($http, $q, {
            o: {pedido: pedido},
            query: "Sistema::finalizarSeparacao($c,$o->pedido,$usuario);",
            sucesso: fn,
            falha: fn
        });
    }
    this.gerarRelatorioSeparacao = function (pedido, itens, fn) {
        baseService($http, $q, {
            o: {pedido: pedido, itens: itens},
            query: "$r->relatorio=Sistema::relatorioSeparacao($c,$empresa,$o->itens,$o->pedido);",
            sucesso: fn,
            falha: fn
        });
    }
    this.popularEnderecamento = function (itens, fn) {
        baseService($http, $q, {
            o: itens,
            query: "$r->itens=Sistema::popularEnderecamento($c,$o);",
            sucesso: fn,
            falha: fn
        });
    }
    this.setLimiteCredito = function (valor, id_cliente, id_empresa, id_pedido, fn) {
        baseService($http, $q, {
            o: {valor: valor, id_cliente: id_cliente, id_empresa: id_empresa, id_pedido: id_pedido},
            query: "Sistema::setLimiteCredito($o->valor,$o->id_cliente,$o->id_empresa,$usuario,$o->id_pedido);",
            sucesso: fn,
            falha: fn
        });
    }
    this.aoCadastrarCliente = function (cliente, fn) {
        baseService($http, $q, {
            o: cliente,
            query: "Sistema::aoCadastrarCliente($usuario,$o);",
            sucesso: fn,
            falha: fn
        });
    }
    this.aoAlterarCliente = function (cliente, fn) {
        baseService($http, $q, {
            o: cliente,
            query: "Sistema::aoAlterarCliente($usuario,$o);",
            sucesso: fn,
            falha: fn
        });
    }
    this.inserirClienteRTC = function (cliente, fn) {
        baseService($http, $q, {
            o: cliente,
            query: "Sistema::inserirClienteRTC($c,$o)",
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
    this.getClienteCadastro = function (parametro, fn) {
        baseService($http, $q, {
            o: {parametro: parametro},
            query: "$r->clientes=Sistema::getClienteCadastro($c,$o->parametro)",
            sucesso: fn,
            falha: fn
        }, null, true);
    }
    this.getMarketings = function (fn) {
        baseService($http, $q, {
            query: "$r->marketings=Sistema::getMarketings($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getAdms = function (fn) {
        baseService($http, $q, {
            query: "$r->adms=Sistema::getAdms($c)",
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
    this.setMarketing = function (empresa, mkt, fn) {
        baseService($http, $q, {
            o: {empresa: empresa, mkt: mkt},
            query: "$o->empresa->setMarketing($c,$o->mkt)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getVirtuais = function (fn) {
        baseService($http, $q, {
            query: "$r->virtuais=Sistema::getEmpresas($c,'empresa.tipo_empresa=3')",
            sucesso: fn,
            falha: fn
        });
    }
    this.getMarketing = function (empresa, fn) {
        baseService($http, $q, {
            o: empresa,
            query: "$r->marketing=$o->getMarketing($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.setAdm = function (empresa, adm, fn) {
        baseService($http, $q, {
            o: {empresa: empresa, adm: adm},
            query: "$o->empresa->setAdm($c,$o->adm)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getAdm = function (empresa, fn) {
        baseService($http, $q, {
            o: empresa,
            query: "$r->adm=$o->getAdm($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getEmpresasClientes = function (fn) {
        baseService($http, $q, {
            query: "$r->clientes=$empresa->getEmpresasClientes($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getGrupoEmpresarial = function (fn) {
        baseService($http, $q, {
            query: "$grupo=$empresa->getFiliais($c);$r->grupo=array($empresa);foreach($grupo as $key=>$value){$r->grupo[]=$value;}",
            sucesso: fn,
            falha: fn
        });
    }
    this.getFiliais = function (fn) {
        baseService($http, $q, {
            query: "$r->filiais=$empresa->getFiliais($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getParametrosEmissao = function (empresa, fn) {
        baseService($http, $q, {
            o: empresa,
            query: "$r->parametros_emissao = $o->getParametrosEmissao($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.setParametrosEmissao = function (pe, fn) {
        baseService($http, $q, {
            o: pe,
            query: "$o->merge($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getStatusParametroEmissao = function (pe, fn) {
        baseService($http, $q, {
            o: pe,
            query: "$r->status=$o->getStatus($c)",
            sucesso: fn,
            falha: fn
        });
    }
    this.setEmpresa = function (empresa, fn) {
        baseService($http, $q, {
            o: empresa,
            query: "$r->usuario=Sistema::getUsuario(\"usuario.cpf='\".$usuario->cpf->valor.\"' AND usuario.id_empresa=$o->id\");$r->aceito=$r->usuario!==null",
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
rtc.service('carrinhoEncomendaService', function ($http, $q) {
    this.getCarrinho = function (fn) {
        baseService($http, $q, {
            query: "$car=$ses->get('carrinho_encomenda');if($car===null){$car=array();$ses->set('carrinho_encomenda',$car);};$r->carrinho=$car",
            sucesso: fn,
            falha: fn
        });
    }
    this.setCarrinho = function (carrinho, fn) {
        baseService($http, $q, {
            o: {carrinho: carrinho},
            query: "$ses->set('carrinho_encomenda',$o->carrinho)",
            sucesso: fn,
            falha: fn
        });
    }
    this.getEncomendasResultantes = function (fn) {
        baseService($http, $q, {
            query: "$car=$ses->get('carrinho_encomenda');if($car===null){$car=array();$ses->set('carrinho_encomenda',$car);};$r->encomendas=Sistema::getEncomendasResultantes($c,$car,$empresa,$usuario)",
            sucesso: fn,
            falha: fn
        });
    }
})
