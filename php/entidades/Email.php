<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Email
 *
 * @author Renan
 */
class Email {
    
    public $id;
    public $endereco;
    public $excluido;
    public $senha;
    
    private static $SERVIDORES = array(
        "gmail.com" => array("smtp.gmail.com",587,true),
    );
    
    function __construct($str="") {
        
        $this->id = 0;
        $this->endereco = $str;
        $this->excluido = false;
        $this->senha = "";
        
        if(!filter_var($str, FILTER_VALIDATE_EMAIL)){
            
            $this->endereco = "emailinvalido@invalido.com.br";
            
        }
        
    }
    
    public function enviarEmail($destino, $titulo, $conteudo){
        
        if($this->endereco == "emailinvalido@invalido.com.br")
            return;
        
        $servidor = explode('@', $this->endereco);
        $servidor = $servidor[1];
        
        if(isset(self::$SERVIDORES[$servidor])){
            $servidor = self::$SERVIDORES[$servidor];
        }else{
            $servidor = array("mail.".$servidor,587,true);
        }
        
        
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = $servidor[0];
        $mail->Port = $servidor[1];
        
        if($servidor[2]){
            $mail->SMTPSecure = "tls";
        }
        
        $mail->IsHTML(true);
        $mail->Username = $this->endereco; // your gmail address
        $mail->Password = $this->senha; // password
        $mail->SetFrom($this->endereco);
        $mail->Subject = $titulo; // Mail subject
        $mail->Body = $conteudo;
        $mail->AddAddress($destino->endereco);
        $mail->Send();
        
    }
    
    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO email(endereco,excluido,senha) VALUES('" . addslashes($this->endereco) . "',false,'".addslashes($this->senha)."')");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
            
        }else{
            
            $ps = $con->getConexao()->prepare("UPDATE email SET endereco = '" . addslashes($this->endereco) . "', excluido = false, senha = '".addslashes($this->senha)."' WHERE id = ".$this->id);
            $ps->execute();
            $ps->close();
            
        }
        
        
    }
    
    public function delete($con){
        
        $ps = $con->getConexao()->prepare("UPDATE email SET excluido = true WHERE id = ".$this->id);
        $ps->execute();
        $ps->close();
        
    }
    
}
