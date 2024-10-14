<?php
require("../../app/init.php");

// Retrieve Contract ID from POST request
$contract_id = $_POST['contract_id'];
$where = array("contract_id" => $contract_id);

// Fetch the contract details from the database
$contract = $DB->SELECT_ONE_WHERE("contracts", "*", $where);

// Fetch associated vendor data
$vendor = $DB->SELECT_ONE_WHERE('vendors', '*', array('vendor_id' => $contract['vendor_id']));
?>

<!-- Edit Contract Modal -->
<div class="modal fade" id="editContractModal" tabindex="-1" aria-labelledby="editContractModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editContractModalLabel">Edit Contract</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Edit Contract Form -->
                <form id="formEditContract">
                    <!-- Hidden field for Contract ID -->
                    <input type="hidden" name="contract_id" value="<?= $contract['contract_id'] ?>">

                    <!-- Vendor Name Field -->
                    <div class="mb-3">
                        <label for="vendor_name" class="form-label">Vendor Name</label>
                        <input type="text" id="vendor_name" name="vendor_name" class="form-control"
                            value="<?= $vendor['vendor_name'] ?>" readonly>
                    </div>

                    <!-- Contract Terms Field -->
                    <div class="mb-3">
                        <label for="contract_terms" class="form-label">Contract Terms</label>
                        <textarea id="contract_terms" name="contract_terms" class="form-control" rows="3" required><?= $contract['contract_terms'] ?></textarea>
                    </div>

                    <!-- Start Date and End Date Fields -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" id="start_date" name="start_date" class="form-control" value="<?= $contract['start_date'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" value="<?= $contract['end_date'] ?>" required>
                        </div>
                    </div>

                    <!-- Status Field -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="Active" <?= $contract['status'] == 'Active' ? 'selected' : '' ?>>Active</option>
                            <option value="Terminated" <?= $contract['status'] == 'Terminated' ? 'selected' : '' ?>>Terminated</option>
                            <option value="Expired" <?= $contract['status'] == 'Expired' ? 'selected' : '' ?>>Expired</option>
                        </select>
                    </div>

                    <!-- Renewal Date Field -->
                    <div class="mb-3">
                        <label for="renewal_date" class="form-label">Renewal Date</label>
                        <input type="date" id="renewal_date" name="renewal_date" class="form-control" value="<?= $contract['renewal_date'] ?>">
                    </div>

                    <!-- Remarks Field -->
                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea id="remarks" name="remarks" class="form-control" rows="3"><?= $contract['remarks'] ?></textarea>
                    </div>

                    <!-- Modal Footer with Buttons -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update Contract</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Handling Form Submission -->
<script>
    $('#formEditContract').submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        var formData = $(this).serialize(); // Serialize form data

        // AJAX request to update contract data
        $.post("api/contract-management/update.php", formData, function(response) {
            $('#responseModal').html(response); // Display response in the modal
        });
    });
</script>