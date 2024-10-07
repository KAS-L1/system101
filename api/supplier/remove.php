<?php
require("../../app/init.php");
?>

<?php

    // Get the supplier ID from the form
    $id = $_POST['id'];

    // Update the supplier in the database
    $where = array("id" => $id);
    $supplier = $DB->DELETE("suppliers", $where);

    // Check if the update is successful
    if ($supplier) {
        swalAlert("success", "Supplier Removed");
        refreshUrlTimeout(2000);
    } else {
        swalAlert("error", "Failed to remove supplier");
    }
?>