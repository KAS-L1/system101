<?php
require("../../app/init.php");

// Sanitize and escape the input data
$data = array(
    "rfq_id" => rand(),
    "vendor_id" => $DB->ESCAPE($_POST['vendor_id']), // Ensure vendor_id is an integer
    "product_id" => $DB->ESCAPE($_POST['product_id']), // Ensure product_id is an integer
    "requested_quantity" => $DB->ESCAPE($_POST['requested_quantity']), // Ensure requested_quantity is an integer
    "quoted_price" => isset($_POST['quoted_price']) && !empty($_POST['quoted_price']) 
        ? $DB->ESCAPE($_POST['quoted_price']) 
        : 0, // Set to 0 if not provided
    "rfq_status" => $DB->ESCAPE($_POST['rfq_status']),
    "response_date" => $DB->ESCAPE($_POST['response_date']), // Assumes the response date is a datetime string
    "remarks" => $DB->ESCAPE($_POST['response_remarks']),
);

// Insert the RFQ into the database
$rfq = $DB->INSERT("rfqs", $data);

if ($rfq == "success") {
    // Display success alert and refresh the page
    swalAlert('success', 'RFQ Created Successfully');
    refreshUrlTimeout(2000);
} else {
    // Display error alert if something goes wrong
    swalAlert('error', 'Failed to Create RFQ');
}
