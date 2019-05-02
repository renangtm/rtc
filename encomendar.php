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
                                <h2 class="pageheader-title">Encomendar</h2>
                                <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Encomendar</li>
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
                    <!-- banner  -->
                    <!-- ============================================================== -->
					<div class="row">
					<div class="col-xl-9 col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
								
									
										<div id="carouselExampleIndicators" class="product-carousel carousel slide m-b-40" data-ride="carousel">
											<ol class="carousel-indicators">
												<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
												<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
												<!--<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>-->
											</ol>
											<div class="carousel-inner">
												<div class="carousel-item active">
													<img class="d-block w-100" src="assets/images/banner_784x295.jpg" alt="First slide">
												</div>
												<div class="carousel-item">
													<img class="d-block w-100" src="assets/images/banner_784x295.jpg" alt="Second slide">
												</div>
												<!--
												<div class="carousel-item">
													<img class="d-block w-100" src="assets/images/card-img-3.jpg" alt="Third slide">
												</div>-->
											</div>
											<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
											  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
											   <span class="sr-only">Previous</span>  </a>
											<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
												<span class="carousel-control-next-icon" aria-hidden="true"></span>
													<span class="sr-only">Next</span>  </a>
										</div>
							
							</div>
					
					<!-- ============================================================== -->
                    <!-- end banner  -->
                    <!-- ============================================================== -->
							<!-- texto resultado -->
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="m-b-10">2461 produtos encontrados</div>
							</div>
		
                    
					
                                <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="product-thumbnail">
                                        <div class="product-img-head" style="background-color:#fff;">
                                            <div class="product-img">
                                                <img src="assets/images/fotoestilizada.png" alt="" class="img-fluid"></div>
                                            <div class="ribbons1">CUSTO ATUALIZADO</div>
											<!--<div class="ribbons-text m-l-10">CUSTO ATUALIZADO</div>-->
                                            
                                            <!--<div class=""><a href="#" class="product-wishlist-btn"><i class="fas fa-heart"></i></a></div>-->
                                        </div>
                                        <div class="product-content">
                                            <div class="product-content-head">
                                                <h3 class="product-title">Siptroil (Gl 5L)</h3>
												<div class="product-rating d-inline-block">
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                </div>
												<div class="product-quant">4 p/ caixa</div>
                                                <div class="product-price">R$ 90.73 ate 99.80</div>
                                            </div>
											
											<div class="form-group row justify-content-center">
													<label for="inputText4" class="col-sm-5 col-form-label">Quantidade</label>
													<div class="col-sm-5">
														<input id="inputText4" type="number" class="form-control" placeholder="1" min="1" max="5">
													</div>	
											</div>	
											
                                            <div class="product-btn text-center">
                                                <a href="#" class="btn btn-encomendar btn-block">Encomendar&nbsp;&nbsp;<i class="fa fa-fw fa-truck"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="product-thumbnail">
                                        <div class="product-img-head" style="background-color:#fff;">
                                            <div class="product-img">
                                                <img src="http://www.faunasystem.com.br:8080/rtc/galao-5l.jpg" alt="" class="img-fluid"></div>
                                            <div class="ribbons2">CUSTO MUITO DESATUALIZADO</div>
											<!--<div class="ribbons-text m-l-10">CUSTO ATUALIZADO</div>-->
                                            
                                            <!--<div class=""><a href="#" class="product-wishlist-btn"><i class="fas fa-heart"></i></a></div>-->
                                        </div>
                                        <div class="product-content">
                                            <div class="product-content-head">
                                                <h3 class="product-title">Siptroil (Bd 20L)</h3>
												<div class="product-rating d-inline-block">
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                </div>
												<div class="product-quant">1 p/ caixa</div>
                                                <div class="product-price">R$ 2.33</div>
                                            </div>
											
											<div class="form-group row justify-content-center">
													<label for="inputText4" class="col-sm-5 col-form-label">Quantidade</label>
													<div class="col-sm-5">
														<input id="inputText4" type="number" class="form-control" placeholder="1" min="1" max="5">
													</div>	
											</div>	
											
                                            <div class="product-btn text-center">
                                                <a href="#" class="btn btn-encomendar btn-block">Encomendar&nbsp;&nbsp;<i class="fa fa-fw fa-truck"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="product-thumbnail">
                                        <div class="product-img-head" style="background-color:#fff;">
                                            <div class="product-img">
                                                <img src="http://www.faunasystem.com.br:8080/rtc/pacote.jpg" alt="" class="img-fluid"></div>
                                            <div class="ribbons1">CUSTO ATUALIZADO</div>
											<!--<div class="ribbons-text m-l-10">CUSTO ATUALIZADO</div>-->
                                            
                                            <!--<div class=""><a href="#" class="product-wishlist-btn"><i class="fas fa-heart"></i></a></div>-->
                                        </div>
                                        <div class="product-content">
                                            <div class="product-content-head">
                                                <h3 class="product-title">Approve 375 g/Kg</h3>
												<div class="product-rating d-inline-block">
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                </div>
												<div class="product-quant">12 p/ caixa</div>
                                                <div class="product-price">R$ 2.33 ate 2.56</div>
                                            </div>
											
											<div class="form-group row justify-content-center">
													<label for="inputText4" class="col-sm-5 col-form-label">Quantidade</label>
													<div class="col-sm-5">
														<input id="inputText4" type="number" class="form-control" placeholder="1" min="1" max="5">
													</div>	
											</div>	
											
                                            <div class="product-btn text-center">
                                                <a href="#" class="btn btn-encomendar btn-block">Encomendar&nbsp;&nbsp;<i class="fa fa-fw fa-truck"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								
								
								<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="product-thumbnail">
                                        <div class="product-img-head" style="background-color:#fff;">
                                            <div class="product-img">
                                                <img src="http://www.faunasystem.com.br:8080/rtc/galao-5l.jpg" alt="" class="img-fluid"></div>
                                            <div class="ribbons1">CUSTO ATUALIZADO</div>
											<!--<div class="ribbons-text m-l-10">CUSTO ATUALIZADO</div>-->
                                            
                                            <!--<div class=""><a href="#" class="product-wishlist-btn"><i class="fas fa-heart"></i></a></div>-->
                                        </div>
                                        <div class="product-content">
                                            <div class="product-content-head">
                                                <h3 class="product-title">Siptroil (Gl 5L)</h3>
												<div class="product-rating d-inline-block">
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                </div>
												<div class="product-quant">4 p/ caixa</div>
                                                <div class="product-price">R$ 90.73 ate 99.80</div>
                                            </div>
											
											<div class="form-group row justify-content-center">
													<label for="inputText4" class="col-sm-5 col-form-label">Quantidade</label>
													<div class="col-sm-5">
														<input id="inputText4" type="number" class="form-control" placeholder="1" min="1" max="5">
													</div>	
											</div>	
											
                                            <div class="product-btn text-center">
                                                <a href="#" class="btn btn-encomendar btn-block">Encomendar&nbsp;&nbsp;<i class="fa fa-fw fa-truck"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="product-thumbnail">
                                        <div class="product-img-head" style="background-color:#fff;">
                                            <div class="product-img">
                                                <img src="http://www.faunasystem.com.br:8080/rtc/galao-5l.jpg" alt="" class="img-fluid"></div>
                                            <div class="ribbons2">CUSTO MUITO DESATUALIZADO</div>
											<!--<div class="ribbons-text m-l-10">CUSTO ATUALIZADO</div>-->
                                            
                                            <!--<div class=""><a href="#" class="product-wishlist-btn"><i class="fas fa-heart"></i></a></div>-->
                                        </div>
                                        <div class="product-content">
                                            <div class="product-content-head">
                                                <h3 class="product-title">Siptroil (Bd 20L)</h3>
												<div class="product-rating d-inline-block">
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                </div>
												<div class="product-quant">1 p/ caixa</div>
                                                <div class="product-price">R$ 2.33</div>
                                            </div>
											
											<div class="form-group row justify-content-center">
													<label for="inputText4" class="col-sm-5 col-form-label">Quantidade</label>
													<div class="col-sm-5">
														<input id="inputText4" type="number" class="form-control" placeholder="1" min="1" max="5">
													</div>	
											</div>	
											
                                            <div class="product-btn text-center">
                                                <a href="#" class="btn btn-encomendar btn-block">Encomendar&nbsp;&nbsp;<i class="fa fa-fw fa-truck"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="product-thumbnail">
                                        <div class="product-img-head" style="background-color:#fff;">
                                            <div class="product-img">
                                                <img src="http://www.faunasystem.com.br:8080/rtc/pacote.jpg" alt="" class="img-fluid"></div>
                                            <div class="ribbons1">CUSTO ATUALIZADO</div>
											<!--<div class="ribbons-text m-l-10">CUSTO ATUALIZADO</div>-->
                                            
                                            <!--<div class=""><a href="#" class="product-wishlist-btn"><i class="fas fa-heart"></i></a></div>-->
                                        </div>
                                        <div class="product-content">
                                            <div class="product-content-head">
                                                <h3 class="product-title">Approve 375 g/Kg</h3>
												<div class="product-rating d-inline-block">
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                </div>
												<div class="product-quant">12 p/ caixa</div>
                                                <div class="product-price">R$ 2.33 ate 2.56</div>
                                            </div>
											
											<div class="form-group row justify-content-center">
													<label for="inputText4" class="col-sm-5 col-form-label">Quantidade</label>
													<div class="col-sm-5">
														<input id="inputText4" type="number" class="form-control" placeholder="1" min="1" max="5">
													</div>	
											</div>	
											
                                            <div class="product-btn text-center">
                                                <a href="#" class="btn btn-encomendar btn-block">Encomendar&nbsp;&nbsp;<i class="fa fa-fw fa-truck"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								
								<!-- ============================================================== -->
								<!-- BANNER  -->
								<!-- ============================================================== -->
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
								
									
										<div id="carouselExampleIndicators" class="product-carousel carousel slide m-b-40" data-ride="carousel">
											<ol class="carousel-indicators">
												<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
												<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
												<!--<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>-->
											</ol>
											<div class="carousel-inner">
												<div class="carousel-item active">
													<img class="d-block w-100" src="assets/images/banner_784x295.jpg" alt="First slide">
												</div>
												<div class="carousel-item">
													<img class="d-block w-100" src="assets/images/banner_784x295.jpg" alt="Second slide">
												</div>
												<!--
												<div class="carousel-item">
													<img class="d-block w-100" src="assets/images/card-img-3.jpg" alt="Third slide">
												</div>-->
											</div>
											<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
											  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
											   <span class="sr-only">Previous</span>  </a>
											<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
												<span class="carousel-control-next-icon" aria-hidden="true"></span>
													<span class="sr-only">Next</span>  </a>
										</div>
							
								</div>
								<!-- END BANNER  -->
								
								<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="product-thumbnail">
                                        <div class="product-img-head" style="background-color:#fff;">
                                            <div class="product-img">
                                                <img src="http://www.faunasystem.com.br:8080/rtc/galao-5l.jpg" alt="" class="img-fluid"></div>
                                            <div class="ribbons1">CUSTO ATUALIZADO</div>
											<!--<div class="ribbons-text m-l-10">CUSTO ATUALIZADO</div>-->
                                            
                                            <!--<div class=""><a href="#" class="product-wishlist-btn"><i class="fas fa-heart"></i></a></div>-->
                                        </div>
                                        <div class="product-content">
                                            <div class="product-content-head">
                                                <h3 class="product-title">Siptroil (Gl 5L)</h3>
												<div class="product-rating d-inline-block">
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                </div>
												<div class="product-quant">4 p/ caixa</div>
                                                <div class="product-price">R$ 90.73 ate 99.80</div>
                                            </div>
											
											<div class="form-group row justify-content-center">
													<label for="inputText4" class="col-sm-5 col-form-label">Quantidade</label>
													<div class="col-sm-5">
														<input id="inputText4" type="number" class="form-control" placeholder="1" min="1" max="5">
													</div>	
											</div>	
											
                                            <div class="product-btn text-center">
                                                <a href="#" class="btn btn-encomendar btn-block">Encomendar&nbsp;&nbsp;<i class="fa fa-fw fa-truck"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="product-thumbnail">
                                        <div class="product-img-head" style="background-color:#fff;">
                                            <div class="product-img">
                                                <img src="http://www.faunasystem.com.br:8080/rtc/galao-5l.jpg" alt="" class="img-fluid"></div>
                                            <div class="ribbons2">CUSTO MUITO DESATUALIZADO</div>
											<!--<div class="ribbons-text m-l-10">CUSTO ATUALIZADO</div>-->
                                            
                                            <!--<div class=""><a href="#" class="product-wishlist-btn"><i class="fas fa-heart"></i></a></div>-->
                                        </div>
                                        <div class="product-content">
                                            <div class="product-content-head">
                                                <h3 class="product-title">Siptroil (Bd 20L)</h3>
												<div class="product-rating d-inline-block">
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                </div>
												<div class="product-quant">1 p/ caixa</div>
                                                <div class="product-price">R$ 2.33</div>
                                            </div>
											
											<div class="form-group row justify-content-center">
													<label for="inputText4" class="col-sm-5 col-form-label">Quantidade</label>
													<div class="col-sm-5">
														<input id="inputText4" type="number" class="form-control" placeholder="1" min="1" max="5">
													</div>	
											</div>	
											
                                            <div class="product-btn text-center">
                                                <a href="#" class="btn btn-encomendar btn-block">Encomendar&nbsp;&nbsp;<i class="fa fa-fw fa-truck"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="product-thumbnail">
                                        <div class="product-img-head" style="background-color:#fff;">
                                            <div class="product-img">
                                                <img src="http://www.faunasystem.com.br:8080/rtc/pacote.jpg" alt="" class="img-fluid"></div>
                                            <div class="ribbons1">CUSTO ATUALIZADO</div>
											<!--<div class="ribbons-text m-l-10">CUSTO ATUALIZADO</div>-->
                                            
                                            <!--<div class=""><a href="#" class="product-wishlist-btn"><i class="fas fa-heart"></i></a></div>-->
                                        </div>
                                        <div class="product-content">
                                            <div class="product-content-head">
                                                <h3 class="product-title">Approve 375 g/Kg</h3>
												<div class="product-rating d-inline-block">
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                </div>
												<div class="product-quant">12 p/ caixa</div>
                                                <div class="product-price">R$ 2.33 ate 2.56</div>
                                            </div>
											
											<div class="form-group row justify-content-center">
													<label for="inputText4" class="col-sm-5 col-form-label">Quantidade</label>
													<div class="col-sm-5">
														<input id="inputText4" type="number" class="form-control" placeholder="1" min="1" max="5">
													</div>	
											</div>	
											
                                            <div class="product-btn text-center">
                                                <a href="#" class="btn btn-encomendar btn-block">Encomendar&nbsp;&nbsp;<i class="fa fa-fw fa-truck"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="product-thumbnail">
                                        <div class="product-img-head" style="background-color:#fff;">
                                            <div class="product-img">
                                                <img src="http://www.faunasystem.com.br:8080/rtc/galao-5l.jpg" alt="" class="img-fluid"></div>
                                            <div class="ribbons1">CUSTO ATUALIZADO</div>
											<!--<div class="ribbons-text m-l-10">CUSTO ATUALIZADO</div>-->
                                            
                                            <!--<div class=""><a href="#" class="product-wishlist-btn"><i class="fas fa-heart"></i></a></div>-->
                                        </div>
                                        <div class="product-content">
                                            <div class="product-content-head">
                                                <h3 class="product-title">Siptroil (Gl 5L)</h3>
												<div class="product-rating d-inline-block">
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                </div>
												<div class="product-quant">4 p/ caixa</div>
                                                <div class="product-price">R$ 90.73 ate 99.80</div>
                                            </div>
											
											<div class="form-group row justify-content-center">
													<label for="inputText4" class="col-sm-5 col-form-label">Quantidade</label>
													<div class="col-sm-5">
														<input id="inputText4" type="number" class="form-control" placeholder="1" min="1" max="5">
													</div>	
											</div>	
											
                                            <div class="product-btn text-center">
                                                <a href="#" class="btn btn-encomendar btn-block">Encomendar&nbsp;&nbsp;<i class="fa fa-fw fa-truck"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="product-thumbnail">
                                        <div class="product-img-head" style="background-color:#fff;">
                                            <div class="product-img">
                                                <img src="http://www.faunasystem.com.br:8080/rtc/galao-5l.jpg" alt="" class="img-fluid"></div>
                                            <div class="ribbons2">CUSTO MUITO DESATUALIZADO</div>
											<!--<div class="ribbons-text m-l-10">CUSTO ATUALIZADO</div>-->
                                            
                                            <!--<div class=""><a href="#" class="product-wishlist-btn"><i class="fas fa-heart"></i></a></div>-->
                                        </div>
                                        <div class="product-content">
                                            <div class="product-content-head">
                                                <h3 class="product-title">Siptroil (Bd 20L)</h3>
												<div class="product-rating d-inline-block">
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                </div>
												<div class="product-quant">1 p/ caixa</div>
                                                <div class="product-price">R$ 2.33</div>
                                            </div>
											
											<div class="form-group row justify-content-center">
													<label for="inputText4" class="col-sm-5 col-form-label">Quantidade</label>
													<div class="col-sm-5">
														<input id="inputText4" type="number" class="form-control" placeholder="1" min="1" max="5">
													</div>	
											</div>	
											
                                            <div class="product-btn text-center">
                                                <a href="#" class="btn btn-encomendar btn-block">Encomendar&nbsp;&nbsp;<i class="fa fa-fw fa-truck"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="product-thumbnail">
                                        <div class="product-img-head" style="background-color:#fff;">
                                            <div class="product-img">
                                                <img src="http://www.faunasystem.com.br:8080/rtc/pacote.jpg" alt="" class="img-fluid"></div>
                                            <div class="ribbons1">CUSTO ATUALIZADO</div>
											<!--<div class="ribbons-text m-l-10">CUSTO ATUALIZADO</div>-->
                                            
                                            <!--<div class=""><a href="#" class="product-wishlist-btn"><i class="fas fa-heart"></i></a></div>-->
                                        </div>
                                        <div class="product-content">
                                            <div class="product-content-head">
                                                <h3 class="product-title">Approve 375 g/Kg</h3>
												<div class="product-rating d-inline-block">
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                </div>
												<div class="product-quant">12 p/ caixa</div>
                                                <div class="product-price">R$ 2.33 ate 2.56</div>
                                            </div>
											
											<div class="form-group row justify-content-center">
													<label for="inputText4" class="col-sm-5 col-form-label">Quantidade</label>
													<div class="col-sm-5">
														<input id="inputText4" type="number" class="form-control" placeholder="1" min="1" max="5">
													</div>	
											</div>	
											
                                            <div class="product-btn text-center">
                                                <a href="#" class="btn btn-encomendar btn-block">Encomendar&nbsp;&nbsp;<i class="fa fa-fw fa-truck"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								
								
								<!-- ============================================================== -->
								<!-- paginação  -->
								<!-- ============================================================== -->
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                            <li class="page-item-encomendar"><a class="page-link-encomendar" href="#">Anterior</a></li>
                                            <li class="page-item-encomendar"><a class="page-link-encomendar" href="#">1</a></li>
                                            <li class="page-item-encomendar active"><a class="page-link-encomendar " href="#">2</a></li>
                                            <li class="page-item-encomendar"><a class="page-link-encomendar" href="#">3</a></li>
                                            <li class="page-item-encomendar"><a class="page-link-encomendar" href="#">Próximo</a></li>
                                        </ul>
                                    </nav>
                                </div>
								
								
								</div>
                            </div>
                        
						
					<!-- ============================================================== -->
                    <!-- sidebar BANNER + FILTRO  -->
                    <!-- ============================================================== -->	
						
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12">
						<div class="product-sidebar m-b-30">
								<div class="product-sidebar-widget">
                                    <h4 class="product-sidebar-widget-title">Busca</h4>
                                    <form>
										<div class="form-group">
											<div class="icon-addon addon-lg">
												<input class="form-control form-control-lg" type="search" placeholder="Digite o que procura" aria-label="Search">
												<label for="email" class="fa fa-search" rel="tooltip" title="email"></label>
											</div>
										</div>
                                    </form>
                                </div>
								<div class="product-sidebar-widget">
                                    <h4 class="product-sidebar-widget-title">Não encontrei o produto</h4>
									<button class="btn btn-primary btn-block" data-toggle="modal" data-target="#mdlCadastra">
                                                <i class="fas fa-plus-circle"></i>&nbsp; adicionar produto
                                            </button>
                                </div>
                                <div class="product-sidebar-widget">
                                    <h4 class="mb-0">Busca por filtro</h4>
                                </div>
                                <div class="product-sidebar-widget">
                                    <h4 class="product-sidebar-widget-title">Category</h4>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="cat-1">
                                        <label class="custom-control-label" for="cat-1">Categories #1</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="cat-2">
                                        <label class="custom-control-label" for="cat-2">Categories #2</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="cat-3">
                                        <label class="custom-control-label" for="cat-3">Categories #3</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="cat-4">
                                        <label class="custom-control-label" for="cat-4">Categories #4</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="cat-5">
                                        <label class="custom-control-label" for="cat-5">Categories #5</label>
                                    </div>
                                </div>
                                <div class="product-sidebar-widget">
                                    <h4 class="product-sidebar-widget-title">Size</h4>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="size-1">
                                        <label class="custom-control-label" for="size-1">Small</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="size-2">
                                        <label class="custom-control-label" for="size-2">Medium</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="size-3">
                                        <label class="custom-control-label" for="size-3">Large</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="size-4">
                                        <label class="custom-control-label" for="size-4">Extra Large</label>
                                    </div>
                                </div>
                                <div class="product-sidebar-widget">
                                    <h4 class="product-sidebar-widget-title">Brand</h4>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="brand-1">
                                        <label class="custom-control-label" for="brand-1">Brand Name #1</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="brand-2">
                                        <label class="custom-control-label" for="brand-2">Brand Name #2</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="brand-3">
                                        <label class="custom-control-label" for="brand-3">Brand Name #3</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="brand-4">
                                        <label class="custom-control-label" for="brand-4">Brand Name #4</label>
                                    </div>
                                </div>
                                <div class="product-sidebar-widget">
                                    <h4 class="product-sidebar-widget-title">Price</h4>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="price-1">
                                        <label class="custom-control-label" for="price-1">$$</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="price-2">
                                        <label class="custom-control-label" for="price-2">$$$</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="price-3">
                                        <label class="custom-control-label" for="price-3">$$$$</label>
                                    </div>
                                </div>
                                <div class="product-sidebar-widget">
                                    <a href="#" class="btn btn-outline-light">Resetar Filtro</a>
                                </div>
                            </div>
							
							<!-- ============================================================== -->
							<!-- sidebar BANNER 300x250  -->
							<!-- ============================================================== -->
						
							<div class="product-sidebar m-b-30">
								<div class="product-sidebar-widget p-0" style="margin-bottom: 0px">
                                    <img alt="pampa Design Medium Rectangle 300x250" src="assets/images/banner_300x250.jpg" style="width: 100%;">
                                </div>
							</div>
							
							<!-- ============================================================== -->
							<!-- sidebar BANNER 240x400  -->
							<!-- ============================================================== -->
							
							<div class="product-sidebar m-b-30">
								<div class="product-sidebar-widget p-0" style="margin-bottom: 0px">
                                    <img alt="tordon banner 240x400" src="assets/images/banner_240x400.jpg" style="width: 100%;">
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
	
	
	<!-- ============================================================== -->
    <!-- start cadastro produto - MODAL  -->
    <!-- ============================================================== -->
	<div class="modal fade in" id="mdlCadastra" tabindex="-1" role="dialog" aria-labelledby="mdlCadastra" aria-hidden="false" >
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
											<h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-cubes fa-3x"></i>&nbsp;&nbsp;&nbsp;Cadastre seu produto em nossa base de dados</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
                                        </div>
                                        <div class="modal-body">
										<div class="mx-auto">
                                            <div class="row" style="margin-bottom:10px">
                                                <div class="col-md-10">
                                                    <input type="text" placeholder="nome do produto" id="txtNomeProduto" class="form-control form-control-lg">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom:10px">
                                                <div class="col-md-6">
                                                    <input type="text" placeholder="Galao, Balde, Saco, etc.. ?" id="txtUnidade" class="form-control form-control-lg">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" placeholder="Litros/Kilos?" id="txtQuantidade" class="form-control form-control-lg">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <input type="text" placeholder="Valor mínimo" id="txtMinimo" class="form-control form-control-lg">
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="text" placeholder="Valor máximo" id="txtMaximo" class="form-control form-control-lg">
                                                </div>
                                            </div>
                                       

                                        </div>
										</div>
                                        <div class="modal-footer">
											<button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                                            <button class="btn btn-primary" onclick="cadastrarProduto()">
                                                <i class="fas fa-save"></i> &nbsp; Salvar
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
							
	<!-- ============================================================== -->
    <!-- end cadastro produto - MODAL   -->
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