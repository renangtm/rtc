<?php
session_start();

foreach(glob("php/herancas/*.php") as $filename){
    
    include $filename;
    
}

foreach(glob("php/entidades/*.php") as $filename){
    
    include $filename;
    
}

foreach(glob("PHPMailer/src") as $filename){
    
    require $filename;
    
}

?>
