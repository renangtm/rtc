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
        <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
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
                                                        <th data-ordem="lote.quantidade_real">Quantidade</th>
                                                        <th data-ordem="lote.validade">Validade</th>
                                                        <th data-ordem="lote.numero">Numero</th>
                                                        <th data-ordem="lote.rua">Rua</th>
                                                        <th data-ordem="lote.altura">Altura</th>
                                                        <th width="150px">Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat-start="lote in lotes.elementos">
                                                        <td>{{lote[0].id}}</td>
                                                        <td>{{lote[0].produto.nome}}</td>
                                                        <td>{{lote[0].quantidade_real}}</td>
                                                        <td>{{lote[0].validade| data}}</td>
                                                        <td>{{lote[0].numero}}</td>
                                                        <td>{{lote[0].rua}}</td>
                                                        <td>{{lote[0].altura}}</td>
                                                        <th>
                                                            <div class="product-btn">
                                                                <a href="#" class="btn btn-outline-light btninfo" data-toggle="collapse" ng-click="setLote(lote[0], 'arvore' + lote[0].id)" data-target="#demo{{lote[0].id}}" class="accordion-toggle"><i class="fas fa-info-circle"></i></a>
                                                                <a href="#" class="btn btn-outline-light btndel" data-title="Editar" ng-click="setLote(lote[0], null)" data-toggle="modal" data-target="#edit"><i class="fas fa-edit"></i></a>
                                                                <a href="#" class="btn btn-outline-light btndel" data-title="Delete" ng-click="setLote(lote[0], null)" data-toggle="modal" data-target="#delete"><i class="fas fa-trash-alt"></i></a>      
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    <tr ng-repeat-end>
                                                        <td colspan="6" class="hiddenRow">
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
                                                        <th>Quantidade</th>
                                                        <th>Validade</th>
                                                        <th>Numero</th>
                                                        <th>Rua</th>
                                                        <th>Altura</th>
                                                        <th>Ação</th>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                            <!-- paginação  -->
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination justify-content-end">
                                                        <li class="page-item" ng-click="lotes.prev()"><a class="page-link" href="">Anterior</a></li>
                                                        <li class="page-item" ng-repeat="pg in lotes.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid':''}}">{{pg.numero + 1}}</a></li>
                                                        <li class="page-item" ng-click="lotes.next()"><a class="page-link" href="">Próximo</a></li>
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

                <div class="modal fade" id="pendencias" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-plus-circle fa-3x"></i>&nbsp;&nbsp;&nbsp;Cadastros pendentes</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">

                                <input type="text" class="form-control" placeholder="Filtro" ng-model="pendencias.filtro" ng-keyup="pendencias.attList()">
                                <hr>
                                <table id="pend" class="table table-striped table-bordered first">
                                    <thead>
                                        <tr>
                                            <th>Id Produto</th>
                                            <th>Nome Produto</th>
                                            <th>Quantidade</th>
                                            <th>Grade</th>
                                            <th>Divisao</th>
                                            <th>Cadastrar</th>
                                        </tr>
                                    </thead>
                                    <tr ng-repeat="pendencia in pendencias.elementos">
                                        <td>{{pendencia[0].id_produto}}</td>
                                        <td>{{pendencia[0].nome_produto}}</td>
                                        <td>{{pendencia[0].quantidade}}</td>
                                        <td>{{pendencia[0].grade.str}}</td>
                                        <td><input type="number" class="form-control" ng-model="pendencia[0].divisao"></td>
                                        <td><button class="btn btn-primary" ng-click="setPendencia(pendencia[0], pendencia[0].divisao)" data-toggle="modal" data-target="#cadastroLotes"><i class="fas fa-plus-circle"></i></button></td>
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
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
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
                                        <td>{{l.produto.id}}</td>
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
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-trash-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Edite os dados de seu Lote</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
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
                                        <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Codigo Fabricante</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtname" type="text" ng-model="lote.codigo_fabricante" required data-parsley-type="email" placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    

                                    <hr>
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
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center"> Tem certeza de que deseja excluir este Lote?</p>

                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" ng-click="deletarLote(lote)">Sim</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Não</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content --> 


                <!-- jquery 3.3.1 -->
                <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
                <script src="assets/vendor/jquery/jquery.mask.min.js"></script>
                <script src="assets/libs/js/form-mask.js"></script>

                <!-- bootstap bundle js -->
                <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
                <!-- datatables js -->

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