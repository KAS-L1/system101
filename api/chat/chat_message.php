<?php
require("../../app/init.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender_id = AUTH_USER_ID; // Get the authenticated user ID
    $receiver_id = $_POST['receiver_id']; // Get the receiver ID from the form
    $message = $DB->ESCAPE($_POST['message']); // Escape the message to prevent SQL injection

    // Insert the message into the database
    $result = $DB->INSERT('messages', [
        'sender_id' => $sender_id,
        'receiver_id' => $receiver_id,
        'message' => $message
    ]);

    if ($result === 'success') {
        swalAlert('success', 'Message sent!');
    } else {
        swalAlert('error', 'Failed to send message!');
    }
}
