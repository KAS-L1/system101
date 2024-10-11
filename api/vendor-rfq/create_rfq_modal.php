<?php require("../../app/init.php"); ?>



<!-- Create RFQ Modal -->
<div class="modal fade" id="createRFQModal" tabindex="-1" aria-labelledby="createRFQModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRFQModalLabel">Create RFQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- RFQ Creation Form -->
                <form id="formAddRFQ">
                    <div class="mb-3">
                        <label for="vendor_id" class="form-label">Vendor ID</label>
                        <select class="form-control" id="vendor_id" name="vendor_id" required>
                            <?php foreach ($vendors as $vendor): ?>
                            <option value="<?= $vendor['vendor_id']; ?>"><?= $vendor['vendor_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Product ID</label>
                        <select class="form-control" id="product_id" name="product_id" required>
                            <?php foreach ($products as $product): ?>
                            <option value="<?= $product['product_id']; ?>"><?= $product['product_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="requested_quantity" class="form-label">Requested Quantity</label>
                        <input type="number" class="form-control" id="requested_quantity" name="requested_quantity"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="quoted_price" class="form-label">Quoted Price</label>
                        <input type="number" class="form-control" id="quoted_price" name="quoted_price" step="0.01">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" form="formAddRFQ">Save RFQ</button>
            </div>
        </div>
    </div>
</div>





<div id="responseModal"></div>

<!-- JavaScript for Handling the Form Submission -->
<script>
$('#formAddRfq').submit(function(e) {
    e.preventDefault(); // Prevent default form submission
    var formData = $(this).serialize();
    $.post("api/vendor-rfq/create_rfq.php", formData, function(response) {
        $('#responseModal').html(response); // Display response in the modal
    });
});
</script>