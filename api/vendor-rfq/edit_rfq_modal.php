<?php
require("../../app/init.php");
$rfq_id = $_POST['rfq_id'];
$rfq = $DB->SELECT_ONE_WHERE("rfqs", "*", ["rfq_id" => $rfq_id]);
?>

<!-- Edit RFQ Modal -->
<div class="modal fade" id="editRFQModal" tabindex="-1" aria-labelledby="editRFQModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRFQModalLabel">Edit RFQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editRFQForm">
                    <input type="hidden" name="rfq_id" value="<?= $rfq['rfq_id']; ?>">
                    <div class="mb-3">
                        <label for="vendor_id" class="form-label">Vendor ID</label>
                        <input type="text" class="form-control" id="vendor_id" name="vendor_id" value="<?= $rfq['vendor_id']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Product ID</label>
                        <input type="text" class="form-control" id="product_id" name="product_id" value="<?= $rfq['product_id']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="requested_quantity" class="form-label">Requested Quantity</label>
                        <input type="number" class="form-control" id="requested_quantity" name="requested_quantity" value="<?= $rfq['requested_quantity']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="quoted_price" class="form-label">Quoted Price</label>
                        <input type="number" class="form-control" id="quoted_price" name="quoted_price" value="<?= $rfq['quoted_price']; ?>" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="rfq_status" class="form-label">RFQ Status</label>
                        <select class="form-select" id="rfq_status" name="rfq_status" required>
                            <option value="Pending" <?= $rfq['rfq_status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="Approved" <?= $rfq['rfq_status'] == 'Approved' ? 'selected' : ''; ?>>Approved</option>
                            <option value="Rejected" <?= $rfq['rfq_status'] == 'Rejected' ? 'selected' : ''; ?>>Rejected</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Update RFQ</button>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
$('#editRFQForm').submit(function(e) {
    e.preventDefault(); // Prevent default form submission

    // Send an AJAX POST request to update the RFQ details
    $.post('api/rfq/update.php', $(this).serialize(), function(response) {
        $('#response').html(response); // Display response message
        $('#editRFQModal').modal('hide'); // Hide the modal after updating
        location.reload(); // Refresh the page to reflect the changes
    });
});
</script>

