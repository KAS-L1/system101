<?php
require("../../app/init.php");
require("../auth/auth.php");

// Escape and sanitize the input data
$data = array(
    "audit_id" => rand(100000, 999999),
    "audit_type" => $DB->ESCAPE($_POST['audit_type']),
    "scheduled_date" => $DB->ESCAPE($_POST['scheduled_date']),
    "scheduled_time" => $DB->ESCAPE($_POST['scheduled_time']),
    "status" => "Scheduled", // Default status when created
    "department" => $DB->ESCAPE($_POST['department']),
    "remarks" => $DB->ESCAPE($_POST['remarks']),
);

// Insert the new audit schedule into the audit_schedule table
$auditSchedule = $DB->INSERT("audit_schedule", $data);

// Check if the audit schedule was successfully created
if ($auditSchedule == "success") {
    // Display success alert and refresh page
    swalAlert('success', 'Audit Schedule Created Successfully!');
    refreshUrlTimeout(2000);
} else {
    // Display error alert if something goes wrong
    swalAlert('error', 'Failed to Create Audit Schedule');
}
