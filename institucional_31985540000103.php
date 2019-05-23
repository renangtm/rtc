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
                color: #023d77 !important;
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
                                                    <img src="assets/images/avatar-logc.jpg" alt="User Avatar" class="user-avatar-xxl">
                                                </div>
                                            </div>
                                            <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8 col-12">
                                                <div class="user-avatar-info">
                                                    <div class="m-b-20">
                                                        <div class="user-avatar-name">
                                                            <h2 class="mb-1">Logistic Center GRU</h2>
                                                        </div>
                                                    </div>
                                                    <!--  <div class="float-right"><a href="#" class="user-avatar-email text-secondary">www.henrybarbara.com</a></div> -->
                                                    <div class="user-avatar-address">
                                                        <p class="border-bottom pb-3">
                                                            <br>
                                                            <br>
                                                            <span class="d-xl-inline-block d-block mb-2"><i class="fa fa-map-marker-alt mr-2 text-primary " style="color: #023d77 !important;"></i>R. Antônio Mestriner, 194 - Jardim Fatima, Guarulhos - SP, 07177-220</span><br>
                                                            <span class="d-xl-inline-block d-block mb-2"><i class="fa fa-phone mr-2 text-primary " style="color: #023d77 !important;"></i>11 2484-0087</span><br>
                                                            <span class="d-xl-inline-block d-block mb-2"><i class="fa fa-envelope mr-2 text-primary " style="color: #023d77 !important;"></i>faleconosco@logc.com.br</span><br>
                                                            <span class="d-xl-inline-block d-block mb-2"><i class="fa fa-globe mr-2 text-primary " style="color: #023d77 !important;"></i><a class="link-institucional" href="http://www.logc.com.br" target="_blank">http://www.logc.com.br</a></span><br>
                                                        </p>
                                                        <div class="mt-3 col-8">
                                                            <h3>A empresa</h3>
                                                            <p style="text-align: justify;">O Logistic Center GRU nasce com a experiência de 37 anos da Agro Fauna, realizando operações de armazenagem de defensivos agrícolas (Produtos químicos classificados). Faz parte de um conglomerado de empresas que nasceram naturalmente da necessidade de se produzir serviços de melhor qualidade com custos mais baixos para toda a cadeia de parceiros que compõem o Projeto Novos Rumos.</p>
                                                            <!--<p style="text-align: justify;">Seu objetivo é de proporcionar agilidade no processo de armazenagem preservando todas as responsabilidades inerentes à logística dos produtos Químicos.</p>
                                                            <p style="text-align: justify;">Tem como Missão encontrar um ponto de equilíbrio entre o custo das operações logísticas com a realidade financeira de nossos clientes.</p>
                                                            <p style="text-align: justify;">Sua função como agente de serviços terceirizados será de estreitar os laços comerciais entre empresas, viabilizando seus empreendimentos a qualquer distância.</p>
                                                            <p style="text-align: justify;">Caracteriza-se por ser parte de um grupo empresarial composto por mais de 20.000 clientes cadastrados ao longo de 37 anos, que compõe a carteira da empresa Agro Fauna C. Insumos Ltda.</p>-->
                                                            <p style="text-align: justify;">Agora, com uma proposta de foco nas operações logísticas, o Logistic Center GRU (LCG) traz o mais alto nível de gestão e operações voltadas ao armazém, além de disponibilizar de uma grande carteira de transportadoras parceiras, que levam a todo o Brasil, com frete (custo) e prazos competitivos, os produtos expedidos pelo LCG.</p>
                                                            <!--<p style="text-align: justify;">O LCG, como integrante fundamental do Projeto Novos Rumos tem a seu lado, como braço Intelectual, a empresa Agro Fauna Tecnologia para suporte estratégico a área Tecnológica, proporcionando eficiência e rapidez nas constantes atualizações de nosso sistema ERP (RTC). Essa parceria oferece a constante modernização de nossa Inteligência Artificial.</p>-->
                                                            <!--<p style="text-align: justify;">O Logistic Center GRU surge como alternativa para operadores de diversos ramos (Transportadores, distribuidores, Fabricantes, sejam estes atuantes no Agro Negócio ou demais setores) para livrar-se de complicações de armazenagem, tornar custo fixo em custo variável (maior sustentabilidade financeira), contornar problemas de localização geográfica, etc.</p>-->
                                                            <h3>Serviços</h3>
                                                            <img src="assets/images/inst_logc_recebimento_carga.png" alt="User Avatar">
                                                            <br><br>
                                                            <p style="text-align: justify;">Esse sistema já é utilizado pela empresa Agro Fauna para químicos classificados com grande eficiência. Demais empresas do Grupo também o utilizam em outras categorias de produtos.</p>
                                                            <p style="text-align: justify;">O LCG trabalha com o recebimento de carga 100% paletizada, em padrão PBR.</p> 
                                                            <br>
                                                            <img src="assets/images/inst_logc_expedicao_de_carga.png" alt="User Avatar">
                                                            <br><br>
                                                            <p style="text-align: justify;">Para quem se utiliza do nosso RTC bastará que o operador de faturamento da empresa em questão seleciona os pedidos através de um processo de Agrupamento de Pedidos de seus clientes. Esse processo consiste na junção de tudo aquilo que foi faturado em um único formulário que originara a Nota Fiscal de Remessa de  Saída do LCG para a empresa cliente. Posteriormente nosso robô recompõe todos os pedidos dos clientes da empresa em questão e fatura todas as notas automaticamente com a permissão de nosso cliente.</p>
                                                            <br>
                                                            <img src="assets/images/inst_logc_armanezamento.png" alt="User Avatar">
                                                            <br><br>
                                                            <p style="text-align: justify;">O LCG possuí vasta experiência no armazenamento de produtos químicos com classificação de risco, uma categoria de produtos que exige de maneira peculiar do operador logístico, em relação à cautela nas movimentações, controle de validades, planos de emergência, contenção de possíveis vazamentos e destinação correta de produtos (embalagens) avariados.</p>
                                                            <p style="text-align: justify;">Dado esta experiência, o LCG é uma empresa de confiança para armazenagem de quaisquer tipos de produtos (Exceto alimentos).</p>
                                                            <p style="text-align: justify;">Controle de estoque, entrada e saída de mercadoria totalmente informatizado.</p>
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