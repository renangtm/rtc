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
class TTProspeccaoDeCliente extends TipoTarefa {

    public $id_empresa;
    
    function __construct($id_empresa) {

        parent::__construct(9, $id_empresa);

        $this->id_empresa = $id_empresa;
        
        $this->classes = array(
            array(
                "<strong style='color:Black'>Aprovar para recepcao</strong>"
                ,"<strong style='color:Orange'>Cliente nao quer trabalhar momentaneamente com a Agro Fauna</strong>"
                ,"<strong style='color:Red'>Cliente nao quer trabalhar com a Agro Fauna</strong>"
                ,"<strong style='color:Purple'>Faleceu, fechou, nao trabalha mais, etc..</strong>"
                ,"<strong style='color:Gray'>Cooperativa</strong>"
                ,"<strong style='color:Blue'>Jogar para o pos-venda</strong>"
                ,"<strong style='color:Red'>Usina</strong>"
                ,"<strong style='color:LightGreen'>Consumidor</strong>"
                ,"<strong style='color:DarkOrange'>Contatos invalidos</strong>"));
        
        $this->nome = "Prospeccao de Cliente";
        $this->tempo_medio = 0.3;
        $this->prioridade = 100;
        $this->cargos = array(
            Virtual::CF_ASSISTENTE_VIRTUAL_PROSPECCAO(new Empresa($id_empresa)),
            Virtual::CF_ASSISTENTE_VIRTUAL_RECEPCAO(new Empresa($id_empresa))
        );
        $this->carregarDados();
    }
    
    public function getOpcoes($con,$tarefa){
        
        $ps = $con->getConexao()->prepare("SELECT classe_virtual FROM cliente WHERE id=$tarefa->id_entidade_relacionada");
        $ps->execute();
        $ps->bind_result($classe_virtual);
        if($ps->fetch()){
            return array($classe_virtual);
        }
        $ps->close();
        return array(0);
        
    }
    
    public function getObservacaoPadrao($tarefa){
        
        
        $con = new ConnectionFactory();
        
        $ps = $con->getConexao()->prepare("SELECT "
                . "cliente.codigo,"
                . "cliente.razao_social,"
                . "cliente.pessoa_fisica,"
                . "cliente.cnpj,"
                . "cliente.cpf,"
                . "estado.sigla,"
                . "cidade.nome,"
                . "endereco.rua,"
                . "endereco.bairro,"
                . "endereco.cep,"
                . "endereco.numero,"
                . "telefone.numero,"
                . "email.endereco "
                . " FROM cliente "
                . "INNER JOIN endereco ON endereco.id_entidade=cliente.id "
                . "AND endereco.tipo_entidade='CLI' "
                . "INNER JOIN cidade ON cidade.id=endereco.id_cidade "
                . "INNER JOIN estado ON estado.id=cidade.id_estado "
                . "INNER JOIN email ON email.id_entidade=cliente.id "
                . "AND email.tipo_entidade='CLI' "
                . "LEFT JOIN telefone ON telefone.id_entidade = cliente.id "
                . "AND telefone.tipo_entidade='CLI' "
                . "WHERE cliente.id=$tarefa->id_entidade_relacionada");
        $ps->execute();
        $telefones = "";
        $ps->bind_result($codigo,$nome,$pessoa_fisica,$cnpj,$cpf,$sigla_estado,$nome_cidade,$rua,$bairro,$cep,$numero,$numtel,$endem);
        while($ps->fetch()){
            
            $this->observacao_padrao = "#CONFERENCIA_CADASTRO_CLIENTE<br>";
            $this->observacao_padrao .= "#Codigo: $codigo<br>";
            $this->observacao_padrao .= "#Nome: $nome<br>";
            if($pessoa_fisica){
                $cpf = new CPF($cpf);
                $this->observacao_padrao .= "#CPF: ".$cpf->valor."<br>";
            }else{
                $cnpj = new CNPJ($cnpj);
                $this->observacao_padrao .= "#CNPJ: ".$cnpj->valor."<br>";
            }
            $this->observacao_padrao .= "#Estado: ".$sigla_estado."<br>";
            $this->observacao_padrao .= "#Cidade: ".$nome_cidade."<br>";
            $this->observacao_padrao .= "#Rua: ".$rua."<br>";
            $this->observacao_padrao .= "#Bairro: ".$bairro."<br>";
            $cep = new CEP($cep);
            $this->observacao_padrao .= "#Cep: ".$cep->valor."<br>";
            $this->observacao_padrao .= "#Numero: ".$numero."<br>";
            $this->observacao_padrao .= "#Email: ".$endem."<br>";
            
            $telefones .= "$numtel;";
        }
        $this->observacao_padrao .= "#Telefones: $telefones <br>";
        $this->observacao_padrao .= "#Codigo: 4000 <br>";
        $this->observacao_padrao .= "#Observacao: --------";
        
        return $this->observacao_padrao;
        
    }

    public function aoAtribuir($id_usuario, $tarefa) {

        $con = new ConnectionFactory();
        $relacionamento = new RelacaoUsuarioCliente();
        $relacionamento->situacao = RelacaoUsuarioCliente::$PROSPECCAO;
        $relacionamento->cliente = new stdClass();
        $relacionamento->cliente->id = $tarefa->id_entidade_relacionada;
        $relacionamento->merge($con);
        
        $ps = $con->getConexao()->prepare("UPDATE usuario_cliente SET id_usuario=$id_usuario,data_inicio=data_inicio,data_fim=data_fim WHERE id=$relacionamento->id");
        $ps->execute();
        $ps->close();
        
       
        
    }
    
    public function init($tarefa){
        
         $con = new ConnectionFactory();
        
         if($tarefa->opcoes[0] > 0){
            
            $ps = $con->getConexao()->prepare("UPDATE cliente SET classe_virtual=".$tarefa->opcoes[0]." WHERE id=$tarefa->id_entidade_relacionada");
            $ps->execute();
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE cliente SET classe_virtual=".($tarefa->opcoes[0]+1)." WHERE id=$tarefa->id_entidade_relacionada");
            $ps->execute();
            $ps->close();
            
            
        }
        
    }
    
    public function aoFinalizar($tarefa,$usuario) {
        
        $con = new ConnectionFactory();
        
        
        
        $dados = array();
        
        foreach($tarefa->observacoes as $key=>$value){
            $o = str_replace(array("<br>"), array(""), $value->observacao);
            $o = explode("#", $o);
            foreach($o as $k=>$d){
                $val = explode(":", $d,2);
                if(count($val)<2){
                    continue;
                }
                $val2 = $val[1];
                $val = $val[0];
                if(strlen($val)===0 || strlen($val2)===0){
                    continue;
                }
                while($val2{0} === " "){
                    $val2 = substr($val2, 1);
                }
                $dados[strtolower($val)] = $val2;
            }
        }
        
        
        
        if(isset($dados['nome'])){
            $ps = $con->getConexao()->prepare("UPDATE cliente SET razao_social='".$dados['nome']."' WHERE id=$tarefa->id_entidade_relacionada");
            $ps->execute();
            $ps->close();
        }
        
        if(isset($dados['cnpj'])){
            $ps = $con->getConexao()->prepare("UPDATE cliente SET cnpj='".$dados['cnpj']."' WHERE id=$tarefa->id_entidade_relacionada");
            $ps->execute();
            $ps->close();
        }
        
        if(isset($dados['cpf'])){
            $ps = $con->getConexao()->prepare("UPDATE cliente SET razao_social='".$dados['cpf']."' WHERE id=$tarefa->id_entidade_relacionada");
            $ps->execute();
            $ps->close();
        }
        
        if(isset($dados['email'])){
            $ps = $con->getConexao()->prepare("UPDATE email SET endereco='".$dados['email']."' WHERE tipo_entidade='CLI' AND id_entidade=$tarefa->id_entidade_relacionada");
            $ps->execute();
            $ps->close();
        }
        
        $telefones = array();
        $emails = array();
        $nome = "";
        $cnpj = "";
        $codigo = "";
        
        $ps = $con->getConexao()->prepare("SELECT c.codigo,c.razao_social, c.cnpj, t.numero, e.endereco FROM cliente c LEFT JOIN email e ON e.id_entidade=c.id AND e.tipo_entidade='CLI' LEFT JOIN telefone t ON t.id_entidade=c.id AND t.tipo_entidade='CLI' WHERE c.id=$tarefa->id_entidade_relacionada");
        $ps->execute();
        $ps->bind_result($codigo,$nome_cliente,$cnpj_cliente,$telefone_cliente,$email_cliente);
        while($ps->fetch()){
            $nome = $nome_cliente;
            $cnpj = $cnpj_cliente;
            $codigo = $codigo;
            $telefones[$telefone_cliente] = "";
            $emails[$email_cliente] = "";
        }
        $ps->close();
        
        
        if($tarefa->opcoes[0] > 0){
            
            $ps = $con->getConexao()->prepare("UPDATE cliente SET classe_virtual=".($tarefa->opcoes[0]+1)." WHERE id=$tarefa->id_entidade_relacionada");
            $ps->execute();
            $ps->close();
            
            return;
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE cliente SET classe_virtual=".$tarefa->opcoes[0]." WHERE id=$tarefa->id_entidade_relacionada");
            $ps->execute();
            $ps->close();
            
            
            
        }
        
        $str_telefones = "";
        foreach($telefones as $key=>$value){
            $str_telefones .= "$key<br>";
        }
        
        $str_emails = "";
        foreach($emails as $key=>$value){
            $str_emails .= "$key<br>";
        }
        
        $tarefa_ = new Tarefa();
        $tarefa_->tipo_tarefa = Sistema::TT_RECEPCAO_CLIENTE($this->id_empresa);
        $tarefa_->titulo = "Recepcao de Cliente $nome";
        $tarefa_->descricao = "Recepcione o cliente $codigo -$nome para o RTC CNPJ: $cnpj<hr>Telefones:<br>$str_telefones<hr>Emails:<br>$str_emails<hr>";
        $tarefa_->id_entidade_relacionada = $tarefa->id_entidade_relacionada;
        $tarefa_->tipo_entidade_relacionada = $tarefa->tipo_entidade_relacionada;
        
        Sistema::novaTarefaEmpresa(new ConnectionFactory(), $tarefa_, new Virtual($this->id_empresa,$con));
        
        $ps = $con->getConexao()->prepare("UPDATE usuario_cliente SET data_inicio=data_inicio, data_fim=CURRENT_TIMESTAMP WHERE id_usuario=$usuario->id AND id_cliente=$tarefa->id_entidade_relacionada");
        $ps->execute();
        $ps->close();
        
        
        
        
    }

}
