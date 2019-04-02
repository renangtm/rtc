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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/dataTables.bootstrap4.css">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/buttons.bootstrap4.css">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/select.bootstrap4.css">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/fixedHeader.bootstrap4.css">
        <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">-->
        <link rel="stylesheet" href="assets/vendor/multi-select/css/multi-select.css">
        <title>RTC (Reltrab Cliente) - WEB</title>
        <style>
        </style>
    </head>

    <body ng-controller="crtEmpresaConfig">

        <!-- main wrapper -->
        <!-- ============================================================== -->
        <div class="dashboard-main-wrapper">
            <!-- ============================================================== -->
            <!-- navbar -->
            <!-- ============================================================== -->

            <!-- ============================================================== -->
            <!-- end navbar -->
            <!-- ============================================================== -->
            <?php include("menu.php"); ?>
            <!-- ============================================================== -->
            <!-- left sidebar -->
            <!-- ============================================================== -->

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
                                    <h2 class="pageheader-title">Configuracoes da <?php echo $empresa->nome; ?></h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Configuracoes da empresa</li>
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
                                        <?php if ($empresa->tipo_empresa === 5) { ?>
                                            <select style="width:200px" class="form-control" ng-model="empresa_atual" ng-change="trocaEmpresa()">
                                                <option ng-repeat="e in empresas_clientes" ng-value="e">{{e.nome}}</option>
                                            </select>
                                            <hr>
                                        <?php } ?>
                                        <form id="add-form" ng-submit="mergeEmpresa()" parsley-validate>
                                            <div class="form-group row">
                                                <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Razao Social</label>
                                                <div class="col-md-5">
                                                    <input id="txtname" type="text" ng-model="empresa.nome" required data-parsley-type="email" placeholder="" class="form-control">
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-5">
                                                    <email entidade="Empresa" atributo="empresa.email" senha="true" alterar="true"></email>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Inscricao Estadual</label>
                                                <div class="col-md-4">
                                                    <input id="txtname" type="text" ng-model="empresa.inscricao_estadual" required data-parsley-type="email" placeholder="" class="form-control">
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Telefone</label>
                                                <div class="col-md-4">
                                                    <telefone model="empresa.telefone.numero"></telefone>
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">CNPJ</label>
                                                <div class="col-md-4">
                                                    <input id="txtname" type="text" ng-model="empresa.cnpj.valor" required data-parsley-type="email" placeholder="" class="form-control">
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Rua</label>
                                                <div class="col-md-4">
                                                    <input id="txtname" type="text" ng-model="empresa.endereco.rua" required data-parsley-type="email" placeholder="" class="form-control">
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Bairro</label>
                                                <div class="col-md-4">
                                                    <input id="txtname" type="text" ng-model="empresa.endereco.bairro" required data-parsley-type="email" placeholder="" class="form-control">
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Numero</label>
                                                <div class="col-md-2">
                                                    <input id="txtname" type="text" ng-model="empresa.endereco.numero" required data-parsley-type="email" placeholder="" class="form-control">
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">CEP</label>
                                                <div class="col-md-4">
                                                    <input id="txtname" type="text" ng-model="empresa.endereco.cep.valor" required data-parsley-type="email" placeholder="" class="form-control">
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label  class="col-3 col-lg-2 col-form-label text-left">Estado</label>
                                                <div class="col-md-2">
                                                    <select ng-model="estado" class="form-control">
                                                        <option ng-repeat="e in estados" ng-value="e">{{e.sigla}}</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label  class="col-3 col-lg-2 col-form-label text-left">Cidade</label>
                                                <div class="col-md-5">
                                                    <select ng-model="empresa.endereco.cidade" class="form-control">
                                                        <option ng-repeat="cidade in estado.cidades" ng-value="cidade">{{cidade.nome}}</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Juros Mensal %</label>
                                                <div class="col-md-4">
                                                    <decimal model="empresa.juros_mensal"></decimal>
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Ultima NFe</label>
                                                <div class="col-md-3">
                                                    <inteiro model="parametros_emissao.nota"></inteiro>
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Serie NFe</label>
                                                <div class="col-md-3">
                                                    <inteiro model="parametros_emissao.serie"></inteiro>
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="txtname" class="col-4 col-lg-2 col-form-label text-left">Lote NFe</label>
                                                <div class="col-md-3">
                                                    <inteiro model="parametros_emissao.lote"></inteiro>
                                                    <div class="invalid-feedback">
                                                        Please provide a valid text.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3">

                                                    Marketing Contrada:


                                                </div>
                                                <div class="col-md-3">

                                                    <div ng-repeat="mkt in marketings">
                                                        <input type="checkbox" ng-click="setMarketing(mkt)" ng-checked="mkt === marketing" id="{{(mkt!==null)?'mkt_'+mkt.id:'sep'}}">
                                                        &nbsp<label for="{{(mkt!==null)?'mkt_'+mkt.id:'sep'}}">{{(mkt!==null)?mkt.nome:'Sem empresa de mkt'}}</label>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3">

                                                    Administracao Contrada:


                                                </div>
                                                <div class="col-md-3">
                                                    <div ng-repeat="ad in adms">
                                                        <input type="checkbox" ng-click="setAdm(ad)" ng-checked="ad === adm" id="{{(ad!==null)?'adm_'+ad.id:'sep'}}">
                                                        &nbsp<label for="{{(ad!==null)?'adm_'+ad.id:'sep'}}">{{(ad!==null)?ad.nome:'Sem empresa de administracao'}}</label>
                                                    </div>

                                                </div>
                                            </div>
                                            <?php if ($usuario->temPermissao(Sistema::P_NOTA()->m("A"))) { ?>
                                                <hr>
                                                <div class="form-group row">
                                                    <div class="col-md-2">Certificado</div>
                                                    <div class="col-md-3">
                                                        <button type="button" onclick="$('#uploaderCertificadoDigital').click()" class="btn btn-outline-{{parametros_emissao.certificado===''?'danger':'success'}}"><i class="fas fa-key"></i>&nbsp Certificado Digital NFe A1</button>
                                                        <input type="file" id="uploaderCertificadoDigital" style="display:none">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="txtname" class="col-4 col-lg-2 col-form-label text-left">Senha</label>
                                                    <div class="col-md-3">
                                                        <input id="txtname" type="password" ng-model="parametros_emissao.senha_certificado" required data-parsley-type="email" placeholder="" class="form-control">
                                                        <div class="invalid-feedback">
                                                            Please provide a valid text.
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <hr>
                                            <button class="btn btn-sucess"><i class="fas fa-check"></i>&nbsp Confirmar Alteracoes</button>
                                        </form>

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
            </script>


    </body>

</html>