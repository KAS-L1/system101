<?php
include('../../app/init.php');
header('Content-Type: application/json');

// Validate the token provided in the request
if (!isset($_GET['token']) || $_GET['token'] !== PURCHASE_REQUISITION_VIEW_TOKEN) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid token."
    ]);
    exit();
}

// Check if the 'status' parameter is set and sanitize it
$status = isset($_GET['status']) ? $DB->ESCAPE($_GET['status']) : 'Pending'; // Default to 'Pending'

// Define the query condition for fetching requisitions
$options = "";
if (strtolower($status) !== 'all') {
    // If a specific status is provided or the default 'Pending', add a condition to filter by status
    $optijons = "WHERE status = '$status'";
}

// Define the fields to fetch from the database
$fields = "requisition_id, department, item_description, quantity, estimated_cost, unit_of_measure, priority_level, requested_date, required_date, status, remarks";

// Add order by condition to the options
$options .= " ORDER BY requested_date ASC";

try {
    // Fetch the requisitions with the specified or all statuses
    $requisitions = $DB->SELECT('purchaserequisition', $fields, $options);

    // Check if any records were found
    if (!empty($requisitions)) {
        echo json_encode([
            "status" => "success",
            "data" => $requisitions
        ]);
    } else {
        echo json_encode([
            "status" => "success",
            "message" => "No requisitions found.",
            "data" => []
        ]);
    }
} catch (Exception $e) {
    // Catch and handle any exceptions
    echo json_encode([
        "status" => "error",
        "message" => "An error occurred while fetching requisitions: " . $e->getMessage()
    ]);
}
