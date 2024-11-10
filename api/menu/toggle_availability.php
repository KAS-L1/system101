<?php
include_once('../../app/init.php');

$item_id = $_POST['item_id'];
$availability = $_POST['availability'];

// Ensure $availability is either 1 (Yes) or 0 (No)
$data = ["availability" => $availability];
$where = ["item_id" => $item_id];

$update = $DB->UPDATE("menu_items", $data, $where);
if ($update === "success") {
    echo json_encode(["status" => "success", "message" => "Availability updated successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update availability."]);
}
