<?php
require("../../app/init.php");

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Escape and sanitize the input data
    $data = array(
        "id" => rand(),
        "name" => $DB->ESCAPE($_POST['name']),
        "contact_person" => $DB->ESCAPE($_POST['contact_person']),
        "contact_number" => $DB->ESCAPE($_POST['contact_number']),
        "email" => $DB->ESCAPE($_POST['email']),
        "address" => $DB->ESCAPE($_POST['address']),
        "status" => "Pending"  // Default status when created
    );

    // Insert the supplier into the database
    $supplier = $DB->INSERT("suppliers", $data);

    // Check if the insert was successful and respond accordingly
    if ($supplier == "success") {
        echo alert("success", "Supplier Added Successfully");
    } else {
        echo alert("danger", "Failed to add supplier: " . $supplier['error']);
    }
}
?>
