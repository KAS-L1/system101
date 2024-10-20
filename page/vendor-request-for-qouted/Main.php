<?php
include_once('api/middleware/role_access_vendor.php');
// Retrieve all vendors from the `vendors` table
$vendors = $DB->SELECT("vendors", "*");

// Retrieve all products from the `vendor_products` table
$products = $DB->SELECT("vendor_products", "*");

// Retrieve all RFQs from the `rfqs` table
$rfqs = $DB->SELECT("rfqs", "*");
?>

<!-- Container for Page Content -->
<div class="container mt-5">
    <!-- Row for Cards -->
    <div class="row g-4">
        <!-- RFQ Management Card -->
        <!-- <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-file-signature fa-2x text-success mb-3"></i>
                    <h5 class="card-title">RFQ Management</h5>
                    <p class="card-text text-muted small">Create and manage Requests for Quotations (RFQs).</p>
                    <button id="openCreateRFQModalButton" class="btn btn-success">Create RFQ</button>
                </div>
            </div>
        </div> -->

        <!-- RFQ Management Table Card -->
        <div class="container mt-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light text-success">
                    <h5 class="mb-0">RFQ Management and Status</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable3" class="table table-bordered table-hover table-sm mb-0 shadow-sm">
                            <thead class="table-success">
                                <tr>
                                    <th>#</th>
                                    <th>RFQ ID</th>
                                    <th>Vendor Name</th>
                                    <th>Product Name</th>
                                    <th>Requested Quantity</th>
                                    <th>Quoted Price</th>
                                    <th>RFQ Status</th>
                                    <th>Response Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach ($rfqs as $rfq): ?>
                            <?php
                            // Selecting vendor name
                            $vendor_name = $DB->SELECT_ONE_WHERE("vendors", "vendor_name", array("vendor_id" => $rfq['vendor_id']));
                            $vendorName = CHARS($vendor_name['vendor_name'] ?? 'Unknown Vendor');

                            // Selecting product name
                            $product_name = $DB->SELECT_ONE_WHERE("vendor_products", "product_name", array("product_id" => $rfq['product_id']));
                            $productName = CHARS($product_name['product_name'] ?? 'Unknown Product');
                            ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= CHARS($rfq['rfq_id']); ?></td>
                                <td><?= $vendorName ?></td>
                                <td><?= $productName ?></td>
                                <td><?= CHARS($rfq['requested_quantity']); ?></td>
                                <td><?= NUMBER_PHP_2($rfq['quoted_price']); ?></td>
                                <td>
                                    <?php if ($rfq['rfq_status'] == 'Approved'): ?>
                                        <span class="badge bg-success"><?= CHARS($rfq['rfq_status']); ?></span>
                                    <?php elseif ($rfq['rfq_status'] == 'Rejected'): ?>
                                        <span class="badge bg-danger"><?= CHARS($rfq['rfq_status']); ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><?= CHARS($rfq['rfq_status']); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?= CHARS($rfq['response_date']); ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <!-- Edit RFQ Button -->
                                        <button class="btn btn-sm btn-light shadow-sm editRFQ" data-rfq_id="<?= CHARS($rfq['rfq_id']); ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Container for Dynamic Modals -->
        <div id="responseModal"></div>
        <div id="response"></div>

        <!-- JavaScript for Handling Modals and AJAX Requests -->
        <script>
            // RFQ Modals and Actions

            // Handle Create RFQ button click
            $('#openCreateRFQModalButton').click(function() {
                $.post('api/vendor-rfq/create_rfq_modal.php', function(res) {
                    $('#responseModal').html(res);
                    $('#createRFQModal').modal('show');
                });
            });

            $('.editRFQ').click(function() {
                const rfq_id = $(this).data('rfq_id');
                $.post('api/vendor-rfq/edit_rfq_modal.php', {
                    rfq_id: rfq_id
                }, function(res) {
                    $('#responseModal').html(res);
                    $('#editRFQModal').modal('show');
                });
            });

            // Handle Approve RFQ button click
            $('.approveRFQ').click(function() {
                const rfq_id = $(this).data('rfq_id');
                $.post('api/vendor-rfq/approve_rfq.php', {
                    rfq_id: rfq_id
                }, function(response) {
                    $('#responseModal').html(response);
                });
            });

            // Handle Reject RFQ button click
            $('.rejectRFQ').click(function() {
                const rfq_id = $(this).data('rfq_id');
                $.post('api/vendor-rfq/rfq_rejected.php', {
                    rfq_id: rfq_id
                }, function(response) {
                    $('#responseModal').html(response);
                });
            });

            // Remove RFQ
            $('.removeRFQ').click(function() {
                const rfq_id = $(this).data('rfq_id');

                Swal.fire({
                    title: "Are you sure you want to delete this RFQ?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Delete",
                    confirmButtonColor: '#198754', // Set the success color (green)
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed with deletion
                        $.post('api/vendor-rfq/remove_rfq.php', {
                            rfq_id: rfq_id
                        }, function(response) {
                            $('#responseModal').html(response);
                            // Call your custom swalAlert after successful deletion
                            swalAlert('success', 'RFQ has been deleted!');
                        }).fail(function() {
                            // Optional: Handle failure case
                            swalAlert('error', 'Failed to delete RFQ. Please try again.');
                        });
                    }
                });
            });
        </script>
