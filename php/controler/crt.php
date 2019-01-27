<?php

include("includes.php");

$ses = new SessionManager();

$usuario = $ses->get("usuario");
$empresa = $usuario->empresa;

$objeto = null;

if(isset($_POST['o'])){
    
    $objeto = Utilidades::fromJson($_POST['o']);
    
}else if(isset($_GET['o'])){
    
    $objeto = Utilidades::fromJson($_GET['o']);
    
}

$codigo = "";

if(isset($_POST['c'])){
    
    $codigo = $_POST['codigo'];
    
}else if(isset($_GET['c'])){
    
    $codigo = $_GET['codigo'];
    
}else{
    
    exit;
    
}

$retorno = new stdClass();
$retorno->erro = "";
$retorno->objeto = $objeto;

$codigo = str_replace(".", "->", $codigo);

eval('try{ '.$codigo.'; }catch(Exception $ex){$retorno->erro = $ex->getMessage();}');

echo Utilidades::toJson($retorno);