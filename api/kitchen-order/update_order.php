<?php
require("../../app/init.php");

$order_id = $_POST['order_id'];
$data = array(
    "guest_name" => $DB->ESCAPE($_POST['guest_name']),
    "room_number" => $DB->ESCAPE($_POST['room_number']),
    "order_items" => $DB->ESCAPE($_POST['order_items']),
    "special_requests" => $DB->ESCAPE($_POST['special_requests'])
);

$where = array("order_id" => $order_id); // Define where condition as an array
$update = $DB->UPDATE("kitchen_orders", $data, $where);

if ($update == "success") {
    swalAlert('success', 'Order updated successfully!');
    refreshUrlTimeout(2000);
} else {
    swalAlert('error', 'Failed to update order.');
}
