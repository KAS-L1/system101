<?php
require("../../app/init.php");

if ($_POST) {
    $user_id = $_POST['user_id'];
    
    // Update database (assuming $DB->UPDATE works as per your framework)
    $data = array(
        "firstname" => $DB->ESCAPE($_POST['firstname']),
        "lastname" => $DB->ESCAPE($_POST['lastname']),
        "email" => $DB->ESCAPE($_POST['email']),
        "contact" => $DB->ESCAPE($_POST['contact']),
        "address" => $DB->ESCAPE($_POST['address']),
        "status" => $DB->ESCAPE($_POST['status']),
        "about_me" => $DB->ESCAPE($_POST['aboutMe']),
        "role" => $DB->ESCAPE($_POST['role']),
    );

    $where = array("user_id" => $user_id);
    $update_result = $DB->UPDATE("users", $data, $where);
    
    // If update is successful, also update session data
    if ($update_result == "success") {
        $_SESSION['firstname'] = $_POST['firstname'];
        $_SESSION['lastname'] = $_POST['lastname'];
        $_SESSION['role'] = $_POST['role'];

        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update profile.']);
    }
}
?>
