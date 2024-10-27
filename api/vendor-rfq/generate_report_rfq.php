<?php
require("../../app/init.php");
require_once '../tcpdf/vendor/autoload.php';

if (isset($_GET['rfq_id'])) {
    $rfq_id = $_GET['rfq_id'];
    $rfq = $DB->SELECT_ONE_WHERE("rfqs", "*", array("rfq_id" => $rfq_id));

    if ($rfq) {
        // Fetch Vendor and Product names from their respective tables
        $vendor = $DB->SELECT_ONE_WHERE("users", "vendor_name", array("user_id" => $rfq['vendor_id']));
        $product = $DB->SELECT_ONE_WHERE("vendor_products", "product_name", array("product_id" => $rfq['product_id']));

        $vendorName = CHARS($vendor['vendor_name'] ?? 'Unknown Vendor');
        $productName = CHARS($product['product_name'] ?? 'Unknown Product');

        // Create new PDF document
        $pdf = new TCPDF();

        // Add a page to the PDF
        $pdf->AddPage();

        // Set the title of the document with a font that supports Unicode
        $pdf->SetFont('dejavusans', 'B', 16);
        $pdf->Cell(0, 15, "RFQ Report for RFQ ID: " . CHARS($rfq['rfq_id']), 0, 1, 'C');
        $pdf->Ln(10); // Add space after the title

        // Set RFQ details
        $pdf->SetFont('dejavusans', '', 12);
        $pdf->MultiCell(
            0,
            10,
            "Vendor Name: " . $vendorName . "\n" .
                "Product Name: " . $productName . "\n" .
                "Quantity Requested: " . CHARS($rfq['requested_quantity']) . "\n" .
                "Quoted Price: ₱" . number_format($rfq['quoted_price'], 2) . "\n" .
                "Status: " . CHARS($rfq['rfq_status']) . "\n" .
                "Remarks: " . CHARS($rfq['remarks']),
            0,
            'L'
        );

        // Close and output PDF document to the browser
        $pdf->Output("RFQ_Report_{$rfq['rfq_id']}.pdf", 'I'); // 'I' to display in the browser, 'D' to force download
    } else {
        echo "RFQ not found.";
    }
} else {
    echo "Invalid RFQ ID.";
}
