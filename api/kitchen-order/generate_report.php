<?php
require_once '../tcpdf/vendor/autoload.php';
require_once '../../app/init.php';

// Check if the database connection is established
if (!isset($DB)) {
    die("Error: Database connection not initialized.");
}

// Retrieve summary data for kitchen orders by status
$orderSummary = $DB->SELECT("kitchen_orders", "order_status, COUNT(*) as count", "GROUP BY order_status");

// Retrieve recent kitchen orders
$recentOrders = $DB->SELECT("kitchen_orders", "order_id, guest_name, room_number, order_items, order_status, special_requests", "ORDER BY order_id DESC LIMIT 10");

// Initialize TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Kitchen Order Management System');
$pdf->SetTitle('Kitchen Order Report');
$pdf->SetHeaderData('', 0, 'Kitchen Order Report', 'Generated on ' . date('Y-m-d'));
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
$pdf->Cell(0, 10, 'Kitchen Order Report Summary', 0, 1, 'C');

// Order Status Summary Table
$html = '<h3>Order Status Summary</h3>
         <table border="1" cellpadding="4">
            <thead>
                <tr style="background-color:#198754; color: #fff;">
                    <th>Status</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>';

foreach ($orderSummary as $summary) {
    $html .= '<tr>
                <td>' . htmlspecialchars($summary['order_status']) . '</td>
                <td>' . htmlspecialchars($summary['count']) . '</td>
              </tr>';
}

$html .= '</tbody></table>';

// Recent Orders Table
$html .= '<h3>Recent Kitchen Orders</h3>
         <table border="1" cellpadding="4">
            <thead>
                <tr style="background-color:#198754; color: #fff;">
                    <th>Order ID</th>
                    <th>Guest Name</th>
                    <th>Room Number</th>
                    <th>Items</th>
                    <th>Status</th>
                    <th>Special Requests</th>
                </tr>
            </thead>
            <tbody>';

foreach ($recentOrders as $order) {
    $html .= '<tr>
                <td>' . htmlspecialchars($order['order_id']) . '</td>
                <td>' . htmlspecialchars($order['guest_name']) . '</td>
                <td>' . htmlspecialchars($order['room_number']) . '</td>
                <td>' . htmlspecialchars($order['order_items']) . '</td>
                <td>' . htmlspecialchars($order['order_status']) . '</td>
                <td>' . htmlspecialchars($order['special_requests']) . '</td>
              </tr>';
}

$html .= '</tbody></table>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('kitchen_order_report.pdf', 'I'); // 'D' for download; change to 'I' to display in browser
exit;
