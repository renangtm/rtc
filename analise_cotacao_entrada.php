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

    <body ng-controller="crtAnaliseCotacao">
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
                                    <h2 class="pageheader-title">Analise Cotacao</h2>
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
                                            <hr><br>
                                            <table id="pedidos" class="table table-striped table-bordered first">
                                                <thead>
                                                    <tr>
                                                        <th>Produto</th>
                                                        <th>Qtd</th>
                                                        <th>Atual (R$)</th>
                                                        <th>Min (R$)</th>
                                                        <th>Max (R$)</th>
                                                        <th>Media Ponderada (R$)</th>
                                                        <th>Ultima Cotacao</th>
                                                        <th>Forn.</th>
                                                        <th>Aprovar &nbsp <i class="fas fa-check"></i></th>
                                                        <th>Campanha &nbsp <i class="fas fa-anchor"></i></th>
                                                        <th>Recusar &nbsp <i class="fas fa-times"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="analise in analises.elementos" style="{{(analise[0].valor===analise[0].custo_atual)?'background-color:LightBlue;color:#000000':''}}">
                                                        <td>{{analise[0].nome_produto}}</td>
                                                        <td>{{analise[0].quantidade_produto}}</td>
                                                        <td style="{{analise[0].valor===analise[0].custo_atual?'color:Green':''}}">{{analise[0].custo_atual.toFixed(2)}} R$</td>
                                                        <td style="color:Green">{{analise[0].valor_minimo.toFixed(2)}} R$</td>
                                                        <td style="color:Red">{{analise[0].valor_maximo.toFixed(2)}} R$</td>
                                                        <td style="color:steelblue"><input type="number" class="form-control" style="width:100px;display: inline;color:steelblue;font-weight: bold;text-decoration: underline" step="0.01" ng-model="analise[0].valor">&nbsp<strong style="display: inline">R$</strong></td>
                                                        <td>{{analise[0].data| data}} - <strong style="color:blueviolet">{{analise[0].ultimo_custo.toFixed(2)}} R$</strong></td>
                                                        <td style="font-size:12px">{{analise[0].nome_fornecedor.substring(0,10)}}...</td>
                                                        <td>
                                                            <button class="btn btn-success" ng-if="analise[0].valor!==analise[0].custo_atual" style="display: inline" ng-click="aprovar(analise[0])"><i class="fas fa-check"></i></button>
                                                            <button class="btn btn-outline-primary" ng-if="analise[0].valor===analise[0].custo_atual" style="display: inline" ng-click="passar(analise[0])"><i class="fas fa-arrow-right"></i></button>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-outline-success" style="display: inline" ng-click="campanha(analise[0])"><i class="fas fa-certificate"></i></button><input min="1" style="display: inline;width:70px;margin-left:5px" type="number" placeholder="Dias Campanha" ng-model="analise[0].dias_campanha" class="form-control">
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-danger" ng-click="recusar(analise[0])">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination justify-content-end">
                                                        <li class="page-item" ng-repeat="pg in analises.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid':''}}">{{pg.numero + 1}}</a></li>
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

                <!-- /.modal-content --> 

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
