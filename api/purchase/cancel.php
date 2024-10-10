<?php require("../../app/init.php"); ?>

<?php 
    // Retrieve Purchase Order ID from POST request
    $po_id = $_POST['po_id'];

    // Prepare the data to update the status to "Cancelled"
    $data = array(
        "status" => "Cancelled",
    );

    // Define the WHERE clause to identify the specific Purchase Order
    $where = array("po_id" => $po_id);

    // Update the Purchase Order status in the database
    $updatePO = $DB->UPDATE("purchaseorder", $data, $where);

    // Check if the update was successful
    if ($updatePO != "success") {
        alert("danger", $updatePO['error']);
    } else {
        swalAlert("success", "Purchase Order Cancelled");
        refreshUrlTimeout(2000);
    }
?>