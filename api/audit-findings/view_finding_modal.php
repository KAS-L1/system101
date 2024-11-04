<?php
require("../../app/init.php");

// Get the finding ID
$finding_id = $_POST['finding_id'];
$where = array("finding_id" => $finding_id);

// Fetch finding details
$findingDetails = $DB->SELECT_ONE_WHERE("audit_finding", "*", $where);
?>

<!-- View Finding Details Modal -->
<div class="modal fade" id="viewFindingModal" tabindex="-1" aria-labelledby="viewFindingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewFindingModalLabel">Finding Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Finding ID:</strong> <?= htmlspecialchars($findingDetails['finding_id']) ?></p>
                <p><strong>Audit ID:</strong> <?= htmlspecialchars($findingDetails['audit_id']) ?></p>
                <p><strong>Finding Type:</strong> <?= htmlspecialchars($findingDetails['finding_type']) ?></p>
                <p><strong>Description:</strong> <?= htmlspecialchars($findingDetails['description']) ?></p>
                <p><strong>Severity:</strong> <?= htmlspecialchars($findingDetails['severity']) ?></p>
                <p><strong>Recommendations:</strong> <?= htmlspecialchars($findingDetails['recommendations']) ?></p>
                <p><strong>Status:</strong> <?= htmlspecialchars($findingDetails['status']) ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>