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
            .page-link:hover {
                color:#fff !important;
            }
        </style>
    </head>

    <body ng-controller="crtCampanhas">
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
                                    <h2 class="pageheader-title">Campanhas</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Campanhas</li>
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
                                                <a href="#" class="btn btn-primary" data-title="Add" data-toggle="modal" data-target="#add" ng-click="setCampanhaCriacao(criacao_campanhas[0])"><i class="fas fa-plus-circle m-r-10"></i>Nova campanha</a>
                                            </div>
                                            <table id="clientes" class="table table-striped table-bordered first">
                                                <thead>
                                                    <tr>
                                                        <th data-ordem="campanha.id">Cod.</th>
                                                        <th data-ordem="campanha.nome">Nome</th>
                                                        <th data-ordem="campanha.inicio">Inicio</th>
                                                        <th data-ordem="campanha.fim">Fim</th>
                                                        <th data-ordem="campanha.prazo">Prazo</th>
                                                        <th data-ordem="campanha.parcelas">Parcelas</th>
                                                        <th width="180px">Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat-start="campanha in campanhas.elementos">
                                                        <td class="text-center">{{campanha[0].id}}</td>
                                                        <td>{{campanha[0].nome}}</td>
                                                        <td>{{campanha[0].inicio| data}}</td>
                                                        <td>{{campanha[0].fim| data}}</td>
                                                        <td class="text-center">{{campanha[0].prazo}}</td>
                                                        <td class="text-center">{{campanha[0].parcelas}}</td>
                                                        <th>
                                                            <div class="product-btn">
                                                                <a href="#" class="btn btn-outline-light btninfo" data-toggle="collapse" ng-click="setCampanha(campanha[0])" data-target="#demo{{campanha[0].id}}" class="accordion-toggle"><i class="fas fa-info-circle"></i></a>
                                                                <a href="#" class="btn btn-outline-light btnedit" data-title="Edit" ng-click="setCampanha(campanha[0])" data-toggle="modal" data-target="#edit"><i class="fas fa-pencil-alt"></i></a>
                                                                <a href="#" class="btn btn-outline-light btndel" data-title="Delete" ng-click="setCampanha(campanha[0])" data-toggle="modal" data-target="#delete"><i class="fas fa-trash-alt"></i></a>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    <tr ng-repeat-end>
                                                        <td colspan="7" class="hiddenRow">
                                                            <div class="accordian-body collapse" id="demo{{campanha[0].id}}">
                                                                <div class="row mx-auto m-b-30">
                                                                    <div class="col">
                                                                        <table class="table table-striped table-bordered first">
                                                                            <thead>
                                                                            <th>Cod.</th>
                                                                            <th>Produto</th>
                                                                            <th>Validade</th>
                                                                            <th class="text-center">Limite</th>
                                                                            <th class="text-center">Valor</th>
                                                                            </thead>
                                                                            <tr ng-repeat="prod in campanha[0].produtos">
                                                                                <th class="text-center">{{prod.produto.id}}</th>
                                                                                <th>{{prod.produto.nome}}</th>
                                                                                <th>{{prod.validade| data}}</th>
                                                                                <th class="text-center">{{prod.limite}}</th>
                                                                                <th class="text-center">R$ {{prod.valor}}</th>
                                                                            </tr>
                                                                        </table>
                                                                    </div>	
                                                                    <div class="col">
                                                                        <table class="table-bordered w-100">
                                                                            <tr>
                                                                                <td>Expressão de cliente:</td>
                                                                                <td class="text-center">{{campanha[0].cliente_expression}}</td>
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
                                                        <th>Inicio</th>
                                                        <th>Fim</th>
                                                        <th>Prazo</th>
                                                        <th>Parcelas</th>
                                                        <th width="150px">Ação</th>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                            <!-- paginação  -->
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination justify-content-end">
                                                        <li class="page-item" ng-click="campanhas.prev()"><a class="page-link" href="">Anterior</a></li>
                                                        <li class="page-item" ng-repeat="pg in campanhas.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></li>
                                                        <li class="page-item" ng-click="campanhas.next()"><a class="page-link" href="">Próximo</a></li>
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
                <div class="modal fade in" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-pencil-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Altere os dados de sua Campanha</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="add-form" ng-submit="mergeCampanha()" parsley-validate>
                                    <div class="form-group row">
                                        <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Nome</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtname" type="text" ng-model="campanha.nome" required data-parsley-type="email" placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtemail" class="col-3 col-lg-2 col-form-label text-left">Inicio</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtemail" ng-model="campanha.inicio_texto" type="text" required data-parsley-type="email" placeholder="" class="form-control date_time">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtcnpj" class="col-3 col-lg-2 col-form-label text-left">Fim</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtcnpj" type="text" ng-model="campanha.fim_texto" class="form-control date_time">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtcnpj" class="col-3 col-lg-2 col-form-label text-left">Prazo</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtcnpj" type="text" ng-model="campanha.prazo" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtcnpj" class="col-3 col-lg-2 col-form-label text-left">Parcelas</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtcnpj" type="text" ng-model="campanha.parcelas" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row" style="padding: 15px;">
                                        <br>
                                        <button class="btn btn-primary m-b-20" type="button" onclick="$('#produtos').modal('show')"><i class="fa fa-plus-circle"></i>&nbsp; Adicionar produto</button>
                                        <br>
                                        
                                        <table class="table table-striped table-bordered first">
                                            <thead>
                                            <th>Cod.</th>
                                            <th>Produto</th>
                                            <th>Validade</th>
                                            <th>Limite</th>
                                            <th>Valor</th>
                                            <th>Excluir</th>
                                            </thead>
                                            <tr ng-repeat="prod in campanha.produtos">
                                                <th>{{prod.produto.id}}</th>
                                                <th>{{prod.produto.nome}}</th>
                                                <th>{{prod.validade| data}}</th>
                                                <th><input type="text" class="form-control" ng-model="prod.limite"></th>
                                                <th><input type="text" class="form-control" ng-model="prod.valor"></th>
                                                <th><button class="btn btn-danger" ng-click="deleteProdutoCampanha(campanha, prod)"><i class="fa fa-times"></i></button></th>
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
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-pencil-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Edite os dados de seu Fornecedor</h5>
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
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-trash-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Delete os dados de sua Campanha</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center"> Tem certeza de que deseja excluir esta Campanha?</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" ng-click="deleteCampanha(campanha)">Sim</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Não</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content --> 

                <!-- /.modal-content MONTAGEM DE CAMPANHA --> 
                <div class="modal fade" style="overflow-y:scroll" id="add" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" >
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-anchor fa-3x"></i>&nbsp;&nbsp;&nbsp;Montagem de campanhas</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">

                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link {{c.numero==0?'active':''}}" id="nav-camp-tab{{c.numero}}" ng-repeat="c in criacao_campanhas" ng-click="setCampanhaCriacao(c)" data-toggle="tab" href="#nav-camp{{c.numero}}" role="tab" aria-controls="nav-camp{{c.numero}}" aria-selected="true">{{c.nome}}</a>
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade {{c.numero==0?'show active':''}}" ng-repeat="c in criacao_campanhas" id="nav-camp{{c.numero}}" role="tabpanel" aria-labelledby="nav-camp-tab{{c.numero}}">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-3" style="text-align:left">
                                                Nome
                                            </div>
                                            <div class="col-md-2" style="text-align:left">
                                                Prazo
                                            </div>
                                            <div class="col-md-1" style="text-align:left">
                                                Parcelas
                                            </div>
                                            <div class="col-md-3" style="text-align:left">
                                                Data Inicial
                                            </div>
                                            <div class="col-md-3" style="text-align:left">
                                                Data Final
                                            </div>
                                        </div>
                                        <div class="row" ng-repeat="cc in c.campanhas" style="margin-bottom:4px">
                                            <div class="col-md-3" style="text-align:left">
                                                <input type="text" class="form-control" ng-model="cc.nome">
                                            </div>
                                            <div class="col-md-2" style="text-align:left">
                                                <input type="text" class="form-control" ng-model="cc.prazo">
                                            </div>
                                            <div class="col-md-1" style="text-align:left">
                                                <input type="text" class="form-control" ng-model="cc.parcelas">
                                            </div>
                                            <div class="col-md-3" style="text-align:left">
                                                <input type="text" class="form-control" ng-model="cc.inicio">
                                            </div>
                                            <div class="col-md-3" style="text-align:left">
                                                <input type="text" class="form-control" ng-model="cc.fim">
                                            </div>
                                        </div>
                                        <hr>

                                        <table class="table table-striped table-bordered first">
                                            <thead>
                                            <th>Camp</th>
                                            <th>Produto</th>
                                            <th>Validade</th>
                                            <th>Limite</th>
                                            <th>Valor</th>
                                            <th ng-repeat="v in campanha.lista.elementos[0][0].valores">Sugestao</th>
                                            <th><i class="fas fa-edit"></i> R$</th>
                                            </thead>
                                            <tr ng-repeat="prod in campanha.lista.elementos">
                                                <th><button ng-click="addNumeracao(prod[0])" class="btn btn-default" style="width:23px;height:23px;padding:1px;display:inline;background-color:{{getNumeracaoCor(prod[0].numeracao)}};color:#FFFFFF">{{getNumeracaoAlfabetica(prod[0].numeracao)}}</button></th>
                                                <th>{{prod[0].produto.id}} - {{prod[0].produto.nome}}</th>
                                                <th><button ng-click="setProdutoValidade(prod[0])" class="btn btn-{{prod[0].validade<0?'danger':'success'}}" data-toggle="modal" data-target="#validadeProduto" style="width:23px;height:23px;padding:1px;display:inline"><i class="fas fa-info"></i></button><strong style="display:inline">{{(prod[0].validade > 0) ? (prod[0].validade | data) : 'Selecione'}}</strong></th>
                                                <th><input type="text" class="form-control" ng-model="prod[0].limite"></th>
                                                <th>{{prod[0].produto.custo}}</th>
                                                <th ng-click="selecionarValor(prod[0], v)" style="cursor:pointer;{{v.selecionado?'text-decoration:underline;color:Green':''}}" ng-repeat="v in prod[0].valores">{{v.valor}} R$</th>
                                                <th ng-click="selecionarValor(prod[0], prod[0].valor_editavel)"><input type="text" class="form-control" style="width:50px;{{prod[0].valor_editavel.selecionado?'color:Green;text-decoration:underline':''}}" ng-model="prod[0].valor_editavel.valor"></th>
                                            </tr>
                                        </table>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination justify-content-end">

                                                    <li class="page-item" ng-repeat="pg in campanha.lista.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></li>

                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" data-dismiss="modal" aria-label="Close" ng-click="terminarCadastro()"><i class="fas fa-check"></i>&nbsp; Terminar</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /.modal-content VALIDADE DE PRODUTO --> 
                
                <div class="modal fade" id="validadeProduto" tabindex="99" role="dialog" aria-labelledby="validadeProduto" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Validades do produto {{produto.nome}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">

                                <table class="table table-striped table-bordered first">
                                    <thead>
                                    <th>Produto</th>
                                    <th>Validade</th>
                                    <th>Quantidade</th>
                                    <th>Selecionar</th>
                                    </thead>
                                    <tr ng-repeat="v in produto.validades">
                                        <th>{{produto.nome}}</th>
                                        <th>{{v.validade | data}} <i class="fas fa-arrow-up" ng-if="v.alem" ></i></th>
                                        <th>{{v.quantidade}}</th>
                                        <th><button class="btn btn-success" data-dismiss="modal" aria-label="Close" ng-click="setAutoValidade(v)"><i class="fas fa-plus-circle"></i></th>
                                    </tr>
                                </table>

                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>

                <!-- /.modal-content PRODUTOS --> 
                <div class="modal fade" id="produtos" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Seleção de produtos</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control" id="filtroProdutos" placeholder="Filtro">
                                <hr>
                                <table class="table table-striped table-bordered first">
                                    <thead>
                                    <th>Cod.</th>
                                    <th>Produto</th>
                                    <th>Disponivel</th>
                                    <th>Valor</th>
                                    <th>Selecionar</th>
                                    </thead>
                                    <tr ng-repeat-start="produto in produtos.elementos">
                                        <th>{{produto[0].id}}</th>
                                        <th>{{produto[0].nome}}</th>
                                        <th>{{produto[0].disponivel}}</th>
                                        <th>{{produto[0].valor_base}}</th>
                                        <th><button class="btn btn-success" ng-click="getValidades(produto[0])" data-target="#demo{{produto[0].id}}" data-toggle="collapse" class="accordion-toggle"><i class="fa fa-info"></i></button></th>
                                    </tr>
                                    <tr ng-repeat-end>
                                        <td colspan="6" class="hiddenRow">
                                            <div class="accordian-body collapse" id="demo{{produto[0].id}}">
                                                <div class="row mx-auto m-b-30">
                                                    <div class="col">
                                                        <table class="table table-striped table-bordered first">
                                                            <thead>
                                                            <th>Validade</th>
                                                            <th>Quantidade</th>
                                                            <th>Selecionar</th>
                                                            </thead>
                                                            <tr ng-repeat="validade in produto[0].validades">
                                                                <th>{{validade.validade| data}} <i class="fas fa-arrow-up" ng-if="validade.alem" ></i> </th>
                                                                <th>{{validade.quantidade}}</th>
                                                                <th><button class="btn btn-success" ng-click="addProdutoCampanha(produto[0], validade)"><i class="fas fa-plus-circle"></i></button></th>
                                                            </tr>
                                                        </table>
                                                    </div>																	
                                                </div>	
                                            </div> 
                                        </td>
                                    </tr>
                                </table>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item" ng-click="produtos.prev()"><a class="page-link" href="">Anterior</a></li>
                                            <li class="page-item" ng-repeat="pg in produtos.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></li>
                                            <li class="page-item" ng-click="produtos.next()"><a class="page-link" href="">Próximo</a></li>
                                        </ul>
                                    </nav>
                                </div>

                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>
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
                                    
                                    $("#loading").modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                    
                    
                    
                    $(document).on('keyup', '.date_time', function() {
                        $(this).mask('00/00/0000 00:00:00');
                    });
                    
                     $(document).ready(function () {
                         $('.btninfo').tooltip({title: "Mais informação", placement: "top"});
                         $('.btnedit').tooltip({title: "Editar", placement: "top"});
                         $('.btndel').tooltip({title: "Deletar", placement: "top"});
                     });
                                                        
                </script>

                </body>

                </html>
