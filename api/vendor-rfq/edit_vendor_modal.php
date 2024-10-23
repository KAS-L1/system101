<?php
require("../../app/init.php");
$vendor_id = $_POST['vendor_id'];
$vendor = $DB->SELECT_ONE_WHERE("vendors", "*", ["vendor_id" => $vendor_id]);
?>

<div class="modal fade" id="editVendorModal" tabindex="-1" aria-labelledby="editVendorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editVendorModalLabel">Edit Vendor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editVendorForm">
                    <input type="hidden" name="vendor_id" value="<?= $vendor['vendor_id']; ?>">
                    <div class="mb-3">
                        <label for="vendorName" class="form-label">Vendor Name</label>
                        <input type="text" class="form-control" id="vendorName" name="vendor_name" value="<?= $vendor['vendor_name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="contactInfo" class="form-label">Contact Information</label>
                        <input type="text" class="form-control" id="contactInfo" name="contact_info" value="<?= $vendor['contact_info']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="vendorRating" class="form-label">Vendor Rating</label>
                        <input type="number" class="form-control" id="vendorRating" name="vendor_rating" value="<?= $vendor['vendor_rating']; ?>" min="1" max="5" required>
                    </div>
                    <div class="mb-3">
                        <label for="preferredStatus" class="form-label">Preferred Status</label>
                        <select class="form-select" id="preferredStatus" name="preferred_status" required>
                            <option value="Yes" <?= $vendor['preferred_status'] == 'Yes' ? 'selected' : ''; ?>>Yes</option>
                            <option value="No" <?= $vendor['preferred_status'] == 'No' ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="contractStatus" class="form-label">Contract Status</label>
                        <select class="form-select" id="contractStatus" name="contract_status" required>
                            <option value="Active" <?= $vendor['contract_status'] == 'Active' ? 'selected' : ''; ?>>Active</option>
                            <option value="Inactive" <?= $vendor['contract_status'] == 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Update Vendor</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#editVendorForm').submit(function(e) {
    e.preventDefault(); // Prevent default form submission
    var formData = $(this).serialize(); // Serialize form data
    // AJAX request to update requisition data
        $.post('api/vendor-rfq/update_vendor.php', $(this).serialize(), function(response) {
        $('#response').html(response); // Display response in the modal
    });
});
</script>

   
