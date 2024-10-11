<?php
require("../../app/init.php");

// Check if the form is submitted with POST data
if ($_POST) {
    // Retrieve the user ID from the POST data
    $user_id = $_POST['user_id'];
    // Escape and sanitize the input data
    $data = array(
        "username" => $DB->ESCAPE($_POST['username']),
        "firstname" => $DB->ESCAPE($_POST['user_firstname']),
        "lastname" => $DB->ESCAPE($_POST['user_lastname']),
        "email" => $DB->ESCAPE($_POST['email']),
        "contact" => $DB->ESCAPE($_POST['user_contact']),
        "address" => $DB->ESCAPE($_POST['user_address']),
        "role" => $DB->ESCAPE($_POST['user_role'])
    );

    $where = array("user_id" => $user_id);

    // Update the user in the database
    $user = $DB->UPDATE("users", $data, $where);
    if($user != "success") alert("danger", $user['error']);

    swalAlert("success", "User Updated");
    refreshUrlTimeout(2000);
}
?>