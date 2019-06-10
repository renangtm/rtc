<!doctype html>
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
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/fixedHeader.bootstrap4.css">
        <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">-->
        <title>RTC (Reltrab Cliente) - WEB</title>
        <style>

            .selecionado{

                background-color:steelblue !important;
                color:#FFFFFF;
                cursor:pointer;
            }

            .normal:hover{

                background-color:#000000 !important;
                color:#FFFFFF;
                cursor:pointer;
            }

        </style>
    </head>

    <body ng-controller="crtExpediente">
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
                                    <h2 class="pageheader-title">Expediente</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Expediente</li>
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
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body row">
                                        <div class="col-md-12">
                                            <div class="table-responsive" id="dvUsuarios">
                                                <h4>Selecione o Usuario</h4>
                                                <hr>
                                                <input tipe="text" class="form-control" id="filtroUsuarios" placeholder="Filtro">
                                                <br>
                                                <table id="clientes" class="table table-striped table-bordered first" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th data-ordem="usuario.id">Cod.</th>
                                                            <th data-ordem="usuario.nome">Nome</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="{{usuari[0].id===usuario.id?'selecionado':'normal'}}" ng-click="setUsuario(usuari[0])" ng-repeat="usuari in usuarios.elementos">
                                                            <td>{{usuari[0].id}}</td>
                                                            <td>{{usuari[0].nome}}</td>
                                                            </th>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Cod.</th>
                                                            <th>Nome</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>

                                                <!-- paginacao  -->
                                                <paginacao assinc="usuarios"></paginacao>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4" style="overflow: visible">
                                <div class="card" style="overflow: visible">
                                    <div class="card-body row" style="overflow: visible">
                                        <div class="col-md-12" style="overflow: visible">
                                            <div class="table-responsive" id="dvUsuarios" style="overflow: visible">
                                                <h4 style="display: inline">Auxencias do {{usuario.nome}}</h4>
                                                &nbsp;
                                                <button class="btn btn-outline-success" ng-click="addAusencia()"><i class="fas fa-plus-circle"></i></button>
                                                &nbsp 
                                                <button class="btn btn-success" ng-click="confirmarAusencias()"><i class="fas fa-check"></i>&nbsp Confirmar Alteracoes</button>
                                                <hr>
                                                <table id="clientes" class="table table-striped table-bordered first" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Periodo</th>
                                                            <th><i class="fas fa-trash"></i></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="a in ausencias.elementos">
                                                            <td><calendario inicio="a[0].inicio" fim="a[0].fim" botao="true" tempo="true" meses="1"></calendario></td>
                                                    <td><button class="btn btn-danger" ng-click="removeAusencia(a[0])"><i class="fas fa-trash"></i></button></td>
                                                    </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Periodo</th>
                                                            <th><i class="fas fa-trash"></i></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>

                                                <!-- paginacao  -->
                                                <paginacao assinc="ausencias"></paginacao>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4" style="overflow: visible">
                                <div class="card" style="overflow: visible">
                                    <div class="card-body row" style="overflow: visible">
                                        <div class="col-md-12" style="overflow: visible">
                                            <div class="table-responsive" id="dvUsuarios" style="overflow: visible">
                                                <h4 style="display: inline">Expediente do {{usuario.nome}}</h4>
                                                &nbsp;
                                                <button class="btn btn-outline-success" ng-click="addExpediente()"><i class="fas fa-plus-circle"></i></button>
                                                &nbsp 
                                                <button class="btn btn-success" ng-click="confirmarExpedientes()"><i class="fas fa-check"></i>&nbsp Confirmar Alteracoes</button>
                                                <hr>
                                                <table id="clientes" class="table table-striped table-bordered first" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Inicio(h)</th>
                                                            <th>Fim(h)</th>
                                                            <th>Dia Semana</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="e in expedientes.elementos">
                                                            <td><input style="width:50%;display: inline" type="number" class="form-control" step="0.01" ng-model="e[0].inicio"> <strong style="display: inline">({{getTempo(e[0].inicio)}})</strong></td>
                                                            <td><input style="width:50%;display: inline" type="number" class="form-control" step="0.01" ng-model="e[0].fim"> <strong style="display: inline">({{getTempo(e[0].fim)}})</strong></td>
                                                            <td>
                                                                <select class="form-control" ng-model="e[0].dia_semana">
                                                                    <option ng-repeat="d in dias" ng-value="d.id">{{d.nome}}</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Inicio(h)</th>
                                                            <th>Fim(h)</th>
                                                            <th>Dia Semana</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>

                                                <!-- paginacao  -->
                                                <paginacao assinc="expedientes"></paginacao>

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

                <!-- /.modal-content --> 				



                <!-- /.modal-content DELETE --> 

                <!-- /.modal-content --> 

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


                                                        $(document).ready(function () {
                                                            $('.btninfo').tooltip({title: "Mais informação", placement: "top"});
                                                            $('.btnedit').tooltip({title: "Editar", placement: "top"});
                                                            $('.btndel').tooltip({title: "Deletar", placement: "top"});
                                                        });


                </script>

                </body>

                </html>