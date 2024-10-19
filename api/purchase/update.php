<?php
require("../../app/init.php");


// Escape and sanitize the input data
$data = array(
    "vendor_name" => $DB->ESCAPE($_POST['vendor_name']),
    "items" => $DB->ESCAPE($_POST['items']),
    "quantity" => $DB->ESCAPE($_POST['quantity']), // Assuming quantity is handled by your framework as needed
    "unit_price" => $DB->ESCAPE($_POST['unit_price']), // Assuming unit price is handled by your framework
    "total_cost" => $DB->ESCAPE($_POST['quantity'] * $_POST['unit_price']), // Calculate total cost after escaping inputs
    "order_date" => $DB->ESCAPE($_POST['order_date']),
    "delivery_date" => $DB->ESCAPE($_POST['delivery_date']),
    "status" => $DB->ESCAPE($_POST['status']),
    "remarks" => $DB->ESCAPE($_POST['remarks']) // Optional remarks
);


// Get the Purchase Order ID from the form
$po_id = $DB->ESCAPE($_POST['po_id']);

// Define where clause for updating the specific Purchase Order
$where = array("po_id" => $po_id);

// Update the Purchase Order in the database
$updatePO = $DB->UPDATE("purchaseorder", $data, $where);

// Check if the update is successful
if ($updatePO == "success") {
    swalAlert("success", "Purchase Order successfully updated");
    refreshUrlTimeout(2000);
} else {
    swalAlert("error", "Failed to update Purchase Order");
}
