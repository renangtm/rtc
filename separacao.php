<html lang="en" ng-app="appRtc">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">

        <script src="js/angular.min.js"></script>
        <script src="js/rtc.js?5"></script>

        <script>

<?php
if (!isset($_GET['pedido']) || !isset($_GET['empresa'])) {

    exit;
}

$id_empresa = $_GET['empresa'];
$id_pedido = $_GET['pedido'];
?>
            rtc.id_empresa = <?php echo $id_empresa; ?>;
            rtc.id_pedido = <?php echo $id_pedido; ?>;

        </script>

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
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/fixedHeader.bootstrap4.css">        <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">-->
        <title>RTC (Reltrab Cliente) - WEB</title>

    </head>

    <body ng-controller="crtSeparacao">
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
            <?php
            include("menu.php");
            ?>
            <!-- end left sidebar -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- wrapper  -->
            <!-- ============================================================== -->
            <div style="width:60%;margin-left:auto;margin-right:auto;background-color:#FAFAFA;margin-top:50px">
                <div class="dashboard-ecommerce" >
                    <div class="container-fluid dashboard-content ">
                        <!-- ============================================================== -->
                        <!-- pageheader  -->
                        <!-- ============================================================== -->
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="page-header">
                                    <h2 class="pageheader-title">Separacao do pedido {{pedido.id}} por '<?php echo $usuario->nome; ?>'</h2>


                                    <button class="btn btn-primary" style="float:right" ng-disabled="!podeFinalizar()" ng-click="finalizarSeparacao()">
                                        <i class="fas fa-check"></i> &nbsp; Finalizar separacao
                                    </button>
                                    <button class="btn btn-primary" style="float:right;margin-right:10px" ng-if="pedido !== null && itens.length > 0" ng-click="gerarRelatorio()">
                                        <i class="fas fa-paperclip"></i> &nbsp; Imprimir
                                    </button>
                                    <button class="btn btn-primary" style="float:right;margin-right:10px" ng-click="imprimirItens()">
                                        <i class="fas fa-paperclip"></i> &nbsp; Imprimir Etiquetas
                                    </button>
                                    <hr>

                                    <div class="modal-body">
                                        <input type="text" ng-confirm="bipe()" ng-model="codigo" id="txtBipe" class="form-control" style="margin-top: 30px;border:3px solid;height:70px;padding:20px;font-size:30px">
                                        <table class="table table-striped" style="margin-top: 50px">
                                            <thead>
                                            <th>ID Produto</th>
                                            <th>Nome Produto</th>
                                            <th>ID Lote</th>
                                            <th>Qtd</th>
                                            <th>Codigo Barra</th>
                                            <th>Descricao Item</th>
                                            <th>Rua</th>
                                            <th>Numero</th>
                                            <th>Altura</th>
                                            </thead>
                                            <tr ng-repeat="item in itens" style="{{item.codigo_bipado!==''?'background-color:LightGreen;color:#FFFFFF':''}}">
                                                <th>{{item.id_produto}}</th>
                                                <th>{{item.nome_produto}}</th>
                                                <th>{{item.id_lote}}</th>
                                                <th>{{item.quantidade}}</th>
                                                <th><strong style="color:Red;font-size:20px">{{item.codigo}}</strong></th>
                                                <th>{{item.descricao}}</th>
                                                <th>{{item.rua}}</th>
                                                <th>{{item.numero}}</th>
                                                <th>{{item.altura}}</th>
                                            </tr>
                                        </table>


                                    </div>


                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Separacao</a></li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form>



                        </form>

                    </div>

                    <div class="modal fade" style="overflow-y:scroll" id="mdlRelatorio" tabindex="-1" role="dialog" aria-labelledby="mdlFilhos" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content" >
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-table fa-3x"></i>&nbsp;&nbsp;&nbsp;Gerado com sucesso !</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">

                                <a href="{{relatorio_separacao}}" onclick="dms()" target="_blank"><i class="fas fa-upload"></i>&nbsp Abrir relatorio</a>

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


        </div>
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

        function dms(){
            
            setTimeout(function(){
                $("#mdlRelatorio").modal('hide');
            },1000)
            
        }
                                setInterval(function () {
                                    $("#txtBipe").focus();
                                }, 1000)

                                var first_load = true;
                                function imprimir() {

                                    if (first_load) {
                                        setTimeout(function () {
                                            first_load = false;
                                        }, 2000);

                                        return;
                                    }

                                    var pdfFrame = window.frames["pdf"];
                                    pdfFrame.focus();
                                    pdfFrame.print();
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

                                $(document).ready(function () {
                                    $('.btnvis').tooltip({title: "Visualizar", placement: "top"});
                                    $('.btnedit').tooltip({title: "Editar", placement: "top"});
                                    $('.btndel').tooltip({title: "Deletar", placement: "top"});
                                    $('.btnaddprod').tooltip({title: "Adicionar", placement: "top"});
                                });


        </script>

    </body>

</html>