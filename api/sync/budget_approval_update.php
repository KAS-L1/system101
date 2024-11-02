<?php
include('../../app/init.php');
header('Content-Type: application/json');

// Validate token
if (!validateToken()) {
    jsonResponse('error', 'Invalid or missing token.');
}

// Determine request method
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        handleGetRequisitions();
        break;
    case 'POST':
        handlePostApprovalUpdate();
        break;
    default:
        jsonResponse('error', 'Invalid request method. Use GET to fetch or POST to update.');
}

function validateToken()
{
    return isset($_GET['token']) && $_GET['token'] === BUDGET_APPROVAL_TOKEN;
}

function jsonResponse($status, $message, $data = [])
{
    echo json_encode(compact('status', 'message', 'data'));
    exit();
}

function handleGetRequisitions()
{
    global $DB;
    try {
        $fields = "pr.requisition_id, pr.department, pr.item_description, pr.quantity, pr.estimated_cost,
                   ba.approved_amount, ba.approved_by, ba.approval_date, ba.approval_status, ba.remarks";
        $options = "
            LEFT JOIN budget_approval ba ON pr.requisition_id = ba.requisition_id 
            WHERE pr.status = 'Approve'
            ORDER BY pr.requested_date ASC";

        $approvals = $DB->SELECT('purchaserequisition pr', $fields, $options);

        if ($approvals) {
            jsonResponse('success', 'Data fetched successfully.', $approvals);
        } else {
            jsonResponse('success', 'No requisitions found with status "Approve".');
        }
    } catch (Exception $e) {
        jsonResponse('error', 'Error fetching data: ' . $e->getMessage());
    }
}

function handlePostApprovalUpdate()
{
    global $DB;
    $data = collectApprovalData();

    if (!$data['requisition_id'] || !$data['approved_amount'] || !$data['approval_status']) {
        jsonResponse('error', 'Missing required fields: requisition_id, approved_amount, approval_status.');
    }

    $requisition = $DB->SELECT_ONE("purchaserequisition", "status", "WHERE requisition_id = ?", [$data['requisition_id']]);
    if (!$requisition || $requisition['status'] !== 'Approve') {
        jsonResponse('error', 'Requisition not eligible for approval actions.');
    }

    $where = ["requisition_id" => $DB->ESCAPE($data['requisition_id'])];
    $updateResult = $DB->UPDATE("budget_approval", $data, $where);

    if ($updateResult === "success") {
        jsonResponse('success', 'Budget approval updated successfully.');
    } else {
        jsonResponse('error', 'Failed to update budget approval.');
    }
}

function collectApprovalData()
{
    global $DB;
    return [
        "requisition_id" => $_POST['requisition_id'] ?? null,
        "approved_amount" => floatval($_POST['approved_amount'] ?? 0),
        "approved_by" => $DB->ESCAPE($_POST['approved_by'] ?? 'Finance Department'),
        "approval_date" => $DB->ESCAPE($_POST['approval_date'] ?? date('Y-m-d')),
        "approval_status" => $DB->ESCAPE($_POST['approval_status'] ?? null),
        "remarks" => $DB->ESCAPE($_POST['remarks'] ?? '')
    ];
}
