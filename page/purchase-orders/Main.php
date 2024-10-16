<?php
include_once('api/middleware/role_access.php');
// Retrieve all Purchase Orders from the `purchaseorder` table
$purchaseOrders = $DB->SELECT("purchaseorder", "*", "ORDER BY po_id DESC");
?>

<!-- Purchase Order Section -->
<div class="container mt-4 py-5">
    <div class="row text-center">
        <!-- Card: Add Purchase Order -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x text-success mb-3"></i>
                    <h6 class="card-title">Create Purchase Order</h6>
                    <p class="card-text text-muted small">Create a new purchase order for the approved requisition.</p>
                    <button id="btnAddPurchaseOrder" class="btn btn-sm btn-success" data-bs-toggle="modal"
                        data-bs-target="#addPurchaseOrderModal">Create PO</button>
                </div>
            </div>
        </div>

        <!-- Card: View Active Purchase Orders -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-eye fa-2x text-success mb-3"></i>
                    <h6 class="card-title">View Active Purchase Orders</h6>
                    <p class="card-text text-muted small">Monitor and manage active purchase orders.</p>
                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#viewPOModal">View
                        Purchase Orders</button>
                </div>
            </div>
        </div>

        <!-- Card: Generate Purchase Order Report -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-chart-bar fa-2x text-success mb-3"></i>
                    <h6 class="card-title">Generate Purchase Order Report</h6>
                    <p class="card-text text-muted small">Generate reports based on purchase order statuses and details.</p>
                    <button class="btn btn-sm btn-success" onclick="window.open('api/purchase/generate_report.php', '_blank')">Generate Report</button>

                </div>
            </div>
        </div>


        <!-- Modal: View Active Purchase Orders -->
        <div class="modal fade" id="viewPOModal" tabindex="-1" aria-labelledby="viewPOModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewPOModalLabel">Active Purchase Orders</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Active Purchase Orders Table -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="dataTable2" class="table table-hover table-sm shadow-sm">
                                        <thead class="table-success">
                                            <tr>
                                                <th>#</th>
                                                <th>PO ID</th>
                                                <th>Vendor Name</th>
                                                <th>Items</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Total Cost</th>
                                                <th>Order Date</th>
                                                <th>Delivery Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($purchaseOrders as $order) {
                                            ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= CHARS($order['po_id']); ?></td>
                                                    <td><?= CHARS($order['vendor_name']); ?></td>
                                                    <td><?= CHARS($order['items']); ?></td>
                                                    <td><?= CHARS($order['quantity']); ?></td>
                                                    <td><?= NUMBER_PHP_2($order['unit_price']); ?></td>
                                                    <td><?= NUMBER_PHP_2($order['total_cost']); ?></td>
                                                    <td><?= CHARS($order['order_date']); ?></td>
                                                    <td><?= !empty($order['delivery_date']) ? htmlspecialchars($order['delivery_date']) : 'No date available'; ?></td>
                                                    <td>
                                                        <?php if ($order['status'] == 'Delivered') { ?>
                                                            <span class="badge bg-success">Delivered</span>
                                                        <?php } elseif ($order['status'] == 'Cancelled') { ?>
                                                            <span class="badge bg-danger">Cancelled</span>
                                                        <?php } else { ?>
                                                            <span class="badge bg-secondary">Ordered</span>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Purchase Orders Table -->
        <div class="container mt-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light text-success">
                    <h5 class="mb-0 text-start">Purchase Order Management</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable1" class="table table-bordered table-hover table-sm mb-0 shadow-sm table-nowrap">
                            <thead class="table-success">
                                <tr>
                                    <th>#</th>
                                    <th>PO ID</th>
                                    <th>Vendor Name</th>
                                    <th>Items</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Cost</th>
                                    <th>Order Date</th>
                                    <th>Delivery Date</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($purchaseOrders as $order) {
                                ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= CHARS($order['po_id']); ?></td>
                                        <td><?= CHARS($order['vendor_name']); ?></td>
                                        <td><?= CHARS($order['items']); ?></td>
                                        <td><?= CHARS($order['quantity']); ?></td>
                                        <td><?= NUMBER_PHP_2($order['unit_price']); ?></td>
                                        <td><?= NUMBER_PHP_2($order['total_cost']); ?></td>
                                        <td><?= CHARS($order['order_date']); ?></td>
                                        <td><?= !empty($order['delivery_date']) ? htmlspecialchars($order['delivery_date']) : 'No date available'; ?></td>
                                        <td>
                                            <?php if ($order['status'] == 'Delivered') { ?>
                                                <span class="badge bg-success">Delivered</span>
                                            <?php } elseif ($order['status'] == 'Cancelled') { ?>
                                                <span class="badge bg-danger">Cancelled</span>
                                            <?php } else { ?>
                                                <span class="badge bg-secondary">Ordered</span>
                                            <?php } ?>
                                        </td>
                                        <td><?= CHARS($order['remarks']); ?></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <!-- Edit Button -->
                                                <button class="btn btn-sm btn-light shadow-sm editOrder" data-po_id="<?= $order['po_id']; ?>">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>

                                                <!-- Approve Button -->
                                                <?php if ($order['status'] == "Ordered") { ?>
                                                    <button class="btn btn-sm btn-success shadow-sm approveOrder" data-po_id="<?= $order['po_id']; ?>">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                <?php } else { ?>
                                                    <button class="btn btn-sm btn-success shadow-sm" disabled>
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                <?php } ?>

                                                <!-- Cancel Button -->
                                                <?php if ($order['status'] != "Cancelled") { ?>
                                                    <button class="btn btn-sm btn-danger shadow-sm cancelOrder" data-po_id="<?= $order['po_id']; ?>">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                <?php } else { ?>
                                                    <button class="btn btn-sm btn-danger shadow-sm" disabled>
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                <?php } ?>

                                                <!-- Sync to Vendor Button -->
                                                <button class="btn btn-sm btn-primary shadow-sm syncOrder" data-po_id="<?= $order['po_id']; ?>">
                                                    <i class="bi bi-upload"></i> Sync to Vendor
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

            <!-- Modal Container for Dynamic Modals -->
            <div id="responseModal"></div>
            <div id="response"></div>

            <!-- JavaScript for Handling Modals and AJAX Requests -->
            <script>
                // Create Purchase Order Button Click Event
                $('#btnAddPurchaseOrder').click(function() {
                    $.post('api/purchase/create_modal.php', function(res) {
                        $('#responseModal').html(res);
                        $('#addPurchaseOrderModal').modal('show');
                    });
                });

                // Edit Purchase Order Button Click Event
                $('.editOrder').click(function() {
                    const po_id = $(this).data('po_id');
                    $.post('api/purchase/edit_modal.php', {
                        po_id: po_id
                    }, function(res) {
                        $('#responseModal').html(res);
                        $('#editPOModal').modal('show');
                    });
                });

                // Cancel Purchase Order Button Click Event
                $('.cancelOrder').click(function() {
                    const po_id = $(this).data('po_id');
                    $.post('api/purchase/cancel.php', {
                        po_id: po_id
                    }, function(res) {
                        $('#response').html(res);
                    });
                });

                // Sync Purchase Order Button Click Event
                $('.syncOrder').click(function() {
                    const po_id = $(this).data('po_id');
                    $.post('api/purchase/sync_to_vendor.php', {
                        po_id: po_id
                    }, function(res) {
                        const response = JSON.parse(res);
                        const alertClass = response.status === 'Synced' ? 'alert-success' : 'alert-danger';
                        $('#response').html(`<div class="alert ${alertClass}">${response.message}</div>`);
                    });
                });

                // Approve Purchase Order Button Click Event
                $('.approveOrder').click(function() {
                    const po_id = $(this).data('po_id');
                    $.post('api/purchase/approve.php', {
                        po_id: po_id
                    }, function(res) {
                        $('#response').html(res);
                    });
                });
            </script>