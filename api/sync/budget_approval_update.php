<?php
include('../../app/init.php');
header('Content-Type: application/json');

// Validate the token provided in the request
if (!isset($_GET['token']) || $_GET['token'] !== BUDGET_APPROVAL_TOKEN) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid or missing token."
    ]);
    exit();
}

// Handle GET request: Retrieve all requisitions with "Approve" status
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Select fields including the necessary details
        $fields = "pr.requisition_id, pr.department, pr.item_description, pr.quantity, 
                   pr.estimated_cost, ba.approved_amount, ba.approved_by, 
                   ba.approval_date, ba.approval_status, ba.remarks";
        $options = "
            LEFT JOIN budget_approval ba ON pr.requisition_id = ba.requisition_id 
            WHERE pr.status = 'Approve'
            ORDER BY pr.requested_date ASC
        ";

        // Fetch all "Approve" requisitions with their related budget approval data
        $approvals = $DB->SELECT('purchaserequisition pr', $fields, $options);

        if (!empty($approvals)) {
            echo json_encode([
                "status" => "success",
                "data" => $approvals
            ]);
        } else {
            echo json_encode([
                "status" => "success",
                "message" => "No requisitions found with status 'Approve'.",
                "data" => []
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            "status" => "error",
            "message" => "An error occurred while fetching data: " . $e->getMessage()
        ]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle POST request: Update a specific budget approval
    $requisition_id = $_POST['requisition_id'] ?? null;
    $approved_amount = $_POST['approved_amount'] ?? null;
    $approved_by = $_POST['approved_by'] ?? 'Finance Department';
    $approval_date = $_POST['approval_date'] ?? date('Y-m-d');
    $approval_status = $_POST['approval_status'] ?? null;
    $remarks = $_POST['remarks'] ?? '';

    if (!$requisition_id || !$approved_amount || !$approval_status) {
        echo json_encode([
            "status" => "error",
            "message" => "Missing required fields: requisition_id, approved_amount, approval_status."
        ]);
        exit();
    }

    // Check if the requisition exists and is in "Approve" status
    $requisition = $DB->SELECT_ONE(
        "purchaserequisition",
        "status",
        "WHERE requisition_id = ?",
        [$requisition_id]
    );

    if (!$requisition || $requisition['status'] !== 'Approve') {
        echo json_encode([
            "status" => "error",
            "message" => "The selected requisition is not eligible for approval actions."
        ]);
        exit();
    }

    // Prepare the data for updating
    $data = [
        "approved_amount" => floatval($approved_amount),
        "approved_by" => $DB->ESCAPE($approved_by),
        "approval_date" => $DB->ESCAPE($approval_date),
        "approval_status" => $DB->ESCAPE($approval_status),
        "remarks" => $DB->ESCAPE($remarks)
    ];

    // Define the condition for updating the specific requisition
    $where = ["requisition_id" => $DB->ESCAPE($requisition_id)];

    // Update the budget approval in the database
    $update_result = $DB->UPDATE("budget_approval", $data, $where);

    // Return the response
    if ($update_result === "success") {
        echo json_encode([
            "status" => "success",
            "message" => "Budget approval updated successfully."
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to update budget approval."
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method. Use GET to fetch or POST to update."
    ]);
}
