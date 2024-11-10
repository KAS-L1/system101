<?php
require_once '../tcpdf/vendor/autoload.php';
include_once('../../app/init.php');

// Fetch all stock items
$stockItems = $DB->SELECT("stock_items", "*", "ORDER BY stock_id ASC");

// Initialize TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Stock Management System');
$pdf->SetTitle('Stock Report');
$pdf->SetHeaderData('', 0, 'Stock Report', 'Generated on ' . date('Y-m-d'));
$pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
$pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
$pdf->SetMargins(10, 20, 10);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(true, 10);

// Add a page
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

// Report Title
$pdf->Cell(0, 10, 'Stock Report Summary', 0, 1, 'C');

// Stock Table
$html = '<h3>Stock Items</h3>
         <table border="1" cellpadding="4">
            <thead>
                <tr style="background-color:#198754; color: #fff;">
                    <th>Stock ID</th>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Current Stock Level</th>
                    <th>Reorder Level</th>
                    <th>Supplier</th>
                    <th>Unit Price</th>
                    <th>Last Restocked</th>
                    <th>Expiration Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>';

foreach ($stockItems as $item) {
    $status = ($item['current_stock_level'] <= $item['reorder_level']) ? 'Low Stock' : 'In Stock';
    $html .= '<tr>
                <td>' . htmlspecialchars($item['stock_id']) . '</td>
                <td>' . htmlspecialchars($item['item_name']) . '</td>
                <td>' . htmlspecialchars($item['category']) . '</td>
                <td>' . htmlspecialchars($item['current_stock_level']) . '</td>
                <td>' . htmlspecialchars($item['reorder_level']) . '</td>
                <td>' . htmlspecialchars($item['supplier']) . '</td>
                <td>' . number_format($item['unit_price'], 2) . '</td>
                <td>' . htmlspecialchars($item['last_restocked_date']) . '</td>
                <td>' . htmlspecialchars($item['expiration_date']) . '</td>
                <td>' . htmlspecialchars($status) . '</td>
              </tr>';
}

$html .= '</tbody></table>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('stock_report.pdf', 'I'); // Change 'I' to 'D' for direct download
