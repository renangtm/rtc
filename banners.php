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

    <body ng-controller="crtBanners">
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
                                    <h2 class="pageheader-title">Banners</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Banners</li>
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
                                                <a href="#" class="btn btn-primary" data-title="Add" data-toggle="modal" data-target="#add" ng-click="novoBanner()"><i class="fas fa-plus-circle m-r-10"></i>Adicionar Banner</a>
                                                <div style="float:right">
                                                    <select ng-model="bannerService.empresa" class="form-control" ng-change="trocaEmpresa()">
                                                        <option ng-repeat="empresa in clientes" ng-value="empresa">{{empresa.nome}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <table id="clientes" class="table table-striped table-bordered first">
                                                <thead>
                                                    <tr>
                                                        <th data-ordem="banner.id">Cod.</th>
                                                        <th data-ordem="banner.data_inicial">Data Inicial</th>
                                                        <th data-ordem="banner.data_final">Data Final</th>
                                                        <th data-ordem="banner.tipo">Tipo</th>
                                                        <th>Campanha</th>
                                                        <th width="180px">Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat-start="banner in banners.elementos">
                                                        <td>{{banner[0].id}}</td>
                                                        <td>{{banner[0].data_inicial| data}}</td>
                                                        <td>{{banner[0].data_final| data}}</td>
                                                        <td>{{tipos_banner[banner[0].tipo]}}</td>
                                                        <td>{{(banner[0].campanha !== null)?banner[0].campanha.nome:'Sem campanha, provavelmente e um banner institucional'}}</td>
                                                        <th>
                                                            <div class="product-btn">
                                                                <a href="#" class="btn btn-outline-light btninfo" data-toggle="collapse" ng-click="setBanner(banner[0])" data-target="#demo{{banner[0].id}}" class="accordion-toggle"><i class="fas fa-info-circle"></i></a>
                                                                <a href="#" class="btn btn-outline-light btnedit" data-title="Edit" ng-click="setBanner(banner[0])" data-toggle="modal" data-target="#add"><i class="fas fa-pencil-alt"></i></a>
                                                                <a href="#" class="btn btn-outline-light btndel" data-title="Delete" ng-click="setBanner(banner[0])" data-toggle="modal" data-target="#delete"><i class="fas fa-trash-alt"></i></a>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    <tr ng-repeat-end>
                                                        <td colspan="6" class="hiddenRow">
                                                            <div class="accordian-body collapse" id="demo{{banner[0].id}}">
                                                                <div class="row mx-auto m-b-30">

                                                                    <div ng-if="banner[0].tipo === 0" style="width: 100%">
                                                                        <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12 col-12">
                                                                            <div class="row">
                                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                    <div id="carouselExampleIndicators{{banner[0].id}}" class="product-carousel carousel slide m-b-40" data-ride="carousel">
                                                                                        <ol class="carousel-indicators">
                                                                                            <li data-target="#carouselExampleIndicators{{banner[0].id}}" data-slide-to="0" class="active" style="cursor: pointer;"></li>
                                                                                        </ol>
                                                                                        <div class="carousel-inner">
                                                                                            <div class="carousel-item active" id="html_{{banner[0].id}}" style="height:22vw">

                                                                                            </div>
                                                                                        </div>
                                                                                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                                            <span class="sr-only">Previous</span>  </a>
                                                                                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                                            <span class="sr-only">Next</span>  </a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div ng-if="banner[0].tipo === 1" style="width:14vw;height:auto" id="html_{{banner[0].id}}">

                                                                </div>
                                                                <div ng-if="banner[0].tipo === 2" style="width:14vw;height:auto" id="html_{{banner[0].id}}">

                                                                </div>
                                                            </div>	
                                                            </div> 
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Cod.</th>
                                                        <th>Data Inicial</th>
                                                        <th>Data Final</th>
                                                        <th>Tipo</th>
                                                        <th>Campanha</th>
                                                        <th width="180px">Ação</th>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                            <!-- paginação  -->
                                            <paginacao assinc="banners"></paginacao>

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
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-plus-circle fa-3x"></i>&nbsp;&nbsp;&nbsp;Altere os dados de seu Banner</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="add-form" ng-submit="mergeBanner()" parsley-validate>
                                    <div class="form-group row">
                                        <div class="col-2">
                                            <input type="text" ng-model="banner.campanha.id" class="form-control" placeholder="Cod." value="9" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" ng-model="banner.campanha.nome" class="form-control" placeholder="Nome da campanha" value="" disabled="">
                                        </div>
                                        <div class="col">
                                            <a href="#" class="btn btn-outline-light btnedit" ng-click="campanhas.attList()" data-toggle="modal" data-target="#campanhas"><i class="fas fa-search"></i></a>
                                        </div>
                                        <div class="col" ng-if="banner.campanha !== null">
                                            <a href="#" class="btn btn-outline-danger btnedit" ng-click="deleteCampanha()"><i class="fas fa-times"></i></a>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <calendario inicio="banner.data_inicial" fim="banner.data_final" refresh="banner" botao="true" tempo="true" meses="1"></calendario>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <button type="button" ng-disabled="banner.json !== null" class="btn btn-outline-dark" onclick="$('#uploaderHTML').click()"><i class="fas fa-upload"></i>&nbsp Subir HTML</button>
                                            <input type="file" id="uploaderHTML" style="display: none" />
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <div class="col-9 col-lg-10">
                                            <label for="slTipo" class="col-3 col-lg-2 col-form-label text-left">Tipo de Banner</label>
                                            <select ng-model="banner.tipo" id="slTipo" class="form-control">
                                                <option ng-repeat="t in tipos_banner" ng-value="$index" >{{t}}</option>
                                            </select>
                                        </div>
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
                ti
                <!-- /.modal-content EDIT --> 
                <div class="modal fade" id="campanhas" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Selecao de Campanha</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control" id="filtroCampanhas" placeholder="Filtro">
                                <hr>
                                <table class="table table-striped table-bordered first">
                                    <thead>
                                    <th data-ordem="campanha.id">Cod.</th>
                                    <th data-ordem="campanha.nome">Nome</th>
                                    <th data-ordem="campanha.inicio">Inicio</th>
                                    <th data-ordem="campanha.fim">Fim</th>
                                    <th>Selecionar</th>
                                    </thead>
                                    <tr ng-repeat="c in campanhas.elementos">
                                        <th>{{c[0].id}}</th>
                                        <th>{{c[0].nome}}</th>
                                        <th>{{c[0].inicio| data}}</th>
                                        <th>{{c[0].fim| data}}</th>
                                        <th><button class="btn btn-success" ng-click="setCampanha(c[0])" data-dismiss="modal" aria-label="Close"><i class="fa fa-info"></i></button></th>
                                    </tr> 
                                </table>
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
                            <div class="modal-footer">

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
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-trash-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Delete os dados de seu Banner</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center"> Tem certeza de que deseja excluir este Banner?</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" ng-click="deleteBanner(banner)">Sim</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Não</button>
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