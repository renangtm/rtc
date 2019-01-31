<?php

include("includes.php");

$ses = new SessionManager();

$c = new ConnectionFactory();

$usuario = $ses->get("usuario");
$empresa = $ses->get("empresa");

$o = null;

if(isset($_POST['o'])){
    
    $o = Utilidades::fromJson($_POST['o']);
    
}else if(isset($_GET['o'])){
    
    $o = Utilidades::fromJson($_GET['o']);
    
}

$codigo = "";

if(isset($_POST['c'])){
    
    $codigo = $_POST['c'];
    
}else if(isset($_GET['c'])){
    
    $codigo = $_GET['c'];
    
}else{
    
    exit;
    
}

$r = new stdClass();
$r->sucesso = true;

if($o!= null){
    
    $r->o = $objeto;
    
}

eval('try{ '.$codigo.'; }catch(Exception $ex){$r->sucesso = false;$r->mensagem=$ex->getMessage();}');

echo Utilidades::toJson($r);