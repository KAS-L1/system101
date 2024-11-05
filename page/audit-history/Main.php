<?php
include_once('api/middleware/role_access.php');

// Check if the database connection is established
if (!isset($DB)) {
    die("Error: Database connection not initialized.");
}

// Array to store combined audit history data from various tables
$auditHistoryData = [];

// Retrieve data from audit_schedule table
$auditSchedules = $DB->SELECT("audit_schedule", "audit_id, audit_type, status, scheduled_date AS change_date, remarks", "ORDER BY scheduled_date DESC");
foreach ($auditSchedules as $schedule) {
    $auditHistoryData[] = [
        'source' => 'Audit Schedule',
        'id' => $schedule['audit_id'],
        'status' => $schedule['status'],
        'change_date' => $schedule['change_date'],
        'remarks' => $schedule['remarks'],
    ];
}

// Retrieve data from audit_finding table
$auditFindings = $DB->SELECT("audit_finding", "finding_id AS id, audit_id, finding_type AS source, status, description AS remarks, NOW() AS change_date", "ORDER BY finding_id DESC");
foreach ($auditFindings as $finding) {
    $auditHistoryData[] = [
        'source' => 'Audit Finding',
        'id' => $finding['id'],
        'status' => $finding['status'],
        'change_date' => $finding['change_date'],
        'remarks' => $finding['remarks'],
    ];
}

// Retrieve data from audit_history table
$auditHistories = $DB->SELECT("audit_history", "history_id AS id, audit_id, status, change_date, remarks", "ORDER BY change_date DESC");
foreach ($auditHistories as $history) {
    $auditHistoryData[] = [
        'source' => 'Audit History',
        'id' => $history['id'],
        'status' => $history['status'],
        'change_date' => $history['change_date'],
        'remarks' => $history['remarks'],
    ];
}

// Retrieve data from audit_logs table
$auditLogs = $DB->SELECT("audit_logs", "log_id AS id, audit_id, action AS status, timestamp AS change_date, details AS remarks", "ORDER BY timestamp DESC");
foreach ($auditLogs as $log) {
    $auditHistoryData[] = [
        'source' => 'Audit Log',
        'id' => $log['id'],
        'status' => $log['status'],
        'change_date' => $log['change_date'],
        'remarks' => $log['remarks'],
    ];
}

// Sort combined data by change_date in descending order
usort($auditHistoryData, function ($a, $b) {
    return strtotime($b['change_date']) - strtotime($a['change_date']);
});
?>

<!-- Audit History Table Section -->
<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-light text-success">
            <h5 class="card-title mb-0">Audit History</h5>
            <div>
                <button class="btn btn-success" onclick="exportFilteredPDF()">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </button>

                <button class="btn btn-primary" id="filterHistoryBtn"><i class="bi bi-filter"></i> Filter History</button>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="card-body">
            <div id="filterSection" style="display:none;">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="filterSource" class="form-label">Source</label>
                        <select id="filterSource" class="form-select">
                            <option value="">All</option>
                            <option value="Audit Schedule">Audit Schedule</option>
                            <option value="Audit Finding">Audit Finding</option>
                            <!-- <option value="Audit History">Audit History</option> -->
                            <option value="Audit Log">Audit Log</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="filterStatus" class="form-label">Status</label>
                        <select id="filterStatus" class="form-select">
                            <option value="">All</option>
                            <option value="Scheduled">Scheduled</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                            <option value="Cancelled">Cancelled</option>
                            <option value="Open">Open</option>
                            <option value="Resolved">Resolved</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="filterDate" class="form-label">Date Range</label>
                        <div class="input-group">
                            <input type="date" id="filterStartDate" class="form-control">
                            <input type="date" id="filterEndDate" class="form-control">
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" id="applyFilter">Apply Filter</button>
                <button class="btn btn-secondary" id="clearFilter">Clear Filter</button>
            </div>

            <!-- Audit History Table -->
            <div class="table-responsive mt-3">
                <table id="auditHistoryTable" class="table table-bordered table-hover table-sm shadow-sm">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th>Source</th>
                            <th>ID</th>
                            <th>Status</th>
                            <th>Change Date</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($auditHistoryData as $history): ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $history['source']; ?></td>
                                <td><?= $history['id']; ?></td>
                                <td><?= $history['status']; ?></td>
                                <td><?= $history['change_date']; ?></td>
                                <td><?= $history['remarks']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle filter section visibility
    $('#filterHistoryBtn').click(function() {
        $('#filterSection').toggle();
    });

    // Apply filter
    $('#applyFilter').click(function() {
        const source = $('#filterSource').val();
        const status = $('#filterStatus').val();
        const startDate = $('#filterStartDate').val();
        const endDate = $('#filterEndDate').val();

        $('#auditHistoryTable tbody tr').each(function() {
            const rowSource = $(this).find("td:eq(1)").text();
            const rowStatus = $(this).find("td:eq(3)").text();
            const rowDate = $(this).find("td:eq(4)").text();
            const rowDateObj = new Date(rowDate);

            const matchSource = !source || rowSource.includes(source);
            const matchStatus = !status || rowStatus === status;
            const matchStartDate = !startDate || rowDateObj >= new Date(startDate);
            const matchEndDate = !endDate || rowDateObj <= new Date(endDate);

            $(this).toggle(matchSource && matchStatus && matchStartDate && matchEndDate);
        });
    });

    // Clear filter
    $('#clearFilter').click(function() {
        $('#filterSource').val('');
        $('#filterStatus').val('');
        $('#filterStartDate').val('');
        $('#filterEndDate').val('');
        $('#auditHistoryTable tbody tr').show();
    });

    // Export table to CSV
    $('#exportHistoryCsv').click(function() {
        let csvContent = "data:text/csv;charset=utf-8,";

        // Check if table has data
        const rows = $('#auditHistoryTable tbody tr:visible');
        if (rows.length === 0) {
            alert("No data available for export.");
            return;
        }

        // Extract headers
        $('#auditHistoryTable thead tr').each(function() {
            const rowData = $(this).find("th").map(function() {
                return `"${$(this).text().trim()}"`;
            }).get().join(",");
            csvContent += rowData + "\n";
        });

        // Extract visible data rows
        rows.each(function() {
            const rowData = $(this).find("td").map(function() {
                return `"${$(this).text().trim()}"`;
            }).get().join(",");
            csvContent += rowData + "\n";
        });

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "audit_history.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });

    // Function to capture filter values and redirect to PDF export with query parameters
    function exportFilteredPDF() {
        const source = $('#filterSource').val();
        const status = $('#filterStatus').val();
        const startDate = $('#filterStartDate').val();
        const endDate = $('#filterEndDate').val();

        // Construct URL with query parameters
        let url = `/api/audit-history/export_history_pdf.php?source=${source}&status=${status}&startDate=${startDate}&endDate=${endDate}`;

        // Redirect to the export PDF page
        window.location.href = url;
    }
</script>