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

class ClienteRelatorio {
    
    public $id;
    public $id_real;
    public $razao_social;
    public $inscricao;
    public $telefones;
    public $email;
    public $cidade;
    public $estado;
    public $classe;
    public $id_empresa;

    public static function getClasses(){
        
        return array(
          array(0,"Sem nenhuma acao sobre","Black"),
          array(1,"Cliente Utiliza o RTC","Green"),
          array(2,"Cliente nao quer trabalhar momentaneamente com a Agrofauna","Orange"),
          array(3,"Cliente nao quer trabalhar com a Agro Fauna","Red"),
          array(4,"Faleceu, fechou, nao trabalha mais etc...","Purple"),
          array(5,"Nao se encontra","DarkGray"),
          array(6,"Nao Atende","Brown"),
          array(7,"Cooperativa","LightGray"),
          array(8,"Pos venda","SteelBlue"),
          array(9,"Usina","Red"),
          array(10,"Contatos invalidos","DarkOrange"),
          array(11,"Consumidor","Orange"),
          array(12,"Aprovado para a recepcao","Blue"),
          array(13,"Aprovado manualmente para recepcao","Pink"),
          array(14,"Aprovado manualmente para recepcao mas recusado pelo robo","DarkRed")
        );
        
    }
    
    function __construct($cliente) {

        $this->id = $cliente->codigo;
        $this->id_real = $cliente->id;
        $this->razao_social = $cliente->razao_social;
        if($cliente->pessoa_fisica){
            $this->inscricao = $cliente->cpf->valor;
        }else{
            $this->inscricao = $cliente->cnpj->valor;
        }
        $this->id_empresa = $cliente->empresa->id;
        $this->cidade = $cliente->endereco->cidade->nome;
        $this->estado = $cliente->endereco->cidade->estado->sigla;
        $this->email = $cliente->email;
        $this->classe = $cliente->classe_virtual;
        $this->telefones = $cliente->telefones;
        
    }
    
    public function getCliente($con){
        
        $empresa = new Empresa($this->id_empresa,$con);
        
        $cliente = $empresa->getClientes($con, 0, 1,"cliente.id=$this->id_real");
        
        return $cliente[0];
        
    }

    public function merge($con,$usuario) {
        
        $ps = $con->getConexao()->prepare("UPDATE cliente SET classe_virtual = $this->classe WHERE id=$this->id_real");
        $ps->execute();
        $ps->close();
        
        if($this->classe===13){
            
            $recepcao = Sistema::TT_RECEPCAO_CLIENTE($usuario->empresa->id);
            
            $ps = $con->getConexao()->prepare("SELECT id FROM tarefa WHERE tipo_entidade_relacionada='CLI' AND id_entidade_relacionada=$this->id_real AND id_tipo_tarefa=$recepcao->id");
            $ps->execute();
            $ps->bind_result($id);
            $existe = $ps->fetch();
            $ps->close();
            
            if(!$existe){
               
                $prosp = new Tarefa();
                $prosp->titulo = "Prospeccao do cliente $this->id - $this->razao_social";
                $prosp->descricao = "Prospeccao do cliente $this->id - $this->razao_social confirmada do relatorio ##@@";
                $prosp->id_entidade_relacionada = $this->id_real;
                $prosp->tipo_entidade_relacionada = 'CLI';
                $prosp->tipo_tarefa = Sistema::TT_PROSPECCAO_CLIENTE($usuario->empresa->id);

                $usuario->addTarefa($con,$prosp);

                $obs = new ObservacaoTarefa();
                $obs->observacao = "Realizada";
                $obs->porcentagem = 100;

                $prosp->addObservacao($con, $usuario, $obs);
                
            }else{

            	$ps = $con->getConexao()->prepare("UPDATE cliente SET classe_virtual=14 WHERE id=$this->id_real");
            	$ps->execute();
            	$ps->close();

            }
            
            //----------------------
            
        }
        
    }
    

}
