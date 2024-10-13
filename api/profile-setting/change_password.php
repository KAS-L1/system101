    <?php
    require("../../app/init.php");
    require("../auth/auth.php");
    // pre_die(AUTH_USER);

    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];
    $user_id = $_POST['user_id'];

    // Validate Old Password
    if (md5($oldPassword) != AUTH_USER['password']) {
        swalAlert("error", "Old password is invalid.");
        die();
    }

    //  Validate newPassword  & confirmPassword
    if ($newPassword != $confirmPassword) {
        swalAlert("error", "Confirm new password is not match.");
        die();
    }

    // Password strength validation
    if (
        !preg_match('/.{8,}/', $newPassword) ||         // At least 8 characters
        !preg_match('/[A-Z]/', $newPassword) ||         // At least one uppercase letter
        !preg_match('/[a-z]/', $newPassword) ||         // At least one lowercase letter
        !preg_match('/[0-9]/', $newPassword) ||         // At least one number
        !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $newPassword)  // At least one special character
    ) {
        die(swalAlert("warning", "Password must meet the following criteria: At least 8 characters long, include uppercase and lowercase letters, contain at least one number, and one special character."));
    }

    $data = array(
        "password" => $DB->ESCAPE(md5($newPassword)),
    );

    // Update the requisition in the database
    $where = array("user_id" => $user_id);
    $user = $DB->UPDATE("users", $data, $where);

    // Check if the update is successful
    if ($user == "success") {
        swalAlert("success", "Password successfully updated");
        redirectUrlTimeout('../api/auth/logout.php', 2000);
    } else {
        swalAlert("error", "Failed to update password");
    }
