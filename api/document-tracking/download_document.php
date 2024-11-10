<?php
// Include database connection
require_once '../../app/init.php';

// Check if document ID is provided
if (!isset($_GET['document_id'])) {
    echo "<p style='text-align: center; color: #198754; font-size: 18px; font-family: Arial, sans-serif;'>"
        . "⚠️ <strong>Error:</strong> Document ID not specified.</p>";
    exit;
}

// Sanitize and validate the document ID
$document_id = intval($_GET['document_id']);

// Fetch document details from the database
$document = $DB->SELECT_ONE("document_tracking", "*", "WHERE document_id = ?", [$document_id]);

// Check if the document exists in the database
if (!$document) {
    echo "<p style='text-align: center; color: #198754; font-size: 18px; font-family: Arial, sans-serif;'>"
        . "⚠️ <strong>Error:</strong> Document not found.</p>";
    exit;
}

// Construct and validate the file path
$file_path = $document['file_path'];
if (!file_exists($file_path)) {
    echo "<p style='text-align: center; color: #198754; font-size: 18px; font-family: Arial, sans-serif;'>"
        . "⚠️ <strong>Error:</strong> File does not exist on the server.</p>";
    exit;
}

// Prepare and set headers for the file download
header("Content-Description: File Transfer");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"" . basename($file_path) . "\"");
header("Content-Transfer-Encoding: binary");
header("Expires: 0");
header("Cache-Control: must-revalidate");
header("Pragma: public");
header("Content-Length: " . filesize($file_path));

// Clear output buffer to prevent additional content from corrupting the download
ob_clean();
flush();

// Stream the file to the user
readfile($file_path);
exit;
