<?php
require("../../app/init.php");

// Use the PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the form is submitted
if (isset($_POST['email'])) {
    // Escape and sanitize the email input
    $email = filter_var($DB->ESCAPE($_POST['email']), FILTER_VALIDATE_EMAIL);

    // Validate the email field
    if (!$email) {
        echo alert("warning", "A valid email is required to reset the password.");
        exit;
    }
    
    // Check if the email exists in the users table
    $user = $DB->SELECT_ONE_WHERE("users", "*", array("email" => $email));
    if (empty($user)) {
        echo alert("warning", "Email not found in our records. Please check your email address.");
        exit;
    }
    
    // Generate a unique and secure forgot password token using random_bytes()
    $token = bin2hex(random_bytes(32));  // Generates a 64-character secure token

    // Update the forgot_token and forgot_token_updated in the database for the specified user
    $where = array("user_id" => $user['user_id']);
    $update_data = array("forgot_token" => $token, "forgot_token_updated" => DATE_TIME);
    $token_update = $DB->UPDATE("users", $update_data, $where);

    if ($token_update == "success") {
        // Construct the password reset link with the token
        $resetLink = "http://".$_SERVER['HTTP_HOST']."/reset-password.php?token=".$token;

        // Load PHPMailer classes
        require("../phpmailer/vendor/autoload.php");

        // Configure PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'kasl.54370906@gmail.com'; 
            $mail->Password = 'lgrg mpma cwzo uhdv';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
            $mail->Port = 587; 

            // Sender and recipient
            $mail->setFrom('kasl.54370906@gmail.com', 'Logistic Paradise'); 
            $mail->addAddress($email);

            // Email Content
            $mail->isHTML(true);
            $mail->Subject = "Your Password Reset Request";
            $mail->Body    = "<p>We received a request to reset your password. Click the link below to reset your password:</p>
                              <p><a href='$resetLink'>$resetLink</a></p>
                              <p>If you did not request a password reset, please ignore this email.</p>";
            $mail->AltBody = "We received a request to reset your password. Click the link below to reset your password: $resetLink. If you did not request a password reset, please ignore this email.";

            if ($mail->send()) {
                echo alert("success", "Password reset link has been sent to $email. Please check your inbox.");
            } else {
                echo alert("danger", "Failed to send the password reset link. Please try again later.");
            }
        } catch (Exception $e) {
            echo alert("danger", "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
        
    } else { 
        echo alert("danger", "Failed to generate password reset link. Please try again.");
    }
} 
