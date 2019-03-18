<!doctype html>
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

    <body ng-controller="crtTarefas">
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
                                    <h2 class="pageheader-title">Tarefas</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Tarefas</li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end pageheader  -->
                        <!-- ============================================================== -->
                        <style>
                            .tarefa{
                                text-align: center;
                                height:240px;
                                border:1px dashed;
                                width:calc(33% - 20px) !important;
                                margin-left:20px !important;
                                padding:10px;
                                border-radius: 3px;
                            }
                        </style>
                        <div class="row">
                            <!-- ============================================================== -->
                            <!-- basic table  -->
                            <!-- ============================================================== -->
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <div class="product-btn m-b-20">
                                                <button class="btn btn-success" ng-click="novaTarefa()" data-toggle="modal" data-target="#nova_tarefa_usuario"><i class="fas fa-plus-circle"></i>&nbsp Criar Tarefa para a Min</button>
                                                <button class="btn btn-success" ng-click="novaTarefa()" data-toggle="modal" data-target="#nova_tarefa_equipe"><i class="fas fa-plus-circle"></i>&nbsp Criar Tarefa para a Equipe</button>
                                            </div>
                                            <hr>

                                            <div class="row" ng-repeat="linha in tarefas.elementos" style="margin:20px">
                                                <div class="tarefa" ng-repeat="t in linha">
                                                    <i class="fas fa-align-left" style="display: inline"></i>&nbsp<h4 style="display: inline">{{t.titulo}}</h4>
                                                    <hr>
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                Realizado:
                                                            </td>
                                                            <td>
                                                                <h4 style="margin-top:12px;color:{{t.porcentagem_conclusao===0?'Red':(t.porcentagem_conclusao>50?'Green':'Orange')}}">{{t.porcentagem_conclusao}} %</h4>
                                                            </td>
                                                            <td style="padding-left:20px">
                                                                Tempo Util Utilizado:
                                                            </td>
                                                            <td>
                                                                <h4 style="margin-top:12px">{{t.calculado_horas_uteis_dispendidas | tempo}} </h4>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Previsao conclusao:
                                                            </td>
                                                            <td>
                                                                <h4 style="margin-top:12px">{{t.calculado_momento_conclusao | data}} </h4>
                                                            </td>
                                                            <td>
                                                                Tempo previsto:
                                                            </td>
                                                            <td>
                                                                <h4 style="margin-top:12px">{{t.calculado_previsao_util_conclusao | tempo}} </h4>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Tipo:
                                                            </td>
                                                            <td colspan="3">
                                                                <h4 style="margin-top:12px">{{t.tipo_tarefa.nome}} - ({{t.tipo_tarefa.tempo_medio*60}}m em media) </h4>
                                                            </td>
                                                        </tr>
                                                    </table>          
                                                </div>
                                            </div>

                                            <!-- paginação  -->
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">

                                                <div style="width:40px;display:inline-block" ng-repeat="pg in tarefas.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid':''}}">{{pg.numero + 1}}</a></div>

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

                <div class="modal fade" id="nova_tarefa_usuario" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-plus-circle fa-3x"></i>&nbsp;&nbsp;&nbsp;Nova tarefa para min</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td>
                                            Tipo de Tarefa:
                                        </td>
                                        <td>
                                            <select class="form-control" ng-model="tipo_tarefa_usuario" ng-change="setTipoTarefaUsuario(tipo_tarefa_usuario)">
                                                <option ng-repeat="t in tipos_tarefa_usuario" ng-value="t">{{t.nome}} - {{(t.tempo_medio * 60)}} minutos em media</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Inicio Minimo:
                                        </td>
                                        <td>
                                            <div>
                                                <calendario model="tarefa.inicio_minimo" tempo="true" meses="1" botao="true" refresh="tarefa"></calendario>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Prioridade:
                                        </td>
                                        <td>
                                            <input type="number" ng-model="tarefa.prioridade" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Recorrencia (0 sem):
                                        </td>
                                        <td>
                                            <input type="number" ng-model="recorrencia" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Titulo:
                                        </td>
                                        <td>
                                            <input type="text" ng-model="tarefa.titulo" class="form-control" placeholder="Titulo da tarefa">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Descricao:
                                        </td>
                                        <td>
                                            <textarea style="width: 100%" rows="5" ng-model="tarefa.descricao" class="form-control" placeholder="Descricao da tarefa">
                                                
                                            </textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>

                                        </td>
                                        <td style="text-align: right">
                                            <button style="width:50%" class="btn btn-success" ng-click="salvarTarefaUsuario()"><i class="fas fa-check"></i>&nbsp;Salvar</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="nova_tarefa_equipe" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-plus-circle fa-3x"></i>&nbsp;&nbsp;&nbsp;Nova tarefa para a equipe</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td>
                                            Empresa:
                                        </td>
                                        <td>
                                            <select class="form-control" ng-model="empresa" ng-change="setEmpresa(empresa)">
                                                <option ng-repeat="e in empresas" ng-value="e">{{e.nome}}</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Tipo de Tarefa:
                                        </td>
                                        <td>
                                            <select class="form-control" ng-model="tipo_tarefa" ng-change="setTipoTarefa(tipo_tarefa)">
                                                <option ng-repeat="t in tipos_tarefa" ng-value="t">{{t.nome}} - {{(t.tempo_medio * 60)}} minutos em media</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Forma de Atribuicao:
                                        </td>
                                        <td>
                                            <div>
                                                <input type="checkbox" style="display:inline;width:20px" id="emp" ng-model="empresarial" ng-true-value="true" ng-false-value="false" class="form-control">
                                                <label style="display:inline" for="emp">Atribuicao Automatica <i class="fas fa-sitemap"></i></label>
                                            </div>
                                            <div>
                                                <input style="display:inline;width:20px" type="checkbox" id="noemp" ng-model="empresarial" ng-true-value="false" ng-false-value="true" class="form-control">
                                                <label style="display:inline" for="noemp">Atribuicao Individual <i class="fas fa-male"></i></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr ng-if="!empresarial">
                                        <td>
                                            Usuario:
                                        </td>
                                        <td>
                                            <button data-toggle="modal" data-target="#usuarios" ng-click="usuarios.attList()" class="btn btn-outline-light" style="width:100%"><i class="fas fa-search"></i>&nbsp{{usuario===null?'Selecione um usuario':usuario.id+' - '+usuario.nome}}</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Inicio Minimo:
                                        </td>
                                        <td>
                                            <div>
                                                <calendario model="tarefa.inicio_minimo" tempo="true" meses="1" botao="true" refresh="tarefa"></calendario>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Prioridade:
                                        </td>
                                        <td>
                                            <input type="number" ng-model="tarefa.prioridade" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Recorrencia (0 sem):
                                        </td>
                                        <td>
                                            <input type="number" ng-model="recorrencia" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Titulo:
                                        </td>
                                        <td>
                                            <input type="text" ng-model="tarefa.titulo" class="form-control" placeholder="Titulo da tarefa">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Descricao:
                                        </td>
                                        <td>
                                            <textarea style="width: 100%" rows="5" ng-model="tarefa.descricao" class="form-control" placeholder="Descricao da tarefa">
                                                
                                            </textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>

                                        </td>
                                        <td style="text-align: right">
                                            <button style="width:50%" class="btn btn-success" ng-click="salvarTarefa()"><i class="fas fa-check"></i>&nbsp;Salvar</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="usuarios" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-search-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Selecione o usuario</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control" placeholder="Filtro" id="filtroUsuarios">
                                <hr>
                                <table id="lista_usuarios" class="table table-striped table-bordered first">
                                    <thead>
                                        <tr>
                                            <th data-ordem="usuario.id">Cod.</th>
                                            <th data-ordem="usuario.nome">Nome</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="usuario in usuarios.elementos">
                                            <td>{{usuario[0].id}}</td>
                                            <td>{{usuario[0].nome}}</td>
                                            <td>
                                                <div class="product-btn">
                                                    <a href="#" class="btn btn-outline-light btninfo" data-dismiss="modal" aria-label="Close" ng-click="setUsuario(usuario[0])"><i class="fas fa-certificate"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Cod.</th>
                                            <th>Nome</th>
                                            <th>Ação</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">

                                    <div class="page-item" ng-click="usuarios.prev()" style="width:105px;display: inline-block;margin-left: 5px;margin-bottom:5px"><a class="page-link" href="">Anterior</a></div>
                                    <div class="page-item" ng-repeat="pg in usuarios.paginas" ng-click="pg.ir()" style="width:40px;display: inline-block;margin-left: 5px;margin-bottom:5px"><a class="page-link" style="{{pg.isAtual?'border:2px solid':''}}">{{pg.numero + 1}}</a></div>
                                    <div class="page-item" ng-click="usuarios.next()" style="width:105px;display: inline-block;margin-left: 5px;margin-bottom:5px"><a class="page-link" href="">Próximo</a></div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <!-- /.modal-content DELETE --> 
                <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-trash-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Delete os dados de seu Fornecedor</h5>
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