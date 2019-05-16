<!doctype html>
<html lang="en" ng-app="appRtc">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">

        <script src="js/angular.min.js"></script>
        <script src="js/rtc.js?5"></script>
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
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/fixedHeader.bootstrap4.css">
        <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">-->
        <title>RTC (Reltrab Cliente) - WEB</title>
        <style>
        </style>
    </head>

    <body ng-controller="crtFechamentoCaixa">
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
                                    <h2 class="pageheader-title">Fechamento de caixa</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Financeiro</li>
                                                <li class="breadcrumb-item active" aria-current="page">Fechamento de caixa</li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div style="height:120px">
                                            <h4>Fechamento de {{fechamento.data_anterior| data_st}} até {{fechamento.data| data_st}} do banco {{banco.codigo + ' - ' + banco.nome}}</h4>
                                            <hr>
                                            Saldo Atual do Banco: <strong style="font-size: 16px;color:Orange">R$ {{fechamento.banco.saldo}}</strong>
                                            &nbsp
                                            Valor calculado do Fechamento: <strong style="font-size: 16px;color:Green">R$ {{fechamento.valor}}</strong>
                                            &nbsp;
                                            Divergencia: <strong style="font-size: 16px;color:{{fechamento.banco.saldo !== fechamento.valor ? 'Red':'Green'}}">R$ {{(fechamento.banco.saldo - fechamento.valor).toFixed(2)}}</strong>
                                            <button style="float:right;margin-left:20px" class="btn btn-primary" ng-click="gerarRelatorio()" ng-disabled="carregando"><i class="fas fa-paperclip"></i>&nbspGerar relatorio</button>
                                            <button ng-click="mergeFechamento()" ng-disabled="!podeFechar(fechamento)" class="btn btn-outline-{{!podeFechar(fechamento) ? 'danger':'success'}}" style="float: right">
                                                <i class="fas fa-{{!podeFechar(fechamento) ? 'times':'check'}}"></i>
                                                &nbsp;
                                                <div ng-if="!podeFechar(fechamento)">
                                                    Existem divergencias, nao e possivel realizar o fechamento
                                                </div>
                                                <div ng-if="podeFechar(fechamento)">
                                                    Fechar
                                                </div>
                                            </button>
                                            <hr>
                                            <strong style="font-size:13px">OBS: clique duas vezes em cima do movimento para ver a nota</strong>
                                        </div>
                                        <hr>
                                        <table id="movimentos" class="table table-striped table-bordered first">
                                            <thead>
                                                <tr>
                                                    <th data-ordem="movimento.id">Cod.</th>
                                                    <th data-ordem="movimento.valor">Valor</th>
                                                    <th data-ordem="movimento.juros">Juros</th>
                                                    <th data-ordem="movimento.descontos">Desc</th>
                                                    <th data-ordem="movimento.data">Data</th>
                                                    <th data-ordem="movimento.banco.nome">Banco</th>
                                                    <th data-ordem="movimento.saldo.anterior">Saldo Ant</th>
                                                    <th>Efeito</th>
                                                    <th data-ordem="movimento.operacao.nome">Op</th>
                                                    <th data-ordem="movimento.historico.nome">Hist</th>
                                                    <th data-ordem="movimento.visto">Ficha</th>
                                                    <?php if ($usuario->temPermissao(Sistema::P_VISTO_MOVIMENTO()->m("C"))) { ?>
                                                        <th><i class="fas fa-eye"></i></th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <style>
                                                .tt:hover{
                                                    background-color:SteelBlue !important;
                                                    color:#FFFFFF;
                                                }
                                                .tt:hold{
                                                    background-color:DarkBlue !important;
                                                    color:#FFFFFF;
                                                }
                                            </style>
                                            <tbody>
                                                <tr ng-dblclick="getNota(mov[0])" ng-repeat="mov in movimentos.elementos" style="{{mov[0].visto?'background-color:LightGreen;color:#111111':''}};cursor:pointer" class="tt">
                                                    <td>{{mov[0].id}}</td>
                                                    <td>{{mov[0].valor}}</td>
                                                    <td>{{mov[0].juros}}</td>
                                                    <td>{{mov[0].descontos}}</td>
                                                    <td>{{mov[0].data| data}}</td>
                                                    <td>{{mov[0].banco.nome}}</td>
                                                    <td>{{mov[0].saldo_anterior}}</td>
                                                    <td style="{{(((mov[0].valor + mov[0].juros - mov[0].descontos) * (mov[0].operacao.debito ? -1 : 1)) < 0) ? 'color:Red' : 'color:Green'}}">{{((mov[0].valor + mov[0].juros - mov[0].descontos) * (mov[0].operacao.debito ? -1 : 1)) > 0 ? '+' : ''}}{{((mov[0].valor + mov[0].juros - mov[0].descontos) * (mov[0].operacao.debito ? -1 : 1)).toFixed(2)}}</td>
                                                    <td>{{mov[0].operacao.nome}}</td>
                                                    <td>{{mov[0].historico.nome}}</td>
                                                    <td>{{mov[0].vencimento.nota.ficha}}</td>
                                                    <?php if ($usuario->temPermissao(Sistema::P_VISTO_MOVIMENTO()->m("C"))) { ?>
                                                        <td><input type="checkbox" ng-model="mov[0].visto" ng-change="setVisto(mov[0])"></input></td>
                                                    <?php } ?>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Cod.</th>
                                                    <th>Valor</th>
                                                    <th>Juros</th>
                                                    <th>Desc</th>
                                                    <th>Data</th>
                                                    <th>Banco</th>
                                                    <th>Saldo Ant</th>
                                                    <th>Efeito</th>
                                                    <th>Op</th>
                                                    <th>Hist</th>
                                                    <th>Ficha</th>
                                                    <?php if ($usuario->temPermissao(Sistema::P_VISTO_MOVIMENTO()->m("C"))) { ?>
                                                        <th><i class="fas fa-eye"></i></th>
                                                    <?php } ?>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination justify-content-end">
                                                    <li class="page-item" ng-click="movimentos.prev()"><a class="page-link" href="">Anterior</a></li>
                                                    <li class="page-item" ng-repeat="pg in movimentos.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid':''}}">{{pg.numero + 1}}</a></li>
                                                    <li class="page-item" ng-click="movimentos.next()"><a class="page-link" href="">Próximo</a></li>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end pageheader  -->
                        <!-- ============================================================== -->
                        <div class="row">


                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <div class="product-btn m-b-20">
                                                <h4>Selecione o banco para o fechamento</h4>
                                                <hr>
                                            </div>
                                            <table id="fechamentos" class="table table-striped table-bordered first">
                                                <thead>
                                                    <tr>
                                                        <th><i class="fas fa-check"></i></th>
                                                        <th>Cod.</th>
                                                        <th>Nome</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="b in bancos">
                                                        <td><button ng-click="setBanco(b)" class="btn btn-outline-{{banco.id===b.id?'success':'light'}}" style="width:50px;height:50px;padding:10px"><i class="fas fa-check" ng-if="banco.id === b.id"></i></button></td>
                                                        <td>{{b.codigo}}</td>
                                                        <td>{{b.nome}}</td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th><i class="fas fa-check"></i></th>
                                                        <th>Cod.</th>
                                                        <th>Nome</th>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- basic table  -->
                            <!-- ============================================================== -->
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <div class="product-btn m-b-20">
                                                <h4>Fechamentos Anteriores</h4>
                                                <hr>
                                            </div>
                                            <table id="fechamentos" class="table table-striped table-bordered first">
                                                <thead>
                                                    <tr>
                                                        <th data-ordem="fechamento_caixa.id">Cod.</th>
                                                        <th data-ordem="fechamento_caixa.valor">Valor</th>
                                                        <th data-ordem="fechamento_caixa.data">Data</th>
                                                        <th data-ordem="fechamento_caixa.banco.codigo">Cod. Ban</th>
                                                        <th data-ordem="fechamento_caixa.banco.nome">Nom Ban</th>
                                                        <th data-ordem="fechamento_caixa.banco.saldo">Sal Ban</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="f in fechamentos.elementos">
                                                        <td>{{f[0].id}}</td>
                                                        <td>{{f[0].valor}}</td>
                                                        <td>{{f[0].data| data}}</td>
                                                        <td>{{f[0].banco.codigo}}</td>
                                                        <td>{{f[0].banco.nome}}</td>
                                                        <td>{{f[0].banco.saldo}}</td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Cod.</th>
                                                        <th>Valor</th>
                                                        <th>Data</th>
                                                        <th>Cod. Ban</th>
                                                        <th>Nom Ban</th>
                                                        <th>Sal Ban</th>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                            <!-- paginação  -->
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination justify-content-end">
                                                        <li class="page-item" ng-click="fechamentos.prev()"><a class="page-link" href="">Anterior</a></li>
                                                        <li class="page-item" ng-repeat="pg in fechamentos.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid':''}}">{{pg.numero + 1}}</a></li>
                                                        <li class="page-item" ng-click="fechamentos.next()"><a class="page-link" href="">Próximo</a></li>
                                                    </ul>
                                                </nav>
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
                <div class="modal fade in" id="add" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-plus-circle fa-3x"></i>&nbsp;&nbsp;&nbsp;Configure os dados de seu Movimento({{movimento.id}})</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="add-form" ng-submit="mergeMovimento()" parsley-validate>
                                    <div class="form-group row">
                                        <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Dt Mov</label>
                                        <div class="col-9 col-lg-10">
                                            <calendario model="movimento.data" botao="true" tempo="true" refresh="movimento" meses="1"></calendario>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtname" class="col-3 col-lg-2 col-form-label text-left">Valor R$</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtname" type="number" step="0.01" ng-model="movimento.valor" required data-parsley-type="email" placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtemail" class="col-3 col-lg-2 col-form-label text-left">Juros R$</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtemail" ng-model="movimento.juros" type="number" step="0.01" required data-parsley-type="email" placeholder="" class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtcnpj" class="col-3 col-lg-2 col-form-label text-left">Desc R$</label>
                                        <div class="col-9 col-lg-10">
                                            <input id="txtcnpj" type="number" step="0.01" ng-model="movimento.descontos" required class="form-control">
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtcnpj" class="col-3 col-lg-2 col-form-label text-left">Historico</label>
                                        <select class="form-control" ng-model="movimento.historico">
                                            <option ng-repeat="h in historicos" ng-value="h">{{h.nome}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txtcnpj" class="col-3 col-lg-2 col-form-label text-left">Operacoes</label>
                                        <select class="form-control" ng-model="movimento.operacao">
                                            <option ng-repeat="o in operacoes" ng-value="o">{{o.nome}} - {{o.debito?'Debito':'Credito'}}</option>
                                        </select>
                                    </div>
                                    <div ng-if="movimento.estorno > 0" style="color:Orange">
                                        <strong>Estorno do movimento {{movimento.estorno}}</strong>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Ficha</label>
                                        <div class="form-row">
                                            <div class="col-2">
                                                <input type="text" ng-model="movimento.vencimento.nota.ficha" class="form-control" placeholder="Ficha" value="9" disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" ng-model="movimento.vencimento.valor" class="form-control" placeholder="valor" value="" disabled="">
                                            </div>
                                            <div class="col-md-4">
                                                <div ng-if="movimento.vencimento === null">
                                                    DD/MM/AAAA
                                                </div>
                                                <div ng-if="movimento.vencimento !== null">
                                                    {{movimento.vencimento.data| data}}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <a href="#" class="btn btn-outline-light btnedit" data-toggle="modal" ng-click="notas.attList()" data-target="#vencimentos"><i class="fas fa-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Banco</label>
                                        <div class="form-row">
                                            <div class="col-2">
                                                <input type="text" ng-model="movimento.banco.id" class="form-control" placeholder="Cod." value="9" disabled>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" ng-model="movimento.banco.nome" class="form-control" placeholder="Nome do banco" value="" disabled="">
                                            </div>
                                            <div class="col-md-2">
                                                <a href="#" class="btn btn-outline-light btnedit" data-toggle="modal" ng-click="bancos.attList()" data-target="#bancos"><i class="fas fa-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-dismiss="modal" ng-if="movimento.id === 0">Fechar</button>
                                        <button class="btn btn-primary" ng-if="movimento.id === 0">
                                            <i class="fas fa-plus-circle"></i> &nbsp; Incluir
                                        </button>
                                        <button type="button" class="btn btn-light" ng-if="movimento.id !== 0">
                                            <i class="fas fa-stop"></i> &nbsp; Nao e possivel alterar um movimento, somente deletar e incluir
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- /.modal-content -->

                <div class="modal fade" id="vencimentos" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Seleção de Ficha/Vencimento</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control col-md-8" id="filtroNota" placeholder="Filtro">
                                <table class="table table-striped table-bordered first">
                                    <thead>
                                    <th data-ordem="nota.ficha">Ficha.</th>
                                    <th data-ordem="nota.numero">Numero</th>
                                    <th data-ordem="nota.cliente.razao_social">Cliente</th>
                                    <th data-ordem="nota.fornecedor.nome">Fornecedor</th>
                                    <th>Selecionar</th>
                                    </thead>
                                    <tr ng-repeat-start="not in notas.elementos">
                                        <th>{{not[0].ficha}}</th>
                                        <th>{{not[0].numero}}</th>
                                        <th>{{not[0].cliente===null?'------':not[0].cliente.razao_social}}</th>
                                        <th>{{not[0].fornecedor===null?'------':not[0].fornecedor.nome}}</th>
                                        <th><button class="btn btn-success" ng-click="getVencimentos(not[0])" data-target="#demo{{not[0].id}}" data-toggle="collapse" class="accordion-toggle"><i class="fa fa-info"></i></button></th>
                                    </tr>
                                    <tr ng-repeat-end>
                                        <td colspan="6" class="hiddenRow">
                                            <div class="accordian-body collapse" id="demo{{not[0].id}}">
                                                <div class="row mx-auto m-b-30">
                                                    <div class="col">
                                                        <table class="table table-striped table-bordered first">
                                                            <thead>
                                                            <th>Valor</th>
                                                            <th>Data</th>
                                                            <th>Baixado</th>
                                                            <th>Selecionar</th>
                                                            </thead>
                                                            <tr ng-repeat="venc in not[0].vencimentos" style="{{venc.movimento !== null ? 'color:Green':'color:Red'}}">
                                                                <th>{{venc.valor}} R$</th>
                                                                <th>{{venc.data| data}}</th>
                                                                <th>{{venc.movimento !== null ? 'Sim':'Nao'}}</th>
                                                                <th><button class="btn btn-success" ng-click="setVencimento(venc)" ng-disabled="venc.movimento !== null"><i class="fas fa-info"></i></button></th>
                                                            </tr>
                                                        </table>
                                                    </div>																	
                                                </div>	
                                            </div> 
                                        </td>
                                    </tr>
                                </table>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item" ng-click="notas.prev()"><a class="page-link" href="">Anterior</a></li>
                                            <li class="page-item" ng-repeat="pg in notas.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></li>
                                            <li class="page-item" ng-click="notas.next()"><a class="page-link" href="">Próximo</a></li>
                                        </ul>
                                    </nav>
                                </div>

                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="bancos" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Seleção de Banco</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control" id="filtroBanco" placeholder="Filtro">
                                <hr>
                                <table class="table table-striped table-bordered first">
                                    <thead>
                                    <th data-ordem="banco.id">Cod.</th>
                                    <th data-ordem="banco.nome">Nome</th>
                                    <th>Selecionar</th>
                                    </thead>
                                    <tr ng-repeat="banc in bancos.elementos">
                                        <th>{{banc[0].id}}</th>
                                        <th>{{banc[0].nome}}</th>
                                        <th><button class="btn btn-success" ng-click="setBanco(banc[0])"><i class="fa fa-info"></i></button></th>
                                    </tr> 
                                </table>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item" ng-click="bancos.prev()"><a class="page-link" href="">Anterior</a></li>
                                            <li class="page-item" ng-repeat="pg in bancos.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></li>
                                            <li class="page-item" ng-click="bancos.next()"><a class="page-link" href="">Próximo</a></li>
                                        </ul>
                                    </nav>
                                </div>

                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>


                <!-- /.modal-content DELETE --> 
                <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-trash-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Delete o Movimento</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center"> Tem certeza de que deseja excluir este Movimento?</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" ng-click="deleteMovimento()">Sim</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Não</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade in" id="nota" tabindex="-1" role="dialog" aria-labelledby="editCompra" aria-hidden="true" style="display: none;overflow-y:scroll">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-pencil-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Configure os dados de sua Nota ({{nota.numero}})</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="col-4 col-lg-4" style="padding-top: 5px;">
                                        Tipo de Nota:
                                        <div class="row">
                                            <div class="col-md-6" style="text-align:center">
                                                <label class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" name="radio-inline" data-ng-value="true" data-ng-model="nota.saida" class="custom-control-input" ng-disabled="true"><span class="custom-control-label">Saida</span>
                                                </label>
                                            </div>
                                            <div class="col-md-6" style="text-align:center">
                                                <label class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" name="radio-inline" data-ng-value="false" data-ng-model="nota.saida" checked="" class="custom-control-input" ng-disabled="true"><span class="custom-control-label">Entrada</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" ng-if='nota.saida'>
                                        <label for="">Cliente</label>
                                        <div class="form-row">
                                            <div class="col-2">
                                                <input type="text" ng-model="nota.cliente.codigo" class="form-control" placeholder="Cod." value="9" disabled>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" ng-model="nota.cliente.razao_social" class="form-control" placeholder="Nome do cliente" value="" disabled="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" ng-if='!nota.saida'>
                                        <label for="">Fornecedor</label>
                                        <div class="form-row">
                                            <div class="col-2">
                                                <input type="text" ng-model="nota.fornecedor.codigo" class="form-control" placeholder="Cod." value="9" disabled>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" ng-model="nota.fornecedor.nome" class="form-control" placeholder="Nome do fornecedor" value="" disabled="">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label for="">Transportadora</label>
                                        <div class="form-row">
                                            <div class="col-2">
                                                <input type="text" class="form-control" placeholder="Cod." ng-model="nota.transportadora.codigo" disabled>
                                            </div>
                                            <div class="col-5">
                                                <input type="text" class="form-control" ng-model="nota.transportadora.razao_social" placeholder="Nome da Transportadora" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-9">
                                            <div class="form-group">                                             
                                                <div class="form-row" style="margin-bottom:5px">
                                                    <div class="col-md-5">
                                                        <label for="">Data e Hora de emissao</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" ng-model="nota.data_emissao_texto"></input>
                                                    </div>
                                                </div>
                                                <div class="form-row" style="margin-bottom:5px">
                                                    <div class="col-md-3">
                                                        <label for="">Chave da nota</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" ng-model="nota.chave"></input>
                                                    </div>
                                                </div>
                                                <div class="form-row" style="margin-bottom:5px">
                                                    <div class="col-md-5">
                                                        <label for="">Protocolo de autorizacao: </label>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="text" class="form-control" ng-model="nota.protocolo"></input>
                                                    </div>
                                                </div>
                                                <div class="form-row" style="margin-bottom:5px">
                                                    <div class="col-md-5">
                                                        <label for="">Numero: </label>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="number" class="form-control" ng-model="nota.numero"></input>
                                                    </div>
                                                </div>
                                            </div>			
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-row">
                                        <div class="col-9">
                                            <div class="form-group">
                                                <label for="">Observações</label>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <textarea class="form-control" rows="2" id="comment" ng-model="nota.observacao"></textarea>
                                                    </div>
                                                </div>

                                            </div>			
                                        </div>
                                    </div>
                                    <div class="form-row" style="height:50px">
                                        <div class="col-4" style="position:relative">
                                            <input class="custom-control-input" id="chk1" style="display: inline-block;position:absolute;top:0px;left:5px" type="checkbox" ng-true-value="true" ng-false-value="false" ng-model="nota.emitida" ng-disabled="nota.ficha > 0">
                                            <label class="custom-control-label" style="cursor:pointer;" for="chk1"><strong style="position:absolute;top:0px;left:27px">Nota emitida</strong></label>
                                        </div>
                                        <div class="col-4" style="position:relative" ng-if="nota.emitida">
                                            <input class="custom-control-input" id="chkr" style="display: inline-block;position:absolute;top:0px;left:5px" type="checkbox" ng-true-value="true" ng-false-value="false" ng-model="nota.cancelada">
                                            <label class="custom-control-label" style="cursor:pointer;" for="chkr"><strong style="position:absolute;top:0px;left:27px">Nota cancelada</strong></label>
                                        </div>
                                    </div>
                                    <div class="form-row" ng-if="nota.emitida">
                                        <button type="button" class="btn btn-success" style="margin-left:5px" ng-if="nota.xml !== ''" ng-download="{{nota.xml}}"><i class="fas fa-save"></i>&nbspBaixar XML</button>
                                        <button type="button" class="btn btn-success" style="margin-left:5px" ng-if="nota.danfe !== ''" ng-download="{{nota.xml}}"><i class="fas fa-save"></i>&nbspBaixar DANFE</button>

                                        <button class="btn btn-light" type="button" style="margin-left:5px" ng-if="nota.xml === ''" ng-click="uploadXML('uploaderXML')"><i class="fas fa-upload"></i>&nbspFazer upload do XML</button>
                                        <button class="btn btn-light" type="button" style="margin-left:5px" ng-if="nota.danfe === ''" ng-click="uploadDANFE('uploaderDANFE')"><i class="fas fa-upload"></i>&nbspFazer upload da DANFE</button>

                                        <input type="file" style="visibility:hidden" id="uploaderXML">
                                        <input type="file" style="visibility:hidden" id="uploaderDANFE">
                                    </div>
                                    <hr>
                                    <div class="form-group" style="position:relative;height:40px">
                                        <input class="custom-control-input" id="chkq" style="display: inline-block;position:absolute;top:0px;left:5px" type="checkbox" ng-true-value="true" ng-false-value="false" ng-model="nota.calcular_valores" ng-change="calcular()">
                                        <label class="custom-control-label" style="cursor:pointer;" for="chkq"><strong style="position:absolute;top:0px;left:27px">Calcular impostos automaticamente</strong></label>
                                    </div>
                                    <hr>
                                    <br>
                                    <label for="">Produtos (tab para atualizar)</label>
                                    <table id="" class="table table-striped" width="90%">
                                        <thead>
                                            <tr>
                                                <th>Cod</th>
                                                <th>Nome</th>
                                                <th>Qtd.</th>
                                                <th class="text-center">Vl Unit.</th>
                                                <th class="text-center">Vl Tot.</th>
                                                <th class="text-center">Bas. Calc.</th>
                                                <th class="text-center">Icms</th>
                                                <th class="text-center">Ipi</th>
                                                <th class="text-center">Cfop</th>
                                                <th class="text-center">Info.</th>
                                                <th>Excluir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="prod in nota.produtos">
                                                <th>{{prod.produto.codigo}}</th>
                                                <th>{{prod.produto.nome}}</th>
                                                <th><input type="number" class="form-control" ng-model="prod.quantidade" ng-confirm="calcular()"></th>
                                                <th><input type="number" class="form-control" ng-model="prod.valor_unitario" ng-confirm="calcular()"></th>
                                                <th class="text-center">{{prod.valor_total}}</th>
                                                <th class="text-center"><input type="number" step="0.001" class="form-control" ng-model="prod.base_calculo" ng-confirm="calcular()"></th>
                                                <th class="text-center"><input type="number" step="0.001"  class="form-control" ng-model="prod.icms" ng-confirm="calcular()"></th>
                                                <th class="text-center"><input type="number" step="0.001"  class="form-control" ng-model="prod.ipi" ng-confirm="calcular()"></th>
                                                <th class="text-center"><input type="text" class="form-control" ng-model="prod.cfop" ng-confirm="calcular()"></th>
                                                <th class="text-center"><input type="text" class="form-control" ng-model="prod.informacao_adicional"></th>
                                                <th><button type="button" class="btn btn-light" ng-disabled="true"><i class="fas fa-trash"></i></button></th>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>

                                                </td>

                                            </tr>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="7" style="text-align:right;">VALOR TOTAL</th>
                                                <th colspan="3">R$ {{getTotalNota().toFixed(2)}}</th>
                                            </tr>
                                        </tfoot>		
                                    </table>
                                    <hr>
                                    <div class="form-group">
                                        <strong style="font-size:15px">Vencimentos:</strong>
                                        <hr>
                                        <div class="form-row">
                                            <div class="form-inline col-12">
                                                <table id="" class="table table-striped" width="90%">
                                                    <thead>
                                                        <tr>
                                                            <th>Cod</th>
                                                            <th>Valor</th>
                                                            <th>Data</th>
                                                            <th>Movimento</th>
                                                            <th>Excluir</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr style="{{venc.movimento==null?'color:Red':'color:Green'}}" ng-repeat="venc in nota.vencimentos">
                                                            <td>{{venc.id}}</td>
                                                            <td>{{venc.valor}} R$</td>
                                                            <td><input type="text" class="form-control" ng-model="venc.data_texto"></td>
                                                            <td>{{venc.movimento==null?'Sem movimento':'Baixado Movimento '+venc.movimento.id+', '+venc.movimento.banco.nome}}</td>
                                                            <td>
                                                                <div class="product-btn">
                                                                    <button type="button" class="btn btn-light" ng-disabled="true"><i class="fas fa-trash"></i></button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>

                                                    </tfoot>		
                                                </table>

                                            </div>    
                                        </div>
                                    </div>
                                    <hr>
                                    <hr>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="form-inline col-5">
                                                <div style="margin-right: 20px;">Forma de cobranca: <strong>{{nota.forma_pagamento.nome}}</strong></div>
                                            </div>
                                        </div>
                                    </div>					
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" style="overflow-y:scroll" id="mdlRelatorio" tabindex="-1" role="dialog" aria-labelledby="mdlFilhos" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content" >
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-table fa-3x"></i>&nbsp;&nbsp;&nbsp;Gerado com sucesso !</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">

                                <a download="relatorioFechamento.pdf" href="{{relatorio}}"><i class="fas fa-upload"></i>&nbsp Baixar relatorio</a>

                            </div>

                        </div>
                    </div>
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
                                                            $('.btninfo').tooltip({title: "Mais informação", placement: "top"});
                                                            $('.btnedit').tooltip({title: "Editar", placement: "top"});
                                                            $('.btndel').tooltip({title: "Deletar", placement: "top"});
                                                        });
                                                        $(document).ready(function () {
                                                            $('#clientes').DataTable({
                                                                "language": {//Altera o idioma do DataTable para o português do Brasil
                                                                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                                                                },
                                                            });

                                                            $.getJSON('estados_cidades.json', function (data) {
                                                                var items = [];
                                                                var options = '<option value="">escolha um estado</option>';
                                                                $.each(data, function (key, val) {
                                                                    options += '<option value="' + val.nome + '">' + val.nome + '</option>';
                                                                });
                                                                $("#estados").html(options);

                                                                $("#estados").change(function () {

                                                                    var options_cidades = '';
                                                                    var str = "";

                                                                    $("#estados option:selected").each(function () {
                                                                        str += $(this).text();
                                                                    });

                                                                    $.each(data, function (key, val) {
                                                                        if (val.nome == str) {
                                                                            $.each(val.cidades, function (key_city, val_city) {
                                                                                options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
                                                                            });
                                                                        }
                                                                    });
                                                                    $("#cidades").html(options_cidades);

                                                                }).change();

                                                            });
                                                        });

                </script>

                </body>

                </html>
