<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegraTabela
 *
 * @author Renan
 */
class TTRecepcaoCliente extends TipoTarefa {

    public $id_empresa;

    function __construct($id_empresa) {

        parent::__construct(12, $id_empresa);

        $this->id_empresa = $id_empresa;

        $this->nome = "Recepcao de Cliente";
        $this->tempo_medio = 0.2;
        $this->prioridade = 10;
        $this->cargos = array(
            Virtual::CF_ASSISTENTE_VIRTUAL_RECEPCAO(new Empresa($id_empresa))
        );
        $this->carregarDados();
        $this->porcentagem_fixa = 25;
    }

    public function aoAtribuir($id_usuario, $tarefa) {

        $con = new ConnectionFactory();
        $relacionamento = new RelacaoUsuarioCliente();
        $relacionamento->situacao = RelacaoUsuarioCliente::$RECEPCAO;
        $relacionamento->cliente = new stdClass();
        $relacionamento->cliente->id = $tarefa->id_entidade_relacionada;
        $relacionamento->merge($con);

        $ps = $con->getConexao()->prepare("UPDATE usuario_cliente SET id_usuario=$id_usuario,data_inicio=data_inicio,data_fim=data_fim WHERE id=$relacionamento->id");
        $ps->execute();
        $ps->close();
    }

    public function init($tarefa) {

        $antigo = false;

        $con = new ConnectionFactory();
        $ps = $con->getConexao()->prepare("SELECT pedido.id FROM pedido "
                . "INNER JOIN cliente ON pedido.id_cliente=cliente.id "
                . "WHERE pedido.data<=DATE_SUB(CURRENT_DATE,INTERVAL 60 DAY) "
                . "AND cliente.id=" . $tarefa->id_entidade_relacionada);
        $ps->execute();
        $ps->bind_result($id);
        if ($ps->fetch()) {
            $antigo = true;
        }
        $ps->close();

        $e = count($tarefa->observacoes);

        if (!$antigo) {
            if ($e === 0) {

                $tarefa->descricao .= " Dirija-se ao cliente da seguinte forma <hr> ";
                $tarefa->descricao .= "<p><strong>Bom dia
                                Sou Assistente aos clientes da Agro Fauna para apresentar a nossa nova plataforma de trabalho onde sua empresa podera obter vantagens de precos muitas vezes abaixo do preco de fabrica!
                                Meu nome e..........,estarei a sua disposicao para auxilia-lo a entrar em nosso aplicativo chamado RTC.
                                Nele alem de comprar barato em nossas promocoes diarias o Sr.a,podera tambem usar para outros servicos.
                                Como sua empresa ja foi cadastrada recentemente podemos oferecer nossos servicos GRATUITAMENTE por 90 dias. 
                                Ja foi enviado um e-mail explicativo de nosso servico de Informatica que mostra o passo a passo de tudo que eu estou falando.
                                </strong></p>";
            } else if ($e === 1) {

                $tarefa->descricao = " <strong>Continue Falando com ele assim: <hr> </strong>";

                $tarefa->descricao .= "<strong style='color:Red'><p>
                                Como eu disse antes o Sr.tem 90 dias para experimentar e ainda ganha uma promocao de boas vindas dos produtos que pode estar precisando com precos ainda mais baratos que todas as nossas promocoes. 
                                </p>
                                <p>
                                Nossas promocoes sao validas apenas para quem tem o Aplicativo Rtc. Pois nao  somos vendedores. Nos somos seu assistente para ajuda-lo a conhecer o Rtc.
                                </p></strong>";
            } else if ($e === 2) {


                $tarefa->descricao = " <strong>Continue Falando com ele assim: <hr> </strong>";
                $tarefa->descricao .= "<strong style='color:Blue'><p>
                                Gostaria que pudesse dar uma olhadinha no Rtc, o Sr vai perceber que e muito facil de comprar por la! 
                                E muito repido e o senhor podera ver o valor dos produtos com os precos discriminados automaticamente onde vai aparecer os valores de Icms,se tiver,frete automatico com varias opcoes, custo financeiro quando for a prazo.
                                Independente de qualquer coisa que queira perguntar sobre nosso Rtc gostaria que o Sr. pudesse acompanhar nossas promocoes diarias atraves de seu e-mail e ou pelo Whats App(Zap).
                                </p>
                                <p>
                                Por favor para qualquer duvida estamos passando novamente nosso passo a passo e o meu celular..
                                </p>
                                <p>
                                Tenha uma otima experiencia com nosso Rtc, e lembre-se que nosso objetivo e de criar uma rede de clientes muito bem informados de todas as nossas promocoes e servicos ...
                                </p>
                                <p>
                                Numa proxima ocasiao estaremos mostrando outras vantagens de usar o Rtc... Ate Breve</strong>";
            } else {
                $tarefa->descricao = "Digite alguma observacao adicional sobre a conclusao da tarefa";
            }
        } else {
            if ($e === 0) {

                $tarefa->descricao .= " Dirija-se ao cliente da seguinte forma <hr> ";
                $tarefa->descricao .= "<p> Bom Dia !!, 
                                Sou seu novo Assistente Virtual,minha funcao sera de apresentar as opcoes do modulo 1 do RTC,que e esse mesmo que o Sr. Ja usa a algum tempo
                                ja  de inicio quero adiantar que estaremos oferecendo gratuitamente todas as vantagens que o modulo 2 de nosso Rtc oferece. ..
                                </p>";
            } else if ($e === 1) {

                $tarefa->descricao = " <strong>Continue Falando com ele assim: <hr> </strong>";

                $tarefa->descricao .= "<strong style='color:Red'><p>
                                Desde o inicio neste modulo 1 o Sr ja poderia estar cadastrando seus 
                                produtos, seus clientes e fornecedores. Com isso o Sr. poderia usar o servico destes cadastramento no Rtc para sua organizacao.
                                </p></strong>";
            } else if ($e === 2) {

                $tarefa->descricao = " <strong>Continue Falando com ele assim: <hr> </strong>";

                $tarefa->descricao .= "<strong style='color:Blue'><p>
                                Agora no modulo 2 o Sr. podera ter para sua empresa a mesma facilidade em obter seus fretes partindo de Guarlhos pelo Logistic Center ou ate mesmo de sua cidade. Apenas que para isso sua transportadora devera nos fornecer sua tabela de precos para cadastramento.
                                </p>
                                <p>
                                Com isso sua empresa podera usar o mesmo processo para calculo de frete que usamos para venda na Agro Fauna
                                </p></strong>";
            } else {
                $tarefa->descricao = "Digite alguma observacao adicional sobre a conclusao da tarefa";
            }
        }
    }

    public function aoFinalizar($tarefa, $usuario) {

        $con = new ConnectionFactory();

        $tarefa_ = new Tarefa();
        $tarefa_->tipo_tarefa = Sistema::TT_SUPORTE_CLIENTE($this->id_empresa);
        $tarefa_->titulo = "Suporte ao Cliente";
        $tarefa_->descricao = "Preste suporte ao cliente " . $tarefa->id_entidade_relacionada . " para o RTC ";
        $tarefa_->id_entidade_relacionada = $tarefa->id_entidade_relacionada;
        $tarefa_->tipo_entidade_relacionada = $tarefa->tipo_entidade_relacionada;

        $tamanho = 0;

        foreach ($tarefa->observacoes as $key => $value) {
            $tamanho += strlen($value->observacao);
        }

        $pontos = ($tamanho > 500) ? 3 : ($tamanho > 200 ? 2 : 1);
        $atividade = $usuario->getAtividadeUsuarioClienteAtual($con);
        $atividade->pontos_atendimento += $pontos;
        $atividade->merge($con);

        Sistema::novaTarefaEmpresa($con, $tarefa_, new Virtual($this->id_empresa, $con));

        $ps = $con->getConexao()->prepare("UPDATE usuario_cliente SET data_inicio=data_inicio, data_fim=data_fim,situacao=" . RelacaoUsuarioCliente::$RECEPCAO_INATIVA . " WHERE id_usuario=$usuario->id AND id_cliente=$tarefa->id_entidade_relacionada");
        $ps->execute();
        $ps->close();
    }

}
