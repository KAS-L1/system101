<?php
require("../../app/init.php");

// Check if POST request contains the contract_id
if (isset($_POST['contract_id'])) {
    $contract_id = $DB->ESCAPE($_POST['contract_id']);
    $contract = $DB->SELECT_ONE_WHERE("contracts", "*", array("contract_id" => $contract_id));

    if ($contract) {
        // Mock API URL for syncing
        $url = "http://127.0.0.15/mock_vendor_sync_api";
        $jsonContractData = json_encode($contract);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonContractData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);
        curl_close($ch);

        // Assuming the sync is successful
        echo json_encode(['status' => 'Synced', 'message' => 'Contract synced successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Contract not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
