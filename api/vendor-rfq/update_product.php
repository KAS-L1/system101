<?php
require("../../app/init.php");

$product_id = $_POST['product_id'];
$data = [
    "product_name" => $DB->ESCAPE($_POST['product_name']),
    "description" => $DB->ESCAPE($_POST['description']),
    "unit_price" => floatval($_POST['unit_price']),
    "availability" => intval($_POST['availability']),
];

$where = ["product_id" => $product_id];
$updateProduct = $DB->UPDATE("vendor_products", $data, $where);

if ($updateProduct) {
    swalAlert("Product updated successfully.");
} else {
    swalAlert("Failed to update product.");
}
