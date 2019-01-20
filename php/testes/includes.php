<?php

session_start();
echo "testeteste";
$it = new RecursiveDirectoryIterator("/Program Files (x86)/EasyPHP-Webserver-14.1b2/www/rtc/php/herancas/");
$it = new RecursiveIteratorIterator($it,RecursiveIteratorIterator::SELF_FIRST);

foreach($it as $file){
    if($file->isFile()){
        include $file;
    }
}

//C:\Program Files (x86)\EasyPHP-Webserver-14.1b2\www\novo_rtc_web\php\herancas\FuncaoNumerica.php

$it = new RecursiveDirectoryIterator("/Program Files (x86)/EasyPHP-Webserver-14.1b2/www/rtc/php/entidades/");
$it = new RecursiveIteratorIterator($it,RecursiveIteratorIterator::SELF_FIRST);

foreach($it as $file){
    if($file->isFile()){
        include $file;
    }
}

?>
