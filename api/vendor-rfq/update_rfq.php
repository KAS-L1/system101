<?php
require("../../app/init.php");

$rfq_id = $_POST['rfq_id'];
$data = [
    "vendor_id" => $DB->ESCAPE($_POST['vendor_id']),
    "product_id" => $DB->ESCAPE($_POST['product_id']),
    "requested_quantity" => $DB->ESCAPE($_POST['requested_quantity']),
    "quoted_price" => $DB->ESCAPE($_POST['quoted_price']),
    "rfq_status" => $DB->ESCAPE($_POST['rfq_status']),
];

$where = ["rfq_id" => $rfq_id];
$updateRFQ = $DB->UPDATE("rfqs", $data, $where);

if ($updateRFQ == "success") {
    swalAlert("RFQ updated successfully.");
} else {
    swalAlert("Failed to update RFQ.");
}
