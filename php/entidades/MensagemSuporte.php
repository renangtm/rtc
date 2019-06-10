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
class MensagemSuporte{

	public $id;
	public $usuario;
	public $momento;
	public $texto;

	function __construct()
	{
		$this->id = 0;
		$this->usuario = null;
		$this->momento = round(microtime(true)*1000);
		$this->texto = "";
	}

	public function merge($con){

		if($this->id === 0){

			$ps = $con->getConexao()->prepare("INSERT INTO mensagem_suporte(id_usuario,momento,texto) VALUES(".$this->usuario->id.",FROM_UNIXTIME($this->momento/1000),'".addslashes($this->texto)."')");
			$ps->execute();
			$this->id = $ps->insert_id;
			$ps->close();

		}else{

			$ps = $con->getConexao()->prepare("UPDATE mensagem_suporte SET id_usuario=".$this->usuario->id.",momento=FROM_UNIXTIME($this->momento/1000),texto='".addslashes($this->texto)."' WHERE id=$this->id");
			$ps->execute();
			$ps->close();

		}


	}


}
