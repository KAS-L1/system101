<?php
include_once('api/middleware/role_access_vendor.php');
// Retrieve all Purchase Orders from the `purchaseorder` table
$purchaseOrders = $DB->SELECT("purchaseorder", "*", "ORDER BY po_id DESC");
?>

<!-- Purchase Order Section -->
<!-- Container for Page Content -->
<div class="container mt-5">
    <!-- Row for Cards -->
    <div class="row g-4">
        <!-- Purchase Orders Table -->
        <div class="container mt-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light text-success d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-start">Delivery and Shippment Updates</h5>
                    <!-- Download Report Button next to the Search bar -->
                    <!-- <div>
                        <button class="btn btn-sm btn-success" onclick="window.open('/api/purchase/generate_report.php', '_blank')">
                            <i class="bi bi-download"></i>
                        </button>
                    </div> -->
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable1" class="table table-bordered table-hover table-sm mb-0 shadow-sm table-nowrap">
                            <thead class="table-success">
                                <tr>
                                    <th>#</th>
                                    <th>PO ID</th>
                                    <th>Items</th>
                                    <th>Quantity</th>
                                    <th>Delivery Method</th>
                                    <th>Status</th>
                                    <th>Delivery Date</th>
                                    <th>Tracking Link</th>
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
                                        <td><?= CHARS($order['items']); ?></td>
                                        <td><?= CHARS($order['quantity']); ?></td>
                                        <td><?= CHARS($order['delivery_method']); ?></td>
                                        <td>
                                            <?php if ($order['status'] == 'Delivered') { ?>
                                                <span class="badge bg-success">Delivered</span>
                                            <?php } elseif ($order['status'] == 'Cancelled') { ?>
                                                <span class="badge bg-danger">Cancelled</span>
                                            <?php } elseif ($order['status'] == 'Shipped') { ?>
                                                <span class="badge bg-success">Shipped</span>
                                            <?php } elseif ($order['status'] == 'In_transit') { ?>
                                                <span class="badge bg-secondary">In Transit</span>
                                            <?php } else { ?>
                                                <span class="badge bg-secondary">Ordered</span>
                                            <?php } ?>
                                        </td>
                                        <td><?= !empty($order['delivery_date']) ? htmlspecialchars($order['delivery_date']) : 'No date available'; ?></td>
                                        <td><?= CHARS($order['tracking_link']); ?></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <!-- Edit Button -->
                                                <button class="btn btn-sm btn-light shadow-sm editOrder" data-po_id="<?= $order['po_id']; ?>">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>

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

                $(document).on('click', '.viewOrder', function() {
                    const po_id = $(this).data('po_id');
                    $.post('api/purchase/view_purchase_order_modal.php', {
                            po_id: po_id
                        })
                        .done(function(res) {
                            $('#responseModal').html(res);
                            $('#viewOrderModal').modal('show'); // Correct ID here
                        })
                        .fail(function() {
                            alert("An error occurred while fetching the data. Please try again.");
                        });
                });


                // Handle Generate Report button click
                $('.generateOrderReport').click(function() {
                    const po_id = $(this).data('po_id');

                    Swal.fire({
                        title: "Generate Report?",
                        text: "This will generate a PDF report for the selected Order.",
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonText: "Generate Report",
                        confirmButtonColor: '#198754',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.open('api/purchase/generate_report_order.php?po_id=' + po_id, '_blank');
                        }
                    });
                });

                $('#btnAddPurchaseOrder').click(function() {
                    $.post('api/purchase/create_modal.php', function(res) {
                        $('#responseModal').html(res);
                        $('#addPurchaseOrderModal').modal('show');
                    });
                });

                // Edit Purchase Order Button Click Event
                $('.editOrder').click(function() {
                    const po_id = $(this).data('po_id');
                    $.post('api/purchase/vendor_edit_modal.php', {
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