<?php
include("includes.php");

$ses = new SessionManager();
$empresa = $ses->get('empresa');
$usuario = $ses->get('usuario');


if ($usuario == null || $empresa == null) {

    header('location:index.php');
}

$logo = $empresa->getLogo(new ConnectionFactory());
$fonte = $logo->getCorFonteAdequada();
if (!isset($filtro)) {
    $filtro = "";
}

$rtc = $ses->get('rtc');

if ($rtc == null) {

    $rtc = $empresa->getRTC(new ConnectionFactory());

    $rtcs = Sistema::getRTCS();

    $possiveis = array();
    foreach ($rtcs as $key => $value) {
        if ($value->numero > $rtc->numero) {
            continue;
        }
        $possiveis[] = $value;
    }

    $ses->set('rtcs', $possiveis);
}
$possiveis = $ses->get('rtcs');

if (isset($_GET['t'])) {
    $n = $_GET['t'];
    foreach ($possiveis as $key => $value) {
        if ($value->numero == $n) {
            $rtc = $value;
            $ses->set('rtc', $value);
            break;
        }
    }
}

foreach ($possiveis as $key => $value) {
    if ($value->numero === $rtc->numero) {
        $possiveis[$key] = $possiveis[0];
        break;
    }
}

$possiveis[0] = $rtc;
$rtc->numero--;
?>

<style type="text/css">

    .modal-lg {
        max-width: 60% !important;
    }

    .btn-primary{
        background-color:<?php echo $logo->cor_predominante; ?> !important;
        color: <?php echo $fonte; ?> !important;
        border-color: <?php echo $logo->cor_predominante; ?> !important;
    }

    .navbar-light{
        background-color:<?php echo $logo->cor_predominante; ?> !important;
    }

    .menu-list{
        background-color:<?php echo $logo->cor_predominante; ?> !important;
    }

    #men .nav-link{
        color: <?php echo $fonte; ?> !important;
    }

    #men i{
        color: <?php echo $fonte; ?> !important;
    }

    #men .nav-link:hover{
        background-color:<?php echo $logo->cor_predominante; ?> !important;
        filter: brightness(85%);
        color: <?php echo $fonte; ?> !important;
    }


</style>


<div ng-controller="crtAtividade"></div>
<div class="dashboard-header" ng-controller="crtCarrinho">
    <nav class="navbar navbar-expand-lg bg-white fixed-top">
        <a class="navbar-brand" href="index.html"><img id="logo" src="data:image/png;base64, <?php echo $logo->logo; ?>" alt="" title="" style="max-height:50px"></a>
        &nbsp;
        <div ng-controller="crtEmpresa" style="margin-right: 10px">
            <select class="form-control" ng-model="empresa" ng-change="setEmpresa()">
                <option ng-repeat="e in filiais" ng-value="e">{{e.nome}}</option>
            </select>
        </div>
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
                    <a class="nav-link nav-icons" href="#" ng-click="$event.preventDefault(); attCarrinho()" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-shopping-cart fa-bell"></i><span id="indicadorAdd" style="visibility:hidden" class="indicator"></span></a>
                    <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                        <li>
                            <div class="notification-title">Carrinho de Compras<span class="badge badge-primary badge-pill m-l-20">{{carrinho.length}}</span></div>
                            <div class="notification-list">
                                <div class="list-group">

                                    <a href="#" class="list-group-item list-group-item-action active" ng-repeat="item in carrinho">
                                        <div class="notification-info">
                                            <div class="notification-list-user-img"><img src="{{item.imagem}}" alt="" class="user-avatar-xl"></div>
                                            <div class="notification-list-user-img m-l-20"><span class="notification-list-user-name">{{item.nome}}</span>.
                                                <div ng-if="item.validade.validade !== 1000" class="notification-date">Validade: {{item.validade.validade| data_st}}</div>
                                                <div class="notification-date">Valor: {{item.validade.valor}}</div>
                                                <div class="notification-date">Qtd:&nbsp;{{item.quantidade_comprada}}</div>
                                                <div class="notification-date">SubTotal: R$ {{(item.quantidade_comprada * item.validade.valor).toFixed(2)}}</div>
                                            </div>	
                                            <div class="notification-list-user-img m-l-25 product"><button ng-click="removerProduto(item)" class="btn btn-outline-light btn-sm"><i class="fa fa-times"></i></button></div>	

                                        </div>
                                    </a>



                                </div>

                            </div>
                        </li>
                        <li>
                            <div class="list-footer"> <a href="carrinho-de-compras.php">Finalizar Compra</a></div>
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
                    <a style="display:none" class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-bell"></i> <span class="indicator"></span></a>
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
                        <span class="hidden-lg"><?php
                            if (strlen($usuario->nome) < 5) {
                                echo $usuario->nome;
                            } else {
                                echo substr($usuario->nome, 0, 5) . "..";
                            }
                            ?></span>                       
                    </a>
                    <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                        <div class="nav-user-info clearfix align-middle" style="background-color:<?php echo $logo->cor_predominante; ?>">
                            <div class="float-left m-r-10 m-t-5">
                                <img src="data:image/png;base64, <?php echo $logo->logo; ?>" alt="" class="user-avatar-md rounded-circle ">
                            </div>
                            <div class="float-left">									
                                <h5 class="mb-0 nav-user-name" style="color:<?php echo $fonte; ?>"><?php echo $usuario->nome; ?></h5>
                                <span class="status"></span><span class="ml-2"><?php echo $empresa->nome; ?></span>
                            </div>	
                        </div>
                        <a class="dropdown-item" href="cfg.php"><i class="fas fa-user mr-2"></i>Colaboradores</a>
                        <a class="dropdown-item" href="alteracao-do-logo.php"><i class="fas fa-font mr-2"></i>Alterar Logo</a>
                        <!--<a class="dropdown-item" href="cadastro-empresas-filiais.html"><i class="fas fa-file-alt mr-2"></i>Empresas / Filiais</a>-->
                        <!--<a class="dropdown-item" href="configuracao-da-empresa.html"><i class="fas fa-cog mr-2"></i>Configuração da empresa</a>-->
                        <a class="dropdown-item" href="index.php"><i class="fas fa-power-off mr-2"></i>Sair</a>
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
                <ul class="navbar-nav flex-column" id="men" ng-controller="crtRelatorio">
                    <li class="nav-divider" style="color:<?php echo $fonte; ?>;text-decoration: underline">
                        <select style="background-color:transparent;font-weight:bold;color:#FFFFFF;border:0px solid" class="form-control" onchange="window.location = 'comprar.php?t=' + $(this).find('option:selected').val()">
                            <?php
                            foreach ($possiveis as $key => $value) {
                                ?>
                                <option style="color:#000000" value="<?php echo $value->numero; ?>"><?php echo $value->nome; ?></option>
                            <?php } ?>
                        </select>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="comprar.php"><button class="btn btn-warning" onmousedown="tutorial('Compra Parceiros', 'Aqui voce pode comprar produtos da Agro Fauna, e de qualquer empresa do grupo Novos Rumos, adicione os produtos desejados ao seu carrinho de compras, e finalize seu pedido')" style="padding:0px;padding-left:4px;display:inline;margin: 0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fa fa-fw fa-shopping-basket"></i>Compra Parceiros</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="carrinho-de-compras.php"><button class="btn btn-warning" onmousedown="tutorial('Carrinho', 'Aqui é onde você finalizar sua compra, depois de ja ter adcionado os itens ao carrinho na aba de Compra Parceiros, aqui voce também vai ver todos os impostos que estao incidindo sobre a sua compra.')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button><i class="fa fa-fw fa-shopping-cart"></i>Carrinho</a>
                    </li>

                    <li class="nav-divider" style="color:<?php echo $fonte; ?>;text-decoration: underline">
                        <?php echo $empresa->nome; ?>
                    </li>
                    <?php if ($usuario->temPermissao(Sistema::P_CONFIGURACAO_EMPRESA()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="configuracao-empresa.php" ><button class="btn btn-warning" onmousedown="tutorial('Configuracao da Empresa', 'Aqui é onde você cadastra os dados da sua empresa, para que o sistema deixe algumas coisas automaticas para você, caso você tenha o modulo de emissão de nota também ira cadastrar o seu certificado digitao aqui')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-compass"></i>Config. Empresa</a>
                        </li>         
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_CFG()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="cfg.php" ><button class="btn btn-warning" onmousedown="tutorial('CFG', 'Aqui é onde você cria novos usuarios para a sua empresa, atribui autorizações e retira')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-user mr-2"></i>Colaboradores</a>
                        </li>         
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_LISTA_PRECO()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="lista-de-preco.php" ><button class="btn btn-warning" onmousedown="tutorial('Lista de preço', 'Esta é uma pagina de consulta para que você consiga fazer o seu receituario, contem todas as relações de praga, produto e cultura')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-clipboard-list"></i>Receituario</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_CAMPANHA()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="campanhas.php" ><button class="btn btn-warning" onmousedown="tutorial('Campanhas', 'Aqui é onde você define promoções para os seus produtos, e também pode consultar e alterar parametros promocionais')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-anchor"></i>Campanhas</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_GERENCIADOR()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="gerenciador.php" ><button class="btn btn-warning" onmousedown="tutorial('Gerenciador', 'Aqui você consegue ver os usuarios que estao online no período selecionado, ou que entraram no periodo selecionado, apareceram com uma bolinha verde os que estiverem online, e uma vermelha para os que ja sairam, além disso aqui você consegue ver parametros como a quantidade maxima de usuarios que acessam simultaneamente o RTC em um periodo, também consegue checar dados de um usuário especifico, ver sua pontuação seus logs de acesso, e também via grafico, a frequencia de sua atividade')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-chart-bar"></i>Gerenciador</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_BANNERS()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="banners.php" ><button class="btn btn-warning" onmousedown="tutorial('Banners', 'Aqui você consegue confeccionar banners dinâmicos para entrar no RTC da sua empresa e serem enviados por email, esses banners tem que estar em formato HTML, e talvez precise de um profissional de marketing para criar esse HTML para você, mas depois que é criado o próprio sistema faz adaptações nele para servir para qualquer situação')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-image"></i>Banners</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_FORNECEDOR()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="fornecedores.php" ><button class="btn btn-warning" onmousedown="tutorial('Fornecedores', 'Aqui você faz o cadastro de seus fornecedores, alteração, exclusão, habilitação e desabilitação')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-industry"></i>Fornecedores</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_BANCO()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="bancos.php" ><button class="btn btn-warning" onmousedown="tutorial('Bancos', 'Aqui você faz o cadastro de seus bancos com saldos, agencia, conta e outros dados, pode alterar e excluir também')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-calculator"></i>Bancos</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_MOVIMENTO()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="movimentos_banco.php" ><button class="btn btn-warning" onmousedown="tutorial('Movimentos', 'Aqui você faz as baixas das notas fiscais, cadastrando o movimento para ela, o mesmo relacionado a um banco, um código de operação e histórico, ele ja faz a correção de saldo automaticamente também')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-money-bill-alt"></i>Movimentos Financeiro</a>
                        </li>
                    <?php } ?>
                    <li class="nav-item" ng-repeat="relatorio in relatorios">
                        <a class="nav-link" href="relatorios.php?rel={{relatorio.id}}" ><button class="btn btn-warning" onmousedown="tutorial('Relatorios', 'Essa é uma parte destinada a geração de relatorios, você pode solicitar o relatório que desejar para a equipe da Agrofauna Técnologia.')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-paper-plane"></i>{{relatorio.nome}}</a>
                    </li>
                    <?php if ($usuario->temPermissao(Sistema::P_PRODUTO_CLIENTE()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="produto-cliente-logistic.php"><button class="btn btn-warning" onmousedown="tutorial('Produtos Logistic', 'Aqui é onde a empresa de armazenamento, ve os produtos de seus clientes, com respectivos estoques que estão armazenados no armazén')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-camera"></i>Produtos cliente Logistic</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_PRODUTO()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="cadastro-de-produtos.php"><button class="btn btn-warning" onmousedown="tutorial('Cadastro de Produtos', 'Aqui é onde seus produtos são cadastrados, podem ser excluidos e/ou alterados também. ')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-cube"></i>Cadastro de Produtos</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_NOTA()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="notas.php"><button class="btn btn-warning" onmousedown="tutorial('Notas', 'Aqui estão todas as fichas, de saída e entrada, podem ser cadastradas quando for necessário, realizam movimentação no estoque, e também é a parte do sistema destinada a emissão de nota, onde o próprio sistema emite as notas aqui inseridas')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-book"></i>Notas</a>
                        </li>                  
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_LOTE()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="lotes.php"><button class="btn btn-warning" onmousedown="tutorial('Lotes', 'Aqui é onde são administrados os lotes de cada um dos produtos que utilizam o sistema de lotes, podem ser cadastrados, e ter impressas as etiquetas de cada um deles')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-cubes"></i>Lotes</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_CLIENTE()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="clientes.php" ><button class="btn btn-warning" onmousedown="tutorial('Clientes', 'Aqui é o cadastro de clientes, onde você pode cadastrar, excluir e alterar seus clientes')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-users"></i>Clientes</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_TRANSPORTADORA()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="transportadoras.php" ><button class="btn btn-warning" onmousedown="tutorial('Transportadoras', 'Aqui é onde ficam cadastradas todas as suas transportadoras, é possível também alterar e excluir, além disso o RTC conta com um sistema de calculo de frete bastante interessante onde você pode cadastrar sua tabela através de expressões matemáticas, e o sistema então passa a calcular seu frete automaticamente, nos seus pedidos para os seus clientes, além disso a consulta de tabela fica disponivel aqui mesmo para fazer uma simulação de frete')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-truck"></i>Transportadoras</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_COTACAO()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="cotacao-compra.php"><button class="btn btn-warning" onmousedown="tutorial('Cotacao', 'Aqui é onde você pode fazer uma cotação com os seus fornecedores, quando você finaliza a cotação, ele envia um email para o seu fornecedor, com a possíbilidade dele responder pelo próprio email, e quando isso acontece a resposta dele ja entra no seu sistema automaticamente.')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-check-square"></i>Cotacao</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_PEDIDO_ENTRADA()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="visualizar-pedidos-compra.php"><button class="btn btn-warning" onmousedown="tutorial('Pedido de compra', 'Aqui é onde ficam seus pedidos de compra, com o seu fornecedor, também é enviado um email de confirmação de pedido após a conclusão do mesmo, o pedido gera interferência no estoque e é a partir dele que a entrada de NFe vai acontecer')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-tasks"></i>Pedidos de Compra</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_ENTRADA_NFE()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="entrada_nota.php"><button class="btn btn-warning" onmousedown="tutorial('Entrada de Nota', 'Aqui é onde você da a entrada nas suas notas, aqui ocorre relação com o pedido de compra para que as alterações de estoque sejam computadas de forma integra, sem depender da nota do fornecedor, portanto é necessário sempre um pedido de compra para dar entrada em uma NFe')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-code"></i>Entrada NFe</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_PEDIDO_SAIDA()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="visualizar-pedidos-venda.php"><button class="btn btn-warning" onmousedown="tutorial('Pedido de Venda', 'Aqui é onde você cria os pedidos de venda para os seus clientes, já levando em consideração suas promoções e fazendo as movimentações de estoque conforme necessário')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-tasks"></i>Pedidos de Venda</a>
                        </li>
                    <?php } ?>
                    <li class="nav-divider" style="color:<?php echo $fonte; ?>;text-decoration: underline">
                        Administrativo RTC
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="http://agrofauna.com.br/apresentacao_rtc_v3.pdf" target="_blank"><i class="fa fa-fw fa-file-alt"></i>Projeto Novos Rumos</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="contrato.php" ><i class="fa fa-fw fa-file-alt"></i>Contrato</a>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
</div>

<div class="modal fade modal-md" id="tutorial" tabindex="-1" style="" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title m-t-10"><i class="fas fa-book"></i>&nbsp;&nbsp;&nbsp;<strong id="tituloTutorial"></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body text-center" id="conteudoTutorial">


            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<script>

    function tutorial(titulo, conteudo){

    $('#tituloTutorial').html(titulo);
    $("#conteudoTutorial").html(conteudo);
    $("#tutorial").modal("show");
    }

</script>
