<?php
require("../../app/init.php");

// Retrieve and sanitize input data
$audit_id = $DB->ESCAPE($_POST['audit_id'] ?? 0);
$finding_type = $DB->ESCAPE($_POST['finding_type']);
$description = $DB->ESCAPE($_POST['description']);
$severity = $DB->ESCAPE($_POST['severity']);
$recommendations = $DB->ESCAPE($_POST['recommendations']);

// Prepare data for insertion into the audit_findings table
$data = array(
    "finding_id" => rand(100000, 999999),
    "audit_id" => $audit_id,
    "finding_type" => $finding_type,
    "description" => $description,
    "severity" => $severity,
    "recommendations" => $recommendations,
    "status" => "Open" // Default status
);

// Insert the new finding into the database
$insertFinding = $DB->INSERT(table: "audit_finding", $data);

// Check if the finding was successfully added
if ($insertFinding == "success") {
    swalAlert("success", "Audit Finding Created Successfully!");
    refreshUrlTimeout(2000);
} else {
    swalAlert("error", "Failed to Create Audit Schedule");
}
