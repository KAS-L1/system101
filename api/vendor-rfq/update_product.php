    <?php
    require("../../app/init.php");

    $product_id = $_POST['product_id'];
    $data = [
        "vendor_id" => $DB->ESCAPE($_POST['vendor_id']), // Ensure vendor_id is an integer
        "product_name" => $DB->ESCAPE($_POST['product_name']),
        "description" => $DB->ESCAPE($_POST['description']),
        "unit_price" => $DB->ESCAPE($_POST['unit_price']),
        "availability" => $DB->ESCAPE($_POST['availability']),
    ];

    $where = ["product_id" => $product_id];
    $updateProduct = $DB->UPDATE("vendor_products", $data, $where);

    if ($updateProduct) {
        swalAlert("success", "Product updated successfully.");
        refreshUrlTimeout(2000);
    } else {
        swalAlert("error", "Failed to update product.");
    }
