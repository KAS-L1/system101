<?php
include_once('api/middleware/role_access.php');
// Retrieve all Audit Findings from the `audit_finding` table
$auditFindings = $DB->SELECT("audit_finding", "*", "ORDER BY finding_id DESC");
?>

<!-- Audit Findings Table Section -->
<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-light text-success">
            <h5 class="card-title mb-0">Audit Findings Management</h5>
            <!-- Button to Add Audit Finding -->
            <div>
                <button class="btn btn-primary" id="btnAddFinding">
                    <i class="bi bi-plus"></i> Add Finding
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTableFinding" class="table table-bordered table-hover table-sm shadow-sm">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th>Finding ID</th>
                            <th>Audit ID</th>
                            <th>Finding Type</th>
                            <th>Description</th>
                            <th>Severity</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($auditFindings as $finding) {
                            $finding_id = htmlspecialchars($finding['finding_id']);
                            $audit_id = htmlspecialchars($finding['audit_id']);
                            $finding_type = htmlspecialchars($finding['finding_type']);
                            $description = htmlspecialchars($finding['description']);
                            $severity = htmlspecialchars($finding['severity']);
                            $status = htmlspecialchars($finding['status']);

                            // Badge class for different statuses
                            $badgeClass = match ($status) {
                                'Resolved' => 'bg-success text-light',
                                'In Progress' => 'bg-light text-dark',
                                default => 'bg-secondary text-light'
                            };
                        ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $finding_id; ?></td>
                                <td><?= $audit_id; ?></td>
                                <td><?= $finding_type; ?></td>
                                <td><?= $description; ?></td>
                                <td><?= $severity; ?></td>
                                <td><span class="badge <?= $badgeClass; ?>"><?= $status; ?></span></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <!-- View Details Button -->
                                        <button class="btn btn-sm btn-light shadow-sm viewFindingDetails" data-finding_id="<?= $finding_id; ?>">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        <!-- Update Status Button -->
                                        <?php if ($status == "Open" || $status == "In Progress") { ?>
                                            <button class="btn btn-sm btn-light shadow-sm updateFindingStatus" data-finding_id="<?= $finding_id; ?>">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button class="btn btn-sm btn-light shadow-sm" disabled>
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Add Finding Button Click Event
    $('#btnAddFinding').click(function() {
        const auditId = $(this).data('audit_id'); // Assuming the button has data-audit_id attribute
        $.post('api/audit-findings/add_finding_modal.php', {
            audit_id: auditId
        }, function(res) {
            $('#responseModal').html(res);
            $('#addFindingModal').modal('show');
        });
    });

    // View Finding Details Event
    $('.viewFindingDetails').click(function() {
        const finding_id = $(this).data('finding_id');
        $.post('api/audit-findings/view_finding_modal.php', {
            finding_id
        }, function(response) {
            $('#responseModal').html(response);
            $('#viewFindingModal').modal('show');
        });
    });

    // Update Finding Status Event
    $('.updateFindingStatus').click(function() {
        const finding_id = $(this).data('finding_id');
        $.post('api/audit-findings/update_status_modal.php', {
            finding_id
        }, function(response) {
            $('#responseModal').html(response);
            $('#updateFindingStatusModal').modal('show');
        });
    });
</script>

<!-- Placeholder for dynamically loaded modals -->
<div id="responseModal"></div>
<div id="response"></div>