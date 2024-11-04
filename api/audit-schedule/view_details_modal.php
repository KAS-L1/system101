<?php
require("../../app/init.php");

// Retrieve Audit ID from POST request
$audit_id = $_POST['audit_id'];
$where = array("audit_id" => $audit_id);

// Fetch the Audit Schedule details from the database
$auditDetails = $DB->SELECT_ONE_WHERE("audit_schedule", "*", $where);
?>

<!-- View Details Modal -->
<div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewDetailsModalLabel">Audit Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label"><strong>Audit ID:</strong></label>
                    <p><?= htmlspecialchars($auditDetails['audit_id']) ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Audit Type:</strong></label>
                    <p><?= htmlspecialchars($auditDetails['audit_type']) ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Scheduled Date:</strong></label>
                    <p><?= htmlspecialchars($auditDetails['scheduled_date']) ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Scheduled Time:</strong></label>
                    <p><?= htmlspecialchars($auditDetails['scheduled_time']) ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Status:</strong></label>
                    <p><?= htmlspecialchars($auditDetails['status']) ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Department:</strong></label>
                    <p><?= htmlspecialchars($auditDetails['department']) ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Remarks:</strong></label>
                    <p><?= htmlspecialchars($auditDetails['remarks']) ?></p>
                </div>
                <!-- Add any other fields you want to display here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>