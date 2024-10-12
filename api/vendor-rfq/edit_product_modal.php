<?php
require("../../app/init.php");
$product_id = $_POST['product_id'];
$product = $DB->SELECT_ONE_WHERE("vendor_products", "*", ["product_id" => $product_id]);
?>

<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm">
                    <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">
                    <div class="mb-3">
                        <label for="vendorId" class="form-label">Vendor ID</label>
                        <select class="form-select" id="vendorId" name="vendor_id" required>
                            <?php foreach ($vendors as $vendor): ?>
                                <option value="<?= $vendor['vendor_id']; ?>" <?= $vendor['vendor_id'] == $product['vendor_id'] ? 'selected' : ''; ?>>
                                    <?= $vendor['vendor_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="product_name" value="<?= $product['product_name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required><?= $product['description']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="unitPrice" class="form-label">Unit Price</label>
                        <input type="number" class="form-control" id="unitPrice" name="unit_price" value="<?= $product['unit_price']; ?>" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="availability" class="form-label">Availability</label>
                        <input type="number" class="form-control" id="availability" name="availability" value="<?= $product['availability']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success">Update Product</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#editProductForm').submit(function(e) {
        e.preventDefault();
        $.post('api/product/update.php', $(this).serialize(), function(response) {
            $('#response').html(response);
            $('#editProductModal').modal('hide');
            location.reload();
        });
    });
</script>
