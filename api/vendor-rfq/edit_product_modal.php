<?php
require("../../app/init.php");

// Fetch the list of vendors
$vendors = $DB->SELECT("users", "*", "WHERE role = 'VENDOR' ORDER BY user_id ASC");

// Get the product details
$product_id = $_POST['product_id'];
$product = $DB->SELECT_ONE_WHERE("vendor_products", "*", ["product_id" => $product_id]);
?>


<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm">
                    <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">

                    <!-- Vendor Selection -->
                    <div class="mb-3">
                        <label for="vendorId" class="form-label">Vendor Name</label>
                        <select class="form-select" id="vendorId" name="vendor_id" required>
                            <?php foreach ($vendors as $vendor): ?>
                                <option value="<?= htmlspecialchars($vendor['user_id']); ?>" <?= $vendor['user_id'] == $product['vendor_id'] ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($vendor['vendor_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="product_name" value="<?= htmlspecialchars($product['product_name']); ?>" required>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required><?= htmlspecialchars($product['description']); ?></textarea>
                    </div>

                    <!-- Unit Price -->
                    <div class="mb-3">
                        <label for="unitPrice" class="form-label">Unit Price</label>
                        <input type="number" class="form-control" id="unitPrice" name="unit_price" value="<?= htmlspecialchars($product['unit_price']); ?>" step="0.01" required>
                    </div>

                    <!-- Availability -->
                    <div class="mb-3">
                        <label for="availability" class="form-label">Availability</label>
                        <input type="number" class="form-control" id="availability" name="availability" value="<?= htmlspecialchars($product['availability']); ?>" required>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success">Update Product</button>
                </form>
                <div id="response"></div>
            </div>
        </div>
    </div>
</div>


<script>
    $('#editProductForm').submit(function(e) {
        e.preventDefault();
        $.post('api/vendor-rfq/update_product.php', $(this).serialize(), function(response) {
            $('#response').html(response);
        });
    });
</script>