<?php
require("../../app/init.php");
require_once '../tcpdf/vendor/autoload.php';

if (isset($_POST['po_id'])) {
    $po_id = $_POST['po_id'];

    // Query to get Purchase Order details using prepared statements
    $order = $DB->SELECT("purchaseorder", "*", "WHERE po_id = ?", [$po_id]);

    if ($order) {
        $order = $order[0]; // Fetch the first result

        // Modal content
        echo "
        <div class='modal fade' id='viewOrderModal' tabindex='-1' aria-labelledby='viewOrderModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-lg modal-dialog-centered'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title'>Purchase Order Details (ID: {$order['po_id']})</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body text-start'>  <!-- Added text-start class for left alignment -->
                        <p><strong>Vendor Name:</strong> " . htmlspecialchars($order['vendor_name']) . "</p>
                        <p><strong>Items:</strong> " . htmlspecialchars($order['items']) . "</p>
                        <p><strong>Quantity:</strong> " . htmlspecialchars($order['quantity']) . "</p>
                        <p><strong>Unit Price:</strong> " . NUMBER_PHP_2($order['unit_price']) . "</p>
                        <p><strong>Total Cost:</strong> " . NUMBER_PHP_2($order['total_cost']) . "</p>
                        <p><strong>Order Date:</strong> " . htmlspecialchars($order['order_date']) . "</p>
                        <p><strong>Delivery Date:</strong> " . (!empty($order['delivery_date']) ? htmlspecialchars($order['delivery_date']) : 'No date available') . "</p>
                        <p><strong>Status:</strong> " . htmlspecialchars($order['status']) . "</p>
                        <p><strong>Remarks:</strong> " . htmlspecialchars($order['remarks']) . "</p>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                    </div>
                </div>
            </div>
        </div>";
    } else {
        echo '<div class="alert alert-danger">Purchase Order not found.</div>';
    }
} else {
    echo '<div class="alert alert-warning">No Purchase Order ID provided.</div>';
}
?>
