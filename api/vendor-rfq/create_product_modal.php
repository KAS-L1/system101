<?php require("../../app/init.php"); ?>


<!-- Create Product Modal -->
<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createProductModalLabel">Create Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Product Creation Form -->
                <form id="formAddProduct">
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="vendor_id" class="form-label">Vendor ID</label>
                        <select class="form-control" id="vendor_id" name="vendor_id" required>
                            <?php foreach ($vendors as $vendor): ?>
                            <option value="<?= $vendor['vendor_id']; ?>"><?= $vendor['vendor_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="unit_price" class="form-label">Unit Price</label>
                        <input type="number" class="form-control" id="unit_price" name="unit_price" step="0.01"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="availability" class="form-label">Availability</label>
                        <select class="form-control" id="availability" name="availability" required>
                            <option value="In Stock">In Stock</option>
                            <option value="Out of Stock">Out of Stock</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" form="formAddProduct">Save Product</button>
            </div>
        </div>
    </div>
</div>




<div id="responseModal"></div>

<!-- JavaScript for Handling the Form Submission -->
<script>
$('#formAddProduct').submit(function(e) {
    e.preventDefault(); // Prevent default form submission
    var formData = $(this).serialize();
    $.post("api/vendor-rfq/create_product.php", formData, function(response) {
        $('#responseModal').html(response); // Display response in the modal
    });
});
</script>