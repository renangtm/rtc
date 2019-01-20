<?php 

class ConnectionFactory{

		private static $conexao;
		
		 public function getConexao() {

		 	if(self::$conexao==null){
		 		self::$conexao = new mysqli("rtcd.rtcagro.com.br","root","m4st3rk3y1","novo_rtc",45852);
		 	}
                        
                        
		 	return self::$conexao;

		 }

}


 ?>