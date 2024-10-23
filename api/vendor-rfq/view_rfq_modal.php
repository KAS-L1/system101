<?php
require("../../app/init.php");

if (isset($_POST['rfq_id'])) {
    $rfq_id = $_POST['rfq_id'];

    // Query to fetch RFQ details
    $rfq = $DB->SELECT_ONE_WHERE("rfqs", "*", array("rfq_id" => $rfq_id));

    if ($rfq) {
        // Include more detailed information if needed
        $vendor_name = $DB->SELECT_ONE_WHERE("vendors", "vendor_name", array("vendor_id" => $rfq['vendor_id']));
        $product_name = $DB->SELECT_ONE_WHERE("vendor_products", "product_name", array("product_id" => $rfq['product_id']));

        // Output a modal with RFQ details
        echo "
        <div class='modal fade' id='viewRFQModal' tabindex='-1' aria-labelledby='viewRFQModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-lg modal-dialog-centered'> <!-- Center the modal -->
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='viewRFQModalLabel'>RFQ Details for ID: {$rfq['rfq_id']}</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                        <p><strong>Vendor:</strong> " . htmlspecialchars($vendor_name['vendor_name']) . "</p>
                        <p><strong>Product:</strong> " . htmlspecialchars($product_name['product_name']) . "</p>
                        <p><strong>Quantity Requested:</strong> " . htmlspecialchars($rfq['requested_quantity']) . "</p>
                        <p><strong>Quoted Price:</strong> ₱" . number_format($rfq['quoted_price'], 2) . "</p>
                        <p><strong>Status:</strong> " . htmlspecialchars($rfq['rfq_status']) . "</p>
                        <p><strong>Response Date:</strong> " . htmlspecialchars($rfq['response_date']) . "</p>
                        <p><strong>Remarks:</strong> " . htmlspecialchars($rfq['remarks']) . "</p>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                    </div>
                </div>
            </div>
        </div>";
    } else {
        echo "<p class='text-danger'>RFQ not found.</p>";
    }
}
?>
