<?php
include_once('../../app/init.php');

// Validate stock ID and restock quantity
$stock_id = isset($_POST['stock_id']) ? (int) $_POST['stock_id'] : 0;
$restock_quantity = isset($_POST['restock_quantity']) ? (int) $_POST['restock_quantity'] : 0;

if ($stock_id <= 0 || $restock_quantity <= 0) {
    echo json_encode(["status" => "error", "message" => "Invalid stock ID or restock quantity."]);
    exit;
}

// Fetch current stock level
$stockData = $DB->SELECT_ONE("stock_items", "*", ["stock_id" => $stock_id]);

// Check if the item exists and has the correct structure
if (!$stockData || !isset($stockData['current_stock_level'])) {
    echo json_encode(["status" => "error", "message" => "Stock item not found or invalid data structure."]);
    exit;
}

$current_stock = (int) $stockData['current_stock_level'];
$new_stock_level = $current_stock + $restock_quantity;

$data = [
    "current_stock_level" => $new_stock_level,
    "last_restocked_date" => date("Y-m-d")
];

$where = ["stock_id" => $stock_id];

// Update stock item
$update = $DB->UPDATE("stock_items", $data, $where);

if ($update === "success") {
    swalAlert('success', "Stock item restocked successfully.");
    refreshUrlTimeout(2000);
} else {
    swalAlert('error', "Failed to restock item.");
}
