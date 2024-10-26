<?php
require("../../app/init.php");


// Escape and sanitize the input data
$data = array(
    "vendor_name" => $DB->ESCAPE($_POST['vendor_name']),
    "items" => $DB->ESCAPE($_POST['items']),
    "quantity" => $DB->ESCAPE($_POST['quantity']), // Assuming quantity is handled by your framework as needed
    "delivery_method" => $DB->ESCAPE($_POST['delivery_method']),
    "status" => $DB->ESCAPE($_POST['status']),
    "delivery_date" => $DB->ESCAPE($_POST['delivery_date']),
    "tracking_link" => $DB->ESCAPE($_POST['tracking_link']),
);


// Get the Purchase Order ID from the form
$po_id = $DB->ESCAPE($_POST['po_id']);

// Define where clause for updating the specific Purchase Order
$where = array("po_id" => $po_id);

// Update the Purchase Order in the database
$updatePO = $DB->UPDATE("purchaseorder", $data, $where);

// Check if the update is successful
if ($updatePO == "success") {
    swalAlert("success", "Delivery Update successfully updated");
    refreshUrlTimeout(2000);
} else {
    swalAlert("error", "Failed to update Delivery Update");
}
