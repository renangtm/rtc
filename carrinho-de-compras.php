<!doctype html>
<html lang="en" ng-app="appRtc">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->

        <script src="js/angular.min.js"></script>
        <script src="js/rtc.js"></script>
        <script src="js/filters.js"></script>
        <script src="js/services.js"></script>
        <script src="js/controllers.js"></script>  


        <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
        <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/libs/css/style.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" href="assets/vendor/charts/chartist-bundle/chartist.css">
        <link rel="stylesheet" href="assets/vendor/charts/morris-bundle/morris.css">
        <link rel="stylesheet" href="assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="assets/vendor/charts/c3charts/c3.css">
        <link rel="stylesheet" href="assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
        <title>RTC (Reltrab Cliente) - WEB</title>
    </head>

    <body ng-controller="crtCarrinhoFinal">
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
                                    <h2 class="pageheader-title">Seu carrinho de compras</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Seu carrinho de Compras</li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end pageheader  -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- carrinho  -->
                        <!-- ============================================================== -->
                        <div class="">
                           
                            <div ng-repeat="pedido in pedidos" ng-if="!finalizado(pedido)" style="display: inline-block; width:48%; min-width:500px;margin-left:10px;margin-bottom: 50px;">
                                <div class="table-responsive-sm">
                                    <strong style="color:SteelBlue"><i class="fas fa-road"></i>&nbsp{{pedido.empresa.nome}}</strong>
                                    <strong ng-if="pedido.logistica !== null" style="color:DarkBlue">&nbsp / &nbsp<i class="fas fa-box"></i>&nbsp{{pedido.logistica.nome}}</strong>
                                    <table class="table table-striped" style="margin-bottom: 10px;">
                                        <thead>
                                            <tr style="border-top: 0px solid red;">
                                                <th>Img produto</th>
                                                <th>Produto</th>
                                                <th class="right">Qtd</th>
                                                <th class="text-center">Vl. Base</th>
                                                <th class="right">BC</th>
                                                <th class="right">ICMS</th>
                                                <th class="text-center">C. Fin</th>
                                                <th class="right">Frete</th>
                                                <th class="text-center">Sub Tot.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="produto in pedido.produtos">
                                                <td class="center" width="10%" style="position: relative"><button class="btn btn-danger" style="position: absolute;left:5px;top:5px;width:20px;height:20px;padding:0px" ng-click="remover(produto)"><i class="fas fa-times"></i></button><img src="{{produto.produto.imagem}}" class="product-image"></td>
                                                <td class="left">{{produto.produto.nome}}<hr><span ng-if="produto.validade_minima !== 1000">Val:<strong style="text-decorarion:underline">{{produto.validade_minima| data_st}}</strong></span></td>
                                                <td class="right">{{produto.quantidade}}</td>
                                                <td class="text-center" style="color:{{(retirouPromocao(produto) > 0) ? 'Orange' : '#000000'}}">{{produto.valor_base.toFixed(2)}} R$ <span ng-if="retirouPromocao(produto) > 0"><hr>Seria {{retirouPromocao(produto)}} R$ em campanha, no entanto a campanha nao contempla este prazo</span></td>
                                                <td class="text-center" style="color:SteelBlue">{{produto.base_calculo.toFixed(2)}} R$</td>
                                                <td class="text-center" style="{{produto.icms>0?'font-size:15px;color:DarkRed;text-decoration:underline':'text-decoration:line-through'}}">{{produto.icms.toFixed(2)}} R$</td>
                                                <th class="right" style="{{produto.juros>0?'font-size:15px;color:DarkRed;text-decoration:underline':'text-decoration:line-through'}}">{{produto.juros.toFixed(2)}} R$</th>
                                                <th class="right" style="{{produto.frete>0?'font-size:15px;color:DarkRed;text-decoration:underline':'text-decoration:line-through'}}">{{produto.frete.toFixed(2)}} R$</th>
                                                <td class="text-center" style="color:Green">{{((produto.valor_base + produto.icms + produto.frete + produto.ipi + produto.juros) * produto.quantidade).toFixed(2)}} R$</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-sm-4">
                                    </div>
                                    <div class="col-lg-10 col-sm-10 ml-auto">
                                        <table class="table table-clear">
                                            <tbody>

                                                <tr>
                                                    <td class="left">
                                                        <div class="form-group">
                                                            <label for="">Tipo de Frete:</label><br>
                                                            <div class="custom-control custom-radio custom-control-inline" style="margin-left:30px;margin-top: 5px;">
                                                                <input type="radio" id="ra{{pedido.identificador}}" name="radio_{{pedido.identificador}}" ng-value="true" ng-change="atualizaCustosResetandoFrete(pedido)" ng-model="pedido.frete_incluso" class="custom-control-input">
                                                                <label class="custom-control-label" for="ra{{pedido.identificador}}">Por conta da Empresa (CIF)</label>
                                                            </div>
                                                            <div class="custom-control custom-radio custom-control-inline" style="margin-left:30px;margin-top: 5px;">
                                                                <input type="radio" id="rb{{pedido.identificador}}" name="radio_{{pedido.identificador}}" ng-value="false" ng-change="atualizaCustosResetandoFrete(pedido)" ng-model="pedido.frete_incluso" class="custom-control-input">
                                                                <label class="custom-control-label" for="rb{{pedido.identificador}}">Por sua conta (FOB)</label>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="left">
                                                        <div class="form-group">
                                                            <label for="">Transportadora</label>
                                                            <div class="form-row">
                                                                <div class="col-2">
                                                                    <input type="text" class="form-control" placeholder="Cod." ng-model="pedido.transportadora.id" disabled>
                                                                </div>
                                                                <div class="col-5">
                                                                    <input type="text" class="form-control" ng-model="pedido.transportadora.razao_social" placeholder="Nome da Transportadora" disabled>
                                                                </div>
                                                                <div class="col-1">
                                                                    <button ng-if="!pedido.frete_incluso" ng-click="setPedidoContexto(pedido)" class="btn btn-outline-light btnedit" data-toggle="modal" data-target="#transportadoras" ng-disabled="!pedido.status.altera" style="padding: .375rem .75rem;"><i class="fas fa-search"></i><span class="indicator" ng-if="pedido.transportadora === null"></span></button>   
                                                                </div>
                                                                <div class="col-1">
                                                                    <button class="btn btn-primary" ng-click="getFretes(pedido)" data-toggle="modal" ng-if="pedido.frete_incluso" data-target="#fretes"><i class="fas fa-truck"></i>&nbspCalcular Frete</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="left">
                                                        <div class="form-group">
                                                            <label for="">Valor do Frete R$</label>
                                                            <div class="form-row">
                                                                <input type="text" class="form-control col-3" placeholder="0.0" style="padding-left:5px" ng-disabled="pedido.frete_incluso" ng-model="pedido.frete" ng-confirm="atualizaCustos(pedido)">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="left">
                                                        <div class="form-group">
                                                            <label for="">Forma de pagamento</label>
                                                            <div class="form-row">
                                                                <select class="form-control" ng-model="pedido.forma_pagamento">
                                                                    <option ng-repeat="f in pedido.formas_pagamento" ng-value="f">{{f.nome}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="left">
                                                        <div class="form-group">
                                                            <label for="">Prazo</label>
                                                            <div class="form-row">
                                                                <select class="form-control" ng-change="attPrazoParcelas(pedido)" ng-model="pedido.prazo_parcelas">
                                                                    <option ng-repeat="f in possibilidades" ng-value="f">{{f.nome === null ? ('Prazo: ' + f.prazo + ' dias em ' + f.parcelas + ' parcelas') : f.nome}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="col mb-2 m-t-40">
                                    <div class="row">
                                        <div class="col-sm-12  col-md-6">
                                            <button class="btn btn-lg btn-block btn-light" onclick="location.href = 'comprar.html';" >Continuar comprando</button>
                                        </div>
                                        <div class="col-sm-12 col-md-6 text-right">
                                            <button class="btn btn-lg btn-block btn-primary text-uppercase" ng-disabled="pedido.transportadora === null" ng-click="finalizarPedido(pedido)">Finalizar Compra</button>
                                        </div>
                                    </div>
                                </div>
                       
                          </div>
                        </div>	
                        <!-- ============================================================== -->
                        <!-- end carrinho  -->
                        <!-- ============================================================== -->		
                        <div class="modal fade" id="finalizarCompraModal" tabindex="-1" role="dialog" aria-labelledby="vizPedido" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-check fa-3x"></i>&nbsp;&nbsp;&nbsp;Pedido finalizado com sucesso</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body text-center" id="finalizarCompra">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-dismiss="modal">Fechar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="fretes" tcalculoProntoabindex="-1" role="dialog" aria-labelledby="fretes" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fa fa-fw fa-truck fa-3x"></i>&nbsp;&nbsp;&nbsp;Escolha o Frete</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="custom-control custom-radio custom-control-inline" style="margin-top: 5px;" ng-repeat="frete in fretes">
                                                    <input type="radio" id="rdd{{frete.transportadora.id}}" ng-click="setFrete(frete)" name="rdf" class="custom-control-input">
                                                    <label class="custom-control-label" for="rdd{{frete.transportadora.id}}">R$ {{frete.valor.toFixed(2)}} + ({{frete.transportadora.despacho}}) - {{frete.transportadora.razao_social}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                    <table class="table table-striped table-bordered first">
                                        <thead>
                                        <th data-ordem="transportadora.id">Cod.</th>
                                        <th data-ordem="transportadora.razao_social">Nome</th>
                                        <th>Selecionar</th>
                                        </thead>
                                        <tr ng-repeat="trans in transportadoras.elementos">
                                            <th>{{trans[0].id}}</th>
                                            <th>{{trans[0].razao_social}}</th>
                                            <th><button class="btn btn-success" ng-click="setTransportadora(trans[0])"><i class="fa fa-info"></i></button></th>
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

        <!-- ============================================================== -->
        <!-- end main wrapper  -->
        <!-- ============================================================== -->
        <!-- Optional JavaScript -->
        <!-- jquery 3.3.1 -->
        <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
        <!-- bootstap bundle js -->
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
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
                                                                $('.btnvis').tooltip({title: "Visualizar", placement: "top"});
                                                                $('.btnedit').tooltip({title: "Editar", placement: "top"});
                                                                $('.btndel').tooltip({title: "Deletar", placement: "top"});
                                                                $('.btnaddprod').tooltip({title: "Adicionar", placement: "top"});
                                                            });


        </script>
    </body>

</html>
