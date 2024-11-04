<?php
include_once('api/middleware/role_access.php');
// Retrieve all Audit Logs with related Audit Schedule data
$auditLogs = $DB->SELECT("audit_logs LEFT JOIN audit_schedule ON audit_logs.audit_id = audit_schedule.audit_id", "audit_logs.*, audit_schedule.audit_type, audit_schedule.scheduled_date, audit_schedule.department", "ORDER BY timestamp DESC");
?>

<!-- Audit Logs Table Section -->
<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-light text-success">
            <h5 class="card-title mb-0">Audit Logs</h5>
            <div>
                <button class="btn btn-success" id="exportCsv">
                    <i class="bi bi-file-earmark-spreadsheet"></i> Export CSV
                </button>
                <button class="btn btn-danger" id="exportPdf">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="auditLogsTable" class="table table-bordered table-hover table-sm shadow-sm">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th>Log ID</th>
                            <th>Audit ID</th>
                            <th>Action</th>
                            <th>Timestamp</th>
                            <th>User ID</th>
                            <th>Details</th>
                            <th>Audit Type</th>
                            <th>Scheduled Date</th>
                            <th>Department</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($auditLogs as $log) {
                            $log_id = htmlspecialchars($log['log_id'] ?? '');
                            $audit_id = htmlspecialchars($log['audit_id'] ?? '');
                            $action = htmlspecialchars($log['action'] ?? '');
                            $timestamp = htmlspecialchars($log['timestamp'] ?? '');
                            $user_id = htmlspecialchars($log['user_id'] ?? '');
                            $details = htmlspecialchars($log['details'] ?? '');
                            $audit_type = htmlspecialchars($log['audit_type'] ?? 'N/A');
                            $scheduled_date = htmlspecialchars($log['scheduled_date'] ?? 'N/A');
                            $department = htmlspecialchars($log['department'] ?? 'N/A');
                        ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $log_id; ?></td>
                                <td><?= $audit_id; ?></td>
                                <td><?= $action; ?></td>
                                <td><?= $timestamp; ?></td>
                                <td><?= $user_id; ?></td>
                                <td><?= $details; ?></td>
                                <td><?= $audit_type; ?></td>
                                <td><?= $scheduled_date; ?></td>
                                <td><?= $department; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Export table to CSV
    $('#exportCsv').click(function() {
        let csvContent = "data:text/csv;charset=utf-8,";

        // Extract headers
        $('#auditLogsTable thead tr').each(function() {
            const rowData = $(this).find("th").map(function() {
                return `"${$(this).text().trim()}"`;
            }).get().join(",");
            csvContent += rowData + "\n";
        });

        // Extract data rows
        $('#auditLogsTable tbody tr').each(function() {
            const rowData = $(this).find("td").map(function() {
                return `"${$(this).text().trim()}"`;
            }).get().join(",");
            csvContent += rowData + "\n";
        });

        // Check if there is data for CSV export
        if (csvContent === "data:text/csv;charset=utf-8,") {
            alert("No data available for export.");
            return;
        }

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "audit_logs.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });

    // Export table to PDF
    $('#exportPdf').click(function() {
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF();
        doc.autoTable({
            html: '#auditLogsTable',
            theme: 'striped',
            headStyles: {
                fillColor: [22, 160, 133]
            },
            margin: {
                top: 20
            }
        });
        doc.save('audit_logs.pdf');
    });
</script>