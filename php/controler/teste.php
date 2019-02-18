<?php

include("includes.php");

$c = new ConnectionFactory();

echo Utilidades::toJson(Sistema::getCompraParceiros($c));