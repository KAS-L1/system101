<?php
include_once('../../app/init.php');

$item_name = $_POST['item_name'];
$category = $_POST['category'];
$supplier = $_POST['supplier'];
$unit_price = $_POST['unit_price'];
$reorder_level = $_POST['reorder_level'];
$current_stock_level = $_POST['current_stock_level'];
$expiration_date = $_POST['expiration_date'] ?? null; // Optional for non-perishable items

$data = [
    "item_name" => $item_name,
    "category" => $category,
    "supplier" => $supplier,
    "unit_price" => $unit_price,
    "reorder_level" => $reorder_level,
    "current_stock_level" => $current_stock_level,
    "expiration_date" => $expiration_date
];

$insert = $DB->INSERT("stock_items", $data);
if ($insert === "success") {
    swalAlert('success', 'Stock item added successfully');
    refreshUrlTimeout(2000);
} else {
    swalAlert('error', 'Failed to add stock item');
}
