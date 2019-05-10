<!doctype html>
<html lang="en" ng-app="appRtc">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">

        <script src="js/angular.min.js"></script>
        <script src="js/rtc.js?4"></script>
        <script src="js/filters.js?4"></script>
        <script src="js/services.js?4"></script>
        <script src="js/controllers.js?4"></script>  <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>       


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

    <body ng-controller="crtProdutos">
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
                                    <h2 class="pageheader-title">Cadastro de Produtos</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Produtos</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Cadastro de Produtos</li>
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
                                                <a href="#" class="btn btn-primary" data-title="Add" data-toggle="modal" data-target="#add" ng-click="novoProduto()"><i class="fas fa-plus-circle m-r-10"></i>Adicionar Produtos</a>
                                            </div>
                                            <table id="clientes" class="table table-striped table-bordered first">
                                                <thead>
                                                    <tr>
                                                        <th data-ordem="produto.codigo">Cod.</th>
                                                        <th data-ordem="produto.nome">Nome</th>
                                                        <?php if ($usuario->temPermissao(Sistema::P_PARAMETRROS_TECNICOS_PRODUTO()->m("C"))) { ?>
                                                            <th data-ordem="produto.classe_risco">Cl</th>
                                                        <?php } ?>
                                                        <th data-ordem="produto.estoque">Qtd</th>
                                                        <th data-ordem="produto.disponivel">Disp</th>
                                                        <th data-ordem="produto.transito">Trans</th>
                                                        <th data-ordem="produto.valor_base">Valor (R$)</th>
                                                        <?php if ($usuario->temPermissao(Sistema::P_PARAMETRROS_TECNICOS_PRODUTO()->m("C"))) { ?>
                                                            <th data-ordem="produto.ativo">Princ&iacute;pio ativo</th>
                                                        <?php } ?>
                                                        <th data-ordem="produto.id_logistica">Armazenagem</th>
                                                        <th width="180px">A&ccedil;&atilde;o</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat-start="produto in produtos.elementos">
                                                        <td class="text-center">{{produto[0].codigo}}</td>
                                                        <td>{{produto[0].nome}}</td>
                                                        <?php if ($usuario->temPermissao(Sistema::P_PARAMETRROS_TECNICOS_PRODUTO()->m("C"))) { ?>
                                                            <td class="text-center">{{produto[0].classe_risco}}</td>
                                                        <?php } ?>
                                                        <td class="text-center">{{produto[0].estoque}}</td>
                                                        <td class="text-center">{{produto[0].disponivel}}</td>
                                                        <td class="text-center">{{produto[0].transito}}</td>
                                                        <td class="text-center">{{produto[0].valor_base}}</td>
                                                        <?php if ($usuario->temPermissao(Sistema::P_PARAMETRROS_TECNICOS_PRODUTO()->m("C"))) { ?>
                                                            <td>{{produto[0].ativo}}</td>
                                                        <?php } ?>
                                                        <td>{{produto[0].logistica===null?'Propria':produto[0].logistica.nome}}</td>
                                                        <th>
                                                            <div class="product-btn">
                                                                <a href="#" class="btn btn-outline-light btninfo" data-toggle="collapse" ng-click="setProduto(produto[0]);getReceituario(produto[0])" data-target="#demo{{produto[0].id}}" class="accordion-toggle"><i class="fas fa-info-circle"></i></a>
                                                                <a href="#" class="btn btn-outline-light btnedit" data-title="Edit" ng-click="setProduto(produto[0]);getReceituario(produto[0])" data-toggle="modal" data-target="#add"><i class="fas fa-pencil-alt"></i></a>
                                                                <a href="#" class="btn btn-outline-light btndel" data-title="Delete" ng-click="setProduto(produto[0])" data-toggle="modal" data-target="#delete"><i class="fas fa-trash-alt"></i></a>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    <tr ng-repeat-end>
                                                        <td colspan="9" class="hiddenRow">
                                                            <div class="accordian-body collapse" id="demo{{produto[0].id}}">
                                                                <div class="row mx-auto m-b-30">
                                                                    <div class="col">
                                                                        <table class="table table-bordered w-100">
                                                                            <tr ng-if="produto[0].logistica !== null">
                                                                                <td>Armazenado em Logistica:</td>
                                                                                <td>{{produto[0].logistica.nome}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Qtd caixa:</td>
                                                                                <td>{{produto[0].grade.str}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Fabricante:</td>
                                                                                <td>{{produto[0].fabricante}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Peso Bruto:</td>
                                                                                <td>{{produto[0].peso_bruto}}&nbsp; 
                                                                                    <select name="medida" class="form-control-sm" disabled>
                                                                                        <option value="KG" ng-if="!produto[0].liquido">KG</option>
                                                                                        <option value="LT" ng-if="produto[0].liquido" selected>LT</option>
                                                                                    </select>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Peso Liquido:</td>
                                                                                <td>{{produto[0].peso_liquido}}&nbsp; 
                                                                                    <select name="medida" class="form-control-sm" disabled>
                                                                                        <option value="KG" ng-if="!produto[0].liquido">KG</option>
                                                                                        <option value="LT" ng-if="produto[0].liquido" selected>LT</option>
                                                                                    </select>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2">Categoria de produto: &nbsp;
                                                                                    <select name="trib" class="form-control-sm" disabled>
                                                                                        <option value="">{{produto[0].categoria.nome}}</option>
                                                                                    </select></td>
                                                                            </tr>
                                                                            <?php if ($usuario->temPermissao(Sistema::P_PARAMETRROS_TECNICOS_PRODUTO()->m("C"))) { ?>
                                                                                <tr ng-if="produto[0].categoria.parametros_agricolas">
                                                                                    <td colspan="2">

                                                                                        Indica&ccedil;&atilde;o de Uso:
                                                                                        <hr>
                                                                                        <div ng-repeat="rec in produto[0].receituario">
                                                                                            Cultura: <strong>{{rec.cultura.nome}}</strong>
                                                                                            <br>
                                                                                            Praga: <strong>{{rec.praga.nome}}</strong>
                                                                                            <br>
                                                                                            Obs: <strong>{{rec.instrucoes}}</strong>

                                                                                            <hr>
                                                                                        </div> 
                                                                                    </td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                            <tr>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>	
                                                                    <div class="col">
                                                                        <table class="table-bordered w-100">
                                                                            <tr>
                                                                                <td colspan="2"><p>imagem do produto:</p>
                                                                                    <div class="row text-center m-t-20">
                                                                                        <div class="col">
                                                                                            <label class=newbtn>
                                                                                                <img id="" width="416" height="416"  src="{{produto[0].imagem}}" >
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row text-center justify-content-center m-t-10">
                                                                                        <div class="text-center">
                                                                                            <p class="font-12"> (Formato da imagem 416x416px -.png)</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
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
                                                        <?php if ($usuario->temPermissao(Sistema::P_PARAMETRROS_TECNICOS_PRODUTO()->m("C"))) { ?>
                                                            <th>Cl</th>
                                                        <?php } ?>
                                                        <th>Qtd</th>
                                                        <th>Disp</th>
                                                        <th>Trans</th>
                                                        <th>Valor (R$)</th>
                                                        <?php if ($usuario->temPermissao(Sistema::P_PARAMETRROS_TECNICOS_PRODUTO()->m("C"))) { ?>
                                                            <th>Princ&iacute;pio ativo</th>
                                                        <?php } ?>
                                                        <th>Armazenagem</th>
                                                        <th width="150px">A&ccedil;&atilde;o</th>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                            <!-- paginacao  -->
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination justify-content-end">
                                                        <li class="page-item" ng-click="produtos.prev()"><a class="page-link" href="">Anterior</a></li>
                                                        <li class="page-item" ng-repeat="pg in produtos.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></li>
                                                        <li class="page-item" ng-click="produtos.next()"><a class="page-link" href="">Proximo</a></li>
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
                <div class="modal fade in" id="add" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true" style="display: none;overflow-y:scroll">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-plus-circle fa-3x"></i>&nbsp;&nbsp;&nbsp;Adicione os dados de seu Produto</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-prod-tab" data-toggle="tab" href="#nav-prod" role="tab" aria-controls="nav-prod" aria-selected="true">Produto</a>
                                        <a class="nav-item nav-link" id="nav-img-tab" data-toggle="tab" href="#nav-img" role="tab" aria-controls="nav-img" aria-selected="false">Imagem</a>
                                        <?php if ($usuario->temPermissao(Sistema::P_PARAMETRROS_TECNICOS_PRODUTO()->m("C"))) { ?>
                                            <a ng-if="produto.categoria.parametros_agricolas" class="nav-item nav-link text-center" id="nav-uso-tab" data-toggle="tab" href="#nav-uso" role="tab" aria-controls="nav-uso" aria-selected="false">Indica&ccedil;&atilde;o<br> de uso</a>
                                        <?php } ?>
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-prod" role="tabpanel" aria-labelledby="nav-prod-tab">

                                        <!-- form produto -->
                                        <form id="add-form" ng-submit="mergeProduto()" parsley-validate>
                                            <div class="form-group row">
                                                <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Codigo</label>
                                                <div class="col-9 col-lg-10">
                                                    <input id="txtname" ng-model="produto.codigo" type="number" class="form-control">
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Nome</label>
                                                <div class="col-9 col-lg-10">
                                                    <input id="txtname" ng-model="produto.nome" type="text" required data-parsley-type="email" placeholder="" class="form-control">
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="txtfab" class="col-3 col-lg-2 col-form-label text-left">Fabricante</label>
                                                <div class="col-9 col-lg-10">
                                                    <select ng-model="produto.fabricante" class="form-control" >
                                                        <option ng-repeat="fabricante in fabricantes" ng-value="fabricante.nome">{{fabricante.nome}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php if ($usuario->temPermissao(Sistema::P_PARAMETRROS_TECNICOS_PRODUTO()->m("C"))) { ?>
                                                <div class="form-group row" ng-if="produto.categoria.parametros_agricolas">
                                                    <label for="txtcl" class="col-3 col-lg-2 col-form-label text-left">Cl:</label>
                                                    <div class="col-9 col-lg-10">
                                                        <inteiro model="produto.classe_risco"></inteiro>
                                                        <div class="invalid-feedback">
                                                            Please provide a valid text.
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="form-group row" ng-if="produto.categoria.desconta_estoque">
                                                <label for="txtqtd" class="col-3 col-lg-2 col-form-label text-left">Qtd.</label>
                                                <div class="col-9 col-lg-10">
                                                    <inteiro model="produto.estoque"></inteiro>
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row" ng-if="produto.sistema_lotes && !produto.categoria.abstrato">
                                                <label for="txtqtdcaixa" class="col-3 col-lg-2 col-form-label text-left">Grade</label>
                                                <div class="col-9 col-lg-10">
                                                    <input ng-model="produto.grade.str" id="txtqtdcaixa" type="text" required placeholder="" class="form-control">
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="txtqtdcaixa" class="col-3 col-lg-2 col-form-label text-left">NCM</label>
                                                <div class="col-9 col-lg-10">
                                                    <input ng-model="produto.ncm" id="txtqtdcaixa" type="text" required placeholder="" class="form-control">
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row" ng-if="!produto.categoria.abstrato">
                                                <label for="txtqtdcaixa" class="col-4 col-lg-3 col-form-label text-left">Qtd Unidade</label>
                                                <div class="col-9 col-lg-9">
                                                    <decimal model="produto.quantidade_unidade"></decimal>
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row" ng-if="produto.categoria.desconta_estoque">
                                                <label for="txtdisp" class="col-3 col-lg-2 col-form-label text-left">Disp.</label>
                                                <div class="col-9 col-lg-10">
                                                    <inteiro model="produto.disponivel"></inteiro>
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row" ng-if="produto.categoria.abstrato">
                                                <label for="txtval" class="col-3 col-lg-2 col-form-label text-left">Custo (U$)</label>
                                                <div class="col-9 col-lg-10">
                                                    <decimal model="produto.custo"></decimal>
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if ($usuario->temPermissao(Sistema::P_CONFIGURACAO_EMPRESA()->m("C"))) { ?>
                                            <div class="form-group row">
                                                <label for="txtval" class="col-3 col-lg-2 col-form-label text-left">Valor (R$)</label>
                                                <div class="col-9 col-lg-10">
                                                    <decimal model="produto.valor_base"></decimal>
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php if ($usuario->temPermissao(Sistema::P_PARAMETRROS_TECNICOS_PRODUTO()->m("C"))) { ?>
                                                <div class="form-group row" ng-if="produto.categoria.parametros_agricolas">
                                                    <label for="txtpativo" class="col-4 col-lg-3 col-form-label text-left">Princ&iacute;pio ativo</label>
                                                    <div class="col-9 col-lg-9 text-left">
                                                        <div class="col-9 col-lg-9 text-left">
                                                            <select ng-model="produto.ativo" class="form-control" >
                                                                <option ng-repeat="ativo in ativos" ng-value="ativo.nome">{{ativo.nome}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($usuario->temPermissao(Sistema::P_PARAMETRROS_TECNICOS_PRODUTO()->m("C"))) { ?>
                                                <div class="form-group row" ng-if="produto.categoria.parametros_agricolas">
                                                    <label for="txtpativo" class="col-4 col-lg-3 col-form-label text-left">Concentracao</label>
                                                    <div class="col-9 col-lg-9 text-left">
                                                        <input id="txtpativo" ng-model="produto.concentracao" type="text" required placeholder="" class="form-control">
                                                        <div class="invalid-feedback">
                                                            Please provide a valid text.
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="form-group row" ng-if="produto.categoria.desconta_estoque">
                                                <label for="txtpativo" class="col-4 col-lg-3 col-form-label text-left">Log&iacute;stica</label>
                                                <div class="col-9 col-lg-9 text-left">
                                                    <select ng-model="produto.logistica" class="form-control" >
                                                        <option ng-repeat="l in logisticas" ng-value="l">{{l.nome}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="txtpativo" class="col-4 col-lg-3 col-form-label text-left">Categoria</label>
                                                <div class="col-9 col-lg-9 text-left">
                                                    <select ng-model="produto.categoria" class="form-control" >
                                                        <option ng-repeat="c in categorias" ng-value="c">{{c.nome}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row" ng-if="!produto.categoria.abstrato">
                                                <label for="txtpativo" class="col-4 col-lg-3 col-form-label text-left">Peso Liquido</label>
                                                <div class="col-9 col-lg-9 text-left">
                                                    <decimal model="produto.peso_liquido"></decimal>
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row" ng-if="!produto.categoria.abstrato">
                                                <label for="txtpeso" class="col-4 col-lg-3 col-form-label text-left">Peso Bruto</label>
                                                <div class="col-4 col-lg-4">
                                                    <decimal model="produto.peso_bruto" style=""></decimal>               
                                                </div>
                                                <div class="col-4 col-lg-4" style="padding-top: 5px;">
                                                    <label class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" name="radio-inline22" data-ng-value="false" data-ng-model="produto.liquido" class="custom-control-input"><span class="custom-control-label">KG</span>
                                                    </label>
                                                    <label class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" name="radio-inline22" data-ng-value="true" data-ng-model="produto.liquido" checked="" class="custom-control-input"><span class="custom-control-label">LT</span>
                                                    </label>
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row" ng-if="produto.categoria.desconta_estoque">

                                                <div class="col-6 col-lg-6" style="padding-top: 5px;">
                                                    Trabalha com o modulo de Lotes ?
                                                    <br>
                                                    <label class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" name="radio-inline" data-ng-value="true" data-ng-model="produto.sistema_lotes" class="custom-control-input"><span class="custom-control-label">Sim</span>
                                                    </label>
                                                    <label class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" name="radio-inline" data-ng-value="false" data-ng-model="produto.sistema_lotes" checked="" class="custom-control-input"><span class="custom-control-label">Nao</span>
                                                    </label>
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>

                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <div class="col text-center">
                                            <button class="btn btn-primary text-center" type="submit">
                                                <i class="fas fa-save"></i> &nbsp; Salvar
                                            </button>
                                        </div>	
                                        </form>
                                        <!-- end form produto -->

                                    </div>
                                    <div class="tab-pane fade" id="nav-img" role="tabpanel" aria-labelledby="nav-img-tab">

                                        <!-- fom imagem produto -->
                                        <div class="row text-center justify-content-center m-t-30">
                                            <div class="text-center">
                                                <p class=""> Clique na imagem para trocar a foto do produto</p>
                                                <p class="font-12"> (Formato da imagem 416x416px -.png)</p>
                                            </div>
                                        </div>
                                        <div class="row text-center m-t-20">
                                            <div class="col">
                                                <label class=newbtn>
                                                    <img id="blah" width="50%" src="{{produto.imagem}}" >
                                                    <input id="uploaderImagemProduto" style="display: none" type="file" multiple="true">
                                                    <input id="uploaderImagemProdutoSecundario" style="display: none" type="file" multiple="true">
                                                </label>
                                                <hr>
                                                <button type="button" class="btn btn-success" onclick="$('#uploaderImagemProdutoSecundario').click()"><i class="fas fa-plus-circle"></i> Nova foto secundaria</button>
                                                <hr ng-if="produto.mais_fotos.length>0">
                                                    <div ng-repeat="foto in produto.mais_fotos" style="display: inline">
                                                        <img id="blah" width="50%" src="{{foto}}">
                                                        <button type="button" class="btn btn-danger" ng-click="removerFoto(foto,produto)" style="padding:5px;width:25px;height:25px">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                        <hr>
                                                    </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="form-group row">
                                            <div class="col text-center">

                                            </div>	
                                        </div>
                                        <!-- end fom imagem produto -->

                                    </div>
                                    <div class="tab-pane fade" id="nav-uso" role="tabpanel" aria-labelledby="nav-uso-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Cultura:
                                                <hr>
                                                <select class="custom-select" ng-model="receituario.cultura" name="" size="10">
                                                    <option ng-repeat="c in culturas" ng-value="c">{{c.nome}}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                Praga
                                                <hr>
                                                <select class="custom-select" ng-model="receituario.praga" name="" size="10">
                                                    <option ng-repeat="p in pragas" ng-value="p">{{p.nome}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <br>
                                                Observa&ccedil;&atilde;o:
                                                <hr>
                                                <textarea ng-model="receituario.instrucoes" class="form-control" style="width:100%">

                                                </textarea>
                                            </div>
                                            <div class="col-md-3">
                                                <br>
                                                Adicionar
                                                <hr>
                                                <button class="btn btn-success" ng-click="mergeReceituario()"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <hr>

                                        <table class="table table-striped table-bordered first">
                                            <thead>
                                            <td>
                                                Cod
                                            </td>
                                            <td>
                                                Cult
                                            </td>
                                            <td>
                                                Praga
                                            </td>
                                            <td>
                                                Obs
                                            </td>
                                            <td>
                                                Exc
                                            </td>
                                            </thead>
                                            <tr ng-repeat="rec in produto.receituario">
                                                <td>{{rec.id}}</td>
                                                <td>{{rec.cultura.nome}}</td>
                                                <td>{{rec.praga.nome}}</td>
                                                <td>{{rec.instrucoes}}</td>
                                                <td>
                                                    <button class="btn btn-danger" ng-click="deleteReceituario(rec, produto)"><i class="fa fa-times"></i></button>
                                                </td>
                                            </tr>
                                        </table>

                                    </div>

                                    <div class="tab-pane fade" id="nav-rest" role="tabpanel" aria-labelledby="nav-rest-tab">

                                        <!--form restricao por estado-->

                                        <form id="add-form" parsley-validate>
                                            <table class="table m-t-30">
                                                <tbody>
                                                    <tr>
                                                        <td width="45%" class="text-center">
                                                            Produto
                                                        </td>
                                                        <td width="10%">
                                                        </td>
                                                        <td width="45%" class="text-center">
                                                            Todos estados
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="45%">
                                                            <select class="custom-select" name="" size="10" multiple>
                                                                <option value="" > adicione os estados</option>
                                                            </select>
                                                        </td>
                                                        <td width="10%">
                                                            <a href="#" class="btn btn-outline-light m-b-20" data-toggle="tooltip" data-placement="top" title="" data-original-title="Adicionar"><i class="fas fa-chevron-circle-left"></i></a><br>
                                                            <a href="#" class="btn btn-outline-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="Remover"><i class="fas fa-chevron-circle-right"></i></a>

                                                        </td>
                                                        <td width="45%"><select class="custom-select" name="" size="10" multiple>
                                                                <option value="AC">Acre</option>
                                                                <option value="AL">Alagoas</option>
                                                                <option value="AP">Amap??</option>
                                                                <option value="AM">Amazonas</option>
                                                                <option value="BA">Bahia</option>
                                                                <option value="CE">Cear??</option>
                                                                <option value="DF">Distrito Federal</option>
                                                                <option value="ES">Espirito Santo</option>
                                                                <option value="GO">Goi??s</option>
                                                                <option value="MA">Maranhao</option>
                                                                <option value="MT">Mato Grosso</option>
                                                                <option value="MS">Mato Grosso do Sul</option>
                                                                <option value="MG">Minas Gerais</option>
                                                                <option value="PA">Par??</option>
                                                                <option value="PB">Paraiba</option>
                                                                <option value="PR">Paran??</option>
                                                                <option value="PE">Pernambuco</option>
                                                                <option value="PI">Piaui</option>
                                                                <option value="RJ">Rio de Janeiro</option>
                                                                <option value="RN">Rio Grande do Norte</option>
                                                                <option value="RS">Rio Grande do Sul</option>
                                                                <option value="RO">Rondonia</option>
                                                                <option value="RR">Roraima</option>
                                                                <option value="SC">Santa Catarina</option>
                                                                <option value="SP">Sao Paulo</option>
                                                                <option value="SE">Sergipe</option>
                                                                <option value="TO">Tocantins</option>
                                                            </select>
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr>
                                            <div class="form-group row">
                                                <div class="col text-center">
                                                    <button class="btn btn-primary text-center" type="submit">
                                                        <i class="fas fa-save"></i> &nbsp; Salvar
                                                    </button>
                                                </div>	
                                            </div>
                                        </form>

                                        <!-- endf form restricao por estado-->

                                    </div>

                                    <div class="tab-pane fade" id="nav-fat" role="tabpanel" aria-labelledby="nav-fat-tab">
                                        <!--form faturamento-->
                                        <form id="add-form" parsley-validate>
                                            <div class="form-group row m-t-20">
                                                <label for="txtpeso" class="col-4 col-form-label text-left">Paramentros para<br> faturamento</label>
                                                <div class="col-4 col-lg-4" style="padding-top: 5px;">
                                                    <label class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" name="radio-inline" class="custom-control-input"><span class="custom-control-label">Sem Tributacao</span>
                                                    </label>
                                                    <label class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" name="radio-inline" class="custom-control-input"><span class="custom-control-label">Tributacao normal</span>
                                                    </label>
                                                    <label class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" name="radio-inline" class="custom-control-input"><span class="custom-control-label">Tributacao especial 4%</span>
                                                    </label>
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <div class="col text-center">
                                                    <button class="btn btn-primary text-center" type="submit">
                                                        <i class="fas fa-save"></i> &nbsp; Salvar
                                                    </button>
                                                </div>	
                                            </div>

                                        </form>


                                        <!--end form faturamento-->
                                    </div>
                                </div>







                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Fechar</button>
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
                                        <label for="txtend" class="col-3 col-lg-2 col-form-label text-left">Endereco</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtend" type="text" required data-parsley-type="email" placeholder="Rua: Coutinho Cavalcante" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtendnum" class="col-3 col-lg-2 col-form-label text-left">Numero</label>
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
                                                <option value="ap">Amap??</option> 
                                                <option value="ba">Bahia</option> 
                                                <option value="ce">Cear??</option> 
                                                <option value="df">Distrito Federal</option> 
                                                <option value="es">Espirito Santo</option> 
                                                <option value="go">Goi??s</option> 
                                                <option value="ma">Maranhao</option> 
                                                <option value="mt">Mato Grosso</option> 
                                                <option value="ms">Mato Grosso do Sul</option> 
                                                <option value="mg">Minas Gerais</option> 
                                                <option value="pa">Par??</option> 
                                                <option value="pb">Paraiba</option> 
                                                <option value="pr">Paran??</option> 
                                                <option value="pe">Pernambuco</option> 
                                                <option value="pi">Piaui</option> 
                                                <option value="rj">Rio de Janeiro</option> 
                                                <option value="rn">Rio Grande do Norte</option> 
                                                <option value="ro">Rondonia</option> 
                                                <option value="rs">Rio Grande do Sul</option> 
                                                <option value="rr">Roraima</option> 
                                                <option value="sc">Santa Catarina</option> 
                                                <option value="se">Sergipe</option> 
                                                <option value="sp" selected>Sao Jose do Rio Preto</option> 
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
                                                <option value="ap">Amap??</option> 
                                                <option value="ba">Bahia</option> 
                                                <option value="ce">Cear??</option> 
                                                <option value="df">Distrito Federal</option> 
                                                <option value="es">Espirito Santo</option> 
                                                <option value="go">Goi??s</option> 
                                                <option value="ma">Maranhao</option> 
                                                <option value="mt">Mato Grosso</option> 
                                                <option value="ms">Mato Grosso do Sul</option> 
                                                <option value="mg">Minas Gerais</option> 
                                                <option value="pa">Par??</option> 
                                                <option value="pb">Paraiba</option> 
                                                <option value="pr">Paran??</option> 
                                                <option value="pe">Pernambuco</option> 
                                                <option value="pi">Piaui</option> 
                                                <option value="rj">Rio de Janeiro</option> 
                                                <option value="rn">Rio Grande do Norte</option> 
                                                <option value="ro">Rondonia</option> 
                                                <option value="rs">Rio Grande do Sul</option> 
                                                <option value="rr">Roraima</option> 
                                                <option value="sc">Santa Catarina</option> 
                                                <option value="se">Sergipe</option> 
                                                <option value="sp" selected>Sao Paulo</option> 
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



                <!-- /.modal-content DELETE --> 
                <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-trash-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Delete os dados do seu Produto</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center"> Tem certeza de que deseja excluir este Produto?</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" ng-click="deletarProduto()">Sim</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Nao</button>
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



                                    $('.newbtn').bind("click", function () {
                                        $('#pic').click();
                                    });

                                    function readURL(input) {
                                        if (input.files && input.files[0]) {
                                            var reader = new FileReader();

                                            reader.onload = function (e) {
                                                $('#blah')
                                                        .attr('src', e.target.result);
                                            };

                                            reader.readAsDataURL(input.files[0]);
                                        }
                                    }
                </script>
                <script>
                    $(document).ready(function () {
                        $('.btninfo').tooltip({title: "Mais informacoes", placement: "top"});
                        $('.btnedit').tooltip({title: "Editar", placement: "top"});
                        $('.btndel').tooltip({title: "Deletar", placement: "top"});
                    });


                </script>

                </body>

                </html>
