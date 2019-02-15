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

    public static $LOGISTICA = "Logistica";
    public static $COMPRAS = "Compras";
    public static $VENDAS = "Vendas";
    public static $MANUTENCAO = "Manutencao";
    public static $DIRETORIA = "Diretoria";
    public static $ADMINISTRATIVO = "Administrativo";
    public static $TIPOS_GRUPO = array("Logistica","Compras","Vendas","Manutencao","Diretoria","Administrativo");
    
    public $id;
    public $endereco;
    public $excluido;
    public $senha;
    public $filtro;
    
    
    private static $SERVIDORES = array(
        "gmail.com" => array("smtp.gmail.com", 587, true),
    );

    function __construct($str = "") {

        $this->id = 0;
        $this->endereco = $str;
        $this->excluido = false;
        $this->senha = "";
        $this->filtro = "";
        $this->getEnderecos();
    }

    public function filtro($f) {

        $clone = unserialize(serialize($this));
        $clone->filtro = $f;
        return $clone;
    }

    public function getEnderecos() {

        $fin = array();

        $grupos = explode(';', $this->endereco);

     
        
        foreach ($grupos as $key => $value) {

            if (count(explode(':', $value)) == 2) {

                $gp = explode(':', $value);

                $fin[$gp[0]] = array();

                $emails = explode(',', $gp[1]);

                foreach ($emails as $key2 => $value2) {
 
                    if (!filter_var($value2, FILTER_VALIDATE_EMAIL)) {

                        $fin[$gp[0]][] = "emailinvalido@invalido.com.br";
                    } else {

                        $fin[$gp[0]][] = $value2;
                    }
                }

            } else {
     
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {

                    $fin[] = "emailinvalido@invalido.com.br";
                } else {
               
                    $fin[] = $value;
                }
            }
        }

        $ne = "";
        foreach ($fin as $key => $value) {

            if (!is_array($value)) {

                if ($ne != "")
                    $ne .= ";";
                
                $ne .= $value;
            }else {

                if ($ne != "")
                    $ne .= ";";
                
                $ne .= $key . ":";

                $b = false;
                foreach ($value as $key2 => $value2) {
                    if ($b)
                        $ne .= ",";

                    $ne .= $value2;

                    $b = true;
                }
            }
        }

        $this->endereco = $ne;

        $enderecos = array();

        foreach ($fin as $key => $value) {

            if (!is_array($value)) {

                $enderecos[] = $value;
           
            } else{

                $k = $this->filtro=="";
                if (!$k){
                    if (strpos($key, $this->filtro) === false) {
                        continue;
                    }
                }
                
                foreach ($value as $key2 => $value2) {

                    $enderecos[] = $value2;
                }
            }
        }
        
        return $enderecos;
        
    }

    public function enviarEmail($destino, $titulo, $conteudo) {

        $enderecos = $destino->getEnderecos();

        $th = $this->getEnderecos();
        $th = $th[0];

        foreach ($enderecos as $key => $endereco) {

            if ($th == "emailinvalido@invalido.com.br")
                return;

            $servidor = explode('@', $th);
            $servidor = $servidor[1];

            if (isset(self::$SERVIDORES[$servidor])) {
                $servidor = self::$SERVIDORES[$servidor];
            } else {
                $servidor = array("mail." . $servidor, 587, true);
            }


            $mail = new PHPMailer\PHPMailer\PHPMailer();

            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = $servidor[0];
            $mail->Port = $servidor[1];

            if ($servidor[2]) {
                $mail->SMTPSecure = "tls";
            }

            $mail->IsHTML(true);
            $mail->Username = $this->endereco; // your gmail address
            $mail->Password = $this->senha; // password

            $mail->SetFrom($th);
            $mail->Subject = $titulo; // Mail subject
            $mail->Body = $conteudo;
            $mail->AddAddress($endereco);
            $mail->Send();
        }
    }

    public function merge($con) {

        if ($this->id == 0) {

            $ps = $con->getConexao()->prepare("INSERT INTO email(endereco,excluido,senha) VALUES('" . addslashes($this->endereco) . "',false,'" . addslashes($this->senha) . "')");
            $ps->execute();
            $this->id = $ps->insert_id;
            $ps->close();
        } else {

            $ps = $con->getConexao()->prepare("UPDATE email SET endereco = '" . addslashes($this->endereco) . "', excluido = false, senha = '" . addslashes($this->senha) . "' WHERE id = " . $this->id);
            $ps->execute();
            $ps->close();
        }
    }

    public function delete($con) {

        $ps = $con->getConexao()->prepare("UPDATE email SET excluido = true WHERE id = " . $this->id);
        $ps->execute();
        $ps->close();
    }

}
