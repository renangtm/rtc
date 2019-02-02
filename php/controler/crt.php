<?php

include("includes.php");

$ses = new SessionManager();

$c = new ConnectionFactory();

$usuario = $ses->get("usuario");
$empresa = $ses->get("empresa");

$o = null;

if(isset($_POST['o'])){
    
    $o = Utilidades::fromJson(str_replace(array("<m>","<e>"), array("+","&"),$_POST['o']));
    
}else if(isset($_GET['o'])){
    
    $o = Utilidades::fromJson(str_replace(array("<m>","<e>"), array("+","&"),$_GET['o']));
    
}

$codigo = "";

if(isset($_POST['c'])){
    
    $codigo = str_replace(array("<m>","<e>"), array("+","&"),$_POST['c']);
    
}else if(isset($_GET['c'])){
    
    $codigo = str_replace(array("<m>","<e>"), array("+","&"),$_GET['o']);
    
}else{
    
    exit;
    
}

$r = new stdClass();
$r->sucesso = true;

if($o!= null){
    
    $r->o = $o;
    
}

eval('try{ '.$codigo.'; }catch(Exception $ex){$r->sucesso = false;$r->mensagem=$ex->getMessage();}');

echo str_replace("&","<e>",Utilidades::toJson($r));