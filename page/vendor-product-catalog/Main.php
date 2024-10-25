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
                        <button class="btn btn-sm btn-primary" id="CreateCategoryModalButton">
                            <i class="bi bi-plus-circle"></i> Add Category
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
                                    <th>Category</th> <!-- New Category Column -->
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
                                    // Selecting vendor name 
                                    $whereVendor = array("vendor_id" => $product['vendor_id']);
                                    $vendor_name = $DB->SELECT_ONE_WHERE("vendors", "vendor_name", $whereVendor);
                                    $vendorName = $vendor_name ? CHARS($vendor_name['vendor_name']) : 'Unknown Vendor';

                                    // Selecting category name
                                    $whereCategory = array("category_id" => $product['category_id']); // Assuming you have category_id in vendor_products
                                    $category_name = $DB->SELECT_ONE_WHERE("categories", "category_name", $whereCategory);
                                    $categoryName = $category_name ? CHARS($category_name['category_name']) : 'Unknown Category'; // Adjust this based on your actual field names
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $product['product_id']; ?></td>
                                        <td><?= $vendorName; ?></td>
                                        <td><?= $categoryName; ?></td> <!-- Display Category -->
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
</div>

<!-- Modal Container for Dynamic Modals -->
<div id="responseModal"></div>
<div id="response"></div>

<!-- Add Category Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCategoryModalLabel">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createCategoryForm">
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="createCategoryForm" class="btn btn-primary">Add Category</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Handle Create Category modal open action
    $('#CreateCategoryModalButton').click(function() {
        $('#createCategoryModal').modal('show');
    });

    // Handle Create Category form submission
    $('#createCategoryForm').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        const categoryName = $('#category_name').val(); // Get the category name

        $.post('api/vendor-rfq/add_category.php', {
            category_name: categoryName
        }, function(response) {
            $('#createCategoryModal').modal('hide'); // Hide the modal
            $('#response').html(response); // Display response
            $('#category_name').val(''); // Clear input field
            // Optionally, refresh the category list or table
        }).fail(function() {
            alert('Error adding category. Please try again.');
        });
    });
</script>


<!-- JavaScript for Handling Modals and AJAX Requests -->
<script>
    // Product Modals and Actions

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

    // Handle Create Product modal open action
    $('#CreateProductModalButton').click(function() {
        $.post('api/vendor-rfq/create_product_modal.php', function(res) {
            $('#responseModal').html(res);
            $('#createProductModal').modal('show');
        });
    });

    // Edit Product
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
                    swalAlert('success', 'Product has been deleted!');
                }).fail(function() {
                    swalAlert('error', 'Failed to delete product. Please try again.');
                });
            }
        });
    });
</script>