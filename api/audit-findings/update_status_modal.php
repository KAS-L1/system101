<?php
require("../../app/init.php");

// Retrieve Finding ID from POST request
$finding_id = $_POST['finding_id'];

// Fetch the current finding details
$finding = $DB->SELECT_ONE_WHERE("audit_finding", "*", ["finding_id" => $finding_id]);

// Define a static list of status options
$statusOptions = ["Open", "In Progress", "Resolved"];
?>

<!-- Update Finding Status Modal -->
<div class="modal fade" id="updateFindingStatusModal" tabindex="-1" aria-labelledby="updateFindingStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateFindingStatusModalLabel">Update Finding Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Update Finding Status Form -->
                <form id="formUpdateFindingStatus">
                    <input type="hidden" name="finding_id" value="<?= htmlspecialchars($finding_id) ?>">

                    <!-- Status Field -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <?php foreach ($statusOptions as $status): ?>
                                <option value="<?= htmlspecialchars($status) ?>" <?= $finding['status'] === $status ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($status) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // AJAX for submitting the Update Finding Status form
    $('#formUpdateFindingStatus').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        // AJAX request to update finding status
        $.post("api/audit-findings/update_finding_status.php", formData, function(response) {
            $('#updateFindingStatusModal').modal('hide'); // Close modal after submission
            $('#responseModal').html(response); // Display response in the modal area
        }).fail(function() {
            swal("Error", "An unexpected error occurred", "error");
        });
    });
</script>