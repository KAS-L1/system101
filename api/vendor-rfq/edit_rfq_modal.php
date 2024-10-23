<?php
require("../../app/init.php");
$rfq_id = $_POST['rfq_id'];
$rfq = $DB->SELECT_ONE_WHERE("rfqs", "*", ["rfq_id" => $rfq_id]);
$vendors = $DB->SELECT("vendors", "*", "ORDER BY vendor_id ASC");

// Fetch product name based on product_id from RFQ
$productNameData = $DB->SELECT_ONE_WHERE("vendor_products", "product_name", ["product_id" => $rfq['product_id']]);
$productName = $productNameData ? CHARS($productNameData['product_name']) : 'Unknown Product';
?>

<!-- Edit RFQ Modal -->
<div class="modal fade" id="editRFQModal" tabindex="-1" aria-labelledby="editRFQModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRFQModalLabel">Edit RFQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editRFQForm">
                    <input type="hidden" name="rfq_id" value="<?= CHARS($rfq['rfq_id']); ?>">

                    <!-- Vendor Selection -->
                    <div class="mb-3">
                        <label for="vendorId" class="form-label">Vendor Name</label>
                        <select class="form-select" id="vendorId" name="vendor_id" required>
                            <?php foreach ($vendors as $vendor): ?>
                                <option value="<?= CHARS($vendor['vendor_id']); ?>" <?= $vendor['vendor_id'] == $rfq['vendor_id'] ? 'selected' : ''; ?>>
                                    <?= CHARS($vendor['vendor_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                    <!-- Product ID -->
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Product ID</label>
                        <input type="text" class="form-control" id="product_id" name="product_id" value="<?= $rfq['product_id']; ?>" readonly>
                    </div>


                    <!-- Product Name Display -->
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="product_name" value="<?= $productName; ?>" readonly>
                    </div>

                    <!-- Requested Quantity -->
                    <div class="mb-3">
                        <label for="requested_quantity" class="form-label">Requested Quantity</label>
                        <input type="number" class="form-control" id="requested_quantity" name="requested_quantity" value="<?= CHARS($rfq['requested_quantity']); ?>" required>
                    </div>

                    <!-- Quoted Price -->
                    <div class="mb-3">
                        <label for="quoted_price" class="form-label">Quoted Price</label>
                        <input type="number" class="form-control" id="quoted_price" name="quoted_price" value="<?= CHARS($rfq['quoted_price']); ?>" step="0.01">
                    </div>

                    <!-- Remarks -->
                    <div class="mb-3">
                        <label for="response_remarks" class="form-label">Remarks:</label>
                        <textarea class="form-control" id="response_remarks" name="response_remarks"><?= CHARS($rfq['remarks']); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Update RFQ</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="responseEdit"></div>
<script>
   $('#editRFQForm').submit(function(e) {
    e.preventDefault();
    $.post('api/vendor-rfq/update_rfq.php', $(this).serialize(), function(response) {
        $('#responseEdit').html(response);
    });
});
</script>
