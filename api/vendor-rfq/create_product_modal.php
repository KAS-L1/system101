<?php
require("../../app/init.php");

// Fetch vendors from the database
$vendors = $DB->SELECT("vendors", "*", "ORDER BY vendor_id ASC");

?>

<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createProductModalLabel">Create Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createProductForm">
                    <div class="mb-3">
                        <label for="vendorId" class="form-label">Vendor Name</label>
                        <select class="form-select" id="vendorId" name="vendor_id" required>
                            <option value="">Select Vendor</option>
                            <?php foreach ($vendors as $vendor): ?>
                                <option value="<?= $vendor['vendor_id']; ?>"><?= $vendor['vendor_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="product_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="unitPrice" class="form-label">Unit Price</label>
                        <input type="number" class="form-control" id="unitPrice" name="unit_price" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="availability" class="form-label">Availability</label>
                        <input type="number" class="form-control" id="availability" name="availability" required>
                    </div>
                    <button type="submit" class="btn btn-success">Create Product</button>
                </form>
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