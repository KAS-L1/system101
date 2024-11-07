<?php
require("../../app/init.php");

$token = "a1f0b11be3cc20c457d523b8313dbb1c";  // Replace with your actual token

// Validate input
$month = isset($_POST['month']) ? (int)$_POST['month'] : null;
$year = isset($_POST['year']) ? (int)$_POST['year'] : null;

if (!$month || !$year) {
    echo json_encode(["status" => "error", "message" => "Invalid input. Please provide both month and year."]);
    exit;
}

$data = json_encode(["month" => $month, "year" => $year]);

$url = 'http://127.0.0.1:5000/predict_demand';
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

if (isset($prediction['predicted_demand'])) {
    echo json_encode([
        "status" => "success",
        "predicted_demand" => round($prediction['predicted_demand'], 2),
        "message" => "Prediction retrieved successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to retrieve prediction."
    ]);
}
