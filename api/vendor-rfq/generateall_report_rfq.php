<?php
// Include the TCPDF library and init.php for database connection
require_once '../tcpdf/vendor/autoload.php';
require_once '../../app/init.php'; // Include database connection

// Create new PDF document
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator('Logistic 2');
$pdf->SetAuthor('Hotel Paradise');
$pdf->SetTitle('RFQ Report');
$pdf->SetSubject('Generated Report');
$pdf->SetKeywords('TCPDF, PDF, report, RFQ');

// Set default header data
$pdf->SetHeaderData('', 0, 'RFQ Report', 'Generated by Hotel Paradise Logistic 2');

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
$pdf->Cell(0, 15, 'RFQ Report', 0, 1, 'C');
$pdf->Ln(5); // Add some space after title

$pdf->SetFont('dejavusans', '', 10);
$pdf->Write(0, 'Generated report for all RFQs.', '', 0, 'C', true);
$pdf->Ln(5);

// Fetch data from the database (rfqs table)
$rfqs = $DB->SELECT("rfqs", "*", "ORDER BY rfq_id DESC");

// HTML content for the table
$html = '<table border="1" cellpadding="5">
         <thead>
             <tr>
                 <th>#</th>
                 <th>RFQ ID</th>
                 <th>Vendor Name</th>
                 <th>Product Name</th>
                 <th>Requested Quantity</th>
                 <th>Quoted Price</th>
                 <th>Status</th>
                 <th>Response Date</th>
                 <th>Remarks</th>
             </tr>
         </thead>
         <tbody>';

// Populate the table with data from the database
$i = 1;
foreach ($rfqs as $rfq) {
    // Fetch Vendor and Product names from their respective tables
    $vendor_name = $DB->SELECT_ONE_WHERE("vendors", "vendor_name", array("vendor_id" => $rfq['vendor_id']));
    $product_name = $DB->SELECT_ONE_WHERE("vendor_products", "product_name", array("product_id" => $rfq['product_id']));

    $statusBadge = $rfq['rfq_status'] == 'Approved' ? 'Approved' :
                   ($rfq['rfq_status'] == 'Rejected' ? 'Rejected' : 'Pending');
    
    // Add the row to the table with the Peso sign in UTF-8
    $html .= '<tr>
             <td>' . $i++ . '</td>
             <td>' . CHARS($rfq['rfq_id'] ?? '') . '</td>
             <td>' . CHARS($vendor_name['vendor_name'] ?? 'Unknown Vendor') . '</td>
             <td>' . CHARS($product_name['product_name'] ?? 'Unknown Product') . '</td>
             <td>' . CHARS($rfq['requested_quantity'] ?? '') . '</td>
             <td>&#8369;' . number_format($rfq['quoted_price'] ?? 0, 2) . '</td>
             <td>' . $statusBadge . '</td>
             <td>' . CHARS($rfq['response_date'] ?? '') . '</td>
             <td>' . CHARS($rfq['remarks'] ?? 'No Remarks') . '</td>
         </tr>';
}

$html .= '</tbody></table>';

// Print the HTML content to the PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF to the browser
$pdf->Output('rfq_report.pdf', 'I'); // 'I' to display in the browser, 'D' to force download

?>
