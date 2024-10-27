<?php
require("../../app/init.php");
require_once '../tcpdf/vendor/autoload.php';

if (isset($_GET['invoice_id'])) {
    $invoice_id = $_GET['invoice_id'];
    $invoice = $DB->SELECT_ONE_WHERE("invoice_payments", "*", array("invoice_id" => $invoice_id));

    if ($invoice) {
        // Fetch the associated purchase order using `po_id` from the invoice
        $purchaseOrder = $DB->SELECT_ONE_WHERE("purchaseorder", "vendor_name", array("po_id" => $invoice['po_id']));

        // Sanitize and set the vendor name, with a fallback if the vendor is not found
        $vendorName = CHARS($purchaseOrder['vendor_name'] ?? 'Unknown Vendor');

        // Create a new PDF document
        $pdf = new TCPDF();

        // Add a page to the PDF
        $pdf->AddPage();

        // Set the title of the document with a font that supports Unicode
        $pdf->SetFont('dejavusans', 'B', 16);
        $pdf->Cell(0, 15, "Invoice Report for Invoice ID: " . CHARS($invoice['invoice_id']), 0, 1, 'C');
        $pdf->Ln(10); // Add space after the title

        // Set Invoice details
        $pdf->SetFont('dejavusans', '', 12);
        $pdf->MultiCell(
            0,
            10,
            "Vendor Name: " . $vendorName . "\n" .
                "PO ID: " . CHARS($invoice['po_id']) . "\n" .
                "Amount: ₱" . number_format($invoice['amount'], 2) . "\n" .
                "Payment Terms: " . CHARS($invoice['payment_terms']) . "\n" .
                "Payment Status: " . CHARS($invoice['payment_status']) . "\n" .
                "Due Date: " . CHARS($invoice['due_date']) . "\n" .
                "Remarks: " . CHARS($invoice['remarks']),
            0,
            'L'
        );

        // Close and output PDF document to the browser
        $pdf->Output("Invoice_Report_{$invoice['invoice_id']}.pdf", 'I'); // 'I' to display in the browser, 'D' to force download
    } else {
        echo "Invoice not found.";
    }
} else {
    echo "Invalid Invoice ID.";
}
