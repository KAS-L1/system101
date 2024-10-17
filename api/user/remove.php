<?php
require("../../app/init.php");
?>

<?php

// Get the supplier ID from the form
$user_id = $_POST['user_id'];

// Update the supplier in the database
$where = array("user_id" => $user_id);
$user = $DB->DELETE("users", $where);

// Check if the update is successful
if ($user) {
    swalAlert("success", "User Removed");
    refreshUrlTimeout(2000);
} else {
    swalAlert("error", "Failed to remove user");
}
?>