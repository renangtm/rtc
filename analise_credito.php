<html lang="en" ng-app="appRtc">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">

        <script src="js/angular.min.js"></script>
        <script src="js/rtc.js?2"></script>

        <script>

<?php
if (!isset($_GET['cliente']) || !isset($_GET['empresa'])) {

    exit;
}

$id_cliente = $_GET['cliente'];
$id_empresa = $_GET['empresa'];

$id_pedido = 0;
if (isset($_GET['pedido'])) {
    $id_pedido = $_GET['pedido'];
}
?>

            rtc.id_cliente = <?php echo $id_cliente; ?>;
            rtc.id_empresa = <?php echo $id_empresa; ?>;
            rtc.id_pedido = <?php echo $id_pedido; ?>;

        </script>

        <script src="js/filters.js?2"></script>
        <script src="js/services.js?2"></script>
        <script src="js/controllers.js?2"></script>    

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

    <body ng-controller="crtAnaliseCredito">
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
                                    <h2 class="pageheader-title">Analise de credito do cliente {{cliente.razao_social}} por '<?php echo $usuario->nome; ?>'</h2>

                                    <button class="btn btn-primary" style="float:right" ng-disabled="!podeFinalizar()" ng-click="finalizarAnalise()">
                                        <i class="fas fa-save"></i> &nbsp; Finalizar analise
                                    </button>
                                    <hr>

                                    <div class="modal-body">

                                        <h3>Ultimos 12 mêses de faturamento:</h3>
                                        <hr>
                                        <div id="seisMesesFaturamentoReal">
                                            <input class="form-control" style="width:20%;margin-left:5px;display:inline-block;margin-bottom:5px" type="number" ng-model="meses_faturamento.mes1" placeholder="1º mes">
                                            <input class="form-control" style="width:20%;margin-left:5px;display:inline-block;margin-bottom:5px" type="number" ng-model="meses_faturamento.mes2" placeholder="2º mes">
                                            <input class="form-control" style="width:20%;margin-left:5px;display:inline-block;margin-bottom:5px" type="number" ng-model="meses_faturamento.mes3" placeholder="3º mes">
                                            <input class="form-control" style="width:20%;margin-left:5px;display:inline-block;margin-bottom:5px" type="number" ng-model="meses_faturamento.mes4" placeholder="4º mes">
                                            <input class="form-control" style="width:20%;margin-left:5px;display:inline-block;margin-bottom:5px" type="number" ng-model="meses_faturamento.mes5" placeholder="5º mes">
                                            <input class="form-control" style="width:20%;margin-left:5px;display:inline-block;margin-bottom:5px" type="number" ng-model="meses_faturamento.mes6" placeholder="6º mes">
                                            <input class="form-control" style="width:20%;margin-left:5px;display:inline-block;margin-bottom:5px" type="number" ng-model="meses_faturamento.mes7" placeholder="7º mes">
                                            <input class="form-control" style="width:20%;margin-left:5px;display:inline-block;margin-bottom:5px" type="number" ng-model="meses_faturamento.mes8" placeholder="8º mes">
                                            <input class="form-control" style="width:20%;margin-left:5px;display:inline-block;margin-bottom:5px" type="number" ng-model="meses_faturamento.mes9" placeholder="9º mes">
                                            <input class="form-control" style="width:20%;margin-left:5px;display:inline-block;margin-bottom:5px" type="number" ng-model="meses_faturamento.mes10" placeholder="10º mes">
                                            <input class="form-control" style="width:20%;margin-left:5px;display:inline-block;margin-bottom:5px" type="number" ng-model="meses_faturamento.mes11" placeholder="11º mes">
                                            <input class="form-control" style="width:20%;margin-left:5px;display:inline-block;margin-bottom:5px" type="number" ng-model="meses_faturamento.mes12" placeholder="12º mes">
                                        </div>
                                        <br>
                                        Faturamento Anual: R$ {{faturamento_anual;}}

                                        <br>

                                        <h3>Analise de Balanço</h3>
                                        <hr>

                                        <div class="form-group input-group">
                                            <span class="input-group-addon" style="margin-right:10px">Ativo</span>
                                            <input type="number" ng-model="ativo" class="form-control" id="txtAtivo">
                                        </div>
                                        <br>
                                        <div class="form-group input-group" style="margin-left:50px">
                                            <span class="input-group-addon" style="margin-right:10px">Circulante</span>
                                            <input type="number" ng-model="circulante" class="form-control" id="txtCirculante">
                                        </div>
                                        <br>

                                        <h3>Passivo</h3>

                                        <br>
                                        <div class="form-group input-group" style="margin-left:50px">
                                            <span class="input-group-addon" style="margin-right:10px">Circulante</span>
                                            <input type="number" ng-model="m" class="form-control" id="txtM">
                                        </div>
                                        <br>
                                        <div class="form-group input-group" style="margin-left:50px">
                                            <span class="input-group-addon" style="margin-right:10px">Dividas a Longo prazo a vencer</span>
                                            <input type="number" ng-model="exigivelLongoPrazo" class="form-control">
                                        </div>
                                        <br>

                                        Endividamento Geral (EG%): {{endividamentoGeral}}
                                        <br>
                                        Composicao do Endividamento (CE%): {{composicaoEndividamento}}



                                        <h3>Receitas, Despesas e Resultado</h3>

                                        <br>

                                        <div class="form-group input-group">
                                            <span class="input-group-addon" style="margin-right:10px">Receita líquida</span>
                                            <input type="number" ng-model="ac" class="form-control" id="txtAC">
                                        </div>
                                        <br>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon" style="margin-right:10px">Resultado operacional bruto</span>
                                            <input type="number" ng-model="ae" class="form-control" id="txtAE">
                                        </div>
                                        <br>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon" style="margin-right:10px">despesas financeiras líquidas</span>
                                            <input type="number" ng-model="ag" class="form-control" id="txtAG">
                                        </div>

                                        <br>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon" style="margin-right:10px">resultado antes do IR</span>
                                            <input type="number" ng-model="aj" class="form-control" id="txtAJ">
                                        </div>
                                        <br>
                                        <div class="form-group input-group" style="margin-left:10px">
                                            <span class="input-group-addon" style="margin-right:10px">Resultado líquido</span>
                                            <input type="number" ng-model="al" class="form-control" id="txtAL">
                                        </div>
                                        <br>

                                        Índice de Cobertura de Juros (ICJ%): {{indiceCoberturaJuros}}
                                        <br>
                                        Retorno sobre as Vendas (RSV%) : {{retornoSobreVendas}}
                                        <br>
                                        Margem Bruta (MB%) : {{margemBruta}}

                                        <h3>Garantias Secundarias</h3>
                                        <hr>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon" style="margin-right:10px">CARTA DE FIANÇA</span>
                                            <input type="number" ng-model="cartaFianca" class="form-control" id="txtCartaFianca">
                                        </div>
                                        <br>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon" style="margin-right:10px">PATRIMONIO DECLARADO NO IMPOSTO DE RENDA</span>
                                            <input type="number" ng-model="impostoRenda" class="form-control" id="txtImpostoRenda">
                                        </div>
                                        <br>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon" style="margin-right:10px">ESTOQUE CONSIGNADO</span>
                                            <input type="number" ng-model="estoqueConsignado" class="form-control" id="txtEstoqueConsignado">
                                        </div>
                                        <br>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon" style="margin-right:10px">VALOR HIPOTECA</span>
                                            <input type="number" ng-model="hipoteca" class="form-control" id="txtHipoteca">
                                        </div>
                                        <br>

                                        <h3>Histórico de Estabilidade Financeira da Empresa</h3>
                                        <hr>
                                        Possui empreendimento comercial em outro segmento ?
                                        <br>
                                        <input type="checkbox" ng-model="epo" ng-true-value="false" ng-false-value="true">Nao<br>
                                        <input type="checkbox" ng-model="epo" ng-true-value="true" ng-false-value="false"> Sim<br>
                                        <br>
                                        Tem relacionamento de distribuição com empresas de grande porte ?
                                        <br>
                                        <input type="checkbox" ng-model="rde" ng-true-value="false" ng-false-value="true">Nao<br>
                                        <input type="checkbox" ng-model="rde" ng-true-value="true" ng-false-value="false"> Sim<br>
                                        <br>
                                        Tem alguma linha de financiamento bancario com custo de mercado ou abaixo ?
                                        <br>
                                        <input type="checkbox" ng-model="fb" ng-true-value="false" ng-false-value="true">Nao<br>
                                        <input type="checkbox" ng-model="fb" ng-true-value="true" ng-false-value="false"> Sim<br>
                                        <br>
                                        <h3>Histórico de estabilidade financeira dos socios (para o Vendedor)</h3>
                                        <hr>
                                        Tem participação de Capital e outras Empresas?
                                        <br>
                                        <input type="checkbox" ng-model="pco" ng-true-value="false" ng-false-value="true" >Nao<br>
                                        <input type="checkbox" ng-model="pco" ng-true-value="true" ng-false-value="false"> Sim<br>
                                        <br>
                                        Tem relacionamento comercial ou tecnico com algum empreendimento em seguimento diferente?
                                        <br>
                                        <input type="checkbox" ng-model="rco" ng-true-value="false" ng-false-value="true">Nao<br>
                                        <input type="checkbox" ng-model="rco" ng-true-value="true" ng-false-value="false"> Sim<br>
                                        <br>
                                        Participa de algum colegiado Comercial ou Social?
                                        <br>
                                        <input type="checkbox" ng-model="ccs" ng-true-value="false" ng-false-value="true">Nao<br>
                                        <input type="checkbox" ng-model="ccs" ng-true-value="true" ng-false-value="false"> Sim<br>
                                        <br>
                                        Tem possibilidade de suceder algum patrimonio familiar ou convencional de herança?
                                        <br>
                                        <input type="checkbox" ng-model="her" ng-true-value="false" ng-false-value="true">Nao<br>
                                        <input type="checkbox" ng-model="her" ng-true-value="true" ng-false-value="false"> Sim<br>
                                        <br>
                                        <h3>Capacidade de Percepção de Oportunidades dos Sócios</h3>
                                        <hr>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon" style="margin-right:10px">QUANTOS ANOS NO RAMO ATUAL</span>
                                            <input type="number" ng-model="tempoRamoAtual" class="form-control">
                                        </div>
                                        <br>
                                        Tem perfil empreendedor com capacidade de evolução?
                                        <br>
                                        <input type="checkbox" ng-model="pee" ng-true-value="false" ng-false-value="true">Nao<br>
                                        <input type="checkbox" ng-model="pee" ng-true-value="true" ng-false-value="false"> Sim<br>
                                        <br>
                                        Acredita que o seu negocio pode evoluir ?
                                        <br>
                                        <input type="checkbox" ng-model="ane" ng-true-value="false" ng-false-value="true">Nao<br>
                                        <input type="checkbox" ng-model="ane" ng-true-value="true" ng-false-value="false"> Sim<br>
                                        <br>
                                        Tem objetivos e claro quando deseja fazer uma compra de um valor muito superior ao de costume?
                                        <br>
                                        <input type="checkbox" ng-model="toc" ng-true-value="false" ng-false-value="true">Nao<br>
                                        <input type="checkbox" ng-model="toc" ng-true-value="true" ng-false-value="false"> Sim<br>
                                        <br>
                                        <h3>Posição do Ramo de Negócio em relação a Região que trabalha (para o Vendedor)</h3>
                                        <hr>
                                        As  culturas plantadas na região tem potencial lucrativo?
                                        <br>
                                        <input type="checkbox" ng-model="cpr" ng-true-value="false" ng-false-value="true">Nao<br>
                                        <input type="checkbox" ng-model="cpr" ng-true-value="true" ng-false-value="false"> Sim<br>
                                        <br>
                                        O regime de chuvas tem apresentado problemas nos ultimos  dois anos.
                                        <br>
                                        <input type="checkbox" ng-model="pch" ng-true-value="false" ng-false-value="true">Nao<br>
                                        <input type="checkbox" ng-model="pch" ng-true-value="true" ng-false-value="false"> Sim<br>
                                        <br>
                                        A região tem áreas de irrigação.
                                        <br>
                                        <input type="checkbox" ng-model="rai" ng-true-value="false" ng-false-value="true">Nao<br>
                                        <input type="checkbox" ng-model="rai" ng-true-value="true" ng-false-value="false"> Sim<br>
                                        <br>
                                        O transporte da safra tem custo representativo no negocio de seu clientes.
                                        <br>
                                        <input type="checkbox" ng-model="trs" ng-true-value="false" ng-false-value="true">Nao<br>
                                        <input type="checkbox" ng-model="trs" ng-true-value="true" ng-false-value="false"> Sim<br>
                                        <hr>                    
                                        <strong>Score:&nbsp</strong>
                                        <div id="scoreR">
                                            <input type="number" class="form-control" ng-model="scoreR" placeholder="Score" id="txtScoreR">
                                        </div>
                                        <br>
                                        <br>
                                        <h3>Referências bancárias:</h3>
                                        <hr>
                                        <div id="referenciasR">

                                            O Cliente tem limite especial com o banco ?
                                            <br>
                                            <input type="checkbox" ng-model="leR" ng-true-value="false" ng-false-value="true">Nao<br>
                                            <input type="checkbox" ng-model="leR" ng-true-value="true" ng-false-value="false"> Sim<br>
                                            <input class="form-control" type="number" placeholder="Quanto ?" ng-model="leQR" ng-if="leR">
                                            <br>

                                            O Confirma o faturamento anual de R$ {{mediaFaturamentoR}} ?
                                            <br>

                                            <input type="checkbox" ng-model="cfR" ng-true-value="true" ng-false-value="false"> Sim<br>
                                            <br>
                                            <input type="checkbox" ng-model="cfR" ng-true-value="false" ng-false-value="true">Nao, jamais esse cliente faturaria este valor<br>
                                            <input type="number" class="form-control" ng-model="cfQR" ng-if="!cfR" placeholder="Quanto ?">

                                            <br>

                                            Nosso cliente esta solicitando um limite mensal de compras no valor R$ {{limiteMensal}}, acha adequado para seu porte ?
                                            <br>
                                            <input type="checkbox" ng-model="slR" ng-true-value="true" ng-false-value="false">
                                            Sim
                                            <br>
                                            <input type="checkbox" ng-model="slR" ng-true-value="false" ng-false-value="true">


                                        </div>
                                        <hr>
                                        <h3>Referências comerciais:</h3>
                                        <hr>
                                        <div id="referenciasCR">

                                            É cliente desde <input type="number" ng-model="clienteDesdeR" placeholder="Ano" class="form-control">
                                            <br>
                                            <br>
                                            Tem limite de crédito na empresa ?
                                            <br>
                                            <input type="checkbox" ng-model="liR" ng-true-value="false" ng-false-value="true">Nao<br>
                                            <input type="checkbox" ng-model="liR" ng-true-value="true" ng-false-value="false"> Sim<br>
                                            <input type="number" placeholder="Quanto ?" ng-if="liR" ng-model="liQR">
                                            <br>
                                            <br>

                                            Nosso cliente esta solicitando um limite mensal de compras no valor R$ {{limiteMensalR2}}, acha adequado para seu porte ?
                                            <br>
                                            <input type="checkbox" ng-model="sllR" ng-true-value="true" ng-false-value="false">
                                            Sim
                                            <br>
                                            <input type="checkbox" ng-model="sllR" ng-true-value="false" ng-false-value="true">
                                            Nao
                                        </div>
                                        <!-- FIM -->
                                        <hr>
                                        <strong style="font-size:20px;text-decoration: underline;font-style:italic">
                                            Resultado: R$ {{resultado}}
                                        </strong>
                                    </div>


                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Analise</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Analise de credito</li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form>



                        </form>

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
                                                            $('.btnvis').tooltip({title: "Visualizar", placement: "top"});
                                                            $('.btnedit').tooltip({title: "Editar", placement: "top"});
                                                            $('.btndel').tooltip({title: "Deletar", placement: "top"});
                                                            $('.btnaddprod').tooltip({title: "Adicionar", placement: "top"});
                                                        });


        </script>

    </body>

</html>