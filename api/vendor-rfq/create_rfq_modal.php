<div class="modal fade" id="createRFQModal" tabindex="-1" aria-labelledby="createRFQModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRFQModalLabel">Create RFQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createRFQForm">
                    <div class="mb-3">
                        <label for="vendorId" class="form-label">Vendor ID</label>
                        <select class="form-select" id="vendorId" name="vendor_id" required>
                            <?php foreach ($vendors as $vendor): ?>
                                <option value="<?= $vendor['vendor_id']; ?>"><?= $vendor['vendor_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="productId" class="form-label">Product ID</label>
                        <select class="form-select" id="productId" name="product_id" required>
                            <?php foreach ($products as $product): ?>
                                <option value="<?= $product['product_id']; ?>"><?= $product['product_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="requestedQuantity" class="form-label">Requested Quantity</label>
                        <input type="number" class="form-control" id="requestedQuantity" name="requested_quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="quotedPrice" class="form-label">Quoted Price</label>
                        <input type="number" class="form-control" id="quotedPrice" name="quoted_price" step="0.01" required>
                    </div>
                    <button type="submit" class="btn btn-success">Create RFQ</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#createRFQForm').submit(function(e) {
        e.preventDefault();
        $.post('api/rfq/create.php', $(this).serialize(), function(response) {
            $('#response').html(response);
            $('#createRFQModal').modal('hide');
            location.reload();
        });
    });
</script>
