<?php
require("../../app/init.php");

// Escape and sanitize the input data
$data = array(
    "scheduled_date" => $DB->ESCAPE($_POST['new_scheduled_date']),
    "scheduled_time" => $DB->ESCAPE($_POST['new_scheduled_time']),
    "remarks" => $DB->ESCAPE($_POST['remarks']) // Optional remarks for rescheduling
);

// Get the Audit ID from the form
$audit_id = $DB->ESCAPE($_POST['audit_id']);

// Define where clause for updating the specific Audit Schedule
$where = array("audit_id" => $audit_id);

// Update the Audit Schedule in the database
$updateAudit = $DB->UPDATE("audit_schedule", $data, $where);

// Check if the update is successful
if ($updateAudit == "success") {
    swalAlert("success", "Audit Schedule successfully updated");
    refreshUrlTimeout(2000);
} else {
    swalAlert("error", "Failed to update Audit Schedule");
}
