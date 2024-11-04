<?php
require("../../app/init.php");

// Retrieve Audit ID from POST request
$audit_id = $_POST['audit_id'];
$where = array("audit_id" => $audit_id);

// Fetch the Audit Schedule details from the database
$auditSchedule = $DB->SELECT_ONE_WHERE("audit_schedule", "*", $where);
?>

<!-- Reschedule Audit Modal -->
<div class="modal fade" id="rescheduleAuditModal" tabindex="-1" aria-labelledby="rescheduleAuditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rescheduleAuditModalLabel">Reschedule Audit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Reschedule Audit Form -->
                <form id="formRescheduleAudit">
                    <!-- Hidden field for Audit ID -->
                    <input type="hidden" name="audit_id" value="<?= $auditSchedule['audit_id'] ?>">

                    <!-- Audit ID (non-editable) -->
                    <div class="mb-3">
                        <label for="audit_id_display" class="form-label">Audit ID</label>
                        <input type="text" class="form-control" id="audit_id_display" value="<?= $auditSchedule['audit_id'] ?>" readonly>
                    </div>

                    <!-- Audit Type (non-editable) -->
                    <div class="mb-3">
                        <label for="audit_type" class="form-label">Audit Type</label>
                        <input type="text" class="form-control" id="audit_type" value="<?= $auditSchedule['audit_type'] ?>" readonly>
                    </div>

                    <!-- New Scheduled Date -->
                    <div class="mb-3">
                        <label for="new_scheduled_date" class="form-label">New Scheduled Date</label>
                        <input type="date" id="new_scheduled_date" name="new_scheduled_date" class="form-control" value="<?= $auditSchedule['scheduled_date'] ?>" required>
                    </div>

                    <!-- New Scheduled Time -->
                    <div class="mb-3">
                        <label for="new_scheduled_time" class="form-label">New Scheduled Time</label>
                        <input type="time" id="new_scheduled_time" name="new_scheduled_time" class="form-control" value="<?= $auditSchedule['scheduled_time'] ?>" required>
                    </div>

                    <!-- Department (editable) -->
                    <div class="mb-3">
                        <label for="department" class="form-label">Department</label>
                        <input type="text" id="department" name="department" class="form-control" value="<?= $auditSchedule['department'] ?>" required>
                    </div>

                    <!-- Optional Remarks -->
                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea id="remarks" name="remarks" class="form-control" rows="3" placeholder="Optional remarks for rescheduling"><?= $auditSchedule['remarks'] ?></textarea>
                    </div>

                    <!-- Modal Footer with Buttons -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Handling Form Submission -->
<script>
    $('#formRescheduleAudit').submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        var formData = $(this).serialize(); // Serialize form data

        // AJAX request to update Audit Schedule data
        $.post("api/audit/reschedule.php", formData, function(response) {
            $('#responseModal').html(response); // Display response in the modal
        });
    });
</script>