<?php
require("../../app/init.php");

$order_id = $_POST['order_id'];
$start_time = date("Y-m-d H:i:s");

$data = array(
    "order_status" => "Preparing",
    "preparation_start_time" => $start_time
);
$where = array("order_id" => $order_id); // Use an associative array for the WHERE condition
$update = $DB->UPDATE("kitchen_orders", $data, $where);

if ($update == "success") {
    swalAlert('success', 'Order status updated to Preparing!');
    refreshUrlTimeout(2000);
} else {
    swalAlert('error', 'Failed to update order status.');
}
