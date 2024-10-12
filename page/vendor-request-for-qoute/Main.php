<?php

// Retrieve all vendors from the `vendors` table
$vendors = $DB->SELECT("vendors", "*");

// Retrieve all products from the `product_catalog` table
$products = $DB->SELECT("product_catalog", "*");

// Retrieve all RFQs from the `rfq` table
$rfqs = $DB->SELECT("rfq", "*");
?>

<!-- Container for Page Content -->
<div class="container mt-5">
    <!-- Row for Cards -->
    <div class="row g-4">
        <!-- Vendor Management Card -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-2x text-success mb-3"></i>
                    <h5 class="card-title">Vendor Management</h5>
                    <p class="card-text text-muted small">Manage vendors, contracts, and vendor ratings.</p>
                    <button id="openCreateVendorModalButton" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#createVendorModal">Create Vendor</button>
                </div>
            </div>
        </div>

        <!-- Product Catalog Management Card -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-boxes fa-2x text-success mb-3"></i>
                    <h5 class="card-title">Product Catalog Management</h5>
                    <p class="card-text text-muted small">Manage product catalog, descriptions, and prices.</p>
                    <button id="openCreateProductModalButton" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#createProductModal">Create
                        Product</button>
                </div>
            </div>
        </div>

        <!-- RFQ Management Card -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-file-signature fa-2x text-success mb-3"></i>
                    <h5 class="card-title">RFQ Management</h5>
                    <p class="card-text text-muted small">Create and manage Requests for Quotations (RFQs).</p>
                    <button id="openCreateRFQModalButton" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#createRFQModal">Create
                        RFQ</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor Management Table Card -->
    <div class="container mt-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light text-success">
                <h5 class="mb-0">Vendor Management</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="vendorTable" class="table table-bordered table-hover table-sm mb-0 shadow-sm">
                        <thead class="table-success">
                            <tr>
                                <th>#</th>
                                <th>Vendor ID</th>
                                <th>Vendor Name</th>
                                <th>Contact Information</th>
                                <th>Vendor Rating</th>
                                <th>Preferred Status</th>
                                <th>Contract Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($vendors as $vendor): ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $vendor['vendor_id']; ?></td>
                                <td><?= $vendor['vendor_name']; ?></td>
                                <td><?= $vendor['contact_info']; ?></td>
                                <td><?= $vendor['vendor_rating']; ?></td>
                                <td><?= $vendor['preferred_status']; ?></td>
                                <td><?= $vendor['contract_status']; ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <!-- Edit Vendor Button -->
                                        <button class="btn btn-sm btn-light shadow-sm btnEditVendor"
                                            data-vendor_id="<?= $vendor['vendor_id']; ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <!-- Remove Vendor Button -->
                                        <button class="btn btn-sm btn-danger shadow-sm removeVendor"
                                            data-vendor_id="<?= $vendor['vendor_id']; ?>">
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

    <!-- Product Catalog Management Table Card -->
    <div class="container mt-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light text-success">
                <h5 class="mb-0">Product Catalog Management</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="productTable" class="table table-bordered table-hover table-sm mb-0 shadow-sm">
                        <thead class="table-success">
                            <tr>
                                <th>#</th>
                                <th>Product ID</th>
                                <th>Vendor ID</th>
                                <th>Product Name</th>
                                <th>Description</th>
                                <th>Unit Price</th>
                                <th>Availability</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($products as $product): ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $product['product_id']; ?></td>
                                <td><?= $product['vendor_id']; ?></td>
                                <td><?= $product['product_name']; ?></td>
                                <td><?= $product['description']; ?></td>
                                <td><?= number_format($product['unit_price'], 2); ?></td>
                                <td><?= $product['availability']; ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <!-- Edit Product Button -->
                                        <button class="btn btn-sm btn-light shadow-sm editProduct"
                                            data-product_id="<?= $product['product_id']; ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <!-- Remove Product Button -->
                                        <button class="btn btn-sm btn-danger shadow-sm removeProduct"
                                            data-product_id="<?= $product['product_id']; ?>">
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
            <div class="card-header bg-light text-success">
                <h5 class="mb-0">RFQ Management and Status</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="rfqTable" class="table table-bordered table-hover table-sm mb-0 shadow-sm">
                        <thead class="table-success">
                            <tr>
                                <th>#</th>
                                <th>RFQ ID</th>
                                <th>Vendor ID</th>
                                <th>Product ID</th>
                                <th>Requested Quantity</th>
                                <th>Quoted Price</th>
                                <th>RFQ Status</th>
                                <th>Response Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($rfqs as $rfq): ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $rfq['rfq_id']; ?></td>
                                <td><?= $rfq['vendor_id']; ?></td>
                                <td><?= $rfq['product_id']; ?></td>
                                <td><?= $rfq['requested_quantity']; ?></td>
                                <td><?= number_format($rfq['quoted_price'], 2); ?></td>
                                <td><?= $rfq['rfq_status']; ?></td>
                                <td><?= $rfq['response_date']; ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <!-- Edit RFQ Button -->
                                        <button class="btn btn-sm btn-light shadow-sm editRFQ"
                                            data-rfq_id="<?= $rfq['rfq_id']; ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <!-- Remove RFQ Button -->
                                        <button class="btn btn-sm btn-danger shadow-sm removeRFQ"
                                            data-rfq_id="<?= $rfq['rfq_id']; ?>">
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
</div>

<!-- Modal Container for Dynamic Modals -->
<div id="responseModal"></div>
<div id="response"></div>

<!-- JavaScript for Handling Modals and AJAX Requests -->
<script>
// Vendor Modals and Actions
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

$('.removeVendor').click(function() {
    const vendor_id = $(this).data('vendor_id');
    if (confirm("Are you sure you want to delete this vendor?")) {
        $.post('api/vendor/remove.php', {
            vendor_id: vendor_id
        }, function(response) {
            $('#responseModal').html(response);
            location.reload();
        });
    }
});

// Product Modals and Actions

$('#openCreateProductModalButton').click(function() {
    $.post('api/vendor-rfq/create_product_modal.php', function(res) {
        $('#responseModal').html(res);
        $('#createProductModal').modal('show');
    });
});



$('.editProduct').click(function() {
    const product_id = $(this).data('product_id');
    $.post('api/product/edit_modal.php', {
        product_id: product_id
    }, function(res) {
        $('#responseModal').html(res);
        $('#editProductModal').modal('show');
    });
});

$('.removeProduct').click(function() {
    const product_id = $(this).data('product_id');
    if (confirm("Are you sure you want to delete this product?")) {
        $.post('api/product/remove.php', {
            product_id: product_id
        }, function(response) {
            $('#responseModal').html(response);
            location.reload();
        });
    }
});

// RFQ Modals and Actions


$('#openCreateRFQModalButton').click(function() {
    $.post('api/vendor-rfq/create_rfq_modal.php', function(res) {
        $('#responseModal').html(res);
        $('#createRFQModal').modal('show');
    });
});

$('.editRFQ').click(function() {
    const rfq_id = $(this).data('rfq_id');
    $.post('api/rfq/edit_modal.php', {
        rfq_id: rfq_id
    }, function(res) {
        $('#responseModal').html(res);
        $('#editRFQModal').modal('show');
    });
});

$('.removeRFQ').click(function() {
    const rfq_id = $(this).data('rfq_id');
    if (confirm("Are you sure you want to delete this RFQ?")) {
        $.post('api/rfq/remove.php', {
            rfq_id: rfq_id
        }, function(response) {
            $('#responseModal').html(response);
            location.reload();
        });
    }
});
</script>