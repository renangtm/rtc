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
                                    <h2 class="pageheader-title">Tipos de Atividade</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Tipos de Atividade</li>
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
                                            <button class="btn btn-success" ng-click="novoTipoTarefa()" data-toggle="modal" data-target="#editar"><i class="fas fa-plus-circle"></i>&nbsp Cadastrar novo tipo de atividade</button>
                                            <hr>
                                            <table id="tipo_tarefa" class="table table-striped table-bordered first">
                                                <thead>
                                                    <tr>
                                                        <th>Cod</th>
                                                        <th>Nome</th>
                                                        <th>Tempo Medio</th>
                                                        <th>Prioridade</th>
                                                        <th>Acoes</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="{{t[0].id===tipo_tarefa.id?'selecionada':'normal'}}" ng-repeat="t in tipos_tarefa.elementos">
                                                        <td>{{t[0].id<=0?'Fixo':t[0].id}}</td>
                                                        <td>{{t[0].nome}}</td>
                                                        <td>{{t[0].tempo_medio}}h ({{(t[0].tempo_medio * 60)}} min)</td>
                                                        <td>{{t[0].prioridade}}</td>
                                                        <td>
                                                            <button ng-disabled="t[0].id < 0" class="btn btn-danger" ng-click="deleteTipoTarefa(t[0])"><i class="fas fa-trash"></i>&nbsp Excluir</button>
                                                            &nbsp
                                                            <button ng-disabled="t[0].id < 0" class="btn btn-light" ng-click="setTipoTarefa(t[0])" data-toggle="modal" data-target="#editar"><i class="fas fa-certificate"></i>&nbsp Editar</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Cod</th>
                                                        <th>Nome</th>
                                                        <th>Tempo Medio</th>
                                                        <th>Prioridade</th>
                                                        <th>Acoes</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination justify-content-end">
                                                        
                                                        <li class="page-item" ng-repeat="pg in tipos_tarefa.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid':''}}">{{pg.numero + 1}}</a></li>
                                                        
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

                <!-- /.modal-content --> 				

                <div class="modal fade" id="cargo" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-random-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Inserir cargos</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-striped table-bordered first">
                                    <thead>
                                        <tr>
                                            <th>Cod</th>
                                            <th>Nome</th>
                                            <th>Adcionar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="c in lstCargos.elementos">
                                            <td>{{c[0].id<=0?'Fixo':c[0].id}}</td>
                                            <td>{{c[0].nome}}</td>
                                            <th>
                                                <button ng-click="addCargo(c[0])" class="btn btn-success" data-dismiss="modal"><i class="fas fa-plus-circle"></i></button>
                                            </th>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Cod.</th>
                                            <th>Nome</th>
                                            <th>Adcionar</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Sair</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /.modal-content DELETE --> 
                <div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-random-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Altere o tipo da tarefa</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                            </div>
                            <div class="modal-body">


                                <div>
                                    <h4 style="display: inline">{{tipo_tarefa.nome}} {{tipo_tarefa.id < 0 ? ' - (Fixa)' : ''}}</h4> &nbsp 
                                    <hr>
                                    <table class="table table-striped">
                                        <tr>
                                            <td>
                                                Nome
                                            </td>
                                            <td>
                                                <input type="text" ng-model="tipo_tarefa.nome" ng-disabled="tipo_tarefa.id < 0" placeholder="Nome tarefa" class="form-control">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Tempo médio (h)
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" step="0.01" ng-model="tipo_tarefa.tempo_medio">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Prioridade
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" ng-model="tipo_tarefa.prioridade">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align:center">
                                                <i class="fas fa-random"></i>&nbsp Cargos Relacionados
                                            </td>
                                        </tr>
                                    </table>
                                    <hr>
                                    <button class="btn btn-success" data-toggle="modal" data-target="#cargo"><i class="fas fa-plus-circle"></i>&nbsp Adicionar cargo</button>
                                    <hr>
                                    <table id="cargos_tipo_tarefa" class="table table-striped table-bordered first">
                                        <thead>
                                            <tr>
                                                <th>Cod</th>
                                                <th>Nome</th>
                                                <th>Acao</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="c in cargos_tipo_tarefa.elementos">
                                                <td>{{c[0].id<=0?'Fixo':c[0].id}}</td>
                                                <td>{{c[0].nome}}</td>
                                                <td><button class="btn btn-danger" ng-click="removeCargoTarefa(c[0])"><i class="fas fa-trash"></i></button></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Cod</th>
                                                <th>Nome</th>
                                                <th>Acao</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination justify-content-end">
                                                <li class="page-item" ng-click="cargos_tipo_tarefa.prev()"><a class="page-link" href="">Anterior</a></li>
                                                <li class="page-item" ng-repeat="pg in cargos_tipo_tarefa.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid':''}}">{{pg.numero + 1}}</a></li>
                                                <li class="page-item" ng-click="cargos_tipo_tarefa.next()"><a class="page-link" href="">Próximo</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" style="display:inline" ng-click="mergeTipoTarefa(tipo_tarefa)"><i class="fas fa-check"></i>&nbsp Salvar</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Sair</button>
                            </div>
                        </div>
                    </div>
                </div>
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