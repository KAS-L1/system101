<?php
require("../../app/init.php");

$vendor_id = $_POST['vendor_id'];

// Query vendor data
$vendor = $DB->SELECT("vendors", "*", ["vendor_id" => $vendor_id]);

// Check if the vendor exists
if (empty($vendor)) {
    echo "<p class='alert alert-danger'>Vendor not found.</p>";
    exit;
}

$vendor = $vendor[0];  // Assuming $DB->SELECT() returns an array of results
?>

<!-- Edit Vendor Modal -->
<div class="modal fade" id="editVendorModal" tabindex="-1" aria-labelledby="editVendorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editVendorModalLabel">Edit Vendor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editVendorForm">
                <div class="modal-body">
                    <input type="hidden" name="vendor_id" value="<?= htmlspecialchars($vendor['vendor_id']); ?>">
                    <div class="mb-3">
                        <label for="vendor_name" class="form-label">Vendor Name</label>
                        <input type="text" class="form-control" id="vendor_name" name="vendor_name" value="<?= htmlspecialchars($vendor['vendor_name'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact_info" class="form-label">Contact Information</label>
                        <input type="text" class="form-control" id="contact_info" name="contact_info" value="<?= htmlspecialchars($vendor['contact_info'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="vendor_rating" class="form-label">Vendor Rating</label>
                        <input type="number" class="form-control" id="vendor_rating" name="vendor_rating" value="<?= htmlspecialchars($vendor['vendor_rating'] ?? ''); ?>" required min="1" max="5">
                    </div>
                    <div class="mb-3">
                        <label for="preferred_status" class="form-label">Preferred Status</label>
                        <select class="form-select" id="preferred_status" name="preferred_status" required>
                            <option value="Preferred" <?= ($vendor['preferred_status'] ?? '') === 'Preferred' ? 'selected' : ''; ?>>Preferred</option>
                            <option value="Non-Preferred" <?= ($vendor['preferred_status'] ?? '') === 'Non-Preferred' ? 'selected' : ''; ?>>Non-Preferred</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="contract_status" class="form-label">Contract Status</label>
                        <select class="form-select" id="contract_status" name="contract_status" required>
                            <option value="Active" <?= ($vendor['contract_status'] ?? '') === 'Active' ? 'selected' : ''; ?>>Active</option>
                            <option value="Inactive" <?= ($vendor['contract_status'] ?? '') === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Handle form submission for editing vendor
    $('#editVendorForm').submit(function(e) {
        e.preventDefault();  // Prevent form from submitting the traditional way
        const formData = $(this).serialize();  // Gather form data
        
        $.post('api/vendor-rfq/update_vendor.php', formData, function(response) {
            $('#responseModal').html(response);  // Handle response
            $('#editVendorModal').modal('hide');  // Hide modal after success
            location.reload();  // Reload page to reflect changes
        }).fail(function() {
            alert('Error: Could not update vendor.');
        });
    });
</script>
