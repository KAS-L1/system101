<?php
require("../../app/init.php");

// Escape and sanitize the input data
$data = array(
    "po_id" => rand(), // Assuming a random ID is needed for new entries
    "vendor_name" => $DB->ESCAPE($_POST['vendor_name']),
    "items" => $DB->ESCAPE($_POST['items']),
    "quantity" => intval($DB->ESCAPE($_POST['quantity'])), // Ensuring quantity is an integer
    "unit_price" => floatval($DB->ESCAPE($_POST['unit_price'])), // Ensuring unit price is a float
    "total_cost" => floatval($DB->ESCAPE($_POST['quantity'])) * floatval($DB->ESCAPE($_POST['unit_price'])), // Calculate total cost
    "order_date" => $DB->ESCAPE($_POST['order_date']),
    "delivery_date" => $DB->ESCAPE($_POST['delivery_date']),
    "status" => "Ordered", // Default status when created
    "remarks" => $DB->ESCAPE($_POST['remarks']),
);

// Insert the new PO into the purchaseorder table
$purchaseOrder = $DB->INSERT("purchaseorder", $data);

// Check if the Purchase Order was successfully created
if ($purchaseOrder) {
    // Display success alert and refresh page
    swalAlert('success', 'Purchase Order Created Successfully!');
    refreshUrlTimeout(2000);
} else {
    // Display error alert if something goes wrong
    swalAlert('error', 'Failed to Create Purchase Order');
}
?>