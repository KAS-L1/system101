<?php
require("../../app/init.php");

// Sanitize and escape input data
$data = array(
    "po_id" => $DB->ESCAPE($_POST['po_id']),
    "amount" => $DB->ESCAPE($_POST['amount']),
    "payment_terms" => $DB->ESCAPE($_POST['payment_terms']),
    "due_date" => $DB->ESCAPE($_POST['due_date']),
    "remarks" => $DB->ESCAPE($_POST['remarks']),
    "payment_status" => $DB->ESCAPE($_POST['payment_status']),
    "vendor_id" => $DB->SELECT_ONE_WHERE('purchaseorder', 'vendor_id', array("po_id" => $_POST['po_id']))['vendor_id'], // Get vendor ID from the linked purchase order
);

// Insert the new invoice into the `invoice_payments` table
$insertInvoice = $DB->INSERT("invoice_payments", $data);

// Check if the insert was successful
if ($insertInvoice) {
    swalAlert("success", "Invoice created successfully!");
    refreshUrlTimeout(2000);
} else {
    swalAlert("error", "Failed to create invoice. Please try again.");
}
