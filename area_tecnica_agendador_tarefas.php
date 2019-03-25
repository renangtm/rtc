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
        <title>RTC (Reltrab Cliente) - WEB</title>
        <style>
        </style>
    </head>

    <body ng-controller="crtFornecedores">
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
                                    <h2 class="pageheader-title">Area Tecnica - Controlador de Tarefas</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Area Tecnica - Controlador de Tarefas</li>
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

                                        <span style="margin:50px;margin-left:auto;margin-right:auto" class="dashboard-spinner spinner-success spinner-lg "></span>
                                        &nbsp;
                                        <h2 style="display:inline">Executando rotinas do sistema...</h2>
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

                <!-- /.modal-content -->

                <!-- /.modal-content --> 				




                <!-- /.modal-content --> 

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
                

                function executarTarefa(tarefa) {
                    
                    var ss = function () {

                    }
                    jsBaseService(
                            {
                                o:tarefa,
                                query: '$o->executar($c)',
                                sucesso: ss,
                                falha: ss
                            },false
                    )
                }

                function convertTime(t) {
                    
                    t = t.substr(1, t.length - 2);
                    var dt = new Date();
                    t = t.split(":");
                    
                    dt.setHours(0);
                    dt.setMinutes(0);
                    dt.setSeconds(0);
                    dt.setMilliseconds(0);

                    for (var i = 0; i < t.length; i++) {

                        var l = t[i];   
                        
                        var tipo = l.charAt(l.length - 1);
                        var numero = parseInt(l.substr(0, l.length - 1));
                     
                        if (tipo === "m") {
                            if(numero === 60)numero--;
                            dt.setMinutes(numero)
                        } else if (tipo === "s") {
                            if(numero===60)numero--;
                            dt.setSeconds(numero);
                        } else if (tipo === "h") {
                            if(numero === 24)numero--;
                            dt.setHours(numero);
                        }else if(tipo === "q"){
                            if(numero === 1000)numero--;
                            dt.setMilliseconds(numero);
                        }

                    }
                   
                    return dt;

                }

                var rotinas_executadas = [];

                function req() {

                    var agora = new Date();

                    var s = function (r) {

                        var tarefas = r.tasks;
                        
                        lbl:
                                for (var i = 0; i < tarefas.length; i++) {
                                
                            var ce = tarefas[i].cronoExpression;

                            var tipo = ce.substr(0, 2);
                            var expressao = ce.substr(2, ce.length);
                            var data = convertTime(expressao);

                            if (tipo === "at") {

                                for (var j = 0; j < rotinas_executadas.length; j++) {
                                    var rotina = rotinas_executadas[j];
                                    if (rotina.nome === tarefas[i]._classe) {
                                        if (rotina.data.getTime() === data.getTime()) {
                                            continue lbl;
                                        }
                                    }
                                }

                                if (agora.getTime() >= data.getTime()) {

                                    var rotina = {nome: tarefas[i]._classe, data: data, real: agora, rec: 0};
                                    rotinas_executadas[rotinas_executadas.length] = rotina;

                                    executarTarefa(tarefas[i]);

                                }

                            } else if (tipo === "re") {
                                
                                var tempo_atual = agora.getHours() * 60 * 60 * 1000 + agora.getMinutes() * 60 * 1000 + agora.getSeconds() * 1000;
                                var tempo_rec = data.getHours() * 60 * 60 * 1000 + data.getMinutes() * 60 * 1000 + data.getSeconds() * 1000;
                                var rec = (tempo_atual - (tempo_atual % tempo_rec)) / tempo_rec;
                             
                                for (var j = 0; j < rotinas_executadas.length; j++) {
                                    var rotina = rotinas_executadas[j];
                                    if (rotina.nome === tarefas[i]._classe && rotina.data.getTime() === data.getTime()) {
                                        if (rotina.rec === rec) {
                                            continue lbl;
                                        }
                                    }
                                }
                               
                                var rotina = {nome: tarefas[i]._classe, data: data, real: agora, rec: rec};
                                rotinas_executadas[rotinas_executadas.length] = rotina;
                                 
                                executarTarefa(tarefas[i]);
                                
                            }


                        }
                        
                    }

                    jsBaseService(
                            {
                                query: '$r->tasks=Sistema::getTrabalhosCronometrados()',
                                sucesso: s,
                                falha: s
                            }
                    )
                     
                }

                req();
               
                setInterval(function () {

                    req();

                },2000);

                </script>

                </body>

                </html>