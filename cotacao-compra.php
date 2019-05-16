<html lang="en" ng-app="appRtc">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">

        <script src="js/angular.min.js"></script>
        <script src="js/rtc.js?5"></script>
        <script src="js/filters.js?5"></script>
        <script src="js/services.js?5"></script>
        <script src="js/controllers.js?5"></script>  <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>    

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
        <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/libs/css/style.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/dataTables.bootstrap4.css">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/buttons.bootstrap4.css">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/select.bootstrap4.css">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/fixedHeader.bootstrap4.css">        <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">-->
        <title>RTC (Reltrab Cliente) - WEB</title>

    </head>

    <body ng-controller="crtCotacoesEntrada">
        <!-- ============================================================== -->
        <!-- main wrapper -->
        <!-- ============================================================== -->
        <div class="dashboard-main-wrapper">
            <!-- ============================================================== -->
            <!-- navbar -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- end navbar -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- left sidebar -->
            <!-- ============================================================== -->
            <?php include("menu.php") ?>
            <!-- ============================================================== -->
            <!-- end left sidebar -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- wrapper  -->
            <!-- ============================================================== -->
            <div class="dashboard-wrapper">
                <div class="dashboard-ecommerce">
                    <div class="container-fluid dashboard-content ">
                        <!-- ============================================================== -->
                        <!-- pageheader  -->
                        <!-- ============================================================== -->
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="page-header">
                                    <h2 class="pageheader-title">Cotacoes de Compra</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Cotacoes</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Cotacoes de Compra</li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end pageheader  -->
                        <!-- ============================================================== -->
                        <div class="row">
                            <!-- ============================================================== -->
                            <!-- basic table  -->
                            <!-- ============================================================== -->
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <div class="product-btn m-b-20">
                                                <a href="#" class="btn btn-primary" data-title="AddCompra" ng-click="novoCotacao()" data-toggle="modal" data-target="#editCompra" ><i class="fas fa-plus-circle m-r-10"></i>Cadastrar Cotacao de Compra</a>
                                                <a href="#" class="btn btn-warning" data-title="AddCompra" ng-click="novaCotacaoGrupal()" data-toggle="modal" data-target="#cotacaoGrupal" ><i class="fas fa-sitemap m-r-10"></i>Cadastrar Cotacao Grupal de Compra</a>
                                            </div>
                                            <hr><br>
                                            <table id="cotacaoesGrupais" class="table table-striped table-bordered first">
                                                <thead>
                                                    <tr>
                                                        <th data-ordem="c.id">Cod.</th>
                                                        <th>Fornecedores</th>
                                                        <th>Data</th>
                                                        <th style="width:50px">Enviou Email</th>
                                                        <th>Respostas</th>
                                                        <th>Acoes</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="cot in cotacoesGrupais.elementos">
                                                        <td>{{cot[0].id}}</td>
                                                        <td>{{getFornecedores(cot[0])}}</td>
                                                        <td>{{cot[0].data| data}}</td>
                                                        <td style="width:50px"><i class="fas fa-circle fa-2x" style="color: {{cot[0].enviada?'Green':'Red'}}"></i></td>
                                                        <td style="{{(getQuantidadeRespostas(cot[0]) > 0) ? 'color:Green' : 'color:Red'}};font-weight: bold">{{getQuantidadeRespostas(cot[0]) === 0 ? "Ninguem respondeu" : getQuantidadeRespostas(cot[0]) + " resposta(s)"}}</td>
                                                        <th>
                                                            <div class="product-btn">
                                                                <a href="#" class="btn btn-outline-light btnedit" data-title="Edit" ng-click="setCotacaoGrupal(cot[0])" data-toggle="modal" data-target="#cotacaoGrupal"><i class="fas fa-pencil-alt"></i></a>
                                                                <a href="#" class="btn btn-outline-light btndel" data-title="Delete" ng-click="setCotacaoGrupal(cot[0])" data-toggle="modal" data-target="#delete"><i class="fas fa-trash-alt"></i></a>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Cod.</th>
                                                        <th>Fornecedores</th>
                                                        <th>Data</th>
                                                        <th>Enviou Email</th>
                                                        <th>Respostas</th>
                                                        <th>Acoes</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination justify-content-end">
                                                        <li class="page-item" ng-click="cotacoesGrupais.prev()"><a class="page-link" href="">Anterior</a></li>
                                                        <li class="page-item" ng-repeat="pg in cotacoesGrupais.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid':''}}">{{pg.numero + 1}}</a></li>
                                                        <li class="page-item" ng-click="cotacoesGrupais.next()"><a class="page-link" href="">Proximo</a></li>
                                                    </ul>
                                                </nav>
                                            </div>
                                            <hr>
                                            <table id="pedidos" class="table table-striped table-bordered first">
                                                <thead>
                                                    <tr>
                                                        <th data-ordem="cotacao_entrada.id">Cod.</th>
                                                        <th data-ordem="cotacao_entrada.fornecedor.nome">Fornecedor</th>
                                                        <th data-ordem="cotacao_entrada.id_status">Status</th>
                                                        <th data-ordem="cotacao_entrada.data">Data</th>
                                                        <th data-ordem="cotacao_entrada.usuario.nome">Usuario</th>
                                                        <th>Acao</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="pedid in cotacoes.elementos" style="{{pedid[0].recusada?'background-color:Red;color:#FFFFFF':''}}">
                                                        <td>{{pedid[0].id}}</td>
                                                        <td>{{pedid[0].fornecedor.nome}}</td>
                                                        <td style="{{pedid[0].status.id==2?'color:Green':''}}{{pedid[0].status.id==3?'color:Blue':''}}">{{pedid[0].status.nome}}</td>
                                                        <td>{{pedid[0].data| data}}</td>
                                                        <td>{{pedid[0].usuario.nome}}</td>
                                                        <th>
                                                            <div class="product-btn">
                                                                <a href="#" class="btn btn-outline-light btnvis" data-title="vizPedido" ng-click="setCotacao(pedid[0])" data-toggle="modal" data-target="#vizPedido"><i class="fas fa-eye"></i></a>
                                                                <a href="#" class="btn btn-outline-light btnedit" data-title="Edit" ng-click="setCotacao(pedid[0])" data-toggle="modal" data-target="#editCompra"><i class="fas fa-pencil-alt"></i></a>
                                                                <a href="#" class="btn btn-outline-light btndel" data-title="Delete" ng-click="setCotacao(pedid[0])" data-toggle="modal" data-target="#delete"><i class="fas fa-trash-alt"></i></a>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Cod.</th>
                                                        <th>Fornecedor</th>
                                                        <th>Status</th>
                                                        <th>Data</th>
                                                        <th>Usuario</th>
                                                        <th>Acao</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination justify-content-end">
                                                        <li class="page-item" ng-click="cotacoes.prev()"><a class="page-link" href="">Anterior</a></li>
                                                        <li class="page-item" ng-repeat="pg in cotacoes.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid':''}}">{{pg.numero + 1}}</a></li>
                                                        <li class="page-item" ng-click="cotacoes.next()"><a class="page-link" href="">Proximo</a></li>
                                                    </ul>
                                                </nav>
                                            </div>
                                            <!-- paginação  -->


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>	
                        <!-- ============================================================== -->
                        <!-- footer -->
                        <!-- ============================================================== -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="copyright">
                                    <p>Copyright © 2018 - Agro Fauna Tecnologia. Todos os direitos reservados.</p>
                                </div>
                            </div>
                        </div>

                        <!-- ============================================================== -->
                        <!-- end footer -->
                        <!-- ============================================================== -->
                    </div>
                    <!-- ============================================================== -->
                    <!-- end wrapper  -->
                    <!-- ============================================================== -->
                </div>
                <!-- ============================================================== -->
                <!-- end main wrapper  -->
                <!-- ============================================================== -->


                <!-- /.modal-content -->

                <!-- /.modal-content EDIT --> 
                <div class="modal fade in" id="editCompra" tabindex="-1" role="dialog" aria-labelledby="editCompra" aria-hidden="true" style="display: none;overflow-y:scroll">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-pencil-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Configure os dados de sua Cotacao de Compra ({{cotacao.id}})</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label for="">Fornecedor</label>
                                        <div class="form-row">
                                            <div class="col-2">
                                                <input type="text" ng-model="cotacao.fornecedor.codigo" class="form-control" placeholder="Cod." value="9" disabled>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" ng-model="cotacao.fornecedor.nome" class="form-control" placeholder="Nome do fornecedor" value="" disabled="">
                                            </div>
                                            <div class="col">
                                                <a href="#" class="btn btn-outline-light btnedit" data-toggle="modal" ng-click="fornecedores.attList()" data-target="#clientes"><i class="fas fa-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-row">			
                                        <div class="col">
                                            <div class="form-group">
                                                Observacoes:
                                                <textarea class="form-control" ng-model="cotacao.observacao"></textarea>
                                            </div>
                                            <br>
                                        </div>

                                    </div>
                                    <div class="form-row" style="position:relative;height:30px">			

                                        <input class="custom-control-input" id="chk1" style="display: inline-block;position:absolute;top:0px;left:5px" type="checkbox" ng-true-value="true" ng-false-value="false" ng-model="cotacao.tratar_em_litros">
                                        <label class="custom-control-label" style="cursor:pointer;" for="chk1"><strong style="position:absolute;top:0px;left:27px">Tratar em litros/kilos com o fornecedor ao inves de embalagem</strong></label>

                                    </div>
                                    <div class="form-row" style="position:relative;height:30px">			

                                        <input class="custom-control-input" id="chk2" style="display: inline-block;position:absolute;top:0px;left:5px" type="checkbox" ng-true-value="true" ng-false-value="false" ng-model="cotacao.enviar_email">
                                        <label class="custom-control-label" style="cursor:pointer;" for="chk2"><strong style="position:absolute;top:0px;left:27px">Enviar email</strong></label>

                                    </div>
                                    <hr>
                                    <br>
                                    <label for="">Produtos (tab para atualizar)</label>
                                    <table id="" class="table table-striped" width="90%">
                                        <thead>
                                            <tr>
                                                <th>Cod</th>
                                                <th>Nome</th>
                                                <th>Unidade</th>
                                                <th>Qtd.</th>
                                                <th>Valor</th>
                                                <th>Qtd Un.</th>
                                                <th>Valor da unidade</th>
                                                <th>Acao</th>
                                                <th>VP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="prod in cotacao.produtos" style="{{prod.recusado?'background-color:Red;color:#FFFFFF':''}}">
                                                <td>{{prod.produto.codigo}}</td>
                                                <td>{{prod.produto.nome}}</td>
                                                <td>{{prod.produto.unidade}} / {{prod.produto.quantidade_unidade}}</td>
                                                <td class="text-center" width="100px"><input type="number" ng-model="prod.quantidade" class="form-control"></td>
                                                <td class="text-center"><input type=text ng-keyup="attValor(prod)" class="form-control" ng-model="prod.valor"></td>
                                                <td>{{prod.quantidade * prod.produto.quantidade_unidade}}</td>
                                                <td class="text-center"><input type=text ng-keyup="attValorUnitario(prod)" class="form-control" ng-model="prod.valor_unitario"></td>
                                                <td >
                                                    <div class="product-btn">
                                                        <a href="#" class="btn btn-outline-light btndel" ng-click="removerProduto(prod)"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="checkbox" ng-model="prod.passar_pedido"></input>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <div class="product-btn">
                                                        <a href="#" class="btn btn-outline-light btnaddprod" ng-click="produtos.attList()" data-title="addproduto" data-toggle="modal" data-target="#produtos"><i class="fas fa-plus-circle"></i></a>
                                                    </div>
                                                </td>
                                                <td></td>
                                            </tr>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="7" style="text-align:right;">VALOR TOTAL</th>
                                                <th colspan="3">R$ {{getTotalCotacao().toFixed(2)}}</th>
                                            </tr>
                                        </tfoot>		
                                    </table>
                                    <hr>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="form-inline col-6" style="margin-left: 40px;">
                                                <a href="#" class="btn btn-primary" data-title="calcFrete" data-toggle="modal" ng-click="getFretes()" data-target="#calcFrete" ng-if="calculoPronto()">Simular Frete</a>
                                            </div>
                                            <div class="form-inline col-3" style="margin-left: 40px;">
                                                <a href="#" class="btn btn-primary" data-title="calcFrete" ng-click="formarPedido(transp)" ng-if="podeFormarPedido()">Formar Pedido</a>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="form-inline col-8">
                                                <label for="" style="margin-right: 20px;">Status</label>
                                                <select class="form-control col-7" id="status" ng-model="cotacao.status">    
                                                    <option ng-value="status" ng-repeat="status in status_cotacao">{{status.nome}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>	

                                </form>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                                <button class="btn btn-primary" ng-click="mergeCotacao()">
                                    <i class="fas fa-save"></i> &nbsp; Salvar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content --> 				

                <!-- /.modal-content TRANSPORTADORAS --> 

                <div class="modal fade in" id="cotacaoGrupal" tabindex="-1" role="dialog" aria-labelledby="cotacaoGrupal" aria-hidden="true" style="display: none;overflow-y:scroll">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-pencil-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Configure os dados de sua Cotacao Grupal de Compra ({{cotacaoGrupal.id}})</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <h4>Fornecedores</h4>
                                            <hr>
                                            <table class="table table-striped" style="width:75%">
                                                <thead>
                                                <th>Nome &nbsp <button data-toggle="modal" ng-click="fornecedores.attList()" data-target="#clientes" class="btn btn-success"><i class="fas fa-plus-circle"></i></button></th>
                                                <th>CNPJ</th>
                                                <th><i class="fas fa-trash"></i></th>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="f in cotacaoGrupal.fornecedores">
                                                        <td>{{f.nome}}</td>
                                                        <td>{{f.cnpj.valor}}</td>
                                                        <td><button class="btn btn-danger" ng-click="removeFornecedor(f)"><i class="fas fa-trash"></i></button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-row">			
                                        <div class="col">
                                            <div class="form-group">
                                                Observacoes:
                                                <textarea class="form-control" ng-model="cotacaoGrupal.observacoes" rows="8"></textarea>
                                            </div>
                                            <br>
                                        </div>

                                    </div>
                                    <div class="form-row" style="position:relative;height:30px">			
                                        <button ng-disabled="cotacaoGrupal.id === 0 || enviandoEmail" class="btn btn-warning" ng-click="enviarEmailsCotacaoGrupal()" ><i class="fas fa-server"></i>&nbsp Enviar email. {{enviandoEmail?'Aguarde os emails serem enviados, pode demorar um pouco...':''}}</button>
                                    </div>
                                    <hr>
                                    <br>
                                    <label for="">Produtos (tab para atualizar)</label>
                                    <table id="" class="table table-striped" width="90%">
                                        <thead>
                                            <tr>
                                                <th>Cod</th>
                                                <th>Nome</th>
                                                <th>Quantidade</th>
                                                <th>Unidade</th>
                                                <th>Remover</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat-start="prod in cotacaoGrupal.produtos">
                                                <td>{{prod.produto.codigo}}</td>
                                                <td>{{prod.produto.nome}}</td>
                                                <td>{{prod.quantidade}}</td>
                                                <td>{{prod.produto.unidade}} / {{prod.produto.quantidade_unidade}}</td>
                                                <td>
                                                    <div class="product-btn">
                                                        <a href="#" class="btn btn-outline-light btndel" ng-click="removerProduto(prod)"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr ng-repeat-end>
                                                <td colspan="5">
                                                    <div style='width:400px;height:70px;font-size:15px;margin-left:10px;margin-bottom: 10px;display: inline-block' class="label label-{{r.momento===0?'primary':'success'}}" ng-repeat="r in getRespostas(prod)">
                                                        <strong>{{r.fornecedor.nome}}</strong>
                                                        <hr>
                                                        <strong ng-if='r.momento === 0'><i class='fas fa-clock'></i>&nbsp Aguardando...</strong>
                                                        <strong ng-if='r.momento > 0 && r.quantidade>0'><i class='fas fa-check'></i>&nbsp {{r.valor.toFixed(2).split('.').join(',')}} R$, Qtd: {{r.quantidade}} as {{r.momento| data}}</strong>
                                                        <strong ng-if='r.momento > 0 && r.quantidade<=0'><i class='fas fa-times'></i>&nbsp Nao tem ou nao trabalha com esse produto</strong>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <div class="product-btn">
                                                        <a href="#" class="btn btn-outline-light btnaddprod" ng-click="produtos.attList()" data-title="addproduto" data-toggle="modal" data-target="#produtos"><i class="fas fa-plus-circle"></i></a>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3">{{getTotalCotacaoGrupal()}}</th>
                                            </tr>
                                        </tfoot>		
                                    </table>
                                    <hr>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="form-inline col-3" style="margin-left: 40px;">
                                                <a href="#" class="btn btn-primary" data-title="calcFrete" ng-click="formarPedido(transp)" ng-if="podeFormarPedido()">Formar Pedido</a>
                                            </div>
                                        </div>
                                    </div>	

                                </form>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                                <button class="btn btn-primary" ng-click="mergeCotacao()">
                                    <i class="fas fa-save"></i> &nbsp; Salvar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- /.modal-content DELETE --> 
                <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-trash-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Delete os dados de sua Cotacao</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center"> Tem certeza de que deseja excluir esta Cotacao?</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" ng-click="deleteCotacao()">Sim</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Não</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content --> 

                <!-- /.modal-content VISUALIZAR PEDIDO --> 
                <div class="modal fade" id="vizPedido" tabindex="-1" role="dialog" aria-labelledby="vizPedido" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-eye fa-3x"></i>&nbsp;&nbsp;&nbsp;Vizualizando Cotacao</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body text-center">
                                <iframe id="myIframe" name="myIframe" frameborder="1" width="100%" height="300px" ng-src="visualizar-cotacao-entrada.php"></iframe>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content --> 
                <!-- /.modal-content CLIENTE --> 
                <div class="modal fade" id="clientes" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Selecao de Fornecedores</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control" id="filtroFornecedores" placeholder="Filtro">
                                <hr>
                                <table class="table table-striped table-bordered first">
                                    <thead>
                                    <th data-ordem="fornecedor.codigo">Cod.</th>
                                    <th data-ordem="fornecedor.nome">Nome</th>
                                    <th>Estado</th>
                                    <th>Selecionar</th>
                                    </thead>
                                    <tr ng-repeat="f in fornecedores.elementos">
                                        <th>{{f[0].codigo}}</th>
                                        <th>{{f[0].nome}}</th>
                                        <th>{{f[0].endereco.cidade.estado.sigla}}</th>
                                        <th><button class="btn btn-success" ng-click="setFornecedor(f[0])"><i class="fa fa-info"></i></button></th>
                                    </tr> 
                                </table>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item" ng-click="fornecedores.prev()"><a class="page-link" href="">Anterior</a></li>
                                            <li class="page-item" ng-repeat="pg in fornecedores.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></li>
                                            <li class="page-item" ng-click="fornecedores.next()"><a class="page-link" href="">Próximo</a></li>
                                        </ul>
                                    </nav>
                                </div>

                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content PRODUTOS --> 
                <div class="modal fade" id="produtos" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Seleção de produtos</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control col-md-8" id="filtroProdutos" placeholder="Filtro">
                                <br>
                                Qtd: <input type="number" class="form-control" class="col-md-4" ng-model="qtd" placeholder="Quantidade" style="width:40%;margin-top:5px">
                                <br>
                                Valor (R$): <input type="number" class="form-control" class="col-md-4" ng-model="valor" placeholder="Valor" style="width:40%;margin-top:5px">
                                <hr>
                                <table class="table table-striped table-bordered first">
                                    <thead>
                                    <th data-ordem="produto.codigo">Cod.</th>
                                    <th data-ordem="produto.nome">Produto</th>
                                    <th data-ordem="produto.disponivel">Disponivel</th>
                                    <th data-ordem="produto.valor_base">Valor</th>
                                    <th>Selecionar</th>
                                    </thead>
                                    <tr ng-repeat="produt in produtos.elementos">
                                        <th>{{produt[0].codigo}}</th>
                                        <th>{{produt[0].nome}}</th>
                                        <th>{{produt[0].disponivel}}</th>
                                        <th>{{produt[0].valor_base}}</th>
                                        <th><button class="btn btn-success" ng-click="addProduto(produt[0])"><i class="fa fa-info"></i></button></th>
                                    </tr>
                                </table>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item" ng-click="produtos.prev()"><a class="page-link" href="">Anterior</a></li>
                                            <li class="page-item" ng-repeat="pg in produtos.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></li>
                                            <li class="page-item" ng-click="produtos.next()"><a class="page-link" href="">Próximo</a></li>
                                        </ul>
                                    </nav>
                                </div>

                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>




                <!-- /.modal-content ADDPRODUTO --> 

                <!-- /.modal-content --> 

                <!-- /.modal-content CALCFRETE --> 
                <div class="modal fade" id="calcFrete" tcalculoProntoabindex="-1" role="dialog" aria-labelledby="calcFrete" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fa fa-fw fa-truck fa-3x"></i>&nbsp;&nbsp;&nbsp;Veja o Frete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="custom-control custom-radio custom-control-inline" style="margin-top: 5px;" ng-repeat="frete in fretes">
                                            <label class="custom-control-label" for="customRadioInline3">R$ {{frete.valor.toFixed(2)}} - {{frete.transportadora.razao_social}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content LOADING --> 
            <span style="position:absolute;z-index:999999" id="loading" class="dashboard-spinner spinner-success spinner-sm "></span>

            <!-- jquery 3.3.1 -->
            
            <script src="assets/vendor/jquery/jquery.mask.min.js"></script>
            <script src="assets/libs/js/form-mask.js"></script>
            <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>

            <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
            <script src="assets/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
            <!-- slimscroll js -->
            <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
            <!-- main js -->
            <script src="assets/libs/js/main-js.js"></script>
            <!-- chart chartist js -->
            <script src="assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
            <!-- sparkline js -->
            <script src="assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
            <!-- morris js -->
            <script src="assets/vendor/charts/morris-bundle/raphael.min.js"></script>
            <script src="assets/vendor/charts/morris-bundle/morris.js"></script>
            <!-- chart c3 js -->
            <script src="assets/vendor/charts/c3charts/c3.min.js"></script>
            <script src="assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
            <script src="assets/vendor/charts/c3charts/C3chartjs.js"></script>
            <script src="assets/libs/js/dashboard-ecommerce.js"></script>
            <!-- parsley js -->
            <script src="assets/vendor/parsley/parsley.js"></script>

            <!-- Optional JavaScript -->
            <script>

                                                        var l = $('#loading');
                                                        l.hide();


                                                        var x = 0;
                                                        var y = 0;

                                                        $(document).mousemove(function (e) {

                                                            x = e.clientX;
                                                            y = e.clientY;

                                                            var s = $(this).scrollTop();

                                                            l.offset({top: (y + s), left: x});

                                                        })

                                                        var sh = false;
                                                        var it = null;

                                                        loading.show = function () {
                                                            l.show();
                                                            var s = $(document).scrollTop();

                                                            l.offset({top: (y + s), left: x});

                                                        }

                                                        loading.close = function () {
                                                            l.hide();
                                                        }

                                                        $(document).ready(function () {
                                                            $('.btnvis').tooltip({title: "Visualizar", placement: "top"});
                                                            $('.btnedit').tooltip({title: "Editar", placement: "top"});
                                                            $('.btndel').tooltip({title: "Deletar", placement: "top"});
                                                            $('.btnaddprod').tooltip({title: "Adicionar", placement: "top"});
                                                        });


            </script>

    </body>

</html>
