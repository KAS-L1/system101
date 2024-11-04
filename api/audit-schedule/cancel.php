<?php
require("../../app/init.php");

// Get the audit ID from the form
$audit_id = $_POST['audit_id'];

// Define the data to update
$data = array("status" => "Cancelled");

// Define where clause for updating the specific Audit Schedule
$where = array("audit_id" => $audit_id);

// Update the audit schedule status to "Cancelled"
$updateStatus = $DB->UPDATE("audit_schedule", $data, $where);

// Check if the update is successful
if ($updateStatus == "success") {
    swalAlert("success", "Audit cancelled successfully");
    refreshUrlTimeout(2000);
} else {
    swalAlert("error", "Failed to cancel audit");
}
