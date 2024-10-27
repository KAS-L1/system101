    <?php
    require("../../app/init.php");
    require("../auth/auth.php");


    $where = array("user_id" => $_POST['vendor_id']);
    $vendor = $DB->SELECT_ONE_WHERE("users", "*", $where);


    // Escape and sanitize the input data
    $data = array(
        "vendor_id" => $DB->ESCAPE($_POST['vendor_id']),
        "po_id" => rand(), // Assuming a random ID is needed for new entries
        "vendor_name" => $DB->ESCAPE($vendor['vendor_name']),
        "items" => $DB->ESCAPE($_POST['items']),
        "quantity" => $DB->ESCAPE($_POST['quantity']), // Assuming quantity is sanitized by your framework
        "unit_price" => $DB->ESCAPE($_POST['unit_price']), // Assuming unit price is sanitized by your framework
        "total_cost" => $DB->ESCAPE($_POST['quantity']) * $DB->ESCAPE($_POST['unit_price']), // Calculate total cost
        "order_date" => $DB->ESCAPE($_POST['order_date']),
        "delivery_date" => $DB->ESCAPE($_POST['delivery_date']),
        "status" => "Ordered", // Default status when created
        "remarks" => $DB->ESCAPE($_POST['remarks']),
    );


    // Insert the new PO into the purchaseorder table
    $purchaseOrder = $DB->INSERT("purchaseorder", $data);

    // Check if the Purchase Order was successfully created
    if ($purchaseOrder == "success") {
        // Display success alert and refresh page
        swalAlert('success', 'Purchase Order Created Successfully!');
        refreshUrlTimeout(2000);
    } else {
        // Display error alert if something goes wrong
        swalAlert('error', 'Failed to Create Purchase Order');
    }
