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
        </style>
    </head>

    <body ng-controller="crtUsuarios">
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
                                    <h2 class="pageheader-title">Cargos</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Cargos</li>
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
                            
                            <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body row">
                                            <div class="col-md-12">
                                                <table style="width: 50%">
                                                    <tr>
                                                        <td><input type="text" class="form-control" placeholder="Nome do cargo que sera cadastrado" ng-model="cargo.nome" style="padding:10px"></td>
                                                        <td><button class="btn btn-success" style="width:30%" ng-click="mergeCargo(cargo)"><i class="fas fa-plus-circle"></i></button></td>
                                                    </tr>
                                                </table>

                                                <hr>
                                                <table id="cargos" class="table table-striped table-bordered first">
                                                    <thead>
                                                        <tr>
                                                            <th>Cod</th>
                                                            <th>Nome</th>
                                                            <th>Acoes</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="c in lstCargos.elementos">
                                                            <td>{{c[0].id<=0?'Fixo, esse tipo de cargo so pode ser alterado pelos desenvolvedores':c[0].id}}</td>
                                                            <td ng-if="c[0].id <= 0">{{c[0].nome}}</td>
                                                            <td ng-if="c[0].id > 0"><input type="text" class="form-control" ng-model="c[0].nome"></td>

                                                            <th>
                                                                <div class="product-btn" ng-if="c[0].id > 0">
                                                                    <a href="#" class="btn btn-outline-light btnedit" data-title="Edit" ng-click="mergeCargo(c[0])"><i class="fas fa-pencil-alt"></i>&nbsp Confirmar Alteracao</a>
                                                                    <a href="#" class="btn btn-outline-light btndel" data-title="Delete" ng-click="deleteCargo(c[0])"><i class="fas fa-trash-alt"></i>&nbsp Excluir</a>
                                                                    <a href="#" class="btn btn-outline-light btndel" data-toggle="modal" data-target="#permissoes" data-title="Permissoes" ng-click="setCargo(c[0])"><i class="fas fa-key"></i>&nbsp Permissoes Padrao</a>
                                                                </div>
                                                                <div class="product-btn" ng-if="c[0].id <= 0">
                                                                    Cargo Fixo
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Cod.</th>
                                                            <th>Nome</th>
                                                            <th>Acoes</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <paginacao assinc="lstCargos"></paginacao>
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
                <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-trash-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Delete os dados de seu Cargo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center"> Tem certeza de que deseja excluir este Fornecedor?</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" ng-click="deleteFornecedor(fornecedor)">Sim</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Não</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content --> 

                <div class="modal fade" id="permissoes" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-trash-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Permissoes do cargo {{cargo.nome}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">

                                <button class="btn btn-outline-light" ng-click="setPermissoesCargo(cargo_permissoes)"><i class="fas fa-check"></i>&nbspConfirmar alteracoes</button>
                                <hr>
                                <table id="clientes" class="table table-striped table-bordered first">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Alt</th>
                                            <th>Inc</th>
                                            <th>Del</th>
                                            <th>Cons</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="p in cargo_permissoes.permissoes">
                                            <td>{{p.nome}}</td>
                                            <td><input class="form-control" type="checkbox" ng-value="true" ng-model="p.alt"></td>
                                            <td><input class="form-control" type="checkbox" ng-value="true" ng-model="p.in"></td>
                                            <td><input class="form-control" type="checkbox" ng-value="true" ng-model="p.del"></td>
                                            <td><input class="form-control" type="checkbox" ng-value="true" ng-model="p.cons"></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Fechar</button>
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