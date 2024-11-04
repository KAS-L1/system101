<?php
require("../../app/init.php");

// Retrieve all audit logs ordered by timestamp (most recent first)
$auditLogs = $DB->SELECT("audit_logs", "*", "ORDER BY timestamp DESC");
?>

<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-light text-success">
            <h5 class="card-title mb-0">Audit Logs</h5>
            <!-- Export buttons -->
            <div>
                <button class="btn btn-success" id="exportCsv">Export CSV</button>
                <button class="btn btn-danger" id="exportPdf">Export PDF</button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="auditLogsTable" class="table table-bordered table-hover table-sm shadow-sm">
                    <thead class="table-success">
                        <tr>
                            <th>Log ID</th>
                            <th>Audit ID</th>
                            <th>Action</th>
                            <th>Timestamp</th>
                            <th>User ID</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($auditLogs as $log): ?>
                            <tr>
                                <td><?= htmlspecialchars($log['log_id']) ?></td>
                                <td><?= htmlspecialchars($log['audit_id']) ?></td>
                                <td><?= htmlspecialchars($log['action']) ?></td>
                                <td><?= htmlspecialchars($log['timestamp']) ?></td>
                                <td><?= htmlspecialchars($log['user_id']) ?></td>
                                <td><?= htmlspecialchars($log['details']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Export table to CSV with jQuery
    $('#exportCsv').on('click', function() {
        let csvContent = "data:text/csv;charset=utf-8,";
        $('#auditLogsTable tr').each(function() {
            const rowData = $(this).find("td, th").map(function() {
                return `"${$(this).text()}"`;
            }).get().join(",");
            csvContent += rowData + "\n";
        });

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "audit_logs.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });

    // Export table to PDF with jQuery (requires jsPDF library)
    $('#exportPdf').on('click', function() {
        const doc = new jsPDF();
        doc.autoTable({
            html: '#auditLogsTable'
        });
        doc.save('audit_logs.pdf');
    });
</script>