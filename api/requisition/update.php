<?php
require("../../app/init.php");

// Check if the form is submitted

    // Escape and sanitize the input data
    $data = array(
        "department" => $DB->ESCAPE($_POST['department']),
        "item_description" => $DB->ESCAPE($_POST['item_description']),
        "quantity" => $DB->ESCAPE($_POST['quantity']),
        "unit_of_measure" => $DB->ESCAPE($_POST['unit_of_measure']),
        "priority_level" => $DB->ESCAPE($_POST['priority_level']),
        "requested_date" => $DB->ESCAPE($_POST['requested_date']),
        "required_date" => $DB->ESCAPE($_POST['required_date']),
        "status" => $DB->ESCAPE($_POST['status']),
        "remarks" => $DB->ESCAPE($_POST['remarks'])
    );

    // Get the requisition ID from the form
    $requisition_id = $DB->ESCAPE($_POST['requisition_id']);

    // Update the requisition in the database
    $where = array("requisition_id" => $requisition_id);
    $requisition = $DB->UPDATE("purchaserequisition", $data, $where);

    // Check if the update is successful
    if ($requisition) {
        swalAlert("success", "Requisition successfully updated");
        refreshUrlTimeout(2000);
    } else {
        swalAlert("error", "Failed to update requisition");
    }

?>