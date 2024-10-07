<?php
require("../../app/init.php");


    // Escape and sanitize the input data
    $data = array(
        "user_id" => rand(),
        "username" => $DB->ESCAPE($_POST['username']),
        "firstname" => $DB->ESCAPE($_POST['user_firstname']),
        "lastname" => $DB->ESCAPE($_POST['user_lastname']),
        "email" => $DB->ESCAPE($_POST['email']),
        "contact" => $DB->ESCAPE($_POST['user_contact']),
        "address" => $DB->ESCAPE($_POST['user_address']),
        "status" => "Pending"  // Default status when created
    );

    // Insert the supplier into the database
    $user = $DB->INSERT("users", $data);

    swalAlert("success", "User Added");
    refreshUrlTimeout(2000);