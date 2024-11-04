<?php
require("../../app/init.php");

// Retrieve POST data
$finding_id = $_POST['finding_id'];
$new_status = $_POST['status'];

// Fetch the current finding details
$finding = $DB->SELECT_ONE_WHERE("audit_finding", "*", ["finding_id" => $finding_id]);

if ($finding) {
    // Update the status in the audit_findings table
    $data = ["status" => $DB->ESCAPE($new_status)];
    $where = ["finding_id" => $DB->ESCAPE($finding_id)];
    $updateFinding = $DB->UPDATE("audit_finding", $data, $where);

    if ($updateFinding === "success") {
        // Log the status update in the Audit Logs
        $log_data = [
            "action" => "Updated Finding Status",
            "details" => "Finding ID {$finding_id} status changed to {$new_status}",
            "timestamp" => date("Y-m-d H:i:s")
        ];
        $DB->INSERT("audit_logs", $log_data);

        // Display success alert and refresh page after a delay
        swalAlert("success", "Success", "Finding status updated successfully!");
        refreshUrlTimeout(2000);
    } else {
        // Display error alert if update failed
        swalAlert("error", "Error", "Failed to update finding status");
    }
} else {
    // Display error alert if finding not found
    swalAlert("error", "Error", "Finding not found");
}
