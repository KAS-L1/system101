<?php
require("../../app/init.php");
?>

<?php
// Check if the form is submitted

    // Escape and sanitize the input data
    $data = array(
        "name" => $DB->ESCAPE($_POST['name']),
        "contact_number" => $DB->ESCAPE($_POST['contact_number']),
        "email" => $DB->ESCAPE($_POST['email']),
        "address" => $DB->ESCAPE($_POST['address']),
        "contract" => $DB->ESCAPE($_POST['contract']),
        "performance_score" => $DB->ESCAPE($_POST['performance_score']),
    );

    // Get the supplier ID from the form
    $id = $_POST['id'];

    // Update the supplier in the database
    $where = array("id" => $id);
    $supplier = $DB->UPDATE("suppliers", $data, $where);

    // Check if the update is successful
    if ($supplier) {
        swalAlert("success", "Supplier Updated");
        refreshUrlTimeout(2000);
    } else {
        swalAlert("error", "Failed to update supplier");
    }
?>