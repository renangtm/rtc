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
        <style>
            .search_line{
                padding:10px;
                border-bottom:1px solid;
                cursor:pointer;
            }
            .search_line:hover{
                padding:10px;
                border-bottom:1px solid;
                cursor:pointer;
                color:#FFFFFF;
                background-color:SteelBlue
            }
            .pdt td{
                 padding:5px
            }
            
        </style>
    </head>

    <body ng-controller="crtConsignaProduto">
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
                                    <h2 class="pageheader-title">Consignacao de Produtos</h2>
                                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                    <div class="page-breadcrumb">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">      
                                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">RTC</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Fornecedores</li>
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
                                        <div class="table-responsive" style="overflow: hidden">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h3>Contrato de prestacao de serviço</h3>
                                                    <hr>
                                                    <select class="form-control" style="width:40%" ng-model="empresa_selecionada">
                                                        <option ng-repeat="emp in virtuais" ng-value="emp">{{emp.nome}}</option>
                                                    </select>
                                                    <br>
                                                    <div style="width:100%;height:600px;border:2px solid;overflow-y:scroll;padding:10px;margin:10px">
                                                        <h2>CONTRATO DE UTILIZAÇÃO DE PLATAFORMA DIGITAL PARA VENDAS ON LINE</h2>
                                                            <hr>

CONTRATANTE: <strong>{{empresa_av.nome}}</strong>, inscrita no CNPJ nº <strong>{{empresa_av.cnpj.valor}}</strong>, localizada na Rua <strong>{{empresa_av.endereco.rua}}</strong>, nº <strong>{{empresa_av.endereco.numero}}</strong>, na cidade de <strong>{{empresa_av.endereco.cidade.nome}}</strong>, neste ato representada por seu Sócio, Sr. <?php echo $usuario->nome; ?>, (qualificação):
<br><br>
CONTRATADA: <strong>{{empresa_selecionada.nome}}</strong>, inscrita no CNPJ nº <strong>{{empresa_selecionada.cnpj.valor}}</strong>, localizada na Rua <strong>{{empresa_selecionada.endereco.rua}}</strong>, nº <strong>{{empresa_selecionada.endereco.numero}}</strong>, na cidade de <strong>{{empresa_selecionada.endereco.cidade.nome}}</strong>, neste ato representada por seu Sócio, Sr. Elias Tadeu de Oliveira, brasileiro, divorciado, engenheiro agrônomo, portador do CPF nº 601.254.208-97 e do RG nº 7.895.953:
Celebram entre si o presente contrato particular de prestação de serviços a reger-se pelas condições adiante alinhadas, que mutuamente outorgam, aceitam e prometem cumprir, a saber: 
Ao aceitar eletronicamente ou particularmente esta contratação, o CONTRATANTE estará automaticamente aceitando aos termos aqui consignados, não podendo, em hipótese alguma, arguir desconhecimento sobre os mesmos. 
<br><br>

OBJETO Cláusula 1ª - A CONTRATADA se obriga a disponibilizar/licenciar uma plataforma de vendas – Loja Virtual, desenvolvida para possibilitar a comercialização de produtos diretamente pela internet.. 
<br><br>
Cláusula 2ª - A CONTRATANTE estará adquirindo apenas o direito de utilização do sistema através de interface própria disponibilizada pela CONTRATADA.
<br><br>
§ 1º - O licenciamento que tratamos não será exclusivo e nem é transferível.
<br><br>
§ 2º - A licença de uso será efetivada através de acesso via internet em servidores controlados pela CONTRATADA. 
<br><br>
Cláusula 3ª - As obrigações da CONTRATADA são as seguintes, além de outras já mencionadas: 
<br><br>
I - Responsabilizar-se pela manutenção da hospedagem da referida Loja Virtual em seus provedores de conteúdo. A CONTRATADA não se responsabiliza pela disponibilidade de serviços mantidos por terceiros.
<br><br> 
II - Manter informações sobre o cadastro da CONTRATANTE e de seus clientes em seus servidores, além de gerenciar e prestar todas as informações das transações realizadas através de sua plataforma de vendas. 
<br><br>
III - Disponibilizar ao CONTRATANTE acesso através de usuário e senha a um painel administrativo da loja virtual, permitindo assim o gerenciamento da mesma. 
<br><br>
IV - Disponibilizar, se necessário e pertinente, quaisquer melhorias ou modificações na loja virtual mediante novas licenças com condições a combinar, que venham a ser licenciados para se atingir os objetivos previstos neste instrumento; novos módulos/aplicações específicas ou exclusivas, estes deverão ser contratados separadamente, mediante novo acordo de prestação de serviços, a ser definido por adendo. 
<br><br>
V - Intervenções para corrigir as falhas que vierem a surgir no conteúdo desenvolvido, informando porventura a impossibilidade ou inviabilidade técnica. 
<br><br>
VI - Oferecer manutenção do conteúdo desenvolvido como, ajustes, atualizações e aperfeiçoamentos para melhor desempenho. 
<br><br>
§ 1º - Eventuais problemas que dificultem ou impossibilitem o cumprimento desta prestação, originados por culpa de terceiros ou de tecnologia aplicada, não configuram descumprimento contratual pela CONTRATADA. 
<br><br>
§ 2º - Toda a lógica de programação necessária para a perfeita transação das operações e funcionamento do sistema em epígrafe deverá ser desenvolvida especificamente dentro dos limites da proposta referida. 
<br><br>
Cláusula 4ª - O plano da loja virtual escolhida pelo CONTRATANTE dá direito de expor o limite máximo de produtos e limite máximo de vendas. 
<br><br>
§ 1º - Qualquer dos pacotes escolhidos conterá obrigatoriamente os seguintes itens: 
<br><br>
a) Hospedagem em servidor seguro, controlados pela CONTRATADA; 
<br><br>
b) Certificado SSL próprio ou compartilhado de segurança; 
<br><br>
c) Meio de pagamento integrado;
<br><br>
d) Controle de estoques e pedidos; 
<br><br>
e) Cálculo automático de frete;
<br><br>
 f) Simulador automático de parcelas; 
 <br><br>
g) Suporte permanente via acesso a HelpDesk, Chat ou Telefone; 
<br><br>
§ 2º - O plano inicial ora contratado pode ser alterado a qualquer momento pelo Lojista. 
<br><br>
Cláusula 5ª - A CONTRATADA não dará qualquer suporte a outra plataforma particular diversa da que ora especificou nas cláusulas acima. 
<br><br>
§ 1º - A CONTRATADA não fornece, nem se responsabiliza pelos produtos comercializados ou por qualquer operação relacionada á entrega ou cobrança, ficando sob a responsabilidade do CONTRATANTE toda administração. 
<br><br>
§ 2º - Fica reservado à CONTRATADA, por força deste instrumento, o direito de suspender temporariamente ou mesmo definitivamente o cadastramento e aceitação de novos contratos quando forem constatados problemas técnicos que impeçam o comércio eletrônico de funcionar,dentre elas:
<br><br>
I - As ilícitas, transmissão ou divulgação de ameaças, material que instigue o racismo ou a violência, dentre outros. 
<br><br>
II - Não realizar envio em massa de mensagens de e-mail não solicitadas denominados "SPAM" para a promoção de produtos, serviços ou entidades, de natureza comercial ou não, com ou sem fins lucrativos.
<br><br>
 III - Informar à CONTRATADA sobre toda campanha de marketing e/ou publicidade realizada em grande escala, afim de preservar os recursos e o pleno funcionamento dos serviços mantidos no servidor de hospedagem. 
 <br><br>
IV - Fornecer todas as informações corretas e completas sobre si e seu negócio, como pressuposto fundamental para a configuração de sua loja virtual e sua manutenção, sendo que a inobservância deste requisito dará direito a CONTRATADA de cancelar total ou parcialmente o fornecimento dos serviços ora contratados. 
<br><br>
V - Responsabilizar-se por todos os bens e serviços disponibilizados a comercialização, bem como todos os materiais e informações prestadas a seus clientes, sejam de qualquer natureza ou origem, estendendo-se, igualmente, a eventuais omissões e atos ilícitos que ocorram na sua loja, incluindo, mas não se limitando, às suas senhas de acesso. 
<br><br>
VI - Ser responsável pela reprodução e exibição de quaisquer obras intelectuais, imagens, informações próprias ou de terceiros, usadas na divulgação de seu comércio eletrônico.
<br><br>
VII - Não obter ou tentar obter acesso a qualquer servidor controlado pela CONTRATADA, sem que haja a escrita autorização. VIII - Manter regularmente todas as suas mensalidades em dia evitando o bloqueio parcial ou total da loja virtual.
<br><br>
§ Único - Reconhece que possui senha para acesso e uso dos recursos que lhe é disponibilizado por força deste instrumento, devendo, desta forma, mantê-la como confidencial, devendo notificar à CONTRATADA imediatamente se tiver qualquer suspeita de quebra da sua segurança. 
<br><br>
<h3>PROPRIEDADE INTELECTUAL</h3>
<br><br>
Cláusula 7ª - Os serviços contratados foram desenvolvidos e são licenciados pela CONTRATADA; as ferramentas utilizadas para a criação e implementação da referida loja virtual, é de propriedade exclusiva da mesma, que não fornece qualquer tipo de acesso ao código fonte e não permite em hipótese alguma a reprodução ou comercialização, sem consentimento prévio e escrito. 
<br><br>
§ 1º - A CONTRATADA garante que todo o material fornecido e colocado à disposição do CONTRATANTE se encontra devidamente protegido e tem a anuência expressa dos respectivos titulares dos direitos autorais e de imagem daí decorrentes, bem como de patentes, não se constituindo a sua utilização em violação de direitos, e/ou nem concorrência desleal, nos termos da norma legal aplicável; o mesmo não se aplica a loja disponibilizada para o CONTRATANTE onde o conteúdo exposto é de sua inteira responsabilidade. 
<br><br>
§ 2º - O CONTRATANTE, por conseguinte, reconhece que qualquer violação que venha a ocorrer neste particular deverá ser de sua inteira responsabilidade, assumindo o polo passivo de qualquer procedimento judicial que venha a ser intentado por terceiros, arcando com todas as despesas daí decorrentes. 
<br><br>
Cláusula 8ª - A propriedade intelectual de toda a linguagem de programação e de todo o conteúdo ora contratado é de propriedade exclusiva da CONTRATADA, mesmo que advenha rescisão contratual por qualquer das partes ou motivo. 
<br><br>
§ 1º - Aplica-se a este contrato o disposto nas Leis 9.609/98 (proteção da propriedade intelectual do software) e 9.610/98 (proteção dos direitos autorais). 
<br><br>
§ 2º - O direito sobre a propriedade intelectual ora tratada será transmitido aos herdeiros e ou sucessores dos CONTRATADOS, na forma da lei, podendo-os usufruir a maneira que mais lhes convier. 
GARANTIAS 
<br><br>
Cláusula 9ª - Os serviços prestados pelos CONTRATADOS são fornecidos observadas as condições estabelecidas neste instrumento, sem quaisquer outras garantias expressas ou implícitas de qualquer natureza diferentes das definidas pela lei vigente.
<br><br>
§ 1º - Este contrato e seus aditamentos não garantem que os serviços online da loja serão ininterruptos, por prazo indeterminado, livres de erros, pois os mecanismos incorporados têm limitações próprias. 
Cláusula 10ª - A CONTRATADA se responsabiliza pela integridade da Loja On-line, nos termos previstos neste instrumento, sendo que qualquer defeito havido determinará simplesmente a substituição ou correção do mesmo. 
<br><br>
<h3>PRAZO DE ENTREGA</h3>
Cláusula 11ª - A CONTRATADA se compromete a disponibilizar a aplicação retro determinada em até 48 (quarenta e oito) horas quando se tratar de um plano com estrutura padrão sem particularidades ou personalizações ou exclusividades contada da assinatura eletrônica deste instrumento, quando estará apta a ser utilizada pela CONTRATANTE. Para outros formatos de planos personalizados o prazo de liberação será aquele determinado e divulgado no momento da escolha e contratação do plano ou combinado particularmente. 
REMUNERAÇÃO 
<br><br>
Cláusula 12ª - A título de remuneração pela prestação dos serviços referidos, a CONTRATANTE pagará a CONTRATADA as importâncias abaixo elencadas:
<br><br>
 I - O valor do plano escolhido pelo CONTRATANTE deve ser pago de forma adiantada em relação uso da aplicação; os demais vencimentos mensais se darão em ciclos de 30 dias, a partir da data de pagamento da primeira mensalidade à vista, reajustáveis anualmente de acordo com a maior variação apurada entre os índices brasileiros. 
 <br><br>
§ 1º - O atraso na remuneração ora referida, sujeitará a CONTRATANTE a suspensão da loja virtual até a confirmação do pagamento. 
<br><br>
§ 2º - Caso não seja cumprida a determinação referida nesta cláusula, a CONTRATADA ficará desobrigada a cumprir o que ora se avença, podendo ainda inibir a utilização da aplicação porventura já entregue ao uso.
<br><br>
§ 3º - O pagamento referido no item I desta cláusula será preferencialmente feito por boleto bancário. 
<br><br>
§ 4º - Todas as mensalidades a vencer estará disponível para impressão de boleto no painel administrativo do lojista.
<br><br>
 § 5º - Os recibos de pagamentos serão os boletos, os comprovantes de depósito ou outros cupons emitidos pela instituição que realizará a operação, ficando a CONTRATADA responsável a prestar qualquer outro à CONTRATANTE, na hipótese de pagamento em moeda corrente ou para atender interesses da mesma. 
 <br><br>
<h3>DISPOSIÇÕES ESPECIAIS </h3>
Cláusula 13ª - Qualquer alteração das condições aqui ajustadas será considerada como ato de mera tolerância e liberalidade, não acarretando nem sendo considerada como novação ou alteração das mesmas, posto que tal providência só terá validade e surtirá efeitos permanentes para as Partes se forem efetivadas através de instrumento específico.
<br><br>
 § Único - A CONTRATADA se reserva o direito de fazer modificações, adições ou exclusões, no todo ou em parte, nas condições estabelecidas neste contrato, sem prejuízo para o CONTRATANTE das obrigações aqui assumidas, sendo que tal fato será comunicado ao CONTRATANTE, por aviso escrito por meios eletrônicos, especialmente via e-mail.
 <br><br>
a) Caso o CONTRATANTE não concorde com as modificações apresentadas, poderá rescindir este COMPROMISSO, observadas as condições aqui previstas. 
<br><br>
Cláusula 14ª - A CONTRATANTE arcará com o ônus financeiro dos tributos, contribuições sociais, encargos, dentre outras modalidades de impostos que porventura venham a incidir sobre o uso e destinação da loja virtual ora contratada, além de responder por direitos de terceiros eventualmente prejudicados. 
<br><br>
Cláusula 15ª - A CONTRATADA se exime de qualquer responsabilidade cível, criminal ou outras, pelo uso e destinação que será dado ao objeto ora contratado, ficando a CONTRATANTE exclusivamente obrigada a responder por danos porventura causados. 
<br><br>
§ Único - O CONTRATANTE concorda em proteger e isentar a CONTRATADA, ou ainda indenizar esta, suas controladoras, subsidiárias, afiliadas, administradores, acionistas, empregados e agentes, por quaisquer danos morais ou materiais sofridos de qualquer natureza. 
<br><br>
Cláusula 16ª - As partes se comprometem por si, seus funcionários e prepostos, a manter o mais absoluto sigilo sobre toda e qualquer informação, material e documentos, que venham a ter acesso por força do cumprimento do objeto deste contrato, sob pena de arcar com perdas e danos que vier a dar causa, por transgressão às disposições desta cláusula. 
<br><br>
Cláusula 17ª - A impossibilidade de prestação do serviço motivado por incorreção em informação fornecida pela CONTRATANTE ou por omissão no provimento de informação essencial à prestação, não caracterizará descumprimento de obrigação contratual pela CONTRATADA, isentando-a de toda e qualquer responsabilidade, ao tempo em que configurará o não cumprimento de obrigação por parte da CONTRATANTE. 
<br><br>
Cláusula 18ª - O CONTRATANTE neste ato declara estar ciente e de acordo que não mantém nenhum compromisso hierárquico ou trabalhista de qualquer natureza com a CONTRATADA, seja ele em relação a horário ou comparecimento a sede da mesma, não podendo alegar posteriormente qualquer vínculo empregatício. 
<br><br>
<h3>DISPOSIÇÕES GERAIS </h3>
<br><br>
Cláusula 19ª - Para fins de execução do serviço objeto deste contrato, o CONTRATANTE se compromete a fornecer todas as informações solicitadas pela CONTRATADA e efetuar o pagamento conforme já estipulado. 
Cláusula 20ª - As partes se obrigam a manter os seus dados comerciais devidamente atualizados; toda e qualquer alteração deverá ser comunicada imediatamente, uma à outra. 
<br><br>
Cláusula 21ª - Os direitos e obrigações decorrentes deste contrato somente poderão ser cedidos, mediante aviso prévio e escrito, com expresso consentimento das partes. 
<br><br>
Cláusula 22ª - Todo contato, solicitação e chamado formal entre as partes para tratar de assuntos ligados à prestação dos serviços, se dará por HelpDesk ou e-mail, nos endereços divulgados, ou acesso às dependências de escritório sede da CONTRATANTE, no horário comercial. 
<br><br>
<h3>VIGÊNCIA</h3>
<br><br>
Cláusula 24ª - O presente contrato é pactuado por prazo indeterminado a contar da data de assinatura deste, mas poderá ser rescindido por qualquer das partes, sem declinar o motivo, nas seguintes situações: 
<br><br>
I - em qualquer tempo pela CONTRATADA, mediante notificação à CONTRATANTE, com antecedência mínima de 30 (trinta) dias, mediante cumprimento das suas obrigações no prazo previsto para denuncia;
<br><br>
 II - em qualquer tempo pela CONTRATATE, mediante notificação à CONTRATADA, com antecedência mínima de 30 (trinta) dias, mediante cumprimento das suas obrigações no prazo previsto para denuncia; ]
 <br><br>
Cláusula 25ª - Qualquer das partes poderá rescindir de imediato este contrato, independentemente de notificação judicial ou extrajudicial, caso haja o descumprimento de qualquer cláusula ou condição ora estabelecida e, se notificada a parte faltosa, não tenha a mesma, num prazo de 7 (sete) dias a contar do recebimento pertinente, sanado a falta praticada ou justificado a razão de sua manutenção. 
<br><br>
§ 1º - Caso o ilícito tenha sido praticado pelo CONTRATANTE, a CONTRATADA se reserva o direito de suspender todo o acesso da loja virtual, bem como suspender a sua visibilidade na Internet, sem que caiba ao mesmo qualquer pedido de indenização, seja a que título for. 
<br><br>
a) A medida acima poderá ser igualmente aplicada caso a CONTRATADA, a seu critério, conclua que o CONTRATANTE esteja envolvido em atividade ilegal de qualquer natureza que possa prejudicar direitos da CONTRATADA ou de terceiros.
<br><br>
 § 2º - Caso o cancelamento do serviço seja solicitado pela CONTRATANTE, a CONTRATADA se isenta de quaisquer reembolso de mensalidades pagas. 
 <br><br>
Cláusula 26ª - Em qualquer hipótese de terminação do presente contrato, as condições relativas à proteção de direitos autorais, garantias e responsabilidades, confidencialidade e sigilo, permanecerão íntegras, sendo que sua observância subsistirá por prazo indeterminado.
<br><br>
 <h3>FORO </h3>
 <br><br>
Cláusula 27ª - O Foro de eleição, para todos os fins, será o da Comarca de São José do Rio Preto-SP, para dirimir quaisquer dúvidas ou eventuais dissídios relativos a este instrumento de contrato, inclusive nas ações de execução , excluindo-se qualquer outro por mais privilegiado que seja. 
<br><br>
E, assim justos e contratados, assinam o presente instrumento mediante aceitação dos termos e confirmação eletrônica, podendo cada parte imprimir uma via do mesmo.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <i class="fas fa-box" style="display: inline"></i>&nbsp <h4 style="display: inline">Seus produtos ja cadastrados</h4>
                                                    <hr>
                                                    <input type="text" class="form-control col-md-8" id="filtroProdutos2" placeholder="Filtro">
                                                    <br>

                                                    <table class="table table-striped table-bordered first">
                                                        <thead>
                                                        <th data-ordem="produto.codigo">Cod.</th>
                                                        <th data-ordem="produto.nome">Produto</th>
                                                        <th><i class="fas fa-mouse-pointer"></i></th>
                                                        </thead>
                                                        <tr ng-repeat="produt in produtos_av.elementos" style="cursor:pointer;" ng-click="selecionarPossibilidade(produt[0])">
                                                            <th style="{{produt[0].id===produto_av.id?'background-color:SteelBlue;color:#FFFFFF':''}}">{{produt[0].codigo}}</th>
                                                            <th style="{{produt[0].id===produto_av.id?'background-color:SteelBlue;color:#FFFFFF':''}}">{{produt[0].nome}}</th>
                                                            <th style="{{produt[0].id===produto_av.id?'background-color:SteelBlue;color:#FFFFFF':''}}"><i class="fas fa-square"></i></th>
                                                        </tr>
                                                    </table>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                                        <nav aria-label="Page navigation example">
                                                            <ul class="pagination justify-content-end">
                                                                <li class="page-item" ng-click="produtos_av.prev()"><a class="page-link" href="">Anterior</a></li>
                                                                <li class="page-item" ng-repeat="pg in produtos_av.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></li>
                                                                <li class="page-item" ng-click="produtos_av.next()"><a class="page-link" href="">Próximo</a></li>
                                                            </ul>
                                                        </nav>
                                                    </div>
                                                    <hr>
                                                    Produtos consignados atualmente
                                                    <br>

                                                    <table class="table table-striped table-bordered first">
                                                        <thead>
                                                        <th data-ordem="produto.codigo">Cod.</th>
                                                        <th data-ordem="produto.nome">Produto</th>
                                                        <th><i class="fas fa-trash"></i></th>
                                                        </thead>
                                                        <tr ng-repeat="produt in produtos_consignados.elementos">
                                                            <th>{{produt[0].codigo}}</th>
                                                            <th>{{produt[0].nome}}</th>
                                                            <th><button class="btn btn-danger" ng-click="deconsignar(produt[0])"><i class="fas fa-trash"></i></button></th>
                                                        </tr>
                                                    </table>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-30">
                                                        <nav aria-label="Page navigation example">
                                                            <ul class="pagination justify-content-end">
                                                                <li class="page-item" ng-click="produtos_consignados.prev()"><a class="page-link" href="">Anterior</a></li>
                                                                <li class="page-item" ng-repeat="pg in produtos_consignados.paginas" ng-click="pg.ir()"><a class="page-link" style="{{pg.isAtual?'border:2px solid #71748d !important':''}}">{{pg.numero + 1}}</a></li>
                                                                <li class="page-item" ng-click="produtos_consignados.next()"><a class="page-link" href="">Próximo</a></li>
                                                            </ul>
                                                        </nav>
                                                    </div>


                                                </div>
                                                <div class="col-md-6">
                                                    <i class="fas fa-truck" style="display: inline"></i>&nbsp <h4 style="display: inline">Produto para consignar</h4>
                                                    <hr>
                                                    <div ng-if="travado_av">
                                                        <button class="btn btn-danger" ng-click="destravar()">
                                                            <i class="fas fa-times"></i>
                                                            &nbsp;
                                                            Alterar produto
                                                        </button>
                                                        <hr>
                                                    </div>
                                                    <table style="width:100%" class="pdt">
                                                        <tr>
                                                            <td colspan="2" style="text-align:center">
                                                                <img src="{{produto_av.imagem}}" style="max-height:200px">
                                                                <hr>
                                                                <input type="file" multiple="true" style="visibility:hidden" id="flImg">
                                                                <button ng-disabled="travado_av" class="btn btn-success" onclick="$('#flImg').click()"><i class="fas fa-upload"></i>&nbspColocar imagem</button>
                                                            </td> 
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Nome:
                                                            </td>
                                                            <td style="position:relative">
                                                                <input ng-change="atualizarPossibilidades()" ng-disabled="travado_av" type="text" placeholder="Nome do produto" class="form-control" style="width:100%" ng-model="produto_av.nome">
                                                                <div ng-if="produtos_possiveis_av.length > 0 && !travado_av" style="width:100%;top:40px;background-color:#FAFAFA;border:3px solid SteelBlue">
                                                                    Foram encontrados produtos semelhantes no RTC, seria algum destes ?<br>
                                                                    <div ng-repeat="pos in produtos_possiveis_av" ng-click="selecionarPossibilidadeSemEstoque(pos)" class="search_line">
                                                                        <img style="height:40px" src="{{pos.imagem}}"></img>
                                                                        &nbsp;
                                                                        <strong>{{pos.nome}}</strong>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Fabricante:
                                                            </td>
                                                            <td>
                                                                <input ng-disabled="travado_av" type="text" placeholder="Nome do fabricante" class="form-control" style="width:90%" ng-model="produto_av.fabricante">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Custo Medio (R$):
                                                            </td>
                                                            <td>
                                                                <input type="number" placeholder="Custo Medio" class="form-control" style="width:40%" ng-model="produto_av.custo">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Preço de Venda (R$):
                                                            </td>
                                                            <td>
                                                                <input type="number" placeholder="Valor de venda" class="form-control" style="width:40%" ng-model="produto_av.valor_base">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Classe de Risco:
                                                            </td>
                                                            <td>
                                                                <input ng-disabled="travado_av" type="number" placeholder="Classe Risco" class="form-control" style="width:40%" ng-model="produto_av.classe_risco">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Ativo:
                                                            </td>
                                                            <td>
                                                                <input ng-disabled="travado_av" type="text" placeholder="Ativo" class="form-control" style="width:80%" ng-model="produto_av.ativo">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Estoque:
                                                            </td>
                                                            <td>
                                                                <input type="number" placeholder="Estoque" class="form-control" style="width:40%" ng-model="produto_av.estoque" ng-change="produto_av.disponivel=produto_av.estoque">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <hr>
                                                    <button class="btn btn-success" ng-disabled="!liberado()" ng-click="finalizar()">
                                                        <i class="fas fa-truck"></i>
                                                        &nbsp;
                                                        {{(!liberado()) ? "Digite as informacoes corretamente para consignar" : "Consignar produto"}}
                                                    </button>
                                                    <br>
                                                    <strong style="color:#FF0000;font-size:13px">Ao clicar no botao acima, você esta aceitando os termos do contrato.</strong>
                                                    
                                                </div>
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

                <!-- /.modal-content -->

                <!-- /.modal-content EDIT --> 

                <!-- /.modal-content --> 				



                <!-- /.modal-content DELETE --> 
                <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-t-10" id="exampleModalLongTitle"><i class="fas fa-trash-alt fa-3x"></i>&nbsp;&nbsp;&nbsp;Delete os dados de seu Fornecedor</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center"> Tem certeza de que deseja excluir este Fornecedor?</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" ng-click="deleteFornecedor(fornecedor)">Sim</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Não</button>
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
                                                $('.btninfo').tooltip({title: "Mais informação", placement: "top"});
                                                $('.btnedit').tooltip({title: "Editar", placement: "top"});
                                                $('.btndel').tooltip({title: "Deletar", placement: "top"});
                                            });


                </script>

                </body>

                </html>