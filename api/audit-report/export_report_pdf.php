<?php
require_once '../tcpdf/vendor/autoload.php';
require_once '../../app/init.php';

// Check if the database connection is established
if (!isset($DB)) {
    die("Error: Database connection not initialized.");
}

// Retrieve audit summary data for severity
$auditSummary = $DB->SELECT("audit_finding", "severity, COUNT(*) as count", "GROUP BY severity");

// Retrieve recent audit findings
$auditFindings = $DB->SELECT("audit_finding", "finding_id, audit_id, finding_type, severity, description, status", "ORDER BY finding_id DESC LIMIT 10");

// Initialize TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Audit Management System');
$pdf->SetTitle('Audit Report');
$pdf->SetHeaderData('', 0, 'Audit Report', 'Generated on ' . date('Y-m-d'));
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

// Report title
$pdf->Cell(0, 10, 'Audit Report Summary', 0, 1, 'C');

// Severity Summary Table
$html = '<h3>Severity Summary</h3>
         <table border="1" cellpadding="4">
            <thead>
                <tr style="background-color:#198754;">
                    <th>Severity</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>';

foreach ($auditSummary as $summary) {
    $html .= '<tr>
                <td>' . htmlspecialchars($summary['severity']) . '</td>
                <td>' . htmlspecialchars($summary['count']) . '</td>
              </tr>';
}

$html .= '</tbody></table>';

// Recent Findings Table
$html .= '<h3>Recent Audit Findings</h3>
         <table border="1" cellpadding="4">
            <thead>
                <tr style="background-color:#198754;">
                    <th>Finding ID</th>
                    <th>Audit ID</th>
                    <th>Finding Type</th>
                    <th>Severity</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>';

foreach ($auditFindings as $finding) {
    $html .= '<tr>
                <td>' . htmlspecialchars($finding['finding_id']) . '</td>
                <td>' . htmlspecialchars($finding['audit_id']) . '</td>
                <td>' . htmlspecialchars($finding['finding_type']) . '</td>
                <td>' . htmlspecialchars($finding['severity']) . '</td>
                <td>' . htmlspecialchars($finding['description']) . '</td>
                <td>' . htmlspecialchars($finding['status']) . '</td>
              </tr>';
}

$html .= '</tbody></table>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('audit_report.pdf', 'I'); // 'D' for download; change to 'I' to display in browser
exit;
