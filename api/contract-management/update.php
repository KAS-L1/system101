<?php
require("../../app/init.php");

// Escape and sanitize the input data
$data = array(
    "contract_terms" => $DB->ESCAPE($_POST['contract_terms']),
    "start_date" => $DB->ESCAPE($_POST['start_date']),
    "end_date" => $DB->ESCAPE($_POST['end_date']),
    "status" => $DB->ESCAPE($_POST['status']),
    "renewal_date" => $DB->ESCAPE($_POST['renewal_date']),
    "remarks" => $DB->ESCAPE($_POST['remarks']) // Optional remarks
);

// Get the Contract ID from the form
$contract_id = $DB->ESCAPE($_POST['contract_id']);

// Define where clause for updating the specific Contract
$where = array("contract_id" => $contract_id);

// Update the Contract in the database
$updateContract = $DB->UPDATE("contracts", $data, $where);

// Check if the update is successful
if ($updateContract) {
    swalAlert("success", "Contract successfully updated");
    refreshUrlTimeout(2000);
} else {
    swalAlert("error", "Failed to update Contract");
}
