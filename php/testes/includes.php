<?php

session_start();

$it = new RecursiveDirectoryIterator("/Program Files (x86)/EasyPHP-Webserver-14.1b2/www/novo_rtc_web/php/herancas/");
$it = new RecursiveIteratorIterator($it,RecursiveIteratorIterator::SELF_FIRST);

foreach($it as $file){
    if($file->isFile()){
        include $file;
    }
}

//C:\Program Files (x86)\EasyPHP-Webserver-14.1b2\www\novo_rtc_web\php\herancas\FuncaoNumerica.php

$it = new RecursiveDirectoryIterator("/Program Files (x86)/EasyPHP-Webserver-14.1b2/www/novo_rtc_web/php/entidades/");
$it = new RecursiveIteratorIterator($it,RecursiveIteratorIterator::SELF_FIRST);

foreach($it as $file){
    if($file->isFile()){
        include $file;
    }
}


                                    
$it = new RecursiveDirectoryIterator("/Program Files (x86)/EasyPHP-Webserver-14.1b2/www/novo_rtc_web/PHPMailer/src/");
$it = new RecursiveIteratorIterator($it,RecursiveIteratorIterator::SELF_FIRST);

foreach($it as $file){
    if($file->isFile()){
        require $file;
    }
}


?>
