<?php
// Include your database connection or configuration file
require("../../app/init.php");

    // Retrieve the data from the POST request
    $vendor_id = $_POST['vendor_id'];
    $vendor_name = $_POST['vendor_name'];
    $contact_info = $_POST['contact_info'];
    $vendor_rating = $_POST['vendor_rating'];
    $preferred_status = $_POST['preferred_status'];
    $contract_status = $_POST['contract_status'];



    // Update the vendor data in the database
    $update = $DB->UPDATE("vendors", [
        "vendor_name" => $vendor_name,
        "contact_info" => $contact_info,
        "vendor_rating" => $vendor_rating,
        "preferred_status" => $preferred_status,
        "contract_status" => $contract_status
    ], ["vendor_id" => $vendor_id]);

    // Check if the update was successful
    if ($update) {
        echo "<p class='alert alert-success'>Vendor updated successfully.</p>";
    } else {
        echo "<p class='alert alert-danger'>Failed to update vendor. Please try again.</p>";
    }

