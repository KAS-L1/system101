<?php
// Include the database initialization file
require_once '../../app/init.php';

// Retrieve the order ID from the request
$order_id = $_POST['order_id'] ?? null;
if (!$order_id) {
    echo "Order ID is missing.";
    exit;
}

$order = $DB->SELECT_ONE_WHERE("kitchen_orders", "*", ["order_id" => $order_id]);
if (!$order) {
    echo "Order not found.";
    exit;
}
?>

<!-- Edit Kitchen Order Modal -->
<div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOrderModalLabel">Edit Kitchen Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Edit Order Form -->
                <form id="formEditOrder">
                    <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['order_id']) ?>">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="guest_name" class="form-label">Guest Name</label>
                            <input type="text" id="guest_name" name="guest_name" class="form-control" value="<?= htmlspecialchars($order['guest_name']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="room_number" class="form-label">Room Number</label>
                            <input type="number" id="room_number" name="room_number" class="form-control" value="<?= htmlspecialchars($order['room_number']) ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="order_items" class="form-label">Order Items</label>
                            <textarea id="order_items" name="order_items" class="form-control" rows="3" required><?= htmlspecialchars($order['order_items']) ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="special_requests" class="form-label">Special Requests</label>
                            <textarea id="special_requests" name="special_requests" class="form-control" rows="3"><?= htmlspecialchars($order['special_requests']) ?></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="responseModal"></div>

<script>
    // Handle Edit Order Form Submission
    $('#formEditOrder').submit(function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.post("api/kitchen-order/update_order.php", formData, function(response) {
            $('#responseModal').html(response);
            $('#editOrderModal').modal('hide'); // Hide modal after submission
        });
    });
</script>