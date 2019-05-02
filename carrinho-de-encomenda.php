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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
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
                                    <div class="notification-title"> Notificação</div>
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
                                <h2 class="pageheader-title">Seu carrinho de Encomendas</h2>
                                <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Seu carrinho de Encomendas</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
					
					<!-- ============================================================== -->
                    <!-- carrinho  -->
                    <!-- ============================================================== -->
					<div class="card">
						<div class="card-body">
							<div class="alert alert-warning" role="alert"><strong>OBS:</strong> Valores aproximados, por se tratar de uma encomenda, sujeito a variação.</div>
								<div class="table-responsive-sm">
                                        <table class="table table-striped" style="margin-bottom: 10px;">
                                            <thead>
                                                <tr style="border-top: 0px solid red;">
                                                    <th class="center">#</th>
                                                    <th colspan="2">Produto</th>
													<th class="text-center">Quantidade<br> por caixa</th>
                                                    <th class="right">Valor</th>
                                                    <th class="text-center">Quantidade</th>
                                                    <th class="right">Total</th>
													<th class="right"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">1</td>
                                                    <td class="center" width="10%"><img src="assets/images/fotoestilizada.png" class="product-image"></td>
                                                    <td class="left">Siptroil (Gl 5L)</td>
													<td class="text-center">4</td>
                                                    <td class="right">R$ 90.73 ate 99.80</td>
                                                    <td class="text-center"><input id="inputText4" type="number" class="form-control" placeholder="8" min="1" max="5"></td>
                                                    <td class="right">R$ 725.84 ate 798.42</td>
													<td class="text-center product">
														<button type="button" class="btn remove-product btn-sm" data-toggle="tooltip" data-placement="top" title="deletar o produto">
																<i class="fa fa-times"></i>
														</button>
													</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">2</td>
                                                    <td class="center" width="10%"><img src="http://www.tratordecompras.com.br/renew/Status_3/php/uploads/arquivo_15433442644327.png" class="product-image"></td>
                                                    <td class="left">123 123 123</td>
													<td class="text-center">1</td>
                                                    <td class="right">R$ 123.00 ate 135.30</td>
                                                    <td class="text-center"><input id="inputText4" type="number" class="form-control" placeholder="5" min="1" max="5"></td>
                                                    <td class="right">R$ 615.00 ate 676.50</td>
													<td class="text-center product">
														<button type="button" class="btn remove-product btn-sm">
																<i class="fa fa-times"></i>
														</button>
													</td>
                                                </tr>
												<tr>
                                                    <td class="text-center">3</td>
                                                    <td class="center" width="10%"><img src="http://www.tratordecompras.com.br/renew/Status_3/php/uploads/arquivo_15433442644327.png" class="product-image"></td>
                                                    <td class="left">123 123 123</td>
													<td class="text-center">5</td>
                                                    <td class="right">R$ 123.00 ate 135.30</td>
                                                    <td class="text-center"><input id="inputText4" type="number" class="form-control" placeholder="5" min="1" max="5"></td>
                                                    <td class="right">R$  615.00 ate 676.50</td>
													<td class="text-center product">
														<button type="button" class="btn remove-product btn-sm">
																<i class="fa fa-times"></i>
														</button>
													</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
									<div class="row">
                                        <div class="col-lg-4 col-sm-4">
                                        </div>
                                        <div class="col-lg-8 col-sm-8 ml-auto">
                                            <table class="table table-clear">
                                                <tbody>
                                                    <tr>
                                                        <td class="left">
                                                            <strong class="text-dark">Subtotal</strong>
                                                        </td>
                                                        <td class="right">R$ 2009.60</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="left">
                                                            <strong class="text-dark">Frete</strong>
															<select class="form-control" id="fretes" style="margin-top:20px;height: 50px" onchange="r_elementos.tblProdutos.recarregar()">    
																<option value="0">transmudancas sds ltda, R$ 53.76</option>
																<option value="1">rodonasa cargas e encomendas ltda me, R$ 107.54</option>
																<option value="2">transville transportes e servicos ltda, R$ 99.58</option>
																<option value="3">alfa transportes eireli, R$ 84.15</option>
																<option value="4">hb transportes e logistica ltda, R$ 148.79</option>
																<option value="5">transortadora capivari ltda, R$ 230.11</option>
																<option value="6">modular transportes ltda, R$ 126.14</option>
															</select>
                                                        </td>
                                                        <td class="right" style="vertical-align: bottom;">R$ 2009.60</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="left">
                                                            <strong class="text-dark">Pagamento</strong>
															<select class="form-control" id="formaPagamento" style="margin-top:20px;height: 50px">    
																<option value="0">Antecipado</option>
																<option value="30">30 Dias</option>
																<option value="60">60 Dias</option>
																<option value="90">90 Dias</option>
															</select>
                                                        </td>
                                                        <td class="right" style="vertical-align: bottom;">R$ 2009.60</td>
                                                    </tr>
                                                    <tr style="font-size: 1.2rem;">
                                                        <td class="left">
                                                            <strong class="text-dark">Total</strong>
                                                        </td>
                                                        <td class="right">
                                                            <strong class="text-dark">R$ 2009.60</strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
										
                                    </div>
									<div class="col mb-2 m-t-40">
										<div class="row">
											<div class="col-sm-12  col-md-6">
												<button class="btn btn-lg btn-block btn-light" onclick="location.href='comprar.html';">Continuar Encomendando</button>
											</div>
											<div class="col-sm-12 col-md-6 text-right">
												<button class="btn btn-lg btn-block btn-primary text-uppercase">Finalizar Encomenda</button>
											</div>
										</div>
									</div>
								</div>
							</div>	
					<!-- ============================================================== -->
                    <!-- end carrinho  -->
                    <!-- ============================================================== -->			
					 
					 
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