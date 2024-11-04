<?php require("../../app/init.php"); ?>

<!-- Modal: Add Audit Schedule -->
<div class="modal fade" id="addAuditScheduleModal" tabindex="-1" aria-labelledby="addAuditScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAuditScheduleModalLabel">Add New Audit Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add Audit Schedule Form -->
                <form id="formAddAuditSchedule">
                    <!-- Audit Type Field -->
                    <div class="mb-3">
                        <label for="audit_type" class="form-label">Audit Type</label>
                        <select class="form-control" name="audit_type" id="audit_type" required>
                            <option value="Compliance">Compliance</option>
                            <option value="Operational">Operational</option>
                            <option value="Quality Assurance">Quality Assurance</option>
                            <option value="Financial">Financial</option>
                            <option value="Performance">Performance</option>
                        </select>
                    </div>

                    <!-- Scheduled Date and Time Fields -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="scheduled_date" class="form-label">Scheduled Date</label>
                            <input type="date" name="scheduled_date" id="scheduled_date" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="scheduled_time" class="form-label">Scheduled Time</label>
                            <input type="time" name="scheduled_time" id="scheduled_time" class="form-control" required>
                        </div>
                    </div>

                    <!-- Department Field -->
                    <div class="mb-3">
                        <label for="department" class="form-label">Department</label>
                        <input type="text" name="department" id="department" class="form-control" required>
                    </div>

                    <!-- Remarks Field -->
                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea name="remarks" id="remarks" class="form-control" rows="3" placeholder="Optional remarks or additional instructions"></textarea>
                    </div>

                    <!-- Modal Footer with Buttons -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="responseModal"></div>

<!-- JavaScript for Handling Add Audit Schedule Form Submission -->
<script>
    $('#formAddAuditSchedule').submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        var formData = $(this).serialize(); // Serialize form data

        // AJAX request to add audit schedule
        $.post("api/audit-schedule/create.php", formData, function(response) {
            $('#responseModal').html(response);
        });
    });
</script>