<html lang="en" ng-app="appRtc">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">

        <script src="js/angular.min.js"></script>
        <script src="js/rtc.js"></script>

        <script>

<?php
if (!isset($_GET['cotacao']) || !isset($_GET['empresa'])) {

    exit;
}

$id_cotacao = $_GET['cotacao'];
$id_empresa = $_GET['empresa'];
?>

            rtc.id_cotacao = <?php echo $id_cotacao; ?>;
            rtc.id_empresa = <?php echo $id_empresa; ?>;

        </script>

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
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/fixedHeader.bootstrap4.css">        <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">-->
        <title>RTC (Reltrab Cliente) - WEB</title>

    </head>

    <body ng-controller="crtCotacoesEntrada">
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
            <!-- ============================================================== -->
            <!-- end left sidebar -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- wrapper  -->
            <!-- ============================================================== -->
            <div style="width:60%;margin-left:auto;margin-right:auto;background-color:#FAFAFA">
                <div class="dashboard-ecommerce" >
                    <div class="container-fluid dashboard-content" ng-if="!temCotacao()">
                         <h2 class="pageheader-title">Essa cotacao ja foi respondida ou nao existe mais :(</h2>
                    </div>
                    <div class="container-fluid dashboard-content "ng-if="temCotacao()">
                        <!-- ============================================================== -->
                        <!-- pageheader  -->
                        <!-- ============================================================== -->
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="page-header">
                                    <h2 class="pageheader-title">Responder Cotacao de Compra</h2>

                                        <button class="btn btn-primary" style="float:right" ng-click="mergeCotacao()">
                                            <i class="fas fa-save"></i> &nbsp; Responder cotacao
                                        </button>
                                
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Cotacoes</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Cotacoes de Compra</li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form>
                            <div class="form-group">
                                <label for="">Fornecedor</label>
                                <div class="form-row">
                                    <div class="col-2">
                                        <input type="text" ng-model="cotacao.fornecedor.id" class="form-control" placeholder="Cod." value="9" disabled>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" ng-model="cotacao.fornecedor.nome" class="form-control" placeholder="Nome do fornecedor" value="" disabled="">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">			
                                <div class="col">
                                    <div class="form-group">
                                        Observacoes:
                                        <textarea class="form-control" ng-model="cotacao.observacao"></textarea>
                                    </div>
                                    <br>
                                </div>

                            </div>

                            <hr>
                            <br>
                            <label for="">Responda a cotacao da empresa, clicando em "responder cotacao" acima, caso esteja de acordo com os valores estabelecidos, caso contrario altere para o valor possivel e clique em "responder cotacao". Caso nao tenha algum dos produtos clique no icone da "Lixeira" para remover, e caso queira adcionar mais algum produto clique no icone "+"</label>
                            <table id="" class="table table-striped" width="90%">
                                <thead>
                                    <tr>
                                        <th>Cod</th>
                                        <th colspan="3">Nome</th>
                                        <th>Unidade</th>
                                        <th ng-if="!cotacao.tratar_em_litros">Qtd Emb</th>
                                        <th ng-if="!cotacao.tratar_em_litros">Valor R$</th>
                                        <th ng-if="cotacao.tratar_em_litros">Qtd Lt/Kg</th>
                                        <th ng-if="cotacao.tratar_em_litros">Valor R$</th>
                                        <th>Excluir Produto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="prod in cotacao.produtos">
                                        <td>{{prod.produto.id}}</td>
                                        <td colspan="3">{{prod.produto.nome}}</td>
                                        <td>{{prod.produto.unidade}} / {{prod.produto.quantidade_unidade}}</td>
                                        <td ng-if="!cotacao.tratar_em_litros" class="text-center" width="100px">{{prod.quantidade}}</td>
                                        <td ng-if="!cotacao.tratar_em_litros" class="text-center"><input type=text ng-keyup="attValor(prod)" class="form-control" ng-model="prod.valor"></td>
                                        <td ng-if="cotacao.tratar_em_litros">{{prod.quantidade * prod.produto.quantidade_unidade}}</td>
                                        <td ng-if="cotacao.tratar_em_litros"class="text-center"><input type=text ng-keyup="attValorUnitario(prod)" class="form-control" ng-model="prod.valor_unitario"></td>
                                        <td >
                                            <div class="product-btn">
                                                <a href="#" class="btn btn-outline-light btndel" ng-click="removerProduto(prod)"><i class="fas fa-trash-alt"></i></a>
                                            </div>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="product-btn">
                                                <a href="#" class="btn btn-outline-light btnaddprod" ng-click="cotacoes.attList()" data-title="addproduto" data-toggle="modal" data-target="#produtos"><i class="fas fa-plus-circle"></i></a>
                                            </div>
                                        </td>

                                    </tr>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="7" style="text-align:right;">VALOR TOTAL</th>
                                        <th colspan="3">R$ {{getTotalCotacao().toFixed(2)}}</th>
                                    </tr>
                                </tfoot>		
                            </table>
                        </form>

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


            <!-- /.modal-content -->

            <!-- /.modal-content --> 				

            <!-- /.modal-content TRANSPORTADORAS --> 
            <div class="modal fade" id="transportadoras" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Seleção de Transporte</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <input type="text" class="form-control" id="filtroTransportadoras" placeholder="Filtro">
                            <hr>
                            Frete: <input type="text" class="form-control" ng-model="frete" placeholder="Filtro">
                            <hr>
                            <table class="table table-striped table-bordered first">
                                <thead>
                                <th data-ordem="transportadora.id">Cod.</th>
                                <th data-ordem="transportadora.razao_social">Nome</th>
                                <th>Selecionar</th>
                                </thead>
                                <tr ng-repeat="trans in transportadoras.elementos">
                                    <th>{{trans[0].id}}</th>
                                    <th>{{trans[0].razao_social}}</th>
                                    <th><button class="btn btn-success" ng-click="formarPedido(trans[0])"><i class="fa fa-info"></i></button></th>
                                </tr> 
                            </table>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-end">
                                        <li class="page-item" ng-click="transportadoras.prev()"><a class="page-link" href="">Anterior</a></li>
                                        <li class="page-item" ng-repeat="pg in transportadoras.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></li>
                                        <li class="page-item" ng-click="transportadoras.next()"><a class="page-link" href="">Próximo</a></li>
                                    </ul>
                                </nav>
                            </div>

                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>

            <!-- /.modal-content DELETE --> 
            <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-trash-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Delete os dados de sua Cotacao</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <p class="text-center"> Tem certeza de que deseja excluir esta Cotacao?</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" ng-click="deleteCotacao()">Sim</button>
                            <button type="button" class="btn btn-light" data-dismiss="modal">Não</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content --> 

            <!-- /.modal-content VISUALIZAR PEDIDO --> 
            <div class="modal fade" id="vizPedido" tabindex="-1" role="dialog" aria-labelledby="vizPedido" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-eye fa-3x"></i>&nbsp;&nbsp;&nbsp;Vizualizando Cotacao</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body text-center">
                            <iframe id="myIframe" name="myIframe" frameborder="1" width="100%" height="300px" ng-src="visualizar-cotacao-entrada.php"></iframe>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content --> 
            <!-- /.modal-content CLIENTE --> 
            <div class="modal fade" id="clientes" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Seleção de Fornecedores</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <input type="text" class="form-control" id="filtroClientes" placeholder="Filtro">
                            <hr>
                            <table class="table table-striped table-bordered first">
                                <thead>
                                <th data-ordem="fornecedor.id">Cod.</th>
                                <th data-ordem="fornecedor.nome">Nome</th>
                                <th>Selecionar</th>
                                </thead>
                                <tr ng-repeat="f in fornecedores.elementos">
                                    <th>{{f[0].id}}</th>
                                    <th>{{f[0].nome}}</th>
                                    <th><button class="btn btn-success" ng-click="setFornecedor(f[0])"><i class="fa fa-info"></i></button></th>
                                </tr> 
                            </table>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-end">
                                        <li class="page-item" ng-click="fornecedores.prev()"><a class="page-link" href="">Anterior</a></li>
                                        <li class="page-item" ng-repeat="pg in fornecedores.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></li>
                                        <li class="page-item" ng-click="fornecedores.next()"><a class="page-link" href="">Próximo</a></li>
                                    </ul>
                                </nav>
                            </div>

                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content PRODUTOS --> 
            <div class="modal fade" style="overflow-y:scroll" id="produtos" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Seleção de produtos</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <input type="text" class="form-control col-md-8" id="filtroProdutos" placeholder="Filtro">
                            <br>
                            Qtd: <input type="number" class="form-control" class="col-md-4" ng-model="qtd" placeholder="Quantidade" style="width:40%;margin-top:5px">
                            <br>
                            Valor (R$): <input type="number" class="form-control" class="col-md-4" ng-model="valor" placeholder="Valor" style="width:40%;margin-top:5px">
                            <hr>
                            <table class="table table-striped table-bordered first">
                                <thead>
                                <th data-ordem="produto.id">Cod.</th>
                                <th data-ordem="produto.nome">Produto</th>
                                <th>Selecionar</th>
                                </thead>
                                <tr ng-repeat="produt in produtos.elementos">
                                    <th>{{produt[0].id}}</th>
                                    <th>{{produt[0].nome}}</th>
                                    <th><button class="btn btn-success" ng-click="addProduto(produt[0])"><i class="fa fa-info"></i></button></th>
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




            <!-- /.modal-content ADDPRODUTO --> 
            <div class="modal fade" id="addproduto" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fa fa-fw fa-shopping-basket fa-3x"></i>&nbsp;&nbsp;&nbsp;Adicione o produto em seu pedido.</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div id="custom-search" class="top-search-bar" style="padding-top:0px;padding-bottom:15px">
                                <div class="form-group">
                                    <div class="icon-addon addon-sm">
                                        <input class="form-control" type="search" placeholder="Digite o que procura" aria-label="Search" size="80%">
                                        <label for="email" class="fa fa-search" rel="tooltip" title="email"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <table class="table table-striped" style="margin-bottom: 10px;">
                                    <thead>
                                        <tr style="border-top: 0px solid red;">

                                            <th colspan="2">Produto</th>
                                            <th class="text-center">Qtd.Est.</th>
                                            <th class="right">Preço</th>
                                            <th class="right"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>

                                            <td class="center" width="100px"><img src="http://www.faunasystem.com.br:8080/rtc/ENVIDOR-FRC-400ML.png" style="width: 80%;" class="product-image"></td>
                                            <td class="left">
                                                <h3 class="product-title">Envidor (Frc 400ml)</h3>
                                                <span class="product-val">val. 30 / 09 / 2021</span><br>
                                                <span class="product-quant">1 p/ caixa</span>
                                            </td>
                                            <td class="text-center">4</td>
                                            <td class="right">R$ 116.99</td>
                                            <td class="text-center product">
                                                <a href="#" class="btn btn-primary btnaddprod" title=""><i class="fas fa-plus-circle"></i></a>
                                            </td>
                                        </tr>
                                        <tr>

                                            <td class="center" width="100px"><img src="http://www.faunasystem.com.br:8080/rtc/ridomilgold1kg.png" style="width: 80%;" class="product-image"></td>
                                            <td class="left">
                                                <h3 class="product-title">Ridomil Gold MZ (Pct 1kg)</h3>
                                                <span class="product-val">val. 30 / 09 / 2021</span><br>
                                                <span class="product-quant">1 p/ caixa</span>
                                            </td>
                                            <td class="text-center">4</td>
                                            <td class="right">R$ 116.99</td>
                                            <td class="text-center product">
                                                <a href="#" class="btn btn-primary btnaddprod" title=""><i class="fas fa-plus-circle"></i></a>
                                            </td>
                                        </tr>
                                        <tr>

                                            <td class="center" width="100px"><img src="http://www.faunasystem.com.br:8080/rtc/ENVIDOR-FRC-400ML.png" style="width: 80%;" class="product-image"></td>
                                            <td class="left">
                                                <h3 class="product-title">Envidor (Frc 400ml)</h3>
                                                <span class="product-val">val. 30 / 09 / 2021</span><br>
                                                <span class="product-quant">1 p/ caixa</span>
                                            </td>
                                            <td class="text-center">4</td>
                                            <td class="right">R$ 116.99</td>
                                            <td class="text-center product">
                                                <a href="#" class="btn btn-primary btnaddprod" title=""><i class="fas fa-plus-circle"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content --> 

            <!-- /.modal-content CALCFRETE --> 
            <div class="modal fade" id="calcFrete" tcalculoProntoabindex="-1" role="dialog" aria-labelledby="calcFrete" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fa fa-fw fa-truck fa-3x"></i>&nbsp;&nbsp;&nbsp;Veja o Frete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="custom-control custom-radio custom-control-inline" style="margin-top: 5px;" ng-repeat="frete in fretes">
                                        <label class="custom-control-label" for="customRadioInline3">R$ {{frete.valor.toFixed(2)}} - {{frete.transportadora.razao_social}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

                                                    loading.show = function () {
                                                        if (it != null) {
                                                            clearInterval(it);
                                                        }
                                                        if (!sh) {

                                                            sh = true;
                                                            $("#loading").modal("show");

                                                        }

                                                    }

                                                    loading.close = function () {

                                                        it = setTimeout(function () {
                                                            if (sh) {
                                                                sh = false;
                                                                $("#loading").modal("hide");
                                                            }
                                                        }, 2000);


                                                    }

                                                    $(document).ready(function () {
                                                        $('.btnvis').tooltip({title: "Visualizar", placement: "top"});
                                                        $('.btnedit').tooltip({title: "Editar", placement: "top"});
                                                        $('.btndel').tooltip({title: "Deletar", placement: "top"});
                                                        $('.btnaddprod').tooltip({title: "Adicionar", placement: "top"});
                                                    });


        </script>

    </body>

</html>