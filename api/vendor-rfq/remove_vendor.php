<?php
require("../../app/init.php");

$vendor_id = $_POST['vendor_id'];

$where = ["vendor_id" => $vendor_id];
$deleteVendor = $DB->DELETE("vendors", $where);

if ($deleteVendor == "success") {
    swalAlert("success", "Vendor removed successfully.");
    refreshUrlTimeout(2000);
} else {
    swalAlert("error", "Failed to remove vendor.");
}
