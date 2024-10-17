<?php
include('../../app/init.php');


$token = "d368051b3cd2819131fff6811cf4e59cd"; //  Kupal ka ba boss?

if (!isset($_GET['token']) or $_GET['token'] != $token) {
    die("Invalid token failed to request to server.");
}

if (!isset($_GET['status']) or !isset($_GET['po_id'])) {
    die('Invalid parameter data status and po_id required!');
}


$status = $_GET['status'];
$po_id = $_GET['po_id'];
$remarks = $_GET['remarks'];

// Escape and sanitize the input data
$data = array(
    "status" => $DB->ESCAPE($status),
    "remarks" => $DB->ESCAPE($remarks) // Optional remarks
);


// Define where clause for updating the specific Purchase Order
$where = array("po_id" => $po_id);

// Update the Purchase Order in the database
$updatePO = $DB->UPDATE("purchaseorder", $data, $where);

// Check if the update is successful
if ($updatePO == "success") {
    echo "ORDER_UPDATED";
} else {
    echo "FAILED_TO_UPDATE";
}
