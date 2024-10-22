<?php
require("../../app/init.php");
require_once '../tcpdf/vendor/autoload.php';

if (isset($_GET['rfq_id'])) {
    $rfq_id = $_GET['rfq_id'];
    $rfq = $DB->SELECT_ONE_WHERE("rfqs", "*", array("rfq_id" => $rfq_id));

    if ($rfq) {
        // Create new PDF document
        $pdf = new TCPDF();
        $pdf->AddPage();
        
        // Set the title and output content
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 15, "RFQ Report for RFQ ID: {$rfq['rfq_id']}", 0, 1, 'C');

        $pdf->SetFont('helvetica', '', 12);
        $pdf->MultiCell(0, 10, "Vendor ID: {$rfq['vendor_id']}\nProduct ID: {$rfq['product_id']}\nQuantity Requested: {$rfq['requested_quantity']}\nQuoted Price: {$rfq['quoted_price']}\nStatus: {$rfq['rfq_status']}\nRemarks: {$rfq['remarks']}", 0, 'L');

        // Output the PDF
        $pdf->Output("RFQ_Report_{$rfq['rfq_id']}.pdf", 'I');
    } else {
        echo "RFQ not found.";
    }
}
?>
