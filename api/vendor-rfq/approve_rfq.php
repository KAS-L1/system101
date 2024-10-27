<?php
require("../../app/init.php");

// Get the RFQ ID from POST data
$rfq_id = $_POST['rfq_id'];

// Prepare the data for updating the RFQ
$data = array(
    "rfq_status" => "Approved", // Use "Approved" based on your database enum definition
    "response_date" => DATE_TIME
);

$where = array("rfq_id" => $rfq_id);

// Update the RFQ status in the database
$rfq = $DB->UPDATE("rfqs", $data, $where);

// Check for success or error in the update operation
if ($rfq != "success") {
    alert("danger", $rfq['error']); // Display error message if the update fails
} else {
    swalAlert("success", "RFQ Approved Successfully"); // Show success message
    refreshUrlTimeout(2000); // Refresh the page or red irect after 2 seconds
}
