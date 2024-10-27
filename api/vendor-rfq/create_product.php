<?php
require("../../app/init.php");
require("../auth/auth.php");

// Fetch vendor details using the provided vendor_id
$where = array("user_id" => $_POST['vendor_id']);
$vendor = $DB->SELECT_ONE_WHERE("users", "*", $where);

// Sanitize and escape the input data
$data = array(
    "product_id" => rand(), // Replace with a proper unique identifier generation method if necessary
    "vendor_id" => $DB->ESCAPE($_POST['vendor_id']),
    "category_id" => $DB->ESCAPE($_POST['category_id']),
    // "vendor_name" => $DB->ESCAPE($vendor['vendor_name']),
    "product_name" => $DB->ESCAPE($_POST['product_name']),
    "description" => $DB->ESCAPE($_POST['description']),
    "unit_price" => $DB->ESCAPE($_POST['unit_price']),
    "availability" => $DB->ESCAPE($_POST['availability']),
);

// Insert the product into the database
$product = $DB->INSERT("vendor_products", $data);

if ($product == "success") {
    // Display success alert and refresh the page
    swalAlert('success', 'Product Created Successfully');
    refreshUrlTimeout(2000);
} else {
    // Display error alert if something goes wrong
    swalAlert('error', 'Failed to Create Product');
    echo $product['error']; // Display any specific error returned from the database
}
