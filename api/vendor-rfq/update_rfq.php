<?php
require("../../app/init.php");

// Check if RFQ ID is provided
if (empty($_POST['rfq_id'])) {
    swalAlert("error", "RFQ ID is required.");
    exit;
}

// Sanitize and prepare the data for updating the RFQ
$rfq_id = $_POST['rfq_id'] ?? null; // Use null coalescing to avoid undefined index
$data = [
    "vendor_id" => $DB->ESCAPE($_POST['vendor_id'] ?? ''), // Ensure vendor_id is properly sanitized
    "product_id" => $DB->ESCAPE($_POST['product_id'] ?? ''), // Check if product_id is set
    "requested_quantity" => $DB->ESCAPE($_POST['requested_quantity'] ?? ''),
    "quoted_price" => $DB->ESCAPE($_POST['quoted_price'] ?? 0), // Default to 0 if not provided
    "rfq_status" => $DB->ESCAPE($_POST['rfq_status'] ?? ''),
    "remarks" => $DB->ESCAPE($_POST['response_remarks'] ?? ''),
];

// Check if product_id is set
if (empty($data['product_id'])) {
    swalAlert("error", "Product ID is required.");
    exit;
}

// Only require the fields you need for the update
$where = ["rfq_id" => $rfq_id];
$updateRFQ = $DB->UPDATE("rfqs", $data, $where);

// Check the result of the update operation
if ($updateRFQ === "success") {
    swalAlert("success", "RFQ updated successfully.");
    refreshUrlTimeout(2000); // Optional: refresh page after 2 seconds
} else {
    // Assuming $updateRFQ might return an error array
    $error_message = is_array($updateRFQ) && isset($updateRFQ['error']) ? $updateRFQ['error'] : "Unknown error";
    swalAlert("error", "Failed to update RFQ: " . $error_message);
}
?>
