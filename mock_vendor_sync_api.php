<?php

// Clear any previous output to ensure no extra content is sent
ob_clean();

// Set the Content-Type header to application/json
header('Content-Type: application/json');

// Get the raw POST data
$inputData = file_get_contents("php://input");

// Log the raw input data for debugging purposes
file_put_contents('log_received_contract_input.txt', $inputData);  // Log raw input data

// Decode the JSON data (assuming the request sends JSON data)
$data = json_decode($inputData, true);

// If the data is not properly decoded, return an error response
if (json_last_error() !== JSON_ERROR_NONE) {
    $response = array(
        "status" => "error",
        "message" => "Invalid JSON input received.",
        "error_details" => json_last_error_msg(),  // Include the JSON error message for better debugging
        "raw_input" => $inputData  // Log the raw input that caused the issue
    );

    // Log the error to a file for further debugging
    file_put_contents('log_json_error.txt', json_encode($response));  // Log the error details

    echo json_encode($response);
    exit;
}

// Optional: Log the received data for debugging (not printed on the screen)
file_put_contents('log_received_contract_data.txt', print_r($data, true));  // Log received data for reference

// Display the received data on the screen for easy checking (JSON format)
echo json_encode([
    "status" => "success",
    "message" => "Contract synced successfully to the vendor system.",
    "received_data" => $data  // Display the received contract data
]);

exit;  // Ensure no additional content is output after this point
