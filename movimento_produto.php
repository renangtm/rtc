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

    <body ng-controller="crtMovimentoEstoque">
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
                                    <h2 class="pageheader-title">Movimento de Estoque</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Movimento Estoque</li>
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
                                        <div ng-if="isLogistica">
                                            <select style="width:30%" ng-options="e as e.nome for e in empresas track by e.id" ng-model="$parent.empresa" ng-change="trocaEmpresa()" class="form-control">
                                            </select>
                                            <hr>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-7">
                                                <calendario inicio="inicio" fim="fim" meses="2" tempo="true"></calendario>
                                            </div>
                                            <div class="col-md-5" style="position: relative">
                                                <h2>Produtos</h2>
                                                <button class="btn btn-warning" ng-click="gerarRelatorio()" data-title="addproduto" style="width:200px;position:absolute;top:0px;right:220px"><i class="fas fa-check"></i>&nbsp Gerar relatorio</button>
                                                <button class="btn btn-success" ng-click="produtos.attList()" data-title="addproduto" data-toggle="modal" data-target="#produtos" style="width:200px;position:absolute;top:0px;right:10px"><i class="fas fa-plus-circle"></i>&nbsp Adicionar Produto</button>
                                                <hr>
                                                <table class="table table-striped">
                                                    <thead>
                                                    <th>Nome Produto</th>
                                                    <th>Estoque</th>
                                                    <th>Disponivel</th>
                                                    <th>Armazem</th>
                                                    <th><i class="fas fa-trash"></i></th>
                                                    </thead>
                                                    <tr ng-if="produtos_selecionados.length === 0">
                                                        <td colspan="5">
                                                            Sem produtos selecionados, sera gerado o relatorio com todos movimentos
                                                        </td>
                                                    </tr>
                                                    <tr ng-repeat="p in produtos_selecionados">
                                                        <th>{{p.nome}}</th>
                                                        <th>{{p.estoque}}</th>
                                                        <th>{{p.disponivel}}</th>
                                                        <th>{{p.logistica===null?'Proprio':p.logistica.nome}}</th>
                                                        <th><button class="btn btn-danger" ng-click="removeProduto(p)"><i class="fa fa-trash"></i></button></th>
                                                    </tr>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="modal fade" id="mdlRelatorio" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Movimentos</h5>
                                    </div>
                                    <div class="modal-body">
                                        <span ng-if="gerando" style=";margin-left:auto;margin-right:auto" class="dashboard-spinner spinner-success spinner-lg "></span>

                                        <div style="width:100%;padding:10px;margin:5px" ng-if="!gerando" ng-repeat="item in relatorio">

                                            <h4>{{item.nome_produto + ' - ' + item.armazen}}, <strong style="color:SteelBlue">Estoque Atual: {{item.estoque_atual}}</strong>, <strong style="color:Orange">Disponivel Atual: {{item.disponivel_atual}}</strong></h4>
                                            <br>
                                            <table class="table table-striped">
                                                <thead>
                                                <th>Influencia Estoque</th>
                                                <th>Influencia Reserva</th>
                                                <th>Data</th>
                                                <th>Pessoa</th>
                                                <th>Ficha</th>
                                                <th>Nota</th>
                                                <th>Pedido</th>
                                                <th>Valor</th>
                                                <th>Icms</th>
                                                <th>Frete</th>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="mov in item.movimentos">
                                                        <td style="color:{{getCor(mov)}};text-align:center;font-weight: bold">{{mov.influencia_estoque}}</td>
                                                        <td style="color:{{getCor(mov)}};text-align:center;font-weight: bold">{{mov.influencia_reserva}}</td>
                                                        <td>{{mov.momento| data}}</td>
                                                        <td>{{mov.pessoa}}</td>
                                                        <td>{{mov.ficha===0?'------':mov.ficha}}</td>
                                                        <td>{{mov.numero_nota===0?'------':mov.numero_nota}}</td>
                                                        <td>{{mov.id_pedido===0?'------':mov.id_pedido}}</td>
                                                        <td>{{mov.valor_base}}</td>
                                                        <td>{{mov.icms}}</td>
                                                        <td>{{mov.frete}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>


                                        </div>

                                    </div>  
                                    <div class="modal-footer">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="produtos" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Seleção de produtos</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" class="form-control col-md-8" id="filtroProdutos" placeholder="Filtro">
                                        <hr>
                                        <table class="table table-striped table-bordered first">
                                            <thead>
                                            <th data-ordem="produto.codigo">Cod.</th>
                                            <th data-ordem="produto.nome">Produto</th>
                                            <th data-ordem="produto.disponivel">Disponivel</th>
                                            <th data-ordem="produto.id_logistica">Armazem</th>
                                            <th>Selecionar</th>
                                            </thead>
                                            <tr ng-repeat="produt in produtos.elementos">
                                                <th>{{produt[0].codigo}}</th>
                                                <th>{{produt[0].nome}}</th>
                                                <th>{{produt[0].disponivel}}</th>
                                                <th>{{produt[0].logistica===null?'Proprio':produt[0].logistica.nome}}</th>
                                                <th><button class="btn btn-success" ng-click="addProduto(produt[0])"><i class="fa fa-plus-circle"></i></button></th>
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

                <!-- /.modal-content --> 				
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