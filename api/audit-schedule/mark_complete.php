<?php
require("../../app/init.php");

// Get the audit ID from the form
$audit_id = $_POST['audit_id'];

// Define the data to update
$data = array("status" => "Completed");

// Define where clause for updating the specific Audit Schedule
$where = array("audit_id" => $audit_id);

// Update the audit schedule status to "Completed"
$updateStatus = $DB->UPDATE("audit_schedule", $data, $where);

// Check if the update is successful
if ($updateStatus == "success") {
    swalAlert("success", "Audit marked as Completed");
    refreshUrlTimeout(2000);
} else {
    swalAlert("error", "Failed to mark audit as Completed");
}
