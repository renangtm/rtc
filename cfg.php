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
                                    <h2 class="pageheader-title">Colaboradores</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Colaboradores</li>
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
                            .selecionavel{
                                cursor:pointer;
                            }
                            .selecionavel:hover{
                                background-color:#E3E3E3 !important;
                            }

                            .selecionado{
                                border-right:7px solid #5f5f5f;
                                border-bottom: 2px solid #5f5f5f;
                                cursor:pointer;
                            }

                        </style>
                        <div class="row">
                            <!-- ============================================================== -->
                            <!-- basic table  -->
                            <!-- ============================================================== -->
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body row">
                                        <div class="table-responsive col-md-7" id="dvUsuarios">
                                            <div class="product-btn m-b-20">
                                                <a href="#" class="btn btn-primary" data-title="Add" data-toggle="modal" data-target="#add" ng-click="novoUsuario()"><i class="fas fa-plus-circle m-r-10"></i>Adicionar Colaborador</a>
                                            </div>
                                            <table id="clientes" class="table table-striped table-bordered first">
                                                <thead>
                                                    <tr>
                                                        <th data-ordem="usuario.id">Cod.</th>
                                                        <th data-ordem="usuario.nome">Nome</th>
                                                        <th data-ordem="usuario.email_usu.endereco">Email</th>
                                                        <th width="150px">Acao</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr id="tr_{{usuari[0].id}}" class="{{usuari[0].id===usuario.id?'selecionado':'selecionavel'}}" ng-click="setUsuario(usuari[0])" ng-repeat-start="usuari in usuarios.elementos">
                                                        <td>{{usuari[0].id}}</td>
                                                        <td>{{usuari[0].nome}}</td>
                                                        <td><email entidade="Usu&aacute;rio" atributo="usuari[0].email" senha="true" alterar="false"></email></td>
                                                <th style="{{usuari[0].id===usuario.id?'border-right:2px solid #5F5F5F':''}}">
                                                    <div class="product-btn">
                                                        <a href="#" class="btn btn-outline-light btninfo" data-toggle="collapse" ng-click="setUsuario(usuari[0])" data-target="#demo{{usuari[0].id}}" class="accordion-toggle"><i class="fas fa-info-circle"></i></a>
                                                        <a href="#" class="btn btn-outline-light btnedit" data-title="Edit" ng-click="setUsuario(usuari[0])" data-toggle="modal" data-target="#add"><i class="fas fa-pencil-alt"></i></a>
                                                        <a href="#" class="btn btn-outline-light btndel" data-title="Delete" ng-click="setUsuario(usuari[0])" data-toggle="modal" data-target="#delete"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </th>
                                                </tr>
                                                <tr ng-repeat-end>
                                                    <td colspan="6" class="hiddenRow">
                                                        <div class="accordian-body collapse" id="demo{{usuari[0].id}}">
                                                            <div class="row mx-auto m-b-30">	
                                                                <div class="col">
                                                                    <table class="table-bordered w-100">
                                                                        <tr>
                                                                            <td>Login:</td>
                                                                            <td>{{usuari[0].login}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Senha:</td>
                                                                            <td><?php
                                                                                $str = "?>{{usuari[0].senha}}<?php";
                                                                                echo md5($str);
                                                                             ?></td>
                                                                        </tr>
                                                                         <tr>
                                                                            <td>CPF:</td>
                                                                            <td>{{usuari[0].cpf.valor}}</td>
                                                                        </tr>
                                                                         <tr>
                                                                            <td>RG:</td>
                                                                            <td>{{usuari[0].rg.valor}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Telefone:</td>
                                                                            <td>{{usuari[0].telefones}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Endereco:</td>
                                                                            <td>{{usuari[0].endereco.rua}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Numero:</td>
                                                                            <td>{{usuari[0].endereco.numero}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Bairro</td>
                                                                            <td>{{usuari[0].endereco.bairro}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Cidade</td>
                                                                            <td>{{usuari[0].endereco.cidade.nome}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Estado</td>
                                                                            <td>{{usuari[0].endereco.cidade.estado.sigla}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>CEP</td>
                                                                            <td>{{usuari[0].endereco.cep.valor}}</td>
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
                                                        <th>Nome</th>
                                                        <th>Email</th>
                                                        <th>Acao</th>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                            <!-- paginacao  -->
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination justify-content-end">
                                                        <li class="page-item" ng-click="usuarios.prev()"><a class="page-link" href="">Anterior</a></li>
                                                        <li class="page-item" ng-repeat="pg in usuarios.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></li>
                                                        <li class="page-item" ng-click="usuarios.next()"><a class="page-link" href="">Proximo</a></li>
                                                    </ul>
                                                </nav>
                                            </div>

                                        </div>
                                        <div class="col-md-5" id="dvPermissoes" style="margin-top:{{marginTop}}px;border:2px solid #5F5F5F;padding:10px;margin-left:0px;border-top-right-radius: 10px;border-bottom-right-radius: 10px;border-top-left-radius: 2px; border-bottom-left-radius: 10px">
                                            Permiss&otilde;es do usu&aacute;rio: <strong>{{usuario.id}} - {{usuario.nome}}</strong>
                                            <hr>
                                            <button class="btn btn-outline-light" ng-click="mergeUsuario()"><i class="fas fa-check"></i>&nbspConfirmar alteracoes</button>
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
                                                    <tr ng-repeat="p in usuario.permissoes">
                                                        <td>{{p.nome}}</td>
                                                        <td><input class="form-control" type="checkbox" ng-value="true" ng-model="p.alt"></td>
                                                        <td><input class="form-control" type="checkbox" ng-value="true" ng-model="p.in"></td>
                                                        <td><input class="form-control" type="checkbox" ng-value="true" ng-model="p.del"></td>
                                                        <td><input class="form-control" type="checkbox" ng-value="true" ng-model="p.cons"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
                <div class="modal fade in" id="add" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                               
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle">
                                    <div ng-if="usuario.id===0">
                                        <i class="fas fa-pencil-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Adicione
                                    </div>
                                    <div ng-if="usuario.id>0">
                                        <i class="fas fa-plus-circle fa-3x"></i>&nbsp;&nbsp;&nbsp;Altere
                                    </div>
                                    
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form id="add-form" ng-submit="mergeUsuario()" parsley-validate>
                                    <div class="form-group row">
                                        <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Nome</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtname" type="text" ng-model="usuario.nome" required data-parsley-type="email" placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Login</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtname" type="text" ng-model="usuario.login" required data-parsley-type="email" placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Senha:</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtname" type="password" ng-model="usuario.senha" required data-parsley-type="email" placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-9 col-lg-10">
                                            <email entidade="usu&aacute;rio" atributo="usuario.email" senha="true" alterar="true"></email>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtcnpj" class="col-3 col-lg-2 col-form-label text-left">CPF</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtcnpj" type="text" ng-model="usuario.cpf.valor" required class="form-control cpf">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtcnpj" class="col-3 col-lg-2 col-form-label text-left">RG</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtcnpj" type="text" ng-model="usuario.rg.valor" required class="form-control rg">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtend" class="col-3 col-lg-2 col-form-label text-left">Endereco</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtend" type="text" ng-model="usuario.endereco.rua" required data-parsley-type="email" placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtendnum" class="col-3 col-lg-2 col-form-label text-left">Numero</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtendnum" type="text" ng-model="usuario.endereco.numero" required data-parsley-type="email" placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtbairro" class="col-3 col-lg-2 col-form-label text-left">Bairro</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtbairro" ng-model="usuario.endereco.bairro" type="text" required placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label  class="col-3 col-lg-2 col-form-label text-left">Estado</label>
                                        <div class="col-9 col-lg-10">
                                            <select ng-model="estado" class="form-control">
                                                <option ng-repeat="e in estados" ng-value="e">{{e.sigla}}</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label  class="col-3 col-lg-2 col-form-label text-left">Cidade</label>
                                        <div class="col-9 col-lg-10">
                                            <select ng-model="usuario.endereco.cidade" class="form-control">
                                                <option ng-repeat="cidade in estado.cidades" ng-value="cidade">{{cidade.nome}}</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtcep" class="col-3 col-lg-2 col-form-label text-left">CEP</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtcep" type="text" ng-model="usuario.endereco.cep.valor" required placeholder="" class="form-control cep" maxlength="9">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <div class="col-md-10">
                                            Telefone
                                            <hr>
                                            <input id="txttel" type="text" ng-model="telefone.numero" placeholder="" class="form-control sp_celphones" maxlength="9">
                                        </div>

                                        <div class="col-md-2">
                                            Adc
                                            <hr>
                                            <button class="btn btn-success" ng-click="addTelefone()" type="button"><i class="fa fa-plus"></i></button>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <table class="table table-striped table-bordered first">
                                            <thead>
                                                <tr>
                                                    <th>N&uacute;mero</th>
                                                    <th><i class="fa fa-times"></i></th>
                                                </tr>
                                            </thead>
                                            <tr ng-repeat="t in usuario.telefones">
                                                <td>{{t.numero}}</td>
                                                <td><button type="button" class="btn btn-danger" ng-click="removeTelefone(t)"><i class="fa fa-times"></i></button></td>
                                            </tr>
                                        </table>
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
                <!-- /.modal-content -->

                <!-- /.modal-content EDIT --> 

                <!-- /.modal-content --> 				



                <!-- /.modal-content DELETE --> 
                <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-trash-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Delete os dados de seu Usuario</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center"> Tem certeza de que deseja excluir este Usuario?</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" ng-click="deleteUsuario(usuario)">Sim</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Nao</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content --> 

                <!-- /.modal-content LOADING --> 
            <div class="modal fade modal-sm"id="loading" tabindex="-1" style="position:fixed;left:calc(100% - 380px)" role="dialog" aria-labelledby="edit" aria-hidden="true">
                <div class="modal-dialog" style="position:absolute;top:calc(100% - 380px)">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-wifi"></i>&nbsp;&nbsp;&nbsp;Aguarde</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body text-center">

                            <span style="margin-top:30px;" class="dashboard-spinner spinner-success spinner-sm "></span>
                            <br>
                            <h3 style="margin-top:20px;">Carregando as informações...</h3>

                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>


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

                                var sh = false;
                                var it = null;

                                loading.show = function () {
                                    if (it != null) {
                                        clearInterval(it);
                                    }
                                    it = setInterval(function () {
                                        $("#loading").modal("show");
                                        if ($("#loading").hasClass('in')) {
                                            clearInterval(it);
                                        }
                                    }, 300)

                                }

                                loading.close = function () {

                                    if (it != null) {
                                        clearInterval(it);
                                    }
                                    it = setInterval(function () {
                                        $("#loading").modal("hide");
                                        if (!$("#loading").hasClass('in')) {
                                            clearInterval(it);
                                        }
                                    }, 300)

                                }

                                            $(document).ready(function () {
                                                $('.btninfo').tooltip({title: "Mais informacoes", placement: "top"});
                                                $('.btnedit').tooltip({title: "Editar", placement: "top"});
                                                $('.btndel').tooltip({title: "Deletar", placement: "top"});
                                            });


                                            $(document).on('keyup', '.cpf', function () {
                                                $(this).mask('000.000.000-00', {reverse: true});
                                            });
                                            $(document).on('keyup', '.rg', function () {
                                                $(this).mask('99.999.999-A', {reverse: true});
                                            });



                </script>

                </body>

                </html>
