<?php
require("../../app/init.php");

$document_id = $_POST['document_id'];
$document = $DB->SELECT_ONE("document_tracking", "*", "WHERE document_id = ?", [$document_id]);

if ($document) {
    // Construct the URL to the document
    $document['file_url'] = '/uploads/documents/' . $document['file_path'];
    echo json_encode($document);
} else {
    echo json_encode(["error" => "Document not found."]);
}
