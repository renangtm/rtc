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
            .arvore ul{
                background-color:#FAFAFA;
                border-radius:5px;
                padding: 15px;
                margin-bottom: 5px;
                border:2px solid DarkGray;
                border-left:10px solid DarkGray;
            }

            .arvore ul:hover{
                border-radius:5px;
                padding: 15px;
                margin-bottom: 5px;
                border:2px solid Green;
                border-left:10px solid Green;
                cursor:pointer;
            }
            .arvore i{
                cursor:pointer;
                padding: 5px;
            }
            .arvore i:hover{
                cursor:pointer;
                color:Green;
            }
        </style>
    </head>

    <body ng-controller="crtLotes">
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
                                    <h2 class="pageheader-title">Lotes</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Produtos</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Lotes</li>
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
                                                <a href="#" class="btn btn-{{todas_pendencias.length>0?'danger':'primary'}}" data-title="Add" data-toggle="modal" data-target="#pendencias"><i class="fas fa-plus-circle m-r-10"></i>Cadastros pendentes</a>
                                            </div>
                                            <table id="clientes" class="table table-striped table-bordered first">
                                                <thead>
                                                    <tr>
                                                        <th data-ordem="lote.id">Cod.</th>
                                                        <th data-ordem="lote.produto.nome">Nome Produto</th>
                                                        <th data-ordem="lote.quantidade_real">Quant.</th>
                                                        <th data-ordem="lote.validade">Validade</th>
                                                        <th data-ordem="lote.numero">Numero</th>
                                                        <th data-ordem="lote.rua">Rua</th>
                                                        <th data-ordem="lote.altura">Altura</th>
                                                        <th>Local</th>
                                                        <th>Pertence a</th>
                                                        <th width="180px">A&ccedil;&atilde;o</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat-start="lote in lotes.elementos">
                                                        <td class="text-center">{{lote[0].id}}</td>
                                                        <td>{{lote[0].produto.codigo}} - {{lote[0].produto.nome}}</td>
                                                        <td class="text-center">{{lote[0].quantidade_real}}</td>
                                                        <td class="text-center">{{lote[0].validade| data}}</td>
                                                        <td class="text-center">{{lote[0].numero}}</td>
                                                        <td class="text-center">{{lote[0].rua}}</td>
                                                        <td class="text-center">{{lote[0].altura}}</td>
                                                        <td>{{lote[0].produto.logistica !== null ? lote[0].produto.logistica.nome : lote[0].produto.empresa.nome}}</td>
                                                        <td>{{lote[0].produto.empresa.nome}}</td>
                                                        <th>
                                                            <div class="product-btn">
                                                                <a href="#" class="btn btn-outline-light btninfo" data-toggle="collapse" ng-click="setLote(lote[0], 'arvore' + lote[0].id)" data-target="#demo{{lote[0].id}}" class="accordion-toggle"><i class="fas fa-info-circle"></i></a>
                                                                <a href="#" class="btn btn-outline-light btndel" data-title="Editar" ng-click="setLote(lote[0], null)" data-toggle="modal" data-target="#edit"><i class="fas fa-pencil-alt"></i></i></a>
                                                                <a href="#" class="btn btn-outline-light btndel" data-title="Delete" ng-click="setLote(lote[0], null)" data-toggle="modal" data-target="#delete"><i class="fas fa-trash-alt"></i></a>      
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    <tr ng-repeat-end>
                                                        <td colspan="10" class="hiddenRow">
                                                            <div class="accordian-body collapse" id="demo{{lote[0].id}}">
                                                                <div class="row mx-auto m-b-30">
                                                                    <div class="col arvore" id="arvore{{lote[0].id}}" style="background-color:#FBFBFB;margin:20px;border-radius:5px;padding:20px">

                                                                    </div>	
                                                                    <div class="col">
                                                                        <table class="table table-bordered w-100">
                                                                            <tr>
                                                                                <td>Grade:</td>
                                                                                <td>{{lote[0].grade.str}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Data de entrada:</td>
                                                                                <td>{{lote[0].data_entrada| data}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Codigo do fabricante:</td>
                                                                                <td>{{lote[0].codigo_fabricante}}</td>
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
                                                        <th>Cod.</th>
                                                        <th>Nome Produto</th>
                                                        <th>Quant.</th>
                                                        <th>Validade</th>
                                                        <th>Numero</th>
                                                        <th>Rua</th>
                                                        <th>Altura</th>
                                                        <th>Local</th>
                                                        <th>Pertence a</th>
                                                        <th>A&ccedil;&atilde;o</th>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                            <!-- pagina??�??�o  -->
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination justify-content-end">
                                                        <li class="page-item" ng-click="lotes.prev()"><a class="page-link" href="">Anterior</a></li>
                                                        <li class="page-item" ng-repeat="pg in lotes.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid':''}}">{{pg.numero + 1}}</a></li>
                                                        <li class="page-item" ng-click="lotes.next()"><a class="page-link" href="">Proximo</a></li>
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
                                    <p>Copyright  2018 - Agro Fauna Tecnologia. Todos os direitos reservados.</p>
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

                <div class="modal fade" id="pendencias" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-plus-circle fa-3x"></i>&nbsp;&nbsp;&nbsp;Cadastros pendentes</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                            </div>
                            <div class="modal-body">

                                <input type="text" class="form-control" placeholder="Filtro" ng-model="pendencias.filtro" ng-keyup="pendencias.attList()">
                                <hr>
                                <table id="pend" class="table table-striped table-bordered first">
                                    <thead>
                                        <tr>
                                            <th>Id Produto</th>
                                            <th>Nome Produto</th>
                                            <th>Quant.</th>
                                            <th>Grade</th>
                                            <th width="110px">Divisao</th>
                                            <th>Cadastrar</th>
                                        </tr>
                                    </thead>
                                    <tr ng-repeat="pendencia in pendencias.elementos">
                                        <td class="text-center">{{pendencia[0].id_produto}}</td>
                                        <td>{{pendencia[0].nome_produto}}</td>
                                        <td class="text-center">{{pendencia[0].quantidade}}</td>
                                        <td class="text-center">{{pendencia[0].grade.str}}</td>
                                        <td><input type="number" class="form-control" ng-model="pendencia[0].divisao"></td>
                                        <td class="text-center"><button class="btn btn-primary" ng-click="setPendencia(pendencia[0], pendencia[0].divisao)" data-toggle="modal" data-target="#cadastroLotes"><i class="fas fa-plus-circle"></i></button></td>
                                    </tr>
                                </table>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item" ng-repeat="pg in pendencias.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid':''}}">{{pg.numero + 1}}</a></li>
                                        </ul>
                                    </nav>
                                </div>

                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="cadastroLotes" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-plus-circle fa-3x"></i>&nbsp;&nbsp;&nbsp;Cadastros de lotes</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">??�</span></button>
                            </div>
                            <div class="modal-body">

                                <table id="pend" class="table table-striped table-bordered first">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Produto</th>
                                            <th>Validade</th>
                                            <th>Cod Fab</th>
                                            <th>Quantidade</th>
                                        </tr>
                                    </thead>
                                    <tr ng-repeat="l in lotes_cadastro">
                                        <td>{{l.produto.codigo}}</td>
                                        <td>{{l.produto.nome}}</td>
                                        <td><input type="text" class="form-control" ng-model="l.validade_texto"></td>
                                        <td><input type="text" class="form-control" ng-model="l.codigo_fabricante"></td>
                                        <td>{{l.quantidade_real}}</td>
                                    </tr>
                                </table>
                                <hr>
                                <button class="btn btn-default" ng-click="mergeLotes()"><i class="fas fa-plus-circle"></i>&nbsp; Cadastrar tudo</button>

                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-pencil-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Edite os dados de seu Lote</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                            </div>
                            <div class="modal-body">
                                <form ng-submit="mergeLote()">
                                    <div class="form-group row">
                                        <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Rua</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtname" type="text" ng-model="lote.rua" required data-parsley-type="email" placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Altura</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtname" type="text" ng-model="lote.altura" required data-parsley-type="email" placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Numero</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtname" type="text" ng-model="lote.numero" required data-parsley-type="email" placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtname" class="col-4 col-lg-4 col-form-label text-left">Codigo Fabricante</label>
                                        <div class="col-8 col-lg-8">
                                            <input id="txtname" type="text" ng-model="lote.codigo_fabricante" required data-parsley-type="email" placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-primary" ><i class="fas fa-save"></i>&nbsp; Salvar</button>
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
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-trash-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Delete os dados de seu Lote</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center"> Tem certeza de que deseja excluir este Lote?</p>

                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" ng-click="deletarLote(lote)">Sim</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">N&atilde;o</button>
                            </div>
                        </div>
                    </div>
                </div>
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
                                            $('.btninfo').tooltip({title: "Mais informa??�??�o", placement: "top"});
                                            $('.btnedit').tooltip({title: "Editar", placement: "top"});
                                            $('.btndel').tooltip({title: "Deletar", placement: "top"});
                                        });

                </script>

                </body>

                </html>