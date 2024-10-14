<?php
require("../../app/init.php");

// Check if POST request contains the invoice_id
if (isset($_POST['invoice_id'])) {
    $invoice_id = $DB->ESCAPE($_POST['invoice_id']);
    $invoice = $DB->SELECT_ONE_WHERE("invoice_payments", "*", array("invoice_id" => $invoice_id));

    if ($invoice) {
        // Fetch the vendor details based on vendor_id in the invoice
        $vendor = $DB->SELECT_ONE_WHERE('vendors', '*', array('vendor_id' => $invoice['vendor_id']));

        if ($vendor) {
            // Prepare invoice data to sync with the vendor
            $syncData = [
                'invoice_id' => $invoice['invoice_id'],
                'po_id' => $invoice['po_id'],
                'vendor_name' => $vendor['vendor_name'],
                'amount' => $invoice['amount'],
                'payment_terms' => $invoice['payment_terms'],
                'payment_status' => $invoice['payment_status'],
                'due_date' => $invoice['due_date'],
                'remarks' => $invoice['remarks']
            ];

            // Convert invoice data to JSON format
            $jsonInvoiceData = json_encode($syncData);

            // Mock API URL for syncing
            $url = "http://127.0.0.15/mock_vendor_sync_api"; // Change this to your real API endpoint

            // Initialize cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonInvoiceData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

            // Execute the request
            $response = curl_exec($ch);
            curl_close($ch);

            // Handle the response from the mock API
            if ($response) {
                echo $response; // Return the API response
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to sync invoice']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Vendor not found']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invoice not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
