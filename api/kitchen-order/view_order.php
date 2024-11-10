<?php
include_once('../../app/init.php');
$order_id = $_POST['order_id'];
$order = $DB->SELECT("kitchen_orders", "*", "WHERE order_id = $order_id")[0];

echo "
<div class='modal fade' id='viewOrderModal' tabindex='-1' aria-labelledby='viewOrderModalLabel' aria-hidden='true'>
    <div class='modal-dialog modal-lg modal-dialog-centered'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='viewOrderModalLabel'>Order Details</h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class='modal-body'>
                <p><strong>Guest Name:</strong> {$order['guest_name']}</p>
                <p><strong>Room Number:</strong> {$order['room_number']}</p>
                <p><strong>Order Items:</strong> {$order['order_items']}</p>
                <p><strong>Special Requests:</strong> {$order['special_requests']}</p>
                <p><strong>Status:</strong> {$order['order_status']}</p>
                <p><strong>Preparation Start Time:</strong> {$order['preparation_start_time']}</p>
                <p><strong>Completion Time:</strong> {$order['completion_time']}</p>
                <p><strong>Delivery Time:</strong> {$order['delivery_time']}</p>
                <p><strong>Cancellation Reason:</strong> {$order['cancellation_reason']}</p>
            </div>
        </div>
    </div>
</div>";
