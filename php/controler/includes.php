<?php
session_start();

foreach(glob("../herancas/*.php") as $filename){
    
    include $filename;
    
}

foreach(glob("../entidadestestecommit/*.php") as $filename){
    
    include $filename;
    
}

?>
