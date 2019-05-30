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

    <body ng-controller="crtTarefaSimplificada">
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
                                    <h2 class="pageheader-title">Atividades Simplificadas</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Atividades Simplificadas</li>
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
                                                <a href="#" class="btn btn-primary" data-title="Add" data-toggle="modal" data-target="#add" ng-click="novaTarefa()"><i class="fas fa-plus-circle m-r-10"></i>Adicionar Atividade</a>
                                            </div>
                                            <table id="clientes" class="table table-striped table-bordered first">
                                                <thead>
                                                    <tr>
                                                        <th data-ordem="t.prioridade">Prioridade</th>
                                                        <th data-ordem="t.id">Cod.</th>
                                                        <th data-ordem="t.descricao">Descricao</th>
                                                        <th data-ordem="t.momento">Data</th>
                                                        <th data-ordem="t.id_tipo_tarefa">Tipo</th>
                                                        <th>Status</th>
                                                        <th width="180px">Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat-start="tarefa in tarefas.elementos">
                                                        <td>{{tarefa[0].prioridade}}</td>
                                                        <td>{{tarefa[0].id}}</td>
                                                        <td>{{tarefa[0].descricao}}</td>
                                                        <td>{{tarefa[0].momento| data}}</td>
                                                        <td>{{tarefa[0].tipo.nome}}</td>
                                                        <td style="width:40px">

                                                            <div style="width:100%;height:60px;color:#FFFFFF;background-color: DarkGray;padding:20px;font-weight: bold;font-size:13px;border-radius:5px" ng-if="getStatus(tarefa[0]) === -1">
                                                                Sem andamento
                                                            </div>
                                                            <div style="width:100%;height:60px;color:#FFFFFF;background-color: steelblue;padding:20px;font-weight: bold;font-size:13px;border-radius:5px" ng-if="getStatus(tarefa[0]) === 0">
                                                                Iniciada
                                                            </div>
                                                            <div style="width:100%;height:60px;color:#FFFFFF;background-color: orangered;padding:20px;font-weight: bold;font-size:13px;border-radius:5px" ng-if="getStatus(tarefa[0]) === 1">
                                                                Pausada
                                                            </div>
                                                            <div style="width:100%;height:60px;color:#FFFFFF;background-color: green;padding:20px;font-weight: bold;font-size:13px;border-radius:5px" ng-if="getStatus(tarefa[0]) === 2">
                                                                Concluida
                                                            </div>

                                                        </td>
                                                        <th>
                                                            <div class="product-btn">
                                                                <a href="#" class="btn btn-outline-light btninfo" data-toggle="collapse" ng-click="setTarefa(tarefa[0])" data-target="#demo{{tarefa[0].id}}" class="accordion-toggle"><i class="fas fa-info-circle"></i></a>
                                                                <a href="#" class="btn btn-outline-light btnedit" data-title="Edit" ng-click="setTarefa(tarefa[0])" data-toggle="modal" data-target="#add"><i class="fas fa-pencil-alt"></i></a>
                                                                <a href="#" class="btn btn-outline-light btndel" data-title="Delete" ng-click="setTarefa(tarefa[0])" data-toggle="modal" data-target="#delete"><i class="fas fa-trash-alt"></i></a>
                                                                <a href="#" class="btn btn-success btndel" data-title="NovoAndamento" ng-click="novoAndamento(tarefa[0])" data-toggle="modal" data-target="#addAndamento"><i class="fas fa-plus-circle"></i></a>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    <tr ng-repeat-end>
                                                        <td colspan="7" class="hiddenRow">
                                                            <div class="accordian-body collapse" id="demo{{tarefa[0].id}}">
                                                                <div class="row mx-auto m-b-30">
                                                                    <div class="col-md-8">
                                                                        <br>
                                                                        <br>
                                                                        <h3>Andamento</h3>
                                                                        <hr>
                                                                        <table class="table table-striped w-100">
                                                                            <tr>
                                                                                <td>Tipo</td>
                                                                                <td>Data</td>
                                                                                <td>Usuario</td>
                                                                                <td>Excluir</td>
                                                                            </tr>
                                                                            <tr ng-repeat="a in tarefa[0].andamentos">
                                                                                <td>{{tipos_andamento[a.tipo].nome}}</td>
                                                                                <td>{{a.momento| data}}</td>
                                                                                <td>{{a.usuario.id + ' - ' + a.usuario.nome}}</td>
                                                                                <td><button class="btn btn-danger" ng-click="removeAndamento(a, tarefa[0])"><i class="fas fa-times"></i></button></td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <br>
                                                                        <br>
                                                                        <h3 style="display: inline;margin-right:20px">Arquivos</h3>
                                                                        <button class="btn btn-success" ng-click="initUpload(tarefa[0])"><i class="fas fa-plus-circle"></i></button>
                                                                        <hr>
                                                                        <table class="table table-striped w-100">
                                                                            <tr>
                                                                                <td>Link</td>
                                                                                <td>Excluir</td>
                                                                            </tr>
                                                                            <tr ng-repeat="a in tarefa[0].arquivos">
                                                                                <td><a href="{{a}}" target="_blank">LINK PARA ARQUIVO</a></td>
                                                                                <td><button class="btn btn-danger" ng-click="removeArquivo(a, tarefa[0])"><i class="fas fa-times"></i></button></td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>	
                                                            </div> 
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Prioridade</th>
                                                        <th>Cod.</th>
                                                        <th>Descricao</th>
                                                        <th>Data</th>
                                                        <th>Tipo</th>
                                                        <th>Status</th>
                                                        <th>Ação</th>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                            <!-- paginação  -->
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination justify-content-end">
                                                        <li class="page-item" ng-click="tarefas.prev()"><a class="page-link" href="">Anterior</a></li>
                                                        <li class="page-item" ng-repeat="pg in tarefas.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid':''}}">{{pg.numero + 1}}</a></li>
                                                        <li class="page-item" ng-click="tarefas.next()"><a class="page-link" href="">Próximo</a></li>
                                                    </ul>
                                                </nav>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>	
                        <input type="file" multiple="true" id="flArquivos" style="visibility:hidden">
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
                <div class="modal fade in" id="add" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-plus-circle fa-3x"></i>&nbsp;&nbsp;&nbsp;Altere os dados da Atividade</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="add-form" ng-submit="mergeTarefa(tarefa)" parsley-validate>
                                    <div class="form-group row">
                                        <div class="col-12 col-lg-12">
                                            <textarea class="form-control" style="width:100%" rows="5" ng-model="tarefa.descricao" placeholder="Digite a descricao da tarefa"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Urgência</label>
                                        <div class="col-9 col-lg-10">
                                            <input type="number" class="form-control" ng-model="tarefa.prioridade_real">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Tipo</label>
                                        <div class="col-9 col-lg-10">
                                            <select class="form-control" ng-model="tarefa.tipo" ng-change="getUsuariosPossiveis(tarefa)">
                                                <option ng-repeat="t in tipos_tarefa" ng-value="t">{{t.nome}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row" style="padding-left:20px">
                                        <h4><i class="fas fa-male"></i>&nbsp Selecione o Lider e os Ajudantes</h4>
                                        <hr>
                                        <div class="col-12 col-lg-12">
                                            <div style="width:100%;max-height:400px;border:1px solid;border-radius:5px;overflow-y: scroll;padding:20px">
                                                <div ng-repeat="usuario in usuarios_possiveis">

                                                    <i class="fas fa-square" style="display:inline;cursor:pointer" ng-if="!contem(usuario, tarefa)" ng-click="addUsuario(usuario, tarefa)"></i>
                                                    <i class="fas fa-check-square" style="display:inline;cursor:pointer;background-color: Green;color:Green" ng-if="contem(usuario, tarefa)" ng-click="removeUsuario(usuario, tarefa)"></i>

                                                    &nbsp

                                                    <span style="display:inline;cursor:pointer" ng-if="!contem(usuario, tarefa)" ng-click="addUsuario(usuario, tarefa)">{{usuario.id + ' - ' + usuario.nome}}</span>
                                                    <span style="display:inline;cursor:pointer;color:Green" ng-if="contem(usuario, tarefa)" ng-click="removeUsuario(usuario, tarefa)">{{usuario.id + ' - ' + usuario.nome}}</span>
                                                    <hr>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div>
                                            <calendario model="tarefa.momento" botao="true" tempo="true" refresh="tarefa" meses="1"></calendario>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                                        <button class="btn btn-primary">
                                            <i class="fas fa-save"></i> &nbsp; Salvar
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>		



                <div class="modal fade in" id="addAndamento" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-plus-circle fa-3x"></i>&nbsp;&nbsp;&nbsp;Acrescente novos andamentos a Atividade</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="add-form" ng-submit="mergeAndamento(andamento)" parsley-validate>
                                    <div class="form-group row">
                                        <div class="col-12 col-lg-12">
                                            Tipo: &nbsp
                                            <select ng-model="andamento.tipo" class="form-control">
                                                <option ng-repeat="t in getTiposPossiveis(andamento)" ng-value="t.id">{{t.nome}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Data</label>
                                        <div class="col-9 col-lg-10">
                                            <calendario model="andamento.momento" refresh="andamento" botao="true" tempo="true" meses="1"></calendario>
                                        </div>
                                    </div>
                                    <div class="form-group row" style="padding-left:20px">
                                        <label for="slusu" class="col-3 col-lg-2 col-form-label text-left">Usuario</label>
                                        <select ng-model="andamento.usuario" class="form-control">
                                            <option ng-repeat="usuario in andamento.tarefa.usuarios" ng-value="usuario">{{usuario.nome}}</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                                        <button class="btn btn-primary">
                                            <i class="fas fa-save"></i> &nbsp; Salvar
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>



                <!-- /.modal-content DELETE --> 
                <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-trash-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Delete os dados da Atividade</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center"> Tem certeza de que deseja excluir esta Atividade?</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" ng-click="deleteTarefa(tarefa)">Sim</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Não</button>
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