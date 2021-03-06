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
        <style>
            a.link-institucional:hover{
                color: #75d06f !important;
            }
        </style>


    </head>

    <body>
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
                                    <h2 class="pageheader-title">Página Institucional</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item" aria-current="page">RTC</li>
                                                <li class="breadcrumb-item active" aria-current="page">Página Institucional</li>
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
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card influencer-profile-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="text-center" style="margin-top: 20px;">
                                                    <img src="assets/images/avatar-agftec.jpg" alt="User Avatar" class="user-avatar-xxl">
                                                </div>
                                            </div>
                                            <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8 col-12">
                                                <div class="user-avatar-info">
                                                    <div class="m-b-20">
                                                        <div class="user-avatar-name">
                                                            <h2 class="mb-1">Agro Fauna Tecnologia</h2>
                                                        </div>
                                                    </div>
                                                    <!--  <div class="float-right"><a href="#" class="user-avatar-email text-secondary">www.henrybarbara.com</a></div> -->
                                                    <div class="user-avatar-address">
                                                        <p class="border-bottom pb-3">
                                                            <br>
                                                            <br>
                                                            <span class="d-xl-inline-block d-block mb-2"><i class="fa fa-map-marker-alt mr-2 text-primary " style="color: #75d06f !important;"></i>R. Antônio Mestriner, 194 - Jardim Fatima, Guarulhos - SP, 07177-220</span><br>
                                                            <!--
                                                            <span class="d-xl-inline-block d-block mb-2"><i class="fa fa-phone mr-2 text-primary " style="color: #75d06f !important;"></i></span><br>
                                                            <span class="d-xl-inline-block d-block mb-2"><i class="fa fa-envelope mr-2 text-primary " style="color: #75d06f !important;"></i></span><br>
                                                            <span class="d-xl-inline-block d-block mb-2"><i class="fa fa-globe mr-2 text-primary " style="color: #75d06f !important;"></i><a class="link-institucional" href="http://agrofauna.com.br/" target="_blank">http://agrofauna.com.br/</a></span><br>
                                                            -->
                                                        </p>
                                                        <div class="mt-3 col-8">
                                                            <h3>A empresa</h3>
                                                            <p style="text-align: justify;">A Agro Fauna Tecnologia é uma empresa nova, que nasceu do departamento de TI da Agro Fauna Insumos. Ela é a responsável pela construção e localização de nosso RTC (Reltrab Cliente).</p>
                                                            <p style="text-align: justify;">Em 1987, a Agro Fauna Insumos adquiri o primeiro computador. Momentos depois, conseguimos emitir nossa primeira nota fiscal e, em seguida, foi criado o relatório de contas a pagar e a receber. A partir daí, nossos programadores criaram a nomenclatura de Reltrab, e não imaginávamos que estávamos criando um Enterprise Resource Planning (ERP).</p>
                                                            <p style="text-align: justify;">Nesses 28 anos de atividades intensas, em nosso T.I, construímos grandes ferramentas de trabalho que fizeram a nossa história. Oportunamente, estaremos abrindo, gradativamente, em pequenos pacotes de serviços, essas ferramentas que, certamente, farão a diferença para muitos parceiros que, eventualmente, ainda não as possuam.</p>
                                                            <p style="text-align: justify;">Nosso diferencial em relação aos concorrentes são:</p>
                                                            <ul>
                                                                <li>prestação de serviço com custo muito baixo.</li>
                                                                <li>uma grande gama de serviços oferecidos.</li>
                                                                <li>fazemos modificação do software de acordo com o cliente.</li>
                                                                <li>nossa meta é aumentar seu faturamento.</li>
                                                            </ul>
                                                            <br>
                                                            <h3>Missão e Visão</h3>
                                                            <p style="text-align: justify;">“Prover soluções de software com flexibilidade, agilidade, excelência e exclusividade para o setor do agronegócio.”</p>
                                                            <p></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
    </body>

</html>