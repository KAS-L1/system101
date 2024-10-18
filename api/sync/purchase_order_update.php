<?php
include('../../app/init.php');

// Token should ideally be stored securely (e.g., environment variables or database)
$token = "d368051b3cd2819131fff6811cf4e59cd";

if (!isset($_GET['token']) or $_GET['token'] != $token) {
    die(json_encode(["status" => "error", "message" => "Invalid token."]));
}

if (!isset($_GET['status']) or !isset($_GET['po_id'])) {
    die(json_encode(["status" => "error", "message" => "Invalid parameters: status and po_id are required."]));
}

$status = $_GET['status'];
$po_id = $_GET['po_id'];
$remarks = $_GET['remarks'] ?? null;  // Optional remarks

// Escape and sanitize the input data
$data = array(
    "status" => $DB->ESCAPE($status),
    "remarks" => $DB->ESCAPE($remarks), // Optional remarks
    "updated_at" => date("Y-m-d H:i:s"), // Ensure the timestamp is updated
    "sync_status" => 'Pending', // Reset sync status if applicable
);

// Define where clause for updating the specific Purchase Order
$where = array("po_id" => $po_id);

// Update the Purchase Order in the database
$updatePO = $DB->UPDATE("purchaseorder", $data, $where);

// Check if the update is successful and return a JSON response
if ($updatePO == "success") {
    echo json_encode(["status" => "success", "message" => "ORDER_UPDATED"]);
} else {
    echo json_encode(["status" => "error", "message" => "FAILED_TO_UPDATE"]);
}
