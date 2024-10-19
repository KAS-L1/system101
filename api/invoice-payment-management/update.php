<?php
require("../../app/init.php");

// Escape and sanitize the input data
$data = array(
    "po_id" => $DB->ESCAPE($_POST['po_id']),
    "amount" => $DB->ESCAPE($_POST['amount']),
    "payment_terms" => $DB->ESCAPE($_POST['payment_terms']),
    "payment_status" => $DB->ESCAPE($_POST['payment_status']),
    "due_date" => $DB->ESCAPE($_POST['due_date']),
    "remarks" => $DB->ESCAPE($_POST['remarks'])
);

// Get the Invoice ID from the form
$invoice_id = $DB->ESCAPE($_POST['invoice_id']);

// Define where clause for updating the specific Invoice
$where = array("invoice_id" => $invoice_id);

// Update the Invoice in the database
$updateInvoice = $DB->UPDATE("invoice_payments", $data, $where);

// Check if the update is successful
if ($updateInvoice == "success") {
    swalAlert("success", "Invoice successfully updated");
    refreshUrlTimeout(2000);
} else {
    swalAlert("error", "Failed to update invoice");
}
