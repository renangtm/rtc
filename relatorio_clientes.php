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

    <body ng-controller="crtClienteRelatorio">
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
                                    <h2 class="pageheader-title">Relatorio de Clientes</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Relatorio de Clientes</li>
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
                                            <select ng-model="filtro" ng-change="changeFiltro()" class="form-control">
                                                <option ng-value="f" ng-repeat="f in filtros">{{f.nome}}</option>
                                            </select>
                                            <hr>
                                            QTD: {{quantidade}}
                                            <hr>
                                            <table id="clientes" class="table table-striped table-bordered first">
                                                <thead>
                                                    <tr>
                                                        <th>Cor</th>
                                                        <th data-ordem="cliente.id">Id.</th>
                                                        <th data-ordem="cliente.razao_social">Razao Social</th>
                                                        <th data-ordem="cliente.cidade.nome">Cidade</th>
                                                        <th data-ordem="cliente.estado.sigla">Estado</th>
                                                        <th data-ordem="cliente.cnpj">CNPJ/CPF</th>
                                                        <th>Email</th>
                                                        <th>Telefone</th>
                                                        <th data-ordem="cliente.classe_virtual">Classe</th>
                                                        <th><i class="fas fa-edit"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="cliente in clientes.elementos" style="font-size:13px;font-weight: bold;color:{{getClasse(cliente[0]).cor}}">
                                                        <td style="width:70px;background-color:{{getClasse(cliente[0]).cor}}"></td>
                                                        <td>{{cliente[0].id}}</td>
                                                        <td>{{cliente[0].razao_social}}</td>
                                                        <td>{{cliente[0].cidade}}</td>
                                                        <td>{{cliente[0].estado}}</td>
                                                        <td>{{cliente[0].inscricao}}</td>
                                                        <td><email entidade="Cliente" atributo="cliente[0].email" senha="false" alterar="false"></email></td>
                                                        <td>
                                                            <div style="width:100%;max-height:100px;overflow-y: scroll">
                                                                <strong ng-repeat="telefone in cliente[0].telefones">
                                                                    {{telefone.numero}}
                                                                    <hr>
                                                                </strong>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <select class="form-control" style="width:200px" ng-model="cliente[0].classe" ng-change="atualizar(cliente[0])">
                                                                <option ng-repeat="classe in classes" ng-value="classe.id">{{classe.nome}}</option>
                                                            </select>
                                                        </td>
                                                        <td><button class="btn btn-outline-light" ng-click="setCliente(cliente[0])" data-toggle="modal" data-target="#add"><i class="fas fa-edit"></i></button></td>
                                                </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Cor</th>
                                                        <th>Id.</th>
                                                        <th>Razao Social</th>
                                                        <th>Cidade</th>
                                                        <th>Estado</th>
                                                        <th>CNPJ/CPF</th>
                                                        <th>Email</th>
                                                        <th>Telefone</th>
                                                        <th>Classe</th>
                                                        <th><i class="fas fa-edit"></i></th>
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

                <!-- /.modal-content EDIT --> 
                
                <!-- /.modal-content --> 				

                <div class="modal fade in" id="add" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-plus-circle fa-3x"></i>&nbsp;&nbsp;&nbsp;Adicione os dados de seu Cliente</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="add-form" ng-submit="mergeCliente()" parsley-validate>
                                    <div class="form-group row">
                                        <label for="txtname" class="col-3 col-lg-3 col-form-label text-left">Codigo</label>
                                        <div class="col-9 col-lg-9">
                                            <input id="txtname" type="number" ng-model="cliente.codigo">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtname" class="col-3 col-lg-3 col-form-label text-left">Codigo Contimatic</label>
                                        <div class="col-9 col-lg-9">
                                            <input id="txtname" type="number" ng-model="cliente.codigo_contimatic">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtname" class="col-3 col-lg-3 col-form-label text-left">Razao social</label>
                                        <div class="col-9 col-lg-9">
                                            <input id="txtname" type="text" ng-model="cliente.razao_social" required data-parsley-type="email" placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtnamef" class="col-3 col-lg-3 col-form-label text-left">Nome Fantasia</label>
                                        <div class="col-9 col-lg-9">
                                            <input id="txtnamef" type="text" ng-model="cliente.nome_fantasia" required data-parsley-type="email" placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtnamef" class="col-3 col-lg-3 col-form-label text-left">Limite de Credito</label>
                                        <div class="col-9 col-lg-9">
                                            <input id="txtnamef" type="text" ng-model="cliente.limite_credito" required data-parsley-type="email" placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-9 col-lg-10">
                                            <email entidade="Cliente" atributo="cliente.email" senha="false" alterar="true"></email>
                                        </div>
                                    </div>
                                    <div class="col" style="padding-top: 5px;">
                                        <div class="row">
                                            <div class="col-md-6" style="text-align:center">
                                                <label class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" name="radio-inline" data-ng-value="false" data-ng-model="cliente.pessoa_fisica" class="custom-control-input"><span class="custom-control-label">Pessoa Jurídica</span>
                                                </label>
                                            </div>
                                            <div class="col-md-6" style="text-align:center">
                                                <label class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" name="radio-inline" data-ng-value="true" data-ng-model="cliente.pessoa_fisica" checked="" class="custom-control-input"><span class="custom-control-label">Pessoa Física</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">
                                            Please provide a valid text.
                                        </div>
                                    </div>
                                    <div class="form-group row" ng-if="!cliente.pessoa_fisica">
                                        <label for="txtcnpj" class="col-3 col-lg-2 col-form-label text-left">CNPJ</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtcnpj" type="text" ng-model="cliente.cnpj.valor" required placeholder="00.000.000/0000-00" class="form-control cnpj">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" ng-if="!cliente.pessoa_fisica">
                                        <label for="txtcnpj" class="col-3 col-lg-2 col-form-label text-left">Insc. Est</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtcnpj" type="text" ng-model="cliente.inscricao_estadual" required placeholder="000.000.000.000" class="form-control ie">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" ng-if="cliente.pessoa_fisica">
                                        <label for="txtcpf" class="col-3 col-lg-2 col-form-label text-left">CPF</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtcpf" type="text" ng-model="cliente.cpf.valor" required placeholder="000.000.000-00" class="form-control cpf">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" ng-if="cliente.pessoa_fisica">
                                        <label for="txtrg" class="col-3 col-lg-2 col-form-label text-left">RG</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtrg" type="text" ng-model="cliente.rg.valor" required placeholder="000.000.000-00" class="form-control rg">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="txtend" class="col-3 col-lg-2 col-form-label text-left">Endereço</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtend" type="text" ng-model="cliente.endereco.rua" required data-parsley-type="email" placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtendnum" class="col-3 col-lg-2 col-form-label text-left">Número</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtendnum" type="text" ng-model="cliente.endereco.numero" required data-parsley-type="email" placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtbairro" class="col-3 col-lg-2 col-form-label text-left">Bairro</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtbairro" ng-model="cliente.endereco.bairro" type="text" required placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label  class="col-3 col-lg-4 col-form-label text-left">Categoria Cliente</label>
                                        <div class="col-9 col-lg-8">
                                            <select ng-model="cliente.categoria" class="form-control">
                                                <option ng-repeat="categoria in categorias_cliente" ng-value="categoria">{{categoria.nome}}</option>
                                            </select>
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
                                            <select ng-model="cliente.endereco.cidade" class="form-control">
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
                                            <input id="txtcep" type="text" ng-model="cliente.endereco.cep.valor" required placeholder="" class="form-control cep" maxlength="9">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtsuf" class="col-3 col-form-label text-left">Tem Suframa ?</label>
                                        <div class="col-9">
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="radio-inline2" data-ng-value="true" data-ng-model="cliente.suframado" class="custom-control-input"><span class="custom-control-label">Sim</span>
                                            </label>
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="radio-inline2" data-ng-value="false" data-ng-model="cliente.suframado" checked="" class="custom-control-input"><span class="custom-control-label">Nao</span>
                                            </label>

                                        </div>
                                        <div class="invalid-feedback">
                                            Please provide a valid text.
                                        </div>
                                    </div>
                                    <div class="form-group row" ng-if="cliente.suframado">
                                        <label for="txtsuf" class="col-3 col-lg-2 col-form-label text-left">Suframa</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtsuf" type="text" ng-model="cliente.inscricao_suframa" placeholder="000000000" class="form-control txtsuf" maxlength="9">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="margin: 5px 0px;">
                                    <div class="form-group row">

                                        <div class="col-md-10">
                                            Categorias
                                            <hr>
                                            <select ng-model="categoria_prospeccao" class="form-control">
                                                <option ng-repeat="categoria in categorias_prospeccao" ng-value="categoria">{{categoria.nome}}</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            Adc
                                            <hr>
                                            <button class="btn btn-primary" ng-click="addCategoriaProspeccao()" type="button"><i class="fa fa-plus"></i></button>
                                            <input id="uploaderDocumentoCliente" style="display: none" type="file" multiple>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <table class="table table-striped table-bordered first">
                                            <thead>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th><i class="fa fa-times"></i></th>
                                                </tr>
                                            </thead>
                                            <tr ng-repeat="cat in categorias_prospeccao_cliente">
                                                <td>{{cat.nome}}</td>
                                                <td class="product"><button type="button" class="btn remove-product" ng-click="removeCategoriaProspeccao(cat)"><i class="fa fa-times"></i></button></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <hr style="margin: 30px 0px;">
                                    <div class="form-group row">

                                        <div class="col-md-10">
                                            Telefone
                                            <hr>
                                            <telefone model="telefone.numero"></telefone>
                                        </div>

                                        <div class="col-md-2">
                                            Adc
                                            <hr>
                                            <button class="btn btn-primary" ng-click="addTelefone()" type="button"><i class="fa fa-plus"></i></button>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <table class="table table-striped table-bordered first">
                                            <thead>
                                                <tr>
                                                    <th>Número</th>
                                                    <th><i class="fa fa-times"></i></th>
                                                </tr>
                                            </thead>
                                            <tr ng-repeat="t in cliente.telefones">
                                                <td>{{t.numero}}</td>
                                                <td class="product"><button type="button" class="btn remove-product" ng-click="removeTelefone(t)"><i class="fa fa-times"></i></button></td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                    <hr style="margin: 30px 0px;">
                                    <div class="form-group row">

                                        <div class="col-md-10">
                                            Documento
                                            <hr>
                                            <select ng-model="documento.categoria" class="form-control">
                                                <option ng-repeat="categoria in categorias_documento" ng-value="categoria">{{categoria.nome}}</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            Adc
                                            <hr>
                                            <button class="btn btn-primary" onclick="$('#uploaderDocumentoCliente').click()" type="button"><i class="fa fa-plus"></i></button>
                                            <input id="uploaderDocumentoCliente" style="display: none" type="file" multiple>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <table class="table table-striped table-bordered first">
                                            <thead>
                                                <tr>
                                                    <th>Documento</th>
                                                    <th>Abrir</th>
                                                    <th><i class="fa fa-times"></i></th>
                                                </tr>
                                            </thead>
                                            <tr ng-repeat="doc in cliente.documentos">
                                                <td>{{doc.categoria.nome}}</td>
                                                <td><a class="btn btn-primary" target="_blank" ng-href="{{doc.link}}"><i class="fas fa-folder-open"></i></a></td>
                                                <td class="product"><button type="button" class="btn remove-product" ng-click="removeDocumento(doc)"><i class="fa fa-times"></i></button></td>
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