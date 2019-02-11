<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of testeConnectionFactory
 *
 * @author Renan
 */
include('includes.php');

class testeEmail extends PHPUnit_Framework_TestCase {

    public function testSimple() {

         /*
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = "mail.agrofauna.com.br";
        $mail->Port = 587;
        $mail->SMTPSecure = "tls";
        $mail->IsHTML(true);
        $mail->Username = "renan.miranda@agrofauna.com.br"; // your gmail address
        $mail->Password = "a1g2r304"; // password
        $mail->SetFrom("agro.49.comunicado@gmail.com");
        $mail->Subject = "Using PHPMailer without composer"; // Mail subject
        $mail->Body = "teste";
        $mail->AddAddress("renan_goncalves@outlook.com.br");
        try{
            $mail->Send();
        }catch(Exception $ex){
            echo $ex->getMessage();
        }
       
          $email = new Email("1234");
          $email->senha = "teste";

          $this->assertEquals($email->endereco,"emailinvalido@invalido.com.br");

          $email = new Email("renan.miranda@agrofauna.com.br");
          $email->senha = "teste";

          $this->assertEquals($email->endereco,"renan.miranda@agrofauna.com.br");
          $email->merge(new ConnectionFactory());


          $email->merge(new ConnectionFactory());

          $email->delete(new ConnectionFactory());
         */
        
        $email = new Email("renan_goncalves@outlook.com.br;matheus@agrofauna.com.br;MANUTENCAO:matheus@dedede.com.br,matheus@aaa.com.br;VENDAS:renan.miranda@agrofauna.com.br");
        
        echo print_r($email->filtro("VENDAS")->getEnderecos());
        
    }

}
