<?php
require("../../app/init.php");

$rfq_id = $_POST['rfq_id'];

$where = ["rfq_id" => $rfq_id];
$deleteRFQ = $DB->DELETE("rfqs", $where);

if ($deleteRFQ) {
    swalAlert("success", "RFQ removed successfully.");
    refreshUrlTimeout(2000);
} else {
    swalAlert("error", "Failed to remove RFQ.");
}
