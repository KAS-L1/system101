<?php
require("../../app/init.php");

$order_id = $_POST['order_id'];
$data = array(
    "order_status" => "Delivered",
    "delivery_time" => date("Y-m-d H:i:s")
);

$where = array("order_id" => $order_id); // Use an associative array for the WHERE condition
$update = $DB->UPDATE("kitchen_orders", $data, $where);

if ($update == "success") {
    swalAlert('success', 'Order delivered successfully!');
    refreshUrlTimeout(2000);
} else {
    swalAlert('error', 'Failed to mark order as delivered.');
}
