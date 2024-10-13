<?php
require("../../app/init.php");


$user_id = $_POST['user_id'];

// Update database (assuming $DB->UPDATE works as per your framework)
$data = array(
    "email" => $DB->ESCAPE($_POST['email']),
    "contact" => $DB->ESCAPE($_POST['contact']),
    "address" => $DB->ESCAPE($_POST['address']),
    "about_me" => $DB->ESCAPE($_POST['aboutMe']),
);

$where = array("user_id" => $user_id);
$update_user = $DB->UPDATE("users", $data, $where);

if ($update_user == "success") {
    swalAlert("success", "Profile successfully updated");
    refreshUrlTimeout(2000);
} else {
    swalAlert("error", "Failed to update profile");
}
