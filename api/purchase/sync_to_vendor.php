<?php
require("../../app/init.php");

// Define the mock vendor portal URL
$url = "http://127.0.0.15/mock_vendor_portal.php"; // Mock URL for testing

// Check if the request method is POST and po_id is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['po_id'])) {
    // Retrieve and sanitize the Purchase Order ID
    $po_id = $DB->ESCAPE($_POST['po_id']);

    // Fetch Purchase Order data from the database
    $where = array("po_id" => $po_id);
    $poData = $DB->SELECT_ONE_WHERE("purchaseorder", "*", $where);

    if (!$poData) {
        echo json_encode(['status' => 'error', 'message' => 'Purchase Order not found.']);
        return; // Return early if PO not found
    }

    // Convert PO data to JSON for sending via API
    $jsonPOData = json_encode($poData, JSON_PRETTY_PRINT);

    // Log the JSON data being sent for debugging
    file_put_contents('log_sent_po_data.txt', $jsonPOData);  // Add this line

    // Initialize cURL for sending data to mock API
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPOData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($jsonPOData)
    ));

    // Execute cURL request and capture response
    $response = curl_exec($ch);
    $syncStatus = "Failed"; // Default sync status
    $errorMessage = 'Unknown error'; // Default error message

    // Handle cURL errors or process response
    if (curl_errno($ch)) {
        $errorMessage = 'Request Error: ' . curl_error($ch);
    } else {
        // Check if the response is not empty
        if ($response) {
            // Decode the API response
            $responseDecoded = json_decode($response, true);

            // Check if response is in JSON format and contains a status
            if (json_last_error() === JSON_ERROR_NONE) {
                $syncStatus = isset($responseDecoded['status']) && $responseDecoded['status'] == 'success' ? 'Synced' : 'Failed';
                $errorMessage = isset($responseDecoded['message']) ? $responseDecoded['message'] : 'No message provided';
            } else {
                // Log the response if it's not valid JSON
                file_put_contents('log_invalid_json_response.txt', $response); // Log the raw response for debugging
                $errorMessage = 'Invalid JSON response from vendor portal.';
            }
        } else {
            $errorMessage = 'Empty response from vendor portal.';
        }
    }

    // Close cURL session
    curl_close($ch);

    // Prepare data to update the purchaseorder table with sync status and response details
    $syncData = array(
        "sync_status" => $DB->ESCAPE($syncStatus),
        "vendor_response" => $DB->ESCAPE($errorMessage),
        "sync_attempts" => $poData['sync_attempts'] + 1,
        "last_sync_attempt" => date('Y-m-d H:i:s')
    );

    // Update the purchaseorder table with sync information
    $updateResult = $DB->UPDATE("purchaseorder", $syncData, $where);

    // Send JSON response based on the update result
    if ($updateResult == "success") {
        echo json_encode(['status' => $syncStatus, 'message' => $errorMessage]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update Purchase Order status in the database.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>