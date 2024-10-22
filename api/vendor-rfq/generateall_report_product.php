<?php
// Include the TCPDF library and init.php for database connection
require_once '../tcpdf/vendor/autoload.php';
require_once '../../app/init.php'; // Include database connection

// Create new PDF document
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator('Logistic 2');
$pdf->SetAuthor('Hotel Paradise');
$pdf->SetTitle('Product Catalog Report');
$pdf->SetSubject('Generated Report');
$pdf->SetKeywords('TCPDF, PDF, report, product');

// Set default header data
$pdf->SetHeaderData('', 0, 'Product Catalog Report', 'Generated by Your Company Name');

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
$pdf->Cell(0, 15, 'Product Catalog Report', 0, 1, 'C');
$pdf->Ln(5); // Add some space after title

$pdf->SetFont('dejavusans', '', 10);
$pdf->Write(0, 'Generated report for all products.', '', 0, 'C', true);
$pdf->Ln(5);

// Fetch data from the database (vendor_products table)
$products = $DB->SELECT("vendor_products", "*", "ORDER BY product_id DESC");

// HTML content for the table
$html = '<table border="1" cellpadding="5">
         <thead>
             <tr>
                 <th>#</th>
                 <th>Product ID</th>
                 <th>Vendor Name</th>
                 <th>Product Name</th>
                 <th>Description</th>
                 <th>Unit Price</th>
                 <th>Availability</th>
             </tr>
         </thead>
         <tbody>';

// Populate the table with data from the database
$i = 1;
foreach ($products as $product) {
    // Fetch Vendor name from the vendors table
    $vendor_name = $DB->SELECT_ONE_WHERE("vendors", "vendor_name", array("vendor_id" => $product['vendor_id']));
    $vendorName = CHARS($vendor_name['vendor_name'] ?? 'Unknown Vendor');

    // Add the row to the table
    $html .= '<tr>
             <td>' . $i++ . '</td>
             <td>' . CHARS($product['product_id'] ?? '') . '</td>
             <td>' . $vendorName . '</td>
             <td>' . CHARS($product['product_name'] ?? '') . '</td>
             <td>' . CHARS($product['description'] ?? '') . '</td>
             <td>₱' . number_format($product['unit_price'] ?? 0, 2) . '</td>
             <td>' . CHARS($product['availability'] ?? '') . '</td>
         </tr>';
}

$html .= '</tbody></table>';

// Print the HTML content to the PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF to the browser
$pdf->Output('product_catalog_report.pdf', 'I'); // 'I' to display in the browser, 'D' to force download
?>
