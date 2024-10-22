<?php
require("../../app/init.php");
require_once '../tcpdf/vendor/autoload.php';

if (isset($_GET['po_id'])) {
    $po_id = $_GET['po_id'];

    // Query to get Purchase Order details
    $order = $DB->SELECT_ONE_WHERE("purchaseorder", "*", array("po_id" => $po_id));

    if ($order) {
        // Create new PDF document
        $pdf = new TCPDF();
        $pdf->AddPage();

        // Set title and output content
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 15, "Purchase Order Report for PO ID: {$order['po_id']}", 0, 1, 'C');
        
        // Set content font
        $pdf->SetFont('helvetica', '', 12);

        // Format content with details of the purchase order
        $content = "Vendor Name: {$order['vendor_name']}\n";
        $content .= "Items: {$order['items']}\n";
        $content .= "Quantity: {$order['quantity']}\n";
        $content .= "Unit Price: " . number_format($order['unit_price'], 2) . "\n";
        $content .= "Total Cost: " . number_format($order['total_cost'], 2) . "\n";
        $content .= "Order Date: {$order['order_date']}\n";
        $content .= "Delivery Date: " . (!empty($order['delivery_date']) ? $order['delivery_date'] : 'No date available') . "\n";
        $content .= "Status: {$order['status']}\n";
        $content .= "Remarks: {$order['remarks']}";

        // Output the content to the PDF
        $pdf->MultiCell(0, 10, $content, 0, 'L');

        // Output the PDF
        $pdf->Output("Purchase_Order_{$order['po_id']}.pdf", 'I');
    } else {
        echo "Purchase Order not found.";
    }
} else {
    echo "Invalid request.";
}
?>
