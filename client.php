<?php

require $_SERVER['DOCUMENT_ROOT']."/generateWSDL.php";

ini_set("soap.wsdl_cache_enabled", "0");
$client = new SoapClient($_SERVER['DOCUMENT_ROOT']."/definitions.wsdl");


