<?php require("../../app/init.php"); ?>

<!-- Modal: Create Contract -->
<div class="modal fade" id="addContractModal" tabindex="-1" aria-labelledby="addContractModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addContractModalLabel">Create New Contract</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Create Contract Form -->
                <form id="formAddContract">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="vendor_id" class="form-label">Vendor Name</label>
                            <select id="vendor_id" name="vendor_id" class="form-select" required>
                                <?php
                                $vendors = $DB->SELECT('vendors', '*');
                                foreach ($vendors as $vendor) {
                                    echo "<option value='{$vendor['vendor_id']}'>" . htmlspecialchars($vendor['vendor_name']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="contract_terms" class="form-label">Contract Terms</label>
                            <textarea id="contract_terms" name="contract_terms" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" id="start_date" name="start_date" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="renewal_date" class="form-label">Renewal Date</label>
                            <input type="date" id="renewal_date" name="renewal_date" class="form-control">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Create Contract</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Handling Create Contract Form Submission -->
<script>
    $('#formAddContract').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.post("api/contract-management/create.php", formData, function(response) {
            $('#responseModal').html(response);
        });
    });
</script>