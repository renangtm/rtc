<html lang="en" ng-app="appRtc">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">

        <script src="js/angular.min.js"></script>
        <script src="js/rtc.js?3"></script>
        <script src="js/filters.js?3"></script>
        <script src="js/services.js?3"></script>
        <script src="js/controllers.js?3"></script>    

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

    <body ng-controller="crtAcompanharPedidos">
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
                                    <h2 class="pageheader-title">Acompanhamento de pedidos</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Pedidos</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Acompanhamento de Pedidos</li>
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
                                            <table id="pedidos" class="table table-striped table-bordered first">
                                                <thead>
                                                    <tr>
                                                        <th width="70px" data-ordem="pedido.id">Cod.</th>
                                                        <th data-ordem="pedido.empresa.nome">Empresa</th>
                                                        <th data-ordem="pedido.data">Data</th>
                                                        <th width="70px" data-ordem="pedido.frete">frete</th>
                                                        <th data-ordem="pedido.id_status">Status</th>
                                                        <th width="105px" data-ordem="pedido.usuario.nome">Usuario</th>
                                                        <th width="180px">Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="pedid in pedidos.elementos">
                                                        <td>{{pedid[0].id}}</td>
                                                        <td>{{pedid[0].empresa.nome}}</td>
                                                        <td>{{pedid[0].data| data}}</td>
                                                        <td>{{pedid[0].frete.toFixed(2)}}</td>
                                                        <td>{{pedid[0].status.nome}}</td>
                                                        <?php if ($usuario->temPermissao(Sistema::P_EMPRESA_PEDIDO()->m('C'))) { ?>
                                                            <th>{{pedid[0].empresa.nome}}</th>
                                                        <?php } ?>
                                                        <td>{{pedid[0].usuario.nome}}</td>
                                                        <th>
                                                            <div class="product-btn">
                                                                <a href="#" class="btn btn-outline-light btnedit" data-title="Edit" ng-click="setPedido(pedid[0])" data-toggle="modal" data-target="#editCompra"><i class="fas fa-eye"></i></a>
                                                                <a href="#" class="btn btn-outline-success" data-title="Logs" data-toggle="modal" ng-click="getLogsPedido(pedid[0])" data-target="#logs"><i class="fas fa-list-alt"></i></a>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                <tfoot>
                                                    <tr>
                                                        <th>Cod.</th>
                                                        <th>Empresa</th>
                                                        <th>Data</th>
                                                        <th>frete</th>
                                                        <th>Status</th>
                                                        <th>Usuario</th>
                                                        <th>Ação</th>
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
                                
                                <a href="#" style="position:absolute;top:5px;right:50px" class="btn btn-outline-success" data-title="logs" data-toggle="modal" ng-click="getLogs()" data-target="#logs"><i class="fas fa-clipboard-list"></i>&nbsp;Logs do pedido (Segunda via de boleto)</a>
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
                                                <input type="text" ng-model="pedido.cliente.codigo" class="form-control" placeholder="Cod." value="9" disabled>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" ng-model="pedido.cliente.razao_social" class="form-control" placeholder="Nome do cliente" value="" disabled="">
                                            </div>
                                            <div class="col">
                                                <a href="#" class="btn btn-outline-light btnedit" data-toggle="modal" ng-click="clientes.attList()" data-target="#clientes" ng-disabled="!pedido.status.altera" ng-if="pedido.empresa.id===<?php echo $empresa->id; ?>"><i class="fas fa-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label for="">Logistica</label>
                                        <div class="form-row">
                                                <select ng-model="pedido.logistica" style="width:40%" class="form-control" ng-change="resetarPedido()" ng-disabled="true">
                                                <option ng-repeat="l in logisticas" ng-value="l">{{l.nome}}</option>
                                            </select>
                                        </div>
                                        <div ng-if="pedido.logistica === null" style="color:SteelBlue">
                                            <div class="form-row" style="margin-top: 10px;">
                                                Pedido normal feito com estoque da {{pedido.empresa.nome}}
                                            </div>
                                        </div>
                                        <div ng-if="pedido.logistica !== null" style="color:Orange">
                                            <div class="form-row" style="margin-top: 10px;">
                                                Pedido feito por meio do {{pedido.logistica.nome}}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label for="">Transportadora</label>
                                        <div class="form-row">
                                            <div class="col-2">
                                                <input type="text" class="form-control" placeholder="Cod." ng-model="pedido.transportadora.codigo" disabled>
                                            </div>
                                            <div class="col-5">
                                                <input type="text" class="form-control" ng-model="pedido.transportadora.razao_social" placeholder="Nome da Transportadora" disabled>
                                            </div>
                                            <div class="col">
                                                <a href="#" class="btn btn-outline-light btnedit" data-toggle="modal" ng-click="transportadoras.attList()" data-target="#transportadoras" ng-disabled="true"><i class="fas fa-search"></i></a>
                                            </div>
                                            <div class="form-inline col-4">
                                                <label for="" style="margin-left: 25px;margin-right: 10px;">Frete R$</label>
                                                <input type="text" class="form-control col-3" placeholder="0.0" ng-model="pedido.frete" ng-confirm="atualizaCustos()" ng-disabled="true">
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
                                                        <textarea class="form-control" rows="2" id="comment" ng-model="pedido.observacoes" ng-disabled="true"></textarea>
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
                                                <th class="text-center">Qtd.</th>
                                                <th class="text-center">Val</th>
                                                <th class="text-center">Vl.base</th>
                                                <th class="text-center">Juros</th>
                                                <th class="text-center">Frete</th>
                                                <th class="text-center">Icms</th>
                                                <th class="text-center">Ipi</th>
                                                <th class="text-center">Valor R$</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="prod in pedido.produtos">
                                                <td class="text-center">{{prod.produto.codigo}}</td>
                                                <td>{{prod.produto.nome}}</td>
                                                <td class="text-center" width="100px">{{prod.quantidade}}</td>
                                                <td ng-if="prod.validade_minima > 0 && prod.validade_minima !== 1000" class="text-center">{{prod.validade_minima| data}}</td>
                                                <td ng-if="prod.validade_minima === 1000" class="text-center">-------</td>
                                                <td class="text-center">{{prod.valor_base}}</td>
                                                <td class="text-center">{{prod.juros}}</td>
                                                <td class="text-center">{{prod.frete}}</td>
                                                <td class="text-center">{{prod.icms}}</td>
                                                <td class="text-center">{{prod.ipi}}</td>
                                                <td class="text-center">{{(prod.icms + prod.valor_base + prod.ipi + prod.frete + prod.juros).toFixed(2)}}</td>
                                                <td >
                                                    <div class="product-btn">
                                                       
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
                                                <td></td>
                                                <td>
                                                   
                                                </td>

                                            </tr>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="10" style="text-align:right;">VALOR TOTAL R$ {{getTotalPedido().toFixed(2)}}</th>
                                                <th></th>
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
                                                <input ng-disabled="true" type="radio" id="customRadioInline1" name="customRadioInline1" ng-value="true" ng-change="atualizaCustos()" ng-model="pedido.frete_incluso" class="custom-control-input" checked>
                                                <label class="custom-control-label" for="customRadioInline1">CIF</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline" style="margin-top: 5px;">
                                                <input ng-disabled="true" type="radio" id="customRadioInline2" name="customRadioInline1" ng-value="false" ng-change="atualizaCustos()" ng-model="pedido.frete_incluso" class="custom-control-input">
                                                <label class="custom-control-label" for="customRadioInline2">FOB</label>
                                            </div>
                                            <div class="form-inline col-3" style="margin-left: 40px;">
                                                <a href="#" ng-disabled="true" class="btn btn-primary" data-title="calcFrete" data-toggle="modal" ng-click="getFretes()" data-target="#calcFrete" ng-if="calculoPronto()">Calcular Frete</a>
                                            </div>

                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="form-inline" style="margin-right: 20px;">
                                                <label for="">Forma de pagamento</label>
                                            </div>
                                            <div class="form-inline" style="margin-left: 40px;">
                                                    <select ng-disabled="true" class="form-control" id="ped" ng-model="pedido.forma_pagamento">    
                                                    <option ng-value="forma_pagamento" ng-repeat="forma_pagamento in formas_pagamento">{{forma_pagamento.nome}}</option>
                                                </select>
                                            </div>
                                            <div class="form-inline">
                                                <label for="" style="margin-left: 35px;margin-right: 10px;">Prazo:</label>
                                                <input ng-disabled="true" type="number" class="form-control col-5" ng-model="pedido.prazo" ng-confirm="atualizaCustos()" placeholder="5" min="0" max="90" value="0">
                                            </div>
                                            <div class="form-inline">
                                                <label for="" style="margin-left: 25px;margin-right: 10px;">Parcelas:</label>
                                                <input ng-disabled="true" type="number" class="form-control col-5" ng-model="pedido.parcelas" ng-confirm="atualizaCustos()" placeholder="1" min="0" max="90" value="1">
                                            </div>

                                        </div>
                                        <div class="form-row m-t-20">

                                        </div>

                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="form-inline col-7">
                                                <label for="" style="margin-right: 20px;">Status</label>
                                                <select class="form-control col" id="status" ng-model="pedido.status" ng-disabled="true">    
                                                    <option ng-value="status" ng-repeat="status in status_pedido" ng-disabled="!pedido.status.volta_status && status.id < pedido.status.id">{{status.nome}}</option>
                                                </select>
                                            </div>
                                            <div class="form-inline col-3" style="">
                                                
                                            </div>

                                        </div>
                                    </div>					
                                </form>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Sair</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content --> 				



                <!-- /.modal-content DELETE --> 
                <div class="modal fade" id="observacoes" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-address-book fa-3x"></i>&nbsp;&nbsp;&nbsp;Digite as observacoes desse status de pedido caso haja alguma</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <textarea class="form-control" ng-model="pedido.observacao_status"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" ng-click="mergePedido()">Prosseguir</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content --> 

                <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-trash-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Digite uma mensagem para enviar para o Cliente Juntamente ao Status</h5>
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

                <div class="modal fade" id="cobranca" tabindex="-1" role="dialog" aria-labelledby="vizPedido" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-money-bill-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Cobranca do pedido</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body text-center" id="retCob">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
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
                                    <th data-ordem="cliente.codigo">Cod.</th>
                                    <th data-ordem="cliente.razao_social">Nome</th>
                                    <th>Selecionar</th>
                                    </thead>
                                    <tr ng-repeat="cli in clientes.elementos">
                                        <th>{{cli[0].codigo}}</th>
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
                                    <th data-ordem="transportadora.codigo">Cod.</th>
                                    <th data-ordem="transportadora.razao_social">Nome</th>
                                    <th>Selecionar</th>
                                    </thead>
                                    <tr ng-repeat="trans in transportadoras.elementos">
                                        <th>{{trans[0].codigo}}</th>
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
                                    <th data-ordem="produto.codigo">Cod.</th>
                                    <th data-ordem="produto.nome">Produto</th>
                                    <th data-ordem="produto.disponivel">Disponivel</th>
                                    <th data-ordem="produto.valor_base">Valor</th>
                                    <th>Selecionar</th>
                                    </thead>
                                    <tr ng-repeat-start="produt in produtos.elementos">
                                        <th>{{produt[0].codigo}}</th>
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
                                                                <th ng-if="validade.validade > 0 && validade.validade !== 1000">{{validade.validade| data}} <i class="fas fa-arrow-up" ng-if="validade.alem" ></i> </th>
                                                                <th ng-if="validade.validade === 1000">-------</th>
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
                <div class="modal fade" id="logs" tcalculoProntoabindex="-1" role="dialog" aria-labelledby="logs" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-clipboard-list fa-3x"></i>&nbsp;&nbsp;&nbsp;Logs do pedido</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="custom-control custom-radio" style="margin-top: 5px;" id="shLogs">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                            <input type="radio" id="rdd{{frete.transportadora.codigo}}" ng-click="setFrete(frete)" name="customRadioInline1" class="custom-control-input">
                                            <label class="custom-control-label" for="rdd{{frete.transportadora.codigo}}">R$ {{frete.valor.toFixed(2)}} + ({{frete.transportadora.despacho}}) - {{frete.transportadora.razao_social}}</label>
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

                                                        $(document).ready(function () {
                                                            $(document).on({
                                                                'show.bs.modal': function () {
                                                                    var zIndex = 1040 + (10 * $('.modal:visible').length);
                                                                    $(this).css('z-index', zIndex);
                                                                    setTimeout(function () {
                                                                        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
                                                                    }, 0);
                                                                },
                                                                'hidden.bs.modal': function () {
                                                                    if ($('.modal:visible').length > 0) {
                                                                        // restore the modal-open class to the body element, so that scrolling works
                                                                        // properly after de-stacking a modal.
                                                                        setTimeout(function () {
                                                                            $(document.body).addClass('modal-open');
                                                                        }, 0);
                                                                    }
                                                                }
                                                            }, '.modal');
                                                        });
            </script>

    </body>

</html>