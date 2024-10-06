<?php require("../../app/init.php"); ?>

<!-- Modal for Adding Supplier -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSupplierModalLabel">Add Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add Supplier Form -->
                <form id="formAddSupplier">
                    <div class="mb-3">
                        <label for="supplierName" class="form-label">Supplier Name:</label>
                        <input type="text" id="supplierName" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierContactPerson" class="form-label">Contact Person:</label>
                        <input type="text" id="supplierContactPerson" name="contact_person" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierContactNumber" class="form-label">Contact Number:</label>
                        <input type="text" id="supplierContactNumber" name="contact_number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierEmail" class="form-label">Email:</label>
                        <input type="email" id="supplierEmail" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierAddress" class="form-label">Address:</label>
                        <input type="text" id="supplierAddress" name="address" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Handling the Form Submission -->
<script>
    $('#formAddSupplier').submit(function(e) {
        e.preventDefault(); // Prevent default form submission

        var formData = $(this).serialize();
        $.post("api/supplier/create.php", formData, function(response) {
            $('#responseModal').html(response); // Display response in the modal
            if (response.includes('success')) {
                $('#addSupplierModal').modal('hide'); // Hide modal if successful
                location.reload(); // Reload page to reflect changes
            }
        });
    });
</script>
