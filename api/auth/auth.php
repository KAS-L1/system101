<?php

/*
* Authenticate user and validate user token
*/

if(isset($_COOKIE['_usertoken'])){
	
	$user_token = explode(".", $_COOKIE['_usertoken']);
    $user_id = base64_decode($user_token[0]);
    
    $where = array("user_id"=> $user_id, "login_token" => $_COOKIE['_usertoken']);
    $user = $DB->SELECT_ONE_WHERE("users", "*", $where);
	
	if(!empty($user)){
	    define('AUTH_USER_ID', $user['user_id']);
	    define('AUTH_USER', $user);
	}else{
        setcookie("_usertoken", '', -1, "/");
		die(redirectUrl("../../login.php?res=403&action=2"));
	}

}else{
    die(redirectUrl("../../login.php?res=403&action=1"));
}

