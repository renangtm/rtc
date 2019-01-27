<?php

include("includes.php");

$ses = new SessionManager();

$c = new ConnectionFactory();

$usuario = $ses->get("usuario");
$empresa = $ses->get("empresa");

$objeto = null;

if(isset($_POST['o'])){
    
    $objeto = Utilidades::fromJson($_POST['o']);
    
}else if(isset($_GET['o'])){
    
    $objeto = Utilidades::fromJson($_GET['o']);
    
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

if($objeto!= null){
    
    $r->objeto = $objeto;
    
}

$codigo = str_replace(".", "->", $codigo);

eval('try{ '.$codigo.'; }catch(Exception $ex){$r->sucesso = false;$r->mensagem=$ex->getMessage();}');

echo Utilidades::toJson($r);