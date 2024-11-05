<?php
// Include the TCPDF library and database connection
require_once '../tcpdf/vendor/autoload.php';
require_once '../../app/init.php'; // Include your database connection

// Check if the database connection is established
if (!isset($DB)) {
    die("Error: Database connection not initialized.");
}

// Retrieve filter parameters
$sourceFilter = $_GET['source'] ?? '';
$statusFilter = $_GET['status'] ?? '';
$startDate = $_GET['startDate'] ?? '';
$endDate = $_GET['endDate'] ?? '';

// Array to store combined audit history data
$auditHistoryData = [];

// Helper function to apply filters
function applyFilters($row, $sourceFilter, $statusFilter, $startDate, $endDate)
{
    if ($sourceFilter && strpos($row['source'], $sourceFilter) === false) return false;
    if ($statusFilter && $row['status'] != $statusFilter) return false;
    if ($startDate && strtotime($row['change_date']) < strtotime($startDate)) return false;
    if ($endDate && strtotime($row['change_date']) > strtotime($endDate)) return false;
    return true;
}

// Retrieve data from audit_schedule table
$auditSchedules = $DB->SELECT("audit_schedule", "audit_id, audit_type, status, scheduled_date AS change_date, remarks", "ORDER BY scheduled_date DESC");
foreach ($auditSchedules as $schedule) {
    $row = [
        'source' => 'Audit Schedule',
        'id' => $schedule['audit_id'],
        'status' => $schedule['status'],
        'change_date' => $schedule['change_date'],
        'remarks' => $schedule['remarks'],
    ];
    if (applyFilters($row, $sourceFilter, $statusFilter, $startDate, $endDate)) {
        $auditHistoryData[] = $row;
    }
}

// Similar logic for other tables
// Retrieve data from audit_finding table
$auditFindings = $DB->SELECT("audit_finding", "finding_id AS id, audit_id, finding_type AS source, status, description AS remarks, NOW() AS change_date", "ORDER BY finding_id DESC");
foreach ($auditFindings as $finding) {
    $row = [
        'source' => 'Audit Finding',
        'id' => $finding['id'],
        'status' => $finding['status'],
        'change_date' => $finding['change_date'],
        'remarks' => $finding['remarks'],
    ];
    if (applyFilters($row, $sourceFilter, $statusFilter, $startDate, $endDate)) {
        $auditHistoryData[] = $row;
    }
}

// Retrieve data from audit_history table
$auditHistories = $DB->SELECT("audit_history", "history_id AS id, audit_id, status, change_date, remarks", "ORDER BY change_date DESC");
foreach ($auditHistories as $history) {
    $row = [
        'source' => 'Audit History',
        'id' => $history['id'],
        'status' => $history['status'],
        'change_date' => $history['change_date'],
        'remarks' => $history['remarks'],
    ];
    if (applyFilters($row, $sourceFilter, $statusFilter, $startDate, $endDate)) {
        $auditHistoryData[] = $row;
    }
}

// Retrieve data from audit_logs table
$auditLogs = $DB->SELECT("audit_logs", "log_id AS id, audit_id, action AS status, timestamp AS change_date, details AS remarks", "ORDER BY timestamp DESC");
foreach ($auditLogs as $log) {
    $row = [
        'source' => 'Audit Log',
        'id' => $log['id'],
        'status' => $log['status'],
        'change_date' => $log['change_date'],
        'remarks' => $log['remarks'],
    ];
    if (applyFilters($row, $sourceFilter, $statusFilter, $startDate, $endDate)) {
        $auditHistoryData[] = $row;
    }
}

// Sort combined data by change_date in descending order
usort($auditHistoryData, function ($a, $b) {
    return strtotime($b['change_date']) - strtotime($a['change_date']);
});

// Initialize TCPDF and generate PDF as before
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Audit Management System');
$pdf->SetTitle('Filtered Audit History Report');
$pdf->SetHeaderData('', 0, 'Audit History Report', 'Generated on ' . date('Y-m-d'));
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(10, 20, 10);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Add a page
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 10, 'Audit History (Filtered)', 0, 1, 'C');

$html = '<table border="1" cellpadding="4">
            <thead>
                <tr>
                    <th style="background-color:#198754;">#</th>
                    <th style="background-color:#198754;">Source</th>
                    <th style="background-color:#198754;">ID</th>
                    <th style="background-color:#198754;">Status</th>
                    <th style="background-color:#198754;">Change Date</th>
                    <th style="background-color:#198754;">Remarks</th>
                </tr>
            </thead>
            <tbody>';

$i = 1;
foreach ($auditHistoryData as $row) {
    $html .= '<tr>
                <td>' . $i++ . '</td>
                <td>' . htmlspecialchars($row['source']) . '</td>
                <td>' . htmlspecialchars($row['id']) . '</td>
                <td>' . htmlspecialchars($row['status']) . '</td>
                <td>' . htmlspecialchars($row['change_date']) . '</td>
                <td>' . htmlspecialchars($row['remarks']) . '</td>
              </tr>';
}

$html .= '</tbody></table>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('filtered_audit_history.pdf', 'I');
exit;
