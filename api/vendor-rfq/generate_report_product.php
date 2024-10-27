<?php
require("../../app/init.php");
require_once '../tcpdf/vendor/autoload.php';

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $product = $DB->SELECT_ONE_WHERE("vendor_products", "*", array("product_id" => $product_id));

    // Check if product exists
    if ($product) {
        // Fetch the vendor's name from the `users` table based on `user_id`
        $vendor = $DB->SELECT_ONE_WHERE("users", "vendor_name", array("user_id" => $product['vendor_id']));

        // Sanitize and set the vendor name
        $vendorName = CHARS(isset($vendor['vendor_name']) ? $vendor['vendor_name'] : 'Unknown Vendor');


        // Fetch category name
        $category = $DB->SELECT_ONE_WHERE("categories", "category_name", array("category_id" => $product['category_id'])); // Adjust based on your actual field name
        $categoryName = $category ? CHARS($category['category_name']) : 'Unknown Category';

        // Create new PDF document
        $pdf = new TCPDF();

        // Add a page to the PDF
        $pdf->AddPage();

        // Set the title of the document with a font that supports Unicode
        $pdf->SetFont('dejavusans', 'B', 16);
        $pdf->Cell(0, 10, 'Product Report', 0, 1, 'C');
        $pdf->Ln(10); // Add space after the title

        // Set product details with a font that supports Unicode
        $pdf->SetFont('dejavusans', '', 12);
        $pdf->Cell(0, 10, 'Product ID: ' . CHARS($product['product_id']), 0, 1);
        $pdf->Cell(0, 10, 'Vendor Name: ' . $vendorName, 0, 1);
        $pdf->Cell(0, 10, 'Category: ' . $categoryName, 0, 1); // New Category Line
        $pdf->Cell(0, 10, 'Product Name: ' . CHARS($product['product_name']), 0, 1);
        $pdf->Cell(0, 10, 'Description: ' . CHARS($product['description']), 0, 1);
        $pdf->Cell(0, 10, 'Unit Price: ₱' . number_format($product['unit_price'], 2), 0, 1); // Use the Peso sign in UTF-8
        $pdf->Cell(0, 10, 'Availability: ' . CHARS($product['availability']), 0, 1);

        // Close and output PDF document to the browser
        $pdf->Output('product_report_' . $product_id . '.pdf', 'I'); // 'I' to display in the browser, 'D' to force download
    } else {
        echo "Product not found.";
    }
} else {
    echo "Invalid product ID.";
}
