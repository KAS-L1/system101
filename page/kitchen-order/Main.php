<?php
include_once('api/middleware/role_access_kitchen.php');

// Retrieve all kitchen orders from the `kitchen_orders` table
$kitchenOrders = $DB->SELECT("kitchen_orders", "*", "ORDER BY order_id DESC");
?>

<div class="container mt-5">
    <div class="row g-4">
        <div class="container mt-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light text-success d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Kitchen Order Management</h5>
                    <button class="btn btn-sm btn-success" onclick="window.open('api/kitchen-order/generate_report.php', '_blank')">
                        <i class="fas fa-download"></i> Generate Report
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="kitchenOrderTable" class="table table-bordered table-hover table-sm mb-0 shadow-sm">
                            <thead class="table-success">
                                <tr>
                                    <th>#</th>
                                    <th>Order ID</th>
                                    <th>Guest Name</th>
                                    <th>Room Number</th>
                                    <th>Items</th>
                                    <th>Status</th>
                                    <th>Special Requests</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($kitchenOrders as $order) {
                                ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= htmlspecialchars($order['order_id']); ?></td>
                                        <td><?= htmlspecialchars($order['guest_name']); ?></td>
                                        <td><?= htmlspecialchars($order['room_number']); ?></td>
                                        <td><?= htmlspecialchars($order['order_items']); ?></td>
                                        <td>
                                            <?php if ($order['order_status'] == 'Pending') : ?>
                                                <span class="badge bg-secondary"><?= htmlspecialchars($order['order_status']); ?></span>
                                            <?php elseif ($order['order_status'] == 'Preparing') : ?>
                                                <span class="badge bg-warning"><?= htmlspecialchars($order['order_status']); ?></span>
                                            <?php elseif ($order['order_status'] == 'Ready') : ?>
                                                <span class="badge bg-primary"><?= htmlspecialchars($order['order_status']); ?></span>
                                            <?php elseif ($order['order_status'] == 'Delivered') : ?>
                                                <span class="badge bg-success"><?= htmlspecialchars($order['order_status']); ?></span>
                                            <?php elseif ($order['order_status'] == 'Cancelled') : ?>
                                                <span class="badge bg-danger"><?= htmlspecialchars($order['order_status']); ?></span>
                                            <?php else : ?>
                                                <span class="badge bg-dark"><?= htmlspecialchars($order['order_status']); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($order['special_requests']); ?></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <!-- View Order Button -->
                                                <button class="btn btn-sm btn-light shadow-sm viewDetails" data-order_id="<?= $order['order_id']; ?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <!-- Edit Order Button -->
                                                <button class="btn btn-sm btn-light shadow-sm editOrder" data-order_id="<?= $order['order_id']; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <?php if ($order['order_status'] == 'Pending'): ?>
                                                    <!-- Start Order Button -->
                                                    <button class="btn btn-sm btn-success shadow-sm startPreparing" data-order_id="<?= $order['order_id']; ?>">
                                                        <i class="fas fa-play"></i>
                                                    </button>
                                                <?php elseif ($order['order_status'] == 'Preparing'): ?>
                                                    <!-- Mark as Ready Button -->
                                                    <button class="btn btn-sm btn-warning shadow-sm markReady" data-order_id="<?= $order['order_id']; ?>">
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                <?php elseif ($order['order_status'] == 'Ready'): ?>
                                                    <!-- Deliver Order Button -->
                                                    <button class="btn btn-sm btn-primary shadow-sm deliverOrder" data-order_id="<?= $order['order_id']; ?>">
                                                        <i class="fas fa-truck"></i>
                                                    </button>
                                                <?php endif; ?>
                                                <!-- Cancel Order Button -->
                                                <button class="btn btn-sm btn-danger shadow-sm cancelOrder" data-order_id="<?= $order['order_id']; ?>">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="responseModal"></div>
        </div>
    </div>
</div>

<script>
    // View Order Details
    $('.viewDetails').click(function() {
        const order_id = $(this).data('order_id');
        $.post('api/kitchen-order/view_order.php', {
            order_id
        }, function(response) {
            $('#responseModal').html(response);
            $('#viewOrderModal').modal('show');
        });
    });

    // Edit Order
    $('.editOrder').click(function() {
        const order_id = $(this).data('order_id');
        $.post('api/kitchen-order/edit_order.php', {
            order_id
        }, function(response) {
            $('#responseModal').html(response);
            $('#editOrderModal').modal('show');
        });
    });

    // Start Preparing Order
    $('.startPreparing').click(function() {
        const order_id = $(this).data('order_id');
        $.post('api/kitchen-order/start_preparing.php', {
            order_id
        }, function(response) {
            $('#responseModal').html(response);
        });
    });

    // Mark Order as Ready
    $('.markReady').click(function() {
        const order_id = $(this).data('order_id');
        $.post('api/kitchen-order/mark_ready.php', {
            order_id
        }, function(response) {
            $('#responseModal').html(response);
        });
    });

    // Deliver Order
    $('.deliverOrder').click(function() {
        const order_id = $(this).data('order_id');
        $.post('api/kitchen-order/deliver.php', {
            order_id
        }, function(response) {
            $('#responseModal').html(response);
        });
    });

    // Cancel Order
    $('.cancelOrder').click(function() {
        const order_id = $(this).data('order_id');
        $.post('api/kitchen-order/cancel_order.php', {
            order_id
        }, function(response) {
            $('#responseModal').html(response);
        });
    });
</script>