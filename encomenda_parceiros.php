<!doctype html>
<html lang="en" ng-app="appRtc">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <script src="js/angular.min.js"></script>
        <script src="js/rtc.js?5"></script>
        <script src="js/filters.js?5"></script>
        <script src="js/services.js?5"></script>
        <script src="js/controllers.js?5"></script>  <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>   

        <!-- Bootstrap CSS -->
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
        <style>
            a:hover {
                color: #4aaf51;
            }

            .product-sidebar-widget-title .fas {
                transition: .3s transform ease-in-out;   
            }


        </style>
    </head>

    <body ng-controller="crtEncomendaParceiros">
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
            $filtro = "ng-model='produtos.filtro[0].valor' ng-confirm='produtos.attList()' ng-if='!carregando_compra'";

            include("menu.php");

            $b = Sistema::getBanners(new ConnectionFactory());

            $banners_frontais = array();
            $banners_laterais = array();

            if (isset($b[0])) {
                $banners_frontais = $b[0];
            }

            if (isset($b[1])) {
                $banners_laterais = $b[1];
            }
            ?>
            <!-- ============================================================== -->
            <!-- end left sidebar -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- wrapper  -->
            <!-- ============================================================== -->
            <div style="width:400px;height:100px;padding:10px;border:1px dashed;border-bottom-left-radius: 10px;position:fixed;right:0px;top:66px;z-index:9999;background-color: #FFFFFF">
                <button class="btn btn-primary" data-toggle="modal" data-target="#encomenda_avancada" style="width:100%;height:100%">
                    <i class="fas fa-search"></i>&nbsp Encomenda avancada.
                </button>
            </div>

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
                                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active" style="cursor: pointer;"></li>
                                                <li data-target="#carouselExampleIndicators" data-slide-to="1" style="cursor: pointer;"></li>
                                                <?php
                                                $i = 2; //manter sempre proximo numero inteiro apos o <li data-slide-to> anterior

                                                for ($j = 0; $j < count($banners_frontais); $j++) {
                                                    ?>
                                                    <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo ($j + $i); ?>" style="cursor: pointer;"></li>
                                                    <?php
                                                }
                                                ?>
                                            </ol>
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <a href="http://agrofauna.com.br/mail/fraude_boletos/email_fraude_boletos_bancarios.html">
                                                        <img class="d-block w-100" src="assets/images/banner_fraude_em_boletos_784x295.jpg" alt="First slide">
                                                    </a>
                                                </div>
                                                <div class="carousel-item">
                                                    <a href="http://agrofauna.com.br/apresentacao_rtc_v6.pdf" target="_blank">
                                                        <img class="d-block w-100" src="assets/images/banner_fraude_em_boletos_784x295.jpg" alt="First slide">
                                                    </a>    
                                                </div>
                                                <?php
                                                for ($j = 0; $j < count($banners_frontais); $j++) {
                                                    ?>
                                                    <div class="carousel-item" style="height:22vw">
                                                        <?php echo $banners_frontais[$j]; ?>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
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

                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" ng-if="!carregando_encomenda" ng-repeat="produto in dividir(produtos.elementos, 2)[0]">
                                        <div class="product-thumbnail">
                                            <div class="product-img-head">
                                                <div class="product-img">
                                                    <img src="{{produto.imagem}}" id="img_{{produto.id}}" data-padrao="{{produto.imagem_padrao}}" alt="" class="img-fluid" onload="fechaLoad(this)" onerror="altImg(this)" style="display: none">
                                                    <br>
                                                    <span id="sp_{{produto.id}}" class="dashboard-spinner spinner-success spinner-sm" style="width:100px;height:100px;margin-bottom:95px"></span>
                                                </div>
                                                <div class="ribbons" ng-if="produto.ofertas > 0"></div>
                                                <div class="ribbons-text" ng-if="produto.ofertas > 0" style="margin-left: 5px;">Oferta</div>

                                            </div>
                                            <div class="product-content">
                                                <div class="product-content-head">
                                                    <h3 class="product-title">{{produto.nome}}</h3>
                                                    <hr>

                                                    <table class="table table-striped">
                                                        <thead>
                                                        <th>
                                                            De (R$)
                                                        </th>
                                                        <th>
                                                            Ate (R$)
                                                        </th>
                                                        <th>
                                                            <i class="fas fa-plus-circle"></i>
                                                        </th>
                                                        </thead>
                                                        <tr>
                                                            <th>
                                                                {{produto.valor_base_inicial}}
                                                            </th>
                                                            <th>
                                                                {{produto.valor_base_final}}
                                                            </th>
                                                            <th>
                                                                <button class="btn btn-success" ng-click="addCarrinho(produto)"><i class="fas fa-plus-circle"></i></button>
                                                            </th>
                                                        </tr>
                                                        <tfoot>
                                                        <th style="{{produto.custo_atualizado?'color:Green;font-size:16px':'color:Red;font-size:11px'}}">
                                                            {{produto.custo_atualizado?'Custos Atualizados':'Custo Desatualizado. Podera sofrer variações'}}
                                                        </th>
                                                        </tfoot>
                                                    </table>
                                                    <hr>
                                                    <div style="color:SteelBlue;font-size:18px;font-weight: bold">
                                                        <i class="fas fa-home"></i>&nbsp {{produto.empresa.nome}} 
                                                    </div>
                                                </div>
                                                <div class="product-quant" style="font-size:15px;font-weight: bold;font-style: italic;color:#000000">{{produto.grade.gr[0]}} por caixa</div>

                                            </div>

                                            <div class="product-btn text-center">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" ng-if="carregando_compra" ng-repeat="l in loaders">
                                        <div class="product-thumbnail" style="height:500px;border:1px dashed;border:3px solid #DDDDDD;border-radius:5px;border-bottom: 250px solid #F2F2F2">
                                            <div class="product-img-head">
                                                <div class="product-img">

                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-content-head">
                                                    <h3 class="product-title"></h3>
                                                </div>
                                            </div>

                                            <div class="product-btn text-center">
                                                <span class="dashboard-spinner spinner-success spinner-lg" style="width:100px;height:100px;margin-bottom:95px"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ============================================================== -->
                                    <!-- banner  -->
                                    <!-- ============================================================== -->


                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" ng-if="!carregando_encomenda" ng-repeat="produto in dividir(produtos.elementos, 2)[1]">
                                        <div class="product-thumbnail">
                                            <div class="product-img-head">
                                                <div class="product-img">
                                                    <img src="{{produto.imagem}}" data-padrao="{{produto.imagem_padrao}}" id="img_{{produto.id}}" alt="" class="img-fluid" onload="fechaLoad(this)" onerror="altImg(this)" style="display: none">
                                                    <br>
                                                    <span id="sp_{{produto.id}}" class="dashboard-spinner spinner-success spinner-sm" style="width:100px;height:100px;margin-bottom:95px"></span>
                                                </div>
                                                <div class="ribbons" ng-if="produto.ofertas > 0"></div>
                                                <div class="ribbons-text" ng-if="produto.ofertas > 0" style="margin-left: 5px;">Oferta</div>

                                            </div>
                                            <div class="product-content">
                                                <div class="product-content-head">
                                                    <h3 class="product-title">{{produto.nome}}</h3>
                                                    <hr>

                                                    <table class="table table-striped">
                                                        <thead>
                                                        <th>
                                                            De (R$)
                                                        </th>
                                                        <th>
                                                            Ate (R$)
                                                        </th>
                                                        <th>
                                                            <i class="fas fa-plus-circle"></i>
                                                        </th>
                                                        </thead>
                                                        <tr>
                                                            <th>
                                                                {{produto.valor_base_inicial}}
                                                            </th>
                                                            <th>
                                                                {{produto.valor_base_final}}
                                                            </th>
                                                            <th>
                                                                <button class="btn btn-success" ng-click="addCarrinho(produto)"><i class="fas fa-plus-circle"></i></button>
                                                            </th>
                                                        </tr>
                                                        <tfoot>
                                                        <th style="{{produto.custo_atualizado?'color:Green;font-size:16px':'color:Red;font-size:11px'}}">
                                                            {{produto.custo_atualizado?'Custos Atualizados':'Custo Desatualizado. Podera sofrer variações'}}
                                                        </th>
                                                        </tfoot>
                                                    </table>
                                                    <hr>
                                                    <div style="color:SteelBlue;font-size:18px;font-weight: bold">
                                                        <i class="fas fa-home"></i>&nbsp {{produto.empresa.nome}} 
                                                    </div>
                                                </div>
                                                <div class="product-quant" style="font-size:15px;font-weight: bold;font-style: italic;color:#000000">{{produto.grade.gr[0]}} por caixa</div>

                                            </div>

                                            <div class="product-btn text-center">

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
                                <div class="product-sidebar m-b-30" ng-if="!carregando_compra">
                                    <div class="product-sidebar-widget" ng-repeat="filtro in produtos.filtro">
                                        <h4 ng-if="filtro._classe === 'FiltroTextual'" class="product-sidebar-widget-title">Busca por filtro</h4>
                                        <h4 ng-if="filtro._classe === 'FiltroOpcional'" class="product-sidebar-widget-title">
                                            <a class="" data-toggle="collapse" href="#collapseExample_{{filtro.id}}" role="button" aria-expanded="false" aria-controls="collapseExample_{{filtro.id}}">
                                                {{filtro.nome}}<span class="fas ml-2 fa-angle-down"></span>
                                            </a>
                                        </h4>
                                        <div class="form-group" ng-if="filtro._classe === 'FiltroTextual'">
                                            <div class="icon-addon addon-lg">
                                                <input class="form-control form-control-lg" ng-model="filtro.valor" ng-confirm="produtos.attList()" type="search" placeholder="{{filtro.nome}}" aria-label="Search">
                                                <label for="email" class="fa fa-search" rel="tooltip" title="email"></label>
                                            </div>
                                        </div>
                                        <div ng-if="filtro._classe === 'FiltroOpcional'" class="collapse" id="collapseExample_{{filtro.id}}">
                                            <div  class="custom-control custom-checkbox" ng-repeat="opcao in filtro.opcoes" style="{{opcao.quantidade===0?'text-decoration:line-through;color:DarkRed':''}}">
                                                <a ng-if="opcao.selecionada === 0" ng-click="addLevel(opcao, filtro)" style="width:auto;height:20px;padding:3px;padding-top:0px;padding-right:0px;cursor:pointer"><i class="fa fa-square"></i>&nbsp {{opcao.nome}} <strong> {{opcao.quantidade > 0 ? '(' + opcao.quantidade + ')' : ''}}</a>
                                                <a ng-if="opcao.selecionada === 1" ng-click="addLevel(opcao, filtro)" style="width:auto;height:20px;padding:3px;padding-top:0px;padding-right:0px;cursor:pointer"><i class="fa fa-check"></i>&nbsp {{opcao.nome}} <strong> {{opcao.quantidade > 0 ? '(' + opcao.quantidade + ')' : ''}}</a>

                                            </div>
                                            <button type="button" class="btn btn-success" ng-click="resetarFiltro()"><i class="fas fa-certificate"></i>&nbsp Mostrar Todos Produtos</button>
                                        </div>
                                    </div>
                                    <div class="product-sidebar-widget">
                                        <button type="button" class="btn btn-outline-light" ng-click="resetarFiltro()">Resetar Filtro</button>
                                    </div>
                                </div>
                                <div class="product-sidebar m-b-30" ng-if="carregando_compra" style="height:1200px;border:3px solid #DDDDDD;border-radius:5px">
                                    <div class="product-sidebar-widget" style="text-align: center">
                                        <span class="dashboard-spinner spinner-success spinner-sm " style="width:150px;height:150px;margin-top:95px"></span>
                                    </div>
                                </div>
                                <!-- ============================================================== -->
                                <!-- MODAL validade produto  -->
                                <!-- ============================================================== -->

                                <div class="modal fade" id="locaisProduto" tabindex="99" role="dialog" aria-labelledby="locaisProduto" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Outros locais do produto {{produto.nome}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">

                                                <table class="table table-striped">
                                                    <thead>
                                                    <th>
                                                        Local
                                                    </th>
                                                    <th>
                                                        Validade
                                                    </th>
                                                    <th>
                                                        Preço (R$)
                                                    </th>
                                                    <th>
                                                        <i class="fas fa-plus-circle"></i>
                                                    </th>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="local in locais" style="{{local.validade.oferta?'color:Green !important':''}}">
                                                            <td>
                                                                {{(local.local.logistica !== null)?local.local.logistica.nome:local.local.empresa.nome}}
                                                            </td>
                                                            <td>
                                                                {{local.validade.validade| data_st}}
                                                            </td>
                                                            <td>
                                                                {{local.validade.valor}}
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-success" style="padding:5px;width:100%" ng-click="addCarrinho(local.local, local.validade)">
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                            <div class="modal-footer">

                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <!-- ============================================================== -->
                                <!-- sidebar BANNER 300x250  -->
                                <!-- ============================================================== -->

                                <?php foreach ($banners_laterais as $key => $value) { ?>
                                    <div class="">
                                        <div class="" style="margin-bottom: 0px">
                                            <div style="">
                                                <?php echo $value; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

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

        <style>
            .search_line{
                padding:10px;
                border-bottom:1px solid;
                cursor:pointer;
            }
            .search_line:hover{
                padding:10px;
                border-bottom:1px solid;
                cursor:pointer;
                color:#FFFFFF;
                background-color:SteelBlue
            }
            .pdt td{
                 padding:5px
            }
        </style>
        <div ng-controller="crtProdutoEncomenda" class="modal fade" id="encomenda_avancada" tabindex="99" role="dialog" aria-labelledby="encomenda_avancada" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-search fa-3x"></i>&nbsp;&nbsp;&nbsp;Encomenda Avancada</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="col-md-5">
                                <i class="fas fa-box" style="display: inline"></i>&nbsp <h4 style="display: inline">Seus produtos</h4>
                                <hr>
                                <input type="text" class="form-control col-md-8" id="filtroProdutos2" placeholder="Filtro">
                                <br>
                                <table class="table table-striped table-bordered first">
                                    <thead>
                                        <th data-ordem="produto.codigo">Cod.</th>
                                        <th data-ordem="produto.nome">Produto</th>
                                        <th><i class="fas fa-mouse-pointer"></i></th>
                                    </thead>
                                    <tr ng-repeat="produt in produtos_av.elementos" style="cursor:pointer;" ng-click="selecionarPossibilidade(produt[0])">
                                        <th style="{{produt[0].id===produto_av.id?'background-color:SteelBlue;color:#FFFFFF':''}}">{{produt[0].codigo}}</th>
                                        <th style="{{produt[0].id===produto_av.id?'background-color:SteelBlue;color:#FFFFFF':''}}">{{produt[0].nome}}</th>
                                        <th style="{{produt[0].id===produto_av.id?'background-color:SteelBlue;color:#FFFFFF':''}}"><i class="fas fa-square"></i></th>
                                    </tr>
                                </table>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item" ng-click="produtos_av.prev()"><a class="page-link" href="">Anterior</a></li>
                                            <li class="page-item" ng-repeat="pg in produtos_av.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></li>
                                            <li class="page-item" ng-click="produtos_av.next()"><a class="page-link" href="">Próximo</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <i class="fas fa-truck" style="display: inline"></i>&nbsp <h4 style="display: inline">Produto a ser encomendado</h4>
                                <hr>
                                <div ng-if="travado_av">
                                    <button class="btn btn-danger" ng-click="destravar()">
                                        <i class="fas fa-times"></i>
                                        &nbsp;
                                        Alterar produto
                                    </button>
                                    <hr>
                                </div>
                                <table style="width:100%" class="pdt">
                                    <tr>
                                        <td>
                                            Nome:
                                        </td>
                                        <td style="position:relative">
                                            <input ng-change="atualizarPossibilidades()" ng-disabled="travado_av" type="text" placeholder="Nome do produto" class="form-control" style="width:100%" ng-model="produto_av.nome">
                                            <div ng-if="produtos_possiveis_av.length>0 && !travado_av" style="width:100%;top:40px;background-color:#FAFAFA;border:3px solid SteelBlue">
                                                Foram encontrados produtos semelhantes no RTC, seria algum destes ?<br>
                                                <div ng-repeat="pos in produtos_possiveis_av" ng-click="selecionarPossibilidadeSemEstoque(pos)" class="search_line">
                                                    <img style="height:40px" src="{{pos.imagem}}"></img>
                                                    &nbsp;
                                                    <strong>{{pos.nome}}</strong>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Fabricante:
                                        </td>
                                        <td>
                                            <input ng-disabled="travado_av" type="text" placeholder="Nome do fabricante" class="form-control" style="width:90%" ng-model="produto_av.fabricante">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Custo Medio (R$):
                                        </td>
                                        <td>
                                            <input ng-disabled="travado_av" type="number" placeholder="Custo Medio" class="form-control" style="width:40%" ng-model="produto_av.custo">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Classe de Risco:
                                        </td>
                                        <td>
                                            <input ng-disabled="travado_av" type="number" placeholder="Classe Risco" class="form-control" style="width:40%" ng-model="produto_av.classe_risco">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Ativo:
                                        </td>
                                        <td>
                                            <input ng-disabled="travado_av" type="text" placeholder="Ativo" class="form-control" style="width:80%" ng-model="produto_av.ativo">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Quantidade:
                                        </td>
                                        <td>
                                            <input type="number" placeholder="Quantidade a encomendar" class="form-control" style="width:40%" ng-model="quantidade_av">
                                        </td>
                                    </tr>
                                </table>
                                <hr>
                                <button class="btn btn-success" ng-disabled="!liberado()" ng-click="finalizar()">
                                    <i class="fas fa-truck"></i>
                                    &nbsp;
                                    {{(!liberado())?"Digite as informacoes corretamente para encomendar":"Encomendar produto"}}
                                </button>
                                
                                <button onclick="window.open('carrinho_encomenda.php')" class="btn btn-success" style="margin-left:10px">
                                    <i class="fas fa-cart-plus"></i>
                                    &nbsp;
                                    Carrinho de encomenda
                                </button>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>


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

                                                                            function filtro(fi) {

                                                                                $('#filtro').each(function () {

                                                                                    // Make sure the select element reflects the change (as setting the option doesn't always do this properly).
                                                                                    $(this).val(fi);

                                                                                    // Now use the Angular API's triggerHandler function to call the change.
                                                                                    angular.element($(this)).triggerHandler('change');
                                                                                    $(this).change();

                                                                                    var body = $("html, body");
                                                                                    body.stop().animate({scrollTop: 290}, 500, 'swing', function () {

                                                                                    });

                                                                                })



                                                                            }


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

                                                                            function fechaLoad(img) {

                                                                                var im = $(img);
                                                                                var num = im.attr('id').split('_')[1];


                                                                                $("#sp_" + num).hide();
                                                                                im.css('display', 'initial');

                                                                            }
                                                                            function altImg(img) {

                                                                                var im = $(img);
                                                                                var num = im.attr('id').split('_')[1];

                                                                                $("#sp_" + num).hide();
                                                                                im.attr('src', im.data('padrao'));
                                                                            }





        </script>

        <script>



                    $('.collapse').on('shown.bs.collapse', function () {
                        /* $(this).parent().find(".fa-angle-down").removeClass("fa-angle-down").addClass("fa-angle-up");*/
                        $(this).parent().find(".fa-angle-down").css('transform', 'rotate(180deg)');
                    }).on('hidden.bs.collapse', function () {
                        /*$(this).parent().find(".fa-angle-up").removeClass("fa-angle-up").addClass("fa-angle-down");*/
                        $(this).parent().find(".fa-angle-down").css('transform', 'rotate(0deg)');
                    });
        </script>

    </body>

</html>
