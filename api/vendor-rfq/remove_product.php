<?php
require("../../app/init.php");

$product_id = $_POST['product_id'];

$where = ["product_id" => $product_id];
$deleteProduct = $DB->DELETE("vendor_products", $where);

if ($deleteProduct) {
    swalAlert("Product removed successfully.");
} else {
    swalAlert("Failed to remove product.");
}
