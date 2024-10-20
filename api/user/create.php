<?php
require("../../app/init.php");

// Use the PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

    // Escape and sanitize the input data
    $password = $_POST['username'].rand(1000, 9999);
    $data = array(
        "user_id" => rand(),
        "username" => $DB->ESCAPE($_POST['username']),
        "password" => md5($password),
        "firstname" => $DB->ESCAPE($_POST['user_firstname']),
        "lastname" => $DB->ESCAPE($_POST['user_lastname']),
        "email" => $DB->ESCAPE($_POST['email']),
        "contact" => $DB->ESCAPE($_POST['user_contact']),
        "address" => $DB->ESCAPE($_POST['user_address']),
        "role" => $DB->ESCAPE($_POST['user_role']),
        "status" => "Pending"  // Default status when created
    );

    // Insert the supplier into the database
    $user = $DB->INSERT("users", $data);
    if($user != "success") die(alert("danger", $user['error']));


        // Send email password
        require("../phpmailer/vendor/autoload.php");

        // Configure PHPMailer
        $mail = new PHPMailer(true);    
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'kasl.54370906@gmail.com'; 
        $mail->Password = 'lgrg mpma cwzo uhdv';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port = 587; 

        $email = $_POST['email'];
        $link = '<a href="http://'.$_SERVER['HTTP_HOST'].'/login">http://'.$_SERVER['HTTP_HOST'].'/login</a>';

        // Sender and recipient
        $mail->setFrom('kasl.54370906@gmail.com', 'Logistic Paradise'); 
        $mail->addAddress($email);
        // Email Content
        $mail->isHTML(true);
        $mail->Subject = "Your Account Password";
        $mail->Body = "
            Password: $password<br>
            Link: $link
            <br><br>
            Access your account via your password above kupal.
        ";
        $mail->AltBody = "Password access";

        if ($mail->send()) {
            swalAlert("success", "User Added", "Password sent to email ".$email);
        }else{
            swalAlert("success", "User Added", "Password failed to send");
        }
    
        refreshUrlTimeout(3000);