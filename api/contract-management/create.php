<?php
require("../../app/init.php");

// Escape and sanitize input data
$data = array(
    "vendor_id" => $DB->ESCAPE($_POST['vendor_id']),
    "contract_terms" => $DB->ESCAPE($_POST['contract_terms']),
    "start_date" => $DB->ESCAPE($_POST['start_date']),
    "end_date" => $DB->ESCAPE($_POST['end_date']),
    "status" => "Active",
    "renewal_date" => $DB->ESCAPE($_POST['renewal_date']),
);

// Insert the new contract into the contracts table
$contract = $DB->INSERT("contracts", $data);

// Check if the contract was created successfully
if ($contract) {
    swalAlert('success', 'Contract Created Successfully!');
    refreshUrlTimeout(2000);
} else {
    swalAlert('error', 'Failed to Create Contract');
}
