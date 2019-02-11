<?php
include("includes.php");

$ses = new SessionManager();
$empresa = $ses->get('empresa');
$usuario = $ses->get('usuario');


if ($usuario == null || $empresa == null) {

    header('location:index.php');
}

$logo = $empresa->getLogo(new ConnectionFactory());

if (!isset($filtro)) {
    $filtro = "";
}
?>

<div class="dashboard-header">
    <nav class="navbar navbar-expand-lg bg-white fixed-top">
        <a class="navbar-brand" href="index.html"><img id="logo" style="" src="data:image/png;base64, <?php echo $logo->logo; ?>" alt="" title=""></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto navbar-right-top">
                <li class="nav-item">
                    <div id="custom-search" class="top-search-bar">
                        <div class="form-group">
                            <div class="icon-addon addon-sm">
                                <input class="form-control" type="search" id="filtro" placeholder="Digite o que procura" aria-label="Search" size="80%" <?php echo $filtro; ?>>
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
                        <img src="data:image/png;base64, <?php echo $logo->logo; ?>" alt="" class="user-avatar-md rounded-circle">
                        <span class="hidden-xs"><?php echo $usuario->nome; ?></span>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                        <div class="nav-user-info clearfix align-middle">
                            <div class="float-left m-r-10 m-t-5">
                                <img src="data:image/png;base64, <?php echo $logo->logo; ?>" alt="" class="user-avatar-md rounded-circle ">
                            </div>
                            <div class="float-left">									
                                <h5 class="mb-0 text-white nav-user-name"><?php echo $usuario->nome; ?></h5>
                                <span class="status"></span><span class="ml-2"><?php echo $empresa->nome; ?></span>
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
<div class="nav-left-sidebar sidebar-dark">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="d-xl-none d-lg-none" href="#">RTC</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-divider">
                        Compras
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="comprar.php" ><i class="fa fa-fw fa-shopping-basket"></i>Comprar</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="carrinho-de-compras.php" ><i class="fa fa-fw fa-shopping-cart"></i>Carrinho</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="encomendar.php" ><i class="fa fa-fw fa-truck"></i>Encomendar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="carrinho-de-encomenda.php" ><i class="fa fa-fw fa-shopping-cart"></i>Carrinho Encomenda</a>
                    </li>
                    <li class="nav-divider">
                        <?php echo $empresa->nome; ?>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="lista-de-preco.php" ><i class="fas fa-clipboard-list"></i>Lista de Preço</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="campanhas.php" ><i class="fas fa-anchor"></i>Campanhas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="fornecedores.php" ><i class="fas fa-industry"></i>Fornecedores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="bancos.php" ><i class="fas fa-calculator"></i>Bancos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="movimentos_banco.php" ><i class="fas fa-money-bill-alt"></i>Movimentos Financeiro</a>
                    </li>
                    <?php if($empresa->is_logistica){ ?>
                        <li class="nav-item">
                            <a class="nav-link" href="produto-cliente-logistic.php"><i class="fas fa-camera"></i>Produtos cliente Logistic</a>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" href="cadastro-de-produtos.php"><i class="fas fa-cube"></i>Cadastro de Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="notas.php"><i class="fas fa-book"></i>Notas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-exchange-alt"></i>Movimentação</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="lotes.php"><i class="fas fa-cubes"></i>Lotes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="clientes.php" ><i class="fas fa-users"></i>Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="transportadoras.php" ><i class="fas fa-truck"></i>Transportadoras</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cotacao-compra.php"><i class="fas fa-check-square"></i>Cotacao</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="visualizar-pedidos-compra.php"><i class="fas fa-tasks"></i>Pedidos de Compra</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="visualizar-pedidos-venda.php"><i class="fas fa-tasks"></i>Pedidos de Venda</a>
                    </li>

                    <li class="nav-divider">
                        Administrativo RTC
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="http://www.tratordecompras.com.br/rtc_erp/downloads/apresentacao_rtc_v2.pdf" target="_blank"><i class="fa fa-fw fa-file-alt"></i>Projeto Novos Rumos</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="contrato.php" ><i class="fa fa-fw fa-file-alt"></i>Contrato</a>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
</div>
