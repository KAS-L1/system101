<?php
include_once('../../app/init.php');

$order_id = $_POST['order_id'];
$cancellation_reason = $_POST['cancellation_reason'] ?? 'No reason provided';

// Data to update
$data = array(
    "order_status" => "Cancelled",
    "cancellation_reason" => $cancellation_reason
);

// Use an associative array for the WHERE condition
$where = array("order_id" => $order_id);

// Perform the update
$update = $DB->UPDATE("kitchen_orders", $data, $where);

if ($update == "success") {
    swalAlert('success', 'Order canceled successfully.');
    refreshUrlTimeout(2000);
} else {
    swalAlert('error', 'Failed to update order status.');
}
