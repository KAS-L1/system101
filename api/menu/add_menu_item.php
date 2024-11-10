<?php
require("../../app/init.php");

$item_name = $_POST['item_name'];
$category = $_POST['category'];
$description = $_POST['description'];
$price = $_POST['price'];
$availability = isset($_POST['availability']) ? 1 : 0;
$seasonal = isset($_POST['seasonal']) ? 1 : 0;
$event_specific = isset($_POST['event_specific']) ? 1 : 0;

$data = array(
    "item_id" => rand(100000, 999999),
    "item_name" => $item_name,
    "category" => $category,
    "description" => $description,
    "price" => $price,
    "availability" => $availability,
    "seasonal" => $seasonal,
    "event_specific" => $event_specific
);

$insert = $DB->INSERT("menu_items", $data);
if ($insert == "success") {
    swalAlert('success', 'New menu item added successfully.');
    refreshUrlTimeout(2000);
} else {
    swalAlert('error', 'Failed to add new item.');
}
