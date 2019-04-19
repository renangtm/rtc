<?php

include("includes.php");

function n($str) {
    $escapers = array("\\", "\n", "\r", "\t", "\x08", "\x0c", "\f", "\x1d", "\x1c", "\x13");
    $replacements = array("/", "", "", "", "", "", "", "", "", "");
    $result = str_replace($escapers, $replacements, $str);
    return $result;
}

$ses = new SessionManager();

$c = new ConnectionFactory();

$usuario = $ses->get("usuario");
$empresa = $ses->get("empresa");

$o = null;

if (isset($_POST['o'])) {


    $o = Utilidades::fromJson(n(Utilidades::base64decodeSPEC($_POST['o'])));
} else if (isset($_GET['o'])) {

    $o = Utilidades::fromJson(n(Utilidades::base64decodeSPEC($_GET['o'])));
}



$codigo = "";

if (isset($_POST['c'])) {

    $codigo = Utilidades::base64decodeSPEC($_POST['c']);
} else if (isset($_GET['c'])) {

    $codigo = Utilidades::base64decodeSPEC($_GET['c']);
} else {

    exit;
}


if ($o != null) {

    $r->o = $o;
}

$r->sucesso = true;

eval('try{ ' . $codigo . '; }catch(Exception $ex){$r->sucesso = false;$r->mensagem=$ex->getMessage();}');

echo Utilidades::base64encodeSPEC(n(Utilidades::toJson($r)));
