<?php
require("../../app/init.php");

// Fetch all active audits from the `audit_schedule` table
$auditSchedules = $DB->SELECT("audit_schedule", "*", "ORDER BY audit_id DESC");
?>

<!-- Add Finding Modal -->
<div class="modal fade" id="addFindingModal" tabindex="-1" aria-labelledby="addFindingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFindingModalLabel">Add Audit Finding</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add Finding Form -->
                <form id="formAddFinding">
                    <!-- Audit ID Dropdown to link the finding to an existing audit schedule -->
                    <div class="mb-3">
                        <label for="audit_id" class="form-label">Audit ID</label>
                        <select class="form-select" id="audit_id" name="audit_id" required>
                            <option value="" disabled selected>Select Audit</option>
                            <?php foreach ($auditSchedules as $audit): ?>
                                <option value="<?= htmlspecialchars($audit['audit_id']) ?>">
                                    <?= htmlspecialchars($audit['audit_id'] . " - " . $audit['audit_type'] . " (" . $audit['scheduled_date'] . ")") ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Finding Type -->
                    <div class="mb-3">
                        <label for="finding_type" class="form-label">Finding Type</label>
                        <select class="form-select" id="finding_type" name="finding_type" required>
                            <option value="Non-Compliance">Non-Compliance</option>
                            <option value="Observation">Observation</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
                    </div>

                    <!-- Severity -->
                    <div class="mb-3">
                        <label for="severity" class="form-label">Severity</label>
                        <select class="form-select" id="severity" name="severity" required>
                            <option value="Critical">Critical</option>
                            <option value="High">High</option>
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>
                        </select>
                    </div>

                    <!-- Recommendations -->
                    <div class="mb-3">
                        <label for="recommendations" class="form-label">Recommendations</label>
                        <textarea id="recommendations" name="recommendations" class="form-control" rows="3"></textarea>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Finding</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // AJAX for submitting the Add Finding form
    $('#formAddFinding').submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        var formData = $(this).serialize(); // Serialize form data

        // AJAX request to create finding
        $.post("api/audit-findings/add_finding.php", formData, function(response) {
            $('#responseModal').html(response); // Display response in the modal
            $('#addFindingModal').modal('hide'); // Close the modal after submission

            // Show success or error message based on response
            if (response.includes("success")) {
                swal("Success", "Audit finding added successfully", "success");
            } else {
                swal("Error", "Failed to add audit finding", "error");
            }

            // Optionally, reload the findings table to show the new entry
            $('#dataTableFinding').DataTable().ajax.reload();
        }).fail(function() {
            // Handle AJAX errors
            swal("Error", "An unexpected error occurred", "error");
        });
    });
</script>