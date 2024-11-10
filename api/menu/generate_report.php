<?php
require_once '../tcpdf/vendor/autoload.php';
require_once '../../app/init.php';

// Check if the database connection is established
if (!isset($DB)) {
    die("Error: Database connection not initialized.");
}

// Retrieve all menu items from the database
$menuItems = $DB->SELECT("menu_items", "item_id, item_name, category, description, price, availability, seasonal, event_specific", "ORDER BY item_id ASC");

// Initialize TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Menu Management System');
$pdf->SetTitle('Menu Report');
$pdf->SetHeaderData('', 0, 'Menu Report', 'Generated on ' . date('Y-m-d'));
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
$pdf->Cell(0, 10, 'Menu Items Report', 0, 1, 'C');

// Menu Items Table
$html = '<h3>Menu Items</h3>
         <table border="1" cellpadding="4">
            <thead>
                <tr style="background-color:#198754; color: #fff;">
                    <th>Item ID</th>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Availability</th>
                    <th>Seasonal</th>
                    <th>Event Specific</th>
                </tr>
            </thead>
            <tbody>';

// Populate table with menu items data
foreach ($menuItems as $item) {
    $availability = $item['availability'] == 1 ? 'Yes' : 'No';
    $seasonal = $item['seasonal'] == 1 ? 'Yes' : 'No';
    $event_specific = $item['event_specific'] == 1 ? 'Yes' : 'No';

    $html .= '<tr>
                <td>' . htmlspecialchars($item['item_id']) . '</td>
                <td>' . htmlspecialchars($item['item_name']) . '</td>
                <td>' . htmlspecialchars($item['category']) . '</td>
                <td>' . htmlspecialchars($item['description']) . '</td>
                <td>' . number_format($item['price'], 2) . '</td>
                <td>' . $availability . '</td>
                <td>' . $seasonal . '</td>
                <td>' . $event_specific . '</td>
              </tr>';
}

$html .= '</tbody></table>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('menu_report.pdf', 'I'); // 'D' for download; change to 'I' to display in browser
exit;
