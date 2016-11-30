<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/client.php";
    $data = $client->search($_POST['cat']*1, $_POST['min'], $_POST['max']);
    
    
    echo json_encode(array("status"=>"OK","data"=>$data),JSON_UNESCAPED_UNICODE);