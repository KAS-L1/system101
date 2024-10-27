    <?php
    include_once('api/middleware/role_access_vendor.php');

    // Retrieve all RFQs from the `rfqs` table


    if (AUTH_USER['role'] == "ADMIN") {
        $vendors = $DB->SELECT("vendors", "*");
        $products = $DB->SELECT("vendor_products", "*");
        $rfqs = $DB->SELECT("rfqs", "*", "ORDER BY response_date DESC");
    } elseif (AUTH_USER['role'] == "VENDOR") {
        $where = array("vendor_id" => AUTH_USER_ID);
        $rfqs = $DB->SELECT_WHERE("rfqs", "*", $where, "ORDER BY response_date DESC");
    }



    ?>

    <!-- Container for Page Content -->
    <div class="container mt-5">
        <!-- Row for Cards -->
        <div class="row g-4">
            <!-- RFQ Management Table Card -->
            <div class="container mt-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light text-success d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">RFQ Management and Status</h5>
                        <!-- Download Report Button next to the Search bar -->
                        <div>
                            <button class="btn btn-sm btn-success" onclick="window.open('/api/vendor-rfq/generateall_report_rfq.php', '_blank')">
                                <i class="bi bi-download"></i>
                            </button>
                        </div>
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
                                        <th>Remarks</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($rfqs as $rfq) {
                                        // Selecting vendor name
                                        $vendor_name = $DB->SELECT_ONE_WHERE("vendors", "vendor_name", array("vendor_id" => $rfq['vendor_id']));
                                        $vendorName = CHARS(isset($vendor_name['vendor_name']) ? $vendor_name['vendor_name'] : 'Unknown Vendor');

                                        // Selecting product name
                                        $product_name = $DB->SELECT_ONE_WHERE("vendor_products", "product_name", array("product_id" => $rfq['product_id']));
                                        $productName = CHARS(isset($product_name['product_name']) ? $product_name['product_name'] : 'Unknown Product');
                                    ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo CHARS($rfq['rfq_id']); ?></td>
                                            <td><?php echo $vendorName; ?></td>
                                            <td><?php echo $productName; ?></td>
                                            <td><?php echo CHARS($rfq['requested_quantity']); ?></td>
                                            <td><?php echo NUMBER_PHP_2($rfq['quoted_price']); ?></td>
                                            <td>
                                                <?php if ($rfq['rfq_status'] == 'Approved'): ?>
                                                    <span class="badge bg-success"><?= $rfq['rfq_status']; ?></span>
                                                <?php elseif ($rfq['rfq_status'] == 'Rejected'): ?>
                                                    <span class="badge bg-danger"><?= $rfq['rfq_status']; ?></span>
                                                <?php elseif ($rfq['rfq_status'] == 'Responded'): ?>
                                                    <span class="badge bg-info"><?= $rfq['rfq_status']; ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary"><?= $rfq['rfq_status']; ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo CHARS($rfq['response_date']); ?></td>
                                            <td><?php echo CHARS($rfq['remarks']); ?></td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <!-- Edit RFQ Button -->
                                                    <button class="btn btn-sm btn-light shadow-sm editRFQ" data-rfq_id="<?php echo CHARS($rfq['rfq_id']); ?>">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <!-- View RFQ Button -->
                                                    <button class="btn btn-sm btn-light shadow-sm viewRFQ" data-rfq_id="<?= $rfq['rfq_id']; ?>">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <!-- Generate Report Button -->
                                                    <button class="btn btn-sm btn-light shadow-sm generateReport text-success" data-rfq_id="<?= $rfq['rfq_id']; ?>">
                                                        <i class="bi bi-file-earmark-text"></i>
                                                    </button>
                                                    <!-- Responded RFQ Button -->
                                                    <button class="btn btn-sm btn-light shadow-sm respondedRFQ text-info" data-rfq_id="<?= $rfq['rfq_id']; ?>">
                                                        <i class="bi bi-reply-fill"></i>
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
            </div>

            <!-- Modal Container for Dynamic Modals -->
            <div id="responseModal"></div>
            <div id="response"></div>

            <!-- JavaScript for Handling Modals and AJAX Requests -->
            <script>
                // RFQ Modals and Actions

                // Handle View RFQ button click

                $('.viewRFQ').click(function() {
                    const rfq_id = $(this).data('rfq_id');
                    $.post('api/vendor-rfq/view_rfq_modal.php', {
                        rfq_id: rfq_id
                    }, function(res) {
                        $('#responseModal').html(res);
                        $('#viewRFQModal').modal('show');
                    });
                });

                // Handle Generate Report button click
                $('.generateReport').click(function() {
                    const rfq_id = $(this).data('rfq_id');

                    Swal.fire({
                        title: "Generate Report?",
                        text: "This will generate a PDF report for the selected RFQ.",
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonText: "Generate Report",
                        confirmButtonColor: '#198754',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.open('api/vendor-rfq/generate_report_rfq.php?rfq_id=' + rfq_id, '_blank');
                        }
                    });
                });

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
                $('.respondedRFQ').click(function() {
                    const rfq_id = $(this).data('rfq_id');
                    $.post('api/vendor-rfq/responded_rfq.php', {
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
        </div>
    </div>