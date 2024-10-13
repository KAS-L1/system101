<?php

/*
* Authenticate user and validate user token
*/


// Check if the '_usertoken' cookie is set
if (isset($_COOKIE['_usertoken'])) {

	// Split the cookie to get user_id and login_token
	$user_token = explode(".", $_COOKIE['_usertoken']);

	// Ensure the token has the correct format (2 parts after splitting)
	if (count($user_token) !== 2) {
		// Invalid token format, clear cookie and redirect to login
		setcookie("_usertoken", '', time() - 3600, "/");
		die(redirectUrl("../../login.php?res=403&action=2"));
	}

	// Decode the user_id part of the token
	$user_id = base64_decode($user_token[0]);

	// Escape the user_id for safety
	$escaped_user_id = $DB->ESCAPE($user_id);

	// Verify the login_token and user_id from the database
	$where = array("user_id" => $escaped_user_id, "login_token" => $_COOKIE['_usertoken']);
	$user = $DB->SELECT_ONE_WHERE("users", "*", $where);

	// If the user exists and the token is valid
	if (!empty($user)) {
		// Define constants to use authenticated user details globally
		define('AUTH_USER_ID', $user['user_id']);
		define('AUTH_USER', $user);

		// OPTIONAL: Generate CSRF token if needed for future form submissions
		if (!isset($_SESSION['csrf_token'])) {
			$_SESSION['csrf_token'] = generate_csrf_token(); // generate_csrf_token() function can be used
		}
	} else {
		// Invalid token or user not found, clear the cookie and redirect to login
		setcookie("_usertoken", '', time() - 3600, "/");
		die(redirectUrl("../../login.php?res=403&action=2"));
	}
} else {
	// No token found, redirect to login
	die(redirectUrl("../../login.php?res=403&action=1"));
}
