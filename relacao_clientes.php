<!doctype html>
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
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/fixedHeader.bootstrap4.css">
        <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">-->
        <title>RTC (Reltrab Cliente) - WEB</title>
        <style>
        </style>
    </head>

    <body ng-controller="crtRelacaoCliente">
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
                                    <h2 class="pageheader-title">Relacao Clientes</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Relacao Clientes</li>
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
                                            <?php if($usuario->cargo->id === Virtual::CF_ASSISTENTE_VIRTUAL_RECEPCAO($empresa)->id){ ?>
                                            <div class="product-btn m-b-20">
                                                <button class="btn btn-outline-{{atividade.pontos_atendimento<atividade.meta?'danger':'success'}}" style="width:auto;font-size:20px;padding:10px">
                                                    <i class="fas fa-star"></i>&nbspMeta de Atendimento Diaria
                                                    <hr>
                                                    <strong>{{atividade.pontos_atendimento}}</strong> de <strong>{{atividade.meta}}</strong>
                                                </button>
                                                <button class="btn btn-outline-{{atividade.pontos_mes<atividade.meta_mes?'danger':'success'}}" style="width:auto;font-size:20px;padding:10px">
                                                    <i class="fas fa-star"></i>&nbspMeta de Atendimento Mensal
                                                    <hr>
                                                    <strong>{{atividade.pontos_mes}}</strong> de <strong>{{atividade.meta_mes}}</strong>
                                                </button>
                                            </div>
                                            <?php } ?>
                                            <hr>
                                            <table id="clientes" class="table table-striped table-bordered first">
                                                <thead>
                                                    <tr>
                                                        <th data-ordem="cliente.codigo">Cod.</th>
                                                        <th data-ordem="cliente.razao_social">Nome</th>
                                                        <th data-ordem="cliente.email.endereco">Email</th>
                                                        <th data-ordem="cliente.cnpj">CNPJ</th>
                                                        <th data-ordem="cliente.cpf">CPF</th>
                                                        <th data-ordem="cliente.empresa.nome">Empresa</th>
                                                        <th>Situacao</th>
                                                        <th width="180px">Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="cliente in clientes.elementos">
                                                        <td>{{cliente[0].cliente.codigo}}</td>
                                                        <td>{{cliente[0].cliente.razao_social}}</td>
                                                        <td><email entidade="Cliente" atributo="cliente[0].cliente.email" senha="false" alterar="false"></email></td>
                                                <td>{{(!cliente[0].cliente.pessoa_fisica)?cliente[0].cliente.cnpj.valor:'------'}}</td>
                                                <td>{{(cliente[0].cliente.pessoa_fisica)?cliente[0].cliente.cpf.valor:'------'}}</td>
                                                <td>{{cliente[0].cliente.empresa.nome}}</td>
                                                <td>
                                                    <strong style="color:steelblue" ng-if="cliente[0].situacao===4">A Prospectar</strong>
                                                    <strong style="color:Purple" ng-if="cliente[0].situacao===0">Prospectado em recepcao</strong>
                                                    <strong style="color:darkgray" ng-if="cliente[0].situacao===1">Prospectado ja recepcionado</strong>
                                                    <strong style="color:Green" ng-if="cliente[0].situacao===2">Prospectado em quarentena</strong>
                                                    <strong style="color:orangered" ng-if="cliente[0].situacao===6">Aprovado na Quarentena</strong>
                                                </td>
                                                <th>
                                                    <div class="product-btn">
                                                        <a href="#" class="btn btn-outline-light btnedit" data-title="Edit" ng-click="setRelacaoCliente(cliente[0])" data-toggle="modal" data-target="#contatos"><i class="fas fa-list"></i>&nbsp Contatos</a>
                                                    </div>
                                                </th>
                                                </tr>
                                                
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Cod.</th>
                                                        <th>Nome</th>
                                                        <th>Email</th>
                                                        <th>CNPJ</th>
                                                        <th>CPF</th>
                                                        <th>Empresa</th>
                                                        <th>Situacao</th>
                                                        <th width="180px">Ação</th>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                            <!-- paginação  -->
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination justify-content-end">
                                                        <li class="page-item" ng-click="clientes.prev()"><a class="page-link" href="">Anterior</a></li>
                                                        <li class="page-item" ng-repeat="pg in clientes.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid':''}}">{{pg.numero + 1}}</a></li>
                                                        <li class="page-item" ng-click="clientes.next()"><a class="page-link" href="">Próximo</a></li>
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


                <!-- /.modal-content DELETE --> 
                <div class="modal fade" id="contatos" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-list-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Contatos com o cliente</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <h4>{{relacaoCliente.cliente.razao_social}}</h4>
                                <hr>
                                <div style="width:100%;border:1px dashed;border-radius:3px;padding:10px;margin-bottom:20px" ng-repeat="contato in contatos">
                                    Data: <strong>{{contato.data | data}}</strong>
                                    <hr>
                                    <strong>Descricao:</strong>
                                    <br>
                                    {{contato.descricao}}
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" ng-click="novoContato()" data-toggle="modal" data-target="#novoContato"><i class="fas fa-plus-circle"></i>Novo contato</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal fade" id="novoContato" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-plus-circle fa-3x"></i>&nbsp;&nbsp;&nbsp;Cadastro de contato com o cliente</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <h4>{{relacaoCliente.cliente.razao_social}}</h4>
                                <hr>
                                <div style="width:100%;border:1px dashed;border-radius:3px;padding:10px;margin-bottom:20px">
                                    Data: <strong>{{contato.data | data}}</strong>
                                    <hr>
                                    <strong>Descricao:</strong>
                                    <br>
                                    <textarea class="form-control" style="width:100%" rows="5" ng-model="contato.descricao">
                                    </textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" ng-click="mergeContato(contato)" data-dismiss="modal" aria-label="Close"><i class="fas fa-plus-circle"></i>Novo contato</button>
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