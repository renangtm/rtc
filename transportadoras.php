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
        </style>
    </head>

    <body ng-controller="crtTransportadoras">
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
                                    <h2 class="pageheader-title">Transportadoras</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Transportadoras</li>
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
                                                <a href="#" class="btn btn-primary" data-title="Add" data-toggle="modal" data-target="#add" ng-click="novoTransportadora()"><i class="fas fa-plus-circle m-r-10"></i>Adicionar Transportadora</a>
                                                <a href="#" class="btn btn-default" data-title="Add" data-toggle="modal" data-target="#simulacaoFrete"><i class="fas fa-adjust m-r-10"></i>Simulacao de frete</a>
                                            </div>
                                            <table id="transportadoras" class="table table-striped table-bordered first">
                                                <thead>
                                                    <tr>
                                                        <th data-ordem="transportadora.id">Cod.</th>
                                                        <th data-ordem="transportadora.razao_social">Raz Soc.</th>
                                                        <th data-ordem="transportadora.nome_fantasia">Nom Fant</th>
                                                        <th data-ordem="transportadora.despacho">Despacho</th>
                                                        <th data-ordem="transportadora.cnpj">CNPJ</th>
                                                        <th data-ordem="transportadora.inscricao_estadual">IE</th>
                                                        <th data-ordem="transportadora.habilitada">Habilitada</th>
                                                        <th width="150px">Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat-start="transportadora in transportadoras.elementos">
                                                        <td>{{transportadora[0].id}}</td>
                                                        <td>{{transportadora[0].razao_social}}</td>
                                                        <td>{{transportadora[0].nome_fantasia}}</td>
                                                        <td>{{transportadora[0].despacho}}</td>
                                                        <td>{{transportadora[0].cnpj.valor}}</td>
                                                        <td>{{transportadora[0].inscricao_estadual}}</td>
                                                        <td>{{transportadora[0].habilitada?'Sim':'Nao'}}</td>
                                                        <th>
                                                            <div class="product-btn">
                                                                <a href="#" class="btn btn-outline-light btninfo" data-toggle="collapse" ng-click="setTransportadora(transportadora[0])" data-target="#demo{{transportadora[0].id}}" class="accordion-toggle"><i class="fas fa-info-circle"></i></a>
                                                                <a href="#" class="btn btn-outline-light btnedit" data-title="Edit" ng-click="setTransportadora(transportadora[0])" data-toggle="modal" data-target="#add"><i class="fas fa-pencil-alt"></i></a>
                                                                <a href="#" class="btn btn-outline-light btndel" data-title="Delete" ng-click="setTransportadora(transportadora[0])" data-toggle="modal" data-target="#delete"><i class="fas fa-trash-alt"></i></a>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    <tr ng-repeat-end>
                                                        <td colspan="6" class="hiddenRow">
                                                            <div class="accordian-body collapse" id="demo{{transportadora[0].id}}">
                                                                <div class="row mx-auto m-b-30">
                                                                    <div class="col">
                                                                        <table class="table table-bordered w-100">
                                                                            <tr>
                                                                                <td>Email:</td>
                                                                                <td>{{transportadora[0].email.endereco}}</td>
                                                                            </tr>
                                                                            <tr ng-if="transportadora[0].tabela == null">
                                                                                <td style="color:SteelBlue">Criar tabela:</td>
                                                                                <td><input type="text" class="form-control" ng-model="tabela.nome" placeholder="Nome da tabela"></td>
                                                                                <td><button class="btn btn-success" ng-click="criarTabela(transportadora[0])" style="width:100%"><i class="fas fa-plus"></i></button></td>
                                                                            </tr>
                                                                            <tr ng-if="transportadora[0].tabela != null">
                                                                                <td style="color:SteelBlue">Tabela: {{transportadora[0].tabela.nome}}</td>
                                                                                <td style="color:SteelBlue">{{transportadora[0].tabela.regras.length}} formulas</td>
                                                                                <td><button class="btn btn-success" ng-click="selecionarTabela(transportadora[0])" style="width:100%" data-toggle="modal" data-target="#tabela"><i class="fas fa-edit"></i></button></td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>	
                                                                    <div class="col">
                                                                        <table class="table-bordered w-100">
                                                                            <tr>
                                                                                <td>Endereço:</td>
                                                                                <td>{{transportadora[0].endereco.rua}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Número:</td>
                                                                                <td>{{transportadora[0].endereco.numero}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Bairro</td>
                                                                                <td>{{transportadora[0].endereco.bairro}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Cidade</td>
                                                                                <td>{{transportadora[0].endereco.cidade.nome}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Estado</td>
                                                                                <td>{{transportadora[0].endereco.cidade.estado.sigla}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>CEP</td>
                                                                                <td>{{transportadora[0].endereco.cep.valor}}</td>
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
                                                        <th>Despacho</th>
                                                        <th>CNPJ</th>
                                                        <th>IE</th>
                                                        <th>Habilitada</th>
                                                        <th width="150px">Ação</th>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                            <!-- paginação  -->
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination justify-content-end">
                                                        <li class="page-item" ng-click="transportadoras.prev()"><a class="page-link" href="">Anterior</a></li>
                                                        <li class="page-item" ng-repeat="pg in transportadoras.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid':''}}">{{pg.numero + 1}}</a></li>
                                                        <li class="page-item" ng-click="transportadoras.next()"><a class="page-link" href="">Próximo</a></li>
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
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-plus-circle fa-3x"></i>&nbsp;&nbsp;&nbsp;Adicione os dados de sua Transportadora</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="add-form" ng-submit="mergeTransportadora()" parsley-validate>
                                    <div class="form-group row">
                                        <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Razao Social</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtname" type="text" ng-model="transportadora.razao_social" required data-parsley-type="email" placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtnamef" class="col-3 col-lg-2 col-form-label text-left">Nome Fantasia</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtnamef" type="text" ng-model="transportadora.nome_fantasia" required data-parsley-type="email" placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="txtemail" class="col-3 col-lg-2 col-form-label text-left">Email</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtemail" ng-model="transportadora.email.endereco" type="email" required data-parsley-type="email" placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 col-lg-4" style="padding-top: 5px;">
                                        <div class="row">
                                            <div class="col-md-6" style="text-align:center">
                                                <label class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" name="radio-inline" data-ng-value="true" data-ng-model="transportadora.habilitada" class="custom-control-input"><span class="custom-control-label">Habilitada</span>
                                                </label>
                                            </div>
                                            <div class="col-md-6" style="text-align:center">
                                                <label class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" name="radio-inline" data-ng-value="false" data-ng-model="transportadora.habilitada" checked="" class="custom-control-input"><span class="custom-control-label">Desabilitada</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">
                                            Please provide a valid text.
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtdesp" class="col-3 col-lg-2 col-form-label text-left">Taxa despacho</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtdesp" type="number" ng-model="transportadora.despacho" required class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtcnpj" class="col-3 col-lg-2 col-form-label text-left">CNPJ</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtcnpj" type="text" ng-model="transportadora.cnpj.valor" required placeholder="00.000.000/0000-00" class="form-control cpf">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtcnpj" class="col-3 col-lg-2 col-form-label text-left">Insc. Est</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtcnpj" type="text" ng-model="transportadora.inscricao_estadual" required placeholder="00.000.000/0000-00" class="form-control cpf">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="txtend" class="col-3 col-lg-2 col-form-label text-left">Endereço</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtend" type="text" ng-model="transportadora.endereco.rua" required data-parsley-type="email" placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtendnum" class="col-3 col-lg-2 col-form-label text-left">Número</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtendnum" type="text" ng-model="transportadora.endereco.numero" required data-parsley-type="email" placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtbairro" class="col-3 col-lg-2 col-form-label text-left">Bairro</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtbairro" ng-model="transportadora.endereco.bairro" type="text" required placeholder="" class="form-control">
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
                                            <select ng-model="transportadora.endereco.cidade" class="form-control">
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
                                            <input id="txtcep" type="text" ng-model="transportadora.endereco.cep.valor" required placeholder="" class="form-control cep" maxlength="9">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <div class="col-md-10">
                                            Telefone
                                            <hr>
                                            <input id="txttel" type="text" ng-model="telefone.numero" placeholder="" class="form-control cep" maxlength="9">
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
                                                    <th>Numero</th>
                                                    <th><i class="fa fa-times"></i></th>
                                                </tr>
                                            </thead>
                                            <tr ng-repeat="t in transportadora.telefones">
                                                <td>{{t.numero}}</td>
                                                <td><button type="button" class="btn btn-danger" ng-click="removeTelefone(t)"><i class="fa fa-times"></i></button></td>
                                            </tr>
                                        </table>
                                    </div>
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
                                            <button class="btn btn-success" onclick="$('#uploaderDocumentoTransportadora').click()" type="button"><i class="fa fa-plus"></i></button>
                                            <input id="uploaderDocumentoTransportadora" style="display: none" type="file" multiple>
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
                                            <tr ng-repeat="doc in transportadora.documentos">
                                                <td>{{doc.categoria.nome}}</td>
                                                <td><a class="btn btn-primary" target="_blank" ng-href="{{doc.link}}"><i class="fa fa-random"></i></a></td>
                                                <td><button type="button" class="btn btn-danger" ng-click="removeDocumento(doc)"><i class="fa fa-times"></i></button></td>
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
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-pencil-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Edite os dados de sua Transportadora</h5>
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
                                <button class="btn btn-primary">
                                    <i class="fas fa-save"></i> &nbsp; Salvar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content --> 				


                <!-- /.modal-content TABELA --> 
                <div class="modal fade" id="tabela" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-edit fa-3x"></i>&nbsp;&nbsp;&nbsp;Tabela {{tabela_selecionada.nome}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <button class="btn btn-default" ng-click="addRegra()"><i class="fas fa-plus"></i>&nbsp Inserir nova regra</button>

                                <button class="btn btn-default" data-toggle="modal" data-target="#testeIndividual"><i class="fas fa-adjust"></i>&nbsp Testar tabela</button>
                                <hr>
                                <table class="table table-striped table-bordered first">
                                    <thead>
                                        <tr>
                                            <th>Regra</th>
                                            <th>Copiar</th>
                                            <th>Abrir</th>
                                            <th><i class="fa fa-times"></i></th>
                                        </tr>
                                    </thead>
                                    <tr ng-repeat="regra in tabela_selecionada.regras">
                                        <td style="{{regra.id==0?'color:SteelBlue':''}}">{{(regra.id == 0) ? ((regra.copia > 0) ? ('Copia da regra ' + regra.copia) : 'Nova') : regra.id}}</td>
                                        <td><button class="btn btn-warning" ng-click="copiarRegra(regra)"><i class="fas fa-copy"></i></button></td>
                                        <td><button class="btn btn-success" ng-click="selecionarRegra(regra)" data-toggle="modal" data-target="#editarRegra"><i class="fas fa-edit"></i></button></td>
                                        <td><button class="btn btn-danger" ng-click="removerRegra(regra)"><i class="fas fa-times"></i></button></td>
                                    </tr>
                                </table>


                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" ng-click="mergeTransportadoraTabela()"><i class="fas fa-edit"></i>Salvar</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Não</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content --> 

                <!-- /.modal-content DELETE --> 
                <div class="modal fade" id="editarRegra" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-edit fa-3x"></i>&nbsp;&nbsp;&nbsp;Edite a regra {{regra.id}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">

                                Expressão condicional
                                <hr>
                                <textarea ng-model="regra.condicional" class="form-control" style="width:100%">

                                </textarea>
                                <br>
                                Expressão de valor
                                <hr>
                                <textarea ng-model="regra.resultante" class="form-control" style="width:100%">

                                </textarea>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Pronto</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content --> 

                <!-- /.modal-content TABELA --> 
                <div class="modal fade" id="simulacaoFrete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-adjust fa-3x"></i>&nbsp;&nbsp;&nbsp;Simulacao de frete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">

                                <div class="form-group row">
                                    <label  class="col-3 col-lg-2 col-form-label text-left">Estado</label>
                                    <div class="col-9 col-lg-10">
                                        <select ng-model="estado_teste" class="form-control">
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
                                        <select ng-model="cidade_teste" ng-change="attResultado()" class="form-control">
                                            <option ng-repeat="cidade in estado_teste.cidades" ng-value="cidade">{{cidade.nome}}</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please provide a valid text.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="txtendnum" class="col-3 col-lg-2 col-form-label text-left">Valor</label>
                                    <div class="col-9 col-lg-10">
                                        <input id="txtendnum" type="text" placeholder="00" ng-change="attResultado()" ng-model="valor_teste" class="form-control" data-parsley-id="5" aria-describedby="parsley-id-5">
                                        <div class="invalid-feedback">
                                            Please provide a valid text.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="txtendnum" class="col-3 col-lg-2 col-form-label text-left">Peso</label>
                                    <div class="col-9 col-lg-10">
                                        <input id="txtendnum" type="text" placeholder="00" ng-change="attResultado()" ng-model="peso_teste" class="form-control" data-parsley-id="5" aria-describedby="parsley-id-5">
                                        <div class="invalid-feedback">
                                            Please provide a valid text.
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer" style="text-align: center;font-weight: bold;text-decoration: underline;">

                                <table class="table table-striped table-bordered first">
                                    <thead>
                                        <tr>
                                            <th>Cod</th>
                                            <th>Transportadora</th>
                                            <th>Taxa Despacho</th>
                                            <th>Valor</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tr ng-repeat="frete in fretes">
                                        <td>{{frete.transportadora.id}}</td>
                                        <td>{{frete.transportadora.razao_social}}</td>
                                        <td>{{frete.transportadora.despacho}} R$</td>
                                        <td>{{frete.valor}} R$</td>
                                        <td>{{frete.valor + frete.transportadora.despacho}} R$</td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
                
                <!-- /.modal-content TABELA --> 
                <div class="modal fade" id="testeIndividual" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-adjust fa-3x"></i>&nbsp;&nbsp;&nbsp;Teste da tabela {{tabela_selecionada.nome}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">

                                <div class="form-group row">
                                    <label  class="col-3 col-lg-2 col-form-label text-left">Estado</label>
                                    <div class="col-9 col-lg-10">
                                        <select ng-model="estado_teste" class="form-control">
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
                                        <select ng-model="cidade_teste" ng-change="attResultadoIndividual()" class="form-control">
                                            <option ng-repeat="cidade in estado_teste.cidades" ng-value="cidade">{{cidade.nome}}</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please provide a valid text.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="txtendnum" class="col-3 col-lg-2 col-form-label text-left">Valor</label>
                                    <div class="col-9 col-lg-10">
                                        <input id="txtendnum" type="text" step="0.01" placeholder="00" ng-change="attResultadoIndividual()" ng-model="valor_teste" class="form-control" data-parsley-id="5" aria-describedby="parsley-id-5">
                                        <div class="invalid-feedback">
                                            Please provide a valid text.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="txtendnum" class="col-3 col-lg-2 col-form-label text-left">Peso</label>
                                    <div class="col-9 col-lg-10">
                                        <input id="txtendnum" type="text" step="0.01" placeholder="00" ng-change="attResultadoIndividual()" ng-model="peso_teste" class="form-control" data-parsley-id="5" aria-describedby="parsley-id-5">
                                        <div class="invalid-feedback">
                                            Please provide a valid text.
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer" style="text-align: center;font-weight: bold;text-decoration: underline;font-size: 21px">

                                {{resultado_individual>=0?resultado_individual+' R$':'Nao atende'}}

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
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-trash-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Delete os dados de sua Transportadora</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center"> Tem certeza de que deseja excluir esta Transportadora?</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" ng-click="deleteTransportadora(transportadora)">Sim</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Não</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content --> 


                <!-- /.modal-content --> 
                <!-- /.modal-content LOADING --> 
                <div class="modal fade" id="loading" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
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
                    
                    loading.show = function(){
                        if(it != null){
                            clearInterval(it);
                        }
                        if(!sh){
                            
                            sh = true;
                            $("#loading").modal("show");
                        
                        }
                        
                    }
                    
                    loading.close = function(){
                        
                        it = setTimeout(function(){
                                if(sh){
                                    sh = false;
                                    $("#loading").modal("hide");
                                }
                        },2000);
                        
                        
                    }
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