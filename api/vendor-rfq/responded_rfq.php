<?php require("../../app/init.php"); ?>

<?php
$rfq_id = $_POST['rfq_id']; // Retrieve RFQ ID from POST

// Data to update
$data = array(
    "rfq_status" => "Responded", // Set status to Approved
);

// Where condition to target the correct RFQ
$where = array("rfq_id" => $rfq_id);

// Perform the update operation
$rfq = $DB->UPDATE("rfqs", $data, $where);

// Check if the update was successful
if ($rfq != "success") {
    swalAlert("error", "Failed to response RFQ."); // Show error message if update fails
} else {
    swalAlert("success", "RFQ responded successfully!"); // Show success message if update is successful
}

refreshUrlTimeout(2000); // Refresh the page after 2 seconds
?>
