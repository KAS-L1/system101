<?php
include_once('../../app/init.php');

$stock_id = $_POST['stock_id'];
$item_name = $_POST['item_name'];
$category = $_POST['category'];
$supplier = $_POST['supplier'];
$unit_price = $_POST['unit_price'];
$reorder_level = $_POST['reorder_level'];
$current_stock_level = $_POST['current_stock_level'];
$expiration_date = $_POST['expiration_date'] ?? null;

$data = [
    "item_name" => $item_name,
    "category" => $category,
    "supplier" => $supplier,
    "unit_price" => $unit_price,
    "reorder_level" => $reorder_level,
    "current_stock_level" => $current_stock_level,
    "expiration_date" => $expiration_date
];
$where = ["stock_id" => $stock_id];

$update = $DB->UPDATE("stock_items", $data, $where);
if ($update === "success") {
    swalAlert('success', 'Stock item updated successfully');
    refreshUrlTimeout(2000);
} else {
    swalAlert('success', 'Failed to update stock item');
}
