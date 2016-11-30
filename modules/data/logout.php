<?php
    session_start();
    $_SESSION['ssid']="";
    
    die(json_encode(array("status"=>"OK","data"=>"")));