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
                                                    <img src="assets/images/avatar-virtual.jpg" alt="User Avatar" class="user-avatar-xxl">
                                                </div>
                                            </div>
                                            <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8 col-12">
                                                <div class="user-avatar-info">
                                                    <div class="m-b-20">
                                                        <div class="user-avatar-name">
                                                            <h2 class="mb-1">Virtual Negócios e Serviços</h2>
                                                        </div>
                                                    </div>
                                                    <!--  <div class="float-right"><a href="#" class="user-avatar-email text-secondary">www.henrybarbara.com</a></div> -->
                                                    <div class="user-avatar-address">
                                                        <p class="border-bottom pb-3">
                                                            <br>
                                                            <br>
                                                            <span class="d-xl-inline-block d-block mb-2"><i class="fa fa-map-marker-alt mr-2 text-primary " style="color: #0071bc !important;"></i>R. Antônio Mestriner, 194 - Jardim Fatima, Guarulhos - SP, 07177-220</span><br>
                                                            <span class="d-xl-inline-block d-block mb-2"><i class="fa fa-phone mr-2 text-primary " style="color: #0071bc !important;"></i>(11) 2480-5302</span><br>
                                                            <!--
                                                            <span class="d-xl-inline-block d-block mb-2"><i class="fa fa-envelope mr-2 text-primary " style="color: #023d77 !important;"></i>faleconosco@logc.com.br</span><br>
                                                            <span class="d-xl-inline-block d-block mb-2"><i class="fa fa-globe mr-2 text-primary " style="color: #023d77 !important;"></i><a class="link-institucional" href="http://www.logc.com.br" target="_blank">http://www.logc.com.br</a></span><br>
                                                            -->
                                                        </p>
                                                        <div class="mt-3 col-8">
                                                            <p style="text-align: justify;">Agência que presta assistência ao uso do aplicativo RTC em todo Brasil, possibilitando o fechamento mais adequado de qualquer negócio envolvendo as empresas que fazem parte direta ou indiretamente desses serviços.</p>
                                                            <br>
                                                            <h3>Quem Somos</h3>
                                                            <p style="text-align: justify;">A Virtual é uma empresa moderna. Criada para superar todas as dificuldades do novo mundo dos aplicativos.</p>
                                                            <p style="text-align: justify;">A Virtual não vende nada, estará o tempo todo ao seu lado, buscando os melhores serviços para orienta-lo sobre como usar em seus negócios. Nosso objetivo é de fortalecer as parcerias oferecidas em nosso macro aplicativo chamado RTC que é o elo entre as empresas do Projeto Novos Rumos.</p>
                                                            <p style="text-align: justify;">A Virtual é a ponte entre todas as empresas que compõe o Projeto Novos Rumos levando a assistência em tempo integral a todos os nossos usuários.</p>

                                                            <br><br>
                                                            <img src="assets/images/rtc_institucional_virtual_modulo_zero.png" alt="User Avatar">
                                                            <br><br>
                                                            <h3>Módulo Zero (0) do RTC</h3>
                                                            <p style="text-align: justify;">No módulo Zero (0) do RTC a Virtual sai em busca de Parcerias Externas que irão compor com todas as empresas da comunidade Novos Rumos um grande cenário de negócios dos mais variados seguimentos do mercado mundial.</p>
                                                            <p style="text-align: justify;">Através de contratos de Representação Comercial a Virtual Negócios e Serviços estará abrindo através de um relacionamento virtual contratos onde todos os fornecedores se comprometam a interagir com nosso Paradigma no tocante à Preços Baixos.</p> 
                                                            
                                                            <br><br>
                                                            <img src="assets/images/rtc_institucional_virtual_modulo_um.png" alt="User Avatar">
                                                            <br><br>
                                                            <h3>Módulo Um (1) do RTC</h3>
                                                            <p style="text-align: justify;">No módulo Um (1) do RTC a Virtual orienta sobre as campanhas do Agronegócio através da empresas que constituem o conjunto de serviços oferecidos pela Agro fauna e todas suas coligadas, onde diariamente são oferecidos produtos que em muitas ocasiões são abaixo do preço fábrica.</p>
                                                            <p style="text-align: justify;">Ainda no módulo 1 a Virtual contando com toda sua equipe de Assistentes Virtuais para dar suporte aos primeiros passos em nosso RTC (ERP), oferecendo orientações sobre como.Comprar em nosso Serviço de Compras Parceiro, como encomendar um produto diretamente com os Compradores do Projeto Novos Rumos e ainda como cadastrar seus Produtos, Clientes, Fornecedores e Transportadoras.</p> 
                                                            
                                                            <br><br>
                                                            <img src="assets/images/rtc_institucional_virtual_modulo_dois.png" alt="User Avatar">
                                                            <br><br>
                                                            <h3>Módulo Dois(2) do RTC</h3>
                                                            <p style="text-align: justify;">No módulo Dois (2) o Logistic Center Gru (LCG) se apresenta como mais um aliado dos seus negócios nos Transportes e Armazenagem. Esse serviço chega até nossos clientes pela Virtual através de seus Assistentes Virtuais que estão habilitados para fazer seu cadastramento junto às suas transportadoras e demais existentes em sua cidade. Dessa forma os clientes do Módulo dois além de poderem montar seus pedidos com identificação de sua empresa, também terão destaque em seus pedidos o preço inicial, frete, icms, custo financeiro e preço final.</p>
                                                            <p style="text-align: justify;">O melhor do Módulo 2 é que até o final do ano é inteiramente grátis, e nossos clientes terão seus pedidos iguaizinhos aos da Agro Fauna! Para isso, é necessário um contrato com o Logistc Center onde você o autoriza a buscar em seu nome as tabelas de preço de frete com as transportadoras de sua cidade. Fretes partindo de qualquer outra cidade do Brasil poderão ser usadas tabelas do Logistic Center.</p> 
                                                            
                                                            <br><br>
                                                            <img src="assets/images/rtc_institucional_virtual_modulo_tres.png" alt="User Avatar">
                                                            <br><br>
                                                            <h3>Módulo Três (3) do RTC</h3>
                                                            <p style="text-align: justify;">A Virtual também leva você ao módulo 3 de seu RTC. Nele você poderá adquirir sua identidade virtual que será desenvolvida em seu RTC pela empresa coligado do Projeto Novos Rumos, a Digital Marketing Assessoria.</p>
                                                            <p style="text-align: justify;">Um novo grupo de Assistentes Virtuais, dessa vez ligados às estratégias do Marketing Digital estarão ao seu lado para criar ou apresentar alterações em seu conteúdo de logomarcas, assinaturas digitais, banners promocionais, cartão de visitas, home page e até mesmo uma loja virtual onde você poderá ingressar nos negócios virtuais do planeta.</p> 
                                                            <p style="text-align: justify;">O melhor do módulo 3 é que você poderá usar todos os produtos de todas as empresas do grupo Novos Rumos como se fossem seus, bastando para isso adicionar a margem de lucro que você deseja. Informaremos o prazo médio de entrega e o custo de frete de uma de nossas unidades até seu cliente ou até você.</p> 
                                                            <p style="text-align: justify;">No módulo (3) sua empresa poderá contar com um botão Compra Parceiros para vender seus e nossos produtos internamente, cadastrando seus vendedores e oferecendo a possibilidade deles visualizarem todos os seus e nossos produtos, com o preço que desejar, da mesma forma como você enxerga quando acessa a Agro Fauna.</p> 
                                                            <p style="text-align: justify;">Poderá também encomendar uma loja Virtual com o seu nome, onde estaremos gerenciando todo seu conteúdo e fazendo suas propagandas diretamente a seus clientes cadastrados no seu RTC, apenas com produtos diferentes de Pesticidas. (Proibido na comercialização Virtual). Nela você também conta com todos os produtos vendidos no Projeto Novos Rumos como se fossem seus. E ainda recebe tudo via boleto bancário de seus clientes. </p> 
                                                            
                                                            <br><br>
                                                            <img src="assets/images/rtc_institucional_virtual_modulo_quatro.png" alt="User Avatar">
                                                            <br><br>
                                                            <h3>Módulo Quatro (4) do RTC</h3>
                                                            <p style="text-align: justify;">No módulo Quatro (4) a empresa Novos Rumos Administração oferece a você a oportunidade de mudar o controle administrativo de sua empresa para uma plataforma moderna e inteligente. Novamente a Virtual com seus novos Assistentes, desta vez especializados na área contábil estarão prestando todo suporte necessário para sua implantação.</p>
                                                            <p style="text-align: justify;">Neste módulo você recebe seus pedidos originados do módulo 3 ou de seu sistema, e faz um adequado controle de estoque. Oferece a possibilidade de fazer seu faturamento automático (caso queira), bastando liberar esse acesso. Cria automáticamente suas contas a receber. Oferece a oportunidade de fazer o rastreamento de tudo que foi faturado para sua empresa através de um sistema de consulta de notas de entradas e CTEs no Sefaz de seu estado criando suas contas a pagar automático.</p> 
                                                            <p style="text-align: justify;">O módulo quatro também oferece a oportunidade de criar seu inventario físico de estoque contábil diário, completo levando em conta todas as suas compras do estoque, criando um custo médio através de média ponderada,lança o valor do icms dos produtos tributados usando o mesmo sistema de média ponderada.</p> 
                                                            <p style="text-align: justify;">No módulo quatro você também terá a oportunidade de comprar uma análise de crédito com seus pontos ou cliques, ou ainda por um preço irrelevante, onde são analisados diversos parâmetros sobre a capacidade financeira de seu cliente.</p> 
              
                                                            <p></p>
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