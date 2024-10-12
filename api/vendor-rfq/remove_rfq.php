<?php
require("../../app/init.php");

$rfq_id = $_POST['rfq_id'];

$where = ["rfq_id" => $rfq_id];
$deleteRFQ = $DB->DELETE("rfqs", $where);

if ($deleteRFQ) {
    swalAlert("RFQ removed successfully.");
} else {
    swalAlert("Failed to remove RFQ.");
}
