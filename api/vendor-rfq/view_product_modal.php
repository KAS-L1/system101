<?php
require("../../app/init.php");

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $product = $DB->SELECT_ONE_WHERE("vendor_products", "*", array("product_id" => $product_id));
    
    // Check if product exists
    if ($product) {
        $vendor = $DB->SELECT_ONE_WHERE("vendors", "vendor_name", array("vendor_id" => $product['vendor_id']));
        $vendorName = CHARS(isset($vendor['vendor_name']) ? $vendor['vendor_name'] : 'Unknown Vendor');
?>
<div class="modal fade" id="viewProductModal" tabindex="-1" aria-labelledby="viewProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> <!-- Add modal-dialog-centered class -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProductModalLabel">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Product ID: <?= CHARS($product['product_id']); ?></h5>
                <p><strong>Vendor Name:</strong> <?= $vendorName; ?></p>
                <p><strong>Product Name:</strong> <?= CHARS($product['product_name']); ?></p>
                <p><strong>Description:</strong> <?= CHARS($product['description']); ?></p>
                <p><strong>Unit Price:</strong> <?= NUMBER_PHP_2($product['unit_price']); ?></p>
                <p><strong>Availability:</strong> <?= CHARS($product['availability']); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
    } else {
        echo "<div class='alert alert-danger'>Product not found.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Invalid product ID.</div>";
}
?>
