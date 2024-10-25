<?php
require("../../app/init.php");

// Retrieve the category name
$category_name = $_POST['category_name'];

// Insert into categories table
$data = [
    'category_name' => CHARS($category_name),
];

$inserted = $DB->INSERT("categories", $data);
if ($inserted == "success") {
    swalAlert("success", "Category added successfully!");
} else {
    swalAlert("error", "Failed to add category.");
}
