<!doctype html>
<html lang="en" ng-app="appRtc">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">

        <script src="js/angular.min.js"></script>
        <script src="js/rtc.js?4"></script>
        <script src="js/filters.js?4"></script>
        <script src="js/services.js?4"></script>
        <script src="js/controllers.js?4"></script>    

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
        <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/libs/css/style.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/dataTables.bootstrap4.css">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/buttons.bootstrap4.css">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/select.bootstrap4.css">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/fixedHeader.bootstrap4.css">
        <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">-->
        <title>RTC (Reltrab Cliente) - WEB</title>
        <style>
        </style>
    </head>

    <body ng-controller="crtProdutoClienteLogistic">
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
                                    <h2 class="pageheader-title">Produtos de clientes</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Produtos de Clientes</li>
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

                                            </div>
                                            <table id="clientes" class="table table-striped table-bordered first">
                                                <thead>
                                                    <tr>
                                                        <th data-ordem="produto.id_universal">Cod. Univ.</th>
                                                        <th data-ordem="produto.nome">Nome Produto</th>
                                                        <th data-ordem="produto.categoria.nome">Categoria</th>
                                                        <th ng-repeat="e in produtos.elementos[0][0].empresas">{{e}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="produto in produtos.elementos">
                                                        <td>{{produto[0].id}}</td>
                                                        <td>{{produto[0].nome}}</td>
                                                        <td>{{produto[0].categoria}}</td>
                                                        <td ng-repeat="i in to(produto[0].empresas.length)">
                                                            <table class="table table-bordered w-100">
                                                                <tr>
                                                                    <td style="text-align:center">
                                                                        Disp
                                                                    </td>
                                                                    <td style="text-align:center">
                                                                        Est
                                                                    </td>
                                                                    <td style="text-align:center">
                                                                        Tran
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="text-align:center">
                                                                        <strong>{{produto[0].disponiveis[i]}}</strong> 
                                                                    </td>
                                                                    <td style="text-align:center">
                                                                        <strong>{{produto[0].estoques[i]}}</strong> 
                                                                    </td>
                                                                    <td style="text-align:center">
                                                                        <strong>{{produto[0].transitos[i]}}</strong> 
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Cod. Univ.</th>
                                                        <th>Nome Produto</th>
                                                        <th>Categoria</th>
                                                        <th ng-repeat="e in produtos.elementos[0][0].empresas">{{e}}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                            <!-- paginação  -->
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination justify-content-end">
                                                        <li class="page-item" ng-click="produtos.prev()"><a class="page-link" href="">Anterior</a></li>
                                                        <li class="page-item" ng-repeat="pg in produtos.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid':''}}">{{pg.numero + 1}}</a></li>
                                                        <li class="page-item" ng-click="produtos.next()"><a class="page-link" href="">Próximo</a></li>
                                                    </ul>
                                                </nav>
                                            </div>

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

                <!-- /.modal-content ADD --> 

                <!-- /.modal-content -->

                <!-- /.modal-content EDIT --> 
                [
                <!-- /.modal-content --> 				



                <!-- /.modal-content DELETE --> 

                <!-- /.modal-content --> 

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
                                                                            $('.btninfo').tooltip({title: "Mais informação", placement: "top"});
                                                                            $('.btnedit').tooltip({title: "Editar", placement: "top"});
                                                                            $('.btndel').tooltip({title: "Deletar", placement: "top"});
                                                                        });
                                                                        $(document).ready(function () {
                                                                            $('#clientes').DataTable({
                                                                                "language": {//Altera o idioma do DataTable para o português do Brasil
                                                                                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                                                                                },
                                                                            });

                                                                            $.getJSON('estados_cidades.json', function (data) {
                                                                                var items = [];
                                                                                var options = '<option value="">escolha um estado</option>';
                                                                                $.each(data, function (key, val) {
                                                                                    options += '<option value="' + val.nome + '">' + val.nome + '</option>';
                                                                                });
                                                                                $("#estados").html(options);

                                                                                $("#estados").change(function () {

                                                                                    var options_cidades = '';
                                                                                    var str = "";

                                                                                    $("#estados option:selected").each(function () {
                                                                                        str += $(this).text();
                                                                                    });

                                                                                    $.each(data, function (key, val) {
                                                                                        if (val.nome == str) {
                                                                                            $.each(val.cidades, function (key_city, val_city) {
                                                                                                options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
                                                                                            });
                                                                                        }
                                                                                    });
                                                                                    $("#cidades").html(options_cidades);

                                                                                }).change();

                                                                            });
                                                                        });

                </script>

                </body>

                </html>