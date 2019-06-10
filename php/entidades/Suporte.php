<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Logistica
 *
 * @author Renan
 */
class Suporte{

	public $id;
	public $usuario;
	public $atendente;
	public $inicio;
	public $fim;
        public $ultima_mensagem;
        public $mensagens_retorno;
        public $mensagens;
        
	function __construct()
	{
		
		$this->id = 0;
		$this->usuario = null;
		$this->atendente = null;
		$this->inicio = round(microtime(true)*1000);
		$this->fim = null;
                $this->ultima_mensagem = 0;
                $this->mensagens_retorno = array();
                $this->mensagens = array();
	}
        
        public function atribuir($con){
            
            $empresa_atual = 0;
            $usuario_atual = 0;
            
            $ps = $con->getConexao()->prepare("SELECT id_empresa,id_usuario FROM counter_suporte");
            $ps->execute();
            $ps->bind_result($id_empresa,$id_usuario);
            while($ps->fetch()){
                
                $empresa_atual = $id_empresa;
                $usuario_atual = $id_usuario;
                
            }
            $ps->close();
            
            
            $empresas = array();
            
            $ps = $con->getConexao()->prepare("SELECT id FROM empresa WHERE tipo_empresa=3");
            $ps->execute();
            $ps->bind_result($id);
            while($ps->fetch()){
                
                $empresas[] = $id;
                
            }
            $ps->close();

            if(count($empresas) === 0){
                
                return;
                
            }
            
            if($empresa_atual === 0){
               
               $empresa_atual = $empresas[0];
                
            }
            
            $index = 0;
            
            foreach($empresas as $key=>$value){
                if($value===$empresa_atual){
                    $index = $key;
                    break;
                }
            }
            
            $cargos = array(
               Virtual::CF_ASSISTENTE_VIRTUAL_SUPORTE(null)
            );
            
            $ids_cargos = "(-1";
            
            foreach($cargos as $key=>$value){
                $ids_cargos .= ",$value->id";
            }
            
            $ids_cargos .= ")";
            
            $encontrou = false;
            
            $t = 0;
            while($t<=count($empresas)){
             
                $ps = $con->getConexao()->prepare("SELECT id FROM usuario WHERE id_cargo IN $ids_cargos AND id_empresa=$empresa_atual AND id>$usuario_atual ORDER BY id ASC");
                $ps->execute();
                $ps->bind_result($id);
                $ok = $ps->fetch();
                $ps->close();
                
                if($ok){
                    
                    $usuario_atual = $id;
                    $encontrou = true;
                    break;
                    
                }else{
                    
                    $usuario_atual = 0;
                    $empresa_atual = $empresas[($index+1)%(count($empresas))];  
                    
                }
                
                $t++;
                
            }
            
            if($encontrou){
                
                $this->atendente = new Usuario();
                $this->atendente->id = $usuario_atual;
                $this->merge($con);
                
                $ps = $con->getConexao()->prepare("UPDATE counter_suporte SET id_empresa=$empresa_atual,id_usuario=$usuario_atual");
                $ps->execute();
                $ps->close();
                
            }
            
        }


	public function getMensagens($con,$last_id=0){

		$ret = array();

		$ps = $con->getConexao()->prepare("SELECT m.id,u.id,u.nome,UNIX_TIMESTAMP(m.momento)*1000,m.texto FROM mensagem_suporte m INNER JOIN usuario u ON m.id_usuario=u.id WHERE m.id_suporte=$this->id  AND m.id>$last_id");
		$ps->execute();
		$ps->bind_result($id,$id_usuario,$nome_usuario,$momento,$texto);
		
		while($ps->fetch()){

			$m = new MensagemSuporte();
			$m->id = $id;

			$u = new Usuario();
			$u->id = $id_usuario;
			$u->nome = $nome_usuario;

			$m->usuario = $u;

			$m->momento = $momento;
			$m->texto = $texto;

			$ret[] = $m;

		}

		$ps->close();

		return $ret;


	}

	public function addMensagem($con,$msg){

		$msg->merge($con);

		$ps = $con->getConexao()->prepare("UPDATE mensagem_suporte SET id_suporte=$this->id WHERE id=$msg->id");
		$ps->execute();
		$ps->close();

	}


	public function merge($con){

		if($this->id === 0){

			$ps = $con->getConexao()->prepare("INSERT INTO suporte(id_usuario,id_atendente,inicio,fim) VALUES(".$this->usuario->id.",".$this->atendente->id.",FROM_UNIXTIME($this->inicio/1000),".($this->fim!==null?"FROM_UNIXTIME($this->fim/1000)":"null").")");
			$ps->execute();
			$this->id = $ps->insert_id;
			$ps->close();

		}else{

			$ps = $con->getConexao()->prepare("UPDATE suporte SET id_usuario=".$this->usuario->id.", id_atendente=".$this->atendente->id.", inicio=FROM_UNIXTIME($this->inicio/1000),fim=".($this->fim!==null?"FROM_UNIXTIME($this->fim/1000)":"null")." WHERE id=$this->id");
			$ps->execute();
			$ps->close();

		}


	}


}
