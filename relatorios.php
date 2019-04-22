<!doctype html>
<html lang="en" ng-app="appRtc">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">

        <script src="js/angular.min.js"></script>
        <script src="js/rtc.js?4"></script>
        <script>
            var relatorio = '<?php
if (!isset($_GET['rel'])) {

    exit;
}

$relatorio = $_GET['rel'];

echo $relatorio;
?>';

            rtc["relatorio"] = relatorio;
        </script>
        <script src="js/filters.js?4"></script>
        <script src="js/services.js?4"></script>
        <script src="js/controllers.js?4"></script>    

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

    <body ng-controller="crtRelatorio">
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
                                    <h2 class="pageheader-title">{{relatorio.nome}}</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">{{relatorio.nome}}</li>
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
                                        <div>
                                            <div class="product-btn m-b-20">
                                                <div style="width:100%;text-align:right">
                                                    <button class="btn btn-primary" ng-click="gerarPdf()" ng-disabled="carregando"><i class="fas fa-paperclip"></i>&nbspGerar Pdf</button>
                                                    <button class="btn btn-primary" ng-click="gerarXsd()" ng-disabled="carregando"><i class="fas fa-table"></i>&nbspGerar Excel</button>
                                                    <button class="btn btn-primary" ng-click="gerarRelatorio()" ng-disabled="carregando"><i class="fas fa-check"></i>&nbspGerar Relatorio</button>
                                                </div>
                                                <hr>
                                                <div style="display:inline-block;width:50%;margin-bottom:30px" ng-repeat="campo in relatorio.campos">
                                                    <h4>{{campo.titulo}} {{!campo.agrupado ? ' (Agrupado)' : ''}}</h4>
                                                    <hr>
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <div ng-if="campo.possiveis.length > 0">
                                                                    <input style="display: inline;margin-left:20px" type="checkbox" ng-model="p.selecionado" ng-repeat-start="p in campo.possiveis" id="chk{{p.termo}}">
                                                                    <label style="display:inline" for="chk{{p.termo}}" ng-repeat-end>{{p.termo}}</label>
                                                                    &nbsp&nbsp&nbsp&nbsp
                                                                </div>
                                                                <div ng-if="campo.possiveis.length === 0 && campo.tipo === 'T'">
                                                                    <input type="text" placeholder="{{campo.titulo}} ou deixe em branco" ng-model="campo.texto" class="form-control"></input>
                                                                </div>
                                                                <div ng-if="campo.possiveis.length === 0 && campo.tipo === 'N'">
                                                                    <table>
                                                                        <tr>
                                                                            <td>
                                                                                <select style="color:{{(campo.numero === 0)?'DarkRed':'DarkBlue'}};border:1px solid {{(campo.numero === 0)?'DarkRed':'DarkBlue'}};" class="form-control" ng-model="campo.modo">
                                                                                    <option ng-repeat="m in mn" ng-value="m">{{modos[m]}}</option>
                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <input style="color:{{(campo.numero === 0)?'DarkRed':'DarkBlue'}};border:1px solid {{(campo.numero === 0)?'DarkRed':'DarkBlue'}};max-width:70px" class="form-control" type="number" ng-model="campo.numero"></input>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2">
                                                                                0 = Sem Filtro
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <div ng-if="campo.possiveis.length === 0 && campo.tipo === 'D'" style="position: relative">
                                                                    <calendario botao="true" inicio="campo.inicio" fim="campo.fim" meses="1" tempo="true"></calendario>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-outline-success" ng-click="addOrdem(campo)" style="margin-left:10px;width:30px;height:30px;padding:4px"><i class="fas fa-arrow-up"></i>{{campo.ordem}}</button>
                                                                <button class="btn btn-outline-danger" ng-click="removeOrdem(campo)" style="margin-left:10px;width:30px;height:30px;padding:4px"><i class="fas fa-arrow-down"></i>{{campo.ordem}}</button>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-outline-primary" ng-if="!campo.somente_filtro" ng-click="inverteGroup(campo)" style="margin-left:10px;width:30px;height:30px;padding:4px"><i class="fas fa-object-group" ng-if="campo.agrupado"></i><i class="fas fa-object-ungroup" ng-if="!campo.agrupado"></i></button>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>

                                            </div>
                                            <!-- paginação  -->
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="modal fade" style="overflow-y:scroll" id="mdlRelatorio" tabindex="-1" role="dialog" aria-labelledby="mdlRelatorio" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content" >
                                        <div class="modal-header">
                                            <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-anchor fa-3x"></i>&nbsp;&nbsp;&nbsp;Relatorio</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-striped table-bordered first">
                                                <thead>
                                                <th ng-repeat="c in gerado.elementos[0][0].campos">{{c.titulo}}</th>
                                                </thead>
                                                <tr ng-repeat-start="item in gerado.elementos">
                                                    <th ng-repeat="c in item[0].valores_campos track by $index">{{c}}</th>
                                                </tr>
                                                <tr ng-repeat-end ng-if="item[0].campos_agrupados.length > 0">
                                                    <td colspan="{{gerado.elementos[0][0].campos.length}}">


                                                        <!-- --->

                                                        <table class="table table-striped table-bordered first">
                                                            <thead>
                                                            <th ng-repeat="cc in item[0].campos_agrupados">{{cc.titulo}}</th>
                                                            <th style="max-width:20px">Det</th>
                                                            </thead>
                                                            <tr>
                                                                <td ng-repeat="cc in item[0].valores_campos_agrupados track by $index">{{cc}}</td>
                                                                <td style="text-align: center;max-width:20px;{{(item[0].quantidade_filhos>0 && item[0].campos_agrupados.length > 0)?'cursor:pointer;color:SteelBlue;background-color:#FFFFFF':''}}" ng-click="detalhes(item[0])"><i class="fas fa-arrow-alt-circle-up"></i></td>
                                                            </tr>


                                                        </table>

                                                        <!-- --->

                                                    </td>
                                                </tr>
                                            </table>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                                <div style="display: inline-block" class="page-item" ng-repeat="pg in gerado.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            
                            <div class="modal fade" style="overflow-y:scroll" id="mdlXsd" tabindex="-1" role="dialog" aria-labelledby="mdlFilhos" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content" >
                                        <div class="modal-header">
                                            <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-table fa-3x"></i>&nbsp;&nbsp;&nbsp;Gerado com sucesso !</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">
                                            
                                            <a download="{{relatorio._classe}}.xls" href="{{xsd}}"><i class="fas fa-upload"></i>&nbsp Baixar Excel</a>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            
                            <div class="modal fade" style="overflow-y:scroll" id="mdlPdf" tabindex="-1" role="dialog" aria-labelledby="mdlFilhos" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content" >
                                        <div class="modal-header">
                                            <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-table fa-3x"></i>&nbsp;&nbsp;&nbsp;Gerado com sucesso !</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">
                                            
                                            <a download="{{relatorio._classe}}.pdf" href="{{pdf}}"><i class="fas fa-upload"></i>&nbsp Baixar Pdf</a>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" style="overflow-y:scroll" id="mdlFilhos" tabindex="-1" role="dialog" aria-labelledby="mdlFilhos" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content" >
                                        <div class="modal-header">
                                            <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-sitemap fa-3x"></i>&nbsp;&nbsp;&nbsp;Elementos Separados</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-striped table-bordered first">
                                                <thead>
                                                <th ng-repeat="c in filhos[0].campos">{{c.titulo}}</th>
                                                </thead>
                                                <tr ng-repeat="item in filhos">
                                                    <th ng-repeat="c in item.valores_campos track by $index">{{c}}</th>
                                                </tr>

                                            </table>


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

                <!-- /.modal-content -->

                <!-- /.modal-content EDIT --> 

                <!-- /.modal-content --> 				



                <!-- /.modal-content DELETE --> 

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
