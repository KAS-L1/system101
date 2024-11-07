<?php
require("../../app/init.php");

$token = "e4a1dc5ef53c09f405a44f4b071b4c9b";

$document_type = $_POST['document_type'] ?? null;
$priority = $_POST['priority'] ?? null;

if (!$document_type || !$priority) {
    echo json_encode(["status" => "error", "message" => "Document type and priority are required."]);
    exit;
}

$data = json_encode(["document_type" => (int)$document_type, "priority" => (int)$priority]);

$url = 'http://127.0.0.1:5003/predict_processing_time';
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "Authorization: Bearer $token"));
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(["status" => "error", "message" => 'Curl error: ' . curl_error($ch)]);
    curl_close($ch);
    exit;
}

curl_close($ch);
$prediction = json_decode($response, true);

if (isset($prediction['predicted_processing_time'])) {
    echo json_encode(["status" => "success", "predicted_processing_time" => $prediction['predicted_processing_time']]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to retrieve prediction."]);
}
