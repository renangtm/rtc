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

    <body ng-controller="crtAcompanharAtividades">
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

            <?php
            $filtro = "ng-model='tarefas.filtro' ng-change='tarefas.attList()'";
            include("menu.php");
            ?>
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
                                    <h2 class="pageheader-title">Acompanhar Atividades</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Acompanhar Atividades</li>
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

                                            <div style="border:1px dashed;border-radius: 10px;width:100%;height:600px;padding:20px" ng-if="carregando">

                                                <span style="margin-left:auto;margin-right:auto" class="dashboard-spinner spinner-success spinner-lg"></span>

                                                <div style="position: absolute;width:500px;height:40px;left:calc(50% - 250px);top:200px">
                                                    <h2 style="display: inline">Aguarde o carregamento da pagina, pode demorar alguns segundos...</h2><i style="display: inline" class="fas fa-clock fa-3x"></i>
                                                </div>


                                            </div>

                                            <div style="width:100%" ng-if="!carregando">

                                                <div style="width:100%;border: 1px solid;margin-bottom:10px;border-radius: 3px;padding:15px" ng-repeat="grupo in tarefas.elementos">

                                                    <h3>{{grupo[0].nome_usuario}} - {{grupo[0].nome_empresa}}</h3>
                                                    <hr>


                                                    <!-- TAREFA INDIVIDUAL -->

                                                    <table id="tarefas" class="table table-striped table-bordered first">
                                                        <thead>
                                                            <tr>
                                                                <th>Planejada para</th>
                                                                <th>%</th>
                                                                <th>Titulo</th>
                                                                <th>Descr</th>
                                                                <th>Prioridade</th>
                                                                <th>Por</th>
                                                                <th>Acao</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr ng-repeat-start="tarefa in grupo[0].lista.elementos">
                                                                <td>{{tarefa[0].inicio_minimo| data}}</td>
                                                                <td>{{tarefa[0].porcentagem_conclusao}}%</td>
                                                                <td>{{tarefa[0].titulo}}</td>
                                                                <td>{{tarefa[0].descricao_resumida}}</td>
                                                                <td>{{tarefa[0].prioridade}}</td>
                                                                <td>{{tarefa[0].assinatura_solicitante}}</td>
                                                                <td>
                                                                    <a href="#" class="btn btn-outline-light btninfo" data-toggle="collapse" data-target="#demo{{tarefa[0].id}}" class="accordion-toggle"><i class="fas fa-info-circle"></i></a>
                                                                </td>
                                                            </tr>
                                                            <tr ng-repeat-end>
                                                                <td colspan="7" class="hiddenRow">
                                                                    <div class="accordian-body collapse" id="demo{{tarefa[0].id}}">
                                                                        <div class="row mx-auto m-b-30">
                                                                            <div class="col">
                                                                                <div style="width:100%;height:20px"></div>
                                                                                <table class="table table-bordered w-100">
                                                                                    <tr>
                                                                                        <td>
                                                                                            Descricao:
                                                                                        </td>
                                                                                        <td>
                                                                                            {{tarefa[0].descricao}}
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>	
                                                                            <div class="col" style="margin-bottom:20px">
                                                                                <div style="width:100%;height:20px"></div>
                                                                                Andamento<hr>
                                                                                <table class="table-bordered w-100">
                                                                                    <tr ng-repeat="obs in tarefa[0].observacoes">
                                                                                        <td>
                                                                                            Obs:
                                                                                        </td>
                                                                                        <td>
                                                                                            {{obs.porcentagem}}% - {{obs.observacao}}
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                                <hr>
                                                                                <textarea style="width:60%" ng-model="observacao_tarefa.observacao" class="form-control">
                                                                                    
                                                                                </textarea>
                                                                                <br>
                                                                                <button class="btn btn-success" ng-click="addObservacao(tarefa[0])">
                                                                                    <i class="fas fa-plane"></i> &nbsp Enviar observacao
                                                                                </button>
                                                                            </div>																
                                                                        </div>	
                                                                    </div> 
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                        <th>Planejada para</th>
                                                        <th>%</th>
                                                        <th>Titulo</th>
                                                        <th>Descr</th>
                                                        <th>Prioridade</th>
                                                        <th>Por</th>
                                                        <th>Acao</th>
                                                        </tfoot>
                                                    </table>

                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                                        <nav aria-label="Page navigation example">
                                                            <ul class="pagination justify-content-end">
                                                                <li class="page-item" ng-repeat="pg in grupo[0].lista.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid':''}}">{{pg.numero + 1}}</a></li>
                                                            </ul>
                                                        </nav>
                                                    </div>


                                                    <!-- TAREFA INDIVIDUAL -->

                                                </div>


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