<?php
include_once('api/middleware/role_access.php');

// Retrieve all products from the `vendor_products` table
$products = $DB->SELECT("vendor_products", "*");

// Retrieve all RFQs from the `rfqs` table
$rfqs = $DB->SELECT("rfqs", "*", "ORDER BY response_date DESC");

?>

<!-- Container for Page Content -->
<div class="container mt-5">

    <!-- RFQ Management Card -->
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <i class="fas fa-file-signature fa-2x text-success mb-3"></i>
                <h5 class="card-title">RFQ Management</h5>
                <p class="card-text text-muted small">Create and manage Requests for Quotations (RFQs).</p>
                <button id="openCreateRFQModalButton" class="btn btn-success">Create RFQ</button>
            </div>
        </div>
    </div>
</div>

<!-- Product Catalog Management Table Card -->
<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light text-success d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Product Catalog Management</h5>
            <div>
                <button class="btn btn-sm btn-success" onclick="window.open('/api/vendor-rfq/generateall_report_product.php', '_blank')">
                    <i class="bi bi-download"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable2" class="table table-bordered table-hover table-sm mb-0 shadow-sm">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th>Product ID</th>
                            <th>Vendor Name</th>
                            <th>Category</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Unit Price</th>
                            <th>Availability</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($products as $product): ?>
                            <?php
                            // Fetch vendor name from `users` table
                            $vendor_name = $DB->SELECT_ONE_WHERE("users", "vendor_name", array("user_id" => $product['vendor_id']));
                            $vendorName = $vendor_name ? CHARS($vendor_name['vendor_name']) : 'Unknown Vendor';

                            // Fetch category name from `categories` table
                            $category = $DB->SELECT_ONE_WHERE("categories", "category_name", array("category_id" => $product['category_id']));
                            $categoryName = $category ? CHARS($category['category_name']) : 'Unknown Category';
                            ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $product['product_id']; ?></td>
                                <td><?= $vendorName; ?></td>
                                <td><?= $categoryName; ?></td>
                                <td><?= $product['product_name']; ?></td>
                                <td><?= $product['description']; ?></td>
                                <td><?= NUMBER_PHP_2($product['unit_price']); ?></td>
                                <td><?= $product['availability']; ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-light shadow-sm editProduct" data-product_id="<?= $product['product_id']; ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button class="btn btn-sm btn-light shadow-sm viewProduct" data-product_id="<?= $product['product_id']; ?>">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-light shadow-sm generateReportProduct text-success" data-product_id="<?= $product['product_id']; ?>">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning shadow-sm removeProduct" data-product_id="<?= $product['product_id']; ?>">
                                            <i class="bi bi-trash"></i>
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

<!-- RFQ Management Table Card -->
<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light text-success d-flex justify-content-between align-items-center">
            <h5 class="mb-0">RFQ Management and Status</h5>
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
                        <?php $i = 1;
                        foreach ($rfqs as $rfq): ?>
                            <?php
                            // Fetch vendor name from `users` table
                            $vendor_name = $DB->SELECT_ONE_WHERE("users", "vendor_name", array("user_id" => $rfq['vendor_id']));
                            $vendorName = $vendor_name ? CHARS($vendor_name['vendor_name']) : 'Unknown Vendor';

                            // Fetch product name from `vendor_products` table
                            $product_name_data = $DB->SELECT_ONE_WHERE("vendor_products", "product_name", array("product_id" => $rfq['product_id']));
                            $productName = $product_name_data ? CHARS($product_name_data['product_name']) : 'Unknown Product';
                            ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $rfq['rfq_id']; ?></td>
                                <td><?= $vendorName; ?></td>
                                <td><?= $productName; ?></td>
                                <td><?= $rfq['requested_quantity']; ?></td>
                                <td><?= NUMBER_PHP_2($rfq['quoted_price']); ?></td>
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
                                <td><?= $rfq['response_date']; ?></td>
                                <td><?= CHARS($rfq['remarks']); ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-light shadow-sm viewRFQ" data-rfq_id="<?= $rfq['rfq_id']; ?>">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-light shadow-sm generateReport text-success" data-rfq_id="<?= $rfq['rfq_id']; ?>">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </button>
                                        <button class="btn btn-sm btn-success shadow-sm approveRFQ" data-rfq_id="<?= $rfq['rfq_id']; ?>">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger shadow-sm rejectRFQ" data-rfq_id="<?= $rfq['rfq_id']; ?>">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning shadow-sm removeRFQ" data-rfq_id="<?= $rfq['rfq_id']; ?>">
                                            <i class="bi bi-trash"></i>
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
    // Vendor Modals and Actions

    $('.viewProduct').click(function() {
        const product_id = $(this).data('product_id');
        $.post('api/vendor-rfq/view_product_modal.php', {
            product_id: product_id
        }, function(res) {
            $('#responseModal').html(res);
            $('#viewProductModal').modal('show');
        });
    });

    // Handle Generate Report button click
    $('.generateReportProduct').click(function() {
        const product_id = $(this).data('product_id');

        Swal.fire({
            title: "Generate Report?",
            text: "This will generate a PDF report for the selected RFQ.",
            icon: "info",
            showCancelButton: true,
            confirmButtonText: "Generate Report",
            confirmButtonColor: '#198754',
        }).then((result) => {
            if (result.isConfirmed) {
                window.open('api/vendor-rfq/generate_report_product.php?product_id=' + product_id, '_blank');
            }
        });
    });

    $('#openCreateVendorModalButton').click(function() {
        $.post('api/vendor-rfq/create_vendor_modal.php', function(res) {
            $('#responseModal').html(res);
            $('#createVendorModal').modal('show');
        });
    });

    $('.btnEditVendor').click(function() {
        const vendor_id = $(this).data('vendor_id');
        $.post('api/vendor-rfq/edit_vendor_modal.php', {
            vendor_id: vendor_id
        }, function(res) {
            $('#responseModal').html(res);
            $('#editVendorModal').modal('show');
        });
    });

    // Remove Vendor
    $('.removeVendor').click(function() {
        const vendor_id = $(this).data('vendor_id');

        Swal.fire({
            title: "Are you sure you want to delete this vendor?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Delete",
            confirmButtonColor: '#198754', // Set the success color (green)
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with deletion
                $.post('api/vendor-rfq/remove_vendor.php', {
                    vendor_id: vendor_id
                }, function(response) {
                    $('#responseModal').html(response);
                    // Call your custom swalAlert after successful deletion
                    swalAlert('success', 'Vendor has been deleted!');
                }).fail(function() {
                    // Optional: Handle failure case
                    swalAlert('error', 'Failed to delete vendor. Please try again.');
                });
            }
        });
    });
</script>

<script>
    // Product Modals and Actions
    // Handle Create Product modal open action
    $('#CreateProductModalButton').click(function() {
        $.post('api/vendor-rfq/create_product_modal.php', function(res) {
            // Inject the modal content into the #responseModal container
            $('#responseModal').html(res);
            // Ensure that the modal's ID is correct in the response
            $('#createProductModal').modal('show');
        });
    });

    $('.editProduct').click(function() {
        const product_id = $(this).data('product_id');
        $.post('api/vendor-rfq/edit_product_modal.php', {
            product_id: product_id
        }, function(res) {
            $('#responseModal').html(res);
            $('#editProductModal').modal('show');
        });
    });

    // Remove Product
    $('.removeProduct').click(function() {
        const product_id = $(this).data('product_id');

        Swal.fire({
            title: "Are you sure you want to delete this product?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Delete",
            confirmButtonColor: '#198754', // Set the success color (green)
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with deletion
                $.post('api/vendor-rfq/remove_product.php', {
                    product_id: product_id
                }, function(response) {
                    $('#responseModal').html(response);
                    // Call your custom swalAlert after successful deletion
                    swalAlert('success', 'Product has been deleted!');
                }).fail(function() {
                    // Optional: Handle failure case
                    swalAlert('error', 'Failed to delete product. Please try again.');
                });
            }
        });
    });
</script>

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

    // Handle Create RF Q button click
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