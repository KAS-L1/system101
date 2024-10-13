<?php
require("../../app/init.php");

// Sanitize and escape the input data
$data = array(
    "vendor_id" => $DB->ESCAPE($_POST['vendor_id']), // Ensure vendor_id is an integer
    "product_name" => $DB->ESCAPE($_POST['product_name']),
    "description" => $DB->ESCAPE($_POST['description']),
    "unit_price" => $DB->ESCAPE($_POST['unit_price']), // Ensure unit_price is a float
    "availability" => $DB->ESCAPE($_POST['availability']),
);


// Insert the product into the database
$product = $DB->INSERT("vendor_products", $data);


if ($product) {
    // Display success alert and refresh the page
    swalAlert('success', 'Product Created Successfully');
    refreshUrlTimeout(2000);
} else {
    // Display error alert if something goes wrong
    swalAlert('error', 'Failed to Create Product');
}
