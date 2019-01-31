<!doctype html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
        <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/libs/css/style.css">
        <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/dataTables.bootstrap4.css">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/buttons.bootstrap4.css">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/select.bootstrap4.css">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/fixedHeader.bootstrap4.css">
        <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">-->
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
            <div class="dashboard-header">
                <nav class="navbar navbar-expand-lg bg-white fixed-top">
                    <a class="navbar-brand" href="index.html"><img style="" src="assets/images/logo.png" alt="" title=""></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse " id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto navbar-right-top">
                            <li class="nav-item">
                                <div id="custom-search" class="top-search-bar">
                                    <div class="form-group">
                                        <div class="icon-addon addon-sm">
                                            <input class="form-control" type="search" placeholder="Digite o que procura" aria-label="Search" size="80%">
                                            <label for="email" class="fa fa-search" rel="tooltip" title="email"></label>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown notification">
                                <a class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-shopping-cart fa-bell"></i></a>
                                <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                                    <li>
                                        <div class="notification-title">Carrinho de Compras<span class="badge badge-primary badge-pill m-l-20">3</span></div>
                                        <div class="notification-list">
                                            <div class="list-group">

                                                <a href="#" class="list-group-item list-group-item-action active">
                                                    <div class="notification-info">
                                                        <div class="notification-list-user-img"><img src="http://www.faunasystem.com.br:8080/rtc/SUPPORT-GL-5L.png" alt="" class="user-avatar-xl"></div>
                                                        <div class="notification-list-user-img m-l-20"><span class="notification-list-user-name">Support (Gl 5L)</span>.
                                                            <div class="notification-date">Qtd p/ caixa: 4</div>
                                                            <div class="notification-date">Valor: R$ 79.93</div>
                                                            <div class="notification-date">Qtd:&nbsp;<input id="inputText4" type="number" class="form-control form-control-xs" placeholder="5" min="1" max="5"></div>
                                                            <div class="notification-date">SubTotal: R$ 319.72</div>
                                                        </div>	
                                                        <div class="notification-list-user-img m-l-25 product"><button class="btn btn-outline-light btn-sm"><i class="fa fa-times"></i></button></div>	

                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action active">
                                                    <div class="notification-info">
                                                        <div class="notification-list-user-img"><img src="http://www.faunasystem.com.br:8080/rtc/SUPPORT-GL-5L.png" alt="" class="user-avatar-xl"></div>
                                                        <div class="notification-list-user-img m-l-20"><span class="notification-list-user-name">Support (Gl 5L)</span>.
                                                            <div class="notification-date">Qtd p/ caixa: 4</div>
                                                            <div class="notification-date">Valor: R$ 79.93</div>
                                                            <div class="notification-date">Qtd:&nbsp;<input id="inputText4" type="number" class="form-control form-control-xs" placeholder="5" min="1" max="5"></div>
                                                            <div class="notification-date">SubTotal: R$ 319.72</div>
                                                        </div>	
                                                        <div class="notification-list-user-img m-l-25 product"><button class="btn btn-outline-light btn-sm"><i class="fa fa-times"></i></button></div>	

                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action active">
                                                    <div class="notification-info">
                                                        <div class="notification-list-user-img"><img src="http://www.faunasystem.com.br:8080/rtc/SUPPORT-GL-5L.png" alt="" class="user-avatar-xl"></div>
                                                        <div class="notification-list-user-img m-l-20"><span class="notification-list-user-name">Support (Gl 5L)</span>.
                                                            <div class="notification-date">Qtd p/ caixa: 4</div>
                                                            <div class="notification-date">Valor: R$ 79.93</div>
                                                            <div class="notification-date">Qtd:&nbsp;<input id="inputText4" type="number" class="form-control form-control-xs" placeholder="5" min="1" max="5"></div>
                                                            <div class="notification-date">SubTotal: R$ 319.72</div>
                                                        </div>	
                                                        <div class="notification-list-user-img m-l-25 product"><button class="btn btn-outline-light btn-sm"><i class="fa fa-times"></i></button></div>	

                                                    </div>
                                                </a>


                                            </div>

                                        </div>
                                    </li>
                                    <li>
                                        <div class="list-footer"> <a href="carrinho-de-compras.html">Finalizar Compra</a></div>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown notification">
                                <a class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="far fa-fw fa-comments"></i></span></a>
                                <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                                    <li>
                                        <div class="notification-title bg-primary"> Chat <i class="far fa-comments m-l-10"></i></div>
                                        <div class="notification-list">
                                            <div class="list-group">
                                                <a href="#" class="list-group-item list-group-item-action bg-chat-pardal">
                                                    <div class="notification-info">
                                                        <div class="notification-list-user-img"><img src="assets/images/avatar-2.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                        <div class="notification-list-user-block"><span class="notification-list-user-name">Pardal:</span>Quer fazer uma simulação preços com produtos que tenham algum ativo, ou cultura?
                                                            <div class="notification-date">2 min ago</div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <div class="notification-info">
                                                        <div class="notification-list-user-img"><img src="assets/images/avatar-1.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                        <div class="notification-list-user-block"><span class="notification-list-user-name">Você:</span>teste
                                                            <div class="notification-date">2 days ago</div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action bg-chat-pardal">
                                                    <div class="notification-info">
                                                        <div class="notification-list-user-img"><img src="assets/images/avatar-2.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                        <div class="notification-list-user-block"><span class="notification-list-user-name">Pardal:</span> Como posso ajudá-lo? Serei seu vendedor virtual!
                                                            <div class="notification-date text-right">2 min ago</div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <div class="notification-info">
                                                        <div class="notification-list-user-img"><img src="assets/images/avatar-1.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                        <div class="notification-list-user-block"><span class="notification-list-user-name">Você:</span>teste
                                                            <div class="notification-date">2 days ago</div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action bg-chat-pardal">
                                                    <div class="notification-info">
                                                        <div class="notification-list-user-img"><img src="assets/images/avatar-2.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                        <div class="notification-list-user-block"><span class="notification-list-user-name">Pardal: </span>Sou o Pardal!! Não sou professor, mas inventei o RTC para atendê-lo!
                                                            <div class="notification-date">2 min ago</div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                        </div>
                                    </li>
                                    <li>
                                        <div class="list-footer bg-light"> 
                                            <form class="form-inline justify-content-center">
                                                <div class="form-group mx-sm-3 mb-2">
                                                    <input type="text" class="form-control" style="width: 100%" placeholder="Digite sua mensagem" id="txtFala">
                                                </div>	
                                                <button class="btn btn-sm btn-primary mb-2">Enviar</button>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown notification">
                                <a class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-bell"></i> <span class="indicator"></span></a>
                                <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                                    <li>
                                        <div class="notification-title"> Notification</div>
                                        <div class="notification-list">
                                            <div class="list-group">
                                                <a href="#" class="list-group-item list-group-item-action active">
                                                    <div class="notification-info">
                                                        <div class="notification-list-user-img"><img src="assets/images/avatar-2.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                        <div class="notification-list-user-block"><span class="notification-list-user-name">Jeremy Rakestraw</span>accepted your invitation to join the team.
                                                            <div class="notification-date">2 min ago</div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <div class="notification-info">
                                                        <div class="notification-list-user-img"><img src="assets/images/avatar-3.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                        <div class="notification-list-user-block"><span class="notification-list-user-name">John Abraham </span>is now following you
                                                            <div class="notification-date">2 days ago</div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <div class="notification-info">
                                                        <div class="notification-list-user-img"><img src="assets/images/avatar-4.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                        <div class="notification-list-user-block"><span class="notification-list-user-name">Monaan Pechi</span> is watching your main repository
                                                            <div class="notification-date">2 min ago</div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <div class="notification-info">
                                                        <div class="notification-list-user-img"><img src="assets/images/avatar-5.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                        <div class="notification-list-user-block"><span class="notification-list-user-name">Jessica Caruso</span>accepted your invitation to join the team.
                                                            <div class="notification-date">2 min ago</div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="list-footer"> <a href="#">View all notifications</a></div>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown nav-user">
                                <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="assets/images/avatar-1.jpg" alt="" class="user-avatar-md rounded-circle">
                                    <span class="hidden-xs">Andre Sbrana</span>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                    <div class="nav-user-info clearfix align-middle">
                                        <div class="float-left m-r-10 m-t-5">
                                            <img src="assets/images/avatar-1.jpg" alt="" class="user-avatar-md rounded-circle ">
                                        </div>
                                        <div class="float-left">									
                                            <h5 class="mb-0 text-white nav-user-name">Andre Sbrana </h5>
                                            <span class="status"></span><span class="ml-2">webdesigner</span>
                                        </div>	
                                    </div>
                                    <a class="dropdown-item" href="colaboradores.html"><i class="fas fa-user mr-2"></i>Colaboradores</a>
                                    <a class="dropdown-item" href="alteracao-do-logo.html"><i class="fas fa-font mr-2"></i>Alterar Logo</a>
                                    <a class="dropdown-item" href="cadastro-empresas-filiais.html"><i class="fas fa-file-alt mr-2"></i>Empresas / Filiais</a>
                                    <a class="dropdown-item" href="configuracao-da-empresa.html"><i class="fas fa-cog mr-2"></i>Configuração da empresa</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-power-off mr-2"></i>Sair</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
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
                                    <h2 class="pageheader-title">Pedidos de Venda</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Pedidos</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Pedidos de Venda</li>
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
                                                <a href="#" class="btn btn-primary" data-title="AddCompra" data-toggle="modal" data-target="#addCompra" ><i class="fas fa-plus-circle m-r-10"></i>Cadastrar Pedido de Venda</a>
                                            </div>
                                            <hr><br>
                                            <table id="pedidos" class="table table-striped table-bordered first">
                                                <thead>
                                                    <tr>
                                                        <th>Cod.</th>
                                                        <th>Cliente</th>
                                                        <th>Data</th>
                                                        <th>frete</th>
                                                        <th>Tipo</th>
                                                        <th>Status</th>
                                                        <th>Vendedor</th>
                                                        <th>Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>5395</td>
                                                        <td>AgroFauna Filial17</td>
                                                        <td>15 / 01 / 2019</td>
                                                        <td>0.0</td>
                                                        <td>Entrada</td>
                                                        <td>Iniciado</td>
                                                        <td>2 - ELIAS</td>
                                                        <th>
                                                            <div class="product-btn">
                                                                <a href="#" class="btn btn-outline-light btnvis" data-title="vizPedido" data-toggle="modal" data-target="#vizPedido"><i class="fas fa-eye"></i></a>
                                                                <a href="#" class="btn btn-outline-light btnedit" data-title="Edit" data-toggle="modal" data-target="#editCompra"><i class="fas fa-pencil-alt"></i></a>
                                                                <a href="#" class="btn btn-outline-light btndel" data-title="Delete" data-toggle="modal" data-target="#delete"><i class="fas fa-trash-alt"></i></a>
                                                            </div>
                                                        </th>
                                                    </tr>

                                                    <tr>
                                                        <td>1550</td>
                                                        <td>Brasil Agro Comercio de Insumos Ltda</td>
                                                        <td>04 / 09 / 2017</td>
                                                        <td>0.0</td>
                                                        <td>Saida</td>
                                                        <td>Finalizado</td>
                                                        <td>22-CRISTINIS</td>
                                                        <th>
                                                            <div class="product-btn">
                                                                <a href="#" class="btn btn-outline-light btnvis" data-title="vizPedido" data-toggle="modal" data-target="#vizPedido"><i class="fas fa-eye"></i></a>
                                                                <a href="#" class="btn btn-outline-light btnedit" data-title="Edit" data-toggle="modal" data-target="#editCompra"><i class="fas fa-pencil-alt"></i></a>
                                                                <a href="#" class="btn btn-outline-light btndel" data-title="Delete" data-toggle="modal" data-target="#delete"><i class="fas fa-trash-alt"></i></a>
                                                            </div>
                                                        </th>
                                                    </tr>

                                                    <tr>
                                                        <td>4117</td>
                                                        <td>AgroFauna Filial17</td>
                                                        <td>10 / 10 / 2018</td>
                                                        <td>0.0</td>
                                                        <td>Entrada</td>
                                                        <td>Encomenda</td>
                                                        <td>CPD</td>
                                                        <th>
                                                            <div class="product-btn">
                                                                <a href="#" class="btn btn-outline-light btnvis" data-title="vizPedido" data-toggle="modal" data-target="#vizPedido" ><i class="fas fa-eye"></i></a>
                                                                <a href="#" class="btn btn-outline-light btnedit" data-title="Edit" data-toggle="modal" data-target="#editCompra"><i class="fas fa-pencil-alt"></i></a>
                                                                <a href="#" class="btn btn-outline-light btndel" data-title="Delete" data-toggle="modal" data-target="#delete"><i class="fas fa-trash-alt"></i></a>
                                                            </div>
                                                        </th>
                                                    </tr>

                                                <tfoot>
                                                    <tr>
                                                        <th>Cod.</th>
                                                        <th>Cliente</th>
                                                        <th>Data</th>
                                                        <th>frete</th>
                                                        <th>Tipo</th>
                                                        <th>Status</th>
                                                        <th>Vendedor</th>
                                                        <th>Ação</th>
                                                    </tr>
                                                </tfoot>
                                            </table>

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




                <!-- /.modal-content ADD COMPRA --> 
                <div class="modal fade in" id="addCompra" tabindex="-1" role="dialog" aria-labelledby="addCompra" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-plus-circle fa-3x"></i>&nbsp;&nbsp;&nbsp;Adicione os dados de seu Pedido de Venda</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label for="">Cliente</label>
                                        <div class="form-row">
                                            <div class="col-2">
                                                <input type="text" class="form-control" placeholder="Cod." disabled>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" placeholder="Digite para pesquisar o nome do Cliente">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label for="">Transportadora</label>
                                        <div class="form-row">
                                            <div class="col-2">
                                                <input type="text" class="form-control" placeholder="Cod." disabled>
                                            </div>
                                            <div class="col-6">
                                                <input type="text" class="form-control" placeholder="Digite para pesquisar o nome da Transportadora">
                                            </div>
                                            <div class="form-inline col-4">
                                                <label for="" style="margin-left: 25px;margin-right: 10px;">Frete R$</label>
                                                <input type="text" class="form-control col-3" placeholder="0.0">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="">Redespacho</label>
                                                <div class="form-row">
                                                    <div class="col-2">
                                                        <input type="text" class="form-control" placeholder="Cod." disabled>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="text" class="form-control" placeholder="Digite o nome da Transportadora">
                                                    </div>
                                                    <div class="form-inline col-4">
                                                        <label for="" style="margin-left: 5px;margin-right: 10px;">Frete R$</label>
                                                        <input type="text" class="form-control col-5" placeholder="0.0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <label for="">Observações</label>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <textarea class="form-control" rows="2" id="comment"></textarea>
                                                    </div>
                                                </div>

                                            </div>			
                                        </div>
                                    </div>
                                    <hr>
                                    <br>
                                    <label for="">Produtos</label>
                                    <table id="" class="table table-striped" width="90%">
                                        <thead>
                                            <tr>
                                                <th>Cod</th>
                                                <th>Nome</th>
                                                <th>Qtd.</th>
                                                <th>Qtd. Cx</th>
                                                <th>Vl.base</th>
                                                <th>Juros</th>
                                                <th>Frete</th>
                                                <th>Icms</th>
                                                <th>Valor</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
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
                                                <td>
                                                    <div class="product-btn">
                                                        <a href="#" class="btn btn-outline-light btnaddprod" data-title="addproduto" data-toggle="modal" data-target="#addproduto"><i class="fas fa-plus-circle"></i></a>
                                                    </div>
                                                </td>

                                            </tr>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="7" style="text-align:right;">VALOR TOTAL</th>
                                                <th colspan="3">R$ 0.00</th>
                                            </tr>
                                        </tfoot>		
                                    </table>
                                    <hr>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="form-inline col-1">
                                                <label for="">Frete</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline" style="margin-top: 5px;">
                                                <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input">
                                                <label class="custom-control-label" for="customRadioInline1">CIF</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline" style="margin-top: 5px;">
                                                <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input">
                                                <label class="custom-control-label" for="customRadioInline2">FOB</label>
                                            </div>
                                            <div class="form-inline col-3" style="margin-left: 40px;">
                                                <a href="#" class="btn btn-primary" data-title="calcFrete" data-toggle="modal" data-target="#calcFrete">Calcular Frete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="form-inline" style="margin-right: 20px;">
                                                <label for="">Forma de pagamento</label>
                                            </div>
                                            <div class="form-inline">
                                                <label for="" style="margin-left: 25px;margin-right: 10px;">Prazo:</label>
                                                <input type="number" class="form-control col-5" placeholder="5" min="0" max="90">
                                            </div>
                                            <div class="form-inline">
                                                <label for="" style="margin-left: 25px;margin-right: 10px;">Parcelas:</label>
                                                <input type="number" class="form-control col-5" placeholder="1" min="0" max="90">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="form-inline col-12">
                                                <label for="" style="margin-right: 20px;">Status</label>
                                                <select class="form-control col-7" id="status">    
                                                    <option value="1">Iniciado</option>
                                                    <option value="2">Confirmação de pagamento</option>
                                                    <option value="3">Separação</option>
                                                    <option value="4">Solicitação de coleta</option>
                                                    <option value="5">Rastreio</option>
                                                    <option value="6">Finalizado</option>
                                                    <option value="7">Cancelado</option>
                                                    <option value="8">Aguardando Pedido de Compra</option>
                                                    <option value="9">Encomenda</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>					
                                </form>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-save"></i> &nbsp; Salvar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->

                <!-- /.modal-content EDIT --> 
                <div class="modal fade in" id="editCompra" tabindex="-1" role="dialog" aria-labelledby="editCompra" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-pencil-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Edite os dados de seu Pedido de Venda</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label for="">Cliente</label>
                                        <div class="form-row">
                                            <div class="col-2">
                                                <input type="text" class="form-control" placeholder="Cod." value="9" disabled>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" placeholder="Digite para pesquisar o nome do Cliente" value="AgroFauna Filial17">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label for="">Transportadora</label>
                                        <div class="form-row">
                                            <div class="col-2">
                                                <input type="text" class="form-control" placeholder="Cod." value="4917" disabled>
                                            </div>
                                            <div class="col-6">
                                                <input type="text" class="form-control" placeholder="Digite para pesquisar o nome da Transportadora" value="Alfa Transportes Ltda">
                                            </div>
                                            <div class="form-inline col-4">
                                                <label for="" style="margin-left: 25px;margin-right: 10px;">Frete R$</label>
                                                <input type="text" class="form-control col-3" placeholder="0.0" value="108.1">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="">Redespacho</label>
                                                <div class="form-row">
                                                    <div class="col-2">
                                                        <input type="text" class="form-control" placeholder="Cod." disabled>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="text" class="form-control" placeholder="Digite o nome da Transportadora">
                                                    </div>
                                                    <div class="form-inline col-4">
                                                        <label for="" style="margin-left: 5px;margin-right: 10px;">Frete R$</label>
                                                        <input type="text" class="form-control col-5" placeholder="0.0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <label for="">Observações</label>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <textarea class="form-control" rows="2" id="comment">Pedido RTC Web</textarea>
                                                    </div>
                                                </div>

                                            </div>			
                                        </div>
                                    </div>
                                    <hr>
                                    <br>
                                    <label for="">Produtos</label>
                                    <table id="" class="table table-striped" width="90%">
                                        <thead>
                                            <tr>
                                                <th>Cod</th>
                                                <th>Nome</th>
                                                <th>Qtd.</th>
                                                <th class="text-center">Qtd. Cx</th>
                                                <th class="text-center">Vl.base</th>
                                                <th class="text-center">Juros</th>
                                                <th class="text-center">Frete</th>
                                                <th class="text-center">Icms</th>
                                                <th class="text-center">Valor</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>37385</td>
                                                <td>Tordon (Gl 5L)</td>
                                                <td class="text-center" width="100px"><input id="inputText4" type="number" class="form-control" placeholder="5" min="1" value="24"></td>
                                                <td class="text-center">4.0</td>
                                                <td class="text-center">158.72</td>
                                                <td class="text-center">0.0</td>
                                                <td class="text-center">0.0</td>
                                                <td class="text-center">0.0</td>
                                                <td class="text-center">158.72</td>
                                                <td >
                                                    <div class="product-btn">
                                                        <a href="#" class="btn btn-outline-light btndel"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>

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
                                                <td>
                                                    <div class="product-btn">
                                                        <a href="#" class="btn btn-outline-light btnaddprod" data-title="addproduto" data-toggle="modal" data-target="#addproduto"><i class="fas fa-plus-circle"></i></a>
                                                    </div>
                                                </td>

                                            </tr>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="7" style="text-align:right;">VALOR TOTAL</th>
                                                <th colspan="3">R$ 3809,38</th>
                                            </tr>
                                        </tfoot>		
                                    </table>
                                    <hr>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="form-inline col-1">
                                                <label for="">Frete</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline" style="margin-top: 5px;">
                                                <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input" checked>
                                                <label class="custom-control-label" for="customRadioInline1">CIF</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline" style="margin-top: 5px;">
                                                <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input">
                                                <label class="custom-control-label" for="customRadioInline2">FOB</label>
                                            </div>
                                            <div class="form-inline col-3" style="margin-left: 40px;">
                                                <a href="#" class="btn btn-primary" data-title="calcFrete" data-toggle="modal" data-target="#calcFrete">Calcular Frete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="form-inline" style="margin-right: 20px;">
                                                <label for="">Forma de pagamento</label>
                                            </div>
                                            <div class="form-inline">
                                                <label for="" style="margin-left: 25px;margin-right: 10px;">Prazo:</label>
                                                <input type="number" class="form-control col-5" placeholder="5" min="0" max="90" value="0">
                                            </div>
                                            <div class="form-inline">
                                                <label for="" style="margin-left: 25px;margin-right: 10px;">Parcelas:</label>
                                                <input type="number" class="form-control col-5" placeholder="1" min="0" max="90" value="1">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="form-inline col-12">
                                                <label for="" style="margin-right: 20px;">Status</label>
                                                <select class="form-control col-7" id="status">    
                                                    <option value="1" selected>Iniciado</option>
                                                    <option value="2">Confirmação de pagamento</option>
                                                    <option value="3">Separação</option>
                                                    <option value="4">Solicitação de coleta</option>
                                                    <option value="5">Rastreio</option>
                                                    <option value="6">Finalizado</option>
                                                    <option value="7">Cancelado</option>
                                                    <option value="8">Aguardando Pedido de Compra</option>
                                                    <option value="9">Encomenda</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>					
                                </form>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                                <button class="btn btn-primary" type="submit">
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
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-trash-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Delete os dados de seu Pedido</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center"> Tem certeza de que deseja excluir este Pedido?</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" onclick="cadastrarProduto()">Sim</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Não</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content --> 

                <!-- /.modal-content VISUALIZAR PEDIDO --> 
                <div class="modal fade" id="vizPedido" tabindex="-1" role="dialog" aria-labelledby="vizPedido" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-eye fa-3x"></i>&nbsp;&nbsp;&nbsp;Vizualizando Pedido</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body text-center">
                                <iframe id="myIframe" name="myIframe" frameborder="1" width="100%" height="300px" src="visualizar-pedido-print.php"></iframe>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content --> 




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
                <!-- /.modal-content --> 

                <!-- /.modal-content CALCFRETE --> 
                <div class="modal fade" id="calcFrete" tabindex="-1" role="dialog" aria-labelledby="calcFrete" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fa fa-fw fa-truck fa-3x"></i>&nbsp;&nbsp;&nbsp;Escolha o Frete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="custom-control custom-radio custom-control-inline" style="margin-top: 5px;">
                                            <input type="radio" id="customRadioInline3" name="customRadioInline1" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadioInline3">R$ 55.00 - transmudanças S ds ltda</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline" style="margin-top: 5px;">
                                            <input type="radio" id="customRadioInline4" name="customRadioInline1" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadioInline4">R$ 95.06 - rodonasa cargas e encomendas ltda me</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline" style="margin-top: 5px;">
                                            <input type="radio" id="customRadioInline5" name="customRadioInline1" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadioInline5">R$ 97.90 - transville transportes e servicos ltda</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline" style="margin-top: 5px;">
                                            <input type="radio" id="customRadioInline6" name="customRadioInline1" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadioInline6">R$ 79.57 - alfa transportes eireli</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline" style="margin-top: 5px;">
                                            <input type="radio" id="customRadioInline7" name="customRadioInline1" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadioInline7">R$ 147.54 - hb transportes e logistica ltda</label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->


                <!-- jquery 3.3.1 -->
                <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
                <script src="assets/vendor/jquery/jquery.mask.min.js"></script>
                <script src="assets/libs/js/form-mask.js"></script>

                <!-- bootstap bundle js -->
                <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
                <!-- datatables js -->
                <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
                <script src="assets/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
                <script src="../../../../../cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
                <script src="assets/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
                <script src="assets/vendor/datatables/js/data-table.js"></script>

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
                                        $('.btnvis').tooltip({title: "Visualizar", placement: "top"});
                                        $('.btnedit').tooltip({title: "Editar", placement: "top"});
                                        $('.btndel').tooltip({title: "Deletar", placement: "top"});
                                        $('.btnaddprod').tooltip({title: "Adicionar", placement: "top"});
                                    });
                                    $(document).ready(function () {
                                        $('#pedidos').DataTable({
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