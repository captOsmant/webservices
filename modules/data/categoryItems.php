<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/client.php";
    $data = $client->getItemsOf($_POST['id']*1);
    
    
    echo json_encode(array("status"=>"OK","data"=>$data),JSON_UNESCAPED_UNICODE);