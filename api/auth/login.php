<?php require("../../app/init.php") ?>

<?php 

if(isset($_POST['username']) AND isset($_POST['password'])){
        
    $username = $DB->ESCAPE($_POST['username']);
    $password = $DB->ESCAPE($_POST['password']);
    
    if(empty($username) AND empty($password)) die(alert("warning", "Username and Password is Empty"));
    if(empty($username)) die(alert("warning", "Username is required to login"));
    if(empty($password)) die(alert("warning", "Password is required to login"));
    
    $where = array("username" => $username, "password" => md5($password));
    $user = $DB->SELECT_ONE_WHERE("users", "*", $where);
    
    if(empty($user)) die(alert("warning", "Invalid account credentials. Check your username and password."));
    
    // CREATE ACCESS TOKEN
    $user_id = $user['user_id'];
    $username = $user['username'];
    $user_token = base64_encode($user_id).".".md5($username);
    
    if(setcookie("_usertoken", $user_token, strtotime('+1 month'), "/")){
        
        $where = array("user_id" => $user_id);
        if($DB->UPDATE('users', array("login_token" => $user_token , "login_last" => DATE_TIME), $where)){
        
            $_SESSION['SUCCESS_LOGIN'] = true;
            
            if($user['role'] == "ADMIN"){
                redirectUrl("/dashboard");
            }else if($user['role'] == "LOGISTIC"){
                redirectUrl("/purchase-orders");
            }else if($user['role'] == "FINANCE"){
                redirectUrl("/audit-management");
            }
            
        }else{
            die(alert("danger", "AUTHENTICATION_FAILED"));	        
        }

    }else{
        die(alert("danger", "SET_TOKEN_FAILED"));
    }
    
}
    

    