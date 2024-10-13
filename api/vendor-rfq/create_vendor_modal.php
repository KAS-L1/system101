<div class="modal fade" id="createVendorModal" tabindex="-1" aria-labelledby="createVendorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createVendorModalLabel">Create Vendor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createVendorForm">
                    <div class="mb-3">
                        <label for="vendorName" class="form-label">Vendor Name</label>
                        <input type="text" class="form-control" id="vendorName" name="vendor_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="contactInfo" class="form-label">Contact Information</label>
                        <input type="text" class="form-control" id="contactInfo" name="contact_info" required>
                    </div>
                    <div class="mb-3">
                        <label for="vendorRating" class="form-label">Vendor Rating</label>
                        <input type="number" class="form-control" id="vendorRating" name="vendor_rating" min="1" max="5" required>
                    </div>
                    <div class="mb-3">
                        <label for="preferredStatus" class="form-label">Preferred Status</label>
                        <select class="form-select" id="preferredStatus" name="preferred_status" required>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="contractStatus" class="form-label">Contract Status</label>
                        <select class="form-select" id="contractStatus" name="contract_status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Create Vendor</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#createVendorForm').submit(function(e) {
        e.preventDefault();
        $.post('api/vendor-rfq/create_vendor.php', $(this).serialize(), function(response) {
            $('#response').html(response);
        });
    });
</script>
