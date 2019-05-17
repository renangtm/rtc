<!doctype html>
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
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/fixedHeader.bootstrap4.css">
        <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">-->
        <title>RTC (Reltrab Cliente) - WEB</title>
        <style type="text/css">

            .nodo{

                border-radius: 4px;
                border:2px solid #000000;
                background-color:#FFFFFF;
                z-index: 20;
                text-align: right;
                color:#000000;
                font-family: Arial;
                font-weight: bold;
                padding-top:5px;
            }

            .nodo button{
                width:20px;
                padding:0px;
                margin-right:4px;
            }

            .nodo div{
                height:2px !important;
                text-align: center;
            }

            .nodo:hover{

                border-radius: 4px;
                border:2px solid #000000;
                background-color:#FFFFFF;
                z-index: 20;
                text-align: right;
                color:#000000;
                font-family: Arial;
                font-weight: bold;
                padding-top:5px;

            }

        </style>
    </head>

    <body ng-controller="crtOrganograma">
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
                                    <h2 class="pageheader-title">Organograma</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Organograma</li>
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
                                        <button class="btn btn-outline-success" id="btIn"><i class="fas fa-plus-circle"></i></button>
                                        <button class="btn btn-outline-danger" id="btOut"><i class="fas fa-minus-circle"></i></button>

                                        <button class="btn btn-success" style="float:right" onclick="salvar()"><i class="fas fa-check"></i>&nbsp Confirmar Alteracoes</button>
                                        <hr>
                                        <div id="corpo" style="height:1000px">



                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="modal fade" id="usuarios" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-search-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Selecione o usuario</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" class="form-control" placeholder="Filtro" id="filtroUsuarios">
                                        <hr>
                                        <table id="lista_usuarios" class="table table-striped table-bordered first">
                                            <thead>
                                                <tr>
                                                    <th data-ordem="usuario.id">Cod.</th>
                                                    <th data-ordem="usuario.nome">Nome</th>
                                                    <th>Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="usuario in usuarios.elementos">
                                                    <td>{{usuario[0].id}}</td>
                                                    <td>{{usuario[0].nome}}</td>
                                                    <td>
                                                        <div class="product-btn">
                                                            <a href="#" class="btn btn-outline-light btninfo" data-toggle="collapse" id="{{usuario[0].id}}___{{usuario[0].nome}}" onclick="setUsuario($(this).attr('id').split('___')[0], $(this).attr('id').split('___')[1])"><i class="fas fa-certificate"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Cod.</th>
                                                    <th>Nome</th>
                                                    <th>Ação</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">

                                            <div class="page-item" ng-click="usuarios.prev()" style="width:105px;display: inline-block;margin-left: 5px;margin-bottom:5px"><a class="page-link" href="">Anterior</a></div>
                                            <div class="page-item" ng-repeat="pg in usuarios.paginas" ng-click="pg.ir()" style="width:40px;display: inline-block;margin-left: 5px;margin-bottom:5px"><a class="page-link" style="{{pg.isAtual?'border:2px solid':''}}">{{pg.numero + 1}}</a></div>
                                            <div class="page-item" ng-click="usuarios.next()" style="width:105px;display: inline-block;margin-left: 5px;margin-bottom:5px"><a class="page-link" href="">Próximo</a></div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="copyright">
                                    <p>Copyright © 2018 - Agro Fauna Tecnologia. Todos os direitos reservados.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

                                                        var arvore = <?php
            $o = new Organograma($empresa);
            if ($usuario->temPermissao(Sistema::P_ORGANOGRAMA_TOTAL()->m("C"))) {
                $raiz = $o->getRaiz(new ConnectionFactory());
                echo Utilidades::toJson($raiz);
            } else if ($usuario->temPermissao(Sistema::P_ORGANOGRAMA()->m("C"))) {
                $raiz = $o->getNodo(new ConnectionFactory(),$usuario);
                echo Utilidades::toJson($raiz);
            }
            ?>;
                                                        //-------------------------------



                                                        var one = true;
                                                        var nodo_selecionado = null;
                                                        var adcionar = false;


                                                        var corpo = $('#corpo');
                                                        corpo.css('position', 'relative');
                                                        corpo.css('overflow', 'hidden');
                                                        corpo.css('cursor', 'move');
                                                        var max_id = 0;
                                                        function maxId(a) {

                                                            var max = a.id;
                                                            for (var i = 0; i < a.filhos.length; i++) {
                                                                var x = maxId(a.filhos[i]);
                                                                if (x > max)
                                                                    max = x;
                                                            }

                                                            return max;
                                                        }

                                                        max_id = maxId(arvore);
                                                        var x = 30;
                                                        var y = 0;
                                                        var zoom = 1;
                                                        var dx = 0;
                                                        var dy = 0;
                                                        var mv = false;
                                                        var objetos = [];
                                                        var posicoes = [];
                                                        var espacamento_vertical = 30;
                                                        var espacamento_horizontal = 30;
                                                        var w = 170;
                                                        var h = 60;
                                                        function getNumberOfLeafs(node) {

                                                            var num = 0;
                                                            if (node.filhos.length == 0)
                                                                return 1;
                                                            for (var i = 0; i < node.filhos.length; i++) {

                                                                num += getNumberOfLeafs(node.filhos[i]);
                                                            }

                                                            return num;
                                                        }
                                                        var nl = getNumberOfLeafs(arvore);
                                                        var offset = (corpo.height() / 2) - ((nl * (h + espacamento_vertical)) / 2);
                                                        var mens = [];
                                                        var crt = [];
                                                        var max = 9999999;
                                                        var nodoAlteracao = null;
                                                        function makeNode(xx, yy, nodo) {



                                                            var lm = mens.length;
                                                            mens[lm] = [];
                                                            crt[lm] = false;
                                                            var dvNome = $('<div></div>').html(nodo.nome_usuario);
                                                            var dvAdd = $('<button></button>').html('<i class="fa fa-plus"></i>').addClass("btn btn-outline-success");
                                                            mens[lm][0] = dvAdd;
                                                            var dvUpd = $('<button></button>').html('<i class="fa fa-save"></i>').addClass("btn btn-outline-default");
                                                            mens[lm][1] = dvUpd;
                                                            var dvRm = $('<button></button>').html('<i class="fa fa-minus"></i>').addClass("btn btn-outline-danger");
                                                            mens[lm][2] = dvRm;
                                                            var len = objetos.length;
                                                            objetos[objetos.length] = $('<div></div>').addClass('nodo').css('position', 'absolute').css('width', w + 'px').css('height', h + 'px').css('left', (xx + x) + "px").css('top', (yy + y) + "px").appendTo(corpo).css('z-index', 1).append(dvNome).append($("<br></br>")).append(dvAdd).append(dvUpd).append(dvRm);
                                                            max--;
                                                            posicoes[posicoes.length] = {x: xx + x, y: yy + y, width: w, height: h};
                                                            dvAdd.click(function (e) {

                                                                nodo_selecionado = nodo;
                                                                $("#usuarios").modal('show');
                                                                adcionar = true;
                                                            })

                                                            dvUpd.click(function () {

                                                                nodo_selecionado = nodo;
                                                                $("#usuarios").modal('show');
                                                                adcionar = false;
                                                            })

                                                            dvRm.click(function (ex) {


                                                                var nds = [arvore];
                                                                lbl:
                                                                        for (var i = 0; i < nds.length; i++) {

                                                                    for (var j = 0; j < nds[i].filhos.length; j++) {

                                                                        if (nds[i].filhos[j] == nodo) {

                                                                            var fs = nds[i].filhos;
                                                                            fs[j] = null;
                                                                            for (; j < fs.length - 1; j++) {
                                                                                fs[j] = fs[j + 1];
                                                                            }

                                                                            fs.length--;
                                                                            corpo.find('*').each(function () {
                                                                                $(this).remove();
                                                                            })
                                                                            formarArvore(arvore, offset, 0);
                                                                            one = true;
                                                                            gerarFundo();
                                                                            break lbl;
                                                                        }

                                                                        nds[nds.length] = nds[i].filhos[j];
                                                                    }

                                                                }

                                                            })
                                                        }


                                                        function formarArvore(node, ofst, level) {

                                                            if (node.filhos.length == 0) {

                                                                makeNode(level * (espacamento_horizontal + w), ofst, node);
                                                                return h;
                                                            }

                                                            var nofst = ofst;
                                                            var l = [];
                                                            for (var i = 0; i < node.filhos.length; i++) {

                                                                var hr = formarArvore(node.filhos[i], nofst, level + 1);
                                                                l[l.length] = hr;
                                                                nofst += hr + espacamento_vertical;
                                                                objetos[objetos.length] = $('<div></div>').css('position', 'absolute').css('width', (espacamento_vertical / 2) + "px").css('height', '1px').css('border', '1px solid').css('left', ((level + 1) * (espacamento_horizontal + w) - (espacamento_vertical / 2) + x) + "px").css('top', (nofst - espacamento_vertical - (hr / 2) + y) + "px").css('background-color', '#000000').appendTo(corpo);
                                                                posicoes[posicoes.length] = {x: ((level + 1) * (espacamento_horizontal + w) - (espacamento_vertical / 2)) + x, y: (nofst - espacamento_vertical - (hr / 2)) + y, width: (espacamento_vertical / 2), height: 1};
                                                            }

                                                            nofst -= espacamento_vertical;
                                                            var ini = ofst + l[0] / 2;
                                                            var fn = nofst - l[l.length - 1] / 2;
                                                            objetos[objetos.length] = $('<div></div>').css('position', 'absolute').css('width', '1px').css('height', (fn - ini) + 'px').css('border', '1px solid').css('left', ((level + 1) * (espacamento_horizontal + w) - (espacamento_vertical / 2) + x) + "px").css('top', (ini + y) + "px").css('background-color', '#000000').appendTo(corpo);
                                                            posicoes[posicoes.length] = {x: ((level + 1) * (espacamento_horizontal + w) - (espacamento_vertical / 2)) + x, y: ini + y, width: 1, height: (fn - ini)};
                                                            objetos[objetos.length] = $('<div></div>').css('position', 'absolute').css('width', (espacamento_vertical / 2) + "px").css('height', '1px').css('border', '1px solid').css('left', ((level + 1) * (espacamento_horizontal + w) - (espacamento_vertical) + x) + "px").css('top', (((nofst - ofst) / 2) + ofst + y) + "px").css('background-color', '#000000').appendTo(corpo);
                                                            posicoes[posicoes.length] = {x: ((level + 1) * (espacamento_horizontal + w) - (espacamento_vertical)) + x, y: (((nofst - ofst) / 2) + ofst) + y, width: (espacamento_vertical / 2), height: 1};
                                                            var k = (((nofst - ofst) / 2) - (h / 2)) + ofst;
                                                            makeNode(level * (espacamento_horizontal + w), k, node);
                                                            return nofst - ofst;
                                                        }


                                                        formarArvore(arvore, offset, 0);
                                                        corpo.mousedown(function (e) {

                                                            if (e.which != 1)
                                                                return;
                                                            dx = e.clientX;
                                                            dy = e.clientY;
                                                            mv = true;
                                                            //e.preventDefault();
                                                            e.stopPropagation();
                                                        })

                                                        corpo.mousemove(function (e) {

                                                            if (mv) {

                                                                var mx = e.clientX - dx;
                                                                var my = e.clientY - dy;
                                                                for (var i = 0; i < objetos.length; i++) {

                                                                    objetos[i].css('left', (posicoes[i].x + mx) + "px");
                                                                    objetos[i].css('top', (posicoes[i].y + my) + "px");
                                                                }

                                                                x += mx;
                                                                y += my;
                                                                gerarFundo();
                                                                x -= mx;
                                                                y -= my;
                                                            }

                                                            e.preventDefault();
                                                            e.stopPropagation();
                                                        });
                                                        $(document).mouseup(function (e) {

                                                            if (mv) {

                                                                var mx = e.clientX - dx;
                                                                var my = e.clientY - dy;
                                                                for (var i = 0; i < objetos.length; i++) {

                                                                    objetos[i].css('left', (posicoes[i].x + mx) + "px");
                                                                    objetos[i].css('top', (posicoes[i].y + my) + "px");
                                                                    posicoes[i].x += mx;
                                                                    posicoes[i].y += my;
                                                                }

                                                                x += mx;
                                                                y += my;
                                                                mv = false;
                                                            }

                                                            e.preventDefault();
                                                            e.stopPropagation();
                                                        })


                                                        var one = true;
                                                        $("#btIn").click(function () {



                                                            setTimeout(function () {

                                                                objetos = [];
                                                                posicoes = [];
                                                                var fat = 1.1;
                                                                x *= fat;
                                                                y *= fat;
                                                                offset *= fat;
                                                                zoom *= fat;
                                                                espacamento_vertical *= fat;
                                                                espacamento_horizontal *= fat;
                                                                w *= fat;
                                                                h *= fat;
                                                                corpo.find('*').each(function () {
                                                                    $(this).remove();
                                                                })
                                                                one = true;
                                                                formarArvore(arvore, offset, 0);
                                                                gerarFundo();
                                                            }, 100);
                                                        })

                                                        $("#btOut").click(function () {

                                                            setTimeout(function () {
                                                                objetos = [];
                                                                posicoes = [];
                                                                var fat = 1.1;
                                                                x /= fat;
                                                                y /= fat;
                                                                offset /= fat;
                                                                zoom /= fat;
                                                                espacamento_vertical /= fat;
                                                                espacamento_horizontal /= fat;
                                                                w /= fat;
                                                                h /= fat;
                                                                corpo.find('*').each(function () {
                                                                    $(this).remove();
                                                                })
                                                                one = true;
                                                                formarArvore(arvore, offset, 0);
                                                                gerarFundo();
                                                            }, 100);
                                                        })


                                                        var lns = [];
                                                        function gerarFundo() {

                                                            if (!one)
                                                                return;
                                                            one = false;
                                                            for (var i = 0; i < lns.length; i++) {
                                                                lns[i].remove();
                                                            }
                                                            lns.length = 0;
                                                            var sz = 40 * zoom;
                                                            for (var xx = (x % sz); xx < corpo.width(); xx += sz) {

                                                                lns[lns.length] = $('<div></div>').css('color', '#999999').css('border', '1px dashed').css('width', '1px').css('height', '300vh').css('position', 'absolute').css('top', '0px').css('left', xx + "px").appendTo(corpo);
                                                            }

                                                            for (var yy = (y % sz); yy < corpo.height(); yy += sz) {

                                                                lns[lns.length] = $('<div></div>').css('color', '#999999').css('border', '1px dashed').css('width', '100vw').css('heigth', '1px').css('position', 'absolute').css('top', yy + 'px').css('left', "0px").appendTo(corpo);
                                                            }

                                                        }

                                                        function jaExiste(raiz, id) {

                                                            if (raiz.id_usuario === id) {

                                                                return raiz;

                                                            }

                                                            for (var i = 0; i < raiz.filhos.length; i++) {

                                                                var k = jaExiste(raiz.filhos[i], id);
                                                                if (k !== null) {

                                                                    return k;

                                                                }

                                                            }

                                                            return null;

                                                        }

                                                        function setUsuario(id, nome) {

                                                            id = parseInt("" + id);

                                                            if (adcionar) {

                                                                if (jaExiste(arvore, id) !== null) {
                                                                    msg.erro("Esse usuario ja esta cadastrado");
                                                                    return;
                                                                }

                                                                corpo.find('*').each(function () {
                                                                    $(this).remove();
                                                                })
                                                                var nodo = {id: 0, nome_usuario: nome, id_usuario: id, filhos: []};
                                                                nodo_selecionado.filhos[nodo_selecionado.filhos.length] = nodo;

                                                                formarArvore(arvore, offset, 0);
                                                                one = true;
                                                                gerarFundo();

                                                            } else {

                                                                var usu = jaExiste(arvore, id);

                                                                corpo.find('*').each(function () {
                                                                    $(this).remove();
                                                                })

                                                                if (usu !== null) {
                                                                    usu.id = 0;
                                                                    usu.id_usuario = nodo_selecionado.id_usuario;
                                                                    usu.nome_usuario = nodo_selecionado.nome_usuario;
                                                                }

                                                                nodo_selecionado.id = 0;
                                                                nodo_selecionado.id_usuario = id;
                                                                nodo_selecionado.nome_usuario = nome;

                                                                formarArvore(arvore, offset, 0);
                                                                one = true;
                                                                gerarFundo();


                                                            }

                                                        }

                                                        gerarFundo();

                                                        var sucesso = function (r) {
                                                            if (r.sucesso) {
                                                                arvore = r.o.arvore;
                                                                msg.alerta("Confirmado com sucesso");
                                                                corpo.find('*').each(function () {
                                                                    $(this).remove();
                                                                })
                                                                formarArvore(arvore, offset, 0);
                                                                one = true;
                                                                gerarFundo();
                                                            } else {
                                                                msg.erro("Houve um erro ao confirmar, tente novamente mais tarde");
                                                            }
                                                        }
                                                        function salvar() {
                                                            jsBaseService({
                                                                o: {arvore: arvore},
                                                                query: "$org=new Organograma($empresa);$org->alterar($c,$o->arvore)",
                                                                sucesso: sucesso,
                                                                falha: sucesso
                                                            });
                                                        }

                                                        //-------------------------------------------

                                                        var l = $('#loading');
                                                        l.hide();
                                                        var xxx = 0;
                                                        var yyy = 0;
                                                        $(document).mousemove(function (e) {

                                                            xxx = e.clientX;
                                                            yyy = e.clientY;
                                                            var s = $(this).scrollTop();
                                                            l.offset({top: (yyy + s), left: xxx});
                                                        })

                                                        var sh = false;
                                                        var it = null;
                                                        loading.show = function () {
                                                            l.show();
                                                            var s = $(document).scrollTop();
                                                            l.offset({top: (yyy + s), left: xxx});
                                                        }

                                                        loading.close = function () {
                                                            l.hide();
                                                        }





                </script>

                </body>

                </html>