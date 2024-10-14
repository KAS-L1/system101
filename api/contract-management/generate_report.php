<?php
// Include the necessary libraries and init.php for database connection
require_once '../tcpdf/vendor/autoload.php';
require_once '../../app/init.php';

// Create new PDF document
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator('Your System');
$pdf->SetAuthor('Your Company');
$pdf->SetTitle('Contract Report');
$pdf->SetSubject('Generated Report');
$pdf->SetKeywords('TCPDF, PDF, report, contracts');

// Set header and footer fonts
$pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
$pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Add a page
$pdf->AddPage();

// Title of the report
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 15, 'Contract Report', 0, 1, 'C');
$pdf->Ln(5);

// Set font for content
$pdf->SetFont('dejavusans', '', 10);

// Fetch contract data from the database
$contracts = $DB->SELECT("contracts", "*", "ORDER BY contract_id DESC");

// HTML content for the table
$html = '<table border="1" cellpadding="5">
         <thead>
             <tr>
                 <th>#</th>
                 <th>Contract ID</th>
                 <th>Vendor Name</th>
                 <th>Terms</th>
                 <th>Start Date</th>
                 <th>End Date</th>
                 <th>Status</th>
                 <th>Renewal Date</th>
             </tr>
         </thead>
         <tbody>';

// Populate the table with data from the database
$i = 1;
foreach ($contracts as $contract) {
    $vendor = $DB->SELECT_ONE_WHERE("vendors", "*", array("vendor_id" => $contract['vendor_id']));
    $html .= '<tr>
                 <td>' . $i++ . '</td>
                 <td>' . CHARS($contract['contract_id']) . '</td>
                 <td>' . CHARS($vendor['vendor_name']) . '</td>
                 <td>' . CHARS($contract['contract_terms']) . '</td>
                 <td>' . CHARS($contract['start_date']) . '</td>
                 <td>' . CHARS($contract['end_date']) . '</td>
                 <td>' . CHARS($contract['status']) . '</td>
                 <td>' . CHARS($contract['renewal_date']) . '</td>
             </tr>';
}

$html .= '</tbody></table>';

// Output the table in the PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF
$pdf->Output('contract_report.pdf', 'I'); // 'I' to display in browser, 'D' to download
