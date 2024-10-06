<?php require("../../app/init.php") ?>

<?php 
    $id = $_POST['id'];
    $where = array("id" => $id);
    $supplier = $DB->SELECT_ONE_WHERE("suppliers", "*", $where); 

    if (!$supplier) {
        echo "<div class='alert alert-danger'>Supplier not found. Please check the ID.</div>";
        exit; 
    }
?>

<!-- Modal for Editing Supplier Profile -->
<div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editSupplierModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSupplierModalLabel">Edit Supplier Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Edit Supplier Profile Form -->
                <form id="formEditSupplier">
                    <input type="hidden" name="id" value="<?=$supplier['id']?>">
                    <div class="mb-3">
                        <label for="supplierName" class="form-label">Supplier Name:</label>
                        <input type="text" id="supplierName" name="name" class="form-control"
                            value="<?=$supplier['name']?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierContactNumber" class="form-label">Contact Number:</label>
                        <input type="text" id="supplierContactNumber" name="contact_number" class="form-control"
                            value="<?=$supplier['contact_number']?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierEmail" class="form-label">Email:</label>
                        <input type="email" id="supplierEmail" name="email" class="form-control"
                            value="<?=$supplier['email']?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierAddress" class="form-label">Address:</label>
                        <input type="text" id="supplierAddress" name="address" class="form-control"
                            value="<?=$supplier['address']?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierContract" class="form-label">Contract:</label>
                        <input type="text" id="supplierContract" name="contract" class="form-control"
                            value="<?=$supplier['contract']?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierPerformance" class="form-label">Supplier Performance:</label>
                        <input type="text" id="supplierPerformance" name="performance_score" class="form-control"
                            value="<?=$supplier['performance_score']?>" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="responseModal"></div>

<!-- JavaScript for Handling the Form Submission -->
<script>
$('#formEditSupplier').submit(function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.post("api/supplier/update.php", formData, function(response) {
        $('#responseModal').html(response);
    });
});
</script>