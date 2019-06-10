<!doctype html>
<html lang="en" ng-app="appRtc">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">

        <script src="js/angular.min.js"></script>
        <script src="js/rtc.js?125"></script>
        <script src="js/filters.js?125"></script>
        <script src="js/services.js?125"></script>
        <script src="js/controllers.js?125"></script>  <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>    

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

            a.link-passoapasso:hover{
                color: #fff !important;
            }

        </style>
        <style>
            .passoapasso-carousel{}
            .passoapasso .carousel-indicators {
                position: absolute;
                right: 0;
                bottom: -80px;
                left: 0;
                z-index: 15;
                display: -ms-flexbox;
                display: flex;
                -ms-flex-pack: center;
                justify-content: center;
                padding-left: 0;
                margin-right: 15%;
                margin-left: 15%;
                list-style: none;
                bottom: -50px;
            }

            .passoapasso .carousel-indicators li {
                position: relative;
                -ms-flex: 0 1 auto;
                flex: 0 1 auto;
                width: 20px!important;
                height: 20px!important;
                margin-right: 3px;
                margin-left: 3px;
                text-indent: -999px;
                background-color: rgb(224, 224, 231);
                border-radius: 100%;

                width: 10px!important;
                height: 10px!important;
                border-radius: 50%;

            }
            .passoapasso .carousel-indicators li.active{ background-color: #13161f; }
            .passoapasso .carousel-control-next,.passoapasso .carousel-control-prev {   
                background-color: #13161f;
                width: 50px;
                height: 50px;
                background-size: 60%;
                border-radius: 10px;
                top: unset;
                bottom: 5px;
            }
            .passoapasso .carousel-control-next {
                right: 8px;
            }
            .passoapasso .carousel-control-prev {
                left: 8px;
            }
        </style>    
    </head>

    <body ng-controller="crtConsignaProduto">
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
                                    <h2 class="pageheader-title">CONTRATO DE REPRESENTAÇÃO COMERCIAL PARA VENDAS ON LINE</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Fornecedores</li>
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
                                        <!-- bem vindo ao RTC  -->
                                        <div class="row">
                                            <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8 col-12">
                                                <div style="width:100%;background-position:center top;background-size:100% auto;background-repeat: no-repeat;<?php
                                                if ($espelho) {
                                                    echo "background-image:url('assets/images/tira-adagro.jpg')";
                                                }
                                                ?>">
                                                    <div class="container">
                                                        <div class="row" style="padding: 0px;">
                                                            <div style="margin-top: 150px;padding:40px;background-color: #13161f;color:#fff;">
                                                                <h2 class="mb-1" style="text-align: center;color:#fff;">Bem vindo ao RTC</h2><br>
                                                                <p style="text-align: justify;">Você poderá ser a partir de agora ser nosso fornecedor virtual do projeto Novos Rumos (Agro fauna).</p>
                                                                <p style="text-align: justify;">Para que nossa parceria possa ser implantada será necessário estabelecer um contrato com a empresa Virtual Negócios e Servicos que representara a <?php echo $empresa->nome; ?> fazendo a intervenção de vendas on-line em todo o brasil ou nas cidades definidas no anexo contratual.</p>
                                                                <p style="text-align: justify;">Para isso leia com a atenção nosso contrato e siga o passo a passo abaixo.</p>
                                                                <!--<a class="nav-link link-passoapasso" href="https://www.rtcagro.com.br/consignar_produtos_passo_a_passo_v2.pdf" target="_blank"><i class="fa fa-fw fa-file-alt"></i>&nbsp;&nbsp;Passo a Passo - produto consignado</a>-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br><br>
                                            </div>

                                        </div>
                                        <!-- fim bem vindo -->
                                        <!-- PASSO A PASSO -->
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div style="border: 1px solid rgba(0,0,0,.1);padding:30px">
                                                    <div id="carouselExampleIndicators" class="passoapasso carousel slide" data-interval="false" data-ride="carousel" data-pause="hover" style="border: 1px solid rgba(0,0,0,.1);margin-bottom: 40px;">
                                                        <ol class="carousel-indicators">
                                                            <li data-target="#carouselExampleIndicators" data-slide-to="0" style="cursor: pointer;width: 30px!important;height: 10px!important;border-radius: 20%;" class="active"></li>
                                                            <li data-target="#carouselExampleIndicators" data-slide-to="1" style="cursor: pointer;width: 30px!important;height: 10px!important;border-radius: 20%;"></li>
                                                            <li data-target="#carouselExampleIndicators" data-slide-to="2" style="cursor: pointer;width: 30px!important;height: 10px!important;border-radius: 20%;"></li>
                                                            <li data-target="#carouselExampleIndicators" data-slide-to="3" style="cursor: pointer;width: 30px!important;height: 10px!important;border-radius: 20%;"></li>
                                                            <li data-target="#carouselExampleIndicators" data-slide-to="4" style="cursor: pointer;width: 30px!important;height: 10px!important;border-radius: 20%;"></li>
                                                            <li data-target="#carouselExampleIndicators" data-slide-to="5" style="cursor: pointer;width: 30px!important;height: 10px!important;border-radius: 20%;"></li>
                                                            <li data-target="#carouselExampleIndicators" data-slide-to="6" style="cursor: pointer;width: 30px!important;height: 10px!important;border-radius: 20%;"></li>
                                                            <li data-target="#carouselExampleIndicators" data-slide-to="7" style="cursor: pointer;width: 30px!important;height: 10px!important;border-radius: 20%;"></li>
                                                            <li data-target="#carouselExampleIndicators" data-slide-to="8" style="cursor: pointer;width: 30px!important;height: 10px!important;border-radius: 20%;"></li>
                                                        </ol>
                                                        <div class="carousel-inner">
                                                            <div class="carousel-item active">
                                                                <img class="d-block w-100" src="assets/images/passo_a_passo3/Slide1.PNG" alt="First slide">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img class="d-block w-100" src="assets/images/passo_a_passo3/Slide2.PNG" alt="Second slide">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img class="d-block w-100" src="assets/images/passo_a_passo3/Slide3.PNG" alt="Third slide">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img class="d-block w-100" src="assets/images/passo_a_passo3/Slide4.PNG" alt="Third slide">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img class="d-block w-100" src="assets/images/passo_a_passo3/Slide5.PNG" alt="Third slide">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img class="d-block w-100" src="assets/images/passo_a_passo3/Slide6.PNG" alt="Third slide">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img class="d-block w-100" src="assets/images/passo_a_passo3/Slide7.PNG" alt="Third slide">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img class="d-block w-100" src="assets/images/passo_a_passo3/Slide8.PNG" alt="Third slide">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img class="d-block w-100" src="assets/images/passo_a_passo3/Slide9.PNG" alt="Third slide">
                                                            </div>
                                                        </div>
                                                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev" style="display: flex;">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                            <span class="sr-only">Previous</span>
                                                        </a>
                                                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                            <span class="sr-only">Next</span>
                                                        </a>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>

                                        <style type="text/css">
                                            .frm td{
                                                padding:10px;
                                            }
                                            .frm{
                                                margin-left: auto;
                                                margin-right: auto;
                                            }

                                            .frm input[tpe='text']{
                                                width:300px;
                                            }


                                            .tt input[tpe='text']{
                                                width:300px;
                                            }

                                            .frm input[type='password']{
                                                width:200px;
                                            }

                                        </style>
                                        <!-- FIM PASSO A PASSO -->
                                        <!-- CONTRATO -->
                                        <div class="row" ng-if="!liberadoc">
                                            <div class="col-10">
                                                <br><br>
                                                <table class="frm" style="width: 100%;">
                                                    <tr>
                                                        <td colspan="2">
                                                            <i class="fas fa-key fa-2x" style="display: inline;margin-left:10px"></i>&nbsp
                                                            <h3 style="display: inline">Verifique seus dados e escolha um login e uma senha</h3>
                                                            <br><br>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="form-group row">
                                                                <label class="col-3 col-lg-2 col-form-label text-left">Nome</label>
                                                                <div class="col-md-5">
                                                                    <input type="text" class="form-control" ng-model="usuario.nome">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-3 col-lg-2 col-form-label text-left">Nome de Usuario</label>
                                                                <div class="col-md-5">
                                                                    <input type="text" class="form-control" ng-model="usuario.login">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-3 col-lg-2 col-form-label text-left">Senha</label>
                                                                <div class="col-md-5">
                                                                    <input type="password" class="form-control" ng-model="usuario.senha">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-3 col-lg-2 col-form-label text-left">Confirmar Senha</label>
                                                                <div class="col-md-5">
                                                                    <input type="password" class="form-control" ng-model="usuario.confirmar_senha">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-3 col-lg-2 col-form-label text-left">RG</label>
                                                                <div class="col-md-5">
                                                                   <input type="text" class="form-control" ng-model="usuario.rg.valor">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-3 col-lg-2 col-form-label text-left">CPF</label>
                                                                <div class="col-md-5">
                                                                   <input type="text" class="form-control" ng-model="usuario.cpf.valor">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td colspan="2">
                                                            <br>
                                                            <i class="fas fa-list fa-2x" style="display: inline;margin-right: 10px"></i><h3 style="display: inline">Dados da empresa</h3>
                                                            <br><br>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="tt">
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
                                                                <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">IE</label>
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
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <hr>
                                                            <button class="btn btn-success" ng-click="mergeUsuario(usuario)"><i class="fas fa-check"></i>&nbsp Confirme seus dados para prosseguir</button>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row" ng-if="liberadoc">
                                            <div class="col-md-12">
                                                <br>
                                                <hr>
                                                <br><br>
                                                <h3>Contrato de prestacao de serviço</h3>
                                                <hr>
                                                <select class="form-control" style="width:40%;display: inline;margin-right:30px" ng-model="empresa_selecionada">
                                                    <option ng-repeat="emp in virtuais" ng-value="emp">{{emp.nome}}</option>
                                                </select>
                                                <button class="btn btn-outline-light" ng-click="aceitar()" style="display: inline" ng-if="!aceitou_contrato">
                                                    <i class="fas fa-square fa-2x"></i>&nbsp
                                                    Eu li e aceito os termos desse Contrato abaixo
                                                </button>
                                                <button class="btn btn-success" style="display: inline" ng-if="aceitou_contrato" ng-click="aceitar()">
                                                    <i class="fas fa-check fa-2x"></i>&nbsp
                                                    Contrato aceito
                                                </button>
                                                <br>
                                                <div id="contrato" style="width:100%;height:600px;border:2px solid;overflow-y:scroll;padding:10px;margin:10px">
                                                    <input id="btnprint" type="button" value="Imprimir" />
                                                    <br><br>
                                                    <h2>CONTRATO DE REPRESENTAÇÃO COMERCIAL, VEICULAÇÃO DE IMAGEM E VENDA DE PRODUTOS NA INTERNET</h2>
                                                    <hr>

                                                    CONTRATANTE: <strong>{{empresa_av.nome}}</strong>,com sede em  <strong>{{empresa_av.endereco.cidade.nome}}</strong>, na Rua <strong>{{empresa_av.endereco.rua}}</strong>, nº <strong>{{empresa_av.endereco.numero}}</strong>, bairro  <strong>{{empresa_av.endereco.bairro}}</strong>, Cep  <strong>{{empresa_av.endereco.cep.valor}}</strong>, no Estado  <strong>{{empresa_av.endereco.estado}}</strong>, inscrita no C.N.P.J. sob o nº  <strong>{{empresa_av.cnpj.valor}}</strong>, e no Cadastro Estadual sob o nº  <strong>{{empresa_av.inscricao_estadual}}</strong>, neste ato representada por  Sr(a). <?php echo $usuario->nome; ?>, (Nacionalidade), (Estado Civil), (Profissão), Carteira de Identidade nº  <strong>{{usuario.rg.valor}}</strong> 
                                                    <br><br>
                                                    CONTRATADA: <strong>{{empresa_selecionada.nome}}</strong>, com sede em  <strong>{{empresa_selecionada.endereco.cidade.nome}}</strong>, na Rua <strong>{{empresa_selecionada.endereco.rua}}</strong>, nº <strong>{{empresa_selecionada.endereco.numero}}</strong>, bairro <strong>{{empresa_selecionada.endereco.bairro}}</strong>, Cep <strong>{{empresa_selecionada.endereco.cep.valor}}</strong>, no Estado <strong>{{empresa_selecionada.endereco.estado}}</strong>, inscrita no C.N.P.J. sob o nº <strong>{{empresa_selecionada.cnpj.valor}}</strong>, e no Cadastro Estadual sob o nº  <strong>{{empresa_selecionada.inscricao_estadual}}</strong> neste ato representada por Sr. Elias Tadeu de Oliveira, brasileiro, divorciado, engenheiro agrônomo, portador do CPF nº 601.254.208-97 e do RG nº 7.895.953:  
                                                    <br><br>
                                                    As partes acima identificadas têm, entre si, justo e acertado o presente Contrato de Representação Comercial, Veiculação de Imagem e Venda de Produtos na Intranet, que se regerá pelas cláusulas seguintes e pelas condições descritas no presente.
                                                    <br><br>
                                                    Ao aceitar eletronicamente ou particularmente este contrato, o CONTRATANTE estará automaticamente aceitando aos termos aqui consignados, não podendo, em hipótese alguma, arguir desconhecimento sobre os mesmos. 
                                                    <br><br>
                                                    <h3>DO OBJETO DO CONTRATO</h3>
                                                    Cláusula 1ª - O presente instrumento tem como objeto a prestação de serviços de representação comercial e venda de produtos pela internet. 
                                                    <br><br>
                                                    Cláusula 1ª.1 - A CONTRATADA se obriga a disponibilizar uma plataforma de Serviços (ERP) RTC, desenvolvida para possibilitar a comercialização de produtos diretamente pela intranet, para o Brasil ou cidades definidas no anexo contratual.
                                                    <br><br>
                                                    <h3>DAS OBRIGAÇÕES DA CONTRATADA</h3>
                                                    Cláusula 2ª - A CONTRATADA está obrigada a promover a veiculação, em sua página na intranet www.rtcagro.com.br (designar o endereço eletrônico da página), das imagens das mercadorias produzidas pela CONTRATANTE.
                                                    <br><br>
                                                    Cláusula 3ª - A CONTRATADA deverá também realizar todos os atos necessários à venda dos produtos, divulgando-os em suas diversas plataformas digitais e utilizando sua carteira de proponentes compradores, dentre outras.    
                                                    <br><br>
                                                    Cláusula 3ª.1 - Não será responsabilizada a CONTRATADA por eventuais falhas ou suspensão nos serviços da plataforma de vendas virtual ocasionados por problemas técnicos alheios à sua responsabilidade.   
                                                    <br><br>
                                                    <h3>DAS OBRIGAÇÕES DA CONTRATANTE</h3>

                                                    Cláusula 4ª - A CONTRATANTE está obrigada a manter a exclusividade da CONTRATADA para o que foi estabelecido neste contrato, não podendo contratar outra empresa que realize os mesmos serviços.
                                                    <br><br>
                                                    Cláusula 5ª - A CONTRATANTE deverá realizar a entrega dos produtos divulgados pela CONTRATADA na data previamente fixada pelas partes, responsabilizando-se pela qualidade dos mesmos perante os compradores.
                                                    <br><br>
                                                    Cláusula 5ª.1 - A CONTRATANTE deverá inserir na plataforma própria os produtos a serem comercializados, informando nome, marca, prazo de validade, preço, forma de pagamento e prazo de entrega.
                                                    <br><br>
                                                    Cláusula 5ª.2 - Cabe exclusivamente à CONTRATADA a analise e posterior liberação e aceitação dos produtos disponibilizados pela CONTRATANTE, cuja liberação poderá ser total ou parcial.
                                                    <br><br>
                                                    Cláusula 5ª.3 - Os produtos disponibilizados pela CONTRATANTE deverão obedecer o paradigma da CONTRATADA, qual seja preço baixo.
                                                    <br><br>
                                                    Cláusula 5ª.4 - A CONTRATANTE poderá estabelecer cidades ou regiões onde a comercialização dos produtos disponibilizados serão de inteira exclusividade da CONTRATADA.
                                                    <br><br>
                                                    Cláusula 6ª - Não cabe nenhuma responsabilidade à CONTRATADA pela inadimplência no pagamento dos produtos disponibilizados e comercializados através da plataforma digital oferecida a CONTRATANTE, a qual assume o risco total das operações.
                                                    <br><br>
                                                    <h3>DO PAGAMENTO</h3>

                                                    Cláusula 7ª - A CONTRATANTE deverá pagar à CONTRATADA o percentual de 2% descrito no anexo a título de comissão dos valores comercializados através da plataforma virtual de vendas, cujo valor deverá ser pago através de cobrança bancaria 
                                                    <br><br>
                                                    Cláusula 8ª - O repasse do valor obtido na venda desses produtos deve se dar em até  três dias a partir do recebimento.
                                                    <br><br>
                                                    § 1º - O atraso na remuneração ora referida, sujeitará a CONTRATANTE a suspensão dos serviços virtuais até a confirmação do pagamento. 
                                                    <br><br>
                                                    § 2º - Caso não seja cumprida a determinação referida nesta cláusula, a CONTRATADA ficará desobrigada a cumprir o que ora se avença, podendo ainda inibir a utilização disponibilizadas ao uso.
                                                    <br><br>
                                                    § 3º - Todos os parâmetros contratuais referentes aos produtos e regiões a serem comercializados estata, expostos definidos nos anexos deste contrato
                                                    <br><br>
                                                    <h3>DA RESCISÃO</h3>

                                                    Cláusula 10ª - O contrato poderá ser rescindido por ambas as partes, a qualquer momento, devendo, porém, a parte avisar à outra com 30 (trinta) dias de antecedência.   
                                                    <br><br>
                                                    Cláusula 11ª - O contrato também será rescindido caso uma das partes descumpra o estabelecido nas cláusulas do presente instrumento, a qualquer momento bastando para isso se utilizar da plataforma RTC no campo encerramento contratual, onde encontrara todas as orientacoes e observações para o procedimento.
                                                    <br><br>
                                                    <h3>DISPOSIÇÕES ESPECIAIS</h3>

                                                    Cláusula 12ª - Qualquer alteração das condições aqui ajustadas será considerada como ato de mera tolerância e liberalidade, não acarretando nem sendo considerada como novação ou alteração das mesmas, posto que tal providência só terá validade e surtirá efeitos permanentes para as Partes se forem efetivadas através de instrumento específico.   
                                                    <br><br>
                                                    § Único - A CONTRATADA se reserva o direito de fazer modificações, adições ou exclusões, no todo ou em parte, nas condições estabelecidas neste contrato, sem prejuízo para o CONTRATANTE das obrigações aqui assumidas, sendo que tal fato será comunicado ao CONTRATANTE, por aviso escrito por meios eletrônicos, especialmente via e-mail. 
                                                    <br><br>
                                                    a) Caso o CONTRATANTE não concorde com as modificações apresentadas, poderá rescindir este COMPROMISSO, observadas as condições aqui previstas. 
                                                    <br><br>
                                                    Cláusula 13ª - A CONTRATANTE arcará com o ônus financeiro dos tributos, contribuições sociais, encargos, dentre outras modalidades de impostos que porventura venham a incidir sobre o uso e destinação da plataforma de serviços RTC ora contratada, além de responder por direitos de terceiros eventualmente prejudicados.    
                                                    <br><br>
                                                    Cláusula 14ª - A CONTRATADA se exime de qualquer responsabilidade cívil, criminal ou outras, pelo uso e destinação que será dado ao objeto ora contratado, ficando a CONTRATANTE exclusivamente obrigada a responder por danos porventura causados.     
                                                    <br><br>
                                                    § Único - O CONTRATANTE concorda em proteger e isentar a CONTRATADA, ou ainda indenizar esta, suas controladoras, subsidiárias, afiliadas, administradores, acionistas, empregados e agentes, por quaisquer danos morais ou materiais sofridos de qualquer natureza.  
                                                    <br><br>
                                                    Cláusula 15ª - As partes se comprometem por si, seus funcionários e prepostos, a manter o mais absoluto sigilo sobre toda e qualquer informação, material e documentos, que venham a ter acesso por força do cumprimento do objeto deste contrato, sob pena de arcar com perdas e danos que vier a dar causa, por transgressão às disposições desta cláusula.      
                                                    <br><br>
                                                    Cláusula 16ª - A impossibilidade de prestação do serviço motivado por incorreção em informação fornecida pela CONTRATANTE ou por omissão no provimento de informação essencial à prestação, não caracterizará descumprimento de obrigação contratual pela CONTRATADA, isentando-a de toda e qualquer responsabilidade, ao tempo em que configurará o não cumprimento de obrigação por parte da CONTRATANTE.       
                                                    <br><br>
                                                    Cláusula 17ª - O CONTRATANTE neste ato declara estar ciente e de acordo que não mantém nenhum compromisso hierárquico ou trabalhista de qualquer natureza com a CONTRATADA, seja ele em relação a horário ou comparecimento a sede da mesma, não podendo alegar posteriormente qualquer vínculo empregatício.        
                                                    <br><br>
                                                    <h3>DISPOSIÇÕES GERAIS</h3>

                                                    Cláusula 18ª - Para fins de execução do serviço objeto deste contrato, o CONTRATANTE se compromete a fornecer todas as informações solicitadas pela CONTRATADA e efetuar o pagamento conforme já estipulado.         
                                                    <br><br>
                                                    Cláusula 19ª - As partes se obrigam a manter os seus dados comerciais devidamente atualizados; toda e qualquer alteração deverá ser comunicada imediatamente, uma à outra e aditadas na plataforma RTC.        
                                                    <br><br>
                                                    Cláusula 20ª - Os direitos e obrigações decorrentes deste contrato somente poderão ser cedidos, mediante aviso prévio e escrito, com expresso consentimento das partes.           
                                                    <br><br>
                                                    Cláusula 21ª - Todo contato, solicitação e chamado formal entre as partes para tratar de assuntos ligados à prestação dos serviços, se dará por HelpDesk ou e-mail, nos endereços divulgados, ou acesso às dependências de escritório sede da CONTRATANTE, no horário comercial.            
                                                    <br><br>
                                                    Cláusula 22ª - Em qualquer hipótese de terminação do presente contrato, as condições relativas à proteção de direitos autorais, garantias e responsabilidades, confidencialidade e sigilo, permanecerão íntegras, sendo que sua observância subsistirá por prazo indeterminado.            
                                                    <br><br>
                                                    <h3>DO PRAZO</h3>

                                                    Cláusula 23ª - O presente contrato terá prazo indeterminado, iniciando-se a vigência no ato de sua assinatura.                 
                                                    <br><br>
                                                    <h3>DO FORO</h3>

                                                    Cláusula 23ª - Para dirimir quaisquer controvérsias oriundas do presente contrato, as partes elegem o foro da comarca de São José do Rio Preto, São Paulo, Brasil.                 
                                                    <br><br>
                                                    Por estarem assim justos e contratados, firmam o presente instrumento, em duas vias de igual teor, juntamente com 2 (duas) testemunhas.
                                                    <br><br>
                                                    <p>São José do Rio Preto-SP, _____, __________________, 2019</p>
                                                    <br>
                                                    <p><center>__________________________ &emsp;&emsp;&emsp;&emsp; _________________________</center></p>
                                                    <p><center>CONTRATADA({{empresa_av.nome}}) &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; CONTRATANTE({{empresa.nome}})</center>
                                                    <br><br>
                                                    <p align="justify"><center>Testemunhas 1:&nbsp;&nbsp;____________________  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Testemunha 2:&nbsp;&nbsp;_____________________  </center> </p>
                                                    <br><br>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <i class="fas fa" style="display: inline"></i>&nbsp<h3 style="display: inline">Locais de venda do produto</h3>
                                                                <hr>
                                        <div style="width:100%;border:2px solid;padding:20px;border-radius: 3px">

                                            <div style="display:block"><button class="btn btn-primary" ng-click="selecionarPais()"><i style="display: inline" class="fas fa-certificate"></i></button>&nbsp<h3 style="display: inline">Brasil</h3></div>
                                            <hr>
                                                            
                                                                <div ng-repeat="r in regioes" style="width:calc(26% - 120px);font-size:14px;max-height: 300px;border:1px dashed;overflow-y: scroll;padding:20px;margin-top:20px;margin-left:20px;display: inline-block;">
                                                                     <button class="btn btn-primary" style="float:left" ng-click="selecionarTudo(r)"><i class="fas fa-certificate"></i></button>&nbsp<h4 style="display: inline">{{r.nome}}</h4>
                                                                    <br>
                                                                    <input style="margin-top:20px" type="text" ng-model="r.filtro" placeholder="Filtro cidade" ng-change="filtro(r)" class="form-control">
                                                                    <hr>
                                                                    <strong ng-if="c.aparecer" ng-click="selecionar(c)" ng-repeat="c in r.cidades" style="display: block;cursor:pointer;{{c.selecionada?'color:Green;font-weight: bold;text-decoration: underline;':'color:Black'}}">
                                                                       <i class="fas fa-square" style="display: inline"></i> &nbsp {{c.cidade.nome}} - {{c.cidade.estado.sigla}}
                                                                    </strong>
                                                                </div>

                                         </div>                   
                                        <hr>
                                        <!-- FIM CONTRATO -->
                                        <div class="table-responsive" style="overflow: hidden" ng-if="liberadoc">
                                            <br>
                                            <hr>
                                            <br><br>
                                            <div class="row">
                                                <div class="col-md-5" style="border-right: 1px solid #e6e6f2;padding-right: 45px;">
                                                    <i class="fas fa-box" style="display: inline"></i>&nbsp <h4 style="display: inline">Seus produtos ja cadastrados</h4>
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
                                                    <hr>

                                                </div>
                                                <div class="col-md-6" style="padding-left: 45px;">
                                                    <i class="fas fa-truck" style="display: inline"></i>&nbsp <h4 style="display: inline">Produto para consignar</h4>
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
                                                            <td colspan="2" style="text-align:center">
                                                                <img src="{{produto_av.imagem}}" style="max-height:200px">
                                                                <hr>
                                                                <input type="file" multiple="true" style="visibility:hidden" id="flImg">
                                                                <button ng-disabled="travado_av" class="btn btn-success" onclick="$('#flImg').click()"><i class="fas fa-upload"></i>&nbspColocar imagem</button>
                                                            </td> 
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Nome:
                                                            </td>
                                                            <td style="position:relative">
                                                                <input ng-change="atualizarPossibilidades()" ng-disabled="travado_av" type="text" placeholder="Nome do produto" class="form-control" style="width:100%" ng-model="produto_av.nome">
                                                                <div ng-if="produtos_possiveis_av.length > 0 && !travado_av" style="width:100%;top:40px;background-color:#FAFAFA;border:3px solid SteelBlue">
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
                                                                Preço de Custo (R$):
                                                            </td>
                                                            <td>
                                                                <input type="number" placeholder="Custo Medio" class="form-control" style="width:40%" ng-model="produto_av.custo">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Preço de Venda (R$):
                                                            </td>
                                                            <td>
                                                                <input type="number" placeholder="Valor de venda" class="form-control" style="width:40%" ng-model="produto_av.valor_base">
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
                                                                Estoque:
                                                            </td>
                                                            <td>
                                                                <input type="number" placeholder="Estoque" class="form-control" style="width:40%" ng-model="produto_av.estoque" ng-change="produto_av.disponivel = produto_av.estoque">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <hr>
                                                    <button class="btn btn-success" ng-disabled="!liberado()" ng-click="finalizar()">
                                                        <i class="fas fa-truck"></i>
                                                        &nbsp;
                                                        {{(!liberado()) ? "Digite as informacoes corretamente para consignar" : "Consignar produto"}}
                                                    </button>
                                                    <br>
                                                    <strong style="color:#FF0000;font-size:13px">Ao clicar no botao acima, você esta aceitando os termos do contrato.</strong>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <br>
                                                    <hr>
                                                    <br>
                                                    <i class="fas fa-plus-circle" style="display:inline"></i>&nbsp<h4 style="display: inline">Anexo contratual de representação comercial para venda de produtos entre as partes (<strong>{{empresa_selecionada.nome}}</strong> e <?php echo $empresa->nome; ?>)</h4> 
                                                    <br>
                                                    <br>
                                                    <table class="table table-striped table-bordered first">
                                                        <thead>
                                                        <th data-ordem="produto.codigo">Cod.</th>
                                                        <th data-ordem="produto.nome">Produto</th>
                                                        <th data-ordem="produto.nome">Preço de Custo (R$)</th>
                                                        <th data-ordem="produto.nome">Preço de Venda (R$)</th>
                                                        <th data-ordem="produto.nome">Estoque</th>
                                                        <th><i class="fas fa-trash"></i></th>
                                                        </thead>
                                                        <tr ng-repeat="produt in produtos_consignados.elementos">
                                                            <th>{{produt[0].codigo}}</th>
                                                            <th>{{produt[0].nome}}</th>
                                                            <th>{{produt[0].custo}}</th>
                                                            <th>{{produt[0].valor_base}}</th>
                                                            <th>{{produt[0].estoque}}</th>
                                                            <th><button class="btn btn-danger" ng-click="deconsignar(produt[0])"><i class="fas fa-trash"></i></button></th>
                                                        </tr>
                                                    </table>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                                        <nav aria-label="Page navigation example">
                                                            <ul class="pagination justify-content-end">
                                                                <li class="page-item" ng-click="produtos_consignados.prev()"><a class="page-link" href="">Anterior</a></li>
                                                                <li class="page-item" ng-repeat="pg in produtos_consignados.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></li>
                                                                <li class="page-item" ng-click="produtos_consignados.next()"><a class="page-link" href="">Próximo</a></li>
                                                            </ul>
                                                        </nav>
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

                <!-- /.modal-content ADD --> 

                <!-- /.modal-content -->

                <!-- /.modal-content EDIT --> 

                <!-- /.modal-content --> 				



                <!-- /.modal-content DELETE --> 
                <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-trash-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Delete os dados de seu Fornecedor</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center"> Tem certeza de que deseja excluir este Fornecedor?</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" ng-click="deleteFornecedor(fornecedor)">Sim</button>
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
                                            document.getElementById('btnprint').onclick = function () {
                                                var conteudo = document.getElementById('contrato').innerHTML,
                                                        tela_impressao = window.open('about:blank');

                                                tela_impressao.document.write(conteudo);
                                                tela_impressao.window.print();
                                                tela_impressao.window.close();
                                            };
                </script>
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