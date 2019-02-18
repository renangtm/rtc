<!doctype html>
<html lang="en" ng-app="appRtc">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <script src="js/angular.min.js"></script>
        <script src="js/rtc.js"></script>
        <script src="js/filters.js"></script>
        <script src="js/services.js"></script>
        <script src="js/controllers.js"></script>   

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
        <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/libs/css/style.css">
        <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
        <link rel="stylesheet" href="assets/vendor/charts/chartist-bundle/chartist.css">
        <link rel="stylesheet" href="assets/vendor/charts/morris-bundle/morris.css">
        <link rel="stylesheet" href="assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="assets/vendor/charts/c3charts/c3.css">
        <link rel="stylesheet" href="assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
        <title>RTC (Reltrab Cliente) - WEB</title>
    </head>

    <body ng-controller="crtCompraParceiros">
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
            <?php 
            
            $filtro = "ng-model='produtos.filtro[0].valor' ng-confirm='produtos.attList()'";
            
            include("menu.php"); ?>
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
                                    <h2 class="pageheader-title">Comprar</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Comprar</li>
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
                        <!-- banner  -->
                        <!-- ============================================================== -->
                        <div class="row">
                            <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12 col-12">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">


                                        <div id="carouselExampleIndicators" class="product-carousel carousel slide m-b-40" data-ride="carousel">
                                            <ol class="carousel-indicators">
                                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                                <!--<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>-->
                                            </ol>
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <img class="d-block w-100" src="assets/images/banner_queima de estoque_784x295.jpg" alt="First slide">
                                                </div>
                                                <div class="carousel-item">
                                                    <img class="d-block w-100" src="assets/images/mega oferta_784x295.jpg" alt="Second slide">
                                                </div>
                                                <!--
                                                <div class="carousel-item">
                                                        <img class="d-block w-100" src="assets/images/card-img-3.jpg" alt="Third slide">
                                                </div>-->
                                            </div>
                                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>  </a>
                                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>  </a>
                                        </div>

                                    </div>

                                    <!-- ============================================================== -->
                                    <!-- end banner  -->
                                    <!-- ============================================================== -->
                                    <!-- texto resultado -->                                   

                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" ng-repeat="produto in dividir(produtos.elementos, 2)[0]">
                                        <div class="product-thumbnail">
                                            <div class="product-img-head">
                                                <div class="product-img">
                                                    <img src="{{produto.imagem}}" id="img_{{produto.id}}" alt="" class="img-fluid" onload="fechaLoad(this)" style="display: none">
                                                    <br>
                                                    <span id="sp_{{produto.id}}" class="dashboard-spinner spinner-success spinner-sm" style="width:250px;height:250px;margin-bottom:95px"></span>
                                                </div>
                                                <div class="ribbons" ng-if="produto.ofertas.length > 0"></div>
                                                <div class="ribbons-text m-l-10" ng-if="produto.ofertas.length > 0">Oferta</div>

                                            </div>
                                            <div class="product-content">
                                                <div class="product-content-head">
                                                    <h3 class="product-title">{{produto.nome}}</h3>
                                                    <div class="product-rating d-inline-block" style="min-height: 70px">

                                                        <div ng-repeat="oferta in produto.ofertas" style="font-size:15px">

                                                            <i class="fa fa-fw fa-star"></i>
                                                            &nbsp;
                                                            Oferta: 
                                                            &nbsp;

                                                            <span ng-if="oferta.validade !== 1000">{{oferta.validade| data_st}} &nbsp</span>

                                                            &nbsp;

                                                            <strong style="text-decoration:underline">{{oferta.valor}} R$ ({{(((oferta.valor - produto.valor_base) / produto.valor_base) * 100).toFixed(0)}}%)</strong>

                                                        </div>

                                                        <div ng-if="produto.ofertas.length === 0" style="color:Gray">
                                                            <i class="fa fa-fw fa-star"></i> Sem ofertas no momento
                                                        </div>
                                                        
                                                        <div style="color:SteelBlue">
                                                            <i class="fas fa-road"></i>&nbsp {{produto.empresa.nome}} 
                                                        </div>
                                                        
                                                        <div ng-if="produto.logistica !== null" style="color:DarkBlue">
                                                            
                                                            <i class="fas fa-box"></i>&nbsp {{produto.logistica.nome}} 
                                                        </div>

                                                    </div>
                                                    <div class="product-val"><button class="btn bn-default" style="margin-bottom:10px" ng-click="setProduto(produto)" data-toggle="modal" data-target="#validadeProduto"><i class="fa fa-info"></i>&nbsp Ver validades</button></div>
                                                    <div class="product-quant">{{produto.grade.gr[0]}} p/ caixa</div>
                                                    <div class="product-price">R$ {{produto.valor_base}} </div>

                                                </div>

                                                <div class="product-btn text-center">
                                                    <button ng-click="setProduto(produto)" data-toggle="modal" data-target="#validadeProduto" class="btn btn-primary btn-block">Comprar&nbsp;&nbsp;<i class="fas fa-shopping-cart"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- ============================================================== -->
                                    <!-- banner  -->
                                    <!-- ============================================================== -->

                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">


                                        <div id="carouselExampleIndicators" class="product-carousel carousel slide m-b-40" data-ride="carousel">
                                            <ol class="carousel-indicators">
                                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                                <!--<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>-->
                                            </ol>
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <img class="d-block w-100" src="assets/images/banner_queima de estoque_784x295.jpg" alt="First slide">
                                                </div>
                                                <div class="carousel-item">
                                                    <img class="d-block w-100" src="assets/images/mega oferta_784x295.jpg" alt="Second slide">
                                                </div>
                                                <!--
                                                <div class="carousel-item">
                                                        <img class="d-block w-100" src="assets/images/card-img-3.jpg" alt="Third slide">
                                                </div>-->
                                            </div>
                                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>  </a>
                                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>  </a>
                                        </div>

                                    </div>


                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" ng-repeat="produto in dividir(produtos.elementos, 2)[1]">
                                        <div class="product-thumbnail">
                                            <div class="product-img-head">
                                                <div class="product-img">
                                                    <img src="{{produto.imagem}}" id="img_{{produto.id}}" onload="fechaLoad(this)" alt="" class="img-fluid" style="display: none"></div>
                                                    <span id="sp_{{produto.id}}" class="dashboard-spinner spinner-success spinner-sm " style="width:250px;height:250px;margin-left:calc(50% - 125px )"></span>
                                                <div class="ribbons" ng-if="produto.ofertas.length > 0"></div>
                                                <div class="ribbons-text m-l-10" ng-if="produto.ofertas.length > 0">Oferta</div>

                                            </div>
                                            <div class="product-content">
                                                <div class="product-content-head">
                                                    <h3 class="product-title">{{produto.nome}}</h3>
                                                    <div class="product-rating d-inline-block" style="min-height: 70px">

                                                        <div ng-repeat="oferta in produto.ofertas" style="font-size:15px">

                                                            <i class="fa fa-fw fa-star"></i>
                                                            &nbsp;
                                                            Oferta: 
                                                            &nbsp;

                                                            <span ng-if="oferta.validade !== 1000">{{oferta.validade| data_st}} &nbsp</span>

                                                            &nbsp;

                                                            <strong style="text-decoration:underline">{{oferta.valor}} R$ ({{(((oferta.valor - produto.valor_base) / produto.valor_base) * 100).toFixed(0)}}%)</strong>

                                                        </div>

                                                        <div ng-if="produto.ofertas.length === 0" style="color:Gray">
                                                            <i class="fa fa-fw fa-star"></i> Sem ofertas no momento
                                                        </div>
                                                        
                                                        <div style="color:SteelBlue">
                                                            <i class="fas fa-road"></i>&nbsp {{produto.empresa.nome}} 
                                                        </div>
                                                        
                                                        <div ng-if="produto.logistica !== null" style="color:DarkBlue">
                                                            
                                                            <i class="fas fa-box"></i>&nbsp {{produto.logistica.nome}} 
                                                        </div>

                                                    </div>
                                                    <div class="product-val"><button class="btn bn-default" style="margin-bottom:10px" ng-click="setProduto(produto)" data-toggle="modal" data-target="#validadeProduto"><i class="fa fa-info"></i>&nbsp Ver validades</button></div>
                                                    <div class="product-quant">{{produto.grade.gr[0]}} p/ caixa</div>
                                                    <div class="product-price">R$ {{produto.valor_base}} </div>

                                                </div>

                                                <div class="product-btn text-center">
                                                    <button ng-click="setProduto(produto)" data-toggle="modal" data-target="#validadeProduto" class="btn btn-primary btn-block">Comprar&nbsp;&nbsp;<i class="fas fa-shopping-cart"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>





                                    <!-- ============================================================== -->
                                    <!-- paginação  -->
                                    <!-- ============================================================== -->
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination">
                                                <li class="page-item"><button class="page-link" ng-click="produtos.prev()">Anterior</button></li>
                                                <li class="page-item" ng-repeat="p in produtos.paginas"><button class="page-link {{p.isAtual?'btn btn-primary':''}}" ng-click="p.ir()">{{p.numero + 1}}</button></li>
                                                <li class="page-item"><button class="page-link" ng-click="produtos.next()">Proximo</button></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>



                            <!-- ============================================================== -->
                            <!-- sidebar BANNER + FILTRO  -->
                            <!-- ============================================================== -->	

                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="product-sidebar m-b-30">


                                    <div class="product-sidebar-widget" ng-repeat="filtro in produtos.filtro">
                                        <h4 class="product-sidebar-widget-title">{{filtro.nome}}</h4>
                                        <div class="form-group" ng-if="filtro._classe === 'FiltroTextual'">
                                            <div class="icon-addon addon-lg">
                                                <input class="form-control form-control-lg" ng-model="filtro.valor" ng-confirm="produtos.attList()" type="search" placeholder="{{filtro.nome}}" aria-label="Search">
                                                <label for="email" class="fa fa-search" rel="tooltip" title="email"></label>
                                            </div>
                                        </div>

                                        <div ng-if="filtro._classe === 'FiltroOpcional'" class="custom-control custom-checkbox" ng-repeat="opcao in filtro.opcoes" style="{{opcao.quantidade===0?'text-decoration:line-through;color:DarkRed':''}}">
                                            <button ng-if="opcao.selecionada === 0" ng-click="addLevel(opcao)" class="btn btn-default" style="width:20px;height:20px;padding:1px;padding-top:0px;padding-right:0px"><i class="fa fa-adjust"></i></button>
                                            <button ng-if="opcao.selecionada === 1" ng-click="addLevel(opcao)" class="btn btn-success" style="width:20px;height:20px;padding:1px;padding-top:0px;padding-right:0px"><i class="fa fa-check"></i></button>
                                            <button ng-if="opcao.selecionada === 2" ng-click="addLevel(opcao)" class="btn btn-danger" style="width:20px;height:20px;padding:1px;padding-top:0px;padding-right:0px"><i class="fa fa-times"></i></button>
                                            - {{opcao.nome}} <strong> ({{opcao.quantidade}})</strong>
                                        </div>

                                    </div>


                                    <div class="product-sidebar-widget">
                                        <button type="button" class="btn btn-outline-light" ng-click="resetarFiltro()">Resetar Filtro</button>
                                    </div>
                                </div>

                                <div class="modal fade" id="validadeProduto" tabindex="99" role="dialog" aria-labelledby="validadeProduto" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Validades do produto {{prod.nome}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">

                                                <table class="table table-striped table-bordered first">
                                                    <thead>
                                                    <th>Produto</th>
                                                    <th>Validade</th>
                                                    <th>Valor</th>
                                                    <th>Limite</th>
                                                    <th>Selecionar</th>
                                                    </thead>
                                                    <tr ng-repeat="v in prod.validades">
                                                        <th>{{prod.nome}}</th>
                                                        <th ng-if="v.validade !== 1000">{{v.validade| data_st}} <i class="fas fa-arrow-up" ng-if="v.alem" ></i></th>
                                                        <th ng-if="v.validade === 1000"> ------ </th>
                                                        <th>{{v.valor}} R$</th>
                                                        <th ng-if="v.limite>0"> {{v.limite}} </th>
                                                        <th ng-if="v.limite<=0"> ------ </th>
                                                        <th><button class="btn btn-success" data-dismiss="modal" aria-label="Close" ng-click="setValidade(v)" data-toggle="modal" data-target="#qtdProduto"><i class="fas fa-plus-circle"></i></button></th>
                                                    </tr>
                                                </table>

                                            </div>
                                            <div class="modal-footer">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="qtdProduto" tabindex="99" role="dialog" aria-labelledby="qtdProduto" aria-hidden="true">
                                    <div class="modal-dialog" style="max-width:227px">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Digite a quantidade desejada ?</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">

                                                <inteiro type="text" model="qtd"></inteiro>
                                                
                                            
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-primary" data-dismiss="modal" aria-label="Close" ng-click="addCarrinho()"><i class="fa fa-check"></i> &nbsp Adicionar ao carrinho</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- ============================================================== -->
                                <!-- sidebar BANNER 300x250  -->
                                <!-- ============================================================== -->

                                <div class="product-sidebar m-b-30">
                                    <div class="product-sidebar-widget p-0" style="margin-bottom: 0px">
                                        <img alt="pampa Design Medium Rectangle 300x250" src="assets/images/banner_300x250_pampa.jpg" style="width: 100%;">
                                    </div>
                                </div>

                                <!-- ============================================================== -->
                                <!-- sidebar BANNER 240x400  -->
                                <!-- ============================================================== -->

                                <div class="product-sidebar m-b-30">
                                    <div class="product-sidebar-widget p-0" style="margin-bottom: 0px">
                                        <img alt="tordon banner 240x400" src="assets/images/banner_240x400_tordon.jpg" style="width: 100%;">
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
            
            function fechaLoad(img){
                
                var im = $(img);
                var num = im.attr('id').split('_')[1];
               
                $("#sp_"+num).hide();
                im.css('display','initial');
                
            }

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




        </script>

    </body>

</html>