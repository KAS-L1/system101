<?php
include_once('api/middleware/role_access_vendor.php');

if (AUTH_USER['role'] == "ADMIN") {
    $vendors = $DB->SELECT("users", "*", "WHERE role = 'VENDOR' ORDER BY user_id ASC");
    $products = $DB->SELECT("vendor_products", "*");
    $rfqs = $DB->SELECT("rfqs", "*", "ORDER BY response_date DESC");
} elseif (AUTH_USER['role'] == "VENDOR") {
    $where = array("vendor_id" => AUTH_USER_ID);
    $products = $DB->SELECT_WHERE("vendor_products", "*", $where);
}

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
                                    $whereVendor = array("user_id" => $product['vendor_id']);
                                    $vendor_name = $DB->SELECT_ONE_WHERE("users", "vendor_name", $whereVendor);
                                    $vendorName = $vendor_name ? htmlspecialchars($vendor_name['vendor_name']) : 'Unknown Vendor';

                                    // Selecting category name
                                    $whereCategory = array("category_id" => $product['category_id']);
                                    $category_name = $DB->SELECT_ONE_WHERE("categories", "category_name", $whereCategory);
                                    $categoryName = $category_name ? htmlspecialchars($category_name['category_name']) : 'Unknown Category';
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= htmlspecialchars($product['product_id']); ?></td>
                                        <td><?= $vendorName; ?></td>
                                        <td><?= $categoryName; ?></td>
                                        <td><?= htmlspecialchars($product['product_name']); ?></td>
                                        <td><?= htmlspecialchars($product['description']); ?></td>
                                        <td><?= number_format($product['unit_price'], 2); ?></td>
                                        <td><?= htmlspecialchars($product['availability']); ?></td>
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

<!-- JavaScript for Handling Modals and AJAX Requests -->
<script>
    $('#CreateCategoryModalButton').click(function() {
        $('#createCategoryModal').modal('show');
    });

    $('#createCategoryForm').on('submit', function(event) {
        event.preventDefault();
        const categoryName = $('#category_name').val();
        $.post('api/vendor-rfq/add_category.php', {
            category_name: categoryName
        }, function(response) {
            $('#createCategoryModal').modal('hide');
            $('#response').html(response);
            $('#category_name').val('');
        }).fail(function() {
            alert('Error adding category. Please try again.');
        });
    });

    $('.viewProduct').click(function() {
        const product_id = $(this).data('product_id');
        $.post('api/vendor-rfq/view_product_modal.php', {
            product_id
        }, function(res) {
            $('#responseModal').html(res);
            $('#viewProductModal').modal('show');
        });
    });

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
        $.post('api/vendor-rfq/edit_product_modal.php', {
            product_id
        }, function(res) {
            $('#responseModal').html(res);
            $('#editProductModal').modal('show');
        });
    });
</script>