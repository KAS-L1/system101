<?php
require("../../app/init.php");

$token = "c15e7b2f15810b6c3cf9c287aa927f0e";

$severity = $_POST['severity'] ?? null;
$frequency = $_POST['frequency'] ?? null;

if (!$severity || !$frequency) {
    echo json_encode(["status" => "error", "message" => "Severity and frequency are required."]);
    exit;
}

$data = json_encode(["severity" => (int)$severity, "frequency" => (int)$frequency]);

$url = 'http://127.0.0.1:5001/predict_non_compliance_risk';
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

if (isset($prediction['risk'])) {
    echo json_encode(["status" => "success", "risk" => $prediction['risk']]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to retrieve prediction."]);
}
