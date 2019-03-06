<?php

include("includes.php");

$ses = new SessionManager();

$c = new ConnectionFactory();

$usuario = $ses->get("usuario");
$empresa = $ses->get("empresa");

$o = null;

if (isset($_POST['o'])) {


    $o = Utilidades::fromJson(str_replace(array("<m>", "<e>", "<p>","Infinity","NaN","<lp>","<rp>","<mi>"), array("+", "&", "%","0","0","(",")","-"), $_POST['o']));
} else if (isset($_GET['o'])) {

    $o = Utilidades::fromJson(str_replace(array("<m>", "<e>", "<p>","Infinity","NaN","<lp>","<rp>","<mi>"), array("+", "&", "%","0","0","(",")","-"), $_GET['o']));
}



$codigo = "";

if (isset($_POST['c'])) {

    $codigo = str_replace(array("<m>", "<e>", "<p>","Infinity","NaN","<lp>","<rp>","<mi>"), array("+", "&", "%","0","0","(",")","-"), $_POST['c']);
} else if (isset($_GET['c'])) {

    $codigo = str_replace(array("<m>", "<e>", "<p>","Infinity","NaN","<lp>","<rp>","<mi>"), array("+", "&", "%","0","0","(",")","-"), $_GET['c']);
} else {

    exit;
}


if ($o != null) {

    $r->o = $o;
}

$r->sucesso = true;

eval('try{ ' . $codigo . '; }catch(Exception $ex){$r->sucesso = false;$r->mensagem=$ex->getMessage();}');

echo str_replace(array("<m>", "<e>", "<p>","Infinity","NaN"), array("+", "&", "%","0","0"), Utilidades::toJson($r));
