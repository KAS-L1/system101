<?php
require("../../app/init.php");

$token = API_TOKEN; //  Kupal ka ba boss?

if (!isset($_GET['token']) or $_GET['token'] != $token) {
    die(json_encode(["error" => "Unauthorized access."]));
}

$requisitions = $DB->SELECT("purchaserequisition", "*", "ORDER BY requisition_id DESC");

header('Content-Type: application/json; charset=utf-8');

echo json_encode($requisitions);

// For 
// $data = file_get_contents('https://logistic2.paradisehoteltomasmorato.com/api/sync/procurement.php?token=d368051b3cd2819131fff6811cf4e59c');
// $data = json_decode($data, true);
