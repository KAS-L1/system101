<?php
require("../../app/init.php");
?>

<?php
// Check if the form is submitted

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

    // Get the supplier ID from the form
    $user_id = $_POST['user_id'];

    $where = array("user_id" => $user_id);
    // Insert the supplier into the database
    $user = $DB->INSERT("users", $data);



    // Check if the update is successful
    if ($supplier) {
        swalAlert("success", "User Updated");
        refreshUrlTimeout(2000);
    } else {
        swalAlert("error", "Failed to update user");
    }
?>