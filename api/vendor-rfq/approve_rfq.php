<?php require("../../app/init.php"); ?>

<?php
$rfq_id = $_POST['rfq_id']; // Retrieve RFQ ID from POST

// Data to update
$data = array(
    "rfq_status" => "Approved", // Set status to Approved
    "response_date" => DATE_TIME
);

// Where condition to target the correct RFQ
$where = array("rfq_id" => $rfq_id);

// Perform the update operation
$rfq = $DB->UPDATE("rfqs", $data, $where);

// Check if the update was successful
if ($rfq != "success") {
    swalAlert("error", "Failed to approve RFQ."); // Show error message if update fails
} else {
    swalAlert("success", "RFQ approved successfully!"); // Show success message if update is successful
}

refreshUrlTimeout(2000); // Refresh the page after 2 seconds
?>
