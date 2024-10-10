<?php
require("../../app/init.php");

    // Escape and sanitize the input data
    $data = array(
        "requisition_id" => rand(), // Assuming you want a random ID for new entries
        "department" => $DB->ESCAPE($_POST['department']),
        "item_description" => $DB->ESCAPE($_POST['item_description']),
        "quantity" => intval($DB->ESCAPE($_POST['quantity'])), // Ensuring quantity is an integer
        "unit_of_measure" => $DB->ESCAPE($_POST['unit_of_measure']),
        "priority_level" => $DB->ESCAPE($_POST['priority_level']),
        "requested_date" => $DB->ESCAPE($_POST['requested_date']),
        "required_date" => $DB->ESCAPE($_POST['required_date']),
        "status" => $DB->ESCAPE($_POST['status']),  // Use the provided status value
        "remarks" => $DB->ESCAPE($_POST['remarks']),
    );

    // Insert the requisition into the database
    $requisition = $DB->INSERT("purchaserequisition", $data);

    if ($requisition) {
        // Display success alert and refresh page
        swalAlert('success', 'Requisition Created Successfully');
        refreshUrlTimeout(2000);
    } else {
        // Display error alert if something goes wrong
        swalAlert('error', 'Failed to Create Requisition');
    }