<?php
    require_once "RServer.php";   
    ini_set("soap.wsdl_cache_enabled", "0"); // отключаем кэширование WSDL 
    $server = new SoapServer("definitions.wsdl");  
    $server->setClass("RServer");
    $server->handle();