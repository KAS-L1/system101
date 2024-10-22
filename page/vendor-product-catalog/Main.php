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
        <!-- Product Catalog Management Table Card -->
        <div class="container mt-4">
            <div class="card shadow-sm mb-4">
                
                <div class="card-header bg-light text-success d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Product Catalog Management</h5>
                    <!-- Download Report Button next to the Search bar -->
                    <div>
                        <button class="btn btn-sm btn-success" onclick="window.open('/api/vendor-rfq/generateall_report_product.php', '_blank')">
                            <i class="bi bi-download"></i>
                        </button>
                        <button class="btn btn-sm btn-primary" id="CreateProductModalButton">
                            <i class="bi bi-plus-circle"></i> Add Product
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
                                    <th>Product Name</th>
                                    <th>Description</th>
                                    <th>Unit Price</th>
                                    <th>Availability</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach ($products as $product): ?>
                                    <?php
                                    // Selecting on vendors 
                                    $where = array("vendor_id" => $product['vendor_id']);
                                    $vendor_name = $DB->SELECT_ONE_WHERE("vendors", "vendor_name", $where);
                                    $vendorName = $vendor_name ? CHARS($vendor_name['vendor_name']) : 'Unknown Vendor'; // Updated variable reference here
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $product['product_id']; ?></td>
                                        <td><?= $vendorName ?></td>
                                        <td><?= $product['product_name']; ?></td>
                                        <td><?= $product['description']; ?></td>
                                        <td><?= NUMBER_PHP_2($product['unit_price']); ?></td>
                                        <td><?= $product['availability']; ?></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <!-- Edit Product Button -->
                                                <button class="btn btn-sm btn-light shadow-sm editProduct" data-product_id="<?= $product['product_id']; ?>">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <!-- View RFQ Button -->
                                                <button class="btn btn-sm btn-light shadow-sm viewProduct" data-product_id="<?= $product['product_id']; ?>">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <!-- Generate Report Button -->
                                                <button class="btn btn-sm btn-light shadow-sm generateReportProduct text-success" data-product_id="<?= $product['product_id']; ?>">
                                                    <i class="bi bi-file-earmark-text"></i>
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
        // Product Modals and Actions
        // Handle Create Product modal open action

         // Handle View RFQ button click

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

        $('#CreateProductModalButton').click(function() {
            $.post('api/vendor-rfq/create_product_modal.php', function(res) {
                $('#responseModal').html(res);
                $('#createProductModal').modal('show');
            });
        });

        $('.editProduct').click(function() {
            const product_id = $(this).data('product_id');
            $.post('api/vendor-rfq/edit_product_modal.php', { product_id: product_id }, function(res) {
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
                    $.post('api/vendor-rfq/remove_product.php', { product_id: product_id }, function(response) {
                        $('#responseModal').html(response);
                        swalAlert('success', 'Product has been deleted!');
                    }).fail(function() {
                        swalAlert('error', 'Failed to delete product. Please try again.');
                    });
                }
            });
        });
    </script>
</div>
