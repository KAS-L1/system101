<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/app/init.php');

// Check if the database connection is established
if (!isset($DB)) {
    die("Error: Database connection not initialized.");
}

// Initialize variables to avoid undefined variable errors
$auditSummary = [];
$auditFindings = [];

// Retrieve audit data summary (count by severity) and handle any query issues
$auditSummary = $DB->SELECT("audit_finding", "severity, COUNT(*) as count", "GROUP BY severity");
if (!$auditSummary) {
    $auditSummary = []; // Ensure $auditSummary is an empty array if the query fails or returns no results
}

// Retrieve recent audit findings details for display
$auditFindings = $DB->SELECT("audit_finding", "finding_id, audit_id, finding_type, severity, description, status", "ORDER BY finding_id DESC LIMIT 10");
if (!$auditFindings) {
    $auditFindings = []; // Ensure $auditFindings is an empty array if the query fails or returns no results
}

?>
<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-light text-success">
            <h5 class="card-title mb-0">Audit Report Summary</h5>
            <button class="btn btn-success" onclick="window.location.href='/api/audit-report/export_report_pdf.php'">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </button>
        </div>

        <div class="card-body">
            <!-- Summary Section -->
            <h5 class="text-success">Severity Summary</h5>
            <table class="table table-bordered table-sm">
                <thead class="table-success">
                    <tr>
                        <th>Severity</th>
                        <th>Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($auditSummary) > 0): ?>
                        <?php foreach ($auditSummary as $summary): ?>
                            <tr>
                                <td><?= htmlspecialchars($summary['severity']); ?></td>
                                <td><?= htmlspecialchars($summary['count']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" class="text-center">No data available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Recent Findings Section -->
            <h5 class="text-success">Recent Audit Findings</h5>
            <table class="table table-bordered table-hover table-sm">
                <thead class="table-success">
                    <tr>
                        <th>Finding ID</th>
                        <th>Audit ID</th>
                        <th>Finding Type</th>
                        <th>Severity</th>
                        <th>Description</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($auditFindings) > 0): ?>
                        <?php foreach ($auditFindings as $finding): ?>
                            <?php
                            // Badge class for different statuses
                            $badgeClass = 'bg-secondary text-light'; // default class
                            if ($finding['status'] === 'Resolved') {
                                $badgeClass = 'bg-success text-light';
                            } elseif ($finding['status'] === 'In Progress') {
                                $badgeClass = 'bg-light text-dark';
                            } elseif ($finding['status'] === 'Open') {
                                $badgeClass = 'bg-secondary text-light';
                            }
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($finding['finding_id']); ?></td>
                                <td><?= htmlspecialchars($finding['audit_id']); ?></td>
                                <td><?= htmlspecialchars($finding['finding_type']); ?></td>
                                <td><?= htmlspecialchars($finding['severity']); ?></td>
                                <td><?= htmlspecialchars($finding['description']); ?></td>
                                <td><span class="badge <?= $badgeClass; ?>"><?= htmlspecialchars($finding['status']); ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No recent findings available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>