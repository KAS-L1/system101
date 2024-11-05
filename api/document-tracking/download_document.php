<?php
require("../../app/init.php");

// Check if document ID is provided
if (!isset($_GET['document_id'])) {
    die("Error: Document ID not specified.");
}

$document_id = intval($_GET['document_id']);

// Fetch document details from the database
$document = $DB->SELECT_ONE("document_tracking", "*", "WHERE document_id = ?", [$document_id]);

// Check if the document exists
if (!$document) {
    die("Error: Document not found.");
}

// Set the file path and ensure it exists on the server
$file_path = $document['file_path'];
if (!file_exists($file_path)) {
    die("Error: File does not exist.");
}

// Set headers for file download
header("Content-Description: File Transfer");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"" . basename($file_path) . "\"");
header("Content-Transfer-Encoding: binary");
header("Expires: 0");
header("Cache-Control: must-revalidate");
header("Pragma: public");
header("Content-Length: " . filesize($file_path));

// Clear output buffer and read the file
ob_clean();
flush();
readfile($file_path);
exit;
