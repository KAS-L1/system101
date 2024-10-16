<?php
require("../../app/init.php");

$token = "d368051b3cd2819131fff6811cf4e59c"; //  Kupal ka ba boss?

if (!isset($_GET['token']) or $_GET['token'] != $token) {
    die("Invalid token failed to request to server.");
}

$requisitions = $DB->SELECT("purchaserequisition", "*", "ORDER BY requisition_id DESC");

header('Content-Type: application/json; charset=utf-8');

echo json_encode($requisitions);
