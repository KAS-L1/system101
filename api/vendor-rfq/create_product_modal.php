<?php
require("../../app/init.php");

// Fetch the list of vendors from the `users` table where role is "VENDOR"
$where = array("role" => "VENDOR");
$vendors = $DB->SELECT_WHERE("users", "*", $where, "ORDER BY user_id ASC");

// Fetch the list of categories from the `categories` table
$categories = $DB->SELECT("categories", "*", "ORDER BY category_id ASC");
?>


<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createProductModalLabel">Create Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createProductForm">
                    <!-- Vendor Selection -->
                    <div class="mb-3">
                        <label for="vendorId" class="form-label">Vendor Name</label>
                        <select class="form-select" id="vendorId" name="vendor_id" required>
                            <option value="">Select Vendor</option>
                            <?php foreach ($vendors as $vendor): ?>
                                <option value="<?= htmlspecialchars($vendor['user_id']); ?>">
                                    <?= htmlspecialchars($vendor['vendor_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Category Selection -->
                    <div class="mb-3">
                        <label for="categoryId" class="form-label">Category</label>
                        <select class="form-select" id="categoryId" name="category_id" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= htmlspecialchars($category['category_id']); ?>">
                                    <?= htmlspecialchars($category['category_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="product_name" required>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>

                    <!-- Unit Price -->
                    <div class="mb-3">
                        <label for="unitPrice" class="form-label">Unit Price</label>
                        <input type="number" class="form-control" id="unitPrice" name="unit_price" step="0.01" required>
                    </div>

                    <!-- Availability -->
                    <div class="mb-3">
                        <label for="availability" class="form-label">Availability</label>
                        <input type="number" class="form-control" id="availability" name="availability" required>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success">Create Product</button>
                </form>

                <!-- Placeholder for response messages -->
                <div id="response"></div>
            </div>
        </div>
    </div>
</div>


<script>
    $('#createProductForm').submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        // Send the form data via AJAX
        $.post('api/vendor-rfq/create_product.php', $(this).serialize(), function(response) {
            $('#response').html(response); // Display server response
        });
    });
</script>