<?php
require("../../app/init.php");

$document_name = $_POST['document_name'];
$category = $_POST['category'];
$department = $_POST['department'];
$priority = $_POST['priority'];
$remarks = $_POST['remarks'];
$tags = $_POST['tags'];
$status = 'Pending Review';

// Check if file was uploaded without errors
if (isset($_FILES['file_attachment']) && $_FILES['file_attachment']['error'] == 0) {
    $file = $_FILES['file_attachment'];
    $allowed_ext = ['pdf', 'docx', 'jpg'];
    $max_size = 10 * 1024 * 1024; // 10 MB
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);

    if (!in_array($ext, $allowed_ext)) {
        die("Unsupported file type. Only PDF, DOCX, and JPG files are allowed.");
    }

    if ($file['size'] > $max_size) {
        die("File size exceeds 10 MB limit.");
    }

    // Generate a unique file name
    $file_name = uniqid() . '.' . $ext;
    $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/documents/' . $file_name;

    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        // Insert document record into database
        $data = [
            'document_name' => $DB->ESCAPE($document_name),
            'category' => $DB->ESCAPE($category),
            'department' => $DB->ESCAPE($department),
            'priority' => $DB->ESCAPE($priority),
            'remarks' => $DB->ESCAPE($remarks),
            'tags' => $DB->ESCAPE($tags),
            'status' => $status,
            'file_path' => $file_name // Save only the filename in DB
        ];

        $insertResult = $DB->INSERT("document_tracking", $data);

        if ($insertResult === "success") {
            echo "Document uploaded successfully.";
        } else {
            echo "Failed to save document data: " . $insertResult['error'];
        }
    } else {
        die("Failed to move uploaded file.");
    }
} else {
    die("Error uploading file.");
}
