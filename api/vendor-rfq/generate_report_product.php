<?php
require("../../app/init.php");
require_once '../tcpdf/vendor/autoload.php';

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $product = $DB->SELECT_ONE_WHERE("vendor_products", "*", array("product_id" => $product_id));
    
    // Check if product exists
    if ($product) {
        $vendor = $DB->SELECT_ONE_WHERE("vendors", "vendor_name", array("vendor_id" => $product['vendor_id']));
        $vendorName = CHARS(isset($vendor['vendor_name']) ? $vendor['vendor_name'] : 'Unknown Vendor');

        // Create new PDF document
        $pdf = new TCPDF();
        $pdf->AddPage();

        // Set title
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Product Report', 0, 1, 'C');

        // Set product details
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 10, 'Product ID: ' . CHARS($product['product_id']), 0, 1);
        $pdf->Cell(0, 10, 'Vendor Name: ' . $vendorName, 0, 1);
        $pdf->Cell(0, 10, 'Product Name: ' . CHARS($product['product_name']), 0, 1);
        $pdf->Cell(0, 10, 'Description: ' . CHARS($product['description']), 0, 1);
        $pdf->Cell(0, 10, 'Unit Price: ' . NUMBER_PHP_2($product['unit_price']), 0, 1);
        $pdf->Cell(0, 10, 'Availability: ' . CHARS($product['availability']), 0, 1);

        // Close and output PDF document
        $pdf->Output('product_report_' . $product_id . '.pdf', 'I');
    } else {
        echo "Product not found.";
    }
} else {
    echo "Invalid product ID.";
}
?>
