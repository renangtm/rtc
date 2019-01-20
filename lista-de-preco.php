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
	<style>
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
                                <h2 class="pageheader-title">Lista de Preço</h2>
                                <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">      
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Lista de Preço</li>
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
                                    <table id="lista-de-preco" class="table table-striped table-bordered first">
                                        <thead>
                                            <tr>
													<th>Cod.</th>
													<th>Nome</th>
													<th>Estoque</th>
													<th>Disponível</th>
													<th>Transito</th>
													<th>Ativo</th>
													<th>Valor</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>37218</td>
													<td>Skip 125 SC (Gl 10L)</td>
													<td>0</td>
													<td>0</td>
													<td>0</td>
													<td></td>
													<td>198.98</td>
													<th>
														<div class="product-btn">
															<a href="#" class="btn btn-outline-light" data-title="info" data-toggle="modal" data-target="#info" ><i class="fas fa-info-circle m-r-10"></i>mais informação</a>
														</div>
													</th>
												</tr>
												<tr>
													<td>37219</td>
													<td>Hostathion 400 BR (Frc 1L)</td>
													<td>0</td>
													<td>0</td>
													<td>0</td>
													<td>TRIAZOPHOS</td>
													<td>63.91</td>
													<th>
														<div class="product-btn">
															<a href="#" class="btn btn-outline-light" data-title="info" data-toggle="modal" data-target="#info" ><i class="fas fa-info-circle m-r-10"></i>mais informação</a>
														</div>
													</th>
												</tr>
												<tr>
													<td>37220</td>
													<td>Curacron 500 (Frc 1L)</td>
													<td>0</td>
													<td>0</td>
													<td>0</td>
													<td>PROFENOFOS 50%</td>
													<td>25.96</td>
													<th>
														<div class="product-btn">
															<a href="#" class="btn btn-outline-light" data-title="info" data-toggle="modal" data-target="#info" ><i class="fas fa-info-circle m-r-10"></i>mais informação</a>
														</div>
													</th>
												</tr>
												<tr>
													<td>37221</td>
													<td>Danimen 300 EC (Frc 1L)</td>
													<td>144</td>
													<td>84</td>
													<td>0</td>
													<td>(FENOPROPATHRIN)</td>
													<td>120.04</td>
													<th>
														<div class="product-btn">
															<a href="#" class="btn btn-outline-light" data-title="info" data-toggle="modal" data-target="#info" ><i class="fas fa-info-circle m-r-10"></i>mais informação</a>
														</div>
													</th>
												</tr>
												<tr>
													<td>37222</td>
													<td>Agritoato 400 (Frc 1L)</td>
													<td>2592</td>
													<td>2490</td>
													<td>48</td>
													<td>(DIMETHOATE)</td>
													<td>27.24</td>
													<th>
														<div class="product-btn">
															<a href="#" class="btn btn-outline-light" data-title="info" data-toggle="modal" data-target="#info" ><i class="fas fa-info-circle m-r-10"></i>mais informação</a>
														</div>
													</th>
												</tr>
												<tr>
													<td>37223</td>
													<td>Dimexion (Frc 1L)</td>
													<td>0</td>
													<td>0</td>
													<td>0</td>
													<td>DIMETHOATE</td>
													<td>25.54</td>
													<th>
														<div class="product-btn">
															<a href="#" class="btn btn-outline-light" data-title="info" data-toggle="modal" data-target="#info" ><i class="fas fa-info-circle m-r-10"></i>mais informação</a>
														</div>
													</th>
												</tr>
											</tbody>
											<tfoot>
												<tr>
													<th>Cod.</th>
													<th>Nome</th>
													<th>Estoque</th>
													<th>Disponível</th>
													<th>Transito</th>
													<th>Ativo</th>
													<th>Valor</th>
													<th></th>
												</tr>
											</tfoot>
										</table>
							
									
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

   <!-- /.modal-content INFO --> 
    <div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="info" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-info-circle fa-3x"></i>&nbsp;&nbsp;&nbsp;Mais informação do produto</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
				<div class="modal-body">
					<table id="" class="table table-striped">
                                        <thead>
                                            <tr>
													<th>Cod.</th>
													<th>Nome</th>
													<th>Estoque</th>
													<th>Disponível</th>
													<th>Transito</th>
													<th>Ativo</th>
													<th>Valor</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>37218</td>
													<td>Skip 125 SC (Gl 10L)</td>
													<td>0</td>
													<td>0</td>
													<td>0</td>
													<td></td>
													<td>198.98</td>
												</tr>
											</table>
											
											<table id="" class="table table-striped m-t-30">
                                        <thead>
                                            <tr>
													<th>Cultura</th>
													<th>Praga</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>sit amet consectetur adipiscing elit</td>
													<td>sit amet consectetur adipiscing elit</td>

												</tr>
												<tr>
													<td>sit amet consectetur adipiscing elit</td>
													<td>sit amet consectetur adipiscing elit</td>

												</tr>
												<tr>
													<td>sit amet consectetur adipiscing elit</td>
													<td>sit amet consectetur adipiscing elit</td>

												</tr>
											</table>
				</div>
                <div class="modal-footer">
					  <button type="button" class="btn btn-light" data-dismiss="modal">Fechar</button>
                 </div>
			</div>
		</div>
	</div>
	<!-- /.modal-content --> 	
	

    <!-- jquery 3.3.1 -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
	<!-- datatables js -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../../../../cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="assets/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/vendor/datatables/js/data-table.js"></script>
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
	
	<!-- Optional JavaScript -->
	<script>
		$(document).ready(function() {
			$('#lista-de-preco').DataTable( {
				"language":{ //Altera o idioma do DataTable para o português do Brasil
				"url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
				},
			} );
		} );
	</script>
	
</body>
 
</html>