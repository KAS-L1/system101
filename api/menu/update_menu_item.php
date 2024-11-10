<?php
require("../../app/init.php");

$item_id = $_POST['item_id'];
$data = array(
    "item_name" => $_POST['item_name'],
    "category" => $_POST['category'],
    "description" => $_POST['description'],
    "price" => $_POST['price'],
    "availability" => isset($_POST['availability']) ? 1 : 0,
    "seasonal" => isset($_POST['seasonal']) ? 1 : 0,
    "event_specific" => isset($_POST['event_specific']) ? 1 : 0,
);

$where = array("item_id" => $item_id);
$update = $DB->UPDATE("menu_items", $data, $where);
if ($update == "success") {
    swalAlert('success', 'Item updated successfully.');
    refreshUrlTimeout(2000);
} else {
    swalAlert('error', 'Failed to update item.');
}
