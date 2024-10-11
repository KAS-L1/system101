<?php
require("../../app/init.php");

// Sanitize and escape the input data
$data = array(
    "vendor_name" => $DB->ESCAPE($_POST['vendor_name']),
    "contact_info" => $DB->ESCAPE($_POST['contact_info']),
    "vendor_rating" => floatval($DB->ESCAPE($_POST['vendor_rating'])), // Ensure vendor_rating is a float
    "preferred_status" => $DB->ESCAPE($_POST['preferred_status']),
    "contract_status" => $DB->ESCAPE($_POST['contract_status']),
);

pre_die($vendor);

// Insert the vendor into the database
$vendor = $DB->INSERT("vendors", $data);

if ($vendor) {
    // Display success alert and refresh the page
    swalAlert('success', 'Vendor Created Successfully');
    refreshUrlTimeout(2000);
} else {
    // Display error alert if something goes wrong
    swalAlert('error', 'Failed to Create Vendor');
}
?>