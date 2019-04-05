<!doctype html>
<html lang="en" ng-app="appRtc">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">

        <script src="js/angular.min.js"></script>
        <script src="js/rtc.js?2"></script>
        <script src="js/filters.js?2"></script>
        <script src="js/services.js?2"></script>
        <script src="js/controllers.js?2"></script>    

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
            .page-link:hover {
                color:#fff !important;
            }
        </style>
    </head>

    <body ng-controller="crtClientes">
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
                                    <h2 class="pageheader-title">Clientes</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Clientes</li>
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
                                                <a href="#" class="btn btn-primary" data-title="Add" data-toggle="modal" data-target="#add" ng-click="novoCliente()"><i class="fas fa-plus-circle m-r-10"></i>Adicionar Cliente</a>
                                            </div>
                                            <table id="clientes" class="table table-striped table-bordered first">
                                                <thead>
                                                    <tr>
                                                        <th data-ordem="cliente.codigo">Cod.</th>
                                                        <th data-ordem="cliente.razao_social">Raz Soc.</th>
                                                        <th data-ordem="cliente.nome_fantasia">Nom Fant</th>
                                                        <th data-ordem="cliente.inscricao_estadual">IE</th>
                                                        <th data-ordem="cliente.cnpj">CNPJ</th>
                                                        <th data-ordem="cliente.cpf">CPF</th>
                                                        <th data-ordem="cliente.limite_credito">Lim Cre</th>
                                                        <th data-ordem="cliente.termino_limite">Fim Lim</th>
                                                        <?php if ($usuario->temPermissao(Sistema::P_EMPRESA_CLIENTE()->m("C"))) { ?>
                                                        <th data-ordem="cliente.empresa.nome">Empresa</th>
                                                        <?php } ?>
                                                        <th width="150px">Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat-start="cliente in clientes.elementos">
                                                        <td class="text-center">{{cliente[0].codigo}}</td>
                                                        <td>{{cliente[0].razao_social}}</td>
                                                        <td>{{cliente[0].nome_fantasia}}</td>
                                                        <td>{{cliente[0].inscricao_estadual}}</td>
                                                        <td>{{cliente[0].pessoa_fisica?'------':cliente[0].cnpj.valor}}</td>
                                                        <td>{{cliente[0].pessoa_fisica?cliente[0].cpf.valor:'------'}}</td>
                                                        <td>{{cliente[0].limite_credito}}</td>
                                                        <td style="{{(cliente[0].inicio_limite > data_atual|| cliente[0].termino_limite<data_atual)?'background-color:#71748d;color:#FFFFFF':'' }}">{{cliente[0].termino_limite| data}}<button class="btn btn-default" style="float:right" ng-if="cliente[0].inicio_limite > data_atual || cliente[0].termino_limite < data_atual"><i class="fa fa-address-card"></i></button></td>
                                                        <?php if ($usuario->temPermissao(Sistema::P_EMPRESA_CLIENTE()->m("C"))) { ?>
                                                        <td>{{cliente[0].empresa.nome}}</td>
                                                        <?php } ?>
                                                        <th>
                                                            <div class="product-btn">
                                                                <a href="#" class="btn btn-outline-light btninfo" data-toggle="collapse" ng-click="setCliente(cliente[0])" data-target="#demo{{cliente[0].id}}" class="accordion-toggle"><i class="fas fa-info-circle"></i></a>
                                                                <a href="#" class="btn btn-outline-light btnedit" data-title="Edit" ng-click="setCliente(cliente[0])" data-toggle="modal" data-target="#add"><i class="fas fa-pencil-alt"></i></a>
                                                                <a href="#" class="btn btn-outline-light btndel" data-title="Delete" ng-click="setCliente(cliente[0])" data-toggle="modal" data-target="#delete"><i class="fas fa-trash-alt"></i></a>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    <tr ng-repeat-end>
                                                        <td colspan="9" class="hiddenRow">
                                                            <div class="accordian-body collapse" id="demo{{cliente[0].id}}">
                                                                <div class="row mx-auto m-b-30">
                                                                    <div class="col">
                                                                        <table class="table table-bordered w-100">
                                                                            <tr>
                                                                                <td>IE:</td>
                                                                                <td>{{cliente[0].inscricao_estadual}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>CPF / CNPJ:</td>
                                                                                <td>{{cliente[0].pessoa_fisica?cliente[0].cpf.valor:cliente[0].cnpj.valor}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>suframa:</td>
                                                                                <td>{{cliente[0].inscricao_suframa}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Email:</td>
                                                                                <td><email entidade="Cliente" atributo="cliente[0].email" senha="false" alterar="false"></email></td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>	
                                                                    <div class="col">
                                                                        <table class="table-bordered w-100">
                                                                            <tr>
                                                                                <td>Endereço:</td>
                                                                                <td>{{cliente[0].endereco.rua}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Número:</td>
                                                                                <td>{{cliente[0].endereco.numero}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Bairro</td>
                                                                                <td>{{cliente[0].endereco.bairro}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Cidade</td>
                                                                                <td>{{cliente[0].endereco.cidade.nome}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Estado</td>
                                                                                <td>{{cliente[0].endereco.cidade.estado.sigla}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>CEP</td>
                                                                                <td>{{cliente[0].endereco.cep.valor}}</td>
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
                                                        <th>Raz Soc.</th>
                                                        <th>Nom Fant</th>
                                                        <th>IE</th>
                                                        <th>CNPJ</th>
                                                        <th>CPF</th>
                                                        <th>Lim Cre</th>
                                                        <th>Fim Lim</th>
                                                        <?php if ($usuario->temPermissao(Sistema::P_EMPRESA_CLIENTE()->m("C"))) { ?>
                                                        <th>Empresa</th>
                                                        <?php } ?>
                                                        <th width="180px">Ação</th>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                            <!-- paginação  -->
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination justify-content-end">
                                                        <li class="page-item" ng-click="clientes.prev()"><a class="page-link" href="">Anterior</a></li>
                                                        <li class="page-item" ng-repeat="pg in clientes.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></li>
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

                <!-- /.modal-content ADD --> 
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
                                    <?php if ($usuario->temPermissao(Sistema::P_EMPRESA_CLIENTE()->m("C"))) { ?>
                                    <div class="form-group row">
                                        <label  class="col-3 col-lg-4 col-form-label text-left">Empresa</label>
                                        <div class="col-9 col-lg-8">
                                            <select ng-model="cliente.empresa" class="form-control">
                                                <option ng-repeat="e in empresas_clientes" ng-value="e">{{e.nome}}</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
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
                                        <label for="txtname" class="col-3 col-lg-3 col-form-label text-left">Razão social</label>
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
                <!-- /.modal-content -->

                <!-- /.modal-content EDIT --> 
                <div class="modal fade in" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-pencil-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Edite os dados de seu Cliente</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group row">
                                        <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Nome</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtname" type="text" required placeholder="Agro Fauna Comercio De Insumos Ltda" class="form-control is-invalid">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtemail" class="col-3 col-lg-2 col-form-label text-left">Email</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtemail" type="email" required data-parsley-type="email" placeholder="elias@agrofauna.com.br" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtcnpj" class="col-3 col-lg-2 col-form-label text-left">CPF/CNPJ</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtcnpj" type="text" required data-parsley-type="email" placeholder="47.626.510/0001-32" class="form-control cnpj" >
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txttel" class="col-3 col-lg-2 col-form-label text-left">Telefone</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txttel" type="text" required placeholder="(11)2324-2452" class="form-control sp_celphones">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtend" class="col-3 col-lg-2 col-form-label text-left">Endereço</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtend" type="text" required data-parsley-type="email" placeholder="Rua: Coutinho Cavalcante" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtendnum" class="col-3 col-lg-2 col-form-label text-left">Número</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtendnum" type="text" required data-parsley-type="email" placeholder="00" class="form-control" data-parsley-id="5" aria-describedby="parsley-id-5">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtbairro" class="col-3 col-lg-2 col-form-label text-left">Bairro</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtbairro" type="text" required placeholder="Jardim Alto Alegnure" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="cidades" class="col-3 col-lg-2 col-form-label text-left">Cidade</label>
                                        <div class="col-9 col-lg-10">
                                            <select name="cidades" class="form-control"> 
                                                <option value="estado">Selecione a Cidade</option> 
                                                <option value="ac">Acre</option> 
                                                <option value="al">Alagoas</option> 
                                                <option value="am">Amazonas</option> 
                                                <option value="ap">Amapá</option> 
                                                <option value="ba">Bahia</option> 
                                                <option value="ce">Ceará</option> 
                                                <option value="df">Distrito Federal</option> 
                                                <option value="es">Espírito Santo</option> 
                                                <option value="go">Goiás</option> 
                                                <option value="ma">Maranhão</option> 
                                                <option value="mt">Mato Grosso</option> 
                                                <option value="ms">Mato Grosso do Sul</option> 
                                                <option value="mg">Minas Gerais</option> 
                                                <option value="pa">Pará</option> 
                                                <option value="pb">Paraíba</option> 
                                                <option value="pr">Paraná</option> 
                                                <option value="pe">Pernambuco</option> 
                                                <option value="pi">Piauí</option> 
                                                <option value="rj">Rio de Janeiro</option> 
                                                <option value="rn">Rio Grande do Norte</option> 
                                                <option value="ro">Rondônia</option> 
                                                <option value="rs">Rio Grande do Sul</option> 
                                                <option value="rr">Roraima</option> 
                                                <option value="sc">Santa Catarina</option> 
                                                <option value="se">Sergipe</option> 
                                                <option value="sp" selected>São Jose do Rio Preto</option> 
                                                <option value="to">Tocantins</option> 
                                            </select>
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="estados" class="col-3 col-lg-2 col-form-label text-left">Estado</label>
                                        <div class="col-9 col-lg-10">
                                            <select name="estados" class="form-control"> 
                                                <option value="estado">Selecione o Estado</option> 
                                                <option value="ac">Acre</option> 
                                                <option value="al">Alagoas</option> 
                                                <option value="am">Amazonas</option> 
                                                <option value="ap">Amapá</option> 
                                                <option value="ba">Bahia</option> 
                                                <option value="ce">Ceará</option> 
                                                <option value="df">Distrito Federal</option> 
                                                <option value="es">Espírito Santo</option> 
                                                <option value="go">Goiás</option> 
                                                <option value="ma">Maranhão</option> 
                                                <option value="mt">Mato Grosso</option> 
                                                <option value="ms">Mato Grosso do Sul</option> 
                                                <option value="mg">Minas Gerais</option> 
                                                <option value="pa">Pará</option> 
                                                <option value="pb">Paraíba</option> 
                                                <option value="pr">Paraná</option> 
                                                <option value="pe">Pernambuco</option> 
                                                <option value="pi">Piauí</option> 
                                                <option value="rj">Rio de Janeiro</option> 
                                                <option value="rn">Rio Grande do Norte</option> 
                                                <option value="ro">Rondônia</option> 
                                                <option value="rs">Rio Grande do Sul</option> 
                                                <option value="rr">Roraima</option> 
                                                <option value="sc">Santa Catarina</option> 
                                                <option value="se">Sergipe</option> 
                                                <option value="sp" selected>São Paulo</option> 
                                                <option value="to">Tocantins</option> 
                                            </select>
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtcep" class="col-3 col-lg-2 col-form-label text-left">CEP</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtcep" type="text" required placeholder="15055-300" class="form-control cep" maxlength="9">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                                <button class="btn btn-primary" onclick="cadastrarProduto()">
                                    <i class="fas fa-save"></i> &nbsp; Salvar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content --> 				



                <!-- /.modal-content DELETE --> 
                <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-trash-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Delete os dados de seu Cliente</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center"> Tem certeza de que deseja excluir este Cliente?</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" ng-click="deleteCliente(cliente)">Sim</button>
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

                                            $(document).on('keyup', '.txtsuf', function () {
                                                $(this).mask('000000000');
                                            });
                                            $(document).on('keyup', '.cnpj', function () {
                                                $(this).mask('00.000.000/0000-00', {reverse: true});
                                            });
                                            $(document).on('keyup', '.cpf', function () {
                                                $(this).mask('000.000.000-00', {reverse: true});
                                            });
                                            $(document).on('keyup', '.rg', function () {
                                                $(this).mask('99.999.999-A', {reverse: true});
                                            });
                                            $(document).on('keyup', '.ie_', function () {
                                                $(this).mask('000000000000000', {reverse: true});
                                            });

                                            $(document).ready(function () {
                                                $('.btninfo').tooltip({title: "Mais informação", placement: "top"});
                                                $('.btnedit').tooltip({title: "Editar", placement: "top"});
                                                $('.btndel').tooltip({title: "Deletar", placement: "top"});
                                            });


                </script>

                </body>

                </html>
