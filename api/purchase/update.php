<?php
require("../../app/init.php");


    // Escape and sanitize the input data
    $data = array(
        "vendor_name" => $DB->ESCAPE($_POST['vendor_name']),
        "items" => $DB->ESCAPE($_POST['items']),
        "quantity" => intval($DB->ESCAPE($_POST['quantity'])), // Ensuring quantity is an integer
        "unit_price" => floatval($DB->ESCAPE($_POST['unit_price'])), // Ensuring unit price is a float
        "total_cost" => floatval($_POST['quantity'] * $_POST['unit_price']), // Calculate total cost
        "order_date" => $DB->ESCAPE($_POST['order_date']),
        "delivery_date" => $DB->ESCAPE($_POST['delivery_date']),
        "status" => $DB->ESCAPE($_POST['status']),
        "remarks" => $DB->ESCAPE($_POST['remarks']) // Optional remarks
    );

    // Get the Purchase Order ID from the form
    $po_id = $DB->ESCAPE($_POST['po_id']);

    // Define where clause for updating the specific Purchase Order
    $where = array("po_id" => $po_id);

    // Update the Purchase Order in the database
    $updatePO = $DB->UPDATE("purchaseorder", $data, $where);

    // Check if the update is successful
    if ($updatePO) {
        swalAlert("success", "Purchase Order successfully updated");
        refreshUrlTimeout(2000);
    } else {
        swalAlert("error", "Failed to update Purchase Order");
    }

?>