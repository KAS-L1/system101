<?php
require("../../app/init.php");
?>

<?php

    // Get the supplier ID from the form
    $requisition_id = $_POST['requisition_id'];

    // Update the supplier in the database
    $where = array("requisition_id" => $requisition_id);
    $requisition = $DB->DELETE("purchaserequisition", $where);

    // Check if the update is successful
    if ($requisition) {
        swalAlert("success", "Purchase Requisition Removed");
        refreshUrlTimeout(2000);
    } else {
        swalAlert("error", "Failed to remove purchase requisition");
    }
?>