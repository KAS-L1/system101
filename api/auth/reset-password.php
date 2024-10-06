<?php
require("../../app/init.php");

// Check if the form is submitted and the token is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['token'])) {
    // Escape and sanitize the inputs to prevent SQL Injection and XSS
    $token = CHARS($DB->ESCAPE($_POST['token']));
    $newPassword = CHARS($DB->ESCAPE($_POST['newPassword']));
    $confirmPassword = CHARS($DB->ESCAPE($_POST['confirmPassword']));

    // Validate the input fields to ensure they are not empty
    if (empty($newPassword) || empty($confirmPassword)) {
        echo alert("warning", "Both password fields are required.");
        exit;
    }

    // Check if the passwords match
    if ($newPassword !== $confirmPassword) {
        echo alert("warning", "Passwords do not match. Please try again.");
        exit;
    }
    pre_die($newPassword);
    // Password strength validation
    if (
        !preg_match('/.{8,}/', $newPassword) ||         // At least 8 characters
        !preg_match('/[A-Z]/', $newPassword) ||         // At least one uppercase letter
        !preg_match('/[a-z]/', $newPassword) ||         // At least one lowercase letter
        !preg_match('/[0-9]/', $newPassword) ||         // At least one number
        !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $newPassword)  // At least one special character
    ) {
        echo alert("warning", "Password must meet the following criteria: At least 8 characters long, include uppercase and lowercase letters, contain at least one number, and one special character.");
        exit;
    }

    // Verify the token and get the associated user
    $user = $DB->SELECT_ONE_WHERE("users", "*", array("forgot_token" => $token));
    if (empty($user)) {
        echo alert("danger", "Invalid or expired token. Please request a new password reset link.");
        header("Location: ../login.php?res=403&action=1");
        exit;
    }

    // Hash the new password using password_hash() for better security
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT); // Use password_hash instead of md5

    // Update the user's password and clear the forgot_token field
    $where = array("user_id" => $user['user_id']);
    $update_data = array("password" => $hashedPassword, "forgot_token" => NULL);

    try {
        if ($DB->UPDATE("users", $update_data, $where)) {
            echo alert("success", "Your password has been successfully reset. You will be redirected to the login page in 3 seconds.");
            header("refresh:3;url=../login.php"); // Redirect to login page after 3 seconds
            exit();
        } else {
            throw new Exception("Failed to update your password. Please try again.");
        }
    } catch (Exception $e) {
        echo alert("danger", $e->getMessage());
    }
} else {
    header("Location: ../login.php");
    exit();
}
