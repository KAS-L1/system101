<?php
require("../../app/init.php");

$document_id = $_POST['document_id'] ?? null;
$response = ['status' => 'error', 'message' => 'Unknown error occurred'];

if ($document_id) {
    // Fetch file path to delete
    $document = $DB->SELECT_ONE("document_tracking", "file_path", "WHERE document_id = ?", [$document_id]);

    if ($document) {
        // DELETE DATA
        $deleteStatus = $DB->DELETE("document_tracking", ["document_id" => $document_id]);

        if ($deleteStatus === "success") {
            // Delete file from server if exists
            $filePath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/documents/' . $document['file_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $response = ['status' => 'success', 'message' => "Document deleted successfully"];
        } else {
            $response['message'] = $deleteStatus['error'];
        }
    } else {
        $response['message'] = "Document not found";
    }
} else {
    $response['message'] = "Invalid document ID";
}

echo json_encode($response);
