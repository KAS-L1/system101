<?php
require("../../app/init.php");

$product_id = $_POST['product_id'];

$where = ["product_id" => $product_id];
$deleteProduct = $DB->DELETE("vendor_products", $where);

if ($deleteProduct) {
    swalAlert("success", "Product removed successfully.");
    refreshUrlTimeout(2000);
} else {
    swalAlert("error", "Failed to remove product.");
}
