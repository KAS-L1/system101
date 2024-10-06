<?php require("../../app/init.php") ?>

<?php 
// Check if the username and password are set in the POST request
if(isset($_POST['username']) AND isset($_POST['password'])){
        
    // Escape the username and password to prevent SQL injection
    $username = $DB->ESCAPE($_POST['username']);
    $password = $DB->ESCAPE($_POST['password']);
    
    // Check for empty username and password
    if(empty($username) AND empty($password)) 
        // If both are empty, display a warning message
        die(alert("warning", "Username and Password is Empty"));
    if(empty($username)) 
        // If only username is empty, display a warning message
        die(alert("warning", "Username is required to login"));
    if(empty($password)) 
        // If only password is empty, display a warning message
        die(alert("warning", "Password is required to login"));
    
    // Create a where clause for the database query
    $where = array("username" => $username, "password" => md5($password));
    
    // Query the database to find a user with the given username and password
    $user = $DB->SELECT_ONE_WHERE("users", "*", $where);
    
    // If no user is found, display a warning message
    if(empty($user)) 
        die(alert("warning", "Invalid account credentials. Check your username and password."));
    
    // Create an access token for the user
    $user_id = $user['user_id'];
    $username = $user['username'];
    $user_token = base64_encode($user_id).".".md5($username);
    
    // Set a cookie with the access token
    if(setcookie("_usertoken", $user_token, strtotime('+1 month'), "/")){
        
        // Update the user's login token and last login time in the database
        $where = array("user_id" => $user_id);
        if($DB->UPDATE('users', array("login_token" => $user_token , "login_last" => DATE_TIME), $where)){
        
            // Set a session variable to indicate a successful login
            $_SESSION['SUCCESS_LOGIN'] = true;
            
            // Redirect the user to their dashboard based on their role
            if($user['role'] == "ADMIN"){
                redirectUrl("/dashboard");
            }else if($user['role'] == "LOGISTIC"){
                redirectUrl("/purchase-orders");
            }else if($user['role'] == "FINANCE"){
                redirectUrl("/audit-management");
            }
            
        }else{
            // If the database update fails, display an error message
            die(alert("danger", "AUTHENTICATION_FAILED"));	        
        }

    }else{
        // If the cookie cannot be set, display an error message
        die(alert("danger", "SET_TOKEN_FAILED"));
    }
    
}