<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/utils/Utils.php";
    
    
    $name = $_POST['username'];
    $pw = md5($_POST['password']);
    
    $sql = new SQLConnection;
    $data = $sql->getArray("SELECT * FROM users WHERE name='$name' AND password='$pw'");
    
    if(!count($data)){
        die(json_encode(array("status"=>"ERROR","message"=>"Incorrect username or password!")));
    }
    
    $id = $data[0]['id'];
    $ssid = md5(rand(0,999999).$pw.rand(0,999999));
    $sql->query("UPDATE users SET ssid='$ssid' WHERE id=$id");
   
    session_start();
    $_SESSION['ssid']=$ssid;
    
    
    die(json_encode(array("status"=>"OK",'data'=>"")));