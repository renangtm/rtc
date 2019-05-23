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
                                                    <img src="assets/images/avatar-help.jpg" alt="User Avatar" class="user-avatar-xxl">
                                                </div>
                                            </div>
                                            <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8 col-12">
                                                <div class="user-avatar-info">
                                                    <div class="m-b-20">
                                                        <div class="user-avatar-name">
                                                            <h2 class="mb-1">Help Manutenção Predial e Serviços</h2>
                                                        </div>
                                                    </div>
                                                    <!--  <div class="float-right"><a href="#" class="user-avatar-email text-secondary">www.henrybarbara.com</a></div> -->
                                                    <div class="user-avatar-address">
                                                        <p class="border-bottom pb-3">
                                                            <br>
                                                            <br>
                                                            <span class="d-xl-inline-block d-block mb-2"><i class="fa fa-map-marker-alt mr-2 text-primary " style="color: #3d405c !important;"></i>R. Antônio Mestriner, 194 - Jardim Fatima, Guarulhos - SP, 07177-220</span><br>
                                                            <!--
                                                            <span class="d-xl-inline-block d-block mb-2"><i class="fa fa-phone mr-2 text-primary " style="color: #3d405c !important;"></i></span><br>
                                                            <span class="d-xl-inline-block d-block mb-2"><i class="fa fa-envelope mr-2 text-primary " style="color: #3d405c !important;"></i></span><br>
                                                            <span class="d-xl-inline-block d-block mb-2"><i class="fa fa-globe mr-2 text-primary " style="color: #3d405c !important;"></i><a href="http://agrofauna.com.br/" target="_blank">http://agrofauna.com.br/</a></span><br>
                                                            -->
                                                            </p>
                                                        <div class="mt-3 col-8">
                                                            <h3>Motivação e Conceito</h3>
                                                            <p style="text-align: justify;">O desejo de atribuir atividades especificas ao Projeto Novos Rumos e seu Conceito fundamental de Preços Baixos fez com que surgisse a empresa Help visando o mercado de Serviços e Comercio via Leilões.</p>
                                                            
                                                            <br>
                                                            <h3>Definição</h3>
                                                            <p style="text-align: justify;">Define-se como comerciante, reformadora de usados, prestadora de serviços braçais de reparos e consertos praticados em empreendimentos comerciais e residenciais.</p>
                                                            
                                                            <h3>Objetivo</h3>
                                                            <p style="text-align: justify;">Oferecer serviços baratos às empresas irmãs e preços muito baixos de usados reformados ou não.</p>
                                       
                                                            <h3>Missão</h3>
                                                            <p style="text-align: justify;">Alocar  pessoas qualificadas ou não nos serviços pertinentes à sua capacidade. Acreditar que é possível aumentar a vida útil de produtos comercializando ou fazendo descartes adequados.</p>
                                       
                                                             <h3>Valores</h3>
                                                            <p style="text-align: justify;">Disciplina, Organização, Pontualidade e Respeito aos conceitos de cada profissão.</p>
                                                            <br>
                                                             <h3>Novos Rumos e Help</h3>
                                                            <p style="text-align: justify;">A Help tornou-se necessária a medida que se prospectava Preços Baixos com dimensões universais de utilidade fazendo-se valer a premissa que em qualquer lugar pode existir produtos com elevado potencial de vida útil em descarte inoportuno.</p>
                                                            <p style="text-align: justify;">Os Leilões foram os principais eventos que ofereceram destaque à criação de um Comercio de Usados Virtual dentro do Projeto Novos Rumos. Muito embora  também mostram-se  hostis, originando descartes que certamente voltarão aos Leilões.</p>
                                                            <p style="text-align: justify;">Outra motivação relaciona-se ao alto custo dos serviços de manutenção ocasionados nas demandas de ultima hora em qualquer empresa. Sem contar  as ocasiões onde mesmo com alto custo esse profissional não é encontrado por uma empresa de outra área.</p>
                                                            <p style="text-align: justify;">Sua composição deve ser dividida em diversos setores de atividades onde o comercio e os serviços dirigidos a ele merecem o mesmo tratamento que receberia um cliente comum, levando-se em conta que sua aquisição num custo irrelevante dará a oportunidade aos profissionais dos reparos operacionalizá-los  de forma apropriada para se oferecer uma garantia que o mercado convencional não oferece.</p>
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