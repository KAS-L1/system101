<?php
// Include the TCPDF library and init.php for database connection
require_once '../tcpdf/vendor/autoload.php';
require_once '../../app/init.php'; // Include database connection

// Create new PDF document
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator('Logistic 2');
$pdf->SetAuthor('Hotel Paradise');
$pdf->SetTitle('Invoice Payment Report');
$pdf->SetSubject('Generated Invoice Report');
$pdf->SetKeywords('TCPDF, PDF, report, invoice, payment');

// Set default header data
$pdf->SetHeaderData('', 0, 'Invoice Payment Report', 'Generated by Hotel Paradise');

// Set header and footer fonts
$pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
$pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Add a page
$pdf->AddPage();

// Set font for content - Use DejaVu Sans for better Unicode support
$pdf->SetFont('dejavusans', '', 10);

// Title of the report
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 15, 'Invoice Report', 0, 1, 'C');
$pdf->Ln(5); // Add some space after title

$pdf->SetFont('dejavusans', '', 10);
$pdf->Write(0, 'Generated report for all Invoices.', '', 0, 'C', true);
$pdf->Ln(5);

// Fetch data from the database (invoice_payments table)
$invoices = $DB->SELECT("invoice_payments", "*", "ORDER BY invoice_id DESC");

// HTML content for the table
$html = '<table border="1" cellpadding="5">
         <thead>
             <tr>
                 <th>#</th>
                 <th>Invoice ID</th>
                 <th>PO ID</th>
                 <th>Vendor Name</th>
                 <th>Amount</th>
                 <th>Payment Terms</th>
                 <th>Payment Status</th>
                 <th>Due Date</th>
                 <th>Remarks</th>
             </tr>
         </thead>
         <tbody>';

// Populate the table with data from the database
$i = 1;
foreach ($invoices as $invoice) {
    // Fetch the vendor's name from the `purchaseorder` table using `po_id`
    $purchaseOrder = $DB->SELECT_ONE_WHERE("purchaseorder", "vendor_name", array("po_id" => $invoice['po_id']));

    // Sanitize and set the vendor name, with a fallback if the vendor is not found
    $vendorName = CHARS($purchaseOrder['vendor_name'] ?? 'Unknown Vendor');

    // Add the row to the table with the Peso sign in UTF-8
    $html .= '<tr>
                 <td>' . $i++ . '</td>
                 <td>' . CHARS($invoice['invoice_id'] ?? '') . '</td>
                 <td>' . CHARS($invoice['po_id'] ?? '') . '</td>
                 <td>' . $vendorName . '</td>
                 <td>&#8369;' . number_format($invoice['amount'] ?? 0, 2) . '</td>
                 <td>' . CHARS($invoice['payment_terms'] ?? '') . '</td>
                 <td>' . CHARS($invoice['payment_status'] ?? '') . '</td>
                 <td>' . CHARS($invoice['due_date'] ?? '') . '</td>
                 <td>' . CHARS($invoice['remarks'] ?? 'No Remarks') . '</td>
             </tr>';
}

$html .= '</tbody></table>';

// Print the HTML content to the PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF to the browser
$pdf->Output('invoice_report.pdf', 'I'); // 'I' to display in the browser, 'D' to force download
