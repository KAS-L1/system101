<?php
require("../../app/init.php");

$receiver_id = $_GET['receiver_id']; // Get the receiver ID from the request
$sender_id = AUTH_USER_ID; // Get the authenticated user ID

$messages = $DB->SELECT_WHERE('messages', '*', [
    'sender_id' => $sender_id,
    'receiver_id' => $receiver_id
]);

echo json_encode($messages);
