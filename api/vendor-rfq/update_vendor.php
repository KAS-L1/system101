<?php
require("../../app/init.php");

$vendor_id = $_POST['vendor_id'];
$data = [
    "vendor_name" => $DB->ESCAPE($_POST['vendor_name']),
    "contact_info" => $DB->ESCAPE($_POST['contact_info']),
    "vendor_rating" => $DB->ESCAPE($_POST['vendor_rating']),
    "preferred_status" => $DB->ESCAPE($_POST['preferred_status']),
    "contract_status" => $DB->ESCAPE($_POST['contract_status']),
];

$where = ["vendor_id" => $vendor_id];
$updateVendor = $DB->UPDATE("vendors", $data, $where);

if ($updateVendor) {
    swalAlert("Vendor updated successfully.");
    refreshUrlTimeout(2000);
} else {
    swalAlert("Failed to update vendor.");
}


