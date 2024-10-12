<?php
require("../../app/init.php");

if (isset($_POST['user_id'])) {
    $user_id = CHARS($DB->ESCAPE($_POST['user_id']));
    $oldPassword = CHARS($DB->ESCAPE($_POST['oldPassword']));
    $newPassword = CHARS($DB->ESCAPE($_POST['newPassword']));
    $confirmPassword = CHARS($DB->ESCAPE($_POST['confirmPassword']));

    // Check if any password field is empty
    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
        die(json_encode(['status' => 'warning', 'message' => 'All password fields are required.']));
    }

    // Check if new passwords match
    if ($newPassword != $confirmPassword) {
        die(json_encode(['status' => 'warning', 'message' => 'New passwords do not match.']));
    }

    // Validate new password format
    if (
        !preg_match('/.{8,}/', $newPassword) ||
        !preg_match('/[A-Z]/', $newPassword) ||
        !preg_match('/[a-z]/', $newPassword) ||
        !preg_match('/[0-9]/', $newPassword) ||
        !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $newPassword)
    ) {
        die(json_encode(['status' => 'warning', 'message' => 'Password must meet the criteria.']));
    }

    // Hash the new password using md5 (as per your existing logic)
    $hashedPassword = md5($newPassword);

    // Check if the old password matches the stored one
    $sql = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($storedPassword);
    $stmt->fetch();

    // Verify old password
    if ($storedPassword !== md5($oldPassword)) {
        die(json_encode(['status' => 'warning', 'message' => 'Old password is incorrect.']));
    }

    $stmt->close();

    // Prepare data for update
    $data = array("password" => $hashedPassword, "updated_at" => DATE_TIME);
    $where = array("id" => $user_id);

    // Update password in the database
    $update_user = $DB->UPDATE("users", $data, $where);
    if ($update_user != "success") {
        die(json_encode(['status' => 'error', 'message' => $update_user['error']]));
    }

    // Return success message
    echo json_encode(['status' => 'success', 'message' => 'Your password has been successfully reset.']);
    exit();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized request.']);
    exit();
}
?>
