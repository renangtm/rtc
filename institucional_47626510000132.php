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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        
        <link rel="stylesheet" href="assets/vendor/charts/chartist-bundle/chartist.css">
        <link rel="stylesheet" href="assets/vendor/charts/morris-bundle/morris.css">
        <link rel="stylesheet" href="assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="assets/vendor/charts/c3charts/c3.css">
        <link rel="stylesheet" href="assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
        <title>RTC (Reltrab Cliente) - WEB</title>
        <style>
            a.link-institucional:hover{
                color: rgb(24, 160, 73)!important;
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
                                                    <img src="assets/images/avatar-agrofauna.jpg" alt="User Avatar" class="user-avatar-xxl">
                                                </div>
                                            </div>
                                            <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8 col-12">
                                                <div class="user-avatar-info">
                                                    <div class="m-b-20">
                                                        <div class="user-avatar-name">
                                                            <h2 class="mb-1">Agro fauna Insumos (AFI)</h2>
                                                        </div>
                                                    </div>
                                                    <!--  <div class="float-right"><a href="#" class="user-avatar-email text-secondary">www.henrybarbara.com</a></div> -->
                                                    <div class="user-avatar-address">
                                                        <p class="border-bottom pb-3">
                                                            <br>
                                                            <br>
                                                            <span class="d-xl-inline-block d-block mb-2"><i class="fa fa-map-marker-alt mr-2 text-primary " style="color: rgb(24, 160, 73)!important;;"></i>R. Dr. Coutinho Cavalcante, 1171 - Jardim Alto Alegre - São José do Rio Preto - SP, 15055-300</span><br>
                                                            <span class="d-xl-inline-block d-block mb-2"><i class="fa fa-phone mr-2 text-primary " style="color: rgb(24, 160, 73)!important;;"></i>(17) 3224.1233 / (17) 98164.7582</span><br>
                                                            <span class="d-xl-inline-block d-block mb-2"><i class="fa fa-envelope mr-2 text-primary " style="color: rgb(24, 160, 73)!important;;"></i>faleconosco@agrofauna.com.br</span><br>
                                                            <span class="d-xl-inline-block d-block mb-2"><i class="fa fa-globe mr-2 text-primary " style="color: rgb(24, 160, 73)!important;;"></i><a class="link-institucional" href="http://agrofauna.com.br/" target="_blank">http://agrofauna.com.br/</a></span><br>
                                                        </p>
                                                        <div class="mt-3 col-8">
                                                            <h3>História da Agro-Fauna</h3>
                                                            <p style="text-align: justify;">Desde 1981, a Agro-Fauna tem marcado história na distribuição de defensivos agrícolas.</p>
                                                            <p style="text-align: justify;">Já há 35 anos no mercado, procuramos ser uma bandeira livre para nossa agricultura.</p>
                                                            <p style="text-align: justify;">Atendemos todo o território nacional, sempre desenvolvendo novas ferramentas para atender as necessidades dos nossos clientes.</p>
                                                            <p style="text-align: justify;">Como pioneira, fomos os primeiros a usar do telemarketing para nos comunicar com os clientes, e logo após, tivemos a 1º mala direta do agronegócio, nos tornando referência para muitas empresas e acumulando grandes parcerias duradouras ao longo dos anos.</p>
                                                            <p style="text-align: justify;">Trabalhamos sempre com honestidade, produtos de qualidade e simpatia, como a nossa maior bandeira.</p>
                                                            <br>
                                                            <h3>SOBRE A EMPRESA</h3>
                                                            <h6>MISSÃO</h6>
                                                            <p style="text-align: justify;">Contribuir com o desempenho sustentável da agricultura brasileira, com ótimos preços e produtos ecologicamente corretos.</p>
                                                            <h6>VISÃO</h6>
                                                            <p style="text-align: justify;">Estar entre as maiores distribuidoras de Defensivos Agrícolas do Brasil, sempre crescendo e proporcionando o melhor para os clientes.</p>
                                                            <h6>VALORES</h6>
                                                            <p style="text-align: justify;">Ética, Transparência, Confiança, Responsabilidade, Comprometimento, Respeito, Disciplina e Organização</p>
                                                            <br>
                                                            <h3>O QUE FAZEMOS</h3>
                                                            <h6>DISTRIBUIDORA</h6>
                                                            <p style="text-align: justify;">A Agro-Fauna atende todo território nacional, e está disposta a executar grandes parcerias, sempre visando criar ferramentas para melhor atender as necessidades e negociações com os seus clientes.</p>
                                                            <h6>PRODUTOS</h6>
                                                            <p style="text-align: justify;">Trabalhamos com todas as linhas de Defensivos Agrícolas de diversos fabricantes.</p>
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