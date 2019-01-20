<?php 

class SessionManager{


	public function get($nome){

		if(isset($_SESSION[$nome])){

			return unserialize($_SESSION[$nome]);

		}

		return null;

	}

	public function set($nome,$dado){
           
		$_SESSION[$nome] = serialize($dado);

	}


}


 ?>