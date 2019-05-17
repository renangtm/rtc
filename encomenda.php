<html lang="en" ng-app="appRtc">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">

        <script src="js/angular.min.js"></script>
        <script src="js/rtc.js?125"></script>
        <script src="js/filters.js?125"></script>
        <script src="js/services.js?125"></script>
        <script src="js/controllers.js?125"></script>  <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>    

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

    <body ng-controller="crtEncomendas">
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
                                    <h2 class="pageheader-title">Encomendas</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Pedidos</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Encomendas</li>
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
                                                <a href="#" class="btn btn-primary" data-title="AddCompra" ng-click="novoEncomenda()" data-toggle="modal" data-target="#editCompra" ><i class="fas fa-plus-circle m-r-10"></i>Cadastrar Encomenda</a>
                                            </div>
                                            <hr><br>
                                            <table id="pedidos" class="table table-striped table-bordered first">
                                                <thead>
                                                    <tr>
                                                        <th width="70px" data-ordem="encomenda.id">Cod.</th>
                                                        <th data-ordem="encomenda.cliente.razao_social">Cliente</th>
                                                        <th data-ordem="encomenda.data">Data</th>
                                                        <th data-ordem="encomenda.id_status">Status</th>
                                                        <th width="105px" data-ordem="encomenda.usuario.nome">Vendedor</th>
                                                        <th width="180px">Acao</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="enc in encomendas.elementos">
                                                        <td>{{enc[0].id}}</td>
                                                        <td>{{enc[0].cliente.razao_social}}</td>
                                                        <td>{{enc[0].data| data}}</td>
                                                        <td>{{enc[0].status.nome}}</td>
                                                        <td>{{enc[0].usuario.nome}}</td>
                                                        <th>
                                                            <div class="product-btn">
                                                                <a href="#" class="btn btn-outline-light btnvis" data-title="vizPedido" ng-click="setEncomenda(enc[0])" data-toggle="modal" data-target="#vizPedido"><i class="fas fa-eye"></i></a>
                                                                <a href="#" class="btn btn-outline-light btnedit" data-title="Edit" ng-click="setEncomenda(enc[0])" data-toggle="modal" data-target="#editCompra"><i class="fas fa-pencil-alt"></i></a>
                                                                <a href="#" class="btn btn-outline-light btndel" data-title="Delete" ng-click="setEncomenda(enc[0])" data-toggle="modal" data-target="#delete"><i class="fas fa-trash-alt"></i></a>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                <tfoot>
                                                    <tr>
                                                        <th>Cod.</th>
                                                        <th>Cliente</th>
                                                        <th>Data</th>
                                                        <th>Status</th>
                                                        <th>Vendedor</th>
                                                        <th>Acao</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination justify-content-end">
                                                        <li class="page-item" ng-click="encomendas.prev()"><a class="page-link" href="">Anterior</a></li>
                                                        <li class="page-item" ng-repeat="pg in encomendas.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid':''}}">{{pg.numero + 1}}</a></li>
                                                        <li class="page-item" ng-click="encomendas.next()"><a class="page-link" href="">Proximo</a></li>
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
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-pencil-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Configure os dados de sua Encomenda ({{encomenda.id}})</h5>
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
                                                <input type="text" ng-model="encomenda.cliente.codigo" class="form-control" placeholder="Cod." value="9" disabled>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" ng-model="encomenda.cliente.razao_social" class="form-control" placeholder="Nome do cliente" value="" disabled="">
                                            </div>
                                            <div class="col">
                                                <a href="#" class="btn btn-outline-light btnedit" data-toggle="modal" ng-click="clientes.attList()" data-target="#clientes"><i class="fas fa-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-row">

                                        <div class="col-9">
                                            <div class="form-group">
                                                <label for="">Observacoes</label>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <textarea class="form-control" rows="2" id="comment" ng-model="encomenda.observacoes"></textarea>
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
                                                <th class="text-center">Vl Min</th>
                                                <th class="text-center">Vl Max</th>
                                                <th class="text-center">Juros</th>
                                                <th class="text-center">Icms</th>
                                                <th class="text-center">Ipi</th>
                                                <th class="text-center">Valor R$</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="prod in encomenda.produtos">
                                                <td class="text-center">{{prod.produto.codigo}}</td>
                                                <td>{{prod.produto.nome}}</td>
                                                <td class="text-center" width="100px">{{prod.quantidade}}</td>
                                                <td class="text-center"><input type="number" steep="0.01" ng-confirm="atualizaCustos()" class="form-control" ng-model="prod.valor_base_inicial"></td>
                                                <td class="text-center"><input type="number" steep="0.01" ng-confirm="atualizaCustos()" class="form-control" ng-model="prod.valor_base_final"></td>
                                                <td class="text-center">{{prod.juros_inicial}} - {{prod.juros_final}}</td>
                                                <td class="text-center">{{prod.icms_inicial}} - {{prod.icms_final}}</td>
                                                <td class="text-center">{{prod.ipi_inicial}} - {{prod.ipi_final}}</td>
                                                <td class="text-center">{{(prod.icms_inicial + prod.valor_base_inicial + prod.ipi_inicial + prod.juros_inicial).toFixed(2)}} - {{(prod.icms_final + prod.valor_base_final + prod.ipi_final + prod.juros_final).toFixed(2)}}</td>
                                                <td >
                                                    <div class="product-btn">
                                                        <a href="#" class="btn btn-outline-light btndel" ng-click="removerProduto(prod)"><i class="fas fa-trash-alt"></i></a>
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
                                                        <a href="#" class="btn btn-outline-light btnaddprod" ng-click="produtos.attList()" data-title="addproduto" data-toggle="modal" data-target="#produtos"><i class="fas fa-plus-circle"></i></a>
                                                    </div>
                                                </td>

                                            </tr>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="10" style="text-align:right;">Valor Total R$ {{getTotalInicial().toFixed(2)}} - {{getTotalFinal().toFixed(2)}}</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>		
                                    </table>
                                    <hr>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="form-inline col-7">
                                                <label for="" style="margin-right: 20px;">Status</label>
                                                <select class="form-control col" id="status" ng-model="encomenda.status" ng-disabled="encomenda.status.parado">    
                                                    <option ng-value="status" ng-repeat="status in status_encomenda">{{status.nome}}</option>
                                                </select>
                                            </div>
                                            <div class="form-inline col-3" style="">
                                                <a href="#" class="btn btn-outline-success" data-title="logs" data-toggle="modal" ng-click="getLogs()" data-target="#logs"><i class="fas fa-clipboard-list"></i>&nbsp;Logs da encomenda</a>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="form-inline col-7">
                                                Prazo: <input type="number" class="form-control" ng-model="encomenda.prazo" ng-confirm="atualizaCustos()" style="width:70px"> &nbsp
                                                Parcelas: <input type="number" class="form-control" ng-model="encomenda.parcelas" ng-confirm="atualizaCustos()" style="width:70px">
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                                <button class="btn btn-primary" ng-disabled="carregando" data-toggle="modal" data-target="#observacoes">
                                    <i class="fas fa-save"></i> &nbsp; Salvar. {{carregando?'Aguarde... Algumas operacoes podem demorar alguns segundos':''}}
                                </button>
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
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-address-book fa-3x"></i>&nbsp;&nbsp;&nbsp;Digite as observacoes desse status de encomenda caso haja alguma</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <textarea class="form-control" ng-model="encomenda.observacao_status"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" data-dismiss="modal" aria-label="Close" ng-disabled="carregando" ng-click="mergeEncomenda()">Prosseguir</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal" aria-label="Close">Fechar</button>
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
                                <p class="text-center"> Tem certeza de que deseja excluir esta Encomenda?</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" ng-disabled="carregando" ng-click="deletePedido()">Sim. {{carregando?'Aguarde... Pode demorar.':''}}</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Não</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="cobranca" tabindex="-1" role="dialog" aria-labelledby="vizPedido" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-money-bill-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Cobranca da encomenda</h5>
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
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-eye fa-3x"></i>&nbsp;&nbsp;&nbsp;Vizualizando Encomenda</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body text-center">
                                <iframe id="myIframe" name="myIframe" frameborder="1" width="100%" height="300px" ng-src="visualizar-encomenda.php"></iframe>
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
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Selecao de Cliente</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control" id="filtroClientes" placeholder="Filtro">
                                <hr>
                                <table class="table table-striped table-bordered first">
                                    <thead>
                                    <th data-ordem="cliente.codigo">Cod.</th>
                                    <th data-ordem="cliente.razao_social">Nome</th>
                                    <th>Estado</th>
                                    <th>Selecionar</th>
                                    </thead>
                                    <tr ng-repeat="cli in clientes.elementos">
                                        <th>{{cli[0].codigo}}</th>
                                        <th>{{cli[0].razao_social}}</th>
                                        <th>{{cli[0].endereco.cidade.estado.sigla}}</th>
                                        <th><button class="btn btn-success" ng-click="setCliente(cli[0])"><i class="fa fa-info"></i></button></th>
                                    </tr> 
                                </table>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item" ng-click="clientes.prev()"><a class="page-link" href="">Anterior</a></li>
                                            <li class="page-item" ng-repeat="pg in clientes.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></li>
                                            <li class="page-item" ng-click="clientes.next()"><a class="page-link" href="">Proximo</a></li>
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
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Selecao de Transporte</h5>
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
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Selecao de produtos</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control col-md-8" id="filtroProdutos" placeholder="Filtro">
                                <br>
                                Qtd: <input type="number" class="form-control" class="col-md-4" ng-model="qtd" placeholder="Quantidade" style="width:40%;margin-top:5px">
                                <br>
                                Valor Minimo: <input type="number" class="form-control" class="col-md-4" ng-model="valor_inicial" placeholder="Valor min" style="width:30%;margin-top:5px">
                                <br>
                                Valor Maximo: <input type="number" class="form-control" class="col-md-4" ng-model="valor_final" placeholder="Valor max" style="width:30%;margin-top:5px">
                                <hr>
                                <table class="table table-striped table-bordered first">
                                    <thead>
                                    <th data-ordem="produto.codigo">Cod.</th>
                                    <th data-ordem="produto.nome">Produto</th>
                                    <th data-ordem="produto.disponivel">Disponivel</th>
                                    <th data-ordem="produto.valor_base">Valor</th>
                                    <th data-ordem="produto.id_logistica">Armazem</th>
                                    <th>Selecionar</th>
                                    </thead>
                                    <tr ng-repeat="produt in produtos.elementos">
                                        <th>{{produt[0].codigo}}</th>
                                        <th>{{produt[0].nome}}</th>
                                        <th>{{produt[0].disponivel}}</th>
                                        <th>{{produt[0].valor_base}}</th>
                                        <th>{{produt[0].logistica===null?'Proprio':produt[0].logistica.nome}}</th>
                                        <th><button class="btn btn-success" ng-click="addProduto(produt[0])" data-target="#demo{{produt[0].id}}" data-toggle="collapse" class="accordion-toggle"><i class="fa fa-info"></i></button></th>
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