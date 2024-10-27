<?php
require("../../app/init.php");

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $product = $DB->SELECT_ONE_WHERE("vendor_products", "*", array("product_id" => $product_id));

    // Check if product exists
    if ($product) {
        // Fetch the vendor's name from the `users` table based on `user_id`
        $vendor = $DB->SELECT_ONE_WHERE("users", "vendor_name", array("user_id" => $product['vendor_id']));

        // Sanitize and set the vendor name
        $vendorName = CHARS(isset($vendor['vendor_name']) ? $vendor['vendor_name'] : 'Unknown Vendor');


        // Fetch the category name
        $category = $DB->SELECT_ONE_WHERE("categories", "category_name", array("category_id" => $product['category_id']));
        $categoryName = CHARS(isset($category['category_name']) ? $category['category_name'] : 'Unknown Category');
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
                        <p><strong>Category:</strong> <?= $categoryName; ?></p> <!-- Display the category name -->
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