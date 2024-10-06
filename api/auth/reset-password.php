<?php
require("../../app/init.php");

// Check if the form is submitted and the token is provided

if (isset($_POST['token'])) {
    // Escape and sanitize the inputs to prevent SQL Injection and XSS
    $token = CHARS($DB->ESCAPE($_POST['token']));
    $newPassword = CHARS($DB->ESCAPE($_POST['newPassword']));
    $confirmPassword = CHARS($DB->ESCAPE($_POST['confirmPassword']));

    // Validate the input fields to ensure they are not empty
    if (empty($newPassword) || empty($confirmPassword)) {
        die(alert("warning", "Both password fields are required."));
    }

    // Check if the passwords match
    if ($newPassword != $confirmPassword) {
        die(alert("warning", "Passwords do not match. Please try again."));
    }
    
    // Password strength validation
    if (
        !preg_match('/.{8,}/', $newPassword) ||         // At least 8 characters
        !preg_match('/[A-Z]/', $newPassword) ||         // At least one uppercase letter
        !preg_match('/[a-z]/', $newPassword) ||         // At least one lowercase letter
        !preg_match('/[0-9]/', $newPassword) ||         // At least one number
        !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $newPassword)  // At least one special character
    ) {
        die(alert("warning", "Password must meet the following criteria: At least 8 characters long, include uppercase and lowercase letters, contain at least one number, and one special character."));
    }


    // Hash the new password using password_hash() for better security
    $hashedPassword = md5($newPassword); // Use password_hash instead of md5

    // Update the user's password and clear the forgot_token field
    $where = array("forgot_token" => $token);
    $data = array("password" => $hashedPassword, "forgot_token" => NULL, "forgot_token_updated" => DATE_TIME);

    
    $update_user = $DB->UPDATE("users", $data, $where);
    if($update_user != "success") die(alert("danger", $update_user['error']));

    alert("success", "Your password has been successfully reset. You will be redirected to the login page in 3 seconds.");
    redirectUrlTimeout("/login.php?res=password-reset", 3000);
    die();
    
} else {
    exit();
}
