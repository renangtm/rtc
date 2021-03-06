<?php
include("includes.php");

$ses = new SessionManager();
$empresa = $ses->get('empresa');
$usuario = $ses->get('usuario');

$espelho = $empresa->fornecedor_virtual==1;

if(isset($_GET['idc'])){
        
        $espelho = true;

        $idc = Utilidades::base64decodeSPEC($_GET['idc']);
        
        $idc = explode('_',$idc);
        
        $con = new ConnectionFactory();
        $ps = $con->getConexao()->prepare("SELECT id_empresa FROM cliente WHERE id=".$idc[0]);
        $ps->execute();
        $ps->bind_result($id_empresa);
        if($ps->fetch()){
            $ps->close();
            
            $emp = new Empresa($id_empresa,$con);
            
            $cliente = $emp->getClientes($con,0,1,'cliente.id='.$idc[0]);
            
            
            if(count($cliente)===1){
               
                $usuario = Sistema::getUsuario("empresa.cnpj='".$cliente[0]->cnpj->valor."'");
                
                if($usuario === null){
                    
                    $cliente[0]->login = str_replace(array(".","/","-"), array("","",""), $cliente[0]->cnpj->valor);
                    $cliente[0]->senha = str_replace(array(".","/","-"), array("","",""), $cliente[0]->cnpj->valor);
                    
                    Sistema::inserirClienteRTC($con,$cliente[0],true);
                    header('Location: '.$_SERVER['REQUEST_URI']);
                    exit;
                    
                }else{
                    
                   $empresa = $ses->get('empresa');
                   $usuario = $ses->get('usuario');
                    
                }
                
            }
            
        }else{
            $ps->close();
        }
        
    }

if ($usuario == null || $empresa == null) {
    
    header('location:index.php');
}

$logo = $empresa->getLogo(new ConnectionFactory());
$fonte = $logo->getCorFonteAdequada();
if (!isset($filtro)) {
    $filtro = "";
}

$rtc = $usuario->empresa->getRTC(new ConnectionFactory());


$rtcs = $ses->get('rtcs');
if ($rtcs === null) {

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
            $usuario->empresa->rtc = $value;
            $ses->set('usuario', $usuario);
            $rtc = $usuario->empresa->rtc;
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
   
    .scrollBottom{
        
        
    }


</style>



<div ng-controller="crtAtividade"></div>
<div class="dashboard-header" ng-controller="crtCarrinho">
    <nav class="navbar navbar-expand-lg bg-white fixed-top">
        <a class="navbar-brand" href="comprar.php"><img id="logo" src="data:image/png;base64, <?php echo $logo->logo; ?>" alt="" title="" style="max-height:50px"></a>
        &nbsp;
        <div ng-controller="crtEmpresa" style="margin-right: 10px">
            
            <div class="modal fade" id="aprovacoes" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title m-t-10"><i class="fas fa-book"></i>&nbsp;&nbsp;&nbsp;Aprovacao de protocolos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
            </div>
            <div class="modal-body text-center">
                
                <div style="width:100%;border:2px solid;border-radius:3px;padding:20px;margin-bottom:10px" ng-repeat="pr in protocolos_aprovacao">
                    <button class="btn btn-success" style="display: inline;margin-left:10px" ng-click="aprovar(pr)"><i class="fas fa-check"></i>&nbspAprovar</button>
                    <button class="btn btn-danger" style="display: inline;margin-left:10px" ng-click="reprovar(pr)"><i class="fas fa-times"></i>&nbspReprovar</button>
                    <hr>
                    Titulo: {{pr.titulo}}
                    <hr>
                    Descricao: {{pr.descricao}}
                    <hr>
                    Tipo: 
                    <select class="form-control" ng-model="pr.tipo">
                        <option ng-repeat="tp in tipos_protocolo" ng-value="tp">{{tp.nome}}</option>
                    </select>
                    <hr>
                    Usuarios: <br>
                    
                    <div ng-repeat="usu in pr.usuarios" style="display: block;margin-bottom:10px">
                        <strong style="display:inline">{{usu.id}}-{{usu.nome}}</strong>
                        <button class="btn btn-danger" style="padding:2px;height:23px;width:23px" ng-click="removerUsuario(pr,usu)"><i class="fas fa-times"></i></button>
                    </div>
                    
                </div> 

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
            
            <div class="modal fade" id="chat_suporte" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog" style="float:right;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title m-t-10"><i class="fas fa-list"></i>&nbsp;&nbsp;&nbsp;Chat de suporte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
            </div>
            <div class="modal-body text-center">
                
                <div style="width:450px;height:340px;display: block;border-bottom:2px solid;border-radius:3px;padding:10px;margin-bottom:10px" ng-repeat="s in suportes">
                    
                    <div style="margin:10px;border-bottom:1px solid;width:100%;height:200px;overflow-y: scroll;overflow-wrap: break-word;" class="scrollBottom">
                        
                        <div style="text-align: left;margin-bottom:5px">
                            <span>Usuario: <strong style="color:steelblue">{{s.usuario.nome}}</strong></span>
                            <br>
                            <span>Atendente: <strong style="color:green">{{s.atendente.nome}}</strong></span>
                        </div>
                         
                        
                        <div ng-repeat="m in s.mensagens" style="text-align: left;margin-bottom:5px">
                            <strong style="color:steelblue">{{m.usuario.nome}}</strong> - {{m.texto}}
                            <br>
                            <span style="font-size: 10px">{{m.momento | data}}</span>
                        </div>
                         
                        
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <textarea placeholder="Converse com o nosso atendente por aqui." class="form-control" style="width:100%;margin-top:0px;display: inline" rows="3" ng-model="s.mensagem" my-enter="enviar(s)">
                    
                            </textarea>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-success" ng-click="enviar(s)" style="width:100%;height:86px" ng-disabled="enviando">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                    
                    
                </div> 
                
            </div>
        </div>
    </div>
</div>
            
            
            
            
            <select class="form-control" ng-model="$parent.empresa" ng-change="setEmpresa()" ng-if="!carregando_empresa" ng-options="e as e.nome for e in filiais">
            </select>
            <div class="progress mb-1" ng-if="carregando_empresa" style="width:150px">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
            </div>

            <?php if(!$espelho){ ?>
            <div style="position:absolute;cursor:pointer;padding:10px;top:40px;background-color: #FFFFFF;z-index: 99999;border-radius:5px;border:1px solid;visibility: {{protocolos_ativos.length===0?'hidden':'initial'}}" id="drag_protocolos" >
                <button class="btn btn-warning" id="btnEsconde"><i class="fas fa-list"></i>&nbsp PROTOCOLOS</button>
                <div id="chat_protocolos">
                    <hr>
                    <div style="width:500px;height:550px;border:1px dashed;border-radius: 5px;background-color: #FFFFFF;display: inline-block;margin-left:10px;margin-bottom:10px" ng-repeat="p in protocolos_ativos">
                        <div style="height:10%;width:100%;background-color: darkred;color:#FFFFFF !important;text-align: center;padding-top:5px">
                            <h4 style="color:#FFFFFF"><i class="fas fa-fire"></i> - {{p.tipo.nome}}</h4>
                            
                        </div>
                        <div style="margin:10px" ng-if="p.iniciado_por.indexOf('<?php echo $usuario->id." - ".$usuario->nome; ?>')!==0 || p.iniciado_por.length===0">
                                <button ng-click="stopProtocolo(p)" class="btn btn-outline-danger" style="padding:3px">
                                    <i class="fas fa-stop"></i>&nbsp Parar protocolo
                                </button>
                            </div>
                        <hr>
                        <div style="margin:15px;overflow-y: scroll;width:calc(100% - 25px);height:300px">
                            <span>
                                <h4 style="color:#FF0000">{{p.precedente}}</h4>
                                <hr>
                                Titulo: <h4>{{p.titulo}}</h4>
                            </span>
                            <span>
                                Inicio {{p.inicio | data}} por {{p.iniciado_por}}
                                <hr>
                                Precedente: <strong>{{p.descricao}}</strong>
                            </span>
                            <hr>
                            <span ng-repeat="men in p.chat">
                                {{men.momento | data}} por {{men.dados_usuario}}
                                <br>
                                {{men.mensagem}}
                                <hr>
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <textarea ng-model="p.obs" style="margin-left:10px" rows="3" class="form-control">
                            
                                </textarea>
                            </div>
                            <div class="col-md-4 btn btn-success" ng-click="enviar(p)">
                                
                                    <i class="fas fa-paper-plane"></i>&nbsp Enviar Andamento
                                
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
            <?php } ?>
            
            
            

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
                    <a class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink2" onclick="mostraSuporte()"><i class="fas fa-male"></i><span id="indicadorAdd2" class="indicator"></span></a>
                    
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
                <li class="nav-item dropdown notification" ng-controller="crtPardal">
                    <a class="nav-link nav-icons" href="#" id="pardal" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="far fa-fw fa-comments"></i></span></a>
                    <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                        <li>
                            <div class="notification-title bg-primary"> Chat <i class="far fa-comments m-l-10"></i></div>
                            <div class="notification-list">
                                <div class="list-group">
                                    <a href="#" class="list-group-item list-group-item-action {{c.tipo===0?'bg-chat-pardal':''}}" ng-repeat="c in conversa">
                                        <div class="notification-info">
                                            <div class="notification-list-user-img"><img ng-if="c.tipo===0" src="assets/images/avatar-2.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                            <div class="notification-list-user-block"><span class="notification-list-user-name">{{c.tipo===0?'Pardal':'Você'}}:</span><span ng-bind-html="c.texto"></span>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                            </div>
                        </li>
                        <li>
                            <div class="list-footer bg-light"> 
                                <div class="form-inline justify-content-center">
                                    <div class="form-group" style="width: 100%">
                                        <input type="text" class="form-control" ng-confirm="enviar()" style="width: 100%;margin:5px" id="txtEp" placeholder="Digite sua mensagem" ng-model="texto">
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown notification" ng-controller="crtCobranca">
                    <a class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-bell"></i> <span ng-if="cobrar" class="indicator"></span></a>
                    <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                        <li>
                            <div class="notification-title"> Notificacoes</div>
                            <div class="notification-list">
                                <div class="list-group">
                                    <a href="tarefas.php" style="margin-bottom: 10px" class="list-group-item list-group-item-action active" ng-if="cobrar" ng-repeat="cobranca in cobrancas">
                                        <div class="notification-info">
                                            <div class="notification-list-user-block">
                                                <i style="display:inline" class="fas fa-clock"></i>&nbsp<h4 style="display:inline">{{cobranca.titulo}}</h4>
                                                <br>
                                                {{cobranca.descricao}}
                                                <br>
                                                Prazo: <strong>{{cobranca.calculado_momento_conclusao| data}}</strong>
                                                <div class="notification-date">{{cobranca.porcentagem_conclusao}} % concluida</div>
                                                <div ng-if="cobranca.id === cobrancas[0].id" style="width:100%;text-align: center;font-style: italic">
                                                    <hr>
                                                    De Atençao a esta pendencia.
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="list-footer"> <a href="tarefas.php">Ver todas tarefas</a></div>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown nav-user">
                    <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        
                        <?php if(!$espelho){ ?>
                                    <img src="data:image/png;base64, <?php echo $logo->logo; ?>" alt="" class="user-avatar-md rounded-circle ">
                                <?php }else{ ?>
                                    <img src="assets/images/avatar-user-adagro.jpg" alt="" class="user-avatar-md rounded-circle ">
                                <?php } ?>
                                    
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
                                
                                
                                <?php if(!$espelho){ ?>
                                    <img src="data:image/png;base64, <?php echo $logo->logo; ?>" alt="" class="user-avatar-md rounded-circle ">
                                <?php }else{ ?>
                                    <img src="assets/images/avatar-user-adagro.jpg" alt="" class="user-avatar-md rounded-circle ">
                                <?php } ?>
                                
                                
                            </div>
                            <div class="float-left">									
                                <h5 class="mb-0 nav-user-name" style="color:<?php echo $fonte; ?>"><?php echo $usuario->nome; ?></h5>
                                <span class="status"></span><span class="ml-2"><?php echo $empresa->nome; ?></span>
                            </div>	
                        </div>
                        <a class="dropdown-item" href="cfg.php"><i class="fas fa-sitemap"></i>&nbspCFG</a>
                        <a class="dropdown-item" href="alteracao-do-logo.php"><i class="fas fa-font mr-2"></i>Alterar Logo</a>
                        <!--<a class="dropdown-item" href="cadastro-empresas-filiais.html"><i class="fas fa-file-alt mr-2"></i>Empresas / Filiais</a>-->
                        <!--<a class="dropdown-item" href="configuracao-da-empresa.html"><i class="fas fa-cog mr-2"></i>Configura��o da empresa</a>-->
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
                    <?php if(!$espelho){ ?>
                    <li class="nav-divider" style="color:<?php echo $fonte; ?>;text-decoration: underline">
                        <select style="background-color:transparent;font-weight:bold;color:#FFFFFF;border:0px solid" class="form-control" onchange="window.location = 'comprar.php?t=' + $(this).find('option:selected').val()">
                            <?php
                            foreach ($possiveis as $key => $value) {
                                ?>
                                <option style="color:#000000" value="<?php echo $value->numero; ?>"><?php echo $value->nome; ?></option>
                            <?php } ?>
                        </select>
                    </li>
                    <?php } ?>
                    <?php if(!$espelho && $usuario->empresa->rtc->numero>0){ ?>
                    <li class="nav-item ">
                        <a class="nav-link" href="comprar.php"><button class="btn btn-warning" onmousedown="tutorial('Compra Parceiros', 'Aqui voce pode comprar produtos da Agro Fauna, e de qualquer empresa do grupo Novos Rumos, adicione os produtos desejados ao seu carrinho de compras, e finalize seu pedido')" style="padding:0px;padding-left:4px;display:inline;margin: 0px">&nbsp<i class="fas fa-info"></i></button><i class="fa fa-fw fa-shopping-basket"></i>&nbspCompra Parceiros</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="carrinho-de-compras.php"><button class="btn btn-warning" onmousedown="tutorial('Carrinho', 'Aqui � onde voc� finalizar sua compra, depois de ja ter adcionado os itens ao carrinho na aba de Compra Parceiros, aqui voce tamb�m vai ver todos os impostos que estao incidindo sobre a sua compra.')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px"><i class="fas fa-info"></i>&nbsp</button><i class="fa fa-fw fa-shopping-cart"></i>Carrinho</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="encomenda_parceiros.php"><button class="btn btn-warning" onmousedown="tutorial('Encomenda Parceiros', 'Aqui voce pode encomendar produtos da Agro Fauna, e de qualquer empresa do grupo Novos Rumos, adicione os produtos desejados ao seu carrinho de compras, e finalize seu pedido')" style="padding:0px;padding-left:4px;display:inline;margin: 0px">&nbsp<i class="fas fa-info"></i></button><i class="fa fa-fw fa-shopping-basket"></i>&nbspEncomenda Parceiros</a>
                    </li>
                    
                    <li class="nav-item ">
                        <a class="nav-link" href="carrinho_encomenda.php"><button class="btn btn-warning" onmousedown="tutorial('Carrinho de Encomenda', 'Aqui � onde voc� finalizar sua encomenda, depois de ja ter adcionado os itens ao carrinho na aba de Encomenda Parceiros, aqui voce tamb�m vai ver todos os impostos que estao incidindo sobre a sua compra.')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px"><i class="fas fa-info"></i>&nbsp</button><i class="fa fa-fw fa-shopping-cart"></i>Carrinho de Encomenda</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="acompanhar-pedidos.php"><button class="btn btn-warning" onmousedown="tutorial('Acompanhamento de pedido', 'Aqui voce pode acompanhar seus pedidos realizados')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px"><i class="fas fa-info"></i>&nbsp</button><i class="fa fa-fw fa-eye"></i>Acompanhar Pedidos</a>
                    </li>
                    <li class="nav-divider" style="color:<?php echo $fonte; ?>;text-decoration: underline">
                        Operações com Terceiros
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="comprar_terceiros.php"><button class="btn btn-warning" onmousedown="tutorial('Compra Terceiros', 'Aqui voce pode comprar produtos de terceiros')" style="padding:0px;padding-left:4px;display:inline;margin: 0px">&nbsp<i class="fas fa-info"></i></button><i class="fa fa-fw fa-shopping-basket"></i>&nbspCompra Terceiros</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="encomenda_terceiros.php"><button class="btn btn-warning" onmousedown="tutorial('Encomenda Terceiros', 'Aqui voce pode encomendar produtos da Agro Fauna, e de qualquer empresa do grupo Novos Rumos, adicione os produtos desejados ao seu carrinho de compras, e finalize seu pedido')" style="padding:0px;padding-left:4px;display:inline;margin: 0px">&nbsp<i class="fas fa-info"></i></button><i class="fa fa-fw fa-shopping-basket"></i>&nbspEncomenda Terceiros</a>
                    </li>
                    <?php } ?>
                    <li class="nav-divider" style="color:<?php echo $fonte; ?>;text-decoration: underline">
                        <?php echo $empresa->nome; ?>
                    </li>
                    <?php if ($usuario->temPermissao(Sistema::P_ACOMPANHA_TAREFAS()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="acompanhar_atividades.php" ><button class="btn btn-warning" onmousedown="tutorial('Acompanhar atividades', 'Aqui voce consegue acompanhar as atividades de seus subordinados')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-check"></i>Acompanhar atividades</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_BANNERS()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="banners.php" ><button class="btn btn-warning" onmousedown="tutorial('Banners', 'Aqui voc� consegue confeccionar banners din�micos para entrar no RTC da sua empresa e serem enviados por email, esses banners tem que estar em formato HTML, e talvez precise de um profissional de marketing para criar esse HTML para voc�, mas depois que � criado o pr�prio sistema faz adapta��es nele para servir para qualquer situa��o')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-image"></i>Banners</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_GERENCIAR_CONSIGNADOS()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="gerenciar_consignados.php" ><button class="btn btn-warning" onmousedown="tutorial('Gerenciar Consignados', 'Aqui voce consegue gerenciar os produtos consignados de terceiros para aparecer no encomenda do RTC')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-list"></i>Gerenciar Consignados</a>
                        </li>
                    <?php } ?>
                        <?php if ($usuario->temPermissao(Sistema::P_CARGOS()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="cargos.php" ><button class="btn btn-warning" onmousedown="tutorial('Cargos', 'Aqui voce consegue gerenciar os cargos')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-adjust"></i>Cargos</a>
                        </li>
                    <?php } ?>
                        <?php if ($usuario->temPermissao(Sistema::P_IA_CHAT()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="ia_chat.php" ><button class="btn btn-warning" onmousedown="tutorial('Ia Chat', 'Aqui voce consegue alterar a inteligencia artificial do chat')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-sitemap"></i>Arvore Chat</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_TIPOS_ATIVIDADE()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="tipos_atividade.php" ><button class="btn btn-warning" onmousedown="tutorial('Tipos Atividade', 'Aqui voce consegue gerenciar os tipos de atividade')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-random"></i>Tipos de Atividade</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_TAREFA_SIMPLIFICADA()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="tarefa_simplificada.php" ><button class="btn btn-warning" onmousedown="tutorial('Tarefa Simplificada', 'Aqui voce pode realizar o cadastro das tarefas simplificadas, como principal objetivo a afericao de custos')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-tasks"></i>Atividades Simplificadas</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_RELATORIO_CLIENTES()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="relatorio_clientes.php" ><button class="btn btn-warning" onmousedown="tutorial('Relatorio de clientes', 'Aqui voce encontra um relatorio de clientes')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-male"></i>Relatorio Clientes</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_ENCOMENDA()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="encomenda.php" ><button class="btn btn-warning" onmousedown="tutorial('Encomenda', 'Aqui voc� pode gerenciar as encomendas realizadas')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-clock"></i>Encomendas</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_CONSIGNACAO_PRODUTO()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="consigna_produto.php" ><button class="btn btn-warning" onmousedown="tutorial('Consignar produto', 'Aqui voce pode consignar seus produtos para venda, atravez de um contrato')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-camera"></i>Consignar produtos</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_MOVIMENTO_PRODUTO()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="movimento_produto.php" ><button class="btn btn-warning" onmousedown="tutorial('Movimento de Estoque', 'Aqui voce pode conferir os movimentos do estoque')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-random"></i>Movimento de Estoque</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_ANALISE_COTACAO()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="analise_cotacao_entrada.php" ><button class="btn btn-warning" onmousedown="tutorial('Analise Cotacao', 'Aqui voc� pode gerenciar as encomendas realizadas')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-bars"></i>Analise Cotacao Entrada</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_BANCO()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="bancos.php" ><button class="btn btn-warning" onmousedown="tutorial('Bancos', 'Aqui voc� faz o cadastro de seus bancos com saldos, agencia, conta e outros dados, pode alterar e excluir tamb�m')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-calculator"></i>Bancos</a>
                        </li>
                    <?php } ?>   
                    <?php if ($usuario->temPermissao(Sistema::P_PRODUTO()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="cadastro-de-produtos.php"><button class="btn btn-warning" onmousedown="tutorial('Cadastro de Produtos', 'Aqui � onde seus produtos s�o cadastrados, podem ser excluidos e/ou alterados tamb�m. ')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-cube"></i>Cadastro de Produtos</a>
                        </li>
                    <?php } ?>    
                    <?php if ($usuario->temPermissao(Sistema::P_CAMPANHA()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="campanhas.php" ><button class="btn btn-warning" onmousedown="tutorial('Campanhas', 'Aqui � onde voc� define promo��es para os seus produtos, e tamb�m pode consultar e alterar parametros promocionais')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-anchor"></i>Campanhas</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_CFG()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="cfg.php" ><button class="btn btn-warning" onmousedown="tutorial('CFG', 'Aqui � onde voc� cria novos usuarios para a sua empresa, atribui autoriza��es e retira')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-male mr-2"></i>CFG</a>
                        </li>         
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_CLIENTE()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="clientes.php" ><button class="btn btn-warning" onmousedown="tutorial('Clientes', 'Aqui � o cadastro de clientes, onde voc� pode cadastrar, excluir e alterar seus clientes')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-users"></i>Clientes</a>
                        </li>
                    <?php } ?>    
                    <?php if ($usuario->temPermissao(Sistema::P_CONFIGURACAO_EMPRESA()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="configuracao-empresa.php" ><button class="btn btn-warning" onmousedown="tutorial('Configuracao da Empresa', 'Aqui � onde voc� cadastra os dados da sua empresa, para que o sistema deixe algumas coisas automaticas para voc�, caso voc� tenha o modulo de emiss�o de nota tamb�m ira cadastrar o seu certificado digitao aqui')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-compass"></i>Config. Empresa</a>
                        </li>         
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_COTACAO()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="cotacao-compra.php"><button class="btn btn-warning" onmousedown="tutorial('Cotacao', 'Aqui � onde voc� pode fazer uma cota��o com os seus fornecedores, quando voc� finaliza a cota��o, ele envia um email para o seu fornecedor, com a poss�bilidade dele responder pelo pr�prio email, e quando isso acontece a resposta dele ja entra no seu sistema automaticamente.')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-check-square"></i>Cotacao</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_ENTRADA_NFE()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="entrada_nota.php"><button class="btn btn-warning" onmousedown="tutorial('Entrada de Nota', 'Aqui � onde voc� da a entrada nas suas notas, aqui ocorre rela��o com o pedido de compra para que as altera��es de estoque sejam computadas de forma integra, sem depender da nota do fornecedor, portanto � necess�rio sempre um pedido de compra para dar entrada em uma NFe')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-code"></i>Entrada NFe</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_EXPEDIENTE()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="expediente.php" ><button class="btn btn-warning" onmousedown="tutorial('Expediente', 'Aqui voce cadastra o expediente, e faltas de seus colaboradores')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-clock mr-2"></i>Expediente</a>
                        </li>
                    <?php } ?>    
                    <?php if ($usuario->temPermissao(Sistema::P_FECHAMENTO_CAIXA()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="fechamento_caixa.php"><button class="btn btn-warning" onmousedown="tutorial('Fechamento caixa', 'Aqui e onde voce faz os fechamentos do caixa')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-money-bill-alt"></i>Fechamento de caixa</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_FORNECEDOR()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="fornecedores.php" ><button class="btn btn-warning" onmousedown="tutorial('Fornecedores', 'Aqui voc� faz o cadastro de seus fornecedores, altera��o, exclus�o, habilita��o e desabilita��o')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-industry"></i>Fornecedores</a>
                        </li>
                    <?php } ?>    
                    <?php if ($usuario->temPermissao(Sistema::P_GERENCIADOR()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="gerenciador.php" ><button class="btn btn-warning" onmousedown="tutorial('Gerenciador', 'Aqui voc� consegue ver os usuarios que estao online no per�odo selecionado, ou que entraram no periodo selecionado, apareceram com uma bolinha verde os que estiverem online, e uma vermelha para os que ja sairam, al�m disso aqui voc� consegue ver parametros como a quantidade maxima de usuarios que acessam simultaneamente o RTC em um periodo, tamb�m consegue checar dados de um usu�rio especifico, ver sua pontua��o seus logs de acesso, e tamb�m via grafico, a frequencia de sua atividade')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-chart-bar"></i>Gerenciador</a>
                        </li>
                    <?php } ?>    






                    <?php if ($usuario->temPermissao(Sistema::P_LISTA_PRECO()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="lista-de-preco.php" ><button class="btn btn-warning" onmousedown="tutorial('Lista de pre�o', 'Esta � uma pagina de consulta para que voc� consiga fazer o seu receituario, contem todas as rela��es de praga, produto e cultura')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-clipboard-list"></i>Receituario</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_LOTE()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="lotes.php"><button class="btn btn-warning" onmousedown="tutorial('Lotes', 'Aqui � onde s�o administrados os lotes de cada um dos produtos que utilizam o sistema de lotes, podem ser cadastrados, e ter impressas as etiquetas de cada um deles')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-cubes"></i>Lotes</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_MOVIMENTO()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="movimentos_banco.php" ><button class="btn btn-warning" onmousedown="tutorial('Movimentos', 'Aqui voc� faz as baixas das notas fiscais, cadastrando o movimento para ela, o mesmo relacionado a um banco, um c�digo de opera��o e hist�rico, ele ja faz a corre��o de saldo automaticamente tamb�m')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-money-bill-alt"></i>Movimentos Financeiro</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_NOTA()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="notas.php"><button class="btn btn-warning" onmousedown="tutorial('Notas', 'Aqui est�o todas as fichas, de sa�da e entrada, podem ser cadastradas quando for necess�rio, realizam movimenta��o no estoque, e tamb�m � a parte do sistema destinada a emiss�o de nota, onde o pr�prio sistema emite as notas aqui inseridas')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-book"></i>Notas</a>
                        </li>                  
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_ORGANOGRAMA()->m("C")) || $usuario->temPermissao(Sistema::P_ORGANOGRAMA_TOTAL()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="organograma.php" ><button class="btn btn-warning" onmousedown="tutorial('Organograma', 'Aqui e onde voce cria as relacoes hierarquicas de sua empresa')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-sitemap mr-2"></i>Organograma</a>
                        </li>
                    <?php } ?>    
                    <?php if ($usuario->temPermissao(Sistema::P_PRODUTO_CLIENTE()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="produto-cliente-logistic.php"><button class="btn btn-warning" onmousedown="tutorial('Produtos Logistic', 'Aqui � onde a empresa de armazenamento, ve os produtos de seus clientes, com respectivos estoques que est�o armazenados no armaz�n')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-camera"></i>Produtos cliente Logistic</a>
                        </li>
                    <?php } ?>

                    <?php if ($usuario->temPermissao(Sistema::P_RELACAO_CLIENTE()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="relacao_clientes.php"><button class="btn btn-warning" onmousedown="tutorial('Relacao Cliente', 'Aqui e onde voce ve a situacao dos clientes das empresas')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-male"></i>Relacao Clientes</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_TAREFAS()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="tarefas.php" ><button class="btn btn-warning" onmousedown="tutorial('Atividades', 'Aqui e onde voce ve suas atividades e cria novas atividades')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-tasks mr-2"></i>Atividades</a>
                        </li>
                    <?php } ?>    
                    <?php if ($usuario->temPermissao(Sistema::P_TRANSPORTADORA()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="transportadoras.php" ><button class="btn btn-warning" onmousedown="tutorial('Transportadoras', 'Aqui � onde ficam cadastradas todas as suas transportadoras, � poss�vel tamb�m alterar e excluir, al�m disso o RTC conta com um sistema de calculo de frete bastante interessante onde voc� pode cadastrar sua tabela atrav�s de express�es matem�ticas, e o sistema ent�o passa a calcular seu frete automaticamente, nos seus pedidos para os seus clientes, al�m disso a consulta de tabela fica disponivel aqui mesmo para fazer uma simula��o de frete')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-truck"></i>Transportadoras</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_PROTOCOLOS()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="protocolos.php" ><button class="btn btn-warning" onmousedown="tutorial('Protocolos', 'Aqui voce pode iniciar protocolos')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-fire"></i>Protocolos</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_PEDIDO_ENTRADA()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="visualizar-pedidos-compra.php"><button class="btn btn-warning" onmousedown="tutorial('Pedido de compra', 'Aqui � onde ficam seus pedidos de compra, com o seu fornecedor, tamb�m � enviado um email de confirma��o de pedido ap�s a conclus�o do mesmo, o pedido gera interfer�ncia no estoque e � a partir dele que a entrada de NFe vai acontecer')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-tasks"></i>Pedidos de Compra</a>
                        </li>
                    <?php } ?>
                    <?php if ($usuario->temPermissao(Sistema::P_PEDIDO_SAIDA()->m("C"))) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="visualizar-pedidos-venda.php"><button class="btn btn-warning" onmousedown="tutorial('Pedido de Venda', 'Aqui � onde voc� cria os pedidos de venda para os seus clientes, j� levando em considera��o suas promo��es e fazendo as movimenta��es de estoque conforme necess�rio')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-tasks"></i>Pedidos de Venda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="visualizar-pedidos-reserva.php"><button class="btn btn-warning" onmousedown="tutorial('Pedido de Reserva', 'Aqui � onde voc� cria os pedidos de reserva para reservar estoque')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-industry"></i>Pedidos de Reserva</a>
                        </li>
                    <?php } ?>
                    <li class="nav-divider" style="color:<?php echo $fonte; ?>;text-decoration: underline">
                        Relatorios
                    </li>   
                    <li class="nav-item" ng-repeat="relatorio in relatorios">
                        <a class="nav-link" href="relatorios.php?rel={{relatorio.id}}" ><button class="btn btn-warning" onmousedown="tutorial('Relatorios', 'Essa � uma parte destinada a gera��o de relatorios, voc� pode solicitar o relat�rio que desejar para a equipe da Agrofauna T�cnologia.')" style="padding:0px;padding-left:4px;width:20px;height:20px;display:inline;margin:0px">&nbsp<i class="fas fa-info"></i></button>&nbsp<i class="fas fa-paper-plane"></i>{{relatorio.nome}}</a>
                    </li>    
                    <li class="nav-divider" style="color:<?php echo $fonte; ?>;text-decoration: underline">
                        Administrativo RTC
                    </li>
                    <?php if(!$espelho){ ?>
                        
                    <?php }else{ ?>
                        <li class="nav-item ">
                            <a class="nav-link" href="institucional_32749737000106.php" >&nbsp<i class="fa fa-fw fa-file-alt"></i>Institucional da Virtual Negócios e Serviços</a>
                        </li>
                    <?php } ?>
                    
                    <li class="nav-item ">
                        <a class="nav-link" href="http://agrofauna.com.br/apresentacao_rtc_v6.pdf" target="_blank"><i class="fa fa-fw fa-file-alt"></i>Projeto Novos Rumos</a>
                    </li>
                    <?php if(!$espelho){ ?>
                        <li class="nav-item ">
                            <a class="nav-link" href="http://agrofauna.com.br/apresentacao_rtc_passo_a_passo_v6.pdf" target="_blank"><i class="fa fa-fw fa-file-alt"></i>Passo a Passo de seu RTC</a>
                        </li>
                    <?php }else{ ?>
                        <li class="nav-item ">
                            <a class="nav-link" href="https://www.rtcagro.com.br/consignar_produtos_passo_a_passo_v5.pdf" target="_blank"><i class="fa fa-fw fa-file-alt"></i>Passo a Passo - produto consignado</a>
                        </li>

                    <?php } ?>
                    
                    <?php if(!$espelho){ ?>
                    <li class="nav-item " style="margin-bottom:150px">
                        <a class="nav-link" href="contrato.php" ><i class="fa fa-fw fa-file-alt"></i>Contrato</a>
                    </li>
                    <?php }else{ ?>

                    <?php } ?>

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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">�</span></button>
            </div>
            <div class="modal-body text-center" id="conteudoTutorial">


            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<script>

    var mx = 0;
    var my = 0;
    var drg = false;
    $("#drag_protocolos").mousedown(function(e){

        mx = e.clientX - $(this).offset().left;
        my = e.clientY - $(this).offset().top;
        drg = true;

    })

            $(document).mousemove(function(e){
    if (drg){
    $("#drag_protocolos").css('left', (e.clientX - mx) + "px").css('top', (e.clientY - my - $(document).scrollTop()) + "px");
    }
    })


    var us = 0;

    $(document).scroll(function(){

        var diff = $(this).scrollTop()-us;

        us+=diff;



        $("#drag_protocolos").css('top',(($("#drag_protocolos").offset().top-$(document).scrollTop())-diff)+"px");


    })


            $(document).mouseup(function(){

    drg = false;
    })
    
    
    var hd = false
    $("#btnEsconde").click(function(){
        
        if(!hd){
            
            $("#chat_protocolos").hide();
            $("#drag_protocolos").css('left',($(window).width()-220)+"px").css("top","40px");
            hd = true;
        }else{
            
            $("#chat_protocolos").show();
            hd = false;

            var k = $(window).width();
            var l = $("#drag_protocolos").offset().left + $("#drag_protocolos").width(); 

            if(l>k){

                $("#drag_protocolos").css('left',(($(window).width()-20)-$("#drag_protocolos").width())+"px");


            }

        }
        
        
    })
    
    var data = new Date();

    $("#drag_protocolos").css('left',($(window).width()-220)+"px");


            function tutorial(titulo, conteudo){

            $('#tituloTutorial').html(titulo);
            $("#conteudoTutorial").html(conteudo);
            $("#tutorial").modal("show");
            }
            
            function mostraSuporte(){
                
                
                $("#chat_suporte").modal("show");
                $('.modal-backdrop').removeClass("modal-backdrop");  
                setTimeout(function(){
                    
                    $("#chat_suporte").find("textarea")[0].focus();
                    
                },2000);
                
            }
            
            setInterval(function(){
                
                $(".modal-open").each(function(){
                    
                    $(this).removeClass("modal-open");
                    
                })
                
                $(".scrollBottom").each(function(){
                
                    $(this).scrollTop($(this).prop("scrollHeight"));
                
                })
                
            },500)
            
            

</script>
