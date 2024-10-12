<?php
require("../../app/init.php");

$vendor_id = $_POST['vendor_id'];

$where = ["vendor_id" => $vendor_id];
$deleteVendor = $DB->DELETE("vendors", $where);

if ($deleteVendor) {
    swalAlert("Vendor removed successfully.");
} else {
    swalAlert("Failed to remove vendor.");
}
