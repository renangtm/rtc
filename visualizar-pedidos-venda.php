<html lang="en" ng-app="appRtc">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">

        <script src="js/angular.min.js"></script>
        <script src="js/rtc.js"></script>
        <script src="js/filters.js"></script>
        <script src="js/services.js"></script>
        <script src="js/controllers.js"></script>    

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
        <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/libs/css/style.css">
        <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/dataTables.bootstrap4.css">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/buttons.bootstrap4.css">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/select.bootstrap4.css">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/fixedHeader.bootstrap4.css">        <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">-->
        <title>RTC (Reltrab Cliente) - WEB</title>

    </head>

    <body ng-controller="crtPedidos">
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
                                    <h2 class="pageheader-title">Pedidos de Venda</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Pedidos</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Pedidos de Venda</li>
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
                                                <a href="#" class="btn btn-primary" data-title="AddCompra" ng-click="novoPedido()" data-toggle="modal" data-target="#editCompra" ><i class="fas fa-plus-circle m-r-10"></i>Cadastrar Pedido de Venda</a>
                                            </div>
                                            <hr><br>
                                            <table id="pedidos" class="table table-striped table-bordered first">
                                                <thead>
                                                    <tr>
                                                        <th data-ordem="pedido.id">Cod.</th>
                                                        <th data-ordem="pedido.cliente.razao_social">Cliente</th>
                                                        <th data-ordem="pedido.data">Data</th>
                                                        <th data-ordem="pedido.frete">frete</th>
                                                        <th data-ordem="pedido.id_status">Status</th>
                                                        <th data-ordem="pedido.usuario.nome">Vendedor</th>
                                                        <th>Acao</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="pedid in pedidos.elementos">
                                                        <td>{{pedid[0].id}}</td>
                                                        <td>{{pedid[0].cliente.razao_social}}</td>
                                                        <td>{{pedid[0].data| data}}</td>
                                                        <td>{{pedid[0].frete}}</td>
                                                        <td>{{pedid[0].status.nome}}</td>
                                                        <td>{{pedid[0].usuario.nome}}</td>
                                                        <th>
                                                            <div class="product-btn">
                                                                <a href="#" class="btn btn-outline-light btnvis" data-title="vizPedido" ng-click="setPedido(pedid[0])" data-toggle="modal" data-target="#vizPedido"><i class="fas fa-eye"></i></a>
                                                                <a href="#" class="btn btn-outline-light btnedit" data-title="Edit" ng-click="setPedido(pedid[0])" data-toggle="modal" data-target="#editCompra"><i class="fas fa-pencil-alt"></i></a>
                                                                <a href="#" class="btn btn-outline-light btndel" data-title="Delete" ng-click="setPedido(pedid[0])" data-toggle="modal" data-target="#delete"><i class="fas fa-trash-alt"></i></a>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                <tfoot>
                                                    <tr>
                                                        <th>Cod.</th>
                                                        <th>Cliente</th>
                                                        <th>Data</th>
                                                        <th>frete</th>
                                                        <th>Status</th>
                                                        <th>Vendedor</th>
                                                        <th>Acao</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination justify-content-end">
                                                        <li class="page-item" ng-click="pedidos.prev()"><a class="page-link" href="">Anterior</a></li>
                                                        <li class="page-item" ng-repeat="pg in pedidos.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid':''}}">{{pg.numero + 1}}</a></li>
                                                        <li class="page-item" ng-click="pedidos.next()"><a class="page-link" href="">Proximo</a></li>
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
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-pencil-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Configure os dados de seu Pedido de Venda ({{pedido.id}})</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label for="">Cliente</label>
                                        <div class="form-row">
                                            <div class="col-2">
                                                <input type="text" ng-model="pedido.cliente.id" class="form-control" placeholder="Cod." value="9" disabled>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" ng-model="pedido.cliente.razao_social" class="form-control" placeholder="Nome do cliente" value="" disabled="">
                                            </div>
                                            <div class="col">
                                                <a href="#" class="btn btn-outline-light btnedit" data-toggle="modal" data-target="#clientes" ng-disabled="!pedido.status.altera"><i class="fas fa-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label for="">Logistica</label>
                                        <div class="form-row">
                                            <select ng-model="pedido.logistica" style="width:40%" class="form-control" ng-change="resetarPedido()" ng-disabled="!pedido.status.altera">
                                                <option ng-repeat="l in logisticas" ng-value="l">{{l.nome}}</option>
                                            </select>
                                        </div>
                                        <div ng-if="pedido.logistica===null" style="color:SteelBlue">
                                            Pedido normal feito com estoque da <?php echo $empresa->nome; ?>
                                        </div>
                                        <div ng-if="pedido.logistica!==null" style="color:Orange">
                                            Pedido feito por meio do {{pedido.logistica.nome}}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label for="">Transportadora</label>
                                        <div class="form-row">
                                            <div class="col-2">
                                                <input type="text" class="form-control" placeholder="Cod." ng-model="pedido.transportadora.id" disabled>
                                            </div>
                                            <div class="col-5">
                                                <input type="text" class="form-control" ng-model="pedido.transportadora.razao_social" placeholder="Nome da Transportadora" disabled>
                                            </div>
                                            <div class="col">
                                                <a href="#" class="btn btn-outline-light btnedit" data-toggle="modal" data-target="#transportadoras" ng-disabled="!pedido.status.altera"><i class="fas fa-search"></i></a>
                                            </div>
                                            <div class="form-inline col-4">
                                                <label for="" style="margin-left: 25px;margin-right: 10px;">Frete R$</label>
                                                <input type="text" class="form-control col-3" placeholder="0.0" ng-model="pedido.frete" ng-confirm="atualizaCustos()" ng-disabled="!pedido.status.altera">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-row">

                                        <div class="col-9">
                                            <div class="form-group">
                                                <label for="">Observações</label>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <textarea class="form-control" rows="2" id="comment" ng-model="pedido.observacao" ng-disabled="!pedido.status.altera"></textarea>
                                                    </div>
                                                </div>

                                            </div>			
                                        </div>
                                        <div class="col">
                                            <div class="form-group">

                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <br>
                                    <label for="">Produtos (tab para atualizar)</label>
                                    <table id="" class="table table-striped" width="90%">
                                        <thead>
                                            <tr>
                                                <th>Cod</th>
                                                <th>Nome</th>
                                                <th>Qtd.</th>
                                                <th class="text-center">Val</th>
                                                <th class="text-center">Vl.base</th>
                                                <th class="text-center">Juros</th>
                                                <th class="text-center">Frete</th>
                                                <th class="text-center">Icms</th>
                                                <th class="text-center">Ipi</th>
                                                <th class="text-center">Valor</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="prod in pedido.produtos">
                                                <td>{{prod.produto.id}}</td>
                                                <td>{{prod.produto.nome}}</td>
                                                <td class="text-center" width="100px">{{prod.quantidade}}</td>
                                                <td class="text-center">{{prod.validade_minima | data}}</td>
                                                <td class="text-center"><input ng-disabled="!pedido.status.altera" type=text ng-confirm="atualizaCustos()" class="form-control" ng-model="prod.valor_base"></td>
                                                <td class="text-center">{{prod.juros}}</td>
                                                <td class="text-center">{{prod.frete}}</td>
                                                <td class="text-center">{{prod.icms}}</td>
                                                <td class="text-center">{{prod.ipi}}</td>
                                                <td class="text-center">{{(prod.icms + prod.valor_base + prod.ipi + prod.frete + prod.juros).toFixed(2)}}</td>
                                                <td >
                                                    <div class="product-btn">
                                                        <a href="#" ng-disabled="!pedido.status.altera" class="btn btn-outline-light btndel" ng-click="removerProduto(prod)"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
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
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <div class="product-btn">
                                                        <a href="#" class="btn btn-outline-light btnaddprod" ng-disabled="!pedido.status.altera" ng-click="produtos.attList()" data-title="addproduto" data-toggle="modal" data-target="#produtos"><i class="fas fa-plus-circle"></i></a>
                                                    </div>
                                                </td>

                                            </tr>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="7" style="text-align:right;">VALOR TOTAL</th>
                                                <th colspan="3">R$ {{getTotalPedido().toFixed(2)}}</th>
                                            </tr>
                                        </tfoot>		
                                    </table>
                                    <hr>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="form-inline col-1">
                                                <label for="">Frete</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline" style="margin-top: 5px;">
                                                <input ng-disabled="!pedido.status.altera" type="radio" id="customRadioInline1" name="customRadioInline1" ng-value="true" ng-change="atualizaCustos()" ng-model="pedido.incluir_frete" class="custom-control-input" checked>
                                                <label class="custom-control-label" for="customRadioInline1">CIF</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline" style="margin-top: 5px;">
                                                <input ng-disabled="!pedido.status.altera" type="radio" id="customRadioInline2" name="customRadioInline1" ng-value="false" ng-change="atualizaCustos()" ng-model="pedido.incluir_frete" class="custom-control-input">
                                                <label class="custom-control-label" for="customRadioInline2">FOB</label>
                                            </div>
                                            <div class="form-inline col-3" style="margin-left: 40px;">
                                                <a href="#" ng-disabled="!pedido.status.altera" class="btn btn-primary" data-title="calcFrete" data-toggle="modal" ng-click="getFretes()" data-target="#calcFrete" ng-if="calculoPronto()">Calcular Frete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="form-inline" style="margin-right: 20px;">
                                                <label for="">Forma de pagamento</label>
                                            </div>
                                            <div class="form-inline">
                                                <label for="" style="margin-left: 25px;margin-right: 10px;">Prazo:</label>
                                                <input ng-disabled="!pedido.status.altera" type="number" class="form-control col-5" ng-model="pedido.prazo" ng-confirm="atualizaCustos()" placeholder="5" min="0" max="90" value="0">
                                            </div>
                                            <div class="form-inline">
                                                <label for="" style="margin-left: 25px;margin-right: 10px;">Parcelas:</label>
                                                <input ng-disabled="!pedido.status.altera" type="number" class="form-control col-5" ng-model="pedido.parcelas" ng-confirm="atualizaCustos()" placeholder="1" min="0" max="90" value="1">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="form-inline col-7">
                                                <label for="" style="margin-right: 20px;">Status</label>
                                                <select class="form-control col-7" id="status" ng-model="pedido.status" ng-disabled="pedido.status.parado">    
                                                    <option ng-value="status" ng-repeat="status in status_pedido" ng-disabled="!pedido.status.volta_status && status.id<pedido.status.id">{{status.nome}}</option>
                                                </select>
                                            </div>
                                            <div class="form-inline col-5">
                                                <label for="" style="margin-right: 20px;">Forma pagamento</label>
                                                <select ng-disabled="!pedido.status.altera" class="form-control col-7" id="ped" ng-model="pedido.forma_pagamento">    
                                                    <option ng-value="forma_pagamento" ng-repeat="forma_pagamento in formas_pagamento">{{forma_pagamento.nome}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>					
                                </form>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                                <button class="btn btn-primary" ng-click="mergePedido()" ng-disabled="pedido.status.parado">
                                    <i class="fas fa-save"></i> &nbsp; Salvar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content --> 				



                <!-- /.modal-content DELETE --> 
                <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-trash-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Delete os dados de seu Pedido</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center"> Tem certeza de que deseja excluir este Pedido?</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" ng-click="deletePedido()">Sim</button>
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
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-eye fa-3x"></i>&nbsp;&nbsp;&nbsp;Vizualizando Pedido</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body text-center">
                                <iframe id="myIframe" name="myIframe" frameborder="1" width="100%" height="300px" ng-src="visualizar-pedido-print.php"></iframe>
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
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Seleção de Cliente</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control" id="filtroClientes" placeholder="Filtro">
                                <hr>
                                <table class="table table-striped table-bordered first">
                                    <thead>
                                    <th data-ordem="cliente.id">Cod.</th>
                                    <th data-ordem="cliente.razao_social">Nome</th>
                                    <th>Selecionar</th>
                                    </thead>
                                    <tr ng-repeat="cli in clientes.elementos">
                                        <th>{{cli[0].id}}</th>
                                        <th>{{cli[0].razao_social}}</th>
                                        <th><button class="btn btn-success" ng-click="setCliente(cli[0])"><i class="fa fa-info"></i></button></th>
                                    </tr> 
                                </table>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item" ng-click="clientes.prev()"><a class="page-link" href="">Anterior</a></li>
                                            <li class="page-item" ng-repeat="pg in clientes.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></li>
                                            <li class="page-item" ng-click="clientes.next()"><a class="page-link" href="">Próximo</a></li>
                                        </ul>
                                    </nav>
                                </div>

                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content TRANSPORTADORAS --> 
                <div class="modal fade" id="transportadoras" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Seleção de Transporte</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control" id="filtroTransportadoras" placeholder="Filtro">
                                <hr>
                                <table class="table table-striped table-bordered first">
                                    <thead>
                                    <th data-ordem="transportadora.id">Cod.</th>
                                    <th data-ordem="transportadora.razao_social">Nome</th>
                                    <th>Selecionar</th>
                                    </thead>
                                    <tr ng-repeat="trans in transportadoras.elementos">
                                        <th>{{trans[0].id}}</th>
                                        <th>{{trans[0].razao_social}}</th>
                                        <th><button class="btn btn-success" ng-click="setTransportadora(trans[0])"><i class="fa fa-info"></i></button></th>
                                    </tr> 
                                </table>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item" ng-click="transportadoras.prev()"><a class="page-link" href="">Anterior</a></li>
                                            <li class="page-item" ng-repeat="pg in transportadoras.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></li>
                                            <li class="page-item" ng-click="transportadoras.next()"><a class="page-link" href="">Próximo</a></li>
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
                                <hr>
                                <table class="table table-striped table-bordered first">
                                    <thead>
                                    <th data-ordem="produto.id">Cod.</th>
                                    <th data-ordem="produto.nome">Produto</th>
                                    <th data-ordem="produto.disponivel">Disponivel</th>
                                    <th data-ordem="produto.valor_base">Valor</th>
                                    <th>Selecionar</th>
                                    </thead>
                                    <tr ng-repeat-start="produt in produtos.elementos">
                                        <th>{{produt[0].id}}</th>
                                        <th>{{produt[0].nome}}</th>
                                        <th>{{produt[0].disponivel}}</th>
                                        <th>{{produt[0].valor_base}}</th>
                                        <th><button class="btn btn-success" ng-click="setProduto(produt[0])" data-target="#demo{{produt[0].id}}" data-toggle="collapse" class="accordion-toggle"><i class="fa fa-info"></i></button></th>
                                    </tr>
                                    <tr ng-repeat-end>
                                        <td colspan="6" class="hiddenRow">
                                            <div class="accordian-body collapse" id="demo{{produt[0].id}}">
                                                <div class="row mx-auto m-b-30">
                                                    <div class="col">
                                                        <table class="table table-striped table-bordered first">
                                                            <thead>
                                                            <th>Validade</th>
                                                            <th>Quantidade</th>
                                                            <th>Valor</th>
                                                            <th>Selecionar</th>
                                                            </thead>
                                                            <tr ng-repeat="validade in produt[0].validades">
                                                                <th ng-if="validade.validade>0">{{validade.validade| data}} <i class="fas fa-arrow-up" ng-if="validade.alem" ></i> </th>
                                                                <th ng-if="validade.validade<0">-------</th>
                                                                <th>{{validade.quantidade}} <strong>{{validade.limite<0?'Sem limite':'Limite de '+validade.limite}}</strong></th>
                                                                <th>{{validade.valor}}</th>
                                                                <th><button class="btn btn-success" ng-click="addProduto(produt[0], validade)"><i class="fas fa-plus-circle"></i></button></th>
                                                            </tr>
                                                        </table>
                                                    </div>																	
                                                </div>	
                                            </div> 
                                        </td>
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
                <div class="modal fade" id="addproduto" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fa fa-fw fa-shopping-basket fa-3x"></i>&nbsp;&nbsp;&nbsp;Adicione o produto em seu pedido.</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <div id="custom-search" class="top-search-bar" style="padding-top:0px;padding-bottom:15px">
                                    <div class="form-group">
                                        <div class="icon-addon addon-sm">
                                            <input class="form-control" type="search" placeholder="Digite o que procura" aria-label="Search" size="80%">
                                            <label for="email" class="fa fa-search" rel="tooltip" title="email"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <table class="table table-striped" style="margin-bottom: 10px;">
                                        <thead>
                                            <tr style="border-top: 0px solid red;">

                                                <th colspan="2">Produto</th>
                                                <th class="text-center">Qtd.Est.</th>
                                                <th class="right">Preço</th>
                                                <th class="right"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>

                                                <td class="center" width="100px"><img src="http://www.faunasystem.com.br:8080/rtc/ENVIDOR-FRC-400ML.png" style="width: 80%;" class="product-image"></td>
                                                <td class="left">
                                                    <h3 class="product-title">Envidor (Frc 400ml)</h3>
                                                    <span class="product-val">val. 30 / 09 / 2021</span><br>
                                                    <span class="product-quant">1 p/ caixa</span>
                                                </td>
                                                <td class="text-center">4</td>
                                                <td class="right">R$ 116.99</td>
                                                <td class="text-center product">
                                                    <a href="#" class="btn btn-primary btnaddprod" title=""><i class="fas fa-plus-circle"></i></a>
                                                </td>
                                            </tr>
                                            <tr>

                                                <td class="center" width="100px"><img src="http://www.faunasystem.com.br:8080/rtc/ridomilgold1kg.png" style="width: 80%;" class="product-image"></td>
                                                <td class="left">
                                                    <h3 class="product-title">Ridomil Gold MZ (Pct 1kg)</h3>
                                                    <span class="product-val">val. 30 / 09 / 2021</span><br>
                                                    <span class="product-quant">1 p/ caixa</span>
                                                </td>
                                                <td class="text-center">4</td>
                                                <td class="right">R$ 116.99</td>
                                                <td class="text-center product">
                                                    <a href="#" class="btn btn-primary btnaddprod" title=""><i class="fas fa-plus-circle"></i></a>
                                                </td>
                                            </tr>
                                            <tr>

                                                <td class="center" width="100px"><img src="http://www.faunasystem.com.br:8080/rtc/ENVIDOR-FRC-400ML.png" style="width: 80%;" class="product-image"></td>
                                                <td class="left">
                                                    <h3 class="product-title">Envidor (Frc 400ml)</h3>
                                                    <span class="product-val">val. 30 / 09 / 2021</span><br>
                                                    <span class="product-quant">1 p/ caixa</span>
                                                </td>
                                                <td class="text-center">4</td>
                                                <td class="right">R$ 116.99</td>
                                                <td class="text-center product">
                                                    <a href="#" class="btn btn-primary btnaddprod" title=""><i class="fas fa-plus-circle"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content --> 

                <!-- /.modal-content CALCFRETE --> 
                <div class="modal fade" id="calcFrete" tcalculoProntoabindex="-1" role="dialog" aria-labelledby="calcFrete" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fa fa-fw fa-truck fa-3x"></i>&nbsp;&nbsp;&nbsp;Escolha o Frete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="custom-control custom-radio custom-control-inline" style="margin-top: 5px;" ng-repeat="frete in fretes">
                                            <input type="radio" id="customRadioInline3" ng-click="setFrete(frete)" name="customRadioInline1" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadioInline3">R$ {{frete.valor.toFixed(2)}} + ({{frete.transportadora.despacho}}) - {{frete.transportadora.razao_social}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="loading" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-wifi"></i>&nbsp;&nbsp;&nbsp;Aguarde</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body text-center">
                                
                                <span style="margin-top:30px;" class="dashboard-spinner spinner-success spinner-sm "></span>
                                <br>
                                <h3 style="margin-top:20px;">Carregando as informações...</h3>

                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>


                <!-- jquery 3.3.1 -->
                <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
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
                    
                    var sh = false;
                    var it = null;
                    
                    loading.show = function(){
                        if(it != null){
                            clearInterval(it);
                        }
                        if(!sh){
                            
                            sh = true;
                            $("#loading").modal("show");
                        
                        }
                        
                    }
                    
                    loading.close = function(){
                        
                        it = setTimeout(function(){
                                if(sh){
                                    sh = false;
                                    $("#loading").modal("hide");
                                }
                        },2000);
                        
                        
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