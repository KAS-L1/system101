<?php

// Clear any previous output to ensure no extra content is sent
ob_clean();

// Set the Content-Type header to application/json
header('Content-Type: application/json');

// Get the raw POST data
$inputData = file_get_contents("php://input");

// Log the raw input data for debugging
file_put_contents('log_received_raw_input.txt', $inputData);  // Log raw data

// Decode the JSON data (assuming the request sends JSON data)
$data = json_decode($inputData, true);

// If the data is not properly decoded, return an error
if (json_last_error() !== JSON_ERROR_NONE) {
    $response = array(
        "status" => "error",
        "message" => "Invalid JSON input received.",
        "error_details" => json_last_error_msg(),  // Include the JSON error message for better debugging
        "raw_input" => $inputData // Log the raw input that caused the issue
    );

    // Log the error to a file for further debugging
    file_put_contents('log_json_error.txt', json_encode($response));  // Log the error details

    echo json_encode($response);
    exit;
}

// Optional: Log the received data to a file for debugging (not printed on the screen)
file_put_contents('log_received_po_data.txt', print_r($data, true));  // Log received data for reference

// Create a response array (simulating a successful vendor sync)
$response = array(
    "status" => "success",
    "message" => "Purchase Order synced successfully to the vendor portal."
);

// Return the response as JSON and ensure no additional output is sent before/after
echo json_encode($response);
exit; // Make sure no additional content is output after this point