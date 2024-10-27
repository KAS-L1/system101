<?php
require("../../app/init.php");
require("../auth/auth.php");


// Get vendor details
$where = array("user_id" => $_POST['vendor_id']);
$vendor = $DB->SELECT_ONE_WHERE("users", "*", $where);

// Prepare the data to be inserted into the RFQ table
$data = array(
    "rfq_id" => rand(), // Replace with a proper unique identifier generation method
    "vendor_id" => $DB->ESCAPE($_POST['vendor_id']),
    "product_id" => $DB->ESCAPE($_POST['product_id']),
    "requested_quantity" => $DB->ESCAPE($_POST['requested_quantity']),
    "quoted_price" => isset($_POST['quoted_price']) && !empty($_POST['quoted_price'])
        ? $DB->ESCAPE($_POST['quoted_price'])
        : 0,
    "rfq_status" => $DB->ESCAPE($_POST['rfq_status']),
    "response_date" => $DB->ESCAPE($_POST['response_date']),
    "remarks" => $DB->ESCAPE($_POST['response_remarks']),
);

// pre_die($data);
// Insert the RFQ into the database
$rfq = $DB->INSERT("rfqs", $data);

if ($rfq == "success") {
    // Display success alert and refresh the page
    swalAlert('success', 'RFQ Created Successfully');
    refreshUrlTimeout(2000);
} else {
    // Display error alert if something goes wrong
    swalAlert('error', 'Failed to Create RFQ');
    // echo $rfq['error'];
}
