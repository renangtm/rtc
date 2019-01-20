<?php
session_start();

foreach(glob("../herancas/*.php") as $filename){
    
    include $filename;
    
}

foreach(glob("../entidades/*.php") as $filename){
    
    include $filename;
    
}

?>
