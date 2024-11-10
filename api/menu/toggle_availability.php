<?php
include_once('../../app/init.php');

$item_id = $_POST['item_id'];
$availability = $_POST['availability'];

// Ensure $availability is either 1 (Yes) or 0 (No)
$data = ["availability" => $availability];
$where = ["item_id" => $item_id];

// Execute update and check the result
$update = $DB->UPDATE("menu_items", $data, $where);
if ($update === "success") {
    echo json_encode(["success" => true, "message" => "Availability updated successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update availability."]);
}
