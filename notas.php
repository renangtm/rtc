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
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/fixedHeader.bootstrap4.css">        <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">-->
        <title>RTC (Reltrab Cliente) - WEB</title>

    </head>

    <body ng-controller="crtNotas">
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
                                    <h2 class="pageheader-title">Notas</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Notas</li>
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
                                        <div class="table-responsive">
                                            <div class="product-btn m-b-20">
                                                <a href="#" class="btn btn-primary" data-title="AddCompra" ng-click="novoNota()" data-toggle="modal" data-target="#editCompra" ><i class="fas fa-plus-circle m-r-10"></i>Cadastrar Nota</a>


                                            </div>
                                            <hr><br>
                                            <table id="pedidos" class="table table-striped table-bordered first">
                                                <thead>
                                                    <tr>
                                                        <th data-ordem="nota.ficha">Ficha</th>
                                                        <th data-ordem="nota.numero">Numero</th>
                                                        <th data-ordem="nota.transportadora.razao_social">Transportadora</th>
                                                        <th data-ordem="nota.saida">Tipo</th>
                                                        <th data-ordem="nota.id_pedido">Pedido</th>
                                                        <th data-ordem="nota.data">Data Emissao</th>
                                                        <th data-ordem="nota.cliente.razao_social">Cliente</th>
                                                        <th data-ordem="nota.fornecedor.nome">Fornecedor</th>
                                                        <th>Status</th>
                                                        <th>Acao</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat-start="notaa in notas.elementos" style="{{notaa[0].cancelada?'color:DarkRed':(!notaa[0].emitida?'color:DarkOrange':'')}}">
                                                        <td>{{notaa[0].ficha}}</td>
                                                        <td>{{notaa[0].numero}}</td>
                                                        <td>{{notaa[0].transportadora.razao_social}}</td>
                                                        <td>{{notaa[0].saida ? 'Saída' : 'Entrada'}}</td>
                                                        <td>{{notaa[0].id_pedido}}</td>
                                                        <td ng-if="notaa[0].emitida">{{notaa[0].data_emissao| data}}</td>
                                                        <td ng-if="!notaa[0].emitida">---------</td>
                                                        <td>{{notaa[0].cliente == null ? '--------' : notaa[0].cliente.razao_social}}</td>
                                                        <td>{{notaa[0].fornecedor == null ? '--------' : notaa[0].fornecedor.nome}}</td>
                                                        <td>{{notaa[0].cancelada ? 'Cancelada' :( notaa[0].emitida ? (notaa[0].saida?'Emitida':'Manifestada') : (notaa[0].saida?'Aguardando emissao...':'Aguardando manifestacao...'))}}</td>
                                                        <th>
                                                            <div class="product-btn">
                                                                <a href="#" class="btn btn-outline-light btninfo" data-toggle="collapse" ng-click="setNota(notaa[0])" data-target="#demo{{notaa[0].id}}" class="accordion-toggle"><i class="fas fa-info-circle"></i></a>
                                                                <a href="#" class="btn btn-outline-light btnedit" data-title="Edit" ng-click="setNota(notaa[0])" data-toggle="modal" data-target="#editCompra"><i class="fas fa-pencil-alt"></i></a>
                                                                <a href="#" class="btn btn-outline-light btndel" data-title="Delete" ng-click="setNota(notaa[0])" data-toggle="modal" data-target="#delete"><i class="fas fa-trash-alt"></i></a>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    <tr ng-repeat-end>
                                                        <td colspan="6" class="hiddenRow">
                                                            <div class="accordian-body collapse" id="demo{{notaa[0].id}}">
                                                                <div class="row mx-auto m-b-30">
                                                                    <div class="col">
                                                                        <table class="table table-striped w-100">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>
                                                                                        Log
                                                                                    </th>
                                                                                    <th>
                                                                                        Momento
                                                                                    </th>
                                                                                    <th>
                                                                                        Usuario
                                                                                    </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tr ng-repeat="log in notaa[0].logs">
                                                                                <td>
                                                                                    {{log.obs}}
                                                                                </td>
                                                                                <td>
                                                                                    {{log.momento | data}}
                                                                                </td>
                                                                                <td>
                                                                                    {{log.usuario}}
                                                                                </td>
                                                                            </tr>
                                                                            <tr ng-if="notaa[0].logs.length===0">
                                                                                <td colspan="3">
                                                                                    Sem nenhum log
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col" ng-if="operacao_sefaz>0" style="margin-top:20px">
                                                                        <span style="margin-left:auto;margin-tight:auto" class="dashboard-spinner spinner-success spinner-lg "></span>
                                                                        <hr>
                                                                        <h4>
                                                                            Operacao sendo executada
                                                                        </h4>
                                                                    </div>
                                                                    <div class="col" style="margin-top:10px" ng-if="operacao_sefaz===0">
                                                                        <div ng-if="notaa[0].saida && notaa[0].emitida">
                                                                            <button class="btn btn-outline-danger" ng-click="cancelar(notaa[0])" ng-if="!notaa[0].cancelada"> 
                                                                                <i class="fas fa-times"></i>
                                                                                &nbsp Cancelar NF {{notaa[0].numero}}  
                                                                            </button>
                                                                            <button class="btn btn-outline-primary" ng-click="emitir(notaa[0])" ng-if="notaa[0].cancelada"> 
                                                                                <i class="fas fa-check"></i>
                                                                                &nbsp Reemitir NF
                                                                            </button>
                                                                            <button class="btn btn-outline-warning" ng-click="corrigir(notaa[0])"> 
                                                                                <i class="fas fa-list"></i>
                                                                                &nbsp Corrigir NF {{notaa[0].numero}}  
                                                                            </button>
                                                                            
                                                                                <hr>                        
                                                                                <textarea rows="5" ng-model="notaa[0].observacao_sefaz" class="form-control" style="width:100%">
                                                                                    
                                                                                </textarea>
                                                                        </div>
                                                                        <div ng-if="notaa[0].saida && !notaa[0].emitida">
                                                                            <button class="btn btn-outline-success" style="width:100%;height:50px;font-size:16px" ng-click="emitir(notaa[0])"> 
                                                                                <i class="fas fa-check"></i>
                                                                                &nbsp Emitir NF
                                                                            </button>
                                                                        </div>
                                                                        <div ng-if="!notaa[0].saida && !notaa[0].emitida">
                                                                            <button class="btn btn-outline-primary" style="width:100%;height:50px;font-size:16px" ng-click="manifestar(notaa[0])"> 
                                                                                <i class="fas fa-certificate"></i>
                                                                                &nbsp Manifestar NF
                                                                            </button>
                                                                        </div>    
                                                                    </div>																
                                                                </div>	
                                                            </div> 
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Ficha</th>
                                                        <th>Numero</th>
                                                        <th>Transportadora</th>
                                                        <th>Tipo</th>
                                                        <th>Pedido</th>
                                                        <th>Data Emissao</th>
                                                        <th>Cliente</th>
                                                        <th>Fornecedor</th>
                                                        <th>Status</th>
                                                        <th>Acao</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination justify-content-end">
                                                        <li class="page-item" ng-click="notas.prev()"><a class="page-link" href="">Anterior</a></li>
                                                        <li class="page-item" ng-repeat="pg in notas.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid':''}}">{{pg.numero + 1}}</a></li>
                                                        <li class="page-item" ng-click="notas.next()"><a class="page-link" href="">Proximo</a></li>
                                                    </ul>
                                                </nav>
                                            </div>
                                            <!-- paginação  -->


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


                <!-- /.modal-content -->

                <!-- /.modal-content EDIT --> 
                <div class="modal fade in" id="editCompra" tabindex="-1" role="dialog" aria-labelledby="editCompra" aria-hidden="true" style="display: none;overflow-y:scroll">
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
                                                    <input type="radio" name="radio-inline" data-ng-value="true" data-ng-model="nota.saida" class="custom-control-input" ng-disabled="nota.emitida"><span class="custom-control-label">Saida</span>
                                                </label>
                                            </div>
                                            <div class="col-md-6" style="text-align:center">
                                                <label class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" name="radio-inline" data-ng-value="false" data-ng-model="nota.saida" checked="" class="custom-control-input" ng-disabled="nota.emitida"><span class="custom-control-label">Entrada</span>
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
                                            <div class="col">
                                                <a href="#" class="btn btn-outline-light btnedit" data-toggle="modal" ng-click="clientes.attList()" data-target="#clientes"><i class="fas fa-search"></i></a>
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
                                            <div class="col">
                                                <a href="#" class="btn btn-outline-light btnedit" data-toggle="modal" ng-click="fornecedores.attList()" data-target="#fornecedores"><i class="fas fa-search"></i></a>
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
                                            <div class="col">
                                                <a href="#" class="btn btn-outline-light btnedit" data-toggle="modal" ng-click="transportadoras.attList()" data-target="#transportadoras"><i class="fas fa-search"></i></a>
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
                                        <button type="button" class="btn btn-success" style="margin-left:5px" ng-if="nota.danfe !== ''" ng-download="{{nota.danfe}}"><i class="fas fa-save"></i>&nbspBaixar DANFE</button>

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
                                                <th><button type="button" class="btn btn-light" ng-click="removerProduto(prod)"><i class="fas fa-trash"></i></button></th>
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
                                                    <div class="product-btn">
                                                        <a href="#" class="btn btn-outline-light btnaddprod" ng-click="produtos.attList()" data-title="addproduto" data-toggle="modal" data-target="#produtos"><i class="fas fa-plus-circle"></i></a>
                                                    </div>
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
                                                <div class="row" style="margin-bottom:20px">
                                                    <div class="col-md-5">
                                                        Data:
                                                        <input type="text" class="form-control" ng-model="vencimento.data_texto">
                                                    </div>
                                                    <div class="col-md-5">
                                                        Valor:
                                                        <input type="number" step="0.01" class="form-control" ng-model="vencimento.valor">
                                                    </div>
                                                    <div class="col-md-2" style="padding-top: 20px">
                                                        <button class="btn btn-success" type="button" ng-click="addVencimento()">
                                                            <i class="fa fa-plus-circle"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <hr>
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
                                                                    <button type="button" class="btn btn-light" ng-click="removeVencimento(venc)"><i class="fas fa-trash"></i></button>
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
                                                <label for="" style="margin-right: 20px;">Forma de cobranca: </label>
                                                <select class="form-control col-7" id="status" ng-model="nota.forma_pagamento">    
                                                    <option ng-value="forma_pagamento" ng-repeat="forma_pagamento in formas_pagamento">{{forma_pagamento.nome}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>					
                                </form>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                                <button class="btn btn-primary" ng-click="mergeNota()">
                                    <i class="fas fa-save"></i> &nbsp; Salvar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content --> 				



                <!-- /.modal-content DELETE --> 
                <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-trash-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Delete os dados de sua Nota</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center"> Tem certeza de que deseja excluir esta Nota?</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" ng-click="deleteNota()">Sim</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Não</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content --> 
                <!-- /.modal-content --> 
                <div class="modal fade" id="fornecedores" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Seleção de Fornecedores</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control" id="filtroFornecedores" placeholder="Filtro">
                                <hr>
                                <table class="table table-striped table-bordered first">
                                    <thead>
                                    <th data-ordem="fornecedor.codigo">Cod.</th>
                                    <th data-ordem="fornecedor.nome">Nome</th>
                                    <th>Selecionar</th>
                                    </thead>
                                    <tr ng-repeat="fo in fornecedores.elementos">
                                        <th>{{fo[0].codigo}}</th>
                                        <th>{{fo[0].nome}}</th>
                                        <th><button class="btn btn-success" ng-click="setFornecedor(fo[0])"><i class="fa fa-info"></i></button></th>
                                    </tr> 
                                </table>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item" ng-click="fornecedores.prev()"><a class="page-link" href="">Anterior</a></li>
                                            <li class="page-item" ng-repeat="pg in fornecedores.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></li>
                                            <li class="page-item" ng-click="fornecedores.next()"><a class="page-link" href="">Próximo</a></li>
                                        </ul>
                                    </nav>
                                </div>

                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content CLIENTE --> 
                <div class="modal fade" id="clientes" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Seleção de Cliente</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control" id="filtroClientes" placeholder="Filtro">
                                <hr>
                                <table class="table table-striped table-bordered first">
                                    <thead>
                                    <th data-ordem="cliente.codigo">Cod.</th>
                                    <th data-ordem="cliente.razao_social">Nome</th>
                                    <th>Selecionar</th>
                                    </thead>
                                    <tr ng-repeat="cli in clientes.elementos">
                                        <th>{{cli[0].codigo}}</th>
                                        <th>{{cli[0].razao_social}}</th>
                                        <th><button class="btn btn-success" ng-click="setCliente(cli[0])"><i class="fa fa-info"></i></button></th>
                                    </tr> 
                                </table>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item" ng-click="clientes.prev()"><a class="page-link" href="">Anterior</a></li>
                                            <li class="page-item" ng-repeat="pg in clientes.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></li>
                                            <li class="page-item" ng-click="clientes.next()"><a class="page-link" href="">Próximo</a></li>
                                        </ul>
                                    </nav>
                                </div>

                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content TRANSPORTADORAS --> 
                <div class="modal fade" id="transportadoras" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Seleção de Transporte</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control" id="filtroTransportadoras" placeholder="Filtro">
                                <hr>
                                <table class="table table-striped table-bordered first">
                                    <thead>
                                    <th data-ordem="transportadora.codigo">Cod.</th>
                                    <th data-ordem="transportadora.razao_social">Nome</th>
                                    <th>Selecionar</th>
                                    </thead>
                                    <tr ng-repeat="trans in transportadoras.elementos">
                                        <th>{{trans[0].codigo}}</th>
                                        <th>{{trans[0].razao_social}}</th>
                                        <th><button class="btn btn-success" ng-click="setTransportadora(trans[0])"><i class="fa fa-info"></i></button></th>
                                    </tr> 
                                </table>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item" ng-click="transportadoras.prev()"><a class="page-link" href="">Anterior</a></li>
                                            <li class="page-item" ng-repeat="pg in transportadoras.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></li>
                                            <li class="page-item" ng-click="transportadoras.next()"><a class="page-link" href="">Próximo</a></li>
                                        </ul>
                                    </nav>
                                </div>

                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content PRODUTOS --> 
                <div class="modal fade" id="produtos" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-box fa-3x"></i>&nbsp;&nbsp;&nbsp;Seleção de produtos</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control col-md-8" id="filtroProdutos" placeholder="Filtro">
                                <hr>
                                <table class="table table-striped table-bordered first">
                                    <thead>
                                    <th data-ordem="produto.codigo">Cod.</th>
                                    <th data-ordem="produto.nome">Produto</th>
                                    <th data-ordem="produto.disponivel">Disponivel</th>
                                    <th data-ordem="produto.valor_base">Valor</th>
                                    <th>Selecionar</th>
                                    </thead>
                                    <tr ng-repeat="produt in produtos.elementos">
                                        <th>{{produt[0].codigo}}</th>
                                        <th>{{produt[0].nome}}</th>
                                        <th>{{produt[0].disponivel}}</th>
                                        <th>{{produt[0].valor_base}}</th>
                                        <th><button class="btn btn-success" ng-click="setProduto(produt[0])" data-target="#demo{{produt[0].id}}" data-toggle="collapse" class="accordion-toggle"><i class="fa fa-info"></i></button></th>
                                    </tr>
                                </table>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item" ng-click="produtos.prev()"><a class="page-link" href="">Anterior</a></li>
                                            <li class="page-item" ng-repeat="pg in produtos.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></li>
                                            <li class="page-item" ng-click="produtos.next()"><a class="page-link" href="">Próximo</a></li>
                                        </ul>
                                    </nav>
                                </div>

                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>




                <!-- /.modal-content ADDPRODUTO --> 
                <div class="modal fade" id="addproduto" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fa fa-fw fa-shopping-basket fa-3x"></i>&nbsp;&nbsp;&nbsp;Adicione o produto em seu pedido.</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <div id="custom-search" class="top-search-bar" style="padding-top:0px;padding-bottom:15px">
                                    <div class="form-group">
                                        <div class="icon-addon addon-sm">
                                            <input class="form-control" type="search" placeholder="Digite o que procura" aria-label="Search" size="80%">
                                            <label for="email" class="fa fa-search" rel="tooltip" title="email"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <table class="table table-striped" style="margin-bottom: 10px;">
                                        <thead>
                                            <tr style="border-top: 0px solid red;">

                                                <th colspan="2">Produto</th>
                                                <th class="text-center">Qtd.Est.</th>
                                                <th class="right">Preço</th>
                                                <th class="right"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>

                                                <td class="center" width="100px"><img src="http://www.faunasystem.com.br:8080/rtc/ENVIDOR-FRC-400ML.png" style="width: 80%;" class="product-image"></td>
                                                <td class="left">
                                                    <h3 class="product-title">Envidor (Frc 400ml)</h3>
                                                    <span class="product-val">val. 30 / 09 / 2021</span><br>
                                                    <span class="product-quant">1 p/ caixa</span>
                                                </td>
                                                <td class="text-center">4</td>
                                                <td class="right">R$ 116.99</td>
                                                <td class="text-center product">
                                                    <a href="#" class="btn btn-primary btnaddprod" title=""><i class="fas fa-plus-circle"></i></a>
                                                </td>
                                            </tr>
                                            <tr>

                                                <td class="center" width="100px"><img src="http://www.faunasystem.com.br:8080/rtc/ridomilgold1kg.png" style="width: 80%;" class="product-image"></td>
                                                <td class="left">
                                                    <h3 class="product-title">Ridomil Gold MZ (Pct 1kg)</h3>
                                                    <span class="product-val">val. 30 / 09 / 2021</span><br>
                                                    <span class="product-quant">1 p/ caixa</span>
                                                </td>
                                                <td class="text-center">4</td>
                                                <td class="right">R$ 116.99</td>
                                                <td class="text-center product">
                                                    <a href="#" class="btn btn-primary btnaddprod" title=""><i class="fas fa-plus-circle"></i></a>
                                                </td>
                                            </tr>
                                            <tr>

                                                <td class="center" width="100px"><img src="http://www.faunasystem.com.br:8080/rtc/ENVIDOR-FRC-400ML.png" style="width: 80%;" class="product-image"></td>
                                                <td class="left">
                                                    <h3 class="product-title">Envidor (Frc 400ml)</h3>
                                                    <span class="product-val">val. 30 / 09 / 2021</span><br>
                                                    <span class="product-quant">1 p/ caixa</span>
                                                </td>
                                                <td class="text-center">4</td>
                                                <td class="right">R$ 116.99</td>
                                                <td class="text-center product">
                                                    <a href="#" class="btn btn-primary btnaddprod" title=""><i class="fas fa-plus-circle"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Fechar</button>
                            </div>
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