<?php require("../../app/init.php"); ?>

<!-- Create Vendor Modal -->
<div class="modal fade" id="createVendorModal" tabindex="-1" aria-labelledby="createVendorModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createVendorModalLabel">Create Vendor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Vendor Creation Form -->
                <form id="formAddVendor">
                    <div class="mb-3">
                        <label for="vendor_name" class="form-label">Vendor Name</label>
                        <input type="text" class="form-control" id="vendor_name" name="vendor_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact_info" class="form-label">Contact Information</label>
                        <textarea class="form-control" id="contact_info" name="contact_info" rows="3"
                            required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="vendor_rating" class="form-label">Vendor Rating</label>
                        <input type="number" class="form-control" id="vendor_rating" name="vendor_rating" step="0.01"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="preferred_status" class="form-label">Preferred Status</label>
                        <select class="form-control" id="preferred_status" name="preferred_status" required>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="contract_status" class="form-label">Contract Status</label>
                        <select class="form-control" id="contract_status" name="contract_status" required>
                            <option value="Active">Active</option>
                            <option value="Expired">Expired</option>
                            <option value="None">None</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" form="formAddVendor">Save Vendor</button>
            </div>
        </div>
    </div>
</div>


<div id="responseModal"></div>

<!-- JavaScript for Handling the Form Submission -->
<script>
$('#formAddVendor').submit(function(e) {
    e.preventDefault(); // Prevent default form submission
    var formData = $(this).serialize();
    $.post("api/vendor-rfq/create_vendor.php", formData, function(response) {
        $('#responseModal').html(response); // Display response in the modal
    });
});
</script>