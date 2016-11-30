<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/utils/Utils.php";
    session_start();
    
    define(ROLE_USER, 1);
    define(ROLE_MODERATOR, 2);
    
    $ssid = $_SESSION['ssid'];
    $ssid = trim($ssid);
    
    $sql = new SQLConnection;
    
    #print_r($_SESSION);
    
    $data = $sql->getArray("SELECT * FROM users WHERE ssid='$ssid'");
    
    if(count($data)==0 || !$ssid){
        echo "<form class='signin'>
            <h2>Sign In</h2>
            <label>
                <span>Login</span>
                <input type='text' name='username' id='username'/>
            </label>
            
            <label>
                <span>Password</span>
                <input type='password' name='password' id='password'/>
            </label>
            
            <input type='submit' value='Submit' />
            <p id='status'></p>
        </form>";
    }else{
        $role = 'guest';
        if($data[0]['role']==ROLE_MODERATOR){
            $role='moderator';
        }
        echo "<hgroup>
            <h2>Hello, {$data[0]['name']}</h2>
            <p>Your system role: {$role}.</p>
        </hgroup>
        <input type='button' value='Log out' id='logout'/>
        ";
        
    }
?>