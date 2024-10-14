

<?php
require("../../app/init.php");

$user_id = $_POST['user_id'];

// Sanitize and validate input
$username = $DB->ESCAPE($_POST['username']);
$email = $DB->ESCAPE($_POST['email']);
$contact = $DB->ESCAPE($_POST['contact']);
$address = $DB->ESCAPE($_POST['address']);
$about_me = $DB->ESCAPE($_POST['aboutMe']);

// Initialize array to hold any errors
$errors = array();

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
}

// Validate contact (ensure it's numeric)
if (!preg_match("/^[0-9]+$/", $contact)) {
    $errors[] = "Contact number must be numeric";
}

// Handle file upload for profile picture (if provided)
$profile_pic = "";
if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] == 0) {
    // Set allowed file types
    $allowed_types = array("jpg", "jpeg", "png", "gif");
    $file_ext = strtolower(pathinfo($_FILES['profilePicture']['name'], PATHINFO_EXTENSION));

    // Check file type
    if (in_array($file_ext, $allowed_types)) {
        // Generate unique file name
        $new_file_name = uniqid() . '.' . $file_ext;
        $upload_path = "../../assets/uploads/" . $new_file_name;

        // Move file to the destination folder
        if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $upload_path)) {
            // If successful, update the path for the profile picture
            $profile_pic = $new_file_name; // Save only the file name in DB, not the full path
        } else {
            $errors[] = "Failed to upload the profile picture";
        }
    } else {
        $errors[] = "Invalid file type for profile picture. Allowed types are jpg, jpeg, png, gif.";
    }
}

// If no errors, proceed with the update
if (empty($errors)) {
    $data = array(
        "username" => $username,
        "email" => $email,
        "contact" => $contact,
        "address" => $address,
        "about_me" => $about_me,
    );

    // Always update the profile picture if a new one was uploaded
    if (!empty($profile_pic)) {
        $data['profile_pic'] = $profile_pic;
    }

    $where = array("user_id" => $user_id);
    $update_user = $DB->UPDATE("users", $data, $where);

    if ($update_user) {
        // Use your custom swalAlert function for success
        swalAlert('success', 'Profile successfully updated');
    } else {
        // Use your custom swalAlert function for error
        swalAlert('error', 'Failed to update profile');
    }
} else {
    // Loop through the errors and display them using your custom swalAlert function
    foreach ($errors as $error) {
        swalAlert('error', "Contact must be numeric");
    }
}
