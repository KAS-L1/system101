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

        // Add a page to the PDF
        $pdf->AddPage();

        // Set the title of the document with a font that supports Unicode
        $pdf->SetFont('dejavusans', 'B', 16);
        $pdf->Cell(0, 15, "Purchase Order Report for PO ID: " . CHARS($order['po_id']), 0, 1, 'C');
        $pdf->Ln(10); // Add space after the title

        // Set content font to DejaVu Sans for better Unicode support
        $pdf->SetFont('dejavusans', '', 12);

        // Format content with details of the purchase order
        $content = "Vendor Name: " . CHARS($order['vendor_name']) . "\n";
        $content .= "Items: " . CHARS($order['items']) . "\n";
        $content .= "Quantity: " . CHARS($order['quantity']) . "\n";
        $content .= "Unit Price: ₱" . number_format($order['unit_price'], 2) . "\n"; // Use the Peso sign in UTF-8
        $content .= "Total Cost: ₱" . number_format($order['total_cost'], 2) . "\n"; // Use the Peso sign in UTF-8
        $content .= "Order Date: " . CHARS($order['order_date']) . "\n";
        $content .= "Delivery Date: " . (!empty($order['delivery_date']) ? CHARS($order['delivery_date']) : 'No date available') . "\n";
        $content .= "Status: " . CHARS($order['status']) . "\n";
        $content .= "Remarks: " . CHARS($order['remarks']);

        // Output the content to the PDF
        $pdf->MultiCell(0, 10, $content, 0, 'L');

        // Output the PDF to the browser
        $pdf->Output("Purchase_Order_{$order['po_id']}.pdf", 'I'); // 'I' to display in the browser, 'D' to force download
    } else {
        echo "Purchase Order not found.";
    }
} else {
    echo "Invalid request.";
}
?>
