<?php require("../../app/init.php"); ?>

<?php

// Retrieve the RFQ ID from the POST request
$rfq_id = $_POST['rfq_id'];

// Prepare the data to update the RFQ status to "Rejected"
$data = array(
    "rfq_status" => "Rejected",
);

// Define the condition to target the correct RFQ by its ID
$where = array("rfq_id" => $rfq_id);

// Perform the update operation using the framework's UPDATE method
$rfq = $DB->UPDATE("rfqs", $data, $where);

// Check if the update was successful
if ($rfq == "success") {
    swalAlert("success", "RFQ Rejected successfully.");
} else {
    alert("danger", $rfq['error']);
}
// Refresh the page after a 2-second delay
refreshUrlTimeout(2000);

?>
