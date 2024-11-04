<?php
require("../../app/init.php");

// Get the audit ID from the form
$audit_id = $_POST['audit_id'];

// Define the data to update
$data = array("status" => "In Progress");

// Define where clause for updating the specific Audit Schedule
$where = array("audit_id" => $audit_id);

// Update the audit schedule status to "In Progress"
$updateStatus = $DB->UPDATE("audit_schedule", $data, $where);

// Check if the update is successful
if ($updateStatus == "success") {
    swalAlert("success", "Audit marked as In Progress");
    refreshUrlTimeout(2000);
} else {
    swalAlert("error", "Failed to update audit status");
}
